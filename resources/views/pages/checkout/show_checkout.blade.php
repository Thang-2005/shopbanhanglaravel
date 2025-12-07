@extends('layout')
@section('content')

<!-- ==========================
     Checkout Section
========================== -->
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
        <div class="checkout-col">
            <div class="bill-to">
                <h4>Thông tin gửi hàng</h4>

                <form action="{{ URL::to('/save-checkout-customer') }}" method="POST">
                    {{ csrf_field() }}

                    <input type="text" name="shipping_name" placeholder="Họ và tên" required>
                    <input type="text" name="shipping_email" placeholder="Email" required>
                    <input type="text" name="shipping_phone" placeholder="Phone" required>
                    <input type="text" name="shipping_address" id="shipping_address" placeholder="Địa chỉ chi tiết" required>
                    <!-- <select id="province" name="shipping_province" required> ... </select>
                    <select id="district" name="shipping_district" required> ... </select>
                    <select id="ward" name="shipping_ward" required> ... </select> -->
                    <textarea name="shipping_notes" placeholder="Ghi chú đơn hàng" rows="4"></textarea>

                    <input type="submit" value="Gửi" name="send_order" class="btn btn-primary btn-sm">
                </form>
            </div>
        </div>

        <!-- Giỏ hàng -->
        <div class="checkout-col">
            <div class="order-summary">
                <h4>Chi tiết giỏ hàng</h4>

                @php $cart = Session::get('cart'); @endphp

                @if(!empty($cart))
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Tên SP</th>
                            <th>Hình</th>
                            <th>SL</th>
                            <th>Giá</th>
                            <th>Tổng</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $total = 0; @endphp
                        @foreach($cart as $item)
                            @php $subtotal = $item['price'] * $item['quantity']; $total += $subtotal; @endphp
                            <tr>
                                <td>{{ $item['name'] }}</td>
                                <td><img src="{{ URL::to('public/uploads/product/'.$item['image']) }}" width="70"></td>
                                <td>{{ $item['quantity'] }}</td>
                                <td>{{ number_format($item['price']) }}đ</td>
                                <td>{{ number_format($subtotal) }}đ</td>
                            </tr>
                        @endforeach
                        <tr>
                            <td colspan="4"><b>Tổng đơn hàng</b></td>
                            <td><b>{{ number_format($total) }}đ</b></td>
                        </tr>
                    </tbody>
                </table>
                @else
                    <p style="color:red;">Giỏ hàng trống</p>
                @endif
            </div>
        </div>

    </div>
</div>
</section>

<!-- ==========================
     Styles
========================== -->
<style>
.checkout-row { display: flex; gap: 30px; flex-wrap: wrap; }
.checkout-col { flex:1; min-width:300px; background:#fff; border-radius:12px; padding:25px; box-shadow:0 10px 25px rgba(0,0,0,0.08); transition: transform 0.3s ease, box-shadow 0.3s ease; }
.checkout-col:hover { transform: translateY(-3px); box-shadow:0 15px 35px rgba(0,0,0,0.1); }
.bill-to form input, .bill-to form select, .bill-to form textarea { width:100%; padding:12px 15px; margin-bottom:18px; border:1px solid #ddd; border-radius:10px; font-size:0.95rem; transition: all 0.3s ease; }
.bill-to form input:focus, .bill-to form select:focus, .bill-to form textarea:focus { border-color:#0d6efd; box-shadow:0 0 8px rgba(13,110,253,0.2); outline:none; }
.bill-to form input[type="submit"] { background-color:#0d6efd; color:#fff; font-weight:600; border:none; border-radius:10px; padding:12px 0; font-size:1rem; cursor:pointer; transition: all 0.3s ease; }
.bill-to form input[type="submit"]:hover { background-color:#0b5ed7; transform:translateY(-2px); }
.order-summary table { width:100%; border-collapse:collapse; font-size:0.95rem; }
.order-summary th, .order-summary td { padding:12px; text-align:center; vertical-align:middle; }
.order-summary th { background-color:#f5f5f5; font-weight:600; color:#333; }
.order-summary td img { border-radius:6px; }
.order-summary { max-height:480px; overflow-y:auto; }
.order-summary table, .order-summary th, .order-summary td { border:1px solid #e0e0e0; }
@media (max-width:991px){ .checkout-row{flex-direction:column;} .checkout-col{margin-bottom:20px;} }
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
