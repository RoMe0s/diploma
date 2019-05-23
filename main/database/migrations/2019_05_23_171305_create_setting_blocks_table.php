<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSettingBlocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('setting_blocks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('type');
            $table->unsignedInteger('min');
            $table->unsignedInteger('max');
            $table->unsignedBigInteger('block_id');
            $table->foreign('block_id')->references('id')->on('blocks')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('setting_blocks');
    }
}
