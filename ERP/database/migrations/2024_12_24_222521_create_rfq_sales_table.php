<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('rfq_sales', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('rfqSaleCode', 12);
            $table->uuid('customerID');
            $table->date('saleDate');
            $table->uuid('productID');
            $table->float('qtySold')->unsigned();
            $table->float('priceSale')->unsigned();
            $table->float('totalSold')->unsigned();
            $table->string('rfqSaleStatus', 32);
            $table->foreign('customerID')->references('id')->on('customers');
            $table->foreign('productID')->references('id')->on('products');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rfq_sales');
    }
};
