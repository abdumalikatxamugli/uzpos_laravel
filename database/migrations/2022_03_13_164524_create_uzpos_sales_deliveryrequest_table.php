<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUzposSalesDeliveryrequestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('uzpos_sales_deliveryrequest', function (Blueprint $table) {
            $table->char('id')->primary();
            $table->longText('from_cstm')->nullable();
            $table->decimal('from_long', 20);
            $table->decimal('from_lat', 20);
            $table->longText('to_address')->nullable();
            $table->decimal('to_lat', 20)->nullable();
            $table->decimal('to_long', 20)->nullable();
            $table->string('phone', 12);
            $table->integer('approved_role')->nullable();
            $table->dateTime('deliver_till', 6)->nullable();
            $table->dateTime('created_at', 6)->nullable();
            $table->dateTime('updated_at', 6);
            $table->bigInteger('approved_by_id')->nullable()->index('uzpos_sales_delivery_approved_by_id_f3e344f1_fk_auth_user');
            $table->bigInteger('assigned_id')->nullable()->index('uzpos_sales_deliveryrequest_assigned_id_b687c3a4_fk_auth_user_id');
            $table->bigInteger('created_by_id')->nullable()->index('uzpos_sales_delivery_created_by_id_725314bb_fk_auth_user');
            $table->char('from_point_id')->nullable()->index('uzpos_sales_delivery_from_point_id_66ac5694_fk_uzpos_cor');
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
}
