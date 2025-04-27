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
        Schema::create('i_laboratory_result', function (Blueprint $table) {
            $table->unsignedBigInteger('id');
            $table->date('date')->nullable();
            $table->string('result_path')->nullable();
            $table->float('hb', 3, 2)->nullable();
            $table->float('leukosit', 3, 2)->nullable();
            $table->float('ht', 3, 2)->nullable();
            $table->float('tr', 3, 2)->nullable();
            $table->char('dc', 13)->nullable();
            $table->text('liver_function')->nullable();
            $table->text('procalsitonin')->nullable();
            $table->float('ginjal_ur', 3, 2)->nullable();
            $table->float('ginjal_cr', 3, 2)->nullable();
            $table->float('ginjal_cct', 3, 2)->nullable();
            $table->float('elektrolit_na', 3, 2)->nullable();
            $table->float('elektrolit_k', 3, 2)->nullable();
            $table->float('elektrolit_cl', 3, 2)->nullable(); 
            $table->float('agd_ph', 3, 2)->nullable();
            $table->float('agd_pco2', 3, 2)->nullable();
            $table->float('agd_po2', 3, 2)->nullable();
            $table->float('agd_hco3', 3, 2)->nullable();
            $table->float('agd_be', 3, 2)->nullable();
            $table->float('agd_so2', 3, 2)->nullable();
            $table->float('gds', 3, 2)->nullable();
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
        Schema::dropIfExists('i_laboratory_result');
    }
};
