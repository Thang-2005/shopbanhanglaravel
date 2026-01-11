@extends('admin_layout')
@section('admin_content')
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Thêm mã giảm giá
            </header>

          @if(session('message') || session('error'))
            <div id="flash-message"
                class="alert {{ session('error') ? 'alert-danger' : 'alert-success' }} text-center">
                {{ session('error') ?? session('message') }}
            </div>

            <script>
                setTimeout(() => {
                    const msg = document.getElementById('flash-message');
                    if (msg) msg.remove();
                }, 2000);
            </script>
        @endif

            <div class="panel-body">
                <div class="position-center">
                    <form action="{{ URL::to('/insert-coupon-code') }}" method="POST">
                        @csrf

                        <div class="form-group">
                            <label>Tên mã giảm giá</label>
                            <input type="text" name="coupon_name" class="form-control" placeholder="Tên mã giảm giá" required>
                        </div>

                        <div class="form-group">
                            <label>Mã giảm giá</label>
                            <input type="text" name="coupon_code" class="form-control" placeholder="Mã giảm giá" required>
                        </div>

                        <div class="form-group">
                            <label>Số lượng mã</label>
                            <input type="number" name="coupon_time" class="form-control" placeholder="Số lượng" required>
                        </div>

                        <div class="form-group">
                            <label>Tính năng mã</label>
                            <select name="coupon_condition" class="form-control" required>
                                <option value="">--Chọn--</option>
                                <option value="1">Giảm theo %</option>
                                <option value="2">Giảm theo tiền</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Nhập số % hoặc số tiền giảm</label>
                            <input type="number" name="coupon_number" class="form-control" placeholder="Số % hoặc tiền" required>
                        </div>

                        <button type="submit" class="btn btn-info">Thêm mã giảm giá</button>
                    </form>
                </div>
            </div>
        </section>
    </div>
</div>
@endsection
