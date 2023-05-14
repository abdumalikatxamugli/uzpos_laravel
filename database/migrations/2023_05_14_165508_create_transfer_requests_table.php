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
        Schema::create('transfer_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('from_division_id');
            $table->foreign('from_division_id')->references('id')->on('divisions');
            $table->unsignedBigInteger('to_division_id');
            $table->foreign('to_division_id')->references('id')->on('divisions');
            $table->unsignedBigInteger('created_by_id');
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
        Schema::dropIfExists('transfer_requests');
    }
};
