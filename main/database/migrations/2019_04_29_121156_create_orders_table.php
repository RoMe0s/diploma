<?php

use App\Constants\Status\Order;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->text('description')->nullable();
            $table->morphs('relation');
            $table->decimal('price');
            $table->unsignedInteger('estimate');
            $table->timestamp('done_at')->nullable();
            $table->unsignedBigInteger('text_id')->nullable();
            $table->foreign('text_id')->references('id')->on('texts')->onDelete('set null');
            $table->enum('status', Order::ALL)->default(Order::DRAFT);
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
        Schema::dropIfExists('orders');
    }
}
