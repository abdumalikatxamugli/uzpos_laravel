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
        Schema::table('uzpos_sales_payment', function (Blueprint $table) {
            $table->decimal('payed_amount', 20);
            $table->decimal('change_amount', 20);
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
            $table->dropColumn('payed_amount');
            $table->dropColumn('change_amount');
        });
    }
};
