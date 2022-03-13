<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToUzposSalesClientTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('uzpos_sales_client', function (Blueprint $table) {
            $table->foreign(['created_by_id'], 'uzpos_sales_client_created_by_id_0239d6c6_fk_auth_user_id')->references(['id'])->on('auth_user');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('uzpos_sales_client', function (Blueprint $table) {
            $table->dropForeign('uzpos_sales_client_created_by_id_0239d6c6_fk_auth_user_id');
        });
    }
}
