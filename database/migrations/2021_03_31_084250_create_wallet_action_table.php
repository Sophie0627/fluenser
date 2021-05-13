<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWalletActionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wallet_action', function (Blueprint $table) {
            $table->unsignedBigInteger('wallet_id');
            $table->float('amount')->default(0.0);
            $table->string('action')->default('');
            $table->string('currency')->default('usd');
            $table->string('aaa');
            $table->timestamps();

            $table->foreign('wallet_id')->references('id')->on('wallet')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wallet');
    }
}
