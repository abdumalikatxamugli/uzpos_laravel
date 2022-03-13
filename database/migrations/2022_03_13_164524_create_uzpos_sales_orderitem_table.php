<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUzposSalesOrderitemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('uzpos_sales_orderitem', function (Blueprint $table) {
            $table->char('id')->primary();
            $table->decimal('price', 20);
            $table->integer('quantity')->nullable();
            $table->dateTime('updated_at', 6);
            $table->char('order_id')->index('uzpos_sales_orderitem_order_id_837f4bed_fk_uzpos_sales_order_id');
            $table->char('product_id')->index('uzpos_sales_orderite_product_id_4caddf00_fk_uzpos_cor');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('uzpos_sales_orderitem');
    }
}
