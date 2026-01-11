@extends('layout')
@section('content')

<div class="container mt-4">
    <div class="edit-form-container">
        <h3 class="text-center mb-4">Chỉnh sửa thông tin người dùng</h3>

        {{-- Hiển thị lỗi Validation --}}
        @if ($errors->any())
            <div class="alert alert-danger p-2 small">
                <ul class="mb-0">
                    @foreach ($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('customer.update', $edit_customer->customer_id) }}" method="POST">
            @csrf
            
            <div class="mb-3">
                <label class="form-label small fw-bold">Tên customer</label>
                <input type="text" name="customer_name" class="form-control form-control-sm" 
                       value="{{ old('customer_name', $edit_customer->customer_name) }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label small fw-bold">Email</label>
                <input type="email" name="customer_email" class="form-control form-control-sm" 
                       value="{{ old('customer_email', $edit_customer->customer_email) }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label small fw-bold">Số điện thoại</label>
                <input type="text" name="customer_phone" class="form-control form-control-sm" 
                       value="{{ old('customer_phone', $edit_customer->customer_phone) }}">
            </div>

            <div class="mb-3">
                <label class="form-label small fw-bold">Mật khẩu mới</label>
                <div class="password-wrapper">
                    {{-- Thêm value="{{ old('customer_password') }}" --}}
                    <input type="password" name="customer_password" id="password" 
                        class="form-control form-control-sm" 
                        placeholder="Nhập mật khẩu mới" 
                        value="{{ old('customer_password') }}">
                    <i class="fas fa-eye toggle-password" onclick="togglePassword('password', this)"></i>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label small fw-bold">Xác nhận mật khẩu</label>
                <div class="password-wrapper">
                    {{-- Thêm value="{{ old('customer_password_confirmation') }}" --}}
                    <input type="password" name="customer_password_confirmation" id="password_confirm" 
                        class="form-control form-control-sm" 
                        placeholder="Nhập lại mật khẩu" 
                        value="{{ old('customer_password_confirmation') }}">
                    <i class="fas fa-eye toggle-password" onclick="togglePassword('password_confirm', this)"></i>
                </div>
            </div>

            

            <div class="text-center mt-4">
                <button onclick="return confirm('Xác nhận thay đổi thông tin?')" type="submit" class="btn btn-success btn-sm px-4">Lưu thay đổi</button>
                <a href="{{ route('/') }}" class="btn btn-secondary btn-sm px-4">Hủy bỏ</a>
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
    /* Làm form gọn lại và đẹp hơn */
    .edit-form-container { max-width: 650px; margin: 0 auto; background: #fff; padding: 25px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
</style>
@endsection