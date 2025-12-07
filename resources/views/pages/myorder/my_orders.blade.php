@extends('layout')
@section('content')

<div class="container">
    <h2>Đơn hàng của tôi</h2>
    @if(Session::has('message'))
        <p class="text-success">{{ Session::get('message') }}</p>
        {{ Session::forget('message') }}
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Đơn hàng</th>
                <th>Tên sản phẩm</th>
                <th>Hình ảnh</th>
                <th>Số lượng</th>
                <th>Giá</th>
                <th>Tổng</th>
                <th>Trạng thái</th>
                <th>Địa chỉ giao hàng</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
            <tr>
                <td>{{ $order->order_id }}</td>
                <td>{{ $order->product_name }}</td>
                <td><img src="{{ URL::to('public/uploads/product/'.$order->product_image) }}" width="80"></td>
                <td>{{ $order->product_sales_quantity }}</td>
                <td>{{ number_format($order->product_price) }} vnđ</td>
                <td>{{ number_format($order->product_price * $order->product_sales_quantity) }} vnđ</td>
                <td>
                    @php
                        switch($order->order_status){
                            case 0: echo 'Đang chờ xử lý'; break;
                            case 1: echo 'Đã xác nhận'; break;
                            case 2: echo 'Đang giao hàng'; break;
                            case 3: echo 'Đã giao hàng'; break;
                            case 4: echo 'Đã hủy'; break; 
                        }
                    @endphp
                </td>
                <td>
                    {{ $order->shipping_name }} <br>
                    {{ $order->shipping_phone }} <br>
                    {{ $order->shipping_address }} <br>
                    Ghi chú: {{ $order->shipping_notes }}
                    <br>
                    @if($order->order_status != 4)
                        <a href="{{ URL::to('/edit-shipping/'.$order->shipping_id) }}" class="btn btn-info btn-sm">Sửa</a>
                    @endif
                </td>
                <td>
                    @if($order->order_status == 0 || $order->order_status == 1)
                        <a onclick="return confirm('Bạn có chắc muốn hủy đơn hàng này?')" 
                           href="{{ URL::to('/cancel-order/'.$order->order_id) }}" 
                           class="btn btn-danger btn-sm">Hủy đơn</a>
                    @else
                        <p style="color:red;">Không thể hủy</p>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection
