@extends('layout')
@section('content')

<section id="checkout">
<div class="container">

    <!-- Breadcrumbs -->
    <div class="breadcrumbs">
        <ol class="breadcrumb">
            <li><a href="{{ URL::to('/') }}">Trang chủ</a></li>
            <li class="active">Thanh toán</li>
        </ol>
    </div>

    <h1>Vui lòng điền thông tin giao hàng</h1>

    <div class="checkout-row">

        <!-- Thông tin gửi hàng -->
        <div class="checkout-col bill-to">
            <h4>Thông tin gửi hàng</h4>
            <form action="{{ URL::to('/save-checkout-customer') }}" method="POST">
                {{ csrf_field() }}
                <input type="text" name="shipping_name" placeholder="Họ và tên" required>
                <input type="text" name="shipping_email" placeholder="Email" required>
                <input type="text" name="shipping_phone" placeholder="Phone" required>
                <input type="text" name="shipping_address" id="shipping_address" placeholder="Địa chỉ chi tiết" required>
                <textarea name="shipping_notes" placeholder="Ghi chú đơn hàng" rows="4"></textarea>
                <input type="submit" value="Gửi" name="send_order" class="btn btn-primary btn-sm">
            </form>
        </div>

        <!-- Giỏ hàng -->
        <div class="checkout-col order-summary">
            <h3>Sản phẩm của bạn</h3>
              @php $cart = Session::get('cart'); @endphp

            @if(!empty($cartContent) && count($cartContent) > 0)
            @php $total = 0; @endphp
            
            <p style="color:red;"><strong>Vui lòng xem kỹ thông tin trước khi thanh toán</strong></p>
            <div class="table-responsive cart_info">
                <table class="table table-vertical">
                    <tbody>
                        <tr>
                            <th>Tên SP</th>
                            @foreach($cartContent as $v_content)
                                <td>{{ $v_content->name }}</td>
                            @endforeach
                        </tr>
                        <tr>
                            <th>Hình</th>
                            @foreach($cartContent as $v_content)
                                <td><img src="{{ URL::to('public/uploads/product/'.$v_content->attributes->image) }}" class="cart-img" alt=""></td>
                            @endforeach
                        </tr>
                        <tr>
                            <th>Số lượng</th>
                            @foreach($cartContent as $v_content)
                                <td>{{ $v_content->quantity }}</td>
                            @endforeach
                        </tr>
                        <tr>
                            <th>Giá</th>
                            @foreach($cartContent as $v_content)
                                <td>{{ number_format($v_content->price, 0, ',', '.') }} VNĐ</td>
                            @endforeach
                        </tr>
                        <tr>
                            <th>Tổng tiền</th>
                            @foreach($cartContent as $v_content)
                                @php
                                    $subtotal = $v_content->price * $v_content->quantity;
                                    $total += $subtotal;
                                @endphp
                                <td>{{ number_format($subtotal, 0, ',', '.') }} VNĐ</td>
                            @endforeach
                        </tr>
                        <tr class="total-row">
                            <th>Tổng giỏ hàng</th>
                            <td colspan="{{ count($cartContent) }}">{{ number_format($total, 0, ',', '.') }} VNĐ</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            @else
                <p style="color:red;">Hiện tại không có sản phẩm nào trong giỏ hàng</p>
            @endif
        </div>

    </div>
</div>
</section>


<!-- ==========================
     Styles
========================== -->
<style>
:root {
    --primary-color: #0d6efd;
    --primary-color-hover: #0b5ed7;
    --success-color: red;
    --light-bg: #f5f5f5;
    --border-color: #e0e0e0;
    --card-bg: #fff;
    --card-radius: 12px;
    --card-padding: 25px;
    --transition-speed: 0.3s;
    --font-base: 0.95rem;
}

.checkout-row {
    display: flex;
    gap: 30px;
    flex-wrap: wrap;
}

.checkout-col {
    flex: 1;
    min-width: 300px;
    background: var(--card-bg);
    border-radius: var(--card-radius);
    padding: var(--card-padding);
    box-shadow: 0 10px 25px rgba(0,0,0,0.08);
    transition: transform var(--transition-speed) ease, box-shadow var(--transition-speed) ease;
}

.checkout-col:hover {
    transform: translateY(-3px);
    box-shadow: 0 15px 35px rgba(0,0,0,0.1);
}

/* Form input/select/textarea */
.bill-to form input,
.bill-to form select,
.bill-to form textarea {
    width: 100%;
    padding: 12px 15px;
    margin-bottom: 18px;
    border: 1px solid #ddd;
    border-radius: 10px;
    font-size: var(--font-base);
    transition: all var(--transition-speed) ease;
}

.bill-to form input:focus,
.bill-to form select:focus,
.bill-to form textarea:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 8px rgba(13,110,253,0.2);
    outline: none;
}

.bill-to form input[type="submit"] {
    background-color: var(--primary-color);
    color: #fff;
    font-weight: 600;
    border: none;
    border-radius: 10px;
    padding: 12px 0;
    font-size: 1rem;
    cursor: pointer;
    transition: all var(--transition-speed) ease;
}
.checkout-row {
    display: flex;
    gap: 30px;
    align-items: flex-start;
    flex-wrap: wrap;
}

.checkout-col {
    flex: 1;
    min-width: 350px;
    background: #fff;
    border-radius: 12px;
    padding: 25px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.08);
}

.bill-to input, .bill-to textarea {
    width: 100%;
    margin-bottom: 15px;
    padding: 12px;
    border: 1px solid #ddd;
    border-radius: 10px;
}

.bill-to input[type="submit"] {
    background-color: #0d6efd;
    color: #fff;
    border: none;
    border-radius: 10px;
    padding: 12px 0;
    cursor: pointer;
}

.order-summary {
    max-height: 500px;
    overflow-y: auto;
}

.table-vertical {
    width: 100%;
    border-collapse: collapse;
}

.table-vertical th, .table-vertical td {
    padding: 12px 10px;
    text-align: center;
    vertical-align: middle;
    border: 1px solid #e0e0e0;
}

.table-vertical th {
    width: 150px;
    text-align: left;
    background-color: #f8f9fa;
    font-weight: bold;
}

.cart-img {
    width: 80px;
    height: auto;
    border-radius: 5px;
    border: 1px solid #ddd;
}

.total-row th {
    background-color: #28a745;
    color: #fff;
}

.total-row td {
    font-weight: bold;
    color: #28a745;
}

@media (max-width: 991px) {
    .checkout-row {
        flex-direction: column;
    }
}


.bill-to form input[type="submit"]:hover {
    background-color: var(--primary-color-hover);
    transform: translateY(-2px);
}

/* Order summary table */
.order-summary {
    max-height: 480px;
    overflow-y: auto;
}

.order-summary table {
    width: 100%;
    border-collapse: collapse;
    font-size: var(--font-base);
    border: 1px solid var(--border-color);
}

.order-summary th,
.order-summary td {
    padding: 12px;
    text-align: center;
    vertical-align: middle;
    border: 1px solid var(--border-color);
}

.order-summary th {
    background-color: var(--light-bg);
    font-weight: 600;
    color: #333;
}

.order-summary td img {
    border-radius: 6px;
}

/* Table dọc (vertical) */
.table-vertical th {
    background-color: #f8f9fa;
    color: #333;
    font-weight: bold;
    text-align: left;
    width: 150px;
    padding: 10px;
    font-size: 16px;
}

.table-vertical td {
    text-align: center;
    vertical-align: middle;
    padding: 10px;
    font-size: 15px;
}

.table-vertical .cart-img {
    width: 80px;
    height: auto;
    border-radius: 5px;
    border: 1px solid #ddd;
}

.table-vertical .header-row th {
    background-color: var(--primary-color);
    color: #fff;
    font-size: 18px;
}

.table-vertical .total-row th {
    background-color: var(--success-color);
    color: #fff;
    font-size: 18px;
}

.table-vertical .total-row td {
    font-weight: bold;
    font-size: 17px;
    color: var(--success-color);
}

/* Responsive */
.cart_info {
    overflow-x: auto;
}

@media (max-width: 991px){
    .checkout-row {
        flex-direction: column;
    }
    .checkout-col {
        margin-bottom: 20px;
    }
}

@media (max-width: 768px) {
    .table-vertical th, 
    .table-vertical td {
        font-size: 14px;
        padding: 8px;
    }

    .table-vertical .header-row th {
        font-size: 16px;
    }

    .table-vertical .total-row th, 
    .table-vertical .total-row td {
        font-size: 15px;
    }
}

</style>

<!-- ==========================
     JS
========================== -->
<!-- Select2 CSS/JS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/css/select2.min.css" rel="stylesheet"/>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/js/select2.min.js"></script>

<script>
$(document).ready(function(){

    let data;

    // Initialize Select2
    $('#province,#district,#ward').select2({placeholder:"Chọn",allowClear:true,width:'100%'});

    // Load JSON tỉnh/thành
    $.getJSON("{{ asset('data/vietnam.json') }}", function(json){
        data = json;
        $("#province").append('<option value="">Chọn Tỉnh/Thành phố</option>');
        $.each(data,function(i,p){ $("#province").append('<option value="'+p.code+'">'+p.name+'</option>'); });
        $('#province').trigger('change.select2');
    });

    function updateFullAddress(){
        let detail = $("#shipping_address").data('detail') || "";
        let ward = $("#ward option:selected").text();
        let district = $("#district option:selected").text();
        let province = $("#province option:selected").text();
        let full = [detail,ward,district,province].filter(Boolean).join(", ");
        $("#shipping_address").val(full);
    }

    // Chọn tỉnh
    $("#province").change(function(){
        let code = $(this).val();
        $("#district,#ward").html('<option value="">Chọn</option>').val(null).trigger('change.select2');
        let province = data.find(p=>p.code==code);
        if(province){ $.each(province.districts,function(i,d){ $("#district").append('<option value="'+d.code+'">'+d.name+'</option>'); }); }
        $('#district').trigger('change.select2');
        updateFullAddress();
    });

    // Chọn huyện
    $("#district").change(function(){
        let provinceCode = $("#province").val();
        let districtCode = $(this).val();
        $("#ward").html('<option value="">Chọn</option>').val(null).trigger('change.select2');
        let province = data.find(p=>p.code==provinceCode);
        if(province){
            let district = province.districts.find(d=>d.code==districtCode);
            if(district){ $.each(district.wards,function(i,w){ $("#ward").append('<option value="'+w.code+'">'+w.name+'</option>'); }); }
        }
        $('#ward').trigger('change.select2');
        updateFullAddress();
    });

    // Chọn xã
    $("#ward").change(updateFullAddress);

    // Lưu chi tiết địa chỉ
    $("#shipping_address").on('input',function(){ $(this).data('detail',$(this).val().split(',')[0]); });

});
</script>
<script>
$(document).ready(function(){

    // Kiểm tra form trước khi submit
    $('form').on('submit', function(e){
        // Lấy giá trị các trường
        let email = $.trim($('input[name="shipping_email"]').val());
        let name = $.trim($('input[name="shipping_name"]').val());
        let phone = $.trim($('input[name="shipping_phone"]').val());
        let address = $.trim($('#shipping_address').val());
        let province = $('#province').val();
        let district = $('#district').val();
        let ward = $('#ward').val();

        // Kiểm tra các trường bắt buộc
        if(!email){
            alert("Vui lòng nhập Email");
            $('input[name="shipping_email"]').focus();
            e.preventDefault(); return false;
        }
        if(!name){
            alert("Vui lòng nhập Họ và tên");
            $('input[name="shipping_name"]').focus();
            e.preventDefault(); return false;
        }
        if(!phone){
            alert("Vui lòng nhập Phone");
            $('input[name="shipping_phone"]').focus();
            e.preventDefault(); return false;
        }
        if(!address){
            alert("Vui lòng nhập Địa chỉ chi tiết");
            $('#shipping_address').focus();
            e.preventDefault(); return false;
        }
        // if(!province){
        //     alert("Vui lòng chọn Tỉnh/Thành phố");
        //     $('#province').select2('open');
        //     e.preventDefault(); return false;
        // }
        // if(!district){
        //     alert("Vui lòng chọn Quận/Huyện");
        //     $('#district').select2('open');
        //     e.preventDefault(); return false;
        // }
        // if(!ward){
        //     alert("Vui lòng chọn Phường/Xã");
        //     $('#ward').select2('open');
        //     e.preventDefault(); return false;
        }

        // Nếu tất cả có giá trị, form sẽ submit bình thường
    });

});
</script>


@endsection
