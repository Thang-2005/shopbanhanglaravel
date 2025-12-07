@extends('admin_layout')
@section('admin_content')
    <div class="table-agile-info">
  <div class="panel panel-default">
    <div class="panel-heading">
      Liệt kê đơn hàng
    </div>
    <div class="row w3-res-tb">
      <div class="col-sm-5 m-b-xs">
        <select class="input-sm form-control w-sm inline v-middle">
          <option value="0">Trạng Thái Hoạt Động</option>
          <option value="1">Xóa</option>
          <option value="2">Sửa</option>
          <option value="3">Xuất Khẩu</option>
        </select>
        <button class="btn btn-sm btn-default">Áp Dụng</button>                
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
      <table class="table table-striped b-t b-light">
        
        <thead>
          <tr>
            <th style="width:20px;">
              <label class="i-checks m-b-none">
                <input type="checkbox"><i></i>
              </label>
            </th>
            <th>Tên người đặt</th>
            <th>Tên sản phẩm</th>
            <th>Tổng giá tiền</th>
             <th>Tình trạng</th>
            <th>Hiển thị</th>
            
            <th style="width:30px;"></th>
          </tr>
        </thead>
         @foreach($all_order as $key => $order)
        <tbody>
         
          <tr>
            <td><label class="i-checks m-b-none"><input type="checkbox" name="post[]"><i></i></label></td>
            <td>{{ $order->customer_name }}</td>
            <td>{{ $order->product_name }}</td>
            <td>{{ $order->order_total }}</td>
            <td>
              <form action="{{ URL::to('/update-order-status/'.$order->order_id) }}" method="POST">
                  @csrf
                  <select name="order_status" onchange="this.form.submit()">
                      <option value="0" {{ $order->order_status == 0 ? 'selected' : '' }} style="color:orange;">Đang chờ xử lý</option>
                      <option value="1" {{ $order->order_status == 1 ? 'selected' : '' }} style="color:blue;">Đã xác nhận</option>
                      <option value="2" {{ $order->order_status == 2 ? 'selected' : '' }} style="color:purple;">Đang giao hàng</option>
                      <option value="3" {{ $order->order_status == 3 ? 'selected' : '' }} style="color:green;">Đã giao hàng</option>
                      <option value="4" {{ $order->order_status == 4 ? 'selected' : '' }} style="color:red;">Đã hủy</option>
                  </select>
              </form>
            </td>


            <!-- <td>{{ $order->order_status }}</td> -->
           
            <td>
              <a href="{{URL::to('/view-order/'.$order->order_id)}}" class="active styling-edit" ui-toggle-class="">
                <i class="fa fa-pencil-square-o text-success text-active"></i></a>
              <a onclick="return confirm('Bạn có chắc là muốn xóa đơn hàng không?')" href="{{URL::to('/delete-order/'.$order->order_id)}}" class="active styling-edit" ui-toggle-class="">
                <i class="fa fa-times text-danger text"></i>
              </a>
            </td>
          </tr>
          
        </tbody>
        @endforeach
      </table>
    </div>
    <footer class="panel-footer">
      <div class="row">
        
        <div class="col-sm-5 text-center">
          <small class="text-muted inline m-t-sm m-b-sm">hiển thị sản phẩm</small>
        </div>
        <div class="col-sm-7 text-right text-center-xs">                
          <ul class="pagination pagination-sm m-t-none m-b-none">
            <li><a href=""><i class="fa fa-chevron-left"></i></a></li>
            <li><a href="">1</a></li>
            <li><a href="">2</a></li>
            <li><a href="">3</a></li>
            <li><a href="">4</a></li>
            <li><a href=""><i class="fa fa-chevron-right"></i></a></li>
          </ul>
        </div>
      </div>
    </footer>
  </div>
</div>
@endsection