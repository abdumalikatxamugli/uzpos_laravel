<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('repayments', function (Blueprint $table) {
            $table->id();
            $table->date('repayment_date');
            $table->decimal('amount',20);
            $table->char('payment_id');
            $table->foreign('payment_id')->references('id')->on('uzpos_sales_payment')->constrained();
            $table->bigInteger('created_by_id');
            $table->foreign('created_by_id')->references('id')->on('auth_user')->constrained();
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
        Schema::dropIfExists('repayments');
    }
};
