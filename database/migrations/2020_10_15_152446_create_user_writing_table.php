<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserWritingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_writing', function (Blueprint $table) {
            $table->string('user_ids');
            $table->string('writing_ids');

            $table->foreign('user_ids')->references('id')->on('users');
            $table->foreign('writing_ids')->references('id')->on('writings');
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
        Schema::dropIfExists('user_writing');
    }
}
