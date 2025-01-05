<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('schedule_frequency', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('schedule_id');
            $table->string('interval')->comment('save interval scheduller laravel');
            $table->string('param_1')->nullable()->comment('parameter 1 for interval');
            $table->string('param_2')->nullable()->comment('parameter 2 for interval');
            $table->timestamps();

            $table->foreign('schedule_id')->references('id')->on('schedulers')->onUpdate('cascade')->onDelete('cascade');
            $table->unique(['schedule_id', 'interval']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('schedule_frequency');
    }
};
