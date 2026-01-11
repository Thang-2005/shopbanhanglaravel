<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\Models\Statistic;
use App\Models\Admin;    
use App\Http\Requests;
use App\Models\Role;

use Illuminate\Support\Facades\Redirect;
session_start();

class AdminController extends Controller
{
    public function AuthLogin(){
    if (!Session::get('admin_id')) {
        return Redirect::to('/admin')->send();
    }
}

    public function index(){
    	return view('admin_login');
    }
//  public function show_dashboard(){
//     $this->AuthLogin();
    
//     // Thống kê tổng quan
//     $product_count = DB::table('tbl_product')->count();
//     $order_count = DB::table('tbl_order')->count();
//     $customer_count = DB::table('tbl_customers')->count();
    
//     // Tổng doanh thu (đơn đã giao)
//     $total_revenue = DB::table('tbl_order')
//         ->join('tbl_order_details', 'tbl_order.order_code', '=', 'tbl_order_details.order_code')
//         ->where('tbl_order.order_status', 2)
//         ->sum(DB::raw('product_price * product_sales_quantity'));

//     // Dữ liệu 7 ngày gần nhất cho biểu đồ khởi tạo
//     $chart_data = DB::table('tbl_statistical')
//         ->whereBetween('order_date', [
//             date('Y-m-d', strtotime('-7 days')),
//             date('Y-m-d')
//         ])
//         ->orderBy('order_date', 'ASC')
//         ->get();

//     return view('admin.dashboard')->with(compact(
//         'product_count',
//         'order_count',
//         'customer_count',
//         'total_revenue',
//         'chart_data'
//     ));
// }
public function show_dashboard()
{
    $this->AuthLogin();

    $product_count  = DB::table('tbl_product')->count();
    $order_count    = DB::table('tbl_order')->count();
    $customer_count = DB::table('tbl_customers')->count();

    $total_revenue = DB::table('tbl_order')
        ->join('tbl_order_details', 'tbl_order.order_code', '=', 'tbl_order_details.order_code')
        ->where('tbl_order.order_status', 3)
        ->sum(DB::raw('product_price * product_sales_quantity'));

    $statistical = DB::table('tbl_statistical')
        ->whereBetween('order_date', [
            date('Y-m-d', strtotime('-7 days')),
            date('Y-m-d')
        ])
        ->orderBy('order_date', 'ASC')
        ->get();

    $chart_data = [];

    foreach ($statistical as $val) {
        $chart_data[] = [
            'period'   => $val->order_date,
            'order'    => (int) $val->total_order,
            'sales'    => (float) $val->sales,
            'profit'   => (float) $val->profit,
            'quantity' => (int) $val->quantity,
        ];
    }

    return view('admin.dashboard', compact(
        'product_count',
        'order_count',
        'customer_count',
        'total_revenue',
        'chart_data'
    ));
}

public function filter_by_date(Request $request)
{
    $from_date = $request->from_date;
    $to_date   = $request->to_date;

    if (!$from_date || !$to_date) {
        return response()->json([]);
    }

    $get = DB::table('tbl_statistical')
        ->whereBetween('order_date', [$from_date, $to_date])
        ->orderBy('order_date', 'ASC')
        ->get();

    $chart_data = [];

    foreach ($get as $val) {
        $chart_data[] = [
            'period'   => $val->order_date,
            'order'    => (int) $val->total_order,
            'sales'    => (float) $val->sales,
            'profit'   => (float) $val->profit,
            'quantity' => (int) $val->quantity,
        ];
    }

    return response()->json($chart_data);
}
    

    public function dashboard(Request $request){
    	$admin_email = $request->admin_email;
    	$admin_password = md5($request->admin_password);

    	$result = DB::table('tbl_admin')->where('admin_email',$admin_email)->where('admin_password',$admin_password)->first();
    	if($result){
            Session::put('admin_name',$result->admin_name);
            Session::put('admin_id',$result->admin_id);
            return Redirect::to('/dashboard');
        }else{
            Session::put('message','Mật khẩu hoặc tài khoản bị sai.Làm ơn nhập lại');
            return Redirect::to('/admin');
        }

    }
    public function logout(){
        $this->AuthLogin();
        Session::put('admin_name',null);
        Session::put('admin_id',null);
        return Redirect::to('/admin');
    }

     // Quản lý danh sách người dùng
    public function manageAdmin()
    {
        $admins = Admin::with('role')->get();
        $admin_id = Session::get('admin_id');
        $admin = Admin::with('role.permissions')->find($admin_id);

        return view('admin.admin.manage_admin', compact('admins', 'admin'));
    }

    public function add_admin() {
        $roles = DB::table('tbl_roles')->get();
    return view('admin.admin.add_admin', compact('roles'));

}
    public function save_admin(Request $request)
{
    $request->validate([
        'admin_name'     => 'required|string|max:255',
        'admin_email'    => 'required|email|max:255|unique:tbl_admin,admin_email',
        'admin_password' => 'required|string|min:6|confirmed', 
        'admin_phone'    => 'nullable|numeric',
        'role_id'        => 'required|exists:tbl_roles,role_id',
    ], [
        'admin_email.unique' => 'Email này đã tồn tại trên hệ thống!',
        'admin_password.confirmed' => 'Mật khẩu xác nhận không trùng khớp!',
    ]);
    $admin = Admin::create([
        'admin_name'     => $request->admin_name,
        'admin_email'    => $request->admin_email,
        'admin_password' => md5($request->admin_password), 
        'admin_phone'    => $request->admin_phone ?? '',
        'role_id'        => $request->role_id,
        'is_super'       => $request->is_super ?? 0, 
    ]);

    if ($admin) {
        return redirect()->route('admin.list')->with('message', 'Thêm mới Admin thành công!');
    }

    return redirect()->back()->with('error', 'Có lỗi xảy ra, vui lòng thử lại!');
}
public function edit_admin($admin_id) {
        $this->AuthLogin();

        $edit_admin = Admin::where('admin_id', $admin_id)->first();
        $roles = DB::table('tbl_roles')->get();
        if(!$edit_admin) {
            return Redirect::to('/admin/manage_admin')->with('error', 'Không tìm thấy quản viên!');
        }

        return view('admin.admin.edit_admin',compact('edit_admin','roles'));
    }

        public function update_admin(Request $request, $admin_id) {
            $this->AuthLogin();

    
           $request->validate([
        'admin_name'     => 'required|string|max:255',
        'admin_email'    => 'required|email|unique:tbl_admin,admin_email,'.$admin_id.',admin_id',
        'admin_phone'    => 'required|numeric',
        'role_id'        => 'required',
        'admin_password' => 'nullable|min:6|confirmed', 
    ], [
        'admin_email.unique'       => 'Email này đã tồn tại, vui lòng chọn email khác!',
        'admin_password.confirmed' => 'Mật khẩu xác nhận không trùng khớp!',
        'admin_password.min'       => 'Mật khẩu mới phải có ít nhất 6 ký tự!',
    ]);

        
            $data = array();
            $data['admin_name']  = $request->admin_name;
            $data['admin_email'] = $request->admin_email;
            $data['admin_phone'] = $request->admin_phone;
            $data['role_id'] = $request->role_id;

            if($request->admin_password) {
                $data['admin_password'] = md5($request->admin_password);
            }

            $result = Admin::where('admin_id', $admin_id)->update($data);

            if($result) {
                return Redirect::to('/admin/manage-admin')->with('message', 'Cập nhật Admin thành công!');
            } else {
                
                return Redirect::back()->with('message', 'Không có thông tin nào thay đổi.');
            }
        }

public function delete_admin($admin_id){
    $admin = Admin::find($admin_id);

    if (!$admin) {
        return redirect()->back()->with('error', 'Admin không tồn tại!');
    }

    // Ngăn xóa admin chính
    if ($admin->is_super) {
        return redirect()->back()->with('error', 'Không thể xóa admin chính!');
    }

    $admin->delete();

    return redirect()->back()->with('message', 'Xóa admin thành công');
}

}
