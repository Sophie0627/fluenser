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
            $table->unsignedBigInteger('request_id');
            $table->string('title')->default('');
            $table->text('content')->default('Please complete your profile.');
            $table->string('amount')->default(0);
            $table->string('unit')->default('usd');
            $table->tinyInteger('gift')->default(0);
            $table->string('brand')->default('');
            $table->integer('status')->default(0);
            $table->tinyInteger('accepted')->default(0);
            $table->tinyInteger('sr_review')->default(0);
            $table->tinyInteger('rs_review')->default(0);
            $table->timestamps();

            $table->foreign('request_id')->references('id')->on('requests')->onDelete('cascade');
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
