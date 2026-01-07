@extends('admin_layout')
@section('admin_content')

<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                <h3>
                    <i class="fa fa-edit"></i> Cập nhật quyền: 
                    <code class="text-primary" style="font-size: 16px;">{{ $permission->permission_name }}</code>
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

                <form role="form" action="{{URL::to('/admin/update-permission/'.$permission->permission_id)}}" method="post">
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Tên quyền</label>
                                <input type="text" 
                                       class="form-control" 
                                       value="{{ $permission->permission_name }}" 
                                       disabled
                                       style="background-color: #f5f5f5; cursor: not-allowed;">
                                <small class="text-muted">
                                    <i class="fa fa-lock"></i> 
                                    Không thể thay đổi tên quyền sau khi tạo
                                </small>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="permission_group">Nhóm quyền</label>
                                <input type="text" 
                                       class="form-control" 
                                       id="permission_group"
                                       name="permission_group" 
                                       value="{{ $permission->permission_group }}"
                                       list="groupList">
                                <datalist id="groupList">
                                    @foreach($groups as $group)
                                        <option value="{{ $group }}">
                                    @endforeach
                                </datalist>
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
                               value="{{ $permission->permission_desc }}" 
                               required>
                    </div>

                    <hr>

                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <strong><i class="fa fa-info-circle"></i> Quyền này đang được sử dụng bởi:</strong>
                        </div>
                        <div class="panel-body">
                            @if($permission->roles->count() > 0)
                                @foreach($permission->roles as $role)
                                    <span class="label label-primary" style="font-size: 13px; margin: 3px;">
                                        <i class="fa fa-shield"></i> {{ $role->role_desc }}
                                    </span>
                                @endforeach
                            @else
                                <span class="text-muted">
                                    <i class="fa fa-times-circle"></i> Chưa có vai trò nào sử dụng quyền này
                                </span>
                            @endif
                        </div>
                    </div>

                    @if($permission->roles->count() > 0)
                        <div class="alert alert-warning">
                            <i class="fa fa-exclamation-triangle"></i> 
                            <strong>Cảnh báo:</strong> Thay đổi quyền này sẽ ảnh hưởng đến 
                            <strong>{{ $permission->roles->count() }}</strong> vai trò đang sử dụng.
                        </div>
                    @endif

                    <hr>

                    <button type="submit" class="btn btn-success btn-lg">
                        <i class="fa fa-save"></i> Cập nhật quyền
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