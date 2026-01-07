@extends('admin_layout')
@section('admin_content')
<div class="table-agile-info" style="padding: 20px;">
    <div class="panel panel-default" style="border-radius: 15px; border: none; box-shadow: 0 5px 25px rgba(0,0,0,0.08);">
        
        <div class="panel-heading" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: white; border-radius: 15px 15px 0 0; padding: 18px 25px; font-weight: bold; font-size: 1.3em; display: flex; align-items: center; gap: 10px;">
            <i class="fa fa-cubes"></i> QUẢN LÝ DANH SÁCH SẢN PHẨM
        </div>

        <div class="row w3-res-tb" style="padding: 25px 20px; display: flex; align-items: center; flex-wrap: wrap;">
            <div class="col-sm-4 m-b-xs">
                <div class="input-group">
                    <select class="input-sm form-control w-sm inline v-middle" style="border-radius: 6px; border: 1px solid #ced4da;">
                        <option value="0">Tác vụ hàng loạt</option>
                        <option value="1">Xóa mục đã chọn</option>
                        <option value="2">Thay đổi trạng thái</option>
                    </select>
                    <button class="btn btn-sm btn-info" style="margin-left: 8px; border-radius: 6px; font-weight: 500;">Áp dụng</button>
                </div>
            </div>

            <div class="col-sm-4 text-center">
                <div class="btn-group" style="background: #f8f9fa; padding: 5px; border-radius: 10px;">
                    <form action="{{ url('admin/import-product') }}" method="POST" enctype="multipart/form-data" id="importForm" style="display: inline-block;">
                        @csrf
                        <input type="file" name="file" id="fileInput" accept=".xlsx,.csv" style="display:none;" onchange="handleFileSelect()">
                        <button type="button" class="btn btn-sm btn-warning" onclick="openFileWindow()" style="border-radius: 6px; margin-right: 5px;">
                            <i class="fa fa-upload"></i> Nhập Excel
                        </button>
                    </form>

                    <form action="{{ url('admin/export-product') }}" method="POST" style="display: inline-block;">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-success" style="border-radius: 6px;">
                            <i class="fa fa-download"></i> Xuất Excel
                        </button>
                    </form>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="input-group">
                    <input type="text" class="input-sm form-control" placeholder="Tìm tên sản phẩm..." style="border-radius: 6px 0 0 6px; border: 1px solid #ced4da;">
                    <span class="input-group-btn">
                        <button class="btn btn-sm btn-primary" type="button" style="border-radius: 0 6px 6px 0; background: #4facfe; border: none;">Tìm kiếm</button>
                    </span>
                </div>
            </div>
        </div>

        <div style="padding: 0 25px;">
            <?php
                $message = Session::get('message');
                if($message){
                    echo '<div class="alert alert-success" style="border-radius: 10px; border: none; background: #d4edda; color: #155724; font-weight: 500;"><i class="fa fa-check-circle"></i> '.$message.'</div>';
                    Session::put('message',null);
                }
            ?>
        </div>

        <div class="table-responsive">
            <table class="table table-hover" style="margin-bottom: 0;">
                <thead style="background-color: #fcfcfc; border-bottom: 2px solid #eee;">
                    <tr>
                        <th style="width:40px; text-align: center;">
                            <label class="i-checks m-b-none"><input type="checkbox"><i></i></label>
                        </th>
                        <th>Thông tin sản phẩm</th>
                        <th>Giá bán</th>
                        <th class="text-center">Hình ảnh</th>
                        <th>Số lượng tồn kho </th>
                        <th>Phân loại</th>
                        <th class="text-center">Trạng thái</th>
                        <th class="text-center">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($all_product as $key => $pro)
                    <tr style="transition: all 0.3s;">
                        <td style="vertical-align: middle; text-align: center;">
                            <label class="i-checks m-b-none"><input type="checkbox" name="post[]"><i></i></label>
                        </td>
                        <td style="vertical-align: middle;">
                            <div style="font-weight: 600; color: #2d3436;">{{ $pro->product_name }}</div>
                            <small class="text-muted">ID: #{{ $pro->product_id }}</small>
                        </td>
                        <td style="vertical-align: middle;">
                            <span style="color: #e74c3c; font-weight: bold; font-size: 1.1em;">{{ number_format($pro->product_price) }} <small>đ</small></span>
                        </td>
                        <td style="vertical-align: middle; text-align: center;">
                            <img src="public/uploads/product/{{ $pro->product_image }}" 
                                 style="object-fit: cover; border-radius: 10px; box-shadow: 0 3px 10px rgba(0,0,0,0.1); border: 1px solid #f1f1f1;" 
                                 height="65" width="65">
                        </td>
                        <td style="vertical-align: middle;">
                            <span style="color: #5b9986ff; font-weight: bold; font-size: 1.1em;">{{ $pro->product_quantity }} <small></small></span>
                        </td>
                        <td style="vertical-align: middle;">
                            <span class="badge" style="background: #dfe6e9; color: #636e72; font-weight: normal; padding: 5px 10px;">{{ $pro->category_name }}</span>
                            <div style="font-size: 0.85em; margin-top: 4px; color: #b2bec3;">{{ $pro->brand_name }}</div>
                        </td>

                        <td class="text-center" style="vertical-align: middle;">
                            @if($pro->product_status == 0)
                                <a href="{{URL::to('/unactive-product/'.$pro->product_id)}}" class="status-badge active" title="Đang hiển thị">
                                    <i class="fa fa-toggle-on text-success" style="font-size: 1.8em;"></i>
                                </a>
                            @else
                                <a href="{{URL::to('/active-product/'.$pro->product_id)}}" class="status-badge inactive" title="Đang ẩn">
                                    <i class="fa fa-toggle-off text-muted" style="font-size: 1.8em;"></i>
                                </a>
                            @endif
                        </td>
                        @php
                            $admin_id = Session::get('admin_id');
                            $admin = App\Models\Admin::with('role.permissions')->find($admin_id);
                        @endphp
                        @if($admin && $admin->hasPermission('delete_product'))
                        <td class="text-center" style="vertical-align: middle;">
                            <a href="{{URL::to('/edit-product/'.$pro->product_id)}}" class="btn-action edit" title="Chỉnh sửa">
                                <i class="fa fa-pencil-square-o"></i>
                            </a>
                            <a onclick="return confirm('Bạn có chắc là muốn xóa sản phẩm này không?')" href="{{URL::to('/delete-product/'.$pro->product_id)}}" class="btn-action delete" title="Xóa">
                                <i class="fa fa-trash"></i>Xóa
                            </a>
                        </td>
                        @endif
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <footer class="panel-footer" style="background: white; border-radius: 0 0 15px 15px; padding: 20px;">
            <div class="row">
                <div class="col-sm-5">
                    <small class="text-muted">Đang hiển thị 20 sản phẩm trên mỗi trang</small>
                </div>
                <div class="col-sm-7 text-right">
                    <ul class="pagination pagination-sm m-t-none m-b-none">
                        <li><a href="#"><i class="fa fa-chevron-left"></i></a></li>
                        <li class="active"><a href="#">1</a></li>
                        <li><a href="#">2</a></li>
                        <li><a href="#">3</a></li>
                        <li><a href="#"><i class="fa fa-chevron-right"></i></a></li>
                    </ul>
                </div>
            </div>
        </footer>
    </div>
</div>

<style>
    .table-hover tbody tr:hover { background-color: #f1f8ff !important; }
    
    .btn-action {
        font-size: 1.2em;
        padding: 5px 10px;
        transition: 0.2s;
        text-decoration: none !important;
    }
    .btn-action.edit { color: #00b894; }
    .btn-action.delete { color: #d63031; }
    .btn-action:hover { transform: scale(1.2); display: inline-block; }

    .status-badge { text-decoration: none !important; transition: 0.3s; }
    .status-badge:hover { opacity: 0.7; }
</style>

<script>
    function openFileWindow() {
        // Chỉ click 1 lần duy nhất vào input ẩn
        document.getElementById('fileInput').click();
    }

    function handleFileSelect() {
        const fileInput = document.getElementById('fileInput');
        if (fileInput.files.length > 0) {
            // Hiển thị trạng thái đang xử lý (tùy chọn)
            // Submit form ngay khi chọn xong
            document.getElementById('importForm').submit();
        }
    }
</script>
@endsection