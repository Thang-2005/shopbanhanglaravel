<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Session;
use DB;
use Barryvdh\DomPDF\Facade\PDF;
use Illuminate\Http\Request;
use App\Models\Feeship;
use App\Models\OrderDetails;
use App\Models\Shipping;
use App\Models\Order;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Coupon;




class OrderController extends Controller
{
    public function placeOrder(Request $request)
    {
        // Validate dữ liệu
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string',
            'address' => 'required|string',
            // ... các field khác
        ]);

        // Tạo đơn hàng
        $order = Order::create([
            'customer_name' => $validated['name'],
            'customer_email' => $validated['email'],
            'customer_phone' => $validated['phone'],
            'customer_address' => $validated['address'],
            'total' => $request->total,
            'status' => 'pending',
        ]);

        // Thêm items vào đơn hàng
        foreach ($request->items as $item) {
            $order->items()->create([
                'product_name' => $item['name'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ]);
        }

        // Thông tin khách hàng
        $customer = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'address' => $validated['address'],
        ];

        // Đường dẫn file hóa đơn PDF (nếu có)
        $invoicePath = storage_path('app/invoices/invoice-' . $order->id . '.pdf');

        // Gửi email
        try {
            Mail::to($validated['email'])->send(
                new OrderConfirmation($order, $customer, $invoicePath)
            );

            return response()->json([
                'success' => true,
                'message' => 'Đặt hàng thành công! Email xác nhận đã được gửi.',
                'order_id' => $order->id
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Đặt hàng thành công nhưng không thể gửi email: ' . $e->getMessage()
            ], 500);
        }
    }
    public function manage_order()
    {
        $order= Order::orderby('created_at','DESC')->get();
        return view('admin.manage_order',compact('order'));
        
    }
    public function view_order($order_code)
    {
        
        $order_details = OrderDetails::with('product')->where('order_code', $order_code)->get();
        $order= Order::Where('order_code', $order_code)->get();
        foreach($order as $key =>$ord){
            $customer_id = $ord->customer_id;
            $shipping_id = $ord->shipping_id;
        }

        foreach($order_details as $key => $order_d){
            $product_coupon = $order_d->product_coupon;
            $product_feeship = $order_d->product_feeship;
            
        }
            $coupon = Coupon::where('coupon_code', $product_coupon)->first();
            $coupon_condition	= $coupon->coupon_condition ?? 0 ;
            $coupon_number	= $coupon->coupon_number ?? 0 ;
        $customer = Customer::where('customer_id', $customer_id)->first();
        $shipping = Shipping::where('shipping_id', $shipping_id)->first();
        $order_details_product = OrderDetails::with('product')->where('order_code', $order_code)->get();
        // Tính tổng tiền
        $total = 0;
        foreach ($order_details as $details) {
            $subtotal = $details->product_price * $details->product_sales_quantity;
            $total += $subtotal;
        }
        
         $discount = 0;

        if ($coupon_condition == 1) {
            
            $discount = $total * $coupon_number / 100;
        } elseif ($coupon_condition == 2) {
            
            $discount = $coupon_number;
        }
        else {
            $discount = 0;
        }

        $discount = min($discount, $total);

    // Tổng thanh toán
    $total_after_coupon = $total - $discount + $product_feeship;

        return view('admin.view_order', compact('order_details', 'order', 'customer', 'shipping', 'coupon', 'product_feeship', 'coupon_condition', 'coupon_number', 'total_after_coupon', 'discount','product_coupon'));
    }


public function print_order($checkout_code)
    {
        $order_details = OrderDetails::where('order_code', $checkout_code)->get();
        $order= Order::Where('order_code', $checkout_code)->get();
        foreach($order as $key =>$ord){
            $customer_id = $ord->customer_id;
            $shipping_id = $ord->shipping_id;
        }

        foreach($order_details as $key => $order_d){
            $product_coupon = $order_d->product_coupon;
            $product_feeship = $order_d->product_feeship;
            
        }
            $coupon = Coupon::where('coupon_code', $product_coupon)->first();
            $coupon_condition	= $coupon->coupon_condition ?? 0 ;
            $coupon_number	= $coupon->coupon_number ?? 0 ;
        $customer = Customer::where('customer_id', $customer_id)->first();
        $shipping = Shipping::where('shipping_id', $shipping_id)->first();
        $order_details_product = OrderDetails::with('product')->where('order_code', $checkout_code)->get();
        // Tính tổng tiền
        $total = 0;
        foreach ($order_details as $details) {
            $subtotal = $details->product_price * $details->product_sales_quantity;
            $total += $subtotal;
        }
        
         $discount = 0;

        if ($coupon_condition == 1) {
            
            $discount = $total * $coupon_number / 100;
        } elseif ($coupon_condition == 2) {
            
            $discount = $coupon_number;
        }
        else {
            $discount = 0;
        }

        $discount = min($discount, $total);


        // Hình thức thanh toán
     $shipping_method = $shipping->shipping_method == 0 ? 'Chuyển khoản': 'Tiền mặt';

    // Tổng thanh toán
    $total_after_coupon = $total - $discount + $product_feeship;
        return PDF::loadView(
            'admin.print.print_order',
            compact(
                'order',
                'order_details',
                'customer',
                'shipping',
                'total',
                'discount',
                'product_feeship',
                'total_after_coupon',
                'coupon_condition',
                'coupon_number',
                'shipping_method',
                'product_coupon'
            )
        )->stream('order_'.$checkout_code.'.pdf');
    }

 public function update_order_status(Request $request) {
    // Lấy mảng dữ liệu từ form
    $order_data = $request->order_status; 

    // Kiểm tra nếu $order_data không phải mảng (đề phòng lỗi form)
    if (!is_array($order_data)) {
        return redirect()->back()->with('error', 'Dữ liệu không hợp lệ hoặc trống!');
    }

    foreach($order_data as $order_code => $status_value) {
        $status = (int)$status_value;
        $order = DB::table('tbl_order')->where('order_code', $order_code)->first();

        // Kiểm tra tồn kho khi admin chọn "Đã giao hàng" (2)
        if ($order->order_status != 2 && $status == 2) {
            $order_details = DB::table('tbl_order_details')
                ->join('tbl_product', 'tbl_order_details.product_id', '=', 'tbl_product.product_id')
                ->where('tbl_order_details.order_code', $order_code)
                ->select('tbl_order_details.*', 'tbl_product.product_quantity', 'tbl_product.product_name')
                ->get();

            foreach ($order_details as $item) {
                if ($item->product_sales_quantity > $item->product_quantity) {
                    Session::put('error', 'Đơn hàng '.$order_code.' thất bại: ['.$item->product_name.'] không đủ hàng trong kho!');
                    continue 2; // Bỏ qua đơn hàng này, nhảy sang đơn kế tiếp
                }
            }

            // Trừ kho
            foreach ($order_details as $item) {
                DB::table('tbl_product')
                    ->where('product_id', $item->product_id)
                    ->decrement('product_quantity', $item->product_sales_quantity);
            }
        }

        // Cập nhật trạng thái
        DB::table('tbl_order')->where('order_code', $order_code)->update(['order_status' => $status]);
    }

    return redirect()->back()->with('message', 'Đã cập nhật tất cả trạng thái đơn hàng!');
}

public function add_cart_ajax(Request $request){
    $data = $request->all();
    $cart = Session::get('cart');
    
    $product_db = DB::table('tbl_product')->where('product_id', $data['product_id'])->first();
    $stock_qty = (int)$product_db->product_quantity;
    $qty_want_to_add = (int)$data['product_qty'];

    $qty_already_in_cart = 0;
    if($cart){
        foreach($cart as $val){
            if($val['product_id'] == $data['product_id']){
                $qty_already_in_cart = (int)$val['product_qty'];
                break;
            }
        }
    }
    if( ($qty_already_in_cart + $qty_want_to_add) > $stock_qty ){
        return response()->json([
            'status' => 'error',
            'message' => 'Sản phẩm này chỉ còn ' . $stock_qty . ' cái. Bạn đã có ' . $qty_already_in_cart . ' cái trong giỏ, không thể thêm tiếp ' . $qty_want_to_add . ' cái!'
        ]);
    }

    $is_available = false;
    if($cart == true){
        foreach($cart as $key => $val){
            if($val['product_id'] == $data['product_id']){
                $cart[$key]['product_qty'] = $qty_already_in_cart + $qty_want_to_add;
                $is_available = true;
            }
        }
        if($is_available == false){
            $cart[] = array(
                'session_id' => substr(md5(microtime()),rand(0,26),5),
                'product_name' => $data['product_name'],
                'product_id' => $data['product_id'],
                'product_image' => $data['product_image'],
                'product_qty' => $qty_want_to_add,
                'product_price' => $data['product_price'],
            );
        }
    }else{
        $cart[] = array(
            'session_id' => substr(md5(microtime()),rand(0,26),5),
            'product_name' => $data['product_name'],
            'product_id' => $data['product_id'],
            'product_image' => $data['product_image'],
            'product_qty' => $qty_want_to_add,
            'product_price' => $data['product_price'],
        );
    }

    Session::put('cart', $cart);
    Session::save();

    return response()->json([
        'status' => 'success',
        'cart' => $cart
    ]); 
}



    public function delete_order($orderId){
     $this->AuthLogin();
    
     // Xóa chi tiết đơn hàng trước
     DB::table('tbl_order_details')->where('order_id', $orderId)->delete();
    
     // Xóa đơn hàng
     DB::table('tbl_order')->where('order_id', $orderId)->delete();
    
     return Redirect::to('/manage-order')->with('message', 'Xóa đơn hàng thành công');
    }
}
