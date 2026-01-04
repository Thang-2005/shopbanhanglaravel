@extends('admin_layout')
@section('admin_content')
<div class="table-agile-info">
  
  <div class="panel panel-default">
    <div class="panel-heading">
     Thông tin khách hàng
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
           
            <th>Tên khách hàng</th>
            <th>Số điện thoại</th>
            <th>Email</th>
          
            
            <th style="width:30px;"></th>
          </tr>
        </thead>
        <tbody>
        
          <tr>
           
            <td>{{$customer->customer_name}}</td>
            <td>{{$customer->customer_phone}}</td>
              <td>{{$customer->customer_email}}</td>
            
           
          
          </tr>
     
        </tbody>
      </table>

    </div>
   
  </div>
</div>
<br>
<div class="table-agile-info">
  
  <div class="panel panel-default">
    <div class="panel-heading">
     Thông tin vận chuyển
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
           
            <th>Tên người vận chuyển</th>
            <th>Địa chỉ</th>
            <th>Số điện thoại</th>
            <th>Email</th>
            <th>Ghi chú</th>
            <th>Hình thức thanh toán</th>
            

          
            
            <th style="width:30px;"></th>
          </tr>
        </thead>
        <tbody>
        
          <tr>
           
            <td>{{$shipping->shipping_name}}</td>
            <td>{{$shipping->shipping_address}}</td>
             <td>{{$shipping->shipping_phone}}</td>
             <td>{{$shipping->shipping_email}}</td>
             <td>{{$shipping->shipping_notes}}</td>
              <td>
                @if($shipping->shipping_method==1)
                  Chuyển khoản
                @else($shipping->shipping_method==2)
                  Tiền mặt
                @endif
              </td>
          </tr>
     
        </tbody>
      </table>

    </div>
   
  </div>
</div>
<br><br>
 <div class="table-agile-info">
  
  <div class="panel panel-default">
    <div class="panel-heading">
      Liệt kê chi tiết đơn hàng
    </div>
    <div class="row w3-res-tb">
      <div class="col-sm-5 m-b-xs">
        <select class="input-sm form-control w-sm inline v-middle">
          <option value="0">Trạng Thái Hoạt Động</option>
          <option value="1">Xóa Sản Phẩm</option>
          <option value="2">Sửa </option>
          <option value="3">Xuất Khẩu</option>
        </select>
        <button class="btn btn-sm btn-default">Áp dụng</button>                
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
            <th>Thứ tự</th>
            <th>Tên sản phẩm</th>
            <th>Số lượng đặt</th>
            <th>Số lượng Tồn kho</th>
            <th>Giá</th>
            <th>Tổng tiền</th>
            
            <th style="width:30px;"></th>
          </tr>
        </thead>
        <tbody>
          @php
           $i = 1;
           $total=0;
        
          @endphp
         @foreach($order_details as $key => $ord)
          <tr>
           
            <td><label class="i-checks m-b-none"><input type="checkbox" name="post[]"><i></i></label></td>
            <td>{{$i++}}</td>
            <td>{{$ord->product_name}}</td>
            <td>{{$ord->product_sales_quantity}}</td>
            <td>{{$ord->product->product_quantity}}</td>
            <td>{{number_format($ord->product_price, 0, ',', '.')}}đ</td>
            <td>{{number_format($ord->product_price * $ord->product_sales_quantity, 0, ',', '.')}}đ</td>
          
           
          </tr>
         @endforeach
         <thead>
          <tr>
            
           <th colspan="3">Mã giảm giá: {{$product_coupon}} </th>
           
         
           <th >Phí vận chuyển:</th>
          
          <th colspan="3">Tổng tiền đơn hàng:</th>
          
          </tr>
              <tbody>   
                <tr>
                  <td colspan="3">
                    @if($coupon_condition==1)

                      Giảm:{{$coupon_number}}% - {{number_format($discount, 0, ',', '.')}} đ
                    @elseif($coupon_condition==2)
                      Giảm: {{number_format($discount, 0, ',', '.')}} đ
                    @endif
                  </td>
                  
                  <td>{{number_format($product_feeship, 0, ',', '.')}} đ</td>
                  
                  <td colspan="3">
                    
                    {{number_format($total_after_coupon, 0, ',', '.')}} đ
                  </td>
                   </tr>   
                </tbody>            
        </thead>
      </table>

    </div>
    <footer class="panel-footer">
      <div class="row">
        
        <div class="col-sm-5 text-center">
          <small class="text-muted inline m-t-sm m-b-sm">hiển thị sản phẩm {{ $order_details->count() }}</small>
        </div>
        <a target="_blank"
          href="{{ URL::to('/print-order/'.$ord->order_code) }}"
          class="btn btn-primary"
          style="margin-left: 20px;">
          In đơn hàng
        </a>

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