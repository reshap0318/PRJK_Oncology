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
        Schema::create('i_radioterapi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inspection_id');
            $table->date('date')->nullable();
            $table->tinyInteger('category')->nullable();
            $table->string('dose')->nullable();
            $table->string('fraksi')->nullable();
            $table->string('ct_scan_path')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();

            $table->foreign('inspection_id')->references('id')->on('inspection')->cascadeOnUpdate()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('i_radioterapi');
    }
};
