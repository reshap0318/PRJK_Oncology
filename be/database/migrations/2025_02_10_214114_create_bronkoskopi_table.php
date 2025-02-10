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
            $table->string('vocal_cords'); //pita suara
            $table->string('trachea'); // trakea
            $table->string('carina');
            
            $table->string('r_bu');
            $table->string('r_carina_second');
            $table->string('r_la');
            $table->string('r_lb');
            $table->string('r_ti');
            $table->string('r_lm');

            
            $table->string('l_bu');
            $table->string('l_carina_second');
            $table->string('l_la');
            $table->string('l_lb');
            $table->string('l_ld'); //lower division
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
