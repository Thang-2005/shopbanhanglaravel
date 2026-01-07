<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Bảng vai trò (Roles)
        Schema::create('tbl_roles', function (Blueprint $table) {
            $table->id('role_id');
            $table->string('role_name', 50)->unique(); // admin, staff, customer
            $table->string('role_desc', 255); // Mô tả vai trò
            $table->tinyInteger('role_status')->default(1); // 1: active, 0: inactive
            $table->timestamps();
        });

        // Bảng quyền hạn (Permissions)
        Schema::create('tbl_permissions', function (Blueprint $table) {
            $table->id('permission_id');
            $table->string('permission_name', 100)->unique(); // view_product, create_product
            $table->string('permission_desc', 255); // Mô tả quyền
            $table->string('permission_module', 50); // product, order, user
            $table->timestamps();
        });

        // Bảng trung gian: Role - Permission
        Schema::create('tbl_role_permission', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('role_id');
            $table->unsignedBigInteger('permission_id');
            $table->timestamps();

            $table->foreign('role_id')->references('role_id')->on('tbl_roles')->onDelete('cascade');
            $table->foreign('permission_id')->references('permission_id')->on('tbl_permissions')->onDelete('cascade');
        });

        // Thêm cột role_id vào bảng tbl_admin
        Schema::table('tbl_admin', function (Blueprint $table) {
            $table->unsignedBigInteger('role_id')->nullable()->after('admin_id');
            $table->foreign('role_id')->references('role_id')->on('tbl_roles')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('tbl_admin', function (Blueprint $table) {
            $table->dropForeign(['role_id']);
            $table->dropColumn('role_id');
        });
        
        Schema::dropIfExists('tbl_role_permission');
        Schema::dropIfExists('tbl_permissions');
        Schema::dropIfExists('tbl_roles');
    }
};