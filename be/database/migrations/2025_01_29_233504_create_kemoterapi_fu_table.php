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
        Schema::create('i_kemoterapi_fu', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kemo_id');
            $table->date('date')->nullable();
            $table->tinyInteger('siklus')->default(0);
            $table->text('subjective')->nullable();
            $table->float('semi_ps', 5, 2)->nullable();
            $table->float('semi_bb', 5, 2)->nullable();
            $table->tinyInteger('toxity')->default(0)->nullable();
            $table->tinyInteger('toxity_detail')->default(0)->nullable();
            $table->mediumInteger('grade')->nullable();
            $table->string('rontgen_path')->nullable();
            $table->string('ct_scan_path')->nullable();
            $table->float('hb', 3, 2)->nullable();
            $table->float('leukosit', 3, 2)->nullable();
            $table->float('trombosit', 3, 2)->nullable();
            $table->float('sgot', 3, 2)->nullable();
            $table->float('sgpt', 3, 2)->nullable();
            $table->float('urine', 3, 2)->nullable();
            $table->char('dc', 13)->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
            $table->foreign('kemo_id')->references('id')->on('i_kemoterapi')->cascadeOnUpdate()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('i_kemoterapi_fu');
    }
};
