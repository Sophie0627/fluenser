<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBrandInfoTabel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('brand_info', function (Blueprint $table) {
            $table->id();
            $table->integer('brand_id');
            $table->string('country')->default('unknown');
            $table->string('state')->default('unknown');
            $table->integer('posts')->default(0);
            $table->string('avatar')->default('johndoeavatar');
            $table->string('back_img')->default('johndoeback');
            $table->integer('rating');
            $table->integer('reviews');
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
        Schema::dropIfExists('brand_info');
    }
}
