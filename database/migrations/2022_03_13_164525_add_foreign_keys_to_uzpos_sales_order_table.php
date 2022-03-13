<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToUzposSalesOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('uzpos_sales_order', function (Blueprint $table) {
            $table->foreign(['deliver_id'], 'uzpos_sales_order_deliver_id_2c9ab5db_fk_auth_user_id')->references(['id'])->on('auth_user');
            $table->foreign(['client_id'], 'uzpos_sales_order_client_id_8deb8f05_fk_uzpos_sales_client_id')->references(['id'])->on('uzpos_sales_client');
            $table->foreign(['created_by_id'], 'uzpos_sales_order_created_by_id_0abd7c9d_fk_auth_user_id')->references(['id'])->on('auth_user');
            $table->foreign(['shop_id'], 'uzpos_sales_order_shop_id_73e7067c_fk_uzpos_core_point_id')->references(['id'])->on('uzpos_core_point');
            $table->foreign(['collector_id'], 'uzpos_sales_order_collector_id_e874c9c3_fk_auth_user_id')->references(['id'])->on('auth_user');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('uzpos_sales_order', function (Blueprint $table) {
            $table->dropForeign('uzpos_sales_order_deliver_id_2c9ab5db_fk_auth_user_id');
            $table->dropForeign('uzpos_sales_order_client_id_8deb8f05_fk_uzpos_sales_client_id');
            $table->dropForeign('uzpos_sales_order_created_by_id_0abd7c9d_fk_auth_user_id');
            $table->dropForeign('uzpos_sales_order_shop_id_73e7067c_fk_uzpos_core_point_id');
            $table->dropForeign('uzpos_sales_order_collector_id_e874c9c3_fk_auth_user_id');
        });
    }
}
