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
        Schema::create('rfqs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('rfqCode', 12);
            $table->uuid('vendorID');
            $table->date('orderDate');
            $table->uuid('materialID');
            $table->float('qtyOrder')->unsigned();
            $table->float('priceOrder')->unsigned();
            $table->float('totalOrder')->unsigned();
            $table->string('rfqStatus', 32);
            $table->foreign('vendorID')->references('id')->on('vendors');
            $table->foreign('materialID')->references('id')->on('materials');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rfqs');
    }
};
