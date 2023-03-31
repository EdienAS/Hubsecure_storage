<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class ApiActivityLogs extends Eloquent
{
    use HasFactory;
    
    protected $connection = 'mongodb';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'request_start_time',
        'url',
        'request_HTTP_method',
        'request_body',
        'request_header',
        'ip',
        'status_code',
        'response_body'
        
    ];
}
