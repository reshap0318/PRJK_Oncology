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
        Schema::create('i_toraks_foto', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inspection_id');
            $table->date('date');
            $table->string('file_path')->nullable();

            $table->tinyInteger('pa_size');
            $table->tinyInteger('pa_lokasi');
            $table->tinyInteger('pa_efusi');
            $table->string('pa_efusi_lainnya')->nullable();
            $table->text('pa_description')->nullable();

            $table->tinyInteger('la_size');
            $table->tinyInteger('la_lokasi');
            $table->tinyInteger('la_efusi');
            $table->string('la_efusi_lainnya')->nullable();
            $table->text('la_description')->nullable();

            $table->timestamps();
            $table->foreign('inspection_id')->references('id')->on('inspection')->cascadeOnUpdate()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('i_toraks_foto');
    }
};
