<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToUzposCoreItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('uzpos_core_item', function (Blueprint $table) {
            $table->foreign(['party_id'], 'uzpos_core_item_party_id_a768c3b7_fk_uzpos_core_party_id')->references(['id'])->on('uzpos_core_party');
            $table->foreign(['product_id'], 'uzpos_core_item_product_id_7fe92977_fk_uzpos_core_product_id')->references(['id'])->on('uzpos_core_product');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('uzpos_core_item', function (Blueprint $table) {
            $table->dropForeign('uzpos_core_item_party_id_a768c3b7_fk_uzpos_core_party_id');
            $table->dropForeign('uzpos_core_item_product_id_7fe92977_fk_uzpos_core_product_id');
        });
    }
}
