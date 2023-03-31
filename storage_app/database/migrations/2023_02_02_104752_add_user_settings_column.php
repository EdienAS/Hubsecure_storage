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
            //
            $table->string('avatar')->nullable();
            $table->string('color')->nullable();
            $table->text('first_name')->nullable();
            $table->text('last_name')->nullable();
            $table->text('address')->nullable();
            $table->text('state')->nullable();
            $table->text('city')->nullable();
            $table->text('postal_code')->nullable();
            $table->text('country')->nullable();
            $table->text('phone_number')->nullable();
            $table->decimal('timezone', 10, 1)->nullable();
            $table->text('emoji_type')->nullable();
            $table->text('theme_mode')->nullable();
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
            $table->dropColumn('avatar');
            $table->dropColumn('color');
            $table->dropColumn('first_name');
            $table->dropColumn('last_name');
            $table->dropColumn('address');
            $table->dropColumn('state');
            $table->dropColumn('city');
            $table->dropColumn('postal_code');
            $table->dropColumn('country');
            $table->dropColumn('phone_number');
            $table->dropColumn('timezone');
            $table->dropColumn('emoji_type');
            $table->dropColumn('theme_mode');
        });
    }
};
