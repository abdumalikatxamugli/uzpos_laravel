<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUzposCorePointproductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('uzpos_core_pointproduct', function (Blueprint $table) {
            $table->char('id')->primary();
            $table->integer('quantity')->nullable();
            $table->bigInteger('created_by_id')->nullable()->index('uzpos_core_pointproduct_created_by_id_6541e88c_fk_auth_user_id');
            $table->char('point_id')->index('uzpos_core_pointproduct_point_id_cfa2b278_fk_uzpos_core_point_id');
            $table->char('product_id')->index('uzpos_core_pointprod_product_id_8672f3c7_fk_uzpos_cor');
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
        Schema::dropIfExists('uzpos_core_pointproduct');
    }
}
