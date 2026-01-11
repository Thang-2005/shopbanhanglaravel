@extends('layout')
@section('content')

<section id="cart_items">
    <div class="container">
        <div class="breadcrumbs">
            <ol class="breadcrumb">
              <li><a href="{{URL::to('/')}}">Trang chủ</a></li>
              <li class="active">Giỏ hàng của bạn</li>
            </ol>
        </div>
        @if(Session::has('message'))
    <div class="alert alert-success">
        {{ Session::get('message') }}
        @php
            Session::forget('message');
        @endphp
    </div>
@endif
    @if(!empty($cartContent) && count($cartContent) > 0)
        <div class="table-responsive cart_info">
            @foreach($cartContent as $v_content)
            <table class="table table-condensed">
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
                    
                    <tr>
                        <td class="cart_product">
                            <a href=""><img src="{{URL::to('public/uploads/product/'.$v_content->attributes->image)}}" width="90" alt="" /></a>
                        </td>
                        <td class="cart_description">
                            <h4><a href="">{{$v_content->name}}</a></h4>
                            <p>Web ID: {{$v_content->id}}</p>
                        </td>
                        <td class="cart_price">
                            <p>{{number_format($v_content->price).' '.'vnđ'}}</p>
                        </td>
                        <td class="cart_quantity">
                            <div class="cart_quantity_button">
                                <form action="{{URL::to('/update-cart-quantity')}}" method="POST">
                                {{ csrf_field() }}
                                <input class="cart_quantity_input" type="number" min="1" name="cart_quantity" value="{{$v_content->quantity}}"  >
                                <input type="hidden" value="{{$v_content->id}}" name="rowId_cart" class="form-control">
                                <input type="submit" value="Cập nhật" name="update_qty" class="btn btn-default btn-sm">
                                </form>
                            </div>
                        </td>
                        <td class="cart_total">
                            <p class="cart_total_price">
                                {{ number_format($v_content->price * $v_content->quantity).' '.'vnđ' }}
                            </p>
                        </td>
						<td class="cart_delete">
							<a class="cart_quantity_delete" 
							href="{{ URL::to('/delete-to-cart/'.$v_content->id) }}" 
							onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này khỏi giỏ hàng?');">
							<i class="fa fa-times" style="color:red;"></i>
							</a>
						</td>

                    </tr>
                   
                </tbody>
            </table>
            @endforeach
        </div>
        @else
                <h3 style="color:red;">Hiện tại không có sản phẩm nào trong giỏ hàng</h3>
            @endif
        
    </div>
    
    
</section> <!--/#cart_items-->

<section id="do_action">
    <div class="container">
    
        <div class="row">
        
            <div class="col-sm-6">
                <div class="total_area">
                                    @php
                        $total = Cart::getTotal();
                        $tax = $total * 0.1; // ví dụ 10% thuế
                        $grandTotal = $total + $tax;
                    @endphp

                    <ul>
                        <li>Tổng <span>{{ number_format($total).' '.'vnđ' }}</span></li>
                        <li>Thuế <span>{{ number_format($tax).' '.'vnđ' }}</span></li>
                        <li>Phí vận chuyển <span>Free</span></li>
                        <li>Thành tiền <span>{{ number_format($grandTotal).' '.'vnđ' }}</span></li>
                    </ul>

                    
                    @if(Session::get('customer_id'))
                    
                        <a class="btn btn-default check_out" href="{{ URL::to('/checkout') }}">Thanh toán</a>
                    @else
                        <a class="btn btn-default check_out" href="{{ URL::to('/login-checkout') }}">Thanh toán</a>
                    @endif  
                    
                </div>
            </div>
        </div>
    </div>
</section><!--/#do_action-->

@endsection
