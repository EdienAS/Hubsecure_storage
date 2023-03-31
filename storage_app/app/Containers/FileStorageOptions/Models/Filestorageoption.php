<?php
namespace App\Containers\FileStorageOptions\Models;

use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int id
 * @property string user_id
 * @property int upload
 * @property int download
 */
class Filestorageoption extends Model
{
    use UuidTrait;

    public $table = 'file_storage_options';

    protected $guarded = [];
    
    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'uuid',
        'name',
        'created_at',
        'updated_at',
    ];
    
    public function setUuidAttribute()
    {
            $this->attributes['uuid'] = $this->generateUuid();
    }
    
    
}
