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
            $table->id();
            $table->foreignId('inspection_id');
            $table->date('date');
            $table->string('result_path')->nullable();
            $table->float('hb', 3, 2);
            $table->float('leukosit', 3, 2);
            $table->float('ht', 3, 2);
            $table->float('tr', 3, 2);
            $table->char('dc', 13);
            $table->text('liver_function');
            $table->text('procalsitonin');
            $table->float('ginjal_ur', 3, 2);
            $table->float('ginjal_cr', 3, 2);
            $table->float('elektrolit_na', 3, 2);
            $table->float('elektrolit_k', 3, 2);
            $table->float('elektrolit_cl', 3, 2);
            $table->float('agd_ph', 3, 2);
            $table->float('agd_pco2', 3, 2);
            $table->float('agd_po2', 3, 2);
            $table->float('agd_hco3', 3, 2);
            $table->float('agd_be', 3, 2);
            $table->float('agd_so2', 3, 2);
            $table->float('gds', 3, 2);
            $table->text('description')->nullable();
            $table->timestamps();
            $table->foreign('inspection_id')->references('id')->on('inspection')->cascadeOnUpdate()->cascadeOnDelete();
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
