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
            $table->id();
            $table->string('invoice_code');
            // $table->foreignId('product_id')->constrained('products');
            // $table->integer('quantity');
            // $table->integer('price');
            $table->integer('total');
            $table->foreignId('store_id')->constrained('stores');
            $table->foreignId('sales_id')->constrained('sales');
            $table->enum('payment_method', ['cash', 'tempo']);
            $table->enum('status', ['paid', 'unpaid', 'partial']);
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