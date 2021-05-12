<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestinfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('request_info', function (Blueprint $table) {
            $table->id();
            $table->integer('request_id');
            $table->integer('title');
            $table->text('content');
            $table->integer('amount');
            $table->string('unit');
            $table->integer('status');
            $table->integer('gift');
            $table->boolean('accepted');
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
        Schema::dropIfExists('request_info');
    }
}
