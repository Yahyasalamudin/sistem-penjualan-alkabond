<?php

use Carbon\Carbon;
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
            $table->char('invoice_code', 15);
            $table->integer('grand_total')->nullable();
            $table->integer('remaining_pay')->nullable();
            $table->foreignId('store_id')->constrained('stores');
            $table->foreignId('sales_id')->constrained('sales');
            $table->enum('payment_method', ['cash', 'tempo'])->nullable();
            $table->enum('status', ['paid', 'unpaid', 'partial'])->default('unpaid');
            $table->enum('delivery_status', ['unsent', 'sent', 'proccess'])->default('unsent');
            $table->date('transaction_date')->default(Carbon::now());
            $table->timestamp('sent_at')->nullable();
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
