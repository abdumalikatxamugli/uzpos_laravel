<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuthUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auth_user', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->string('password', 128);
            $table->dateTime('last_login', 6)->nullable();
            $table->string('username', 150)->unique('username');
            $table->string('first_name', 150);
            $table->string('last_name', 150);
            $table->boolean('is_active');
            $table->dateTime('date_joined', 6)->useCurrent()->useCurrentOnUpdate();;
            $table->integer('user_role');
            $table->dateTime('updated_at', 6)->useCurrent()->useCurrentOnUpdate();;
            $table->char('point_id')->nullable()->index('auth_user_point_id_id_dafae578_fk_uzpos_core_point_id');
            $table->longText('phone')->nullable();
            $table->string('token', 1024)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('auth_user');
    }
}
