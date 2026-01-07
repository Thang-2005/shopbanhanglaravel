<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        // XÓA DỮ LIỆU CŨ
        DB::table('tbl_role_permission')->delete();
        DB::table('tbl_permissions')->delete();
        DB::table('tbl_roles')->delete();

        // TẠO ROLES
        $roles = [
            [
                'role_name' => 'admin',
                'role_desc' => 'Quản trị viên - Toàn quyền',
                'role_status' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'role_name' => 'manager',
                'role_desc' => 'Quản lý - Quản lý sản phẩm và đơn hàng',
                'role_status' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'role_name' => 'staff',
                'role_desc' => 'Nhân viên - Xem và xử lý đơn hàng',
                'role_status' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];

        DB::table('tbl_roles')->insert($roles);

        // TẠO PERMISSIONS
        $permissions = [
            // Product permissions
            ['permission_name' => 'view_product', 'permission_desc' => 'Xem sản phẩm', 'permission_module' => 'product'],
            ['permission_name' => 'create_product', 'permission_desc' => 'Thêm sản phẩm', 'permission_module' => 'product'],
            ['permission_name' => 'edit_product', 'permission_desc' => 'Sửa sản phẩm', 'permission_module' => 'product'],
            ['permission_name' => 'delete_product', 'permission_desc' => 'Xóa sản phẩm', 'permission_module' => 'product'],
            
            // Category permissions
            ['permission_name' => 'view_category', 'permission_desc' => 'Xem danh mục', 'permission_module' => 'category'],
            ['permission_name' => 'create_category', 'permission_desc' => 'Thêm danh mục', 'permission_module' => 'category'],
            ['permission_name' => 'edit_category', 'permission_desc' => 'Sửa danh mục', 'permission_module' => 'category'],
            ['permission_name' => 'delete_category', 'permission_desc' => 'Xóa danh mục', 'permission_module' => 'category'],
            
            // Order permissions
            ['permission_name' => 'view_order', 'permission_desc' => 'Xem đơn hàng', 'permission_module' => 'order'],
            ['permission_name' => 'create_order', 'permission_desc' => 'Tạo đơn hàng', 'permission_module' => 'order'],
            ['permission_name' => 'edit_order', 'permission_desc' => 'Sửa đơn hàng', 'permission_module' => 'order'],
            ['permission_name' => 'delete_order', 'permission_desc' => 'Xóa đơn hàng', 'permission_module' => 'order'],
            
            // User/Admin permissions
            ['permission_name' => 'view_user', 'permission_desc' => 'Xem người dùng', 'permission_module' => 'user'],
            ['permission_name' => 'create_user', 'permission_desc' => 'Thêm người dùng', 'permission_module' => 'user'],
            ['permission_name' => 'edit_user', 'permission_desc' => 'Sửa người dùng', 'permission_module' => 'user'],
            ['permission_name' => 'delete_user', 'permission_desc' => 'Xóa người dùng', 'permission_module' => 'user'],
            
            // Role permissions
            ['permission_name' => 'view_role', 'permission_desc' => 'Xem vai trò', 'permission_module' => 'role'],
            ['permission_name' => 'manage_role', 'permission_desc' => 'Quản lý vai trò', 'permission_module' => 'role'],
        ];

        foreach ($permissions as $permission) {
            DB::table('tbl_permissions')->insert([
                'permission_name' => $permission['permission_name'],
                'permission_desc' => $permission['permission_desc'],
                'permission_module' => $permission['permission_module'],
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        // GÁN QUYỀN CHO ROLES
        
        // Admin có tất cả quyền
        $adminRoleId = DB::table('tbl_roles')->where('role_name', 'admin')->value('role_id');
        $allPermissions = DB::table('tbl_permissions')->pluck('permission_id');
        
        foreach ($allPermissions as $permissionId) {
            DB::table('tbl_role_permission')->insert([
                'role_id' => $adminRoleId,
                'permission_id' => $permissionId,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        // Manager có quyền quản lý sản phẩm, danh mục, đơn hàng
        $managerRoleId = DB::table('tbl_roles')->where('role_name', 'manager')->value('role_id');
        $managerPermissions = DB::table('tbl_permissions')
            ->whereIn('permission_name', [
                'view_product', 'create_product', 'edit_product', 'delete_product',
                'view_category', 'create_category', 'edit_category', 'delete_category',
                'view_order', 'create_order', 'edit_order',
            ])
            ->pluck('permission_id');
        
        foreach ($managerPermissions as $permissionId) {
            DB::table('tbl_role_permission')->insert([
                'role_id' => $managerRoleId,
                'permission_id' => $permissionId,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        // Staff chỉ xem và xử lý đơn hàng
        $staffRoleId = DB::table('tbl_roles')->where('role_name', 'staff')->value('role_id');
        $staffPermissions = DB::table('tbl_permissions')
            ->whereIn('permission_name', [
                'view_product',
                'view_order', 'edit_order',
            ])
            ->pluck('permission_id');
        
        foreach ($staffPermissions as $permissionId) {
            DB::table('tbl_role_permission')->insert([
                'role_id' => $staffRoleId,
                'permission_id' => $permissionId,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        echo "✅ Đã tạo roles và permissions thành công!\n";
    }
}