<?php
namespace App\Containers\User\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

/**
 */
class Blacklist extends Eloquent
{
    use HasFactory;

    protected $connection = 'mongodb';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'tokens'
    ];
    

}
