@extends('admin_layout')
@section('admin_content')
<div class="table-agile-info">
    <div class="panel panel-default">
        <div class="panel-heading">
            Quản lý Trạng thái Đơn hàng Hàng loạt
        </div>

        <div class="table-responsive" style="padding: 15px;">
            <form id="form-update-all">
                @csrf
                <div style="margin-bottom: 20px;">
                    <button type="button" id="btn-submit-all" class="btn btn-sm btn-primary">
                        <i class="fa fa-save"></i> <span id="btn-text">Lưu tất cả thay đổi</span>
                    </button>
                </div>

                <table class="table table-striped b-t b-light" id="myTable">
                    <thead>
                        <tr>
                            <th style="width:20px;"><label class="i-checks m-b-none"><input type="checkbox"><i></i></label></th>
                            <th>STT</th>
                            <th>Mã đơn hàng</th>
                            <th style="width: 300px;">Trạng thái đơn hàng</th>
                            <th>Ngày đặt hàng</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $i = 0; @endphp
                        @foreach($order as $key => $od)
                        <tr>
                            <td><label class="i-checks m-b-none"><input type="checkbox" name="post[]"><i></i></label></td>
                            <td>{{ ++$i }}</td>
                            <td><b style="color: #5861ce;">{{ $od->order_code }}</b></td>
                            <td>
                                <select name="order_status[{{ $od->order_code }}]" class="form-control input-sm select-styling">
                                    <option value="0" {{ $od->order_status == 0 ? 'selected' : '' }}>🆕 Đơn hàng mới</option>
                                    <option value="1" {{ $od->order_status == 1 ? 'selected' : '' }}>⏳ Đã Xác nhận</option>
                                    <option value="2" {{ $od->order_status == 2 ? 'selected' : '' }}>🚚 Đang giao hàng </option>
                                    <option value="3" {{ $od->order_status == 3 ? 'selected' : '' }}>✅ Đã giao hàng (Trừ kho)</option>
                                    <option value="4" {{ $od->order_status == 4 ? 'selected' : '' }}>❌ Đã hủy đơn</option>
                                </select>
                            </td>
                            <td>{{ date('d/m/Y H:i', strtotime($od->created_at)) }}</td>
                            <td>
                                <a href="{{URL::to('/view-order/'.$od->order_code)}}" class="btn btn-xs btn-default">
                                    <i class="fa fa-eye text-success"></i> Xem
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </form>
        </div>
    </div>
</div>

<style>
    .select-styling {
        border-radius: 4px;
        border: 1px solid #ddd;
        transition: all 0.3s;
    }
    .select-styling:focus {
        border-color: #5861ce;
        box-shadow: 0 0 5px rgba(88, 97, 206, 0.2);
    }
</style>
@endsection