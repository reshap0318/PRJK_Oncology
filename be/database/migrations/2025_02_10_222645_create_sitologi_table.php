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
        Schema::create('i_sitologi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inspection_id');
            $table->unsignedTinyInteger('category');
            $table->date('date')->nullable();
            $table->unsignedTinyInteger('type')->nullable();
            $table->unsignedTinyInteger('type_detail')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
            $table->unique(['inspection_id', 'category']);
            $table->foreign('inspection_id')->references('id')->on('inspection')->cascadeOnUpdate()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('i_sitologi');
    }
};
