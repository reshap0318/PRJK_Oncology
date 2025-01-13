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
        Schema::create('i_risk_factor', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inspection_id');
            $table->unsignedTinyInteger('category');
            $table->boolean('own')->default(0)->nullable();
            $table->json('value')->nullable();
            $table->timestamps();
            $table->foreign('inspection_id')->references('id')->on('inspection')->cascadeOnUpdate()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('i_risk_factor');
    }
};
