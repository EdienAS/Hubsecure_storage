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
        Schema::create('xrpl_block_documents', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->index();
            
            
            $table->text('name');
            $table->text('content_type');
            $table->string('gen_name');
            $table->text('file_size');
            $table->text('file_sha_hash');
            $table->string('status');
            $table->string('db_id');
            $table->longText('upload_document_response');
            
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
        Schema::dropIfExists('xrpl_block_documents');
    }
};
