<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profile', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->text('introduction')->default('Hi.');
            $table->string('top_img')->default('default_top');
            $table->string('round_img')->default('default_round');
            $table->string('instagram')->default('none');
            $table->string('instagram_follows')->default('0');
            $table->string('youtube')->default('none');
            $table->string('youtube_follows')->default("0");
            $table->string('tiktok')->default('none');
            $table->string('tiktok_follows')->default("0");
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('profile');
    }
}
