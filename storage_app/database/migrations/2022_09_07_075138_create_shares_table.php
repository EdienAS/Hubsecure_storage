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
    public function up()
    {
        Schema::create('shares', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique()->index();
            
            $table->foreignId('user_id')->constrained();
            $table->integer('item_id')->index();
            
            $table->string('token', 16)->unique()->index();
            $table->enum('type', ['file', 'folder']);
            $table->enum('permission', ['visitor', 'editor'])->nullable();
            $table->boolean('is_protected')->default(0);
            $table->string('password')->nullable();
            $table->integer('expire_in')->nullable();
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
        Schema::dropIfExists('shares');
    }
};
