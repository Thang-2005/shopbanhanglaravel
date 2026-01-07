@extends('admin_layout')
@section('admin_content')

<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                <h3>
                    <i class="fa fa-plus-circle"></i> Thêm vai trò mới
                </h3>
            </header>
            
            <div class="panel-body">
                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <h4><i class="fa fa-exclamation-triangle"></i> Lỗi validation!</h4>
                        <ul style="margin-bottom: 0;">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form role="form" action="{{URL::to('/admin/save-role')}}" method="post">
                    @csrf
                    
                    <div class="form-group">
                        <label for="role_name">
                            Tên vai trò <span class="text-danger">*</span>
                        </label>
                        <input type="text" 
                               class="form-control" 
                               id="role_name"
                               name="role_name" 
                               placeholder="Ví dụ: manager, editor, accountant..." 
                               value="{{ old('role_name') }}"
                               required>
                        <small class="text-muted">
                            <i class="fa fa-info-circle"></i> 
                            Chỉ dùng chữ thường, không dấu, không khoảng trắng (a-z, 0-9, _)
                        </small>
                    </div>

                    <div class="form-group">
                        <label for="role_desc">
                            Mô tả vai trò <span class="text-danger">*</span>
                        </label>
                        <input type="text" 
                               class="form-control" 
                               id="role_desc"
                               name="role_desc" 
                               placeholder="Ví dụ: Quản lý, Biên tập viên, Kế toán..." 
                               value="{{ old('role_desc') }}"
                               required>
                        <small class="text-muted">
                            <i class="fa fa-info-circle"></i> 
                            Tên hiển thị của vai trò (có thể dùng tiếng Việt có dấu)
                        </small>
                    </div>

                    <div class="form-group">
                        <div class="alert alert-info">
                            <i class="fa fa-lightbulb-o"></i> 
                            <strong>Lưu ý:</strong> Sau khi tạo vai trò, bạn có thể vào chỉnh sửa để phân quyền cụ thể.
                        </div>
                    </div>

                    <hr>

                    <button type="submit" class="btn btn-success btn-lg">
                        <i class="fa fa-save"></i> Lưu vai trò
                    </button>
                    <a href="{{URL::to('/admin/roles')}}" class="btn btn-default btn-lg">
                        <i class="fa fa-arrow-left"></i> Quay lại
                    </a>
                </form>
            </div>
        </section>
    </div>
</div>

@endsection