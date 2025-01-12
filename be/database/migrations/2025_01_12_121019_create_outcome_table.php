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
        Schema::create('outcome', function (Blueprint $table) {
            $table->unsignedBigInteger('id');
            $table->tinyInteger('keadaan_pulang')->nullable();
            $table->tinyInteger('cara_pulang')->nullable();
            $table->mediumInteger('lama_dirawat')->nullable();
            $table->date('tanggal_meninggal')->nullable();
            $table->text('sebab_kematian')->nullable();
            $table->boolean('waktu_meninggal')->nullable();
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
        Schema::dropIfExists('outcome');
    }
};
