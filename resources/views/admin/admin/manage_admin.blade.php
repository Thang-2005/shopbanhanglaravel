@extends('admin_layout')

@section('admin_content')
<div class="container-fluid">
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
    <!-- Tiêu đề -->
   <div class="row mb-4">
    <div class="col-12">
        <div class="page-header d-flex justify-content-between align-items-center shadow-sm">
            <h3 class="fw-bold mb-0">
                <i class="fa fa-users"></i> Quản lý người dùng
            </h3>

            <a href="{{ route('admin.add') }}" class="btn-add-admin">
                <i class="fa fa-plus-circle me-2"></i> Thêm admin mới
            </a>
        </div>
    </div>
</div>

    <!-- Bảng dữ liệu -->
    <div class="card shadow-sm">
        <div class="card-header bg-light">
            <strong>Danh sách admin</strong>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-dark text-center">
                        <tr>
                            <th style="width: 80px">ID</th>
                            <th>Tên</th>
                            <th>Email</th>
                            <th>SDT</th>
                            <th>Password</th>

                            <th style="width: 150px">Role</th>
                            <th style="width: 120px">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $i=1;@endphp
                        @forelse($admins as $a)
                        <tr>
                            <td class="text-center">{{ $i++}}</td>

                            <td>{{ $a->admin_name }}</td>
                            <td>{{ $a->admin_email }}</td>
                            <td>{{ $a->admin_phone }}</td>
                            <td>{{ $a->admin_password }}</td>


                            <td class="text-center">
                                @if($a->role)
                                    <span class="badge bg-success">
                                        {{ $a->role->role_name }}
                                    </span>
                                @else
                                    <span class="badge bg-secondary">
                                        Chưa có role
                                    </span>
                                @endif
                            </td>
                            

                            <td class="text-center">
                                <a href="{{ route('edit.admin', $a->admin_id) }}" class="btn btn-sm btn-warning">
                                        Sửa
                                    </a>
                                @if(!$a->is_super) {{-- Không hiện nút xóa admin chính --}}
                                <form action="{{ route('admin.delete', $a->admin_id) }}" method="POST" style="display:inline;"
                                    onsubmit="return confirm('Bạn có chắc muốn xóa admin này?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        Xóa
                                    </button>
                                </form>

                                @endif
                            </td>

                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">
                                Không có dữ liệu
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection
<style>
    .container-fluid {
        background-color: #fff;
    }
    /* Container chứa tiêu đề và nút */
.page-header {
    background-color: #f8f9fa; /* Màu nền xám nhạt cực nhẹ */
    padding: 15px 20px;
    border-radius: 10px;
    border-left: 5px solid #007bff; /* Vạch xanh bên trái tạo điểm nhấn */
}

/* Hiệu ứng cho tiêu đề */
.page-header h3 {
    font-size: 1.5rem;
    color: #333;
    display: flex;
    align-items: center;
}

.page-header h3 i {
    margin-right: 12px;
    color: #007bff;
}

/* Tùy chỉnh nút "Thêm admin" */
.btn-add-admin {
    background: linear-gradient(135deg, #007bff, #0056b3); /* Màu gradient xanh */
    color: white !important;
    border: none;
    padding: 8px 20px;
    border-radius: 50px; /* Bo tròn kiểu viên thuốc */
    font-weight: 600;
    transition: all 0.3s ease; /* Chuyển động mượt mà */
    text-decoration: none;
    display: inline-flex;
    align-items: center;
}

.btn-add-admin:hover {
    transform: translateY(-2px); /* Bay nhẹ lên khi hover */
    box-shadow: 0 5px 15px rgba(0, 123, 255, 0.4); /* Đổ bóng xanh */
    background: linear-gradient(135deg, #0056b3, #004085);
}

.btn-add-admin i {
    font-size: 1.1rem;
}
</style>
