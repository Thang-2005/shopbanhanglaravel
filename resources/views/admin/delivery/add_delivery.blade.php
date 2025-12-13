@extends('admin_layout')
@section('admin_content')
<div class="row">
            <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                           Thêm vận chuyển
                        </header>
                         <?php
                            $message = Session::get('message');
                            if($message){
                                echo '<span class="text-alert">'.$message.'</span>';
                                Session::put('message',null);
                            }
                            ?>
                        <div class="panel-body">

                            <div class="position-center">
                                <form role="form" action="{{URL::to('/save-delivery')}}" method="post">
                                    {{ csrf_field() }}
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Chọn thành phố</label>
                                   <select name="tinh" id="tinh" class="form-control input-sm m-bot15 choose tinh">
                                           <option value="">--Chọn thành phố--</option>
                                           @foreach($tinh as $key => $tinh)
                                            <option value="{{ $tinh->matp }}">{{ $tinh->name_tinh }}</option>
                                             @endforeach
                                    </select>
                                </div>
                                
                                 <div class="form-group">
                                    <label for="exampleInputEmail1">--Chọn huyện--</label>
                                   <select name="huyen" id="huyen" class="form-control input-sm m-bot15 choose huyen">
                                           <option value="">--Chọn huyện--</option>
                                           @foreach($huyen as $key => $huyen)
                                            <option value="{{ $huyen->maqh }}">{{ $huyen->name_huyen }}</option>
                                             @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">--Chọn xã--</label>
                                      <select name="xa"  id="xa"class="form-control input-sm m-bot15 choose xa">
                                            <option value="">--Chọn xã--</option>
                                             @foreach($xa as $key => $xa)
                                            <option value="{{ $xa->maxa }}">{{ $xa->name_xa }}</option>
                                             @endforeach
                                           
                                            
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Phí vận chuyển</label>
                                    <input type="text" name="fee_ship" class="form-control fee_ship" id="exampleInputEmail1" placeholder="Tên danh mục">
                                </div>
                                
                               
                                <button type="button" name="add_devilevi_product" class="btn btn-info add_delivery">Thêm phí vận chuyển</button>
                                </form>
                            </div>

                            <div id="load_delivery">

                            </div>

                        </div>
                    </section>

            </div>
@endsection