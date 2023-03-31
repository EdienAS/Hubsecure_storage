<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    
    protected $connection = 'mongodb';
    
    public function up()
    {
        if (app()->environment('testing')) {
            return ;
        }
        Schema::create('api_activity_logs', function (Blueprint $table) {
            $table->id();
            
            $table->dateTime('request_start_time');
            $table->string('url');
            $table->string('request_HTTP_method');
            $table->longText('request_body')->nullable();
            $table->longText('request_header');
            $table->string('ip');
            $table->string('status_code')->nullable();
            $table->longText('response_body')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (app()->environment('testing')) {
            return ;
        }
        Schema::dropIfExists('api_activity_logs');
    }
};
