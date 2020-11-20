<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('members', function (Blueprint $table) {
            $table->integer('telegram_id')->unique();
            $table->string('telegram_name')->nullable();
            $table->string('name')->nullable();
            $table->string('username')->nullable();
            $table->boolean('is_confirmed')->default(false);
            $table->date('date_of_birth')->nullable();
            $table->boolean('want_presents')->nullable();
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
        Schema::dropIfExists('members');
    }
}
