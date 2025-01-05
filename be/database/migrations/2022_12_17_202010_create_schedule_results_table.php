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
        Schema::create('schedule_results', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('schedule_id');
            $table->timestamp('run_at')->useCurrent();
            $table->decimal('duration', 24, 14)->default(0.0);
            $table->longText('result');
            $table->timestamps();

            $table->index('schedule_id', 'schedule_frequencies_schedule_id_idx');
            $table->foreign('schedule_id', 'task_frequencies_task_id_fk')->references('id')->on('schedulers')->onUpdate('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('schedule_results');
    }
};
