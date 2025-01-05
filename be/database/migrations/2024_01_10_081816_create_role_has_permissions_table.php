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
        Schema::create('role_has_permissions', function (Blueprint $table) {
            $table->bigInteger('role_id')->unsigned();
            $table->bigInteger('permission_id')->unsigned();
            $table->primary(['role_id', 'permission_id']);

            $table->foreign('role_id', 'role_permissions_foreign')->references('id')->on('roles')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('permission_id', 'permission_role_foreign')->references('id')->on('permissions')->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('role_has_permissions');
    }
};
