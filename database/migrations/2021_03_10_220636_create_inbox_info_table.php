<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInboxInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inbox_info', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('inbox_id');
            $table->unsignedBigInteger('send_id');
            $table->unsignedBigInteger('receive_id');
            $table->text('content')->default('');
            $table->string('upload')->default('none');
            $table->timestamps();

            $table->foreign('inbox_id')->references('id')->on('inboxes')->onDelete('cascade');
            $table->foreign('send_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('receive_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inbox_info');
    }
}
