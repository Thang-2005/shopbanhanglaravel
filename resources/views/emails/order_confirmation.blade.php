<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #4CAF50;
            color: white;
            padding: 20px;
            text-align: center;
        }
        .content {
            padding: 20px;
            background-color: #f9f9f9;
        }
        .order-info {
            background-color: white;
            padding: 15px;
            margin: 15px 0;
            border-radius: 5px;
        }
        .footer {
            text-align: center;
            padding: 20px;
            color: #777;
            font-size: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>✅ XÁC NHẬN ĐƠN HÀNG</h1>
        </div>
        
        <div class="content">
            <p>Xin chào <strong>{{ $shipping->shipping_name }}</strong>,</p>
            <p>Cảm ơn bạn đã đặt hàng! Đơn hàng của bạn đã được tiếp nhận và đang chờ xử lý.</p>
            
            <div class="order-info">
                <h3>📋 Thông tin đơn hàng</h3>
                <p><strong>Mã đơn hàng:</strong> {{ $order->order_code }}</p>
                <p><strong>Ngày đặt:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
                <p><strong>Trạng thái:</strong> {{ $order->order_status == 0 ? 'Đang chờ xử lý' : 'Đã xử lý' }}</p>
            </div>
            
            <div class="order-info">
                <h3>🚚 Thông tin giao hàng</h3>
                <p><strong>Người nhận:</strong> {{ $shipping->shipping_name }}</p>
                <p><strong>Điện thoại:</strong> {{ $shipping->shipping_phone }}</p>
                <p><strong>Email:</strong> {{ $shipping->shipping_email }}</p>
                <p><strong>Địa chỉ:</strong> {{ $shipping->shipping_address }}</p>
                @if(!empty($shipping->shipping_notes))
                <p><strong>Ghi chú:</strong> {{ $shipping->shipping_notes }}</p>
                @endif
            </div>
            
            <div class="order-info">
                <h3>🛍️ Chi tiết đơn hàng</h3>
                <table>
                    <thead>
                        <tr>
                            <th>Sản phẩm</th>
                            <th>Hình ảnh</th>
                            <th style="text-align: center;">Số lượng</th>
                            <th style="text-align: right;">Đơn giá</th>
                            <th style="text-align: right;">Thành tiền</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order_details as $item)
                        <tr>
                            <td>{{ $item->product_name }}</td>
                            <td>($item['product_image'])</td>
                            <td style="text-align: center;">{{ $item->product_sales_quantity }}</td>
                            <td style="text-align: right;">{{ number_format($item->product_price,0,',','.') }} đ</td>
                            <td style="text-align: right;">{{ number_format($item->product_price * $item->product_sales_quantity,0,',','.') }} đ</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3" style="text-align: right;"><strong>Tổng cộng:</strong></td>
                            <td style="text-align: right;">
                                {{ number_format($order_details->sum(fn($item) => $item->product_price * $item->product_sales_quantity),0,',','.') }} đ
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            
            <p>📧 Chúng tôi đã gửi kèm hóa đơn chi tiết trong file đính kèm (PDF).</p>
            <p>📞 Nếu có bất kỳ thắc mắc nào, vui lòng liên hệ hotline: <strong>0123-456-789</strong></p>
        </div>
        
        <div class="footer">
            <p>© 2026 Shop của bạn. All rights reserved.</p>
            <p>Email này được gửi tự động, vui lòng không trả lời.</p>
        </div>
    </div>
</body>
</html>
