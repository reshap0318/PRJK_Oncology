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
        Schema::create('i_paal_lungs', function (Blueprint $table) {
            $table->unsignedBigInteger('id');
            $table->float('kvp_ml', 5, 2)->nullable();
            $table->float('kvp_percent', 3, 2)->nullable();
            $table->float('vep_ml', 5, 2)->nullable();
            $table->float('vep_percent', 3, 2)->nullable();
            $table->float('vep_kvp', 3, 2)->nullable();
            $table->text('description')->nullable();
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
        Schema::dropIfExists('i_paal_lungs');
    }
};
