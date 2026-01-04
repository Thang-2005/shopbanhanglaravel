<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Banner;
class HomeController extends Controller
{
  public function contact(Request $request)
{
    $info = DB::table('tbl_information')->first();
    $cate_product = DB::table('tbl_category_product')->orderby('category_id', 'desc')->get();
    $brand_product = DB::table('tbl_brand')->orderby('brand_id','desc')->get();
    $banner = Banner::where('banner_status', 1) ->orderBy('banner_id','DESC')->get();

           $meta_desc = 'Thông tin cửa hàng và liên hệ';
            $meta_keyword = 'map, bản đồ';
            $meta_title = 'Trang thông tin liên hệ';
            $url_canonical = $request->url();
    return view('pages.contact', compact('info','cate_product','brand_product',
  'meta_desc','meta_keyword','meta_title','url_canonical','banner'));

   
}


}
