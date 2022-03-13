<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToUzposCorePointproductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('uzpos_core_pointproduct', function (Blueprint $table) {
            $table->foreign(['product_id'], 'uzpos_core_pointprod_product_id_8672f3c7_fk_uzpos_cor')->references(['id'])->on('uzpos_core_product');
            $table->foreign(['point_id'], 'uzpos_core_pointproduct_point_id_cfa2b278_fk_uzpos_core_point_id')->references(['id'])->on('uzpos_core_point');
            $table->foreign(['created_by_id'], 'uzpos_core_pointproduct_created_by_id_6541e88c_fk_auth_user_id')->references(['id'])->on('auth_user');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('uzpos_core_pointproduct', function (Blueprint $table) {
            $table->dropForeign('uzpos_core_pointprod_product_id_8672f3c7_fk_uzpos_cor');
            $table->dropForeign('uzpos_core_pointproduct_point_id_cfa2b278_fk_uzpos_core_point_id');
            $table->dropForeign('uzpos_core_pointproduct_created_by_id_6541e88c_fk_auth_user_id');
        });
    }
}
