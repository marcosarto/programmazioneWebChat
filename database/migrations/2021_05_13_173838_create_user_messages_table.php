<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_messages', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('message_id');
            $table->unsignedInteger('sender_id');
            $table->unsignedInteger('reciver_id');
            $table->tinyInteger('type')->default(0)
                ->comment('1:messaggio di gruppo, 0:messaggio personale');
            $table->tinyInteger('seen_status')->default(0)->comment('1:visualizzato');
            $table->tinyInteger('deliver_status')->default(0)
                ->comment("1:ricevuto");
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
        Schema::dropIfExists('user_messages');
    }
}
