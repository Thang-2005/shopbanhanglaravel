@extends('admin_layout')
@section('admin_content')

<div class="container">
    <div class="form-container">
        <h3 class="text-center mb-4 text-uppercase">Thêm Admin Mới</h3>

        @if ($errors->any())
            <div class="alert alert-danger p-2 small">
                <ul class="mb-0">
                    @foreach ($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.save') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label small fw-bold">Tên Admin</label>
                <input type="text" name="admin_name" class="form-control form-control-sm" value="{{ old('admin_name') }}" required placeholder="Nhập họ tên...">
            </div>

            <div class="mb-3">
                <label class="form-label small fw-bold">Email (Tài khoản)</label>
                <input type="email" name="admin_email" class="form-control form-control-sm" value="{{ old('admin_email') }}" required placeholder="example@gmail.com">
            </div>

            <div class="mb-3">
                <label class="form-label small fw-bold">Số điện thoại</label>
                <input type="text" name="admin_phone" class="form-control form-control-sm" value="{{ old('admin_phone') }}" placeholder="0123...">
            </div>

            <div class="mb-3">
                <label class="form-label small fw-bold">Mật khẩu mới</label>
                <div class="password-wrapper">
                    {{-- Thêm value="{{ old('admin_password') }}" --}}
                    <input type="password" name="admin_password" id="password" 
                        class="form-control form-control-sm" 
                        placeholder="Nhập mật khẩu mới" 
                        value="{{ old('admin_password') }}">
                    <i class="fas fa-eye toggle-password" onclick="togglePassword('password', this)"></i>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label small fw-bold">Xác nhận mật khẩu</label>
                <div class="password-wrapper">
                    {{-- Thêm value="{{ old('admin_password_confirmation') }}" --}}
                    <input type="password" name="admin_password_confirmation" id="password_confirm" 
                        class="form-control form-control-sm" 
                        placeholder="Nhập lại mật khẩu" 
                        value="{{ old('admin_password_confirmation') }}">
                    <i class="fas fa-eye toggle-password" onclick="togglePassword('password_confirm', this)"></i>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label small fw-bold">Phân quyền</label>
                <select name="role_id" class="form-control form-control-sm" required>
                    <option value="">-- Chọn quyền --</option>
                    @foreach($roles as $role)
                        <option value="{{ $role->role_id }}" {{ old('role_id') == $role->role_id ? 'selected' : '' }}>
                            {{ $role->role_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="text-center mt-4">
                <button type="submit" class="btn btn-success btn-sm px-4">Thêm Admin</button>
                <a href="{{ route('admin.list') }}" class="btn btn-secondary btn-sm px-4">Hủy bỏ</a>
            </div>
        </form>
    </div>
</div>

<script>
function togglePassword(inputId, icon) {
    const input = document.getElementById(inputId);
    if (input.type === "password") {
        input.type = "text";
        icon.classList.replace('fa-eye', 'fa-eye-slash');
    } else {
        input.type = "password";
        icon.classList.replace('fa-eye-slash', 'fa-eye');
    }
}
</script>
<style>
    .password-wrapper { position: relative; }
    .password-wrapper .form-control { padding-right: 40px; }
    .toggle-password {
        position: absolute;
        right: 12px;
        top: 50%;
        transform: translateY(-50%);
        cursor: pointer;
        color: #666;
        z-index: 10;
        font-size: 0.85rem;
    }
    .toggle-password:hover { color: #333; }
    .form-container { max-width: 650px; margin: 20px auto; background: #fff; padding: 25px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
</style>
@endsection