@extends('admin_layout')
@section('admin_content')

<style>
    .order-detail-container {
        padding: 20px;
        background: #f5f7fa;
    }
    
    .card-modern {
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        margin-bottom: 24px;
        overflow: hidden;
        transition: all 0.3s ease;
    }
    
    .card-modern:hover {
        box-shadow: 0 4px 16px rgba(0,0,0,0.12);
    }
    
    .card-header-modern {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 20px 24px;
        font-size: 18px;
        font-weight: 600;
        border: none;
    }
    
    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
        padding: 24px;
    }
    
    .info-item {
        display: flex;
        flex-direction: column;
    }
    
    .info-label {
        font-size: 12px;
        font-weight: 600;
        color: #8b95a5;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 8px;
    }
    
    .info-value {
        font-size: 15px;
        color: #2d3748;
        font-weight: 500;
    }
    
    .payment-badge {
        display: inline-block;
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 600;
    }
    
    .payment-bank {
        background: #e6f7ff;
        color: #1890ff;
    }
    
    .payment-cash {
        background: #f6ffed;
        color: #52c41a;
    }
    
    .table-modern {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }
    
    .table-modern thead {
        background: #f8fafc;
    }
    
    .table-modern th {
        padding: 16px;
        text-align: left;
        font-size: 13px;
        font-weight: 600;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 2px solid #e2e8f0;
    }
    
    .table-modern td {
        padding: 16px;
        color: #334155;
        border-bottom: 1px solid #f1f5f9;
    }
    
    .table-modern tbody tr {
        transition: background 0.2s ease;
    }
    
    .table-modern tbody tr:hover {
        background: #f8fafc;
    }
    
    .product-name {
        font-weight: 600;
        color: #1e293b;
    }
    
    .quantity-badge {
        display: inline-block;
        padding: 4px 10px;
        background: #ede9fe;
        color: #7c3aed;
        border-radius: 6px;
        font-weight: 600;
        font-size: 13px;
    }
    
    .stock-badge {
        display: inline-block;
        padding: 4px 10px;
        background: #fef3c7;
        color: #d97706;
        border-radius: 6px;
        font-weight: 600;
        font-size: 13px;
    }
    
    .price-text {
        color: #059669;
        font-weight: 600;
    }
    
    .summary-section {
        background: #f8fafc;
        padding: 24px;
        border-radius: 8px;
        margin-top: 20px;
    }
    
    .summary-row {
        display: flex;
        justify-content: space-between;
        padding: 12px 0;
        border-bottom: 1px solid #e2e8f0;
    }
    
    .summary-row:last-child {
        border-bottom: none;
        margin-top: 8px;
        padding-top: 16px;
        border-top: 2px solid #cbd5e1;
    }
    
    .summary-label {
        font-size: 14px;
        color: #64748b;
        font-weight: 500;
    }
    
    .summary-value {
        font-size: 14px;
        color: #1e293b;
        font-weight: 600;
    }
    
    .total-label {
        font-size: 16px;
        font-weight: 700;
        color: #1e293b;
    }
    
    .total-value {
        font-size: 20px;
        font-weight: 700;
        color: #059669;
    }
    
    .coupon-info {
        display: inline-block;
        padding: 8px 16px;
        background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
        color: white;
        border-radius: 8px;
        font-weight: 600;
        margin-bottom: 12px;
    }
    
    .discount-text {
        color: #dc2626;
        font-weight: 600;
    }
    
    .btn-print {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 12px 32px;
        border-radius: 8px;
        border: none;
        font-weight: 600;
        font-size: 15px;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-block;
        margin-top: 20px;
    }
    
    .btn-print:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
        color: white;
        text-decoration: none;
    }
    
    .alert-message {
        padding: 12px 20px;
        background: #dbeafe;
        color: #1e40af;
        border-radius: 8px;
        margin-bottom: 20px;
        border-left: 4px solid #3b82f6;
    }
</style>

<div class="order-detail-container">
    @php
        $message = Session::get('message');
    @endphp
    
    @if($message)
        <div class="alert-message">
            {{ $message }}
        </div>
        @php
            Session::put('message', null);
        @endphp
    @endif

    <!-- Customer Information -->
    <div class="card-modern">
        <div class="card-header-modern">
            <i class="fa fa-user"></i> Thông tin khách hàng
        </div>
        <div class="info-grid">
            <div class="info-item">
                <span class="info-label">Tên khách hàng</span>
                <span class="info-value">{{ $customer->customer_name }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Số điện thoại</span>
                <span class="info-value">{{ $customer->customer_phone }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Email</span>
                <span class="info-value">{{ $customer->customer_email }}</span>
            </div>
        </div>
    </div>

    <!-- Shipping Information -->
    <div class="card-modern">
        <div class="card-header-modern">
            <i class="fa fa-truck"></i> Thông tin vận chuyển
        </div>
        <div class="info-grid">
            <div class="info-item">
                <span class="info-label">Người nhận</span>
                <span class="info-value">{{ $shipping->shipping_name }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Địa chỉ</span>
                <span class="info-value">{{ $shipping->shipping_address }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Số điện thoại</span>
                <span class="info-value">{{ $shipping->shipping_phone }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Email</span>
                <span class="info-value">{{ $shipping->shipping_email }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Ghi chú</span>
                <span class="info-value">{{ $shipping->shipping_notes ?: 'Không có ghi chú' }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Hình thức thanh toán</span>
                <span class="info-value">
                    @if($shipping->shipping_method == 1)
                    <span class="payment-badge payment-cash">
                        <i class="fa fa-money"></i> Tiền mặt
                    </span>
                        
                    @else
                        <span class="payment-badge payment-bank">
                            <i class="fa fa-credit-card"></i> Chuyển khoản
                        </span>
                    @endif
                </span>
            </div>
        </div>
    </div>

    <!-- Order Details -->
    <div class="card-modern">
        <div class="card-header-modern">
            <i class="fa fa-shopping-cart"></i> Chi tiết đơn hàng
        </div>
        
        <div style="padding: 24px;">
            <table class="table-modern">
                <thead>
                    <tr>
                        <th style="width: 50px;">STT</th>
                        <th>Tên sản phẩm</th>
                        <th style="text-align: center;">SL đặt</th>
                        <th style="text-align: center;">Tồn kho</th>
                        <th style="text-align: right;">Đơn giá</th>
                        <th style="text-align: right;">Thành tiền</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $i = 1;
                        $order_code = '';
                    @endphp
                    @foreach($order_details as $key => $ord)
                        @php
                            $order_code = $ord->order_code;
                        @endphp
                        <tr>
                            <td style="text-align: center;">{{ $i++ }}</td>
                            <td>
                                <span class="product-name">{{ $ord->product_name }}</span>
                            </td>
                            <td style="text-align: center;">
                                <span class="quantity-badge">{{ $ord->product_sales_quantity }}</span>
                            </td>
                            <td style="text-align: center;">
                                <span class="stock-badge">{{ $ord->product->product_quantity }}</span>
                            </td>
                            <td style="text-align: right;">
                                <span class="price-text">{{ number_format($ord->product_price, 0, ',', '.') }}đ</span>
                            </td>
                            <td style="text-align: right;">
                                <span class="price-text">{{ number_format($ord->product_price * $ord->product_sales_quantity, 0, ',', '.') }}đ</span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Summary Section -->
            <div class="summary-section">
                @if($product_coupon != 'Không có')
                    <div class="coupon-info">
                        <i class="fa fa-tag"></i> Mã giảm giá: {{ $product_coupon }}
                    </div>
                @endif
                
                <div class="summary-row">
                    <span class="summary-label">Tạm tính</span>
                    <span class="summary-value">
                        {{ number_format($total_after_coupon + $discount - $product_feeship, 0, ',', '.') }}đ
                    </span>
                </div>
                
                @if($discount > 0)
                    <div class="summary-row">
                        <span class="summary-label">
                            Giảm giá
                            @if($coupon_condition == 1)
                                ({{ $coupon_number }}%)
                            @endif
                        </span>
                        <span class="summary-value discount-text">
                            -{{ number_format($discount, 0, ',', '.') }}đ
                        </span>
                    </div>
                @endif
                
                <div class="summary-row">
                    <span class="summary-label">Phí vận chuyển</span>
                    <span class="summary-value">{{ number_format($product_feeship, 0, ',', '.') }}đ</span>
                </div>
                
                <div class="summary-row">
                    <span class="total-label">Tổng thanh toán</span>
                    <span class="total-value">{{ number_format($total_after_coupon, 0, ',', '.') }}đ</span>
                </div>
            </div>

            <div style="text-align: center;">
                <a href="{{ URL::to('/print-order/' . $order_code) }}" 
                   target="_blank" 
                   class="btn-print">
                    <i class="fa fa-print"></i> In đơn hàng
                </a>
            </div>
        </div>
    </div>
</div>

@endsection