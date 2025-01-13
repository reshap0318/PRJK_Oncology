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
        Schema::create('i_smoking_history', function (Blueprint $table) {
            $table->unsignedBigInteger('id');
            $table->unsignedTinyInteger('history')->nullable()->default(3);
            $table->unsignedInteger('stick_day')->nullable(); //batang / hari
            $table->unsignedMediumInteger('count_year')->nullable();
            $table->unsignedTinyInteger('ib')->nullable()->default(3);
            $table->unsignedTinyInteger('category')->nullable();
            $table->unsignedTinyInteger('suck')->nullable()->default(0); //cara menghisap
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
        Schema::dropIfExists('i_smoking_history');
    }
};
