<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('admin_roles', function (Blueprint $table) {
            $table->unsignedInteger('admin_id');
            $table->unsignedInteger('role_id');

            $table->foreign('admin_id')->references('admin_id')->on('tbl_admin')->onDelete('cascade');
            $table->foreign('role_id')->references('role_id')->on('tbl_roles')->onDelete('cascade');

            $table->primary(['admin_id', 'role_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('admin_roles');
    }
};
