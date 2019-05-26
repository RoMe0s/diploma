<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLockedChunksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('locked_chunks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->decimal('amount');
            $table->unsignedBigInteger('balance_id');
            $table->foreign('balance_id')->references('id')->on('balances')->onDelete('cascade');
            $table->unsignedBigInteger('order_id')->unique();
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            $table->unique(['balance_id', 'order_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('locked_chunks');
    }
}
