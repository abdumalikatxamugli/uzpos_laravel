<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUzposSalesPaymentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('uzpos_sales_payment', function (Blueprint $table) {
            $table->char('id')->primary();
            $table->integer('payment_type');
            $table->decimal('amount', 20);
            $table->integer('currency');
            $table->decimal('currency_kurs', 20);
            $table->decimal('amount_real', 20);
            $table->dateTime('created_at', 6)->nullable();
            $table->dateTime('updated_at', 6);
            $table->date('payment_date');
            $table->bigInteger('created_by_id')->nullable()->index('uzpos_sales_payment_created_by_id_bd2a9ac6_fk_auth_user_id');
            $table->char('order_id')->index('uzpos_sales_payment_order_id_d37b63ec_fk_uzpos_sales_order_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('uzpos_sales_payment');
    }
}
