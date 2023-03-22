<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransfersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transfers', function (Blueprint $table) {
            $table->id();
            $table->longText('reason')->nullable();
            $table->dateTime('transfer_date', 6);
            $table->integer('status')->default(1);
            
            $table->unsignedBigInteger('to_division_id');
            $table->foreign('to_division_id')->references('id')->on('divisions');
            
            $table->unsignedBigInteger('from_division_id');
            $table->foreign('from_division_id')->references('id')->on('divisions');
            
            $table->unsignedBigInteger('created_by_id')->nullable();
            $table->foreign('created_by_id')->references('id')->on('users')->constrained();
            
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
        Schema::dropIfExists('transfers');
    }
}
