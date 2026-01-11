<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use App\Models\Banner;
use App\Exports\ExcelExportProduct; 
use App\Imports\ExcelImportProduct; 
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Admin;
use App\Models\Product;


class ProductController extends Controller
{

     public function allProduct()
    {
        // Lấy admin đang đăng nhập
        $admin_id = Session::get('admin_id');
        $admin = Admin::with('role.permissions')->find($admin_id);
        
        // Kiểm tra quyền trong controller (tùy chọn)
        if (!$admin->hasPermission('view_product')) {
            Session::put('error', 'Bạn không có quyền xem sản phẩm!');
            return redirect()->back();
        }

        $all_product = Product::all();
        
        return view('admin.product.all_product', compact('all_product', 'admin'));
    }

    // public function deleteProduct($product_id)
    // {
    //     $admin_id = Session::get('admin_id');
    //     $admin = Admin::with('role.permissions')->find($admin_id);
        
    //     if (!$admin->hasPermission('delete_product')) {
    //         Session::put('error', 'Bạn không có quyền xóa sản phẩm!');
    //         return redirect()->back();
    //     }

    //     Product::where('product_id', $product_id)->delete();
        
    //     Session::put('message', 'Xóa sản phẩm thành công!');
    //     return redirect()->back();
    // }
    public function deleteProduct($product_id)
{
    $admin_id = Session::get('admin_id');
    $admin = Admin::with('role.permissions')->find($admin_id);
    
    if (!$admin->hasPermission('delete_product')) {
        Session::put('error', 'Bạn không có quyền xóa sản phẩm!');
        return redirect()->back();
    }
    
    Product::where('product_id', $product_id)->delete();
        
        Session::put('message', 'Xóa sản phẩm thành công!');
        return redirect()->back();
}
    public function AuthLogin(){
        $admin_id = Session::get('admin_id');
        if($admin_id){
            return Redirect::to('dashboard');
        }else{
            return Redirect::to('admin')->send();
        }
    }
    public function add_product(){
        $this->AuthLogin();
        $cate_product = DB::table('tbl_category_product')->orderby('category_id','desc')->get(); 
        $brand_product = DB::table('tbl_brand')->orderby('brand_id','desc')->get(); 
       

        return view('admin.add_product')->with('cate_product', $cate_product)->with('brand_product',$brand_product);
    	

    }
    public function all_product(){
        $this->AuthLogin();
    	$all_product = DB::table('tbl_product')
        ->join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
        ->join('tbl_brand','tbl_brand.brand_id','=','tbl_product.brand_id')
        ->orderby('tbl_product.product_id','desc')->paginate(10);
    	$manager_product  = view('admin.all_product')->with('all_product',$all_product);
    	return view('admin_layout')->with('admin.all_product', $manager_product);

    }
        public function save_product(Request $request){
            $this->AuthLogin();
            $data = array();
       
            $data['product_name'] = $request->product_name;
            $data['product_quantity'] = $request->product_quantity;
            $data['product_price'] = $request->product_price;
            $data['product_desc'] = $request->product_desc;
            $data['product_content'] = $request->product_content;
            $data['category_id'] = $request->category_id;
            $data['brand_id'] = $request->brand_id;
            $data['product_status'] = $request->product_status;
            $data['product_image'] = $request->product_status;
            $get_image = $request->file('product_image');
        
            if($get_image){
                $get_name_image = $get_image->getClientOriginalName();
                $name_image = current(explode('.',$get_name_image));
                $new_image =  $name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();
                $get_image->move('public/uploads/product',$new_image);
                $data['product_image'] = $new_image;
                DB::table('tbl_product')->insert($data);
                Session::put('message','Thêm sản phẩm thành công');
                return Redirect::to('add-product');
            }
            $data['product_image'] = '';
            DB::table('tbl_product')->insert($data);
            Session::put('message','Thêm sản phẩm thành công');
            return Redirect::to('all-product');
        }
    public function unactive_product($product_id){
         $this->AuthLogin();
        DB::table('tbl_product')->where('product_id',$product_id)->update(['product_status'=>1]);
        Session::put('message','Ẩn sản phẩm thành công');
        return Redirect::to('all-product');

    }
    public function active_product($product_id){
         $this->AuthLogin();
        DB::table('tbl_product')->where('product_id',$product_id)->update(['product_status'=>0]);
        Session::put('message',' kích hoạt sản phẩm thành công');
        return Redirect::to('all-product');
    }
    public function edit_product($product_id){
         $this->AuthLogin();
        $cate_product = DB::table('tbl_category_product')->orderby('category_id','desc')->get(); 
        $brand_product = DB::table('tbl_brand')->orderby('brand_id','desc')->get(); 

        $edit_product = DB::table('tbl_product')->where('product_id',$product_id)->get();

        $manager_product  = view('admin.edit_product')->with('edit_product',$edit_product)->with('cate_product',$cate_product)->with('brand_product',$brand_product);

        return view('admin_layout')->with('admin.edit_product', $manager_product);
    }
    public function update_product(Request $request,$product_id){
         $this->AuthLogin();
        $data = array();
        $data['product_name'] = $request->product_name;
        $data['product_quantity'] = $request->product_quantity;
        $data['product_price'] = $request->product_price;
        $data['product_desc'] = $request->product_desc;
        $data['product_content'] = $request->product_content;
        $data['category_id'] = $request->product_cate;
        $data['brand_id'] = $request->product_brand;
        $data['product_status'] = $request->product_status;
        $get_image = $request->file('product_image');
        
        if($get_image){
                    $get_name_image = $get_image->getClientOriginalName();
                    $name_image = current(explode('.',$get_name_image));
                    $new_image =  $name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();
                    $get_image->move('public/uploads/product',$new_image);
                    $data['product_image'] = $new_image;
                    DB::table('tbl_product')->where('product_id',$product_id)->update($data);
                    Session::put('message','Cập nhật sản phẩm thành công');
                    return Redirect::to('all-product');
        }
            
        DB::table('tbl_product')->where('product_id',$product_id)->update($data);
        Session::put('message','Cập nhật sản phẩm thành công');
        return Redirect::to('all-product');
    }
    public function delete_product($product_id){
        $this->AuthLogin();
        DB::table('tbl_product')->where('product_id',$product_id)->delete();
        Session::put('message','Xóa sản phẩm thành công');
        return Redirect::to('all-product');
    }
    //End Admin Page
    public function details_product( Request $request, $product_id){
        $cate_product = DB::table('tbl_category_product')->where('category_status','0')->orderby('category_id','desc')->get(); 
        $brand_product = DB::table('tbl_brand')->where('brand_status','0')->orderby('brand_id','desc')->get(); 

        $details_product = DB::table('tbl_product')
        ->join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
        ->join('tbl_brand','tbl_brand.brand_id','=','tbl_product.brand_id')
        ->where('tbl_product.product_id',$product_id)->get();

        foreach($details_product as $key => $value){
            $category_id = $value->category_id;
        }
        $banner = Banner::where('banner_status', 1)
        ->orderBy('banner_id','DESC')
        ->get();

           $meta_desc = $value->product_desc;
            $meta_keyword = $value-> product_content;
            $meta_title = $value->product_name;
            $url_canonical = $request->url();
			$meta_image = url('public/uploads/product/' . $value->product_image);
            
        $related_product = DB::table('tbl_product')
        ->join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
        ->join('tbl_brand','tbl_brand.brand_id','=','tbl_product.brand_id')
        ->where('tbl_category_product.category_id',$category_id)->whereNotIn('tbl_product.product_id',[$product_id])->get();


        return view('pages.sanpham.show_details',compact('cate_product','brand_product','details_product','related_product','banner',
    'meta_desc','meta_keyword','meta_title','url_canonical','meta_image'));

    }
    public function export_product(){
        return Excel::download(new ExcelExportProduct, 'products.xlsx');
    }

    public function import_product(Request $request)
    {
    
        $request->validate([
            'file' => 'required|mimes:xlsx,csv',
        ], [
            'file.required' => 'Vui lòng chọn file Excel.',
            'file.mimes' => 'File phải có định dạng .xlsx hoặc .csv.',
        ]);

        // Lấy file từ request
        $file = $request->file('file');

        // Thực hiện import
        Excel::import(new ExcelImportProduct, $file);

        // Trả về thông báo thành công
        return back()->with('success', 'Import Excel sản phẩm thành công!');
    }
}
