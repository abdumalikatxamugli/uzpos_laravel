<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToUzposSalesPaymentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('uzpos_sales_payment', function (Blueprint $table) {
            $table->foreign(['created_by_id'], 'uzpos_sales_payment_created_by_id_bd2a9ac6_fk_auth_user_id')->references(['id'])->on('auth_user');
            $table->foreign(['order_id'], 'uzpos_sales_payment_order_id_d37b63ec_fk_uzpos_sales_order_id')->references(['id'])->on('uzpos_sales_order');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('uzpos_sales_payment', function (Blueprint $table) {
            $table->dropForeign('uzpos_sales_payment_created_by_id_bd2a9ac6_fk_auth_user_id');
            $table->dropForeign('uzpos_sales_payment_order_id_d37b63ec_fk_uzpos_sales_order_id');
        });
    }
}
