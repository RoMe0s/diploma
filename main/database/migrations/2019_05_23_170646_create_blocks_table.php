<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBlocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blocks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->text('description')->nullable();
            $table->string('heading', 25);
            $table->unsignedInteger('size_from');
            $table->unsignedInteger('size_to');
            $table->unsignedBigInteger('plan_id');
            $table->unsignedInteger('position');
            $table->foreign('plan_id')->references('id')->on('plans')->onDelete('cascade');
            $table->unique(['plan_id', 'position']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('blocks');
    }
}
