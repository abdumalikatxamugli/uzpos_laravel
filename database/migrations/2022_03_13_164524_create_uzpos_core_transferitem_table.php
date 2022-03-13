<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUzposCoreTransferitemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('uzpos_core_transferitem', function (Blueprint $table) {
            $table->char('id')->primary();
            $table->integer('quantity');
            $table->dateTime('updated_at', 6);
            $table->char('product_id')->index('uzpos_core_transferi_product_id_8ed2e78f_fk_uzpos_cor');
            $table->char('transfer_id')->index('uzpos_core_transferi_transfer_id_0764542c_fk_uzpos_cor');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('uzpos_core_transferitem');
    }
}
