<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use App\Models\Banner;

class HomeController extends Controller
{

    
    public function index(Request $request)
    {
        $meta_desc = "Đây là trang chủ";
        $meta_keyword = "Laravel, elaravel";
        $meta_title = "Shop bán hàng laravel";
        $url_canonical = $request->url();

        $cate_product = DB::table('tbl_category_product')
            ->where('category_status', 0)
            ->orderByDesc('category_id')
            ->get();

        $brand_product = DB::table('tbl_brand')
            ->where('brand_status', 0)
            ->orderByDesc('brand_id')
            ->get();

        $banner = Banner::where('banner_status', 1)
            ->latest('banner_id')
            ->limit(4)
            ->get();

        $all_product = DB::table('tbl_product')
            ->where('product_status', 0)
            ->latest('product_id')
            ->limit(6)
            ->get();

        return view('pages.home', compact(
            'cate_product',
            'brand_product',
            'banner',
            'all_product',
            'meta_desc',
            'meta_keyword',
            'meta_title',
            'url_canonical'
        ));
    }

    public function search(Request $request)
    {
        $keywords = $request->keywords_submit;

        $cate_product = DB::table('tbl_category_product')
            ->where('category_status', 0)
            ->orderByDesc('category_id')
            ->get();

        $brand_product = DB::table('tbl_brand')
            ->where('brand_status', 0)
            ->orderByDesc('brand_id')
            ->get();

        $search_product = DB::table('tbl_product')
            ->where('product_name', 'like', '%' . $keywords . '%')
            ->get();

        return view('pages.sanpham.search', compact('cate_product','brand_product','search_product'));
    }
    

}



