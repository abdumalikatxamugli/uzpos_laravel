<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUzposSalesClientTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('uzpos_sales_client', function (Blueprint $table) {
            $table->char('id')->primary();
            $table->string('fname')->nullable();
            $table->string('lname')->nullable();
            $table->string('mname')->nullable();
            $table->string('pinfl', 14)->nullable();
            $table->string('psery', 2)->nullable();
            $table->string('pnumber', 7)->nullable();
            $table->date('dbirth')->nullable();
            $table->string('phone_number', 9)->nullable();
            $table->dateTime('created_at', 6)->nullable();
            $table->string('inn', 9)->nullable();
            $table->string('company_name')->nullable();
            $table->integer('client_type')->nullable();
            $table->longText('occupation')->nullable();
            $table->dateTime('updated_at', 6);
            $table->bigInteger('created_by_id')->nullable()->index('uzpos_sales_client_created_by_id_0239d6c6_fk_auth_user_id');
            $table->integer('client_no')->unique();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('uzpos_sales_client');
    }
}
