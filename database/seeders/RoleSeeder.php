<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('tbl_roles')->insert([
            ['role_name'=>'admin','description'=>'Toàn quyền'],
            ['role_name'=>'manager','description'=>'Quản lý'],
            ['role_name'=>'staff','description'=>'Nhân viên'],
        ]);
    }
}
