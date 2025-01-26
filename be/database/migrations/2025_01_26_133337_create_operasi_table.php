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
        Schema::create('i_operasi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inspection_id');
            $table->date('date');
            $table->string('category'); //jenis-operasi
            $table->json('margin');   
            $table->foreignId('dokter_id');
            $table->text('description')->nullable();
            $table->timestamps();
            $table->foreign('inspection_id')->references('id')->on('inspection')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('dokter_id')->references('id')->on('users')->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('i_operasi');
    }
};
