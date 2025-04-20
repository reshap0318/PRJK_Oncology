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

            $table->float('pa_size', 3, 2)->nullable();
            $table->string('pa_lokasi')->nullable();
            $table->string('pa_efusi')->nullable();
            $table->text('pa_description')->nullable();

            $table->float('la_size', 3, 2)->nullable();
            $table->string('la_lokasi')->nullable();
            $table->string('la_efusi')->nullable();
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
