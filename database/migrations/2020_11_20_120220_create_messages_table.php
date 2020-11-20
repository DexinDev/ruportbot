<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->integer('message_code');
            $table->integer('member_id');
            $table->integer('birthday_member_id')->nullable();
            $table->dateTime('expired_at')->nullable();
            $table->timestamps();
            $table->foreign('member_id')->references('telegram_id')->on('members');
            $table->foreign('birthday_member_id')->references('telegram_id')->on('members');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('messages');
    }
}
