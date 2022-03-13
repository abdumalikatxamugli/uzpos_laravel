<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUzposCorePartyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('uzpos_core_party', function (Blueprint $table) {
            $table->char('id')->primary();
            $table->dateTime('check_in', 6)->nullable();
            $table->dateTime('updated_at', 6);
            $table->bigInteger('created_by_id')->nullable()->index('uzpos_core_party_created_by_id_6d08e149_fk_auth_user_id');
            $table->char('point_id')->nullable()->index('uzpos_core_party_point_id_132b3347_fk_uzpos_core_point_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('uzpos_core_party');
    }
}
