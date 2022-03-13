<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToUzposCoreTransferTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('uzpos_core_transfer', function (Blueprint $table) {
            $table->foreign(['created_by_id'], 'uzpos_core_transfer_created_by_id_4b845bf0_fk_auth_user_id')->references(['id'])->on('auth_user');
            $table->foreign(['to_point_id'], 'uzpos_core_transfer_to_point_id_10c43152_fk_uzpos_core_point_id')->references(['id'])->on('uzpos_core_point');
            $table->foreign(['from_point_id'], 'uzpos_core_transfer_from_point_id_c7497fee_fk_uzpos_cor')->references(['id'])->on('uzpos_core_point');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('uzpos_core_transfer', function (Blueprint $table) {
            $table->dropForeign('uzpos_core_transfer_created_by_id_4b845bf0_fk_auth_user_id');
            $table->dropForeign('uzpos_core_transfer_to_point_id_10c43152_fk_uzpos_core_point_id');
            $table->dropForeign('uzpos_core_transfer_from_point_id_c7497fee_fk_uzpos_cor');
        });
    }
}
