@extends('layout')
@section('content')

<div class="container">
    <div class="breadcrumbs">
        <ol class="breadcrumb">
            <li><a href="{{URL::to('/')}}">Trang chủ</a></li>
            <li class="active">Sửa thông tin giao hàng</li>
        </ol>
    </div>

    <div class="register-req">
        <p>Điền thông tin giao hàng mới và nhấn Cập nhật</p>
    </div>

    <div class="shopper-informations">
        <div class="row">
            <div class="col-sm-12 clearfix">
                <div class="bill-to">
                    <div class="form-one">
                        <form action="{{ URL::to('/update-shipping/'.$shipping->shipping_id) }}" method="POST">
                            {{ csrf_field() }}
                            <input type="text" name="shipping_email" placeholder="Email" value="{{ $shipping->shipping_email }}">
                            <input type="text" name="shipping_name" placeholder="Họ và tên" value="{{ $shipping->shipping_name }}">
                            <input type="text" name="shipping_address" placeholder="Địa chỉ" value="{{ $shipping->shipping_address }}">
                            <input type="text" name="shipping_phone" placeholder="Phone" value="{{ $shipping->shipping_phone }}">
                            <textarea name="shipping_notes" placeholder="Ghi chú đơn hàng" rows="6">{{ $shipping->shipping_notes }}</textarea>
                            <input type="submit" value="Cập nhật" class="btn btn-primary btn-sm">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
