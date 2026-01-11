@extends('admin_layout')
@section('admin_content')
<div class="row">
            <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                           Thêm banner
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
                                <form role="form"action="{{route('insert.banner')}}" enctype="multipart/form-data" method="post">
                                    @csrf
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Tên banner</label>
                                    <input type="text" name="banner_name" class="form-control" id="exampleInputEmail1" placeholder="Tên banner">
                                </div><div class="form-group">
                                    <label for="exampleInputEmail1">Ảnh banner</label>
                                    <input type="file" name="banner_image" class="form-control" id="exampleInputEmail1" placeholder="Ảnh banner">
                                </div>
                                
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Mô tả banner</label>
                                    <textarea style="resize: none" rows="8" class="form-control" name="banner_desc" id="exampleInputPassword1" placeholder="Mô tả banner"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Hiển thị</label>
                                      <select name="banner_status" class="form-control input-sm m-bot15">
                                            <option value="0">Ẩn</option>
                                            <option value="1">Hiển thị</option>
                                            
                                    </select>
                                </div>
                               
                                <button type="submit" name="add_banner" class="btn btn-info">Thêm banner</button>
                                </form>
                            </div>

                        </div>
                    </section>

            </div>
@endsection