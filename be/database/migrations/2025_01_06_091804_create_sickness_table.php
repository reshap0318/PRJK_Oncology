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
        Schema::create('sickness', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pasien_id');
            $table->text('description');
            $table->date('date_inspection');
            $table->boolean('is_family')->default(0)->nullable();
            $table->timestamps();
            $table->foreign('pasien_id')->references('id')->on('patient')->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sickness');
    }
};
