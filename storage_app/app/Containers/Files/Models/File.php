<?php

namespace App\Containers\Files\Models;

use Config;
use App\Traits\UuidTrait;
use Laravel\Scout\Searchable;
use Laravel\Passport\HasApiTokens;
use Kyslik\ColumnSortable\Sortable;
use Database\Factories\FileFactory;
use App\Containers\User\Models\User;
use App\Containers\Files\Models\Exif;
use App\Containers\Share\Models\Share;
use Illuminate\Support\Facades\Storage;
use Illuminate\Notifications\Notifiable;
use App\Containers\Folders\Models\Folder;
use Illuminate\Database\Eloquent\SoftDeletes;
//use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Containers\XRPLBlock\Models\XrplBlockDocument;
use App\Containers\Traffic\Actions\RecordUploadAction;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class File extends Authenticatable
{
    use SoftDeletes, HasApiTokens, HasFactory, Notifiable, UuidTrait, Sortable, Searchable;

    public ?string $sharedAccess = null;
    
    protected $guarded = [
        'id',
    ];
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'uuid',
        'user_id',
        'parent_folder_id',
        'name',
        'mimetype',
        'type',
        'basename',
        'filesize',
        'creator_id',
        
        'created_at',
        'updated_at',
        'deleted_at',
        'file_storage_option_id',
        'file_hash',
        'xrpl_block_document_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'user_id',
        'creator_id',
        'parent_folder_id',
        'deleted_at'
    ];

    protected $dates = [
        'updated_at',
        'created_at',
        'deleted_at',
    ];


    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
    
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($file) {

            // Store upload record
            resolve(RecordUploadAction::class)($file->filesize, $file->user_id);
        });

    }
    
    protected static function newFactory(): FileFactory
    {
        return FileFactory::new();
    }

    /**
     * Set shared routes with public access
     */
    public function setSharedPublicUrl(string $token)
    {
        $this->sharedAccess = $token;
    }

    public function setUuidAttribute()
    {
            $this->attributes['uuid'] = $this->generateUuid();
    }
    
    
    /**
     * Format file URL
     */
    public function getFileUrlAttribute()
    {
        $route = null;
        if(in_array($this->attributes['file_storage_option_id'], [1,2,3])){
            $route = route('getfile', ['basename' => $this->attributes['basename']]);
        }

        return $route;
    }
    
    /**
     * Format file Thumbnail URL
     */
    public function getThumbnailAttribute()
    {
        $thumbnail = null;
        if($this->attributes['type'] == "image"){
            $thumbnail = array('sm' => Storage::url('/files/'.$this->attributes['user_id'].'/sm-'.$this->attributes['basename']),
                'xs' => Storage::url('/files/'.$this->attributes['user_id'].'/xs-'.$this->attributes['basename']));
        }
        return $thumbnail;
    }

    /**
     * Get parent
     */
    public function parent(){
        return $this->belongsTo(Folder::class, 'parent_folder_id', 'id');
    }

    public function getLatestParent()
    {
        if ($this->parent) {
            return $this->parent->getLatestParent();
        }

        return $this;
    }
      
    public function toSearchableArray()
    {
        return [
            'name' => $this->name,
        ];
    }  
    
    public function shared(){
        return $this->hasOne(Share::class, 'item_id', 'id')
                ->where('type','file');
    }

    public function creator()
    {
        return $this->hasOne(User::class, 'id', 'creator_id');
    }
    
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
    
    public function exif() {
        return $this->hasOne(Exif::class, 'file_id', 'id');
    }

    public function xrplBlockDocument(){
        return $this->hasOne(XrplBlockDocument::class, 'id', 'xrpl_block_document_id');
    }
}
