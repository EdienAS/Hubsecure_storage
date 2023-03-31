<?php
namespace App\Containers\XRPLBlock\Models;

use Illuminate\Support\Carbon;
use App\Containers\Files\Models\File;
use Illuminate\Database\Eloquent\Model;

/**
 */
class XrplBlockDocument extends Model
{
    protected $guarded = ['id'];
    
    protected $primaryKey = "id";

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'uuid',
        'name',
        'content_type',
        'gen_name',
        'file_size',
        'file_sha_hash',
        'status',
        'db_id',
        'upload_document_response',
        
    ];
    public function scopeRecordsOlderThan($query, $interval)
    {
        return $query->where('updated_at', '<=', Carbon::now()->subMinutes($interval)->toDateTimeString());
    }
    
    public function file(){
        return $this->hasOne(File::class, 'xrpl_block_document_id', 'id');
    }
    
    protected static function boot()
    {
        parent::boot();

    }
}
