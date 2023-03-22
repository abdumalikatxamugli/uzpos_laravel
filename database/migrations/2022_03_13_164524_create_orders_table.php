<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            
            $table->integer('order_type');

            $table->longText('address')->nullable();
            $table->integer('status')->default(1)->nullable();
           
            $table->integer('order_no')->nullable()->unique();
            $table->integer('esf_no')->nullable(1);

            
            $table->unsignedBigInteger('client_id')->nullable();
            $table->foreign('client_id')->references('id')->on('clients');
            
            $table->unsignedBigInteger('collector_id')->nullable();
            $table->foreign('collector_id')->references('id')->on('users');
            
            $table->unsignedBigInteger('deliver_id')->nullable();
            $table->foreign('deliver_id')->references('id')->on('users');
            
            $table->unsignedBigInteger('created_by_id');
            $table->foreign('created_by_id')->references('id')->on('users');
            
            $table->unsignedBigInteger('division_id');
            $table->foreign('division_id')->references('id')->on('divisions');
            
            $table->unsignedBigInteger('supplying_division_id');
            $table->foreign('supplying_division_id')->references('id')->on('divisions');
            
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
        Schema::dropIfExists('orders');
    }
}
