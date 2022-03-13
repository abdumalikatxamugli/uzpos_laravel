<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUzposCorePointTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('uzpos_core_point', function (Blueprint $table) {
            $table->char('id')->primary();
            $table->string('name');
            $table->decimal('longitude', 9, 6)->nullable();
            $table->decimal('latitude', 9, 6)->nullable();
            $table->integer('point_type')->nullable();
            $table->decimal('debt', 20)->nullable();
            $table->dateTime('created_at', 6)->nullable();
            $table->dateTime('updated_at', 6);
            $table->bigInteger('created_by_id')->nullable()->index('uzpos_core_point_created_by_id_11b71432_fk_auth_user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('uzpos_core_point');
    }
}
