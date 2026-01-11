@extends('admin_layout')
@section('admin_content')
<style>
    .dashboard-container {
        background: #f8f9fa;
        padding: 25px;
        min-height: 100vh;
    }
    
    .page-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 30px;
        border-radius: 15px;
        color: white;
        margin-bottom: 30px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }
    
    .page-header h3 {
        margin: 0;
        font-size: 28px;
        font-weight: 600;
    }
    
    .page-header p {
        margin: 5px 0 0 0;
        opacity: 0.9;
        font-size: 14px;
    }
    
    .filter-card {
        background: white;
        border-radius: 15px;
        padding: 25px;
        margin-bottom: 30px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.05);
    }
    
    .filter-card h5 {
        color: #333;
        font-weight: 600;
        margin-bottom: 20px;
        font-size: 16px;
    }
    
    .filter-group {
        margin-bottom: 15px;
    }
    
    .filter-group label {
        display: block;
        color: #666;
        font-size: 13px;
        font-weight: 500;
        margin-bottom: 8px;
    }
    
    .filter-group input,
    .filter-group select {
        width: 100%;
        padding: 10px 15px;
        border: 2px solid #e1e8ed;
        border-radius: 8px;
        font-size: 14px;
        transition: all 0.3s;
    }
    
    .filter-group input:focus,
    .filter-group select:focus {
        border-color: #667eea;
        outline: none;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }
    
    .btn-filter {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        padding: 12px 30px;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
        width: 100%;
    }
    
    .btn-filter:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
    }
    
    .btn-reset {
        background: white;
        color: #667eea;
        border: 2px solid #667eea;
        padding: 12px 30px;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
        width: 100%;
        margin-top: 10px;
    }
    
    .btn-reset:hover {
        background: #667eea;
        color: white;
    }
    
    .stats-row {
        margin-bottom: 30px;
    }
    
    .stat-card {
        background: white;
        border-radius: 15px;
        padding: 25px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        transition: all 0.3s;
        height: 100%;
    }
    
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }
    
    .stat-icon {
        width: 60px;
        height: 60px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
        margin-bottom: 15px;
    }
    
    .stat-icon.orders {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }
    
    .stat-icon.revenue {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        color: white;
    }
    
    .stat-icon.products {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        color: white;
    }
    
    .stat-icon.customers {
        background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
        color: white;
    }
    
    .stat-label {
        color: #999;
        font-size: 13px;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .stat-value {
        color: #333;
        font-size: 28px;
        font-weight: 700;
        margin: 5px 0;
    }
    
    .chart-card {
        background: white;
        border-radius: 15px;
        padding: 25px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.05);
    }
    
    .chart-card h5 {
        color: #333;
        font-weight: 600;
        margin-bottom: 20px;
        font-size: 18px;
    }
    
    #chart_business {
        height: 400px;
    }
    
    .loading-overlay {
        display: none;
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(255,255,255,0.9);
        border-radius: 15px;
        justify-content: center;
        align-items: center;
        z-index: 10;
    }
    
    .loading-overlay.active {
        display: flex;
    }
    
    .spinner {
        width: 50px;
        height: 50px;
        border: 4px solid #f3f3f3;
        border-top: 4px solid #667eea;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }
    
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
</style>

<div class="dashboard-container">
    <!-- Page Header -->
    <div class="page-header">
        <h3><i class="fa fa-chart-line"></i> PHÂN TÍCH KINH DOANH</h3>
        <p>Theo dõi và phân tích hiệu quả kinh doanh của bạn</p>
    </div>

    <!-- Statistics Cards -->
    <div class="row stats-row">
        <div class="col-md-3 col-sm-6">
            <div class="stat-card">
                <div class="stat-icon orders">
                    <i class="fa fa-shopping-cart"></i>
                </div>
                <div class="stat-label">Tổng Đơn Hàng</div>
                <div class="stat-value">{{ number_format($order_count) }}</div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="stat-card">
                <div class="stat-icon revenue">
                    <i class="fa fa-dollar"></i>
                </div>
                <div class="stat-label">Tổng Doanh Thu</div>
                <div class="stat-value">{{ number_format($total_revenue) }} ₫</div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="stat-card">
                <div class="stat-icon products">
                    <i class="fa fa-cube"></i>
                </div>
                <div class="stat-label">Tổng Sản Phẩm</div>
                <div class="stat-value">{{ number_format($product_count) }}</div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="stat-card">
                <div class="stat-icon customers">
                    <i class="fa fa-users"></i>
                </div>
                <div class="stat-label">Tổng Khách Hàng</div>
                <div class="stat-value">{{ number_format($customer_count) }}</div>
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="row">
        <div class="col-md-12">
            <div class="filter-card">
                <h5><i class="fa fa-filter"></i> Bộ Lọc Dữ Liệu Biểu Đồ</h5>
                <form autocomplete="off">
                    @csrf
                    <div class="row">
                        <div class="col-md-3">
                            <div class="filter-group">
                                <label><i class="fa fa-calendar"></i> Từ ngày</label>
                                <input type="text" id="datepicker" class="form-control" placeholder="Chọn ngày bắt đầu">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="filter-group">
                                <label><i class="fa fa-calendar"></i> Đến ngày</label>
                                <input type="text" id="datepicker2" class="form-control" placeholder="Chọn ngày kết thúc">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="filter-group">
                                <label><i class="fa fa-clock"></i> Lọc nhanh</label>
                                <select class="dashboard-filter form-control">
                                    <option value="">-- Chọn khoảng thời gian --</option>
                                    <option value="homnay">Hôm nay</option>
                                    <option value="homqua">Hôm qua</option>
                                    <option value="7ngay" selected>7 ngày qua</option>
                                    <option value="30ngay">30 ngày qua</option>
                                    <option value="thangtruoc">Tháng trước</option>
                                    <option value="thangnay">Tháng này</option>
                                    <option value="365ngay">1 năm qua</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="filter-group">
                                <label style="opacity:0;">Action</label>
                                <button type="button" id="btn-dashboard-filter" class="btn-filter">
                                    <i class="fa fa-search"></i> Lọc Kết Quả
                                </button>
                                <button type="button" id="btn-reset-filter" class="btn-reset">
                                    <i class="fa fa-refresh"></i> Đặt Lại
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Chart Section -->
    <div class="row">
        <div class="col-md-12">
            <div class="chart-card" style="position: relative;">
                <div class="loading-overlay" id="chart-loading">
                    <div class="spinner"></div>
                </div>
                <h5><i class="fa fa-bar-chart"></i> Biểu Đồ Phân Tích Theo Thời Gian</h5>
                <div id="chart_business"></div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function(){

    var chart = new Morris.Bar({
        element: 'chart_business',
        parseTime: false,
        xkey: 'period',
        ykeys: ['order', 'sales', 'profit', 'quantity'],
        labels: ['Đơn hàng', 'Doanh thu', 'Lợi nhuận', 'Số lượng'],
        resize: true,
        data: @json($chart_data)
    });

    $("#datepicker, #datepicker2").datepicker({
        dateFormat: "yy-mm-dd",
        maxDate: new Date()
    });

    function loadDashboardData(fromDate, toDate) {
        $('#chart-loading').addClass('active');

        $.post("{{ url('/filter-by-date') }}", {
            from_date: fromDate,
            to_date: toDate,
            _token: "{{ csrf_token() }}"
        }, function(data){
            chart.setData(data);
            $('#chart-loading').removeClass('active');
        }, 'json');
    }

    $('.dashboard-filter').change(function(){
    var filter = $(this).val();
    if(!filter) return;

    var today = new Date();
    var fromDate, toDate;

    toDate = formatDate(today);

    switch(filter) {
        case 'homnay':
            fromDate = toDate;
            break;
        case 'homqua':
            var y = new Date(today);
            y.setDate(y.getDate() - 1);
            fromDate = formatDate(y);
            toDate = fromDate;
            break;
        case '7ngay':
            var d = new Date(today);
            d.setDate(d.getDate() - 7);
            fromDate = formatDate(d);
            break;
        case '30ngay':
            var d = new Date(today);
            d.setDate(d.getDate() - 30);
            fromDate = formatDate(d);
            break;
        case 'thangnay':
            fromDate = formatDate(new Date(today.getFullYear(), today.getMonth(), 1));
            break;
        case 'thangtruoc':
            var first = new Date(today.getFullYear(), today.getMonth() - 1, 1);
            var last  = new Date(today.getFullYear(), today.getMonth(), 0);
            fromDate = formatDate(first);
            toDate   = formatDate(last);
            break;
        case '365ngay':
            var d = new Date(today);
            d.setDate(d.getDate() - 365);
            fromDate = formatDate(d);
            break;
    }

    $('#datepicker').val(fromDate);
    $('#datepicker2').val(toDate);
    loadDashboardData(fromDate, toDate);
});

    // ✅ LỌC THEO NGÀY (BUTTON)
    $('#btn-dashboard-filter').click(function(){
        var fromDate = $('#datepicker').val();
        var toDate = $('#datepicker2').val();

        if(!fromDate || !toDate){
            alert('Vui lòng chọn đủ ngày');
            return;
        }

        $('.dashboard-filter').val('');
        loadDashboardData(fromDate, toDate);
    });

    $('#btn-reset-filter').click(function(){
        location.reload();
    });

    function formatDate(d){
        return d.getFullYear() + '-' +
            String(d.getMonth()+1).padStart(2,'0') + '-' +
            String(d.getDate()).padStart(2,'0');
    }
});
</script>

@endsection