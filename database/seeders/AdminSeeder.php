<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Tạo admin mẫu
        $adminId = DB::table('tbl_admin')->insertGetId([
            'admin_name' => 'Admin Test',
            'admin_email' => 'admin@example.com',
            'admin_phone' => '0123456789',
            'admin_password' => md5('12345678'), // mật khẩu MD5
        ]);

        // 2. Lấy role admin từ tbl_roles
        $role = DB::table('tbl_roles')->where('role_name', 'admin')->first();

        // 3. Gán role cho admin
        DB::table('admin_roles')->insert([
            'admin_id' => $adminId,
            'role_id' => $role->role_id,
        ]);

        // --- Thêm Manager và Staff mẫu ---

        $managerId = DB::table('tbl_admin')->insertGetId([
            'admin_name' => 'Manager Test',
            'admin_email' => 'manager@example.com',
            'admin_phone' => '0987654321',
            'admin_password' => md5('12345678'),
        ]);

        $staffId = DB::table('tbl_admin')->insertGetId([
            'admin_name' => 'Staff Test',
            'admin_email' => 'staff@example.com',
            'admin_phone' => '0912345678',
            'admin_password' => md5('12345678'),
        ]);

        // Lấy role manager và staff
        $managerRole = DB::table('tbl_roles')->where('role_name', 'manager')->first();
        $staffRole = DB::table('tbl_roles')->where('role_name', 'staff')->first();

        // Gán role
        DB::table('admin_roles')->insert([
            ['admin_id' => $managerId, 'role_id' => $managerRole->role_id],
            ['admin_id' => $staffId, 'role_id' => $staffRole->role_id],
        ]);
    }
}
