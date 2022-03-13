<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToUzposCoreProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('uzpos_core_product', function (Blueprint $table) {
            $table->foreign(['created_by_id'], 'uzpos_core_product_created_by_id_f3523f07_fk_auth_user_id')->references(['id'])->on('auth_user');
            $table->foreign(['metric_id'], 'uzpos_core_product_metric_id_351d010a_fk_uzpos_core_metric_id')->references(['id'])->on('uzpos_core_metric');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('uzpos_core_product', function (Blueprint $table) {
            $table->dropForeign('uzpos_core_product_created_by_id_f3523f07_fk_auth_user_id');
            $table->dropForeign('uzpos_core_product_metric_id_351d010a_fk_uzpos_core_metric_id');
        });
    }
}
