@extends('admin_layout')
@section('admin_content')
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Thêm sản phẩm
            </header>

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

            <div class="panel-body">
                <div class="position-center">
                    <form role="form" action="{{URL::to('/save-product')}}" method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}

                        <div class="form-group">
                            <label for="exampleInputEmail1">Tên sản phẩm</label>
                            <input type="text" name="product_name" class="form-control" placeholder="Tên sản phẩm">
                        </div>

                        <div class="form-group">
                            <label for="exampleInputEmail1">Giá sản phẩm</label>
                            <input type="text" name="product_price" class="form-control" placeholder="Giá sản phẩm">
                        </div>

                        <div class="form-group">
                            <label for="exampleInputEmail1">Hình ảnh sản phẩm</label>
                            <input type="file" name="product_image" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="exampleInputPassword1">Mô tả sản phẩm</label>
                            <textarea style="resize: none" rows="8" class="form-control" name="product_desc" placeholder="Mô tả sản phẩm"></textarea>
                        </div>

                        <div class="form-group">
                            <label for="exampleInputPassword1">Nội dung sản phẩm</label>
                            <textarea style="resize: none" rows="8" class="form-control" name="product_content" placeholder="Nội dung sản phẩm"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Số lượng sản phẩm</label>
                            <textarea style="resize: none" rows="1" class="form-control" name="product_quantity" placeholder="số lượng"></textarea>
                        </div>

             <div class="form-group">
    <label for="product_category">Danh mục sản phẩm</label>
    <select name="category_id" id="product_category" class="form-control input-sm m-bot15" required> <option value="" selected disabled>-- Chọn danh mục --</option>
        
        @foreach($cate_product as $key => $cate)
            <option value="{{$cate->category_id}}">{{$cate->category_name}}</option>
        @endforeach

    </select>
</div>

                        <div class="form-group">
                            <label for="exampleInputPassword1">Thương hiệu</label>
                            <select name="brand_id" class="form-control input-sm m-bot15">
                                @foreach($brand_product as $key => $brand)
                                    <option value="{{$brand->brand_id}}">{{$brand->brand_name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="exampleInputPassword1">Hiển thị</label>
                            <select name="product_status" class="form-control input-sm m-bot15">
                                <option value="0">Ẩn</option>
                                <option value="1">Hiển thị</option>
                            </select>
                        </div>
 

                        <button type="submit" name="add_product" class="btn btn-info">Thêm sản phẩm</button>
                    </form>
                </div>
            </div>
        </section>
    </div>
</div>
@endsection
