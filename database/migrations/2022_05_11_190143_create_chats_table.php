<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chats', function (Blueprint $table) {
            $table->id();
            $table->integer('chat_type');
            $table->bigInteger('userId')->nullable();
            $table->foreign('userId')->references('id')->on('auth_user');
            $table->char('clientId')->nullable();
            $table->foreign('clientId')->references('id')->on('uzpos_sales_client');
            $table->string("chatId");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('chats');
    }
};
