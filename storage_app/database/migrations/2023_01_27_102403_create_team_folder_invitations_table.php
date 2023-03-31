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
        Schema::create('team_folder_invitations', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique()->index();
            
            $table->integer('parent_folder_id');
            $table->integer('inviter_id');
            $table->text('email');
            $table->string('color')->nullable();
            $table->enum('permission', ['can-edit', 'can-view', 'can-view-and-download']);
            $table->enum('status', ['pending', 'accepted', 'waiting-for-registration', 'rejected'])->default('pending');
            
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
            
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
        Schema::dropIfExists('team_folder_invitations');
    }
};
