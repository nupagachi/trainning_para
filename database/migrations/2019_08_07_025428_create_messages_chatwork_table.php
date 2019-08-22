<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessagesChatworkTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages_chatwork', function (Blueprint $table) {
            $table->increments('id');
            $table->string('message_id');
            $table->string('name');
            $table->text('message');
            $table->string('avatar');
            $table->date('send_time');
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
        Schema::dropIfExists('messages_chatwork');
    }
}
