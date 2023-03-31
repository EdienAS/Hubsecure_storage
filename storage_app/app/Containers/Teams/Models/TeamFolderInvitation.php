<?php
namespace App\Containers\Teams\Models;

use App\Traits\UuidTrait;
use App\Containers\User\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Database\Factories\TeamFolderInvitationFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @method static create(array $array)
 * @property integer id
 * @property string parent_folder_id
 * @property string email
 * @property string status
 * @property string permission
 * @property string created_at
 * @property string updated_at
 */
class TeamFolderInvitation extends Model
{
    use HasFactory, UuidTrait;

    protected $casts = [
        'id' => 'string',
    ];

    protected $guarded = ['id'];

    public $incrementing = false;

    protected $keyType = 'string';

    public function accept()
    {
        $this->update([
            'status' => 'accepted',
        ]);
    }

    public function reject()
    {
        $this->update([
            'status' => 'rejected',
        ]);
    }

    public function setUuidAttribute()
    {
            $this->attributes['uuid'] = $this->generateUuid();
    }
    
    protected static function newFactory(): TeamFolderInvitationFactory
    {
        return TeamFolderInvitationFactory::new();
    }

    public function inviter(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'inviter_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($invitation) {
            
            $invitation->color = config('filemanager.colors')[rand(0, 4)];
        });
    }
}
