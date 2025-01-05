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
        Schema::create('patient', function (Blueprint $table) {
            $table->id();
            $table->char('no_mr', 10)->unique();
            $table->string('name', 100);
            $table->boolean('gender')->default(1); // 0 => female, 1 => male
            $table->date('dob');
            $table->string('pob', 50);
            $table->string('phone', 15)->nullable();
            $table->string('email', 50)->nullable();
            $table->text('address')->nullable();
            $table->text('education')->nullable();
            $table->string('job', 200)->nullable();
            $table->string('ethnic', 50)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patient');
    }
};
