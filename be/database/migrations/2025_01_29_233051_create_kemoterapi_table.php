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
        Schema::create('i_kemoterapi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inspection_id');
            $table->tinyInteger('lini');
            $table->date('date')->nullable();
            $table->json('platinum_detail')->nullable();
            $table->json('combination_detail')->nullable();
            $table->text('dose')->nullable(); //dosis
            $table->timestamps();
            $table->foreign('inspection_id')->references('id')->on('inspection')->cascadeOnUpdate()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('i_kemoterapi');
    }
};
