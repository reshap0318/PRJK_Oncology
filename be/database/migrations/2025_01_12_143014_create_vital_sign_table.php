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
        Schema::create('i_vital', function (Blueprint $table) {
            $table->unsignedBigInteger('id');
            $table->string('awareness', 100)->nullable();
            $table->tinyInteger('condition')->nullable();
            $table->char('td', 8)->nullable();
            $table->unsignedInteger('nadi')->nullable();
            $table->unsignedInteger('rr')->nullable();
            $table->float('suhu', 3, 2)->nullable();
            $table->text('sp_o2')->nullable();
            $table->unsignedInteger('vas')->nullable();
            $table->text('description')->nullable();
            $table->text('kgb')->nullable();
            $table->string('inspeksi_statis', 120)->nullable();
            $table->string('inspeksi_dinamis', 120)->nullable();
            $table->string('auskultasi', 120)->nullable();
            $table->string('palpasi', 120)->nullable();
            $table->string('abdomen', 120)->nullable();
            $table->string('perkusi', 120)->nullable();
            $table->string('ekstemitas', 120)->nullable();
            $table->timestamps();

            $table->primary('id');
            $table->foreign('id')->references('id')->on('inspection')->cascadeOnUpdate()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('i_vital');
    }
};
