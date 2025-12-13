<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Darryldecode\Cart\Facades\CartFacade as Cart;
use App\Models\Coupon;
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

    public function show_cart(){
        $cate_product = DB::table('tbl_category_product')->where('category_status','0')->orderby('category_id','desc')->get(); 
        $brand_product = DB::table('tbl_brand')->where('brand_status','0')->orderby('brand_id','desc')->get(); 
        $cartContent = Cart::getContent();
        
        return view('pages.cart.show_cart')
                ->with('category',$cate_product)
                ->with('brand',$brand_product)
                ->with('cartContent', $cartContent);
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
                if($val['product_id']==$data['cart_product_id']){
                    $is_avaiable++;
                }
            }
            if($is_avaiable == 0){
                $cart[] = array(
                'session_id' => $session_id,
                'product_name' => $data['cart_product_name'],
                'product_id' => $data['cart_product_id'],
                'product_image' => $data['cart_product_image'],
                'product_qty' => $data['cart_product_qty'],
                'product_price' => $data['cart_product_price'],
                );
                Session::put('cart',$cart);
            }
        }else{
            $cart[] = array(
                'session_id' => $session_id,
                'product_name' => $data['cart_product_name'],
                'product_id' => $data['cart_product_id'],
                'product_image' => $data['cart_product_image'],
                'product_qty' => $data['cart_product_qty'],
                'product_price' => $data['cart_product_price'],

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
       $category = DB::table('tbl_category_product')
    ->where('category_status', 0)
    ->get();
        $brand= DB::table('tbl_brand')->where('brand_status','0')->orderby('brand_id','desc')->get(); 

        return view('pages.cart.cart_ajax')->with(compact('category','brand'));
     }

     public function update_cart(Request $request){
        $data = $request->all();
        $cart = Session::get('cart');
        if($cart==true){
            foreach($data['cart_qty'] as $key => $qty){
                foreach($cart as $session => $val){
                    if($val['session_id']==$key){
                        $cart[$session]['product_qty'] = $qty;
                    }
                }
            }
            Session::put('cart',$cart);
            return Redirect()->back()->with('message','Cập nhật giỏ hàng thành công');
        }else{
            return Redirect()->back()->with('message','Làm ơn thêm sản phẩm vào giỏ hàng');
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

     public function check_coupon(Request $request){
    $data = $request->all();
    // Xóa 1 session cụ thể
    Session::forget('coupon');

    $coupon = DB::table('tbl_coupon')->where('coupon_code', $data['coupon_code'])->first();
    if ($coupon) { // nếu coupon tồn tại
        $coupon_session = Session::get('coupon');

        if ($coupon_session) {
            // Kiểm tra xem coupon đã tồn tại trong session chưa
            $is_avaiable = 0;
            foreach($coupon_session as $c) {
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
        return Redirect()->back()->with('message', 'Thêm mã giảm giá thành công');

    } else {
        return Redirect()->back()->with('error', 'Mã giảm giá không tồn tại');
    }
}

     }

