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
        Schema::table('user_settings', function (Blueprint $table) {
            
            $table->string('client_encryption_key')->nullable();
            $table->string('client_wallet_seed')->nullable();
            $table->bigInteger('client_wallet_seq')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_settings', function (Blueprint $table) {
            $table->dropColumn('client_encryption_key');
            $table->dropColumn('client_wallet_seed');
            $table->dropColumn('client_wallet_seq');
        });
    }
};
