<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->string('sales_name');
            $table->string('username');
            $table->string('email')->unique();
            $table->char('phone_number', 14);
            $table->string('password');
            $table->foreignId('city_id')->constrained('cities')->nullable();
            $table->foreignId('city_branch_id')->constrained('city_branches')->nullable();
            $table->enum('active', [1, 0]);
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
        Schema::dropIfExists('sales');
    }
}
