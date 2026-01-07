<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Shipping;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\Customer;

class OrderConfirmationMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $shipping;
    public $order;
    public $order_details;
    public $customer;
    public $discount;

    public function __construct(Shipping $shipping, Order $order, $order_details, Customer $customer, $discount = 0)
    {
        $this->shipping = $shipping;
        $this->order = $order;
        $this->order_details = $order_details;
        $this->customer = $customer;
        $this->discount = $discount;
    }

    public function build()
    {
        // Tạo PDF hóa đơn
        $pdf = Pdf::loadView('admin.print.print_order', [
            'shipping'       => $this->shipping,
            'order'          => $this->order,
            'order_details'  => $this->order_details,
            'customer'       => $this->customer,
            'shipping_method'=> $this->shipping->shipping_method,
            'discount'       => $this->discount,
        ]);

        return $this->subject('Xác nhận đơn hàng')
                    ->markdown('emails.order_confirmation')
                    ->attachData($pdf->output(), "Hoadon_{$this->shipping->shipping_name}.pdf");
    }
}
