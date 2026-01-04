@extends('layout')
@section('content')

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
        {{ session('message') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
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
            
        </td>
         
    </tr>
    </tbody>
</table>
</form>
     

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

{{-- TỔNG TIỀN --}}
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
                        <li>Thuế: <span>0 đ</span></li>
                        <li>Phí vận chuyển: <span>0 đ</span></li>
                        <li>Thành tiền: 
                           
                            @if(Session::get('coupon'))
                                <span>{{ number_format($total - $total_coupon, 0, ',', '.') }} đ</span>
                            @else
                                <span>{{ number_format($total, 0, ',', '.') }} đ</span>
                            @endif
                        </li>


                    </ul>

                    <div class="action-buttons">
                       
                        @if(Session::get('customer'))
                      <a class="btn btn-checkout" href="{{ route('checkout') }}">Thanh toán</a>
                        @else
                          <a class="btn btn-checkout" href="{{ route('login.checkout') }}">Thanh toán</a>
                         @endif

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
    <h3 style="text-align:center; color:red;">Giỏ hàng trống, vui lòng thêm sản phẩm</h3>
@endif
@endsection

<style>
    .total_area {
    background: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 3px 15px rgba(0,0,0,0.05);
    margin-top: 20px;
}

.total_area h3 {
    margin-bottom: 15px;
    font-size: 20px;
    color: #333;
    font-weight: 600;
}

.total_area ul {
    list-style: none;
    padding: 0;
    margin-bottom: 15px;
}

.total_area ul li {
    display: flex;
    justify-content: space-between;
    font-size: 16px;
    margin-bottom: 8px;
    font-weight: 500;
}

.total_area ul li span {
    color: #ff6600;
    font-weight: 700;
}

.action-buttons {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.btn-checkout {
    background: #28a745;
    color: #fff;
    padding: 10px 25px;
    border-radius: 6px;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s;
    display: inline-block;
    text-align: center;
}

.btn-checkout:hover {
    background: #218838;
}

/* Coupon form */
.coupon-form {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.coupon-input-group {
    display: flex;
    gap: 10px;
}

.coupon-input-group input.form-control {
    flex: 1;
    padding: 8px 10px;
    border-radius: 6px;
    border: 1px solid #ccc;
    transition: all 0.3s;
}

.coupon-input-group input.form-control:focus {
    border-color: #ff6600;
    box-shadow: 0 0 5px rgba(255,102,0,0.3);
    outline: none;
}

.coupon-input-group .btn-apply {
    background: #007bff;
    color: #fff;
    border: none;
    padding: 8px 20px;
    border-radius: 6px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s;
}

.coupon-input-group .btn-apply:hover {
    background: #0069d9;
}

/* Responsive */
@media (max-width: 768px) {
    .total_area ul li {
        font-size: 14px;
    }
    .coupon-input-group {
        flex-direction: column;
    }
    .coupon-input-group .btn-apply {
        width: 100%;
    }
}

/* Bảng giỏ hàng */
.cart_info {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 30px;
}
.cart_info th,
.cart_info td {
    padding: 12px 10px;
    text-align: center;
    border-bottom: 1px solid #ddd;
    vertical-align: middle;
}
.cart_info th {
    background-color: #f8f8f8;
    color: #333;
    font-weight: 600;
    text-transform: uppercase;
}
.cart_info img {
    max-width: 80px;
    border-radius: 5px;
}
/* Input số lượng */
.cart_quantity_input {
    width: 60px;
    text-align: center;
    border: 1px solid #ccc;
    border-radius: 4px;
    padding: 5px;
}
/* Nút xóa sản phẩm */
.cart_delete i {
    color: #ff4d4f;
    font-size: 16px;
    transition: all 0.3s;
}
.cart_delete i:hover {
    color: #d60000;
    transform: scale(1.2);
}
/* Tổng tiền */
.total_area {
    background: #fff;
    padding: 20px;
    border: 1px solid #eee;
    box-shadow: 0 0 10px rgba(0,0,0,0.05);
    border-radius: 6px;
}
.total_area ul {
    list-style: none;
    padding: 0;
}
.total_area ul li {
    display: flex;
    justify-content: space-between;
    margin-bottom: 10px;
    font-weight: 500;
    font-size: 16px;
}
.total_area ul li span {
    font-weight: 700;
    color: #ff6600;
}
/* Nút thanh toán */
.check_out {
    display: inline-block;
    background-color: #ff6600;
    color: #fff;
    padding: 10px 25px;
    margin-top: 15px;
    text-transform: uppercase;
    font-weight: 600;
    border-radius: 5px;
    transition: all 0.3s;
}
.check_out:hover {
    background-color: #e65c00;
    text-decoration: none;
}
/* Responsive */
@media (max-width: 768px) {
    .cart_info th, .cart_info td {
        font-size: 14px;
        padding: 8px;
    }
    .cart_quantity_input {
        width: 50px;
    }
/* --- LỖI --- Thiếu dấu đóng } của media query */
}
</style>
