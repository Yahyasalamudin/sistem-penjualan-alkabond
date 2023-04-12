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
            $table->char('invoice_code', 15)->primary();
            $table->integer('grand_total');
            $table->foreignId('store_id')->constrained('stores');
            $table->foreignId('sales_id')->constrained('sales');
            $table->enum('payment_method', ['cash', 'tempo']);
            $table->enum('status', ['paid', 'unpaid', 'partial']);
            $table->string('city_branch')->nullable();
            $table->enum('status_delivery', ['unsent', 'sent', 'proccess'])->default('unsent');
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
