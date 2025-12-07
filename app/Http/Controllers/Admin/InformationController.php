<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InformationController extends Controller
{
    public function index()
    {
        $info = DB::table('tbl_information')->first();
        return view('admin.information.index', compact('info'));
    }

    public function update(Request $request)
    {
        DB::table('tbl_information')->where('info_id', 1)->update([
            'info_address' => $request->info_address,
            'info_phone'   => $request->info_phone,
            'info_email'   => $request->info_email,
            'info_contact' => $request->info_contact,
            'info_map'     => $request->info_map,
        ]);

        return redirect()->back()->with('message', 'Cập nhật thông tin thành công');
    }
}
