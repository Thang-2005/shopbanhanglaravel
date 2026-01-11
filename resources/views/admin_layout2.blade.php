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
        <a href="{{URL::to('/dashboard')}}" class="logo">
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
                    <input type="text" class="form-control search" placeholder="Tìm kiếm">
                </form>
            </li>
            <!-- user login dropdown start-->
            <li class="dropdown">
                <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                    <img alt="" src="{{asset('public/backend/images/2.png')}}">
                    <span class="username">
                        @php
                            $admin_name = Session::get('admin_name');
                            $admin_id = Session::get('admin_id');
                            $admin = App\Models\Admin::with('role')->find($admin_id);
                        @endphp
                        {{ $admin_name ?? 'Admin' }}
                        @if($admin && $admin->role)
                            <span class="badge badge-info" style="font-size: 10px; margin-left: 5px;">
                                {{ $admin->role->role_desc }}
                            </span>
                        @endif
                    </span>
                    <b class="caret"></b>
                </a>
                <ul class="dropdown-menu extended logout">
                    <li><a href="#"><i class="fa fa-suitcase"></i> Hồ Sơ</a></li>
                    <li><a href="#"><i class="fa fa-cog"></i> Cài Đặt</a></li>
                    <li><a href="{{URL::to('/logout')}}"><i class="fa fa-key"></i> Đăng xuất</a></li>
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
                    
                    {{-- Dashboard - Tất cả có quyền xem --}}
                    <li>
                        <a class="active" href="{{URL::to('/dashboard')}}">
                            <i class="fa fa-dashboard"></i>
                            <span>Tổng quan</span>
                        </a>
                    </li>

                    {{-- Quản lý Banner --}}
                    @if($admin && ($admin->hasPermission('view_banner') || $admin->hasRole('admin')))
                    <li class="sub-menu">
                        <a href="javascript:;">
                            <i class="fa fa-picture-o"></i>
                            <span>Quản lý banner</span>
                        </a>
                        <ul class="sub">
                            @if($admin->hasPermission('create_banner') || $admin->hasRole('admin'))
                                <li><a href="{{URL::to('/add-banner')}}">Thêm banner</a></li>
                            @endif
                            <li><a href="{{URL::to('/manage-banner')}}">Liệt kê banner</a></li>
                        </ul>
                    </li>
                    @endif

                    {{-- Quản lý Đơn hàng --}}
                    @if($admin && ($admin->hasPermission('view_order') || $admin->hasRole('admin')))
                    <li class="sub-menu">
                        <a href="javascript:;">
                            <i class="fa fa-clipboard"></i>
                            <span>Đơn hàng</span>
                        </a>
                        <ul class="sub">
                            <li><a href="{{URL::to('/manage-order')}}">Quản lý đơn hàng</a></li>
                        </ul>
                    </li>
                    @endif

                    {{-- Quản lý Danh mục sản phẩm --}}
                    @if($admin && ($admin->hasPermission('view_category') || $admin->hasRole('admin')))
                    <li class="sub-menu">
                        <a href="javascript:;">
                            <i class="fa fa-list"></i>
                            <span>Danh mục sản phẩm</span>
                        </a>
                        <ul class="sub">
                            @if($admin->hasPermission('create_category') || $admin->hasRole('admin'))
                                <li><a href="{{URL::to('/add-category-product')}}">Thêm danh mục</a></li>
                            @endif
                            <li><a href="{{URL::to('/all-category-product')}}">Liệt kê danh mục</a></li>
                        </ul>
                    </li>
                    @endif

                    {{-- Quản lý Thương hiệu --}}
                    @if($admin && ($admin->hasPermission('view_brand') || $admin->hasRole('admin')))
                    <li class="sub-menu">
                        <a href="javascript:;">
                            <i class="fa fa-tag"></i>
                            <span>Thương hiệu sản phẩm</span>
                        </a>
                        <ul class="sub">
                            @if($admin->hasPermission('create_brand') || $admin->hasRole('admin'))
                                <li><a href="{{URL::to('/add-brand-product')}}">Thêm thương hiệu</a></li>
                            @endif
                            <li><a href="{{URL::to('/all-brand-product')}}">Liệt kê thương hiệu</a></li>
                        </ul>
                    </li>
                    @endif

                    {{-- Quản lý Sản phẩm --}}
                    @if($admin && ($admin->hasPermission('view_product') || $admin->hasRole('admin')))
                    <li class="sub-menu">
                        <a href="javascript:;">
                            <i class="fa fa-cube"></i>
                            <span>Sản phẩm</span>
                        </a>
                        <ul class="sub">
                            @if($admin->hasPermission('create_product') || $admin->hasRole('admin'))
                                <li><a href="{{URL::to('/add-product')}}">Thêm sản phẩm</a></li>
                            @endif
                            <li><a href="{{URL::to('/all-product')}}">Liệt kê sản phẩm</a></li>
                        </ul>
                    </li>
                    @endif

                    {{-- Quản lý Mã giảm giá --}}
                    @if($admin && ($admin->hasPermission('view_coupon') || $admin->hasRole('admin')))
                    <li class="sub-menu">
                        <a href="javascript:;">
                            <i class="fa fa-ticket"></i>
                            <span>Mã giảm giá</span>
                        </a>
                        <ul class="sub">
                            @if($admin->hasPermission('create_coupon') || $admin->hasRole('admin'))
                                <li><a href="{{URL::to('/insert-coupon')}}">Thêm mã giảm giá</a></li>
                            @endif
                            <li><a href="{{URL::to('/list-coupon')}}">Liệt kê mã giảm giá</a></li>
                        </ul>
                    </li>
                    @endif

                    {{-- Quản lý Vận chuyển --}}
                    @if($admin && ($admin->hasPermission('view_shipping') || $admin->hasRole('admin')))
                    <li class="sub-menu">
                        <a href="javascript:;">
                            <i class="fa fa-truck"></i>
                            <span>Vận chuyển</span>
                        </a>
                        <ul class="sub">
                            @if($admin->hasPermission('create_shipping') || $admin->hasRole('admin'))
                                <li><a href="{{URL::to('/delivery')}}">Quản lý phí ship</a></li>
                            @endif
                        </ul>
                    </li>
                    @endif

                    {{-- Quản lý Người dùng - Chỉ Admin --}}
                    @if($admin && $admin->hasRole('admin'))
                    <li class="sub-menu">
                        <a href="javascript:;">
                            <i class="fa fa-users"></i>
                            <span>Quản lý quản trị viên</span>
                        </a>
                        <ul class="sub">
                            <li><a href="{{URL::to('/admin/add-admin')}}">Thêm quản trị viên</a></li>
                            <li><a href="{{URL::to('/admin/manage-admin')}}">Danh sách quản trị viên</a></li>
                        </ul>
                    </li>
                    @endif

                    {{-- Quản lý Vai trò & Quyền - Chỉ Admin --}}
                    @if($admin && $admin->hasRole('admin'))
                    <li class="sub-menu">
                        <a href="javascript:;">
                            <i class="fa fa-lock"></i>
                            <span>Phân quyền</span>
                        </a>
                        <ul class="sub">
                            <li><a href="{{URL::to('/admin/roles')}}">Quản lý vai trò</a></li>
                            <li><a href="{{URL::to('/admin/permissions')}}">Quản lý quyền</a></li>
                        </ul>
                    </li>
                    @endif

                </ul>            
            </div>
            <!-- sidebar menu end-->
        </div>
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
                <p>© 2024 E-Commerce Admin Panel. All rights reserved</p>
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
    <script src="{{asset('public/backend/js/jquery.scrollTo.js')}}"></script>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- morris JavaScript -->    
    <script type="text/javascript">
        $(document).ready(function() {
            // Fetch delivery data
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

            // Update feeship on blur
            $(document).on('blur','.fee_feeship_edit', function(){
                var feeship_id = $(this).data('feeship_id');
                var fee_value = $(this).text();
                var _token = $('input[name="_token"]').val();
                
                $.ajax({
                    url : '{{URL::to('/update-feeship')}}',
                    method: 'POST',
                    data:{feeship_id:feeship_id, fee_value:fee_value, _token:_token},
                    success:function(data){
                        fetch_delivery();
                        Swal.fire({
                            icon: 'success',
                            title: 'Cập nhật thành công!',
                            timer: 1500,
                            showConfirmButton: false
                        });
                    }
                });
            });

            // Add delivery
            $('.add_delivery').click(function(){
                var city = $('.city').val();
                var province = $('.province').val();
                var wards = $('.wards').val();
                var fee_ship = $('.fee_ship').val();
                var _token = $('input[name="_token"]').val();
                
                $.ajax({
                    url : '{{URL::to('/save-delivery')}}',
                    method: 'POST',
                    data:{city:city, province:province, wards:wards, fee_ship:fee_ship, _token:_token},
                    success:function(data){
                        Swal.fire({
                            icon: 'success',
                            title: 'Thêm phí vận chuyển thành công!',
                            timer: 1500,
                            showConfirmButton: false
                        }).then(() => {
                            location.reload();
                        });
                    },
                    error:function(xhr){
                        Swal.fire({
                            icon: 'error',
                            title: 'Có lỗi xảy ra!',
                            text: xhr.responseText
                        });
                    }
                });
            });

            // Select delivery location
            $('.choose').on('change', function(){
                var action = $(this).attr('id');
                var _token = $('input[name="_token"]').val();
                var result = '';
                
                if(action == 'city'){
                    var matp = $(this).val();
                    result = 'province';
                    $.ajax({
                        url: '{{URL::to("/select-delivery")}}',
                        method: 'POST',
                        data: {action: action, matp: matp, _token: _token},
                        success: function(data){
                            $('#'+result).html(data);
                            $('#wards').html('<option value="">--Chọn xã--</option>');
                        }
                    });
                } else if(action == 'province'){
                    var maqh = $(this).val();
                    result = 'wards';
                    $.ajax({
                        url: '{{URL::to("/select-delivery")}}',
                        method: 'POST',
                        data: {action: action, maqh: maqh, _token: _token},
                        success: function(data){
                            $('#'+result).html(data);
                        }
                    });
                }
            });

            // Update order status (batch)
            $('#btn-submit-all').click(function() {
                var btn = $(this);
                var formData = $('#form-update-all').serialize();

                btn.prop('disabled', true).addClass('btn-warning');
                $('#btn-text').text('Đang xử lý...');

                $.ajax({
                    url: "{{URL::to('/update-order-status')}}",
                    method: 'POST',
                    data: formData,
                    success: function(response) {
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
        });
    </script>

    </body>
    </html>