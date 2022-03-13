<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToAuthUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('auth_user', function (Blueprint $table) {
            $table->foreign(['point_id'], 'auth_user_point_id_id_dafae578_fk_uzpos_core_point_id')->references(['id'])->on('uzpos_core_point');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('auth_user', function (Blueprint $table) {
            $table->dropForeign('auth_user_point_id_id_dafae578_fk_uzpos_core_point_id');
        });
    }
}
