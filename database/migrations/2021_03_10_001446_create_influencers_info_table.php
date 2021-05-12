<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInfluencersInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('influencers_info', function (Blueprint $table) {
            $table->id();
            $table->integer('influencer_id');
            $table->string('country');
            $table->string('state');
            $table->integer('follows');
            $table->integer('followings');
            $table->integer('posts');
            $table->string('avatar');
            $table->string('back_img');
            $table->float('arg_rate');
            $table->integer('bf_rate');
            $table->integer('tm_rate');
            $table->integer('m_rate');
            $table->integer('reviews');
            $table->float('rating');
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
        Schema::dropIfExists('influencers_info');
    }
}