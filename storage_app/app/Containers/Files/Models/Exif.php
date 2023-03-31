<?php
namespace App\Containers\Files\Models;

use App\Traits\UuidTrait;
use Laravel\Passport\HasApiTokens;
use App\Containers\Files\Models\File;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Exif extends Model
{
    use HasFactory, HasApiTokens, UuidTrait;

    protected $guarded = ['id'];

    protected $keyType = 'string';

    protected $casts = [
        'longitude' => 'array',
        'latitude'  => 'array',
    ];

    public function setUuidAttribute()
    {
            $this->attributes['uuid'] = $this->generateUuid();
    }
    
    /**
     * Get parent
     */
    public function file(){
        return $this->HasOne(File::class, 'id', 'file_id');
    }

    public static function boot()
    {
        parent::boot();
 
    }
}
