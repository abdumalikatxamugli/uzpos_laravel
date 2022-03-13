<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToUzposCoreTransferitemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('uzpos_core_transferitem', function (Blueprint $table) {
            $table->foreign(['product_id'], 'uzpos_core_transferi_product_id_8ed2e78f_fk_uzpos_cor')->references(['id'])->on('uzpos_core_product');
            $table->foreign(['transfer_id'], 'uzpos_core_transferi_transfer_id_0764542c_fk_uzpos_cor')->references(['id'])->on('uzpos_core_transfer');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('uzpos_core_transferitem', function (Blueprint $table) {
            $table->dropForeign('uzpos_core_transferi_product_id_8ed2e78f_fk_uzpos_cor');
            $table->dropForeign('uzpos_core_transferi_transfer_id_0764542c_fk_uzpos_cor');
        });
    }
}
