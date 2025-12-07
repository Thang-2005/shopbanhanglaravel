<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Darryldecode\Cart\Facades\CartFacade as Cart;

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
}
