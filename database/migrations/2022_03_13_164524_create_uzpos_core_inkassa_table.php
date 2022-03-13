<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUzposCoreInkassaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('uzpos_core_inkassa', function (Blueprint $table) {
            $table->char('id')->primary();
            $table->decimal('amount', 20);
            $table->dateTime('collected_at', 6)->nullable();
            $table->dateTime('updated_at', 6);
            $table->bigInteger('collected_by_id')->nullable()->index('uzpos_core_inkassa_collected_by_id_c64e0191_fk_auth_user_id');
            $table->char('point_id')->index('uzpos_core_inkassa_point_id_dde3b289_fk_uzpos_core_point_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('uzpos_core_inkassa');
    }
}
