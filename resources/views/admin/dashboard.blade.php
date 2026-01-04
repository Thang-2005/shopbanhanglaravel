@extends('admin_layout')
@section('admin_content')
<div class="container-fluid" style="background:#f8f9fa; padding:25px;">
    <h3 class="title-dashboard"><i class="fa fa-dashboard"></i> PHÂN TÍCH KINH DOANH</h3>

    <div class="row filter-box">
        <form autocomplete="off">
            @csrf
            <div class="col-md-2">
                <p>Từ ngày: <input type="text" id="datepicker" class="form-control"></p>
            </div>
            <div class="col-md-2">
                <p>Đến ngày: <input type="text" id="datepicker2" class="form-control"></p>
            </div>
            <div class="col-md-2">
                <p>Lọc theo: 
                    <select class="dashboard-filter form-control">
                        <option>--Chọn--</option>
                        <option value="7ngay">7 ngày qua</option>
                        <option value="thangtruoc">Tháng trước</option>
                        <option value="thangnay">Tháng này</option>
                        <option value="365ngay">1 năm qua</option>
                    </select>
                </p>
            </div>
            <div class="col-md-2" style="margin-top:25px;">
                <button type="button" id="btn-dashboard-filter" class="btn btn-primary btn-sm">Lọc kết quả</button>
            </div>
        </form>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div id="chart_business" style="height: 300px;"></div>
        </div>
    </div>
</div>

<script type="text/javascript">
$(document).ready(function(){
   var chart = new Morris.Bar({
    element: 'chart_business',
    parseTime: false,
    hideHover: 'auto',
    xkey: 'period',
    ykeys: ['order', 'sales', 'profit', 'quantity'],
    labels: ['Đơn hàng', 'Doanh thu', 'Lợi nhuận', 'Số lượng'],
    data: []   // ⬅ DÒNG QUAN TRỌNG
});


    $('#btn-dashboard-filter').click(function(){
        var from_date = $('#datepicker').val();
        var to_date = $('#datepicker2').val();
        $.ajax({
            url: "{{url('/filter-by-date')}}",
            method: "POST",
            dataType: "JSON",
            data: {from_date:from_date, to_date:to_date, _token:"{{csrf_token()}}"},
            success: function(data){
                chart.setData(data);
            }
        });
    });
    // Thêm vào file script hoặc section script của bạn
$( function() {
    $( "#datepicker" ).datepicker({
        dateFormat: "yy-mm-dd" // Định dạng Năm-Tháng-Ngày
    });
    $( "#datepicker2" ).datepicker({
        dateFormat: "yy-mm-dd"
    });
});
});
</script>
@endsection