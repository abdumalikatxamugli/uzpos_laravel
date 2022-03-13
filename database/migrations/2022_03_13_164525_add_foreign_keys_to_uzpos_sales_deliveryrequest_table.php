<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToUzposSalesDeliveryrequestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('uzpos_sales_deliveryrequest', function (Blueprint $table) {
            $table->foreign(['order_id'], 'uzpos_sales_delivery_order_id_21b57939_fk_uzpos_sal')->references(['id'])->on('uzpos_sales_order');
            $table->foreign(['approved_by_id'], 'uzpos_sales_delivery_approved_by_id_f3e344f1_fk_auth_user')->references(['id'])->on('auth_user');
            $table->foreign(['from_point_id'], 'uzpos_sales_delivery_from_point_id_66ac5694_fk_uzpos_cor')->references(['id'])->on('uzpos_core_point');
            $table->foreign(['assigned_id'], 'uzpos_sales_deliveryrequest_assigned_id_b687c3a4_fk_auth_user_id')->references(['id'])->on('auth_user');
            $table->foreign(['created_by_id'], 'uzpos_sales_delivery_created_by_id_725314bb_fk_auth_user')->references(['id'])->on('auth_user');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('uzpos_sales_deliveryrequest', function (Blueprint $table) {
            $table->dropForeign('uzpos_sales_delivery_order_id_21b57939_fk_uzpos_sal');
            $table->dropForeign('uzpos_sales_delivery_approved_by_id_f3e344f1_fk_auth_user');
            $table->dropForeign('uzpos_sales_delivery_from_point_id_66ac5694_fk_uzpos_cor');
            $table->dropForeign('uzpos_sales_deliveryrequest_assigned_id_b687c3a4_fk_auth_user_id');
            $table->dropForeign('uzpos_sales_delivery_created_by_id_725314bb_fk_auth_user');
        });
    }
}
