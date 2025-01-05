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
        Schema::create('satkers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parent_id')->nullable();
            $table->string('name');
            $table->timestamps();
            $table->foreign('parent_id')->references('id')->on('satkers')->cascadeOnUpdate();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('satker_id')->nullable()->after('email');
            $table->foreign('satker_id')->references('id')->on('satkers')->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['satker_id']);
            $table->dropColumn(['satker_id']);
        });

        Schema::dropIfExists('satkers');
    }
};
