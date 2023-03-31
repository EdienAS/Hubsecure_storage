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
        Schema::create('files', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique()->index();
            
            $table->foreignId('user_id')->constrained();
            $table->integer('parent_folder_id')->nullable();
            
            $table->text('name');
            $table->string('basename')->index();

            $table->text('mimetype')->nullable();
            $table->text('filesize');

            $table->text('type')->nullable();

            $table->integer('creator_id')->nullable();

            $table->softDeletes();
            
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
        Schema::dropIfExists('files');
    }
};
