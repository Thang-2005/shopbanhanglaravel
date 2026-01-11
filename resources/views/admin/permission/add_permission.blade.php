
@extends('admin_layout')
@section('admin_content')

<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                <h3>
                    <i class="fa fa-plus-circle"></i> Thêm quyền mới
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

                <form role="form" action="{{URL::to('/admin/save-permission')}}" method="post">
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="permission_name">
                                    Tên quyền <span class="text-danger">*</span>
                                </label>
                                <input type="text" 
                                       class="form-control" 
                                       id="permission_name"
                                       name="permission_name" 
                                       placeholder="Ví dụ: view_product, create_order..." 
                                       value="{{ old('permission_name') }}"
                                       required>
                                <small class="text-muted">
                                    <i class="fa fa-info-circle"></i> 
                                    Định dạng: <code>action_module</code> (chữ thường, gạch dưới)
                                </small>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="permission_group">
                                    Nhóm quyền
                                </label>
                                <input type="text" 
                                       class="form-control" 
                                       id="permission_group"
                                       name="permission_group" 
                                       list="groupList" 
                                       placeholder="Ví dụ: product, order, user..."
                                       value="{{ old('permission_group') }}">
                                <datalist id="groupList">
                                    @foreach($groups as $group)
                                        <option value="{{ $group }}">
                                    @endforeach
                                </datalist>
                                <small class="text-muted">
                                    <i class="fa fa-info-circle"></i> 
                                    Để trống hoặc chọn nhóm có sẵn
                                </small>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="permission_desc">
                            Mô tả quyền <span class="text-danger">*</span>
                        </label>
                        <input type="text" 
                               class="form-control" 
                               id="permission_desc"
                               name="permission_desc" 
                               placeholder="Ví dụ: Xem sản phẩm, Tạo đơn hàng..." 
                               value="{{ old('permission_desc') }}"
                               required>
                        <small class="text-muted">
                            <i class="fa fa-info-circle"></i> 
                            Mô tả rõ ràng để dễ hiểu khi phân quyền
                        </small>
                    </div>

                    <div class="form-group">
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                <i class="fa fa-lightbulb-o"></i> Gợi ý đặt tên quyền
                            </div>
                            <div class="panel-body">
                                <p><strong>Các action phổ biến:</strong></p>
                                <ul>
                                    <li><code>view_*</code> - Xem/Hiển thị</li>
                                    <li><code>create_*</code> - Tạo mới</li>
                                    <li><code>edit_*</code> hoặc <code>update_*</code> - Chỉnh sửa</li>
                                    <li><code>delete_*</code> - Xóa</li>
                                    <li><code>manage_*</code> - Quản lý toàn bộ</li>
                                </ul>
                                <p><strong>Ví dụ:</strong> 
                                    <code>view_product</code>, 
                                    <code>create_banner</code>, 
                                    <code>edit_coupon</code>, 
                                    <code>delete_order</code>
                                </p>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <button type="submit" class="btn btn-success btn-lg">
                        <i class="fa fa-save"></i> Lưu quyền
                    </button>
                    <a href="{{URL::to('/admin/permissions')}}" class="btn btn-default btn-lg">
                        <i class="fa fa-arrow-left"></i> Quay lại
                    </a>
                </form>
            </div>
        </section>
    </div>
</div>

@endsection