<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id('invoice_code');
            $table->foreignId('product_id')->references('product_code')->on('products');
            $table->integer('quantity');
            $table->integer('total');
            $table->foreignId('store_id')->constrained('stores');
            $table->enum('payment_method', ['cash', 'tempo']);
            $table->enum('status', ['paid', 'unpaid', 'partial'])->comment('sudah, belum, cicil');
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
        Schema::dropIfExists('transactions');
    }
}

