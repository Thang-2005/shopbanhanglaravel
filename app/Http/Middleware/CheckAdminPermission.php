<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Admin;

class CheckAdminPermission
{
    public function handle(Request $request, Closure $next, $permission)
    {
        // Lấy admin_id từ session
        $admin_id = Session::get('admin_id');
        
        if (!$admin_id) {
            Session::put('message', 'Vui lòng đăng nhập!');
            return redirect()->to('/admin');
        }

        // Lấy thông tin admin
        $admin = Admin::with('role.permissions')->find($admin_id);
        
        if (!$admin) {
            Session::put('message', 'Tài khoản không tồn tại!');
            return redirect()->to('/admin');
        }

        // Kiểm tra permission
        if ($admin->hasPermission($permission)) {
            return $next($request);
        }
        if (!$admin_id) {
    // Nếu đang ở route login thì không redirect nữa
    if (!$request->is('admin')) {
        Session::put('message', 'Vui lòng đăng nhập!');
        return redirect()->to('/admin');
    }
}
        Session::put('error', 'Bạn không có quyền thực hiện hành động này!');
        return redirect()->back();
    }
}