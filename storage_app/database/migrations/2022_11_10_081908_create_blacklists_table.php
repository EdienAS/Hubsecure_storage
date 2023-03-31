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
        Schema::create('blacklists', function (Blueprint $table) {
            $table->id();
            
            $table->foreignId('user_id')->constrained();
            $table->text('tokens');
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
        Schema::dropIfExists('blacklists');
    }
};
