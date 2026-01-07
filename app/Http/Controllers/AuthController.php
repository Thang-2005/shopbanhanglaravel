<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Roles;
use Illuminate\Support\Facades\DB; 
use Illuminate\Support\Facades\Session;
use Auth;
class AuthController extends Controller
{
    public function register_auth()
    {
        return view('admin.customer_auth.register');
    }

    //  public function login(Request $request)
    // {
    //     $request->validate([
    //         'admin_email' => 'required|email',
    //         'admin_password' => 'required',
    //     ]);

    //     $admin_email = $request->admin_email;
    //     $admin_password = md5($request->admin_password);

    //     $admin = Admin::where('admin_email', $admin_email)
    //                   ->where('admin_password', $admin_password)
    //                   ->first();

    //     if ($admin) {
    //         // Lưu thông tin admin vào session
    //         session(['admin_id' => $admin->id, 'admin_name' => $admin->admin_name]);
    //        echo session(['admin_id' => $admin->id, 'admin_name' => $admin->admin_name]);
          
    //         // return redirect('/dashboard');
    //     } else {
    //         return redirect('/login-auth')->with('error', 'Email hoặc mật khẩu không đúng');
    //     }
    // }
    public function login(Request $request)
{
    $admin_email = $request->admin_email;
    $admin_password = md5($request->admin_password);
    
    $result = DB::table('tbl_admin')
        ->where('admin_email', $admin_email)
        ->where('admin_password', $admin_password)
        ->first();
    
    if ($result) {
        // Lưu thông tin vào session
        Session::put('admin_id', $result->admin_id);
        Session::put('admin_name', $result->admin_name);
        
        // Lấy thông tin role
        $admin = Admin::with('role')->find($result->admin_id);
        if ($admin && $admin->role) {
            Session::put('admin_role', $admin->role->role_name);
            Session::put('admin_role_desc', $admin->role->role_desc);
        }
        
        return redirect('/dashboard');
    } else {
        Session::put('message', 'Email hoặc mật khẩu không đúng!');
        return redirect('/admin');
    }
}
   public function register(Request $request)
{
    $request->validate([
        'admin_name' => 'required|max:255',
        'admin_email' => 'required|email|unique:tbl_admin,admin_email',
        'admin_phone' => 'required|max:20',
        'admin_password' => 'required|min:6|confirmed',
    ]);

    $admin = new Admin();
    $admin->admin_name = $request->admin_name;
    $admin->admin_email = $request->admin_email;
    $admin->admin_phone = $request->admin_phone;
    $admin->admin_password = md5($request->admin_password);

    $admin->save();

    return redirect('/register-auth')->with('message', 'Đăng ký thành công');
    }
    public function login_auth()
    {
        return view('admin.customer_auth.login_auth');
    }

   
}