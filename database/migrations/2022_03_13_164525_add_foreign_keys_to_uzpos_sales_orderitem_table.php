<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToUzposSalesOrderitemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('uzpos_sales_orderitem', function (Blueprint $table) {
            $table->foreign(['product_id'], 'uzpos_sales_orderite_product_id_4caddf00_fk_uzpos_cor')->references(['id'])->on('uzpos_core_product');
            $table->foreign(['order_id'], 'uzpos_sales_orderitem_order_id_837f4bed_fk_uzpos_sales_order_id')->references(['id'])->on('uzpos_sales_order');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('uzpos_sales_orderitem', function (Blueprint $table) {
            $table->dropForeign('uzpos_sales_orderite_product_id_4caddf00_fk_uzpos_cor');
            $table->dropForeign('uzpos_sales_orderitem_order_id_837f4bed_fk_uzpos_sales_order_id');
        });
    }
}
