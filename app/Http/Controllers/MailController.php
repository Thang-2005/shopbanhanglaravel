<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Mail;
use App\Models\Order;
use App\Models\Shipping;



class MailController extends Controller
{
    public function test_mail()
{
    $name = 'test name for email';
   $shipping = Shipping::first();
   Mail::send('emails.test_mail', compact('shipping'), function($message) use ($shipping) {
    $message->to($shipping->shipping_email, $shipping->shipping_name)
            ->subject('Test gửi mail Laravel');
});


    return 'Gửi mail thành công';

}
}
