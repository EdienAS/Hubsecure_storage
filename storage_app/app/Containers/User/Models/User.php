<?php

namespace App\Containers\User\Models;

use Hash;
use Storage;
use Carbon\Carbon;
use App\Traits\UuidTrait;
use Illuminate\Support\Str;
use Laravel\Passport\HasApiTokens;
use Database\Factories\UserFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Containers\Authorization\Models\Role;
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Containers\UserSettings\Models\Usersetting;
use App\Containers\User\Models\UserLimitation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Containers\User\Restrictions\RestrictionsManager;

class User extends Authenticatable
{
    use SoftDeletes, HasApiTokens, HasFactory, Notifiable, UuidTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'uuid',
        'name',
        'email',
        'password',
        'role_id',
        'is_active',
        'created_at',
        'updated_at',
        'deleted_at',
        'remember_token',
        'email_verified_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'id',
        'password',
        'remember_token',
    ];

    protected $dates = [
        'updated_at',
        'created_at',
        'deleted_at',
        'email_verified_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    protected static function newFactory(): UserFactory
    {
        return UserFactory::new();
    }
    
    public function setPasswordAttribute($input)
    {
        if ($input) {
            $this->attributes['password'] = app('hash')->needsRehash($input) ? Hash::make($input) : $input;
        }
    }
    
    public function setUuidAttribute()
    {
            $this->attributes['uuid'] = $this->generateUuid();
    }

    public function role()
    {
        return $this->hasOne(Role::class, 'id', 'role_id');
    }
    
    public function userSettings()
    {
        return $this->hasOne(Usersetting::class, 'user_id', 'id');
    }
    
    public function limitations()
    {
        return $this->hasOne(UserLimitation::class, 'user_id', 'id');
    }
    
    /**
     * Format Avatar URL
     */
    public function getAvatarUrlAttribute()
    {
        $avatar = array();
        $avatarName = $this->userSettings->avatar;
        
        if(!empty($avatarName)){
            $avatar = collect(config('filemanager.avatar_sizes'))
                    ->mapWithKeys(function ($size) use ($avatar, $avatarName) {
                    
                    return [$size['name'] => route('getavatar', ['name' => "{$size['name']}-{$avatarName}"])];
                    
                });
        }
        
        return $avatar;
    }
    public function __call($method, $parameters)
    {
        try {
            if (str_starts_with($method, 'can') || str_starts_with($method, 'get')) {
                return resolve(RestrictionsManager::class)
                    ->driver()
                    ->$method($this, ...$parameters);
            }
        } catch (BadMethodCallException $e) {
            return parent::__call($method, $parameters);
        }

        return parent::__call($method, $parameters);
    }
    
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($user) {

        });

    }
}
