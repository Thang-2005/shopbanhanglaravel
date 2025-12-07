<!DOCTYPE html>
<html>
<head>
    <title>Đăng ký Auth</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="{{ asset('public/backend/css/bootstrap.min.css') }}">
    <link href="{{ asset('public/backend/css/style.css') }}" rel="stylesheet" type="text/css" />
</head>
<body>
<div class="log-w3">
    <div class="w3layouts-main">
        <h2>Đăng nhập</h2>

        {{-- Hiển thị lỗi validate --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        {{-- Thông báo thành công --}}
        @if(session('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif

        <form action="{{ url('/login') }}" method="POST">
            @csrf
            <input type="email" class="ggg" name="admin_email" value="{{ old('admin_email') }}" placeholder="Nhập email" required>
            <input type="password" class="ggg" name="admin_password" placeholder="Nhập mật khẩu" required>

            <div style="margin: 10px 0;">
                <label>
                    <input type="checkbox"> Nhớ đăng nhập
                </label>
            </div>

            <input type="submit" value="Đăng nhập" class="btn btn-primary" style="width:100%;">
        </form>

        <div style="margin-top: 10px;">
            <a href="{{ url('/register-auth') }}">Đăng ký auth</a>
            <a href="{{ url('/login-auth') }}">Đăng nhập auth</a>
        </div>

    </div>
</div>
</body>
</html>
