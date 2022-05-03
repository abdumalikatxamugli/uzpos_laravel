<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUzposCoreTransferTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('uzpos_core_transfer', function (Blueprint $table) {
            $table->char('id')->primary();
            $table->longText('reason')->nullable();
            $table->dateTime('created_at', 6)->nullable();
            $table->dateTime('transfer_date', 6);
            $table->integer('status')->default(1);
            $table->dateTime('updated_at', 6);
            $table->bigInteger('created_by_id')->nullable()->index('uzpos_core_transfer_created_by_id_4b845bf0_fk_auth_user_id');
            $table->char('from_point_id')->index('uzpos_core_transfer_from_point_id_c7497fee_fk_uzpos_cor');
            $table->char('to_point_id')->index('uzpos_core_transfer_to_point_id_10c43152_fk_uzpos_core_point_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('uzpos_core_transfer');
    }
}
