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
        Schema::create('productions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('productionCode', 12);
            $table->float('qtyProduction')->unsigned();
            $table->date('productionDate');
            $table->uuid('bomID');
            $table->string('productionStatus', 32);
            $table->foreign('bomID')->references('id')->on('boms');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productions');
    }
};
