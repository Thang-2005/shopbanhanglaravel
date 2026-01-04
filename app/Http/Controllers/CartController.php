<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Darryldecode\Cart\Facades\CartFacade as Cart;
use App\Models\Coupon;
use App\Models\Banner;

session_start();

class CartController extends Controller
{
    public function save_cart(Request $request){
        $productId = $request->productid_hidden;
        $quantity = $request->qty;
        $product_info = DB::table('tbl_product')->where('product_id',$productId)->first(); 

        Cart::add([
            'id' => $product_info->product_id,
            'name' => $product_info->product_name,
            'price' => $product_info->product_price,
            'quantity' => $quantity,
            'attributes' => [
                'image' => $product_info->product_image
            ]
        ]);

        return Redirect::to('/show-cart');
    }

    public function show_cart(Request $request){
        $cate_product = DB::table('tbl_category_product')->where('category_status','0')->orderby('category_id','desc')->get(); 
        $brand_product = DB::table('tbl_brand')->where('brand_status','0')->orderby('brand_id','desc')->get(); 
        $cartContent = Cart::getContent();
         $banner = Banner::where('banner_status', 1)
        ->orderBy('banner_id','DESC')
        ->get();

           $meta_desc = 'Giỏ hàng';
            $meta_keyword = 'Giỏ hàng';
            $meta_title = 'Trang giỏ hàng';
            $url_canonical = $request->url();
        return view('pages.cart.show_cart',compact('cate_product','brand_product','cartContent','banner','meta_desc',
        'meta_keyword','meta_title','url_canonical'));
        }

    public function delete_to_cart($id){
        if (Cart::get($id)) {
            Cart::remove($id);
        }
        return Redirect::to('/show-cart');
    }

    public function update_cart_quantity(Request $request){
        $id = $request->rowId_cart;
        $qty = $request->cart_quantity;

        Cart::update($id, [
            'quantity' => [
                'relative' => false,
                'value' => $qty
            ]
        ]);

        return Redirect::to('/show-cart');
    }



 public function add_cart_ajax(Request $request){
        $data = $request->all();      
        $session_id = substr(md5(microtime()),rand(0,26),5);
        $cart = Session::get('cart');
        if($cart==true){
            $is_avaiable = 0;
            foreach($cart as $key => $val){
                if($val['product_id']==$data['product_id']){
                    $is_avaiable++;
                }
            }
            if($is_avaiable == 0){
                $cart[] = array(
                'session_id' => $session_id,
                'product_name' => $data['product_name'],
                'product_id' => $data['product_id'],
                'product_image' => $data['product_image'],
                'product_qty' => $data['product_qty'],
                'product_price' => $data['product_price'],
                );
                Session::put('cart',$cart);
            }
        }else{
            $cart[] = array(
                'session_id' => $session_id,
                'product_name' => $data['product_name'],
                'product_id' => $data['product_id'],
                'product_image' => $data['product_image'],
                'product_qty' => $data['product_qty'],
                'product_price' => $data['product_price'],

            );
            Session::put('cart',$cart);
        }
       
        Session::save();
        return response()->json([
        'status' => 'success',
        'cart' => Session::get('cart')
        ]);

     }  

     public function gio_hang(Request $request){
       $cate_product = DB::table('tbl_category_product')
    ->where('category_status', 0)
    ->get();
        $brand_product= DB::table('tbl_brand')->where('brand_status','0')->orderby('brand_id','desc')->get(); 
        $banner = Banner::where('banner_status', 1)
        ->orderBy('banner_id','DESC')
        ->get();

           $meta_desc = 'Giỏ hàng';
            $meta_keyword = 'Giỏ hàng';
            $meta_title = 'Trang giỏ hàng';
            $url_canonical = $request->url();
        return view('pages.cart.cart_ajax')->with(compact('cate_product','brand_product','banner','meta_desc',
        'meta_keyword','meta_title','url_canonical'));
     }
     
     public function update_cart(Request $request){
    $data = $request->all();
    $cart = Session::get('cart');
    if($cart){
        foreach($data['cart_qty'] as $key => $qty){
            foreach($cart as $session => $val){
                if($val['session_id'] == $key){
                    // Kiểm tra tồn kho trước khi cập nhật số lượng mới
                    $product = DB::table('tbl_product')->where('product_id', $val['product_id'])->first();
                    
                    if($qty > $product->product_quantity){
                        return redirect()->back()->with('error', 'Sản phẩm '.$product->product_name.' chỉ còn '.$product->product_quantity.' cái, không thể cập nhật lên '.$qty);
                    }
                    
                    $cart[$session]['product_qty'] = $qty;
                }
            }
        }
        Session::put('cart', $cart);
        return redirect()->back()->with('message', 'Cập nhật số lượng thành công');
    }
}

     public function delete_cart($session_id){
        $cart = Session::get('cart');
    
      
        if($cart==true){
            foreach($cart as $key => $val){
                if($val['session_id']==$session_id){
                    unset($cart[$key]);
                }
            }
            Session::put('cart',$cart);
            return Redirect()->back()->with('message','Xóa sản phẩm thành công');
        }else{
            return Redirect()->back()->with('message','Bạn không có sản phẩm để xóa');
        }
     }

     public function delete_all_cart(){
        $cart = Session::get('cart');
    
        if($cart==true){
            Session::forget('cart');
            return Redirect()->back()->with('message','Xóa tất cả sản phẩm thành công');
        }else{
            return Redirect()->back()->with('message','Bạn không có sản phẩm để xóa');
        }
     }

     public function check_coupon(Request $request)
{
    $data = $request->all();

    // Kiểm tra coupon trong DB
    $coupon = DB::table('tbl_coupon')
        ->where('coupon_code', $data['coupon_code'])
        ->first();

    if ($coupon) {

        // Chỉ xóa session khi coupon hợp lệ
        Session::forget('coupon');

        $coupon_session = Session::get('coupon');

        if ($coupon_session) {
            $is_avaiable = 0;

            foreach ($coupon_session as $c) {
                if ($c['coupon_code'] == $coupon->coupon_code) {
                    $is_avaiable = 1;
                    break;
                }
            }

            if ($is_avaiable == 0) {
                $coupon_session[] = [
                    'coupon_code' => $coupon->coupon_code,
                    'coupon_condition' => $coupon->coupon_condition,
                    'coupon_number' => $coupon->coupon_number,
                ];
                Session::put('coupon', $coupon_session);
            }

        } else {
            $cou[] = [
                'coupon_code' => $coupon->coupon_code,
                'coupon_condition' => $coupon->coupon_condition,
                'coupon_number' => $coupon->coupon_number,
            ];
            Session::put('coupon', $cou);
        }

        Session::save();

        return redirect()->back()->with('message', 'Thêm mã giảm giá thành công');

    } else {
        return redirect()->back()->with('error', 'Mã giảm giá không tồn tại');
    }
}


     }

