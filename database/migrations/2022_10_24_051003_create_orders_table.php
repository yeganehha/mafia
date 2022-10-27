<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            $table->uuid('uuid');
            $table->unique(['uuid']);

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->integer('price');
            $table->enum('status', ['unpaid', 'paid', 'canceled'])->default('unpaid');

            $table->string('gateway');
            $table->timestamp('paid_at')->nullable();

            $table->ipAddress();

            $table->timestamps();
        });

        Schema::create('order_items', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('order_id');
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');

            $table->string('item')->nullable();
            $table->integer('value')->nullable();

            $table->integer('amount');
            $table->text('description')->nullable();

            $table->timestamps();
        });

        Schema::create('transaction', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('order_id');
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');

            $table->string('tracking_code1')->nullable();
            $table->string('tracking_code2')->nullable();

            $table->enum('status', ['unpaid', 'paid', 'canceled'])->default('unpaid');

            $table->string('gateway');
            $table->text('result')->nullable();

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
        Schema::dropIfExists('order_items');
        Schema::dropIfExists('transaction');
        Schema::dropIfExists('orders');
    }
};
