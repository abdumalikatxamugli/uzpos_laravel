<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUzposCoreProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('uzpos_core_product', function (Blueprint $table) {
            $table->char('id')->primary();
            $table->string('name');
            $table->string('bar_code')->nullable();
            $table->decimal('bulk_price', 20)->nullable();
            $table->decimal('one_price', 20)->nullable();
            $table->integer('alert_limit')->nullable();
            $table->dateTime('created_at', 6)->nullable();
            $table->dateTime('updated_at', 6);
            $table->bigInteger('created_by_id')->nullable()->index('uzpos_core_product_created_by_id_f3523f07_fk_auth_user_id');
            $table->char('metric_id')->nullable()->index('uzpos_core_product_metric_id_351d010a_fk_uzpos_core_metric_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('uzpos_core_product');
    }
}
