<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Permission;
use App\Models\Admin;
use Session;
use Redirect;
use DB;

class PermissionController extends Controller
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

    // ========== DANH SÁCH QUYỀN ==========
    public function list_permissions()
    {
        $permissions = Permission::with('roles')
                                 ->orderBy('permission_group')
                                 ->get()
                                 ->groupBy('permission_group');
        
        return view('admin.permission.list_permissions')->with('permissions', $permissions);
    }

    // ========== THÊM QUYỀN ==========
    public function add_permission()
    {
        $groups = Permission::select('permission_group')
                           ->distinct()
                           ->whereNotNull('permission_group')
                           ->pluck('permission_group');
        
        return view('admin.permission.add_permission')->with('groups', $groups);
    }

    public function save_permission(Request $request)
    {
        $request->validate([
            'permission_name' => 'required|unique:tbl_permissions,permission_name|regex:/^[a-z0-9_]+$/',
            'permission_desc' => 'required',
        ], [
            'permission_name.required' => 'Vui lòng nhập tên quyền',
            'permission_name.unique' => 'Tên quyền đã tồn tại',
            'permission_name.regex' => 'Tên quyền chỉ được chứa chữ thường, số và gạch dưới',
            'permission_desc.required' => 'Vui lòng nhập mô tả quyền',
        ]);

        $data = [
            'permission_name' => $request->permission_name,
            'permission_desc' => $request->permission_desc,
            'permission_group' => $request->permission_group,
        ];

        Permission::create($data);
        
        Session::put('message', 'Thêm quyền thành công!');
        return Redirect::to('/admin/permissions');
    }

    // ========== SỬA QUYỀN ==========
    public function edit_permission($permission_id)
    {
        $permission = Permission::with('roles')->findOrFail($permission_id);
        
        $groups = Permission::select('permission_group')
                           ->distinct()
                           ->whereNotNull('permission_group')
                           ->pluck('permission_group');
        
        return view('admin.permission.edit_permission')
            ->with('permission', $permission)
            ->with('groups', $groups);
    }

    public function update_permission(Request $request, $permission_id)
    {
        $permission = Permission::findOrFail($permission_id);
        
        $request->validate([
            'permission_desc' => 'required',
        ], [
            'permission_desc.required' => 'Vui lòng nhập mô tả quyền',
        ]);

        $permission->update([
            'permission_desc' => $request->permission_desc,
            'permission_group' => $request->permission_group,
        ]);

        Session::put('message', 'Cập nhật quyền thành công!');
        return Redirect::to('/admin/permissions');
    }

    // ========== XÓA QUYỀN ==========
    public function delete_permission($permission_id)
    {
        $permission = Permission::with('roles')->findOrFail($permission_id);
        
        // Kiểm tra xem có role nào đang dùng quyền này không
        if ($permission->roles()->count() > 0) {
            Session::put('error', 'Không thể xóa! Còn ' . $permission->roles()->count() . ' vai trò đang có quyền này.');
            return Redirect::to('/admin/permissions');
        }

        $permission->delete();
        
        Session::put('message', 'Xóa quyền thành công!');
        return Redirect::to('/admin/permissions');
    }
}