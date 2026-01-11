@extends('admin_layout')
@section('admin_content')
    <div class="table-agile-info">
        <div class="panel panel-default">
            <div class="panel-heading">
                Liệt kê danh mục sản phẩm
            </div>
            
            <div class="row w3-res-tb">
                <!-- Actions et Import/Export -->
                <div class="col-sm-5 m-b-xs">
                    <div class="form-inline mb-3">
                        <select class="input-sm form-control w-sm inline v-middle">
                            <option value="0">Trạng Thái Hoạt Động</option>
                            <option value="1">Xóa sản phẩm</option>
                            <option value="2">Chỉnh sửa</option>
                            <option value="3">Xuất khẩu</option>
                        </select>
                        <button class="btn btn-sm btn-default">Áp dụng</button>
                    </div>
                    
                    <!-- Import/Export Excel -->
                    <div class="excel-actions mt-3">
                        <form action="{{ url('admin/import-csv') }}" method="POST" enctype="multipart/form-data" class="mb-2">
                            @csrf
                            <div class="input-group">
                                <input type="file" name="file" accept=".xlsx,.csv" required class="form-control input-sm">
                                <span class="input-group-btn">
                                    <button type="submit" class="btn btn-sm btn-warning">
                                        <i class="fa fa-upload"></i> Import Excel
                                    </button>
                                </span>
                            </div>
                        </form>
                        
                        <form action="{{ url('admin/export-csv') }}" method="POST"  id="btn-export">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-success">
                                <i class="fa fa-download"></i> Export Excel
                            </button>
                        </form>
                    </div>
                </div>
                
                <div class="col-sm-4"></div>
                
                <!-- Recherche -->
                <div class="col-sm-3">
                    <div class="input-group">
                        <input type="text" class="input-sm form-control" placeholder="Tìm kiếm...">
                        <span class="input-group-btn">
                            <button class="btn btn-sm btn-default" type="button">
                                <i class="fa fa-search"></i> Tìm
                            </button>
                        </span>
                    </div>
                </div>
            </div>
            
            <!-- Message de notification -->
            <div class="table-responsive">
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
                
                <!-- Table -->
                <table class="table table-striped b-t b-light">
                    <thead>
                        <tr>
                            <th style="width:20px;">
                                <label class="i-checks m-b-none">
                                    <input type="checkbox"><i></i>
                                </label>
                            </th>
                            <th>Tên danh mục</th>
                            <th>Mô tả</th>
                            <th>Hiển thị</th>
                            <th style="width:100px;" class="text-center">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($all_category_product as $key => $cate_pro)
                        <tr>
                            <td>
                                <label class="i-checks m-b-none">
                                    <input type="checkbox" name="post[]"><i></i>
                                </label>
                            </td>
                            <td><strong>{{ $cate_pro->category_name }}</strong></td>
                            <td>
                                <span class="text-ellipsis">
                                    {{ Str::limit($cate_pro->category_desc, 50) }}
                                </span>
                            </td>
                            <td>
                                @if($cate_pro->category_status == 0)
                                    <a href="{{ URL::to('/unactive-category-product/'.$cate_pro->category_id) }}" 
                                       class="btn btn-xs btn-success" 
                                       title="Đang kích hoạt">
                                        <i class="fa fa-thumbs-up"></i> Kích hoạt
                                    </a>
                                @else
                                    <a href="{{ URL::to('/active-category-product/'.$cate_pro->category_id) }}" 
                                       class="btn btn-xs btn-default" 
                                       title="Chưa kích hoạt">
                                        <i class="fa fa-thumbs-down"></i> Ẩn
                                    </a>
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="{{ URL::to('/edit-category-product/'.$cate_pro->category_id) }}" 
                                   class="active styling-edit btn btn-xs btn-primary" 
                                   ui-toggle-class=""
                                   title="Chỉnh sửa">
                                    <i class="fa fa-pencil-square-o"></i>
                                </a>
                                <a onclick="return confirm('Bạn có chắc chắn muốn xóa danh mục này không?')" 
                                   href="{{ URL::to('/delete-category-product/'.$cate_pro->category_id) }}" 
                                   class="active styling-edit btn btn-xs btn-danger" 
                                   ui-toggle-class=""
                                   title="Xóa">
                                    <i class="fa fa-times"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">
                                <div class="alert alert-warning">
                                    <i class="fa fa-exclamation-triangle"></i> 
                                    Chưa có danh mục nào!
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Footer et pagination -->
            <footer class="panel-footer">
                <div class="row">
                    <div class="col-sm-5 text-center">
                        <small class="text-muted inline m-t-sm m-b-sm">
                            Hiển thị {{ $all_category_product->count() }} danh mục
                        </small>
                    </div>
                    <div class="col-sm-7 text-right text-center-xs">                
                        <ul class="pagination pagination-sm m-t-none m-b-none">
                            <li><a href="#"><i class="fa fa-chevron-left"></i></a></li>
                            <li class="active"><a href="#">1</a></li>
                            <li><a href="#">2</a></li>
                            <li><a href="#">3</a></li>
                            <li><a href="#">4</a></li>
                            <li><a href="#"><i class="fa fa-chevron-right"></i></a></li>
                        </ul>
                    </div>
                </div>
            </footer>
        </div>
    </div>
@endsection