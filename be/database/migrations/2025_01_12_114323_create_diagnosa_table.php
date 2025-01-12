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
        Schema::create('diagnosa', function (Blueprint $table) {
            $table->unsignedBigInteger('id');
            $table->json('jenis_sel')->nullable();
            $table->json('paru')->nullable();
            $table->json('stage')->nullable();
            $table->json('staging')->nullable();
            $table->json('ps')->nullable();
            $table->string('egfr', 100)->nullable();
            $table->string('mutasi', 100)->nullable();
            $table->boolean('whild_type')->nullable();
            $table->string('pdl1', 100)->nullable();
            $table->json('alk')->nullable();
            $table->text('komorbid')->nullable();
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
        Schema::dropIfExists('diagnosa');
    }
};
