

@extends('admin_layout')
@section('admin_content')

<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                <h3>
                    <i class="fa fa-edit"></i> Cập nhật vai trò: 
                    <strong class="text-primary">{{ $role->role_name }}</strong>
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

                <form role="form" action="{{URL::to('/admin/update-role/'.$role->role_id)}}" method="post">
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Tên vai trò</label>
                                <input type="text" 
                                       class="form-control" 
                                       value="{{ $role->role_name }}" 
                                       disabled
                                       style="background-color: #f5f5f5; cursor: not-allowed;">
                                <small class="text-muted">
                                    <i class="fa fa-lock"></i> 
                                    Không thể thay đổi tên vai trò sau khi tạo
                                </small>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Trạng thái</label>
                                <select name="role_status" 
                                        class="form-control" 
                                        @if($role->role_name === 'admin') disabled @endif>
                                    <option value="1" @if($role->role_status == 1) selected @endif>
                                        Hoạt động
                                    </option>
                                    <option value="0" @if($role->role_status == 0) selected @endif>
                                        Vô hiệu hóa
                                    </option>
                                </select>
                                @if($role->role_name === 'admin')
                                    <small class="text-danger">
                                        <i class="fa fa-lock"></i> 
                                        Không thể vô hiệu hóa vai trò Admin
                                    </small>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="role_desc">
                            Mô tả vai trò <span class="text-danger">*</span>
                        </label>
                        <input type="text" 
                               class="form-control" 
                               id="role_desc"
                               name="role_desc" 
                               value="{{ $role->role_desc }}" 
                               required>
                    </div>

                    <hr style="border-top: 2px solid #ddd;">

                    <h4 style="margin-top: 20px;">
                        <i class="fa fa-key"></i> Phân quyền cho vai trò
                    </h4>
                    <p class="text-muted">Chọn các quyền mà vai trò này được phép thực hiện:</p>

                    @if($role->role_name === 'admin')
                        <div class="alert alert-warning">
                            <i class="fa fa-shield"></i> 
                            <strong>Vai trò Admin</strong> có toàn bộ quyền hệ thống, không cần phân quyền thủ công.
                        </div>
                    @else
                        <div class="panel panel-default">
                            <div class="panel-body" style="max-height: 500px; overflow-y: auto;">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover">
                                        <thead style="background: #f9f9f9;">
                                            <tr>
                                                <th width="200">
                                                    <i class="fa fa-folder-open"></i> Nhóm quyền
                                                </th>
                                                <th>
                                                    <i class="fa fa-list"></i> Các quyền
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($all_permissions as $group => $permissions)
                                            <tr>
                                                <td style="vertical-align: top; background: #fafafa;">
                                                    <strong style="font-size: 14px; text-transform: uppercase;">
                                                        {{ $group }}
                                                    </strong>
                                                    <br>
                                                    <small class="text-muted">
                                                        {{ count($permissions) }} quyền
                                                    </small>
                                                </td>
                                                <td>
                                                    <div class="row">
                                                        @foreach($permissions as $permission)
                                                        <div class="col-md-6" style="margin-bottom: 10px;">
                                                            <label class="checkbox-inline" style="font-weight: normal;">
                                                                <input type="checkbox" 
                                                                       name="permissions[]" 
                                                                       value="{{ $permission->permission_id }}"
                                                                       @if($role->permissions->contains($permission->permission_id)) checked @endif>
                                                                <strong>{{ $permission->permission_desc }}</strong>
                                                                <br>
                                                                <small class="text-muted">
                                                                    <code>{{ $permission->permission_name }}</code>
                                                                </small>
                                                            </label>
                                                        </div>
                                                        @endforeach
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="alert alert-info">
                            <i class="fa fa-info-circle"></i> 
                            <strong>Tổng số quyền đã chọn:</strong> 
                            <span id="selected-count">{{ $role->permissions->count() }}</span> quyền
                        </div>
                    @endif

                    <hr>

                    <button type="submit" class="btn btn-success btn-lg">
                        <i class="fa fa-save"></i> Cập nhật vai trò
                    </button>
                    <a href="{{URL::to('/admin/roles')}}" class="btn btn-default btn-lg">
                        <i class="fa fa-arrow-left"></i> Quay lại
                    </a>
                </form>
            </div>
        </section>
    </div>
</div>

<script>
// Đếm số checkbox được chọn
$(document).ready(function() {
    function updateCount() {
        var count = $('input[name="permissions[]"]:checked').length;
        $('#selected-count').text(count);
    }
    
    $('input[name="permissions[]"]').on('change', updateCount);
});
</script>

@endsection


