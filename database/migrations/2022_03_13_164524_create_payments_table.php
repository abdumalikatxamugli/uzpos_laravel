<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();

            $table->integer('payment_type');

            $table->decimal('amount');
            
            $table->date('payment_date');

            $table->decimal('payed_amount');

            $table->unsignedBigInteger('payed_currency_type');
            $table->foreign('payed_currency_type')->references('id')->on('currency');
            $table->decimal('payed_currency_rate');

            $table->decimal('change_amount');
            
            $table->unsignedBigInteger('change_currency_type');
            $table->foreign('change_currency_type')->references('id')->on('currency');
            $table->decimal('change_currency_rate');
            
            $table->unsignedBigInteger('order_id');
            $table->foreign('order_id')->references('id')->on('orders');
            
            $table->unsignedBigInteger('created_by_id')->nullable();
            $table->foreign('created_by_id')->references('id')->on('users');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
}
