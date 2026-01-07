<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Hóa đơn bán hàng</title>
<style>
@page { margin: 20mm; size: A4 portrait; }
body { font-family: Arial, sans-serif; font-size: 13px; color: #000; }
.clear { clear: both; }

/* HEADER */
.header { border-bottom: 2px solid #000; padding-bottom: 10px; margin-bottom: 20px; }
.header-left { float: left; width: 50%; }
.header-right { float: right; width: 50%; text-align: right; font-size: 12px; }

/* TITLE */
.title { text-align: center; margin-bottom: 20px; }
.title h1 { font-size: 16px; text-transform: uppercase; }

/* INFO */
.info { margin-bottom: 15px; }
.info div { margin-bottom: 4px; }

/* TABLE */
table { width: 100%; border-collapse: collapse; margin-bottom: 15px; }
th, td { border: 1px solid #000; padding: 6px; text-align: center; }
th { background: #f0f0f0; }

/* SUMMARY */
.summary { margin-top: 10px; text-align: right; }
.summary div { margin-bottom: 4px; }
.total { font-weight: bold; font-size: 14px; }

/* SIGNATURE */
.signature { margin-top: 30px; display: flex; justify-content: space-between; }
.signature div { text-align: center; }
.signature span { display: block; margin-top: 60px; font-weight: bold; }

/* FOOTER */
.footer { text-align: center; font-size: 11px; font-style: italic; margin-top: 15px; }
</style>
</head>
<body>

<div class="header">
    <div class="header-left">
        <div><strong>SHOP BÁN HÀNG LARAVEL</strong></div>
        <div>Địa chỉ: 123 Đường ABC, Quận 1, TP.HCM</div>
        <div>Điện thoại: 0909 000 111</div>
    </div>
    <div class="header-right">
        <div>Mẫu số: 01GTTT3/001</div>
        <div>Số: {{ $order->order_code }}</div>
        <div>Ngày: {{ date('d/m/Y') }}</div>
    </div>
    <div class="clear"></div>
</div>

<div class="title">
    <h1>HÓA ĐƠN BÁN HÀNG</h1>
</div>

<div class="info">
    <div><strong>Khách hàng:</strong> {{ $shipping->shipping_name }}</div>
    <div><strong>Điện thoại:</strong> {{ $shipping->shipping_phone }}</div>
    <div><strong>Địa chỉ:</strong> {{ $shipping->shipping_address }}</div>
    <div><strong>Hình thức thanh toán:</strong> {{ $shipping_method }}</div>
</div>

<table>
    <thead>
        <tr>
            <th>STT</th>
            <th>Tên sản phẩm</th>
            <th>ĐVT</th>
            <th>Số lượng</th>
            <th>Đơn giá</th>
            <th>Thành tiền</th>
        </tr>
    </thead>
    <tbody>
        @php $i=1; $total=0; @endphp
        @foreach ($order_details as $item)
            @php
                $subtotal = $item->product_price * $item->product_sales_quantity;
                $total += $subtotal;
            @endphp
        <tr>
            <td>{{ $i++ }}</td>
            <td class="text-left">{{ $item->product_name }}</td>
            <td>Cái</td>
            <td>{{ $item->product_sales_quantity }}</td>
            <td>{{ number_format($item->product_price,0,',','.') }}</td>
            <td>{{ number_format($subtotal,0,',','.') }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

@php
$feeship = (float) ($order_details->first()->product_feeship ?? 0);
$discount_amount = (float) $discount;
$total_after_coupon = $total - $discount_amount + $feeship;

function numberToWords($number) {
    $words = ['không','một','hai','ba','bốn','năm','sáu','bảy','tám','chín'];
    $units = ['', 'nghìn', 'triệu', 'tỷ'];
    if ($number==0) return 'Không đồng';
    $result = ''; $unitIndex=0;
    while ($number>0) {
        $group=$number%1000;
        if($group>0){
            $h=floor($group/100); $t=floor(($group%100)/10); $u=$group%10;
            $str='';
            if($h>0) $str.=$words[$h].' trăm ';
            if($t>1){ $str.=$words[$t].' mươi '; if($u>0) $str.=$words[$u].' '; }
            elseif($t==1){ $str.='mười '; if($u>0) $str.=$words[$u].' '; }
            elseif($t==0 && $u>0 && $h>0) $str.='lẻ '.$words[$u].' ';
            elseif($t==0 && $u>0) $str.=$words[$u].' ';
            $result=$str.$units[$unitIndex].' '.$result;
        }
        $number=floor($number/1000); $unitIndex++;
    }
    return ucfirst(trim($result)).' đồng chẵn';
}
@endphp

<div class="summary">
    <div>Cộng tiền hàng: {{ number_format($total,0,',','.') }} đồng</div>
    <div>Giảm giá: {{ number_format($discount_amount,0,',','.') }} đồng</div>
    <div>Phí vận chuyển: {{ number_format($feeship,0,',','.') }} đồng</div>
    <div class="total">Tổng thanh toán: {{ number_format($total_after_coupon,0,',','.') }} đồng</div>
    <div><em>Bằng chữ: {{ numberToWords($total_after_coupon) }}</em></div>
</div>

<div class="signature">
    <div>Người mua<span>(Ký, ghi rõ họ tên)</span></div>
    <div>Người bán<span>(Ký, ghi rõ họ tên)</span></div>
    <div>Thủ quỹ<span>(Ký, ghi rõ họ tên)</span></div>
</div>

<div class="footer">(Hóa đơn được lập theo thông tin khách hàng và đơn hàng)</div>

</body>
</html>
