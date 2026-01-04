@extends('layout') {{-- hoặc layout admin của bạn --}}

@section('admin_content')
<div class="container">
    <h3>Thông tin liên hệ & bản đồ</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('admin.contact.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label">Tên công ty</label>
            <input type="text" name="company_name" class="form-control" value="{{ old('company_name', $info->company_name ?? '') }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Giới thiệu công ty</label>
            <textarea name="company_intro" rows="5" class="form-control">{{ old('company_intro', $info->company_intro ?? '') }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Địa chỉ</label>
            <textarea name="address" rows="3" class="form-control">{{ old('address', $info->address ?? '') }}</textarea>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Số điện thoại</label>
                <input type="text" name="phone" class="form-control" value="{{ old('phone', $info->phone ?? '') }}">
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email', $info->email ?? '') }}">
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Nhúng Google Map (iframe)</label>
            <textarea name="info_map" rows="5" class="form-control" placeholder="<iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d7452.243076030728!2d105.72463290000002!3d20.947633800000006!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1svi!2s!4v1764618351102!5m2!1svi!2s"
style="width:100%; height:400px; border:0;" 
allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
">{{ old('info_map', $info->info_map ?? '') }}</textarea>
            <small class="form-text text-muted">Lấy iframe từ Google Maps → Chia sẻ → Nhúng bản đồ → copy iframe</small>
        </div>

        <button class="btn btn-primary" type="submit">Lưu</button>
    </form>

    <hr>

    <h5>Xem trước bản đồ</h5>
    <div style="min-height:300px;">
        {!! $info->info_map ?? '<p>Chưa có bản đồ</p>' !!}
    </div>
</div>
@endsection
