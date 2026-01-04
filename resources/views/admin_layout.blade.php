<!DOCTYPE html>
<head>
<title>Dashboard</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="Visitors Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template, 
Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<!-- bootstrap-css -->
<link rel="stylesheet" href="{{asset('public/backend/css/bootstrap.min.css')}}" >
<!-- //bootstrap-css -->
<!-- Custom CSS -->
<link href="{{asset('public/backend/css/style.css')}}" rel='stylesheet' type='text/css' />
<link href="{{asset('public/backend/css/style-responsive.css')}}" rel="stylesheet"/>
<!-- font CSS -->
<link href='//fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300italic,400italic,500,500italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>
<!-- font-awesome icons -->
<link rel="stylesheet" href="{{asset('public/backend/css/font.css')}}" type="text/css"/>
<link href="{{asset('public/backend/css/font-awesome.css')}}" rel="stylesheet"> 
<link rel="stylesheet" href="{{asset('public/backend/css/morris.css')}}" type="text/css"/>
<!-- calendar -->
<link rel="stylesheet" href="{{asset('public/backend/css/monthly.css')}}">
<!-- //calendar -->
<!-- //font-awesome icons -->
<script src="{{asset('public/backend/js/jquery2.0.3.min.js')}}"></script>
<script src="{{asset('public/backend/js/raphael-min.js')}}"></script>
<script src="{{asset('public/backend/js/morris.js')}}"></script>
</head>
<body>
<section id="container">
<!--header start-->
<header class="header fixed-top clearfix">
<!--logo start-->
<div class="brand">
    <a href="index.html" class="logo">
        ADMIN
    </a>
    <div class="sidebar-toggle-box">
        <div class="fa fa-bars"></div>
    </div>
</div>
<!--logo end-->

<div class="top-nav clearfix">
    <!--search & user info start-->
    <ul class="nav pull-right top-menu">
        <li>
             <form class="navbar-form" role="search">
            <input type="text" class="form-control search" placeholder=" Search">
             </form>
        </li>
        <!-- user login dropdown start-->
        <li class="dropdown">
            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                <img alt="" src="{{('public/backend/images/2.png')}}">
                <span class="username">
                	<?php
					$name = Session::get('admin_name');
					if($name){
						echo $name;
						
					}
					?>

                </span>
                <b class="caret"></b>
            </a>
            <ul class="dropdown-menu extended logout">
                <li><a href="#"><i class=" fa fa-suitcase"></i>Hồ Sơ</a></li>
                <li><a href="#"><i class="fa fa-cog"></i> Cài Đặt</a></li>
                <li><a href="{{URL::to('/logout')}}"><i class="fa fa-key"></i>Đăng xuất</a></li>
            </ul>
        </li>
        <!-- user login dropdown end -->
       
    </ul>
    <!--search & user info end-->
</div>
</header>
<!--header end-->
<!--sidebar start-->
<aside>
    <div id="sidebar" class="nav-collapse">
        <!-- sidebar menu start-->
        <div class="leftside-navigation">
            <ul class="sidebar-menu" id="nav-accordion">
                <li>
                    <a class="active" href="{{URL::to('/dashboard')}}">
                        <i class="fa fa-dashboard"></i>
                        <span>Tổng quan</span>
                    </a>
                </li>
                <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-book"></i>
                        <span>Quản lý banner</span>
                    </a>
                    <ul class="sub">
						<li><a href="{{URL::to('/add-banner')}}">Thêm banner</a></li>
						<li><a href="{{URL::to('/manage-banner')}}">Liệt kê banner</a></li>
                    </ul>
                </li>
                 <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-clipboard"></i>
                        <span>Đơn hàng</span>
                    </a>
                    <ul class="sub">
						<li><a href="{{URL::to('/manage-order')}}">Quản lý đơn hàng</a></li>
						
                      
                    </ul>
                </li>
                <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-book"></i>
                        <span>Danh mục sản phẩm</span>
                    </a>
                    <ul class="sub">
						<li><a href="{{URL::to('/add-category-product')}}">Thêm danh mục sản phẩm</a></li>
						<li><a href="{{URL::to('/all-category-product')}}">Liệt kê danh mục sản phẩm</a></li>
                      
                    </ul>
                </li>
                 <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-book"></i>
                        <span>Thương hiệu sản phẩm</span>
                    </a>
                    <ul class="sub">
						<li><a href="{{URL::to('/add-brand-product')}}">Thêm hiệu sản phẩm</a></li>
						<li><a href="{{URL::to('/all-brand-product')}}">Liệt kê thương hiệu sản phẩm</a></li>
                      
                    </ul>
                </li>
                  <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-cube"></i>
                        <span>Sản phẩm</span>
                    </a>
                    <ul class="sub">
						<li>
                        
                            <a href="{{URL::to('/add-product')}}">Thêm sản phẩm</a>
                        </li>
						<li><a href="{{URL::to('/all-product')}}">Liệt kê sản phẩm</a></li>
                      
                    </ul>
                </li>

                </li>
                  <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-ticket"></i>
                        <span>Mã giảm giá</span>
                    </a>
                    <ul class="sub">
						<li><a href="{{URL::to('/insert-coupon')}}">Quản lý mã giảm giá</a></li>
						<li><a href="{{URL::to('/list-coupon')}}">Liệt kê mã giảm giá</a></li>
                    </ul>
                </li>

                </li>
                  <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-ship"></i>
                        <span>Quản lý vận chuyển</span>
                    </a>
                    <ul class="sub">
						<li><a href="{{URL::to('/delivery')}}">Thêm phí ship</a></li>
						
                      
                    </ul>
                </li>

                </li>
                  <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-user"></i>
                        <span>Người dùng</span>
                    </a>
                    <ul class="sub">
						<li><a href="{{URL::to('/add-user')}}">Thêm người dùng</a></li>
						<li><a href="{{URL::to('/all-user')}}">Tất cả người dùng</a></li>
                      
                    </ul>
                </li>
             
            </ul>           
</aside>
<!--sidebar end-->
<!--main content start-->
<section id="main-content">
	<section class="wrapper">
        @yield('admin_content')
    </section>
 <!-- footer -->
		  <div class="footer">
			<div class="wthree-copyright">
			  <p>© 2017 Visitors. All rights reserved | Design by <a href="http://w3layouts.com">W3layouts</a></p>
			</div>
		  </div>
  <!-- / footer -->
</section>
<!--main content end-->
</section>
<script src="{{asset('public/backend/js/bootstrap.js')}}"></script>
<script src="{{asset('public/backend/js/jquery.dcjqaccordion.2.7.js')}}"></script>
<script src="{{asset('public/backend/js/scripts.js')}}"></script>
<script src="{{asset('public/backend/js/jquery.slimscroll.js')}}"></script>
<script src="{{asset('public/backend/js/jquery.nicescroll.js')}}"></script>
<!--[if lte IE 8]><script language="javascript" type="text/javascript" src="js/flot-chart/excanvas.min.js"></script><![endif]-->
<script src="{{asset('public/backend/js/jquery.scrollTo.js')}}"></script>
<!-- morris JavaScript -->	
<script type="text/javascript">
    $(document).ready(function() {
        fetch_delivery();
        function fetch_delivery(){
            $.ajax({
                url : '{{URL::to('/select-feeship')}}',
                method: 'GET',
                success:function(data){
                    $('#load_delivery').html(data);
                }
            });
        }

        $(document).on('blur','.fee_feeship_edit', function(){
            var feeship_id = $(this).data('feeship_id');
            var fee_value = $(this).text();
            var _token = $('input[name="_token"]').val();
            $.ajax({
                url : '{{URL::to('/update-feeship')}}',
                method: 'POST',
                data:{feeship_id:feeship_id,fee_value:fee_value,_token:_token},
                success:function(data){
                    fetch_delivery();
                }
            });
        });
        $('.add_delivery').click(function(){
            var city = $('.city').val();
            var province = $('.province').val();
            var wards = $('.wards').val();
            var fee_ship = $('.fee_ship').val();
            var _token = $('input[name="_token"]').val();
            
            $.ajax({
                url : '{{URL::to('/save-delivery')}}',
                method: 'POST',
                data:{city:city,province:province,wards:wards,fee_ship:fee_ship,_token:_token},
                success:function(data){
                    alert('Thêm phí vận chuyển thành công');
                    setTimeout(function(){
        location.reload();
    }, 1000); 
                },
                 error:function(xhr){
            alert('Có lỗi xảy ra');
            console.log(xhr.responseText);
        }
            });
        });
        $('.choose').on('change', function(){
    var action = $(this).attr('id');
    var _token = $('input[name="_token"]').val();
    var result = '';
    
    if(action == 'city'){
        var matp = $(this).val();
        result = 'province';
        $.ajax({
            url: '{{ URL::to("/select-delivery") }}',
            method: 'POST',
            data: {action: action, matp: matp, _token: _token},
            success: function(data){
                $('#'+result).html(data);
                $('#wards').html('<option value="">--Chọn xã--</option>'); // reset xã
            }
        });
    } else if(action == 'province'){
        var maqh = $(this).val();
        result = 'wards';
        $.ajax({
            url: '{{ URL::to("/select-delivery") }}',
            method: 'POST',
            data: {action: action, maqh: maqh, _token: _token},
            success: function(data){
                $('#'+result).html(data);
            }
        });
    }
});
    });
</script>
<!-- <script type="text/javascript">
    $('.btn-update-status').click(function() {
        var btn = $(this);
        var select = btn.parent().find('.select-status');
        var order_status = select.val();
        var order_code = select.data('order_code');
        var _token = "{{ csrf_token() }}"; // Lấy token để bảo mật

        // Hiển thị trạng thái đang xử lý
        $('#msg-' + order_code).text('Đang lưu...').css('color', 'orange');

        $.ajax({
            url: "{{ url('/update-order-status') }}/" + order_code,
            method: 'POST',
            data: { _token: _token, order_status: order_status },
            success: function(response) {
                alert(response.message); // Hiện thông báo thành công
                location.reload(); // Load lại trang để cập nhật số liệu mới
            },
            error: function(xhr) {
                // Lấy thông báo lỗi từ Controller (response JSON 400)
                var res = JSON.parse(xhr.responseText);
                alert('LỖI: ' + res.message); 
                location.reload(); // Load lại để reset trạng thái select box
            }
        });
    });
</script> -->

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script type="text/javascript">
    $('#btn-submit-all').click(function() {
        var btn = $(this);
        var formData = $('#form-update-all').serialize();

        // 1. Hiệu ứng đang xử lý trên nút
        btn.prop('disabled', true).addClass('btn-warning');
        $('#btn-text').text('Đang xử lý...');

        // 2. Gửi AJAX
        $.ajax({
            url: "{{URL::to('/update-order-status')}}",
            method: 'POST',
            data: formData,
            success: function(response) {
                // Thông báo thành công kiểu đẹp
                Swal.fire({
                    icon: 'success',
                    title: 'Cập nhật đơn hàng thành công!',
                    text: response.message,
                    timer: 2000,
                    showConfirmButton: false
                }).then(() => {
                    location.reload();
                });
            },
            error: function(xhr) {
                btn.prop('disabled', false).removeClass('btn-warning');
                $('#btn-text').text('Lưu tất cả thay đổi');

                // Thông báo lỗi (ví dụ thiếu kho) kiểu đẹp
                var errorMsg = xhr.responseJSON ? xhr.responseJSON.message : 'Lỗi hệ thống!';
                Swal.fire({
                    icon: 'error',
                    title: 'Cập nhật đơn hàng thất bại',
                    text: errorMsg,
                    confirmButtonColor: '#d33'
                });
            }
        });
    });
</script>



	<!-- //calendar -->
</body>
</html>
