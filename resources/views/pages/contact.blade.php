@extends('layout')

@section('content')
<div class="container my-5">
    <h2 class="text-center mb-4">Liên hệ</h2>

    <!-- Bản đồ -->
   <div class="mb-5">
    <div class="ratio ratio-16x9">
        <iframe 
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3723.9114479797357!2d105.814323!3d21.037012!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3135abbf85cae0f7%3A0x89f34e66e4ae79e5!2zTmjDom4gTmfhu41jIFBow6Fw!5e0!3m2!1svi!2s!4v1700000000000!5m2!1svi!2s"
            width="600"
            height="450"
            style="border:0; border-radius: 8px;"
            allowfullscreen=""
            loading="lazy">
        </iframe>
    </div>
</div>

    <!-- Thông tin công ty + Form liên hệ -->
    <div class="row g-4">
        <!-- Thông tin công ty -->
        <div class="col-lg-6">
            <h5 class="mb-3 fw-bold">CÔNG TY TNHH THƯƠNG MẠI VÀ XUẤT NHẬP KHẨU LARAVEL</h5>
            <p><strong>Shop:</strong> {{ $info->info_address ?? '-' }}</p>
            <p><strong>Giấy phép kinh doanh số:</strong> {{ $info->license ?? '0109967476' }} (cấp ngày 15/04/2022)</p>
            <p><strong>Hotline 1:</strong> 0967.285.899 – Mr. Thắng</p>
            <!-- <p><strong>Hotline 2:</strong> 0967.183.288 – Mr. Phương</p> -->
            <p>{{ $info->info_contact ?? '' }}</p>
        </div>

        <!-- Form liên hệ  -->
</div>
@endsection
<style>
/* Card shadow, bo tròn */
.card {
    border-radius: 12px;
    overflow: hidden;
}
/* Tiêu đề */
h2, h5 {
    color: #222;
}

/* Card / Form bóng nhẹ */
form, .col-lg-6 p {
    font-size: 0.95rem;
    color: #555;
}

/* Form input đẹp */
.form-control {
    border-radius: 8px;
    padding: 10px;
}

/* Button */
.btn-primary {
    border-radius: 8px;
    padding: 10px;
    font-weight: 500;
    transition: all 0.3s ease;
}

.btn-primary:hover {
    transform: translateY(-2px);
}

/* Responsive map */
.ratio-16x9 iframe {
    border: 0;
    border-radius: 8px;
}

/* Tiêu đề */
.card-title {
    font-weight: 600;
    color: #333;
}

/* Map responsive */
.map-container iframe {
    width: 100%;
    height: 100%;
    border: 0;
    border-radius: 0 0 12px 12px;
}

/* Text info đẹp */
.card-body p {
    font-size: 0.95rem;
    color: #555;
    line-height: 1.5;
}

/* Hover hiệu ứng */
.card:hover {
    transform: translateY(-3px);
    transition: all 0.3s ease;
}

/* Responsive spacing */
@media (max-width: 767px) {
    .map-container {
        height: 300px;
    }
}
</style>
