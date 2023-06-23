<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TransactionDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction_details', function (Blueprint $table) {
            $table->id();
            // $table->char('invoice_code', 15);
            $table->foreignId('transaction_id')->constrained('transactions')
                ->onDelete('cascade');
            $table->foreignId('product_id')->constrained('products');
            $table->integer('quantity');
            $table->integer('price');
            $table->integer('subtotal');
            $table->unsignedBigInteger('return_id')->nullable();
            $table->timestamps();

            $table->foreign('return_id')->references('id')->on('product_returns')->onDelete('set null');
            // $table->foreign('invoice_code')->references('invoice_code')->on('transactions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaction_details');
    }
}
