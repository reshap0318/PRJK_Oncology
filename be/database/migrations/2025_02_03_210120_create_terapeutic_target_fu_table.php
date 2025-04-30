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
        Schema::create('i_terapeutic_target_fu', function (Blueprint $table) {
            $table->id();
            $table->foreignId('target_id');
            $table->date('date');
            $table->text('subjective')->nullable();
            $table->text('semi_subjective')->nullable();
            $table->tinyInteger('toxity')->default(0);
            $table->tinyInteger('toxity_detail')->default(0);
            $table->mediumInteger('grade');
            $table->string('ct_scan_path')->nullable();
            $table->text('side_effect')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
            $table->foreign('target_id')->references('id')->on('i_terapeutic_target')->cascadeOnUpdate()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('i_terapeutic_target_fu');
    }
};
