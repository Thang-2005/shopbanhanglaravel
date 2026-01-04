<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Hóa đơn bán hàng</title>

<style>
@page { 
    margin: 20mm 20mm 15mm 20mm; 
    size: A4 portrait;
}

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Times New Roman', 'DejaVu Serif', serif;
    font-size: 13px;
    color: #000;
    line-height: 1.5;
}

.clear { clear: both; }

/* HEADER */
.header {
    border-bottom: 1px solid #000;
    padding-bottom: 10px;
    margin-bottom: 15px;
}

.header-left {
    float: left;
    width: 50%;
}

.header-right {
    float: right;
    width: 50%;
    text-align: right;
}

.company-name {
    font-weight: bold;
    font-size: 14px;
    text-transform: uppercase;
}

/* TITLE */
.doc-title {
    text-align: center;
    margin: 20px 0 5px;
}

.doc-title h1 {
    font-size: 16px;
    font-weight: bold;
    text-transform: uppercase;
    margin-bottom: 5px;
}

.doc-subtitle {
    text-align: center;
    font-style: italic;
    font-size: 12px;
    margin-bottom: 20px;
}

/* INFO */
.info-section {
    margin-bottom: 15px;
    text-align: justify;
}

.info-line {
    margin-bottom: 5px;
}

/* TABLE */
.table-container {
    margin: 15px 0;
}

table {
    width: 100%;
    border-collapse: collapse;
}

table, th, td {
    border: 1px solid #000;
}

th {
    padding: 8px 5px;
    text-align: center;
    font-weight: bold;
    background: #fff;
}

td {
    padding: 6px 5px;
}

.text-center { text-align: center; }
.text-right { text-align: right; }
.text-left { text-align: left; }

/* SUMMARY */
.summary-text {
    margin: 15px 0;
    text-align: right;
    line-height: 1.8;
}

.summary-text div {
    margin-bottom: 3px;
}

.total-amount {
    font-weight: bold;
    font-size: 14px;
    margin-top: 8px;
}

.amount-in-words {
    margin: 15px 0;
    font-style: italic;
    text-align: justify;
}

/* SIGNATURE */
.signature-section {
    margin-top: 30px;
}

.signature-row {
    display: table;
    width: 100%;
}

.signature-col {
    display: table-cell;
    width: 33.33%;
    text-align: center;
    vertical-align: top;
    padding: 0 10px;
}

.signature-title {
    font-weight: bold;
    margin-bottom: 5px;
}

.signature-note {
    font-style: italic;
    font-size: 11px;
    margin-bottom: 60px;
}

.signature-name {
    font-weight: bold;
}

/* FOOTER */
.footer-note {
    margin-top: 20px;
    font-size: 12px;
    text-align: center;
    font-style: italic;
}

@media print {
    body { 
        font-size: 13px;
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
    }
}
</style>
</head>

<body>

<!-- HEADER -->
<div class="header">
    <div class="header-left">
        <div class="company-name">SHOP BÁN HÀNG LARAVEL</div>
        <div>Địa chỉ: 123 Đường ABC, Quận 1, TP.HCM</div>
        <div>Điện thoại: 0909 000 111</div>
    </div>
    <div class="header-right">
        <div>Mẫu số: 01GTTT3/001</div>
        <div>Ký hiệu: AA/25T</div>
        <div>Số: {{ $order_details->first()->order_code }}</div>
    </div>
    <div class="clear"></div>
</div>

<!-- TITLE -->
<div class="doc-title">
    <h1>HÓA ĐƠN GIÁ TRỊ GIA TĂNG</h1>
    <div>(Bản thể hiện của hóa đơn điện tử)</div>
</div>

<div class="doc-subtitle">
    Ngày {{ date('d') }} tháng {{ date('m') }} năm {{ date('Y') }}
</div>

<!-- INFO -->
<div class="info-section">
    <div class="info-line"><strong>Họ tên người mua hàng:</strong> {{ $customer->customer_name }}</div>
    <div class="info-line"><strong>Địa chỉ:</strong> {{ $shipping->shipping_address }}</div>
    <div class="info-line"><strong>Điện thoại:</strong> {{ $customer->customer_phone }}</div>
    <div class="info-line"><strong>Hình thức thanh toán:</strong> {{ $shipping_method }}</div>
</div>

<!-- PRODUCTS TABLE -->
<div class="table-container">
    <table>
        <thead>
            <tr>
                <th width="5%">STT</th>
                <th width="35%">Tên hàng hóa, dịch vụ</th>
                <th width="10%">Đơn vị tính</th>
                <th width="10%">Số lượng</th>
                <th width="15%">Đơn giá</th>
                <th width="15%">Thành tiền</th>
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
                <td class="text-center">{{ $i++ }}</td>
                <td class="text-left">{{ $item->product_name }}</td>
                <td class="text-center">Cái</td>
                <td class="text-center">{{ $item->product_sales_quantity }}</td>
                <td class="text-right">{{ number_format($item->product_price,0,',','.') }}</td>
                <td class="text-right">{{ number_format($subtotal,0,',','.') }}</td>
            </tr>
            @endforeach
            @php
                $empty_rows = 10 - count($order_details);
                if ($empty_rows > 0) {
                    for ($j = 0; $j < $empty_rows; $j++) {
                        echo '<tr><td class="text-center">' . $i++ . '</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>';
                    }
                }
            @endphp
        </tbody>
    </table>
</div>

@php
$feeship = (float) ($order_details->first()->product_feeship ?? 0);
$discount_amount = (float) $discount;
$total_after_coupon = $total - $discount_amount + $feeship;
@endphp

<!-- SUMMARY -->
<div class="summary-text">
    <div>Cộng tiền hàng: <strong>{{ number_format($total,0,',','.') }}</strong> đồng</div>
    <div>Giảm giá: <strong>{{ number_format($discount_amount,0,',','.') }}</strong> đồng</div>
    <div>Phí vận chuyển: <strong>{{ number_format($feeship,0,',','.') }}</strong> đồng</div>
    <div class="total-amount">Tổng cộng tiền thanh toán: <strong>{{ number_format($total_after_coupon,0,',','.') }}</strong> đồng</div>
</div>

<div class="amount-in-words">
    <strong>Số tiền viết bằng chữ:</strong> 
    @php
        function convertNumberToWords($number) {
            $words = ['không', 'một', 'hai', 'ba', 'bốn', 'năm', 'sáu', 'bảy', 'tám', 'chín'];
            $units = ['', 'nghìn', 'triệu', 'tỷ'];
            
            if ($number == 0) return 'Không đồng';
            
            $result = '';
            $unitIndex = 0;
            
            while ($number > 0) {
                $group = $number % 1000;
                if ($group != 0) {
                    $groupWords = '';
                    $hundred = floor($group / 100);
                    $ten = floor(($group % 100) / 10);
                    $unit = $group % 10;
                    
                    if ($hundred > 0) {
                        $groupWords .= $words[$hundred] . ' trăm ';
                    }
                    
                    if ($ten > 1) {
                        $groupWords .= $words[$ten] . ' mươi ';
                        if ($unit > 0) {
                            $groupWords .= $words[$unit] . ' ';
                        }
                    } elseif ($ten == 1) {
                        $groupWords .= 'mười ';
                        if ($unit > 0) {
                            $groupWords .= $words[$unit] . ' ';
                        }
                    } else {
                        if ($unit > 0 && $hundred > 0) {
                            $groupWords .= 'lẻ ' . $words[$unit] . ' ';
                        } elseif ($unit > 0) {
                            $groupWords .= $words[$unit] . ' ';
                        }
                    }
                    
                    $result = $groupWords . $units[$unitIndex] . ' ' . $result;
                }
                $number = floor($number / 1000);
                $unitIndex++;
            }
            
            return ucfirst(trim($result)) . ' đồng chẵn';
        }
        
        echo convertNumberToWords($total_after_coupon);
    @endphp
</div>

<!-- SIGNATURE -->
<div class="signature-section">
    <div class="signature-row">
        <div class="signature-col">
            <div class="signature-title">Người mua hàng</div>
            <div class="signature-note">(Ký, ghi rõ họ tên)</div>
            <div class="signature-name">&nbsp;</div>
        </div>
        <div class="signature-col">
            <div class="signature-title">Người bán hàng</div>
            <div class="signature-note">(Ký, ghi rõ họ tên)</div>
            <div class="signature-name">&nbsp;</div>
        </div>
        <div class="signature-col">
            <div class="signature-title">Thủ quỹ</div>
            <div class="signature-note">(Ký, ghi rõ họ tên)</div>
            <div class="signature-name">&nbsp;</div>
        </div>
    </div>
</div>

<!-- FOOTER -->
<div class="footer-note">
    (Cần kiểm tra, đối chiếu khi lập, giao, nhận hóa đơn)
</div>

</body>
</html