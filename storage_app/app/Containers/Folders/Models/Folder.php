<?php

namespace App\Containers\Folders\Models;

use App\Traits\UuidTrait;
use Laravel\Scout\Searchable;
use Laravel\Passport\HasApiTokens;
use Kyslik\ColumnSortable\Sortable;
use App\Containers\User\Models\User;
use App\Containers\Files\Models\File;
use App\Containers\Share\Models\Share;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Containers\Teams\Models\TeamFolderInvitation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Folder extends Authenticatable
{
    use SoftDeletes, HasApiTokens, HasFactory, Notifiable, UuidTrait, Sortable, Searchable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    
    /**
     *  @method static whereId($id)
     */
    protected $fillable = [
        'uuid',
        'user_id',
        'parent_folder_id',
        'name',
        'color',
        'emoji',
        'team_folder',
        'author_id',
        
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'user_id',
        'creator_id',
        'author_id',
        'deleted_at'
    ];

    protected $dates = [
        'updated_at',
        'created_at',
        'deleted_at',
    ];

    public $sortable = [
        'name',
        'created_at',
    ];


    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
    
    public function setUuidAttribute()
    {
            $this->attributes['uuid'] = $this->generateUuid();
    }
    
    public function setNameAttribute($name): void
    {
        $this->attributes['name'] = mb_convert_encoding($name, 'UTF-8');
    }

    /**
     * Counts how many folder have items
     */
    public function getItemsAttribute(): int
    {
        $folders = $this->folders()
            ->count();

        $files = $this->files()
            ->count();

        return $folders + $files;
    }

    /**
     * Counts how many folder have items
     */
    public function getTrashedItemsAttribute(): int
    {
        $folders = $this->trashedFolders()
            ->count();

        $files = $this->trashedFiles()
            ->count();

        return $folders + $files;
    }

    /**
     * Format parent Folder uuid
     */
    public function getParentFolderUuidAttribute()
    {
        $uuid = null;
        if(!empty($this->parent_folder_id)){
            
            $uuid = $this->parent->uuid;
        }

        return $uuid;
    }
    /**
     * Get parent
     */
    public function parent(){
        return $this->belongsTo(Folder::class, 'parent_folder_id', 'id');
    }
    
    public function parents(){
        return $this->hasMany(Folder::class, 'id', 'parent_folder_id');
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
    
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    
    public function folderIds()
    {
        return $this->children()
            ->with('folderIds')
            ->select(['id', 'parent_folder_id']);
    }

    /**
     * Get all files
     */
    public function files(){
        return $this->hasMany(File::class, 'parent_folder_id', 'id');
    }

    /**
     * Get all trashed files
     */
    public function trashedFiles(){
        return $this->hasMany(File::class, 'parent_folder_id', 'id')
            ->withTrashed();
    }

    /**
     * Get all folders
     */
    public function folders(){
        return $this->children()->with('folders');
    }

    /**
     * Get all trashed folders
     */
    public function trashedFolders(){
        return $this->children()
            ->with('trashedFolders')
            ->withTrashed()
            ->select(['parent_folder_id', 'id', 'name']);
    }

    /**
     * Get children
     */
    public function children(){
        return $this->hasMany(Folder::class, 'parent_folder_id', 'id');
    }

    /**
     * Get trashed children
     */
    public function trashedChildren(){
        return $this->hasMany(Folder::class, 'parent_folder_id', 'id')
            ->withTrashed();
    }
    
    /**
     * Get sharing attributes
     */
    public function shared(){
        return $this->hasOne(Share::class, 'item_id', 'id')
                ->where('type','folder');
    }

    public function teamInvitations(){
        return $this->hasMany(TeamFolderInvitation::class, 'parent_folder_id', 'id')
            ->where('status', 'pending');
    }

    public function teamMembers(){
        return $this->belongsToMany(User::class, 'team_folder_members', 'parent_folder_id', 'user_id')
            ->withPivot('permission');
    }

}
