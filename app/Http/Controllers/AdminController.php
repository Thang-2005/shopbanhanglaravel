<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\Models\Statistic;
use App\Models\Admin;    
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
session_start();

class AdminController extends Controller
{
    public function AuthLogin(){
        $admin_id = Session::get('admin_id');
        if($admin_id){
            return Redirect::to('dashboard');
        }else{
            return Redirect::to('admin')->send();
        }
    }
    public function index(){
    	return view('admin_login');
    }
    public function show_dashboard(){
        $this->AuthLogin();
        $product_count = DB::table('tbl_product')->count();
    $order_count = DB::table('tbl_order')->count();
    $customer_count = DB::table('tbl_customers')->count();
    
    // Doanh thu (Chỉ tính đơn đã giao thành công)
    $total_revenue = DB::table('tbl_order')
        ->join('tbl_order_details', 'tbl_order.order_code', '=', 'tbl_order_details.order_code')
        ->where('tbl_order.order_status', 2)
        ->sum(DB::raw('product_price * product_sales_quantity'));

    // Dữ liệu biểu đồ doanh thu 7 ngày gần nhất
    $chart_data = DB::table('tbl_order')
        ->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as total_order'))
        ->groupBy('date')
        ->orderBy('date', 'ASC')
        ->get();

    return view('admin.dashboard')->with(compact('product_count','order_count','customer_count','total_revenue','chart_data'));
    	
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
            'order'    => $val->total_order,
            'sales'    => $val->sales,
            'profit'   => $val->profit,
            'quantity' => $val->quantity,
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
    public function manageUser()
    {
        // Lấy tất cả admin
        $admins = Admin::with('role')->get();

        // Lấy admin đang đăng nhập
        $admin_id = Session::get('admin_id');
        $admin = Admin::with('role.permissions')->find($admin_id);

        return view('admin.admin.manage_user', compact('admins', 'admin'));
    }
}
