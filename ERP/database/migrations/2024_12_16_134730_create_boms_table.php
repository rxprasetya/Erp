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
        Schema::create('boms', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('bomCode', 12);
            $table->uuid('productID');
            $table->float('qtyProduct')->unsigned();
            $table->uuid('materialID');
            
            $table->float('qtyMaterial')->unsigned();
            $table->float('cost')->unsigned();
            $table->float('unitPrice')->unsigned();
            $table->foreign('productID')->references('id')->on('products');
            $table->foreign('materialID')->references('id')->on('materials');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('boms');
    }
};
