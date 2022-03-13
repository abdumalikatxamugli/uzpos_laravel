<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToUzposCorePointTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('uzpos_core_point', function (Blueprint $table) {
            $table->foreign(['created_by_id'], 'uzpos_core_point_created_by_id_11b71432_fk_auth_user_id')->references(['id'])->on('auth_user');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('uzpos_core_point', function (Blueprint $table) {
            $table->dropForeign('uzpos_core_point_created_by_id_11b71432_fk_auth_user_id');
        });
    }
}
