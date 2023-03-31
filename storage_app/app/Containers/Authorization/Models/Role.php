<?php

namespace App\Containers\Authorization\Models;

use App\Traits\UuidTrait;
use App\Containers\User\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use SoftDeletes, UuidTrait;

    public $table = 'roles';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'uuid',
        'title',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function setUuidAttribute()
    {
            $this->attributes['uuid'] = $this->generateUuid();
    }
    
    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }
}
