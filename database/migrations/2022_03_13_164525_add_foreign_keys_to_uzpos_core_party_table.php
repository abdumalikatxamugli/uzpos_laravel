<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToUzposCorePartyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('uzpos_core_party', function (Blueprint $table) {
            $table->foreign(['created_by_id'], 'uzpos_core_party_created_by_id_6d08e149_fk_auth_user_id')->references(['id'])->on('auth_user');
            $table->foreign(['point_id'], 'uzpos_core_party_point_id_132b3347_fk_uzpos_core_point_id')->references(['id'])->on('uzpos_core_point');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('uzpos_core_party', function (Blueprint $table) {
            $table->dropForeign('uzpos_core_party_created_by_id_6d08e149_fk_auth_user_id');
            $table->dropForeign('uzpos_core_party_point_id_132b3347_fk_uzpos_core_point_id');
        });
    }
}
