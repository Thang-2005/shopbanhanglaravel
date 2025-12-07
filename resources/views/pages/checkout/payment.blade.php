@extends('layout')
@section('content')

<section id="cart_items">
		<div class="container">
	<h3>Giỏ hàng của bạn</h3>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Hình ảnh</th>
            <th>Tên sản phẩm</th>
            <th>Giá</th>
            <th>Số lượng</th>
            <th>Tổng</th>
        </tr>
    </thead>
    <tbody>
        @foreach($cartContent as $item)
        <tr>
            <td><img src="{{ URL::to('public/uploads/product/'.$item->attributes->image) }}" width="80"></td>
            <td>{{ $item->name }}</td>
            <td>{{ number_format($item->price).' vnđ' }}</td>
            <td>{{ $item->quantity }}</td>
            <td style="color:red;">{{ number_format($item->price * $item->quantity).' vnđ' }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<h3 style="color:red;"><strong>Tổng: {{ number_format(\Cart::getTotal()).' vnđ' }}</trong></h3>

			<h4 style="margin:40px 0;font-size: 20px;">Chọn hình thức thanh toán</h4>
			<form method="POST" action="{{URL::to('/order-place')}}">
				{{ csrf_field() }}
			<div class="payment-options">
					<span>
						<label><input name="payment_option" value="1" type="checkbox"> Trả bằng thẻ ATM</label>
					</span>
					<span>
						<label><input name="payment_option" value="2" type="checkbox"> Nhận tiền mặt</label>
					</span>
					<span>
						<label><input name="payment_option" value="3" type="checkbox"> Thanh toán thẻ ghi nợ</label>
					</span>
					<input type="submit" value="Đặt hàng" name="send_order_place" class="btn btn-primary btn-sm">
			</div>
			</form>
		</div>
	</section> <!--/#cart_items-->

@endsection