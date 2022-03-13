<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToUzposCoreMetricTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('uzpos_core_metric', function (Blueprint $table) {
            $table->foreign(['created_by_id'], 'uzpos_core_metric_created_by_id_0eba4722_fk_auth_user_id')->references(['id'])->on('auth_user');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('uzpos_core_metric', function (Blueprint $table) {
            $table->dropForeign('uzpos_core_metric_created_by_id_0eba4722_fk_auth_user_id');
        });
    }
}
