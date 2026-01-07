@extends('admin_layout')
@section('admin_content')

<div class="table-agile-info">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 style="display: inline-block;">
                <i class="fa fa-shield"></i> Danh sách vai trò
            </h3>
            <a href="{{URL::to('/admin/add-role')}}" class="btn btn-success pull-right">
                <i class="fa fa-plus"></i> Thêm vai trò mới
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

        <div class="table-responsive">
            <table class="table table-striped b-t b-light table-hover">
                <thead>
                    <tr style="background: #f5f5f5;">
                        <th style="width:50px;" class="text-center">STT</th>
                        <th>Tên vai trò</th>
                        <th>Mô tả</th>
                        <th class="text-center">Số quyền</th>
                        <th class="text-center">Số người dùng</th>
                        <th class="text-center">Trạng thái</th>
                        <th class="text-center" style="width:180px;">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @php $i = 1; @endphp
                    @forelse($roles as $role)
                    <tr>
                        <td class="text-center">{{ $i++ }}</td>
                        <td>
                            <strong style="font-size: 14px;">{{ $role->role_name }}</strong>
                            @if($role->role_name === 'admin')
                                <span class="label label-danger">Super Admin</span>
                            @endif
                        </td>
                        <td>{{ $role->role_desc }}</td>
                        <td class="text-center">
                            <span class="label label-info" style="font-size: 12px;">
                                <i class="fa fa-key"></i> {{ $role->permissions_count }} quyền
                            </span>
                        </td>
                        <td class="text-center">
                            <span class="label label-primary" style="font-size: 12px;">
                                <i class="fa fa-users"></i> {{ $role->admins_count }} người
                            </span>
                        </td>
                        <td class="text-center">
                            @if($role->role_status == 1)
                                <span class="label label-success">
                                    <i class="fa fa-check-circle"></i> Hoạt động
                                </span>
                            @else
                                <span class="label label-warning">
                                    <i class="fa fa-times-circle"></i> Vô hiệu
                                </span>
                            @endif
                        </td>
                        <td class="text-center">
                            <a href="{{URL::to('/admin/edit-role/'.$role->role_id)}}" 
                               class="btn btn-primary btn-sm" 
                               title="Chỉnh sửa">
                                <i class="fa fa-edit"></i>
                            </a>
                            
                            @if($role->role_status == 1 && $role->role_name !== 'admin')
                                <a href="{{URL::to('/admin/unactive-role/'.$role->role_id)}}" 
                                   class="btn btn-warning btn-sm" 
                                   title="Vô hiệu hóa"
                                   onclick="return confirm('Vô hiệu hóa vai trò này?')">
                                    <i class="fa fa-ban"></i>
                                </a>
                            @elseif($role->role_status == 0)
                                <a href="{{URL::to('/admin/active-role/'.$role->role_id)}}" 
                                   class="btn btn-success btn-sm" 
                                   title="Kích hoạt">
                                    <i class="fa fa-check"></i>
                                </a>
                            @else
                                <button class="btn btn-warning btn-sm" disabled title="Không thể vô hiệu">
                                    <i class="fa fa-ban"></i>
                                </button>
                            @endif
                            
                            @if($role->role_name !== 'admin' && $role->admins_count == 0)
                                <a href="{{URL::to('/admin/delete-role/'.$role->role_id)}}" 
                                   class="btn btn-danger btn-sm" 
                                   title="Xóa"
                                   onclick="return confirm('Bạn có chắc muốn xóa vai trò này?')">
                                    <i class="fa fa-trash"></i>
                                </a>
                            @else
                                <button class="btn btn-danger btn-sm" 
                                        disabled 
                                        title="Không thể xóa">
                                    <i class="fa fa-trash"></i>
                                </button>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center" style="padding: 30px;">
                            <i class="fa fa-inbox" style="font-size: 48px; color: #ccc;"></i>
                            <p style="margin-top: 10px; color: #999;">Chưa có vai trò nào</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection