<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
  public function contact()
{
    $info = DB::table('tbl_information')->first();
    $category = DB::table('tbl_category_product')->orderby('category_id', 'desc')->get();
    $brand = DB::table('tbl_brand')->orderby('brand_id','desc')->get();
    
    return view('pages.contact', compact('info','category','brand'));

   
}


}
