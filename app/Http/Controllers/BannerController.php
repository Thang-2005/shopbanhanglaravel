<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Banner;

class BannerController extends Controller
{
    public function manage_banner()
    {
        $all_banner = Banner::orderBy('banner_id', 'DESC')->get();
        
        return view('admin.banner.list_banner', compact('all_banner'));
    }

    public function add_banner()
    {
        return view('admin.banner.add_banner');
    }
    public function insert_banner(Request $request)
{
    $data = $request->all();
    $get_image = $request->file('banner_image');

    if (!$get_image){
        Session::put('error', 'Vui lòng thêm hình ảnh banner');
        return redirect()->back();
    }
    $banner = new Banner();

        $get_name_image = $get_image->getClientOriginalName();
        $name_image = current(explode('.', $get_name_image));
        $new_image =  $name_image . rand(0, 99) . '.' . $get_image->getClientOriginalExtension();
        $get_image->move('public/uploads/banner', $new_image);
        $banner->banner_image = $new_image;

        $banner->banner_name = $data['banner_name'];
        $banner->banner_image = $new_image;
        $banner->banner_desc = $data['banner_desc'];
        $banner->banner_status = $data['banner_status'];
        $banner->save();
    
    
    return redirect()->back()->with('message', 'Thêm banner thành công');
}

    public function unactive_banner($banner_id)
    {
        Banner::where('banner_id', $banner_id)->update(['banner_status' => 1]);
        return redirect()->back()->with('message', 'Hiển thị banner thành công');
    }

    public function active_banner($banner_id)
    {
        Banner::where('banner_id', $banner_id)->update(['banner_status' => 0]);
        return redirect()->back()->with('error', 'Ẩn banner thành công');
    }

    public function delete_banner($banner_id)
    {
        Banner::where('banner_id', $banner_id)->delete();
        return redirect()->back()->with('error', 'Xóa banner thành công');
    }

}
