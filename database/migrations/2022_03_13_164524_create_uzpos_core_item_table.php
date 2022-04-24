<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUzposCoreItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('uzpos_core_item', function (Blueprint $table) {
            $table->char('id')->primary();
            $table->integer('quantity')->nullable();
            $table->bigInteger('created_by_id');
            $table->foreign('created_by_id')->references('id')->on('auth_user')->constrained();
            $table->char('party_id')->index('uzpos_core_item_party_id_a768c3b7_fk_uzpos_core_party_id');
            $table->char('product_id')->index('uzpos_core_item_product_id_7fe92977_fk_uzpos_core_product_id');
            $table->dateTime('created_at', 6);
            $table->dateTime('updated_at', 6);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('uzpos_core_item');
    }
}
