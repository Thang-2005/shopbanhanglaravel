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
                <th>Ghi chú</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orderDetails as $key =>$ord)
            <tr>
                <td>{{ $ord->order_details_id }}</td>
                <td>{{ $ord->product_name }}</td>
               
                <td> <img src="public/uploads/product/{{ $ord->product_image }}"  width="80"></td>
               
                <td>{{ $ord->product_sales_quantity }}</td>
                <td>{{ number_format($ord->product_price) }} vnđ</td>
                <td>{{ number_format($ord->product_price * $ord->product_sales_quantity) }} vnđ</td>
                <td>
                    @php
                        switch($ord->order_status){
                            case 0: echo 'Đang chờ xử lý'; break;
                            case 1: echo 'Đã xác nhận'; break;
                            case 2: echo 'Đang giao hàng'; break;
                            case 3: echo 'Đã giao hàng'; break;
                            case 4: echo 'Đã hủy'; break; 
                        }
                    @endphp
                </td>
                <td>
                    Tên khách hàng: {{ $ord->shipping_name }} <br>
                    SDT: {{ $ord->shipping_phone }} <br>
                    Địa chỉ: {{ $ord->shipping_address }} <br>
                    
                
                    <br>
                    @if($ord->order_status != 4)
                        <a href="{{ URL::to('/edit-shipping/'.$ord->shipping_id) }}" class="btn btn-info btn-sm">Sửa</a>
                    @endif
                </td>
                <td> {{ $ord->shipping_notes }}</td><br>
                <td>
                    @if($ord->order_status == 0 || $ord->order_status == 1)
                        <a onclick="return confirm('Bạn có chắc muốn hủy đơn hàng này?')" 
                           href="{{ URL::to('/-order/'.$ord->order_id) }}" 
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
