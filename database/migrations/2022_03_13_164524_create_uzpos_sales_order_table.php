<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUzposSalesOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('uzpos_sales_order', function (Blueprint $table) {
            $table->char('id')->primary();
            $table->dateTime('created_at', 6)->useCurrent();
            $table->dateTime('updated_at', 6)->useCurrent();
            $table->integer('order_type');
            $table->longText('address')->nullable();
            $table->integer('status')->default(1)->nullable();
            $table->char('client_id')->nullable()->index('uzpos_sales_order_client_id_8deb8f05_fk_uzpos_sales_client_id');
            $table->bigInteger('collector_id')->nullable()->index('uzpos_sales_order_collector_id_e874c9c3_fk_auth_user_id');
            $table->bigInteger('created_by_id')->nullable()->index('uzpos_sales_order_created_by_id_0abd7c9d_fk_auth_user_id');
            $table->bigInteger('deliver_id')->nullable()->index('uzpos_sales_order_deliver_id_2c9ab5db_fk_auth_user_id');
            $table->char('shop_id')->index('uzpos_sales_order_shop_id_73e7067c_fk_uzpos_core_point_id');
            $table->integer('order_no')->unique();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('uzpos_sales_order');
    }
}
