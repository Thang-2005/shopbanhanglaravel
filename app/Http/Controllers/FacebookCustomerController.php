<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\Customer;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

class FacebookCustomerController extends Controller
{
    public function redirect_facebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function callback_facebook()
    {
        try {
            // Lấy thông tin user từ Socialite
            $fb_user = Socialite::driver('facebook')->user();
            
            // 1. Tìm khách hàng theo facebook_id
            $customer = Customer::where('facebook_id', $fb_user->id)->first();

            if (!$customer) {
                // 2. Nếu chưa có facebook_id, tìm theo email để tránh trùng tài khoản
                $customer = Customer::where('customer_email', $fb_user->email)->first();

                if ($customer) {
                    // Nếu thấy email, cập nhật facebook_id và kiểu login
                    $customer->update([
                        'facebook_id' => $fb_user->id,
                        'login_type' => 'facebook'
                    ]);
                } else {
                    // 3. Nếu hoàn toàn mới thì tạo tài khoản mới
                    $customer = Customer::create([
                        'customer_name'     => $fb_user->name,
                        'customer_email'    => $fb_user->email ?? $fb_user->id . '@facebook.com',
                        'customer_password' => md5(rand(1, 10000)), // Password giả lập
                        'customer_phone'    => '',
                        'role'              => 0, // 0 cho khách hàng
                        'facebook_id'       => $fb_user->id,
                        'login_type'        => 'facebook'
                    ]);
                }
            }

            // Đăng nhập vào Session khách hàng
            Session::put('customer_id', $customer->customer_id);
            Session::put('customer_name', $customer->customer_name);
            
            return Redirect::to('/checkout')->with('message', 'Đăng nhập Facebook thành công!');

        } catch (\Exception $e) {
            return Redirect::to('/login-checkout')->with('error', 'Lỗi đăng nhập Facebook hoặc bạn đã hủy quyền.');
        }
    }
}