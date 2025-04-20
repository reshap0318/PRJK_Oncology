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
        Schema::table('i_vital', function (Blueprint $table) {
            $table->text('lainnya')->nullable()->after('ekstemitas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('i_vital', function (Blueprint $table) {
            $table->dropColumn('lainnya');
        });
    }
};
