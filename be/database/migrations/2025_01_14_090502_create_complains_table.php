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
        Schema::create('i_complain', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inspection_id');
            $table->string('description');
            $table->unsignedMediumInteger('duration');
            $table->unsignedTinyInteger('tag')->default(1)->nullable();
            $table->timestamps();
            $table->foreign('inspection_id')->references('id')->on('inspection')->cascadeOnUpdate()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('i_complain');
    }
};
