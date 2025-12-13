@extends('admin_layout')
@section('admin_content')
    <div class="table-agile-info">
  <div class="panel panel-default">
    <div class="panel-heading">
      Liệt kê mã giảm giá
    </div>
    <div class="row w3-res-tb">
      <div class="col-sm-5 m-b-xs">
        <select class="input-sm form-control w-sm inline v-middle">
          <option value="0">Trạng Thái Hoạt Động</option>
          <option value="1">Xóa sản phẩm</option>
          <option value="2">chỉnh sửa </option>
          <option value="3">xuất khẩu </option>
        </select>
        <button class="btn btn-sm btn-default">Áp</button>                
      </div>
      <div class="col-sm-4">
      </div>
      <div class="col-sm-3">
        <div class="input-group">
          <input type="text" class="input-sm form-control" placeholder="Search">
          <span class="input-group-btn">
            <button class="btn btn-sm btn-default" type="button">Go!</button>
          </span>
        </div>
      </div>
    </div>
    <div class="table-responsive">
                      <?php
                            $message = Session::get('message');
                            if($message){
                                echo '<span class="text-alert">'.$message.'</span>';
                                Session::put('message',null);
                            }
                            ?>
     @if($coupon->count()>0)
        <h3 class="text-center">Chưa có mã giảm giá nào được tạo.<h3>       
      <table class="table table-striped b-t b-light">
        <thead>
          <tr>
          <th>STT</th>
            <th>Tên mã giảm giá</th>
            <th>Mã giảm giá</th>
            <th>Tính năng mã</th>

            <th>Số % hoặc số tiền giảm</th>
            <th>Số lượng mã</th>
            <th style="width:30px;">Thao tác</th>
          </tr>
        </thead>
        <tbody>
          @foreach($coupon as $key => $cou)
          <tr>
            <td><label class="i-checks m-b-none"><input type="checkbox" name="post[]"><i></i></label></td>
            <td>{{ $cou->coupon_name }}</td>
            <td>{{ $cou->coupon_code }}</td>
            
            <td><span class="text-ellipsis">
              <?php
               if($cou->coupon_condition==1){
                ?>
                    Giảm theo %
                <?php
                 }else{
                ?>  
                    Giảm theo tiền
                <?php
               }
              ?>
            </span></td>
            <td><span class="text-ellipsis">
              <?php
               if($cou->coupon_condition==1){
                ?>
                    Giảm {{$cou->coupon_number}} %
                <?php
                 }else{
                ?>  
                    Giảm theo {{$cou->coupon_number}} VNĐ
                <?php
               }
              ?>
            </span></td>
            <td>{{ $cou->coupon_time }}</td>
           
            <td>

             <a href="{{ URL::to('/delete-coupon/'.$cou->coupon_id) }}" 
                               onclick="return confirm('Bạn có chắc là muốn xóa mã này không?')"
                               class="btn btn-sm btn-danger">
                               <i class="fa fa-trash"></i> Xóa
            </a>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
        @else
        <h3 class="text-center" style="color:red">Chưa có mã giảm giá nào được tạo.<h3>
        
        @endif
    </div>
     <footer class="panel-footer d-flex justify-content-between align-items-center">
            <small class="text-muted">Hiển thị {{ $coupon->count() }} mã giảm giá</small>
            <nav>
                
            </nav>
        </footer>
  </div>
</div>
@endsection
