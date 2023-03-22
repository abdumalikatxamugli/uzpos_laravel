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
        Schema::create('uzpos_sales_deliveryrequest', function(Blueprint $table){
            $table->id();
            $table->longText('to_address')->nullable();
            $table->dateTime('deliver_till')->nullable();
            
            $table->unsignedBigInteger('assigned_id');
            $table->foreign('assigned_id')->references('id')->on('users');

            $table->integer('status')->default(0);
            
            $table->unsignedBigInteger('created_by_id')->nullable();
            $table->foreign('created_by_id')->references('id')->on('users')->constrained();
            
            $table->unsignedBigInteger('order_id');
            $table->foreign('order_id')->references('id')->on('orders');
            
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
        Schema::dropIfExists('uzpos_sales_deliveryrequest');
    }
};
