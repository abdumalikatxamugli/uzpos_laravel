<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToUzposCoreInkassaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('uzpos_core_inkassa', function (Blueprint $table) {
            $table->foreign(['collected_by_id'], 'uzpos_core_inkassa_collected_by_id_c64e0191_fk_auth_user_id')->references(['id'])->on('auth_user');
            $table->foreign(['point_id'], 'uzpos_core_inkassa_point_id_dde3b289_fk_uzpos_core_point_id')->references(['id'])->on('uzpos_core_point');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('uzpos_core_inkassa', function (Blueprint $table) {
            $table->dropForeign('uzpos_core_inkassa_collected_by_id_c64e0191_fk_auth_user_id');
            $table->dropForeign('uzpos_core_inkassa_point_id_dde3b289_fk_uzpos_core_point_id');
        });
    }
}
