<?php

// ============================================
// File: app/Http/Controllers/RoleController.php
// ============================================

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\Permission;
use App\Models\Admin;
use Session;
use Redirect;
use DB;

class RoleController extends Controller
{
    // Middleware kiểm tra quyền admin
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $admin_id = Session::get('admin_id');
            if (!$admin_id) {
                Session::put('message', 'Vui lòng đăng nhập!');
                return Redirect::to('/admin')->send();
            }
            
            $admin = Admin::with('role')->find($admin_id);
            if (!$admin || !$admin->hasRole('admin')) {
                Session::put('error', 'Bạn không có quyền truy cập!');
                return Redirect::to('/dashboard')->send();
            }
            
            return $next($request);
        });
    }

    // ========== DANH SÁCH VAI TRÒ ==========
    public function list_roles()
    {
        $roles = Role::withCount('admins', 'permissions')->get();
        return view('admin.role.list_roles')->with('roles', $roles);
    }

    // ========== THÊM VAI TRÒ ==========
    public function add_role()
    {
        return view('admin.role.add_role');
    }

    public function save_role(Request $request)
    {
        $request->validate([
            'role_name' => 'required|unique:tbl_roles,role_name|regex:/^[a-z0-9_]+$/',
            'role_desc' => 'required',
        ], [
            'role_name.required' => 'Vui lòng nhập tên vai trò',
            'role_name.unique' => 'Tên vai trò đã tồn tại',
            'role_name.regex' => 'Tên vai trò chỉ được chứa chữ thường, số và gạch dưới',
            'role_desc.required' => 'Vui lòng nhập mô tả vai trò',
        ]);

        $data = [
            'role_name' => $request->role_name,
            'role_desc' => $request->role_desc,
            'role_status' => 1,
        ];

        Role::create($data);
        
        Session::put('message', 'Thêm vai trò thành công!');
        return Redirect::to('/admin/roles');
    }

    // ========== SỬA VAI TRÒ ==========
    public function edit_role($role_id)
    {
        $role = Role::with('permissions')->findOrFail($role_id);
        $all_permissions = Permission::orderBy('permission_group')
                                     ->get()
                                     ->groupBy('permission_group');
        
        return view('admin.role.edit_role')
            ->with('role', $role)
            ->with('all_permissions', $all_permissions);
    }

    public function update_role(Request $request, $role_id)
    {
        $role = Role::findOrFail($role_id);
        
        $request->validate([
            'role_desc' => 'required',
        ], [
            'role_desc.required' => 'Vui lòng nhập mô tả vai trò',
        ]);

        // Cập nhật thông tin role
        $role->update([
            'role_desc' => $request->role_desc,
            'role_status' => $request->role_status ?? 1,
        ]);

        // Cập nhật quyền (chỉ cho role khác admin)
        if ($role->role_name !== 'admin') {
            if ($request->has('permissions')) {
                $role->permissions()->sync($request->permissions);
            } else {
                $role->permissions()->detach();
            }
        }

        Session::put('message', 'Cập nhật vai trò thành công!');
        return Redirect::to('/admin/roles');
    }

    // ========== XÓA VAI TRÒ ==========
    public function delete_role($role_id)
    {
        $role = Role::findOrFail($role_id);
        
        // Không cho xóa role admin
        if ($role->role_name === 'admin') {
            Session::put('error', 'Không thể xóa vai trò Admin!');
            return Redirect::to('/admin/roles');
        }

        // Kiểm tra có user nào đang dùng role này không
        if ($role->admins()->count() > 0) {
            Session::put('error', 'Không thể xóa! Còn ' . $role->admins()->count() . ' người dùng đang có vai trò này.');
            return Redirect::to('/admin/roles');
        }

        $role->delete();
        Session::put('message', 'Xóa vai trò thành công!');
        return Redirect::to('/admin/roles');
    }

    // ========== KÍCH HOẠT VAI TRÒ ==========
    public function active_role($role_id)
    {
        Role::where('role_id', $role_id)->update(['role_status' => 1]);
        Session::put('message', 'Kích hoạt vai trò thành công!');
        return Redirect::to('/admin/roles');
    }

    // ========== VÔ HIỆU HÓA VAI TRÒ ==========
    public function unactive_role($role_id)
    {
        $role = Role::findOrFail($role_id);
        
        if ($role->role_name === 'admin') {
            Session::put('error', 'Không thể vô hiệu hóa vai trò Admin!');
            return Redirect::to('/admin/roles');
        }

        $role->update(['role_status' => 0]);
        Session::put('message', 'Vô hiệu hóa vai trò thành công!');
        return Redirect::to('/admin/roles');
    }
}