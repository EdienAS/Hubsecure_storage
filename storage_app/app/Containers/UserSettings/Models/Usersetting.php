<?php
namespace App\Containers\UserSettings\Models;

use App\Traits\UuidTrait;
use App\Containers\User\Models\User;
use Illuminate\Database\Eloquent\Model;
use Database\Factories\UserSettingsFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property int id
 * @property string user_id
 * @property int upload
 * @property int download
 */
class Usersetting extends Model
{
    use SoftDeletes, HasFactory, UuidTrait;

    public $table = 'user_settings';

    protected $guarded = [];
    
    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'uuid',
        'user_id',
        'file_storage_option_id',
        'storage_limit_mb',
        'avatar',
        'address',
        'state',
        'city',
        'postal_code',
        'country',
        'phone_number',
        'timezone',
        'client_encryption_key',
        'client_wallet_seed',
        'client_wallet_seq',
        'generate_wallet_response',
        'deleted_at',
        'created_at',
        'updated_at',
    ];
    
    protected static function newFactory(): UserSettingsFactory
    {
        return UserSettingsFactory::new();
    }
    
    public function setUuidAttribute()
    {
            $this->attributes['uuid'] = $this->generateUuid();
    }
    
    public function user(){
    
        return $this->hasOne(User::class, 'id', 'user_id');
}
}
