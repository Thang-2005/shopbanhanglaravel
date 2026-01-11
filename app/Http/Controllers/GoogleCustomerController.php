<?php

namespace App\Http\Controllers;

use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use App\Models\Customer;

class GoogleCustomerController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();

            // Kiểm tra khách hàng đã tồn tại chưa
            $customer = Customer::where('google_id', $googleUser->id)->first();

            if (!$customer) {
                // Nếu chưa, tạo mới
                        $customer = Customer::create([
                'customer_name'     => $googleUser->name,
                'customer_email'    => $googleUser->email,
                'google_id'         => $googleUser->id,
                'login_type'        => 'google',
                'customer_password' => bcrypt(Str::random(16)), // Nên mã hóa password dù không dùng
                'customer_phone'    => '', // Truyền chuỗi rỗng nếu DB là NOT NULL
                ]);
            }

            // Lưu session khách hàng
            Session::put('customer_id', $customer->customer_id);
            Session::put('customer_name', $customer->customer_name);

            return Redirect::to('/')->with('message', 'Đăng nhập thành công');

       } catch (\Exception $e) {
    // In lỗi ra màn hình để xem có phải lỗi Database không
    dd($e->getMessage()); 
}
    }
}
