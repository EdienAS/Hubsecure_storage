<?php
namespace App\Containers\Share\Models;

use App\Traits\UuidTrait;
use Illuminate\Support\Str;
use Laravel\Passport\HasApiTokens;
use App\Containers\User\Models\User;
use Database\Factories\ShareFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * @method static whereNotNull(string $string)
 * @method static where(string $string, string $token)
 * @property string user_id
 * @property mixed is_protected
 * @property string token
 * @property string item_id
 * @property string type
 * @property string password
 * @property User user
 */
class Share extends Model
{
    use Notifiable, HasFactory, HasApiTokens, UuidTrait;

    protected $guarded = ['id'];

    protected $appends = ['link'];

    public $incrementing = false;

    protected $keyType = 'string';

    protected $primaryKey = 'token';

    protected $casts = [
        'is_protected' => 'boolean',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'id',
        'password',
    ];
    protected static function newFactory(){
        return ShareFactory::new();
    }

    public function setUuidAttribute()
    {
            $this->attributes['uuid'] = $this->generateUuid();
    }
    
//    protected function password(): Attribute
//    {
//        return Attribute::make(
//            set: fn ($value) => bcrypt($value),
//        );
//    }

    public function getLinkAttribute(){
        return url(env('FRONTEND_URL'). config('constants.frontend_endpoints.pages_share') ."{$this->token}");
    }

    public function user(){
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    /**
     * Model events
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($shared) {
            
            $shared->token = Str::random();
        });
    }
}
