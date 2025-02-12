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
        Schema::create('i_bronkoskopi', function (Blueprint $table) {
            $table->unsignedBigInteger('id');
            $table->string('vocal_cords')->nullable(); //pita suara
            $table->string('trachea')->nullable(); // trakea
            $table->string('carina')->nullable();
            
            $table->string('r_bu')->nullable();
            $table->string('r_carina_second')->nullable();
            $table->string('r_la')->nullable();
            $table->string('r_lb')->nullable();
            $table->string('r_ti')->nullable();
            $table->string('r_lm')->nullable();

            
            $table->string('l_bu')->nullable();
            $table->string('l_carina_second')->nullable();
            $table->string('l_la')->nullable();
            $table->string('l_lb')->nullable();
            $table->string('l_ld')->nullable(); //lower division
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
        Schema::dropIfExists('i_bronkoskopi');
    }
};
