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
                @csrf
                <input type="text" name="shipping_name" class="shipping_name" placeholder="Họ và tên" required>
                <input type="text" name="shipping_email" class="shipping_email" placeholder="Email" required>
                <input type="text" name="shipping_phone" class="shipping_phone" placeholder="Phone" required>
                <input type="text" name="shipping_address" class="shipping_address" id="shipping_address" placeholder="Địa chỉ chi tiết" required>
                <textarea name="shipping_notes" class="shipping_notes" placeholder="Ghi chú đơn hàng" rows="4"></textarea>

                @if(Session::get('fee'))
                <input type="hidden" name="order_fee" class="order_fee" value="{{ Session::get('fee') }}">
                @else
                <input type="hidden" name="order_fee" class="order_fee" value="25000">
                @endif

                @if(Session::get('coupon'))
                    @foreach(Session::get('coupon') as $key => $cou)
                <input type="hidden" name="order_coupon" class="order_coupon" value="{{ $cou['coupon_code']}}">
                    @endforeach
                @else
                <input type="hidden" name="order_coupon" class="order_coupon" value="no">
                @endif


                <div class="form_group">
                    <label for="exampleInputPassword1">Chọn hình thức thanh toán</label>
                    <select name="shipping_method" class="form-control input-sm m-bot15 payment_select">
                        <option value="1">Thanh toán khi nhận hàng</option>
                        <option value="2">Thanh toán chuyển khoản</option>
                    </select>
                </div>
                <input type="button" value="Gửi" name="send_order" class="btn btn-primary btn-sm send_order">

            </form>
                <div class="position-center">
                                    <form role="form" action="#" method="post">
                                        {{ csrf_field() }}
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Chọn thành phố</label>
                                    <select name="city" id="city" class="form-control input-sm m-bot15 choose city">
                                            <option value="">--Chọn thành phố--</option>
                                            @foreach($city as $key => $city)
                                                <option value="{{ $city->matp }}">{{ $city->name_tinh }}</option>
                                                @endforeach
                                        </select>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">--Chọn huyện--</label>
                                    <select name="province" id="province" class="form-control input-sm m-bot15 choose province">
                                            <option value="">--Chọn huyện--</option>
                                            @foreach($province as $key => $province)
                                                <option value="{{ $province->maqh }}">{{ $province->name_huyen }}</option>
                                                @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">--Chọn xã--</label>
                                        <select name="wards"  id="wards" class="form-control input-sm m-bot15 choose wards">
                                                <option value="">--Chọn xã--</option>
                                                @foreach($wards as $key => $wards)
                                                <option value="{{ $wards->maxa }}">{{ $wards->name_xa }}</option>
                                                @endforeach
                                            
                                                
                                        </select>
                                    </div>
                                                                
                                    <button type="button" name="calculate_devilevy" class="btn btn-info calculate_devilevy">Tính phí vận chuyển</button>
                                    </form>
                                    
                            </div>
        </div>
                               
           @php
    $cartItems = session('cart', []);
    $total = 0;
@endphp

{{-- Thông báo --}}
@php
    $message = Session::get('message');
    if ($message) {
        echo '<span class="text-alert" style="color:red;">'.$message.'</span>';
        Session::put('message', null);
    }
@endphp
@if(session('message'))
    <div class="alert alert-success">
        {{ alert(session('message')) }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger">
        {{ alert(session('error')) }}
    </div>
@endif

@if(!empty($cartItems))
{{-- FORM UPDATE GIỎ HÀNG --}}
<form action="{{route('cart.update')}}" method="POST">
@csrf
<table class="table-responsive cart_info">
    <thead>
        <tr class="cart_menu">
            <td class="image">Hình ảnh</td>
            <td class="description">Tên sp</td>
            <td class="price">Giá</td>
            <td class="quantity">Số lượng</td>
            <td class="total">Tổng</td>
            <td></td>
        </tr>
    </thead>
    <tbody>
    @foreach($cartItems as $item)
        @php
            $subtotal = $item['product_price'] * $item['product_qty'];
            $total += $subtotal;
        @endphp
        <tr>
            <td class="cart_product">
                <img src="{{ isset($item['product_image']) 
                    ? asset('public/uploads/product/'.$item['product_image']) 
                    : asset('public/uploads/no-image.png') }}"
                    width="90">
            </td>
            <td class="cart_description">
                <h4>{{ $item['product_name'] }}</h4>
            </td>
            <td class="cart_price">
                {{ number_format($item['product_price'],0,',','.') }} đ
            </td>
            <td class="cart_quantity">
                <input type="number"
                       min="1"
                       name="cart_qty[{{ $item['session_id'] }}]"
                       value="{{ $item['product_qty'] }}"
                       class="cart_quantity_input">
            </td>
            <td class="cart_total">
                {{ number_format($subtotal,0,',','.') }} đ
            </td>
            <td class="cart_delete">
                @if(!empty($item['session_id']))
                    <button type="button" 
                        onclick="if(confirm('Bạn có chắc muốn xóa sản phẩm này?')) { document.getElementById('delete-{{ $item['session_id'] }}').submit(); }" 
                        style="background:none;border:none;">
                        <i class="fa fa-times" style="color:red;"></i>
                    </button>

                @endif
            </td>
        </tr>
    @endforeach
    <tr>
        <td colspan="6">
            <button type="submit" class="btn btn-default check_out">Cập nhật giỏ hàng</button>
            <a class="btn btn-default check_out" href="{{route('cart.delete.all')}}">Xóa giỏ hàng</a>
            <a class="btn btn-default check_out" href="{{route('unset.coupon')}}">Xóa mã</a>
            <a class="btn btn-default check_out" href="{{route('unset.fee')}}">Xóa phí vận chuyển</a>


        </td>
    </tr>
    </tbody>
</table>
</form>
<section id="do_action">
    <div class="container">
        <div class="row">
            <div class="col-sm-6">
                <div class="total_area">
                    <h3>Thanh toán giỏ hàng</h3>
                    <ul>
                        <li>Tổng: <span>{{ number_format($total, 0, ',', '.') }} đ</span></li>
                        <li> Mã giảm giá:
                            <span> 
                            @if(Session::get('coupon'))
                                @foreach(Session::get('coupon') as $key => $cou)
                                    @if($cou['coupon_condition']==1)
                                       MÃ: {{ $cou['coupon_number'] }} % 
                                        <br>
                                        @php
                                            $total_coupon = ($total * $cou['coupon_number']) / 100;
                                            echo '  Giảm: '.number_format($total_coupon, 0, ',', '.').' đ<br>';
                                         
                                           
                                        @endphp
                                            <!-- <p>Tổng giảm:<spam>number_format( $total -= $total_coupon, 0, ',', '.').' đ</span></p> -->

                                    @elseif($cou['coupon_condition']==2)
                                         MÃ:{{ number_format($cou['coupon_number'], 0, ',', '.') }} đ 
                                        <br>
                                        @php
                                            $total_coupon = $cou['coupon_number'];
                                            
                                        @endphp
                                            <!-- <p>Tổng giảm:<spam>number_format( $total -= $total_coupon; , 0, ',', '.').' đ</span></p> -->
                                    
                                    @endif 
                                    
                                @endforeach   
                                </span>
                            @else
                                Không có mã
                            @endif
                        </li>
                        <li>Thuế: <span>{{ number_format($total*0.1, 0, ',', '.') }} đ</span></li>
                              @if(Session::has('fee'))
                                    <li>
                                        Phí vận chuyển:
                                        <span>{{ number_format(Session::get('fee'), 0, ',', '.') }} đ</span>
                                    </li>
                               @endif





                        <li>Thành tiền: 
<!--                            
                            @if(Session::get('coupon'))
                                <span>{{ number_format($total - $total_coupon + Session::get('fee'), 0, ',', '.') }} đ</span>
                            @else
                                <span>{{ number_format($total, 0, ',', '.') }} đ</span>
                            @endif -->
                             @if(Session::get('coupon')==0)
                                <span>{{ number_format($total +$total*0.1+ Session::get('fee'), 0, ',', '.') }} đ</span>
                             @elseif(Session::get('coupon') && Session::get('fee'))
                                <span>{{ number_format($total - $total_coupon + $total*0.1 +Session::get('fee'), 0, ',', '.') }} đ</span>
                             @elseif(Session::get('fee') == 0)
                                <span>{{ number_format($total - $total_coupon + $total*0.1, 0, ',', '.') }} đ</span>
                             @elseif(Session::get('coupon')==0 && Session::get('fee')==0)
                                <span>{{ number_format($total + $total*0.1, 0, ',', '.') }} đ</span>
                             @endif
                        </li>


                    </ul>

                    <div class="action-buttons">
                        <a class="btn btn-checkout" href="{{ URL::to('/checkout') }}">Thanh toán</a>

                        {{-- Form áp dụng mã giảm giá --}}
                        <form action="{{ route('check_coupon') }}" method="POST" class="coupon-form">
                            @csrf
                            <div class="coupon-input-group">
                                <input type="text" name="coupon_code" class="form-control" placeholder="Nhập mã giảm giá" required>
                                <button type="submit" class="btn btn-apply">Áp dụng mã</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@else
    <div class="alert alert-info">
        Giỏ hàng của bạn đang trống.
    </div>
@endif
     

{{-- FORM DELETE ĐỘC LẬP --}}
@foreach($cartItems as $item)
    @if(!empty($item['session_id']))
        <form id="delete-{{ $item['session_id'] }}" 
              action="{{ route('cart.delete', $item['session_id']) }}" 
              method="POST" style="display:none;">
            @csrf
            @method('DELETE')
        </form>
    @endif
@endforeach
                 
       

        <!-- Giỏ hàng -->
        <!-- <div class="checkout-col order-summary">
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
        </div> -->

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



@endsection
