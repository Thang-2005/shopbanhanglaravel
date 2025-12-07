<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Information;
use App\Models\ContactMessage;


class ContactController extends Controller
{
    // Hiển thị form (nếu chưa có bản ghi thì tạo mới)
    public function index()
    {
        // Lấy bản ghi đầu tiên (ta chỉ cần 1 bản ghi thông tin công ty)
        $info = Information::first();
        return view('admin.contact.index', compact('info'));
    }

    // Lưu hoặc cập nhật
    public function store(Request $request)
    {
        $data = $request->validate([
            'company_name' => 'nullable|string|max:255',
            'company_intro' => 'nullable|string',
            'address' => 'nullable|string',
            'phone' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'info_map' => 'nullable|string', // iframe HTML
        ]);

        // nếu có bản ghi thì update, nếu không thì create
        $info = Information::first();
        if ($info) {
            $info->update($data);
        } else {
            Information::create($data);
        }

        return redirect()->back()->with('success', 'Cập nhật thông tin thành công');
    }

    public function submit(Request $request)
{
    $request->validate([
        'name'    => 'required|max:255',
        'email'   => 'required|email',
        'phone'   => 'nullable|max:20',
        'message' => 'required|min:5',
    ]);

    ContactMessage::create([
        'name' => $request->name,
        'email' => $request->email,
        'phone' => $request->phone,
        'message' => $request->message,
    ]);

    return back()->with('success', 'Gửi thông tin thành công!');
}

}
