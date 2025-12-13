<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Darryldecode\Cart\Facades\CartFacade as Cart;

use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
session_start();

class CheckoutController extends Controller
{
     public function AuthLogin(){
        $admin_id = Session::get('admin_id');
        if($admin_id){
            return Redirect::to('dashboard');
        }else{
            return Redirect::to('admin')->send();
        }
    }
    public function view_order($orderId){
        $this->AuthLogin();
        $order_by_id = DB::table('tbl_order')
        ->join('tbl_customers','tbl_order.customer_id','=','tbl_customers.customer_id')
        ->join('tbl_shipping','tbl_order.shipping_id','=','tbl_shipping.shipping_id')
        ->join('tbl_order_details','tbl_order.order_id','=','tbl_order_details.order_id')
        ->select('tbl_order.*','tbl_customers.*','tbl_shipping.*','tbl_order_details.*')->first();

        $manager_order_by_id  = view('admin.view_order')->with('order_by_id',$order_by_id);
        return view('admin_layout')->with('admin.view_order', $manager_order_by_id);
        
    }
    public function login_checkout(){

    	$cate_product = DB::table('tbl_category_product')->where('category_status','0')->orderby('category_id','desc')->get();
        $brand_product = DB::table('tbl_brand')->where('brand_status','0')->orderby('brand_id','desc')->get(); 

    	return view('pages.checkout.login_checkout')->with('category',$cate_product)->with('brand',$brand_product);
    }
    public function add_customer(Request $request){

    	$data = array();
    	$data['customer_name'] = $request->customer_name;
    	$data['customer_phone'] = $request->customer_phone;
    	$data['customer_email'] = $request->customer_email;
    	$data['customer_password'] = md5($request->customer_password);

    	$customer_id = DB::table('tbl_customers')->insertGetId($data);

    	Session::put('customer_id',$customer_id);
    	Session::put('customer_name',$request->customer_name);
    	return Redirect::to('/checkout');


    }
    public function checkout(){
    	$cate_product = DB::table('tbl_category_product')->where('category_status','0')->orderby('category_id','desc')->get();
        $brand_product = DB::table('tbl_brand')->where('brand_status','0')->orderby('brand_id','desc')->get(); 
        $cartContent = Cart::getContent();


    	return view('pages.checkout.show_checkout')->with('category',$cate_product)->with('brand',$brand_product)
        ->with('cartContent', $cartContent);
    }
   public function save_checkout_customer(Request $request){
    $data = array();
    $data['customer_id'] = Session::get('customer_id'); // <--- thêm dòng này
    $data['shipping_name'] = $request->shipping_name;
    $data['shipping_phone'] = $request->shipping_phone;
    $data['shipping_email'] = $request->shipping_email;
    $data['shipping_notes'] = $request->shipping_notes;
    $data['shipping_address'] = $request->shipping_address;

    $shipping_id = DB::table('tbl_shipping')->insertGetId($data);

    Session::put('shipping_id',$shipping_id);
    
    return Redirect::to('/payment');
}
    public function payment(){

        $cate_product = DB::table('tbl_category_product')->where('category_status','0')->orderby('category_id','desc')->get();
        $brand_product = DB::table('tbl_brand')->where('brand_status','0')->orderby('brand_id','desc')->get(); 
        $cartContent = \Cart::getContent(); // hoặc Cart::getContent() nếu đã dùng alias

    return view('pages.checkout.payment')
            ->with('category', $cate_product)
            ->with('brand', $brand_product)
            ->with('cartContent', $cartContent);

    }
    public function order_place(Request $request){
    // Insert payment
    $data = [];
    $data['payment_method'] = $request->payment_option;
    $data['payment_status'] = 'Đang chờ xử lý'; // nếu DB là VARCHAR, nếu INT thì dùng 0
    $payment_id = DB::table('tbl_payment')->insertGetId($data);

    // Insert order
    $order_data = [];
    $order_data['customer_id'] = Session::get('customer_id');
    $order_data['shipping_id'] = Session::get('shipping_id');
    $order_data['payment_id'] = $payment_id;
    $order_data['order_total'] = Cart::getTotal(); // tổng tiền
    $order_data['order_status'] = 0;

    $order_id = DB::table('tbl_order')->insertGetId($order_data);

    // Insert order_details
    $content = Cart::getContent();
    foreach($content as $item){
        DB::table('tbl_order_details')->insert([
            'order_id' => $order_id,
            'product_id' => $item->id,
            'product_name' => $item->name,
            'product_price' => $item->price,
            'product_sales_quantity' => $item->quantity
        ]);
    }

    // Clear cart
    Cart::clear();

    // Thanh toán
    if($data['payment_method'] == 1){
        echo 'Thanh toán thẻ ATM';
    } elseif($data['payment_method'] == 2){
        $cate_product = DB::table('tbl_category_product')
            ->where('category_status','0')
            ->orderby('category_id','desc')
            ->get();
        $brand_product = DB::table('tbl_brand')
            ->where('brand_status','0')
            ->orderby('brand_id','desc')
            ->get(); 
        return view('pages.checkout.handcash')
            ->with('category', $cate_product)
            ->with('brand', $brand_product);
    } else {
        echo 'Thẻ ghi nợ';
    }
}

        //return Redirect::to('/payment');
    
    public function logout_checkout(){
    	Session::flush();
    	return Redirect::to('/login-checkout');
    }
    public function login_customer(Request $request){
    	$email = $request->email_account;
    	$password = md5($request->password_account);
    	$result = DB::table('tbl_customers')->where('customer_email',$email)->where('customer_password',$password)->first();
    	
    	
    	if($result){
    		Session::put('customer_id',$result->customer_id);
    		return Redirect::to('/trang-chu');
    	}else{
    		return Redirect::to('/login-checkout');
    	}
    }
  
    public function manage_order(){
    $this->AuthLogin();

    $all_order = DB::table('tbl_order')
        ->join('tbl_customers', 'tbl_order.customer_id', '=', 'tbl_customers.customer_id')
        ->join('tbl_order_details', 'tbl_order.order_id', '=', 'tbl_order_details.order_id')
        ->join('tbl_product', 'tbl_order_details.product_id', '=', 'tbl_product.product_id')
        ->select(
            'tbl_order.*',
            'tbl_customers.customer_name',
            'tbl_product.product_name'
        )
        ->orderby('tbl_order.order_id', 'desc')
        ->get();

    $manager_order  = view('admin.manage_order')->with('all_order', $all_order);
    return view('admin_layout')->with('admin.manage_order', $manager_order);
}


   public function update_order_status(Request $request, $order_id)
{
    $status = $request->order_status;

    // Cập nhật vào database
    DB::table('tbl_order')
        ->where('order_id', $order_id)
        ->update(['order_status' => (int)$status]);

    // Redirect về trang quản lý đơn hàng kèm thông báo
    return redirect()->back()->with('message', 'Cập nhật trạng thái đơn hàng thành công');
}

    public function delete_order($orderId){
     $this->AuthLogin();
    
     // Xóa chi tiết đơn hàng trước
     DB::table('tbl_order_details')->where('order_id', $orderId)->delete();
    
     // Xóa đơn hàng
     DB::table('tbl_order')->where('order_id', $orderId)->delete();
    
     return Redirect::to('/manage-order')->with('message', 'Xóa đơn hàng thành công');
    }


// -------------------- PURCHASE ORDER --------------------: sửa thông tin đơn hàng của khách đã đăng nhập

public function my_orders() {
    $customer_id = Session::get('customer_id');

    $category = DB::table('tbl_category_product')->where('category_status', '0')->orderby('category_id','desc')->get();
    $brand = DB::table('tbl_brand')->where('brand_status','0')->orderby('brand_id','desc')->get();

    $order_status_map = [
    0 => 'Đang chờ xử lý',
    1 => 'Đã xác nhận',
    2 => 'Đang giao hàng',
    3 => 'Đã giao hàng',
    4 => 'Đã hủy',
];
    $orders = DB::table('tbl_order_details')
    ->join('tbl_order', 'tbl_order_details.order_id', '=', 'tbl_order.order_id')
    ->join('tbl_product', 'tbl_order_details.product_id', '=', 'tbl_product.product_id')
    ->join('tbl_shipping', 'tbl_order.shipping_id', '=', 'tbl_shipping.shipping_id')
    ->where('tbl_order.customer_id', $customer_id)
    ->select(
        'tbl_order.*',
        'tbl_order_details.*',
        'tbl_product.product_image',
        'tbl_shipping.shipping_name',
        'tbl_shipping.shipping_address',
        'tbl_shipping.shipping_phone',
        'tbl_shipping.shipping_email',
        'tbl_shipping.shipping_notes'
    )
    ->orderBy('tbl_order.order_id', 'desc')
    ->get();
    foreach ($orders as $order) {
    $order->status_text = $order_status_map[$order->order_status] ?? 'Không xác định';
}


    return view('pages.myorder.my_orders')
        ->with('category', $category)
        ->with('brand', $brand)
        ->with('orders', $orders);
}




// Hiển thị form edit
public function edit_shipping($shipping_id)
{
    $shipping = DB::table('tbl_shipping')->where('shipping_id', $shipping_id)->first();

    // Lấy category & brand nếu layout cần
    $cate_product = DB::table('tbl_category_product')->where('category_status','0')->orderby('category_id','desc')->get(); 
    $brand_product = DB::table('tbl_brand')->where('brand_status','0')->orderby('brand_id','desc')->get(); 

    return view('pages.myorder.edit_shipping')
            ->with('shipping', $shipping)
            ->with('category', $cate_product)
            ->with('brand', $brand_product);
}

// Xử lý update
public function update_shipping(Request $request, $shipping_id)
{
    $data = [
        'shipping_name' => $request->shipping_name,
        'shipping_phone' => $request->shipping_phone,
        'shipping_email' => $request->shipping_email,
        'shipping_address' => $request->shipping_address,
        'shipping_notes' => $request->shipping_notes,
    ];

    DB::table('tbl_shipping')->where('shipping_id', $shipping_id)->update($data);

    return Redirect::to('/my-orders')->with('message', 'Cập nhật thông tin giao hàng thành công!');
}

public function cancel_order($order_id)
{
    // Lấy thông tin khách hàng hiện tại
    $customer_id = Session::get('customer_id');

    // Lấy đơn hàng của khách
    $order = DB::table('tbl_order')
        ->where('order_id', $order_id)
        ->where('customer_id', $customer_id)
        ->first();

    if ($order) {
        // Chỉ cho phép hủy nếu trạng thái là 0 hoặc 1
        if ($order->order_status == 0 || $order->order_status == 1) {
            DB::table('tbl_order')
                ->where('order_id', $order_id)
                ->update(['order_status' => 4]); // 4 = Đã hủy

            Session::flash('message', 'Bạn đã hủy đơn hàng thành công.');
        } else {
            Session::flash('message', 'Đơn hàng này không thể hủy vì đang giao hoặc đã hoàn tất.');
        }
    } else {
        Session::flash('message', 'Đơn hàng không tồn tại.');
    }

    return Redirect::to('/my-orders');
}




}
