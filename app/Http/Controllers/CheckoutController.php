<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str; 
use App\Mail\OrderConfirmation;

use Darryldecode\Cart\Facades\CartFacade as Cart;
use App\Models\City;
use App\Models\Province;
use App\Models\Wards;
use App\Models\Feeship;
use App\Models\OrderDetails;
use App\Models\Shipping;
use App\Models\Order;
use App\Models\Banner;
use App\Models\Product;
use App\Models\Customer;




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
    public function AuthCustomerLogin() {
    $customer_id = Session::get('customer_id');
    if ($customer_id) {
        return; 
    } else {
        return Redirect::to('/login-checkout')->send(); 
    }
}
    public function view_order($orderId){
        $this->AuthCustomerLogin();
        $order_by_id = DB::table('tbl_order')
        ->join('tbl_customers','tbl_order.customer_id','=','tbl_customers.customer_id')
        ->join('tbl_shipping','tbl_order.shipping_id','=','tbl_shipping.shipping_id')
        ->join('tbl_order_details','tbl_order.order_id','=','tbl_order_details.order_id')
        ->select('tbl_order.*','tbl_customers.*','tbl_shipping.*','tbl_order_details.*')->first();

        $manager_order_by_id  = view('admin.view_order')->with('order_by_id',$order_by_id);
        return view('admin_layout')->with('admin.view_order', $manager_order_by_id);
        
    }
    public function login_checkout(Request $request){

    	$cate_product = DB::table('tbl_category_product')->where('category_status','0')->orderby('category_id','desc')->get();
        $brand_product = DB::table('tbl_brand')->where('brand_status','0')->orderby('brand_id','desc')->get(); 
         $banner = Banner::where('banner_status', 1) ->orderBy('banner_id','DESC')->get();

           $meta_desc = 'login';
            $meta_keyword = 'Trang đăng nhập người dùng';
            $meta_title = 'Trang đăng nhập/ đăng ký';
            $url_canonical = $request->url();

    	return view('pages.checkout.login_checkout',compact( 'cate_product', 'brand_product','meta_desc','meta_keyword','meta_title','url_canonical','banner'));
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
    public function edit_customer(Request $request,$customer_id){
         $this->AuthCustomerLogin();
         $edit_customer= Customer::where('customer_id',$customer_id)->first();
            $cate_product = DB::table('tbl_category_product')->where('category_status','0')->orderby('category_id','desc')->get();
            $brand_product = DB::table('tbl_brand')->where('brand_status','0')->orderby('brand_id','desc')->get();
            $banner= Banner::where('banner_status', 1)->orderBy('banner_id','DESC')->get();
            $meta_desc = 'Chỉnh sửa thông tin người dùng';
            $meta_keyword = 'edit customer';
            $meta_title = 'Trang thông tin người dùng';
            $url_canonical = $request->url();
         if(!$edit_customer) {
            return Redirect::to('/')->with('error', 'Không tìm thấy người dùng!');
        }


        return view('frontend.customer.edit_customer',compact('cate_product', 'brand_product','edit_customer','meta_desc','meta_keyword','meta_title','url_canonical','banner'));
    }

public function update_customer(Request $request, $customer_id) {
    $this->AuthCustomerLogin();
    $request->validate([
        'customer_name'     => 'required|string|max:255',
        'customer_email'    => 'required|email|unique:tbl_customers,customer_email,'.$customer_id.',customer_id',
        'customer_phone'    => 'required|numeric',
        'customer_password' => 'nullable|min:6|confirmed', 
    ], [
        'customer_email.unique'       => 'Email này đã tồn tại!',
        'customer_password.confirmed' => 'Mật khẩu xác nhận không trùng khớp!',
        'customer_password.min'       => 'Mật khẩu phải từ 6 ký tự!',
    ]);

    $customer = Customer::find($customer_id);
    if(!$customer) return Redirect::back()->with('error','Người dùng không tồn tại');

    $customer->customer_name = $request->customer_name;
    $customer->customer_email = $request->customer_email;
    $customer->customer_phone = $request->customer_phone;

    if($request->customer_password) {
        $customer->customer_password = md5($request->customer_password);
    }

    $customer->save();

    Session::put('customer_name', $request->customer_name);
    return Redirect::to('/')->with('message', 'Cập nhật thông tin thành công!');
}

    public function checkout(Request $request){
    $this->AuthCustomerLogin();
    	$cate_product = DB::table('tbl_category_product')->where('category_status','0')->orderby('category_id','desc')->get();
        $brand_product = DB::table('tbl_brand')->where('brand_status','0')->orderby('brand_id','desc')->get();
        $city = City::orderBy('matp','ASC')->get();
        $province= Province::orderBy('maqh','ASC')->get();
        $wards= Wards::orderBy('maxa','ASC')->get();
        $cartContent = Cart::getContent();

         $banner = Banner::where('banner_status', 1)
        ->orderBy('banner_id','DESC')
        ->get();

           $meta_desc = 'checkout';
            $meta_keyword = 'Checkout';
            $meta_title = 'Trang thanh toán';
            $url_canonical = $request->url();

    	return view('pages.checkout.show_checkout', compact(
    'cate_product', 'brand_product','cartContent','meta_desc','city','province','wards','meta_keyword','meta_title','url_canonical','banner'));

     }
//    public function save_checkout_customer(Request $request){
//     $data = array();
//     $data['customer_id'] = Session::get('customer_id'); // <--- thêm dòng này
//     $data['shipping_name'] = $request->shipping_name;
//     $data['shipping_phone'] = $request->shipping_phone;
//     $data['shipping_email'] = $request->shipping_email;
//     $data['shipping_notes'] = $request->shipping_notes;
//     $data['shipping_address'] = $request->shipping_address;

//     $shipping_id = DB::table('tbl_shipping')->insertGetId($data);

//     Session::put('shipping_id',$shipping_id);
    
//     return Redirect::to('/payment');
// }
    // public function payment(){

    //     $cate_product = DB::table('tbl_category_product')->where('category_status','0')->orderby('category_id','desc')->get();
    //     $brand_product = DB::table('tbl_brand')->where('brand_status','0')->orderby('brand_id','desc')->get(); 
    //     $cartContent = \Cart::getContent(); // hoặc Cart::getContent() nếu đã dùng alias

    // return view('pages.checkout.payment')
    //         ->with('category', $cate_product)
    //         ->with('brand', $brand_product)
    //         ->with('cartContent', $cartContent);

    // }
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
    	
    	
    	if($result) {
        Session::put('customer_id', $result->customer_id);
        Session::put('customer_name', $result->customer_name);
        return Redirect::to('/trang-chu')->with('message','Đăng nhập thành công');
    
    	}else{
    		return Redirect::to('/login-checkout')->with('message','Đăng nhập thất bại');
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


// -------------------- PURCHASE ORDER --------------------: sửa thông tin đơn hàng của khách đã đăng nhập

public function my_orders(Request $request) {
    // 1. Kiểm tra khách hàng đăng nhập
    $customer_id = Session::get('customer_id');
    if(!$customer_id) {
        return redirect()->route('login.checkout')->with('error', 'Vui lòng đăng nhập để xem đơn hàng');
    }

    // 2. Lấy dữ liệu chung cho Layout (Category, Brand, Banner)
    $cate_product = DB::table('tbl_category_product')->where('category_status', '0')->orderby('category_id','desc')->get();
    $brand_product = DB::table('tbl_brand')->where('brand_status','0')->orderby('brand_id','desc')->get();
    $banner = Banner::where('banner_status', 1)->orderBy('banner_id','DESC')->get();

    // 3. Metadata
    $meta_desc = 'Trang hiển thị đơn hàng đã đặt';
    $meta_keyword = 'my-order';
    $meta_title = 'Đơn hàng của tôi';
    $url_canonical = $request->url();

    // 4. Định nghĩa Trạng thái đơn hàng
    $order_status_map = [
        0 => 'Đang chờ xử lý',
        1 => 'Đã xác nhận',
        2 => 'Đang giao hàng',
        3 => 'Đã giao hàng',
        4 => 'Đã hủy',
    ];

    // 5. Lấy đơn hàng CHỈ của khách hàng này (Sử dụng Join hoặc Relationship)
    // Giả sử bảng tbl_order có cột customer_id
    $my_orders = DB::table('tbl_order')
        ->where('customer_id', $customer_id)
        ->orderby('order_id', 'desc')
        ->get();

    // Nếu bạn muốn lấy chi tiết sản phẩm và ảnh từ OrderDetails
    // Nên sử dụng Eager Loading nếu dùng Model hoặc Join nếu dùng DB Table
    $orderDetails = DB::table('tbl_order_details')
        ->join('tbl_order', 'tbl_order_details.order_code', '=', 'tbl_order.order_code')
        ->join('tbl_product', 'tbl_order_details.product_id', '=', 'tbl_product.product_id')
        ->join('tbl_shipping', 'tbl_order.shipping_id', '=', 'tbl_shipping.shipping_id') // JOIN THÊM BẢNG SHIPPING
        ->where('tbl_order.customer_id', $customer_id)
        ->select(
            'tbl_order_details.*', 
            'tbl_product.product_image', 
            'tbl_order.order_status', 
            'tbl_order.order_id',
            'tbl_shipping.shipping_id',
            'tbl_shipping.shipping_name', 
            'tbl_shipping.shipping_address', 
            'tbl_shipping.shipping_phone',
            'tbl_shipping.shipping_notes'
        )
        ->orderby('tbl_order_details.order_details_id', 'desc')
        ->get();

    foreach ($orderDetails as $key => $ord) {
        $ord->status_text = $order_status_map[$ord->order_status] ?? 'Không xác định';
    }

    return view('pages.myorder.my_orders', compact(
        'customer_id', 'cate_product', 'brand_product', 'banner', 
        'order_status_map', 'orderDetails', 'meta_desc', 
        'meta_keyword', 'meta_title', 'url_canonical'
    ));
}




// Hiển thị form edit
public function edit_shipping( Request $request,$shipping_id)
{
    $shipping = DB::table('tbl_shipping')->where('shipping_id', $shipping_id)->first();
    $cate_product = DB::table('tbl_category_product')->where('category_status','0')->orderby('category_id','desc')->get(); 
    $brand_product = DB::table('tbl_brand')->where('brand_status','0')->orderby('brand_id','desc')->get(); 
    $banner = Banner::where('banner_status', 1)->orderBy('banner_id','DESC')->get();

     $meta_desc = 'Trang chỉnh sửa thông tin gửi hàng';
    $meta_keyword = 'my-order';
    $meta_title = 'Đơn hàng của tôi';
    $url_canonical = $request->url();
    return view('pages.myorder.edit_shipping',compact('shipping','cate_product','brand_product','banner','meta_desc','meta_keyword','meta_title', 'url_canonical'));
           
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

    public function select_delivery_home(Request $request){
    $data = $request->all();
        $output = '';

        if(isset($data['action'])) {

            if($data['action'] == "city") {
                // Lấy huyện theo tỉnh
                $select_huyen = Province::where('matp', $data['matp'])->orderby('maqh','ASC')->get();
                $output .= '<option value="">--Chọn huyện--</option>';
                foreach($select_huyen as $huyen){
                    $output .= '<option value="'.$huyen->maqh.'">'.$huyen->name_huyen.'</option>';
                }

            } elseif($data['action'] == "province") {
                // Lấy xã theo huyện
                // SỬA: kiểm tra tồn tại key 'maqh'
                $maqh = $data['maqh'] ?? null; 
                if($maqh){
                    $select_xa = Wards::where('maqh', $maqh)->orderby('maxa','ASC')->get(); 
                    $output .= '<option value="">--Chọn xã--</option>';
                    foreach($select_xa as $xa){
                        $output .= '<option value="'.$xa->maxa.'">'.$xa->name_xa.'</option>';
                    }
                }
            }

        }

        return $output;
    }

public function calculate_fee(Request $request)
{
    $data = $request->all();

    if (!empty($data['matp']) && !empty($data['maqh']) && !empty($data['maxa'])) {

        $feeship = Feeship::where('fee_matp', $data['matp'])
            ->where('fee_maqh', $data['maqh'])
            ->where('fee_maxa', $data['maxa'])
            ->first();

        if ($feeship) {
            Session::put('fee', $feeship->fee_ship);
            Session::save();
        } else {
            Session::put('fee', 25000);
            Session::save();
        }
    }
}
public function unset_fee()
{
    Session::forget('fee');
    return Redirect::back();

}

public function confirm_order(Request $request)
{
    // 1️⃣ Validate và kiểm tra giỏ hàng
    $request->validate([
        'shipping_name'    => 'required|string|max:255',
        'shipping_phone'   => 'required|string|max:255',
        'shipping_email'   => 'required|email|max:255',
        'shipping_address' => 'required|string|max:255',
    ]);

    $cart_data = Session::get('cart');
    if (!$cart_data) return response()->json(['message' => 'Giỏ hàng trống'], 400);

    foreach ($cart_data as $cart) {
        $product = DB::table('tbl_product')->where('product_id', $cart['product_id'])->first();
        if (!$product || $cart['product_qty'] > $product->product_quantity) {
            $stock = $product ? $product->product_quantity : 0;
            return response()->json([
                'status' => 'error',
                'message' => "Sản phẩm [{$cart['product_name']}] không đủ hàng (Kho còn: {$stock})!"
            ], 400);
        }
    }

    // 2️⃣ Tạo Shipping
    $shipping = Shipping::create([
        'shipping_name'    => $request->shipping_name,
        'shipping_phone'   => $request->shipping_phone,
        'shipping_email'   => $request->shipping_email,
        'shipping_address' => $request->shipping_address,
        'shipping_notes'   => $request->shipping_notes ?? null,
        'shipping_method'  => $request->shipping_method ?? 0,
    ]);

    if (!$shipping || !$shipping->shipping_id) {
        return response()->json([
            'status' => 'error',
            'message' => 'Lỗi khi lưu thông tin giao hàng!'
        ], 500);
    }

    // 3️⃣ Tạo Order
    $customer_id = Session::get('customer_id');
    if (!$customer_id) return response()->json(['status'=>'error','message'=>'Bạn cần đăng nhập để đặt hàng!'], 401);

    $order_code = substr(md5(microtime()), rand(0, 26), 6);
    $order = Order::create([
        'customer_id' => $customer_id,
        'shipping_id' => $shipping->shipping_id,
        'order_status'=> 0,
        'order_code'  => $order_code,
        'created_at'  => now(),
    ]);

    // 4️⃣ Lưu Order Details
    foreach ($cart_data as $cart) {
        OrderDetails::create([
            'order_code' => $order->order_code,
            'product_id' => $cart['product_id'],
            'product_name' => $cart['product_name'],
            'product_price'=> $cart['product_price'],
            'product_sales_quantity' => $cart['product_qty'],
            'product_coupon' => $request->order_coupon ?? null,
            'product_feeship'=> $request->order_fee ?? 0,
        ]);
    }

    // 5️⃣ Lấy dữ liệu để gửi mail
$order_details = OrderDetails::where('order_code', $order->order_code)->get();
$customer = Customer::find($customer_id);

// 1. Tính toán Total, Discount và Feeship TRƯỚC khi tạo PDF và Mail
$total = 0;
$product_feeship = 0;
$product_coupon = 'no';

foreach ($order_details as $details) {
    $total += $details->product_price * $details->product_sales_quantity;
    $product_feeship = $details->product_feeship; // Lấy phí ship từ chi tiết đơn hàng
    $product_coupon = $details->product_coupon;   // Lấy mã coupon từ chi tiết đơn hàng
}

// 2. Tính toán tiền giảm giá dựa trên coupon thực tế (Giống hàm Admin)
$coupon = \App\Models\Coupon::where('coupon_code', $product_coupon)->first();
$discount = 0;
if ($coupon) {
    if ($coupon->coupon_condition == 1) { // Giảm theo %
        $discount = ($total * $coupon->coupon_number) / 100;
    } else { // Giảm theo tiền mặt
        $discount = $coupon->coupon_number;
    }
}
$discount = min($discount, $total); // Đảm bảo không giảm quá tổng tiền

// 3. Hình thức thanh toán
$shipping_method_text = ($shipping->shipping_method == 0) ? 'Chuyển khoản' : 'Tiền mặt';

// 4. Tạo PDF hóa đơn (Sử dụng các biến đã tính ở trên)
$pdf = PDF::loadView('admin.print.print_order', [
    'shipping'         => $shipping,
    'order'            => $order,
    'order_details'    => $order_details,
    'customer'         => $customer,
    'shipping_method'  => $shipping_method_text,
    'total'            => $total,
    'discount'         => $discount,
    'product_feeship'  => $product_feeship
]);

// 5. Gửi Mail xác nhận
Mail::send('emails.order_confirmation', [
    'shipping'         => $shipping,
    'order'            => $order,
    'order_details'    => $order_details,
    'customer'         => $customer,
    'total'            => $total,
    'discount'         => $discount,
    'product_feeship'  => $product_feeship,
    'shipping_method'  => $shipping_method_text
], function($message) use ($shipping, $pdf) {
    $message->to($shipping->shipping_email)->subject('Xác nhận đơn hàng từ Shop');
    // Đính kèm file PDF
    $message->attachData($pdf->output(), "Hoa_don_{$shipping->shipping_name}.pdf");
});
    // 8️⃣ Xóa session giỏ hàng
    Session::forget(['cart','coupon','fee']);

    return response()->json(['status'=>'success','message'=>'Đặt hàng thành công!']);
}



   

}
