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
            $table->dateTime('deliver_till', 6)->nullable();
            $table->dateTime('created_at', 6)->nullable()->useCurrent();
            $table->dateTime('updated_at', 6)->nullable()->useCurrent();
            $table->bigInteger('assigned_id')->nullable()->index('uzpos_sales_deliveryrequest_assigned_id_b687c3a4_fk_auth_user_id');
            $table->bigInteger('created_by_id')->nullable()->index('uzpos_sales_delivery_created_by_id_725314bb_fk_auth_user');
            $table->char('order_id')->index('uzpos_sales_delivery_order_id_21b57939_fk_uzpos_sal');
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
