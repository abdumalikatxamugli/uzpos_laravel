<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUzposCoreMetricTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('uzpos_core_metric', function (Blueprint $table) {
            $table->char('id')->primary();
            $table->string('name');
            $table->dateTime('created_at', 6)->nullable();
            $table->dateTime('updated_at', 6);
            $table->bigInteger('created_by_id')->nullable()->index('uzpos_core_metric_created_by_id_0eba4722_fk_auth_user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('uzpos_core_metric');
    }
}
