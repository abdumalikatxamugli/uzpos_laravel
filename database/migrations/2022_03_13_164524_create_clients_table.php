<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('middle_name')->nullable();

            $table->string('pinfl', 14)->nullable();
            $table->string('passport_sery', 2)->nullable();
            $table->string('passport_number', 7)->nullable();
            $table->date('date_birth')->nullable();

            $table->string('inn', 9)->nullable();
            $table->string('company_name')->nullable();
            
            $table->integer('client_type')->nullable();
            $table->longText('occupation')->nullable();
            $table->string('phone_number', 9)->nullable();
            $table->integer('region_id')->nullable();
            
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
        Schema::dropIfExists('clients');
    }
}
