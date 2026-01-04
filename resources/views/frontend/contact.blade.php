@extends('layout')
@section('content')
<div class="container">
    <h2>Liên hệ</h2>

    <div class="row">
        <div class="col-md-6">
            <h4>{{ $info->company_name ?? 'Tên công ty' }}</h4>
            <p>{!! nl2br(e($info->company_intro ?? '')) !!}</p>

            <p><strong>Địa chỉ:</strong><br> {!! nl2br(e($info->address ?? '')) !!}</p>
            <p><strong>Điện thoại:</strong> {{ $info->phone ?? '-' }}</p>
            <p><strong>Email:</strong> <a href="mailto:{{ $info->email ?? '' }}">{{ $info->email ?? '-' }}</a></p>
        </div>

        <div class="col-md-6">
            <h5>Bản đồ</h5>
            <div style="width:100%; height:400px;">
                {!! $info->info_map ?? '<p>Chưa có bản đồ</p>' !!}
            </div>
        </div>
    </div>
</div>
@endsection
