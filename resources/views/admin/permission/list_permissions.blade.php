@extends('admin_layout')
@section('admin_content')

<div class="table-agile-info">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 style="display: inline-block;">
                <i class="fa fa-key"></i> Danh sách quyền hạn
            </h3>
            <a href="{{URL::to('/admin/add-permission')}}" class="btn btn-success pull-right">
                <i class="fa fa-plus"></i> Thêm quyền mới
            </a>
        </div>
        
        <div class="row w3-res-tb">
            <div class="col-sm-12">
                @if(Session::has('message'))
                    <div class="alert alert-success alert-dismissible" style="margin: 15px;">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <i class="fa fa-check-circle"></i> {{ Session::get('message') }}
                    </div>
                @endif
                @if(Session::has('error'))
                    <div class="alert alert-danger alert-dismissible" style="margin: 15px;">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <i class="fa fa-exclamation-triangle"></i> {{ Session::get('error') }}
                    </div>
                @endif
            </div>
        </div>

        @if($permissions->isEmpty())
            <div style="text-align: center; padding: 50px;">
                <i class="fa fa-inbox" style="font-size: 64px; color: #ccc;"></i>
                <p style="margin-top: 15px; color: #999; font-size: 16px;">Chưa có quyền nào</p>
                <a href="{{URL::to('/admin/add-permission')}}" class="btn btn-primary">
                    <i class="fa fa-plus"></i> Thêm quyền đầu tiên
                </a>
            </div>
        @else
            <div class="table-responsive">
                @foreach($permissions as $group => $perms)
                <div style="background: #f5f5f5; padding: 15px; margin-top: 10px; border-left: 4px solid #3498db;">
                    <h4 style="margin: 0;">
                        <i class="fa fa-folder-open"></i> 
                        Nhóm: <strong style="text-transform: uppercase;">{{ $group }}</strong>
                        <span class="label label-info">{{ count($perms) }} quyền</span>
                    </h4>
                </div>
                
                <table class="table table-striped b-t b-light table-hover">
                    <thead>
                        <tr style="background: #fafafa;">
                            <th style="width:50px;" class="text-center">STT</th>
                            <th>Tên quyền</th>
                            <th>Mô tả</th>
                            <th class="text-center">Vai trò sử dụng</th>
                            <th class="text-center" style="width:140px;">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $i = 1; @endphp
                        @foreach($perms as $permission)
                        <tr>
                            <td class="text-center">{{ $i++ }}</td>
                            <td>
                                <code style="font-size: 13px; background: #ecf0f1; padding: 5px 10px;">
                                    {{ $permission->permission_name }}
                                </code>
                            </td>
                            <td>{{ $permission->permission_desc }}</td>
                            <td class="text-center">
                                @if($permission->roles->count() > 0)
                                    @foreach($permission->roles as $role)
                                        <span class="label label-primary" style="margin: 2px;">
                                            {{ $role->role_desc }}
                                        </span>
                                    @endforeach
                                @else
                                    <span class="text-muted">
                                        <i>Chưa gán</i>
                                    </span>
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="{{URL::to('/admin/edit-permission/'.$permission->permission_id)}}" 
                                   class="btn btn-primary btn-sm" 
                                   title="Chỉnh sửa">
                                    <i class="fa fa-edit"></i>
                                </a>
                                
                                @if($permission->roles->count() == 0)
                                    <a href="{{URL::to('/admin/delete-permission/'.$permission->permission_id)}}" 
                                       class="btn btn-danger btn-sm" 
                                       title="Xóa"
                                       onclick="return confirm('Bạn có chắc muốn xóa quyền này?')">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                @else
                                    <button class="btn btn-danger btn-sm" 
                                            disabled 
                                            title="Không thể xóa (đang được sử dụng)">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @endforeach
            </div>
        @endif
    </div>
</div>

@endsection