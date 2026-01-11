<!DOCTYPE html>
<html lang="vi">
<head>
    <title>Dashboard - Admin Panel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    
    <!-- Bootstrap & CSS -->
    <link rel="stylesheet" href="{{asset('backend/css/bootstrap.min.css')}}">
    <link href="{{asset('backend/css/font-awesome.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('backend/css/morris.css')}}" type="text/css"/>
    <link rel="stylesheet" href="{{asset('backend/css/monthly.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background: #f5f7fa;
            overflow-x: hidden;
        }
        
        /* ========== SIDEBAR ========== */
        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            width: 280px;
            height: 100vh;
            background: linear-gradient(180deg, #1a1d29 0%, #2d3142 100%);
            padding: 0;
            transition: all 0.3s ease;
            z-index: 1000;
            overflow-y: auto;
            box-shadow: 4px 0 20px rgba(0,0,0,0.1);
        }
        
        .sidebar::-webkit-scrollbar {
            width: 6px;
        }
        
        .sidebar::-webkit-scrollbar-thumb {
            background: rgba(255,255,255,0.2);
            border-radius: 10px;
        }
        
        .sidebar.collapsed {
            width: 80px;
        }
        
        .sidebar-header {
            padding: 25px 20px;
            background: rgba(0,0,0,0.2);
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        
        .logo {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            color: white;
            font-size: 22px;
            font-weight: 700;
            transition: all 0.3s;
        }
        
        .logo-icon {
            width: 45px;
            height: 45px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            flex-shrink: 0;
        }
        
        .logo-text {
            transition: opacity 0.3s;
        }
        
        .sidebar.collapsed .logo-text {
            opacity: 0;
            display: none;
        }
        
        .toggle-btn {
            position: absolute;
            right: -15px;
            top: 35px;
            width: 30px;
            height: 30px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            color: white;
            box-shadow: 0 4px 10px rgba(102, 126, 234, 0.4);
            transition: all 0.3s;
        }
        
        .toggle-btn:hover {
            transform: scale(1.1);
        }
        
        /* Menu */
        .sidebar-menu {
            padding: 20px 10px;
            list-style: none;
        }
        
        .menu-item {
            margin-bottom: 5px;
        }
        
        .menu-link {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 14px 20px;
            color: rgba(255,255,255,0.7);
            text-decoration: none;
            border-radius: 12px;
            transition: all 0.3s;
            position: relative;
            overflow: hidden;
        }
        
        .menu-link:before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 4px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            transform: scaleY(0);
            transition: transform 0.3s;
        }
        
        .menu-link:hover,
        .menu-link.active {
            background: rgba(255,255,255,0.1);
            color: white;
        }
        
        .menu-link.active:before {
            transform: scaleY(1);
        }
        
        .menu-icon {
            width: 20px;
            font-size: 18px;
            text-align: center;
            flex-shrink: 0;
        }
        
        .menu-text {
            font-size: 14px;
            font-weight: 500;
            white-space: nowrap;
            transition: opacity 0.3s;
        }
        
        .sidebar.collapsed .menu-text {
            opacity: 0;
            display: none;
        }
        
        .menu-arrow {
            margin-left: auto;
            transition: transform 0.3s;
            font-size: 12px;
        }
        
        .sidebar.collapsed .menu-arrow {
            display: none;
        }
        
        .menu-item.open .menu-arrow {
            transform: rotate(90deg);
        }
        
        /* Submenu */
        .submenu {
            list-style: none;
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease;
            padding-left: 15px;
        }
        
        .menu-item.open .submenu {
            max-height: 500px;
        }
        
        .submenu-link {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 20px;
            color: rgba(255,255,255,0.6);
            text-decoration: none;
            font-size: 13px;
            border-radius: 8px;
            transition: all 0.3s;
            margin: 3px 0;
        }
        
        .submenu-link:hover {
            background: rgba(255,255,255,0.05);
            color: white;
            padding-left: 25px;
        }
        
        .badge {
            padding: 3px 8px;
            border-radius: 20px;
            font-size: 10px;
            font-weight: 600;
            margin-left: auto;
        }
        
        /* ========== HEADER ========== */
        .main-header {
            position: fixed;
            top: 0;
            left: 280px;
            right: 0;
            height: 70px;
            background: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 30px;
            z-index: 999;
            transition: left 0.3s;
        }
        
        .sidebar.collapsed + .main-content .main-header {
            left: 80px;
        }
        
        .search-box {
            position: relative;
            width: 350px;
        }
        
        .search-box input {
            width: 100%;
            padding: 12px 45px 12px 20px;
            border: 2px solid #e1e8ed;
            border-radius: 25px;
            font-size: 14px;
            transition: all 0.3s;
        }
        
        .search-box input:focus {
            border-color: #667eea;
            outline: none;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }
        
        .search-box i {
            position: absolute;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
            color: #999;
        }
        
        .header-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }
        
        .header-icon {
            position: relative;
            width: 40px;
            height: 40px;
            background: #f5f7fa;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s;
            color: #666;
        }
        
        .header-icon:hover {
            background: #667eea;
            color: white;
            transform: translateY(-2px);
        }
        
        .notification-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            width: 18px;
            height: 18px;
            background: #f5576c;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 10px;
            color: white;
            font-weight: 600;
        }
        
        .user-dropdown {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 8px 15px;
            background: #f5f7fa;
            border-radius: 25px;
            cursor: pointer;
            transition: all 0.3s;
            position: relative;
        }
        
        .user-dropdown:hover {
            background: #e1e8ed;
        }
        
        .user-avatar {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 14px;
        }
        
        .user-info {
            display: flex;
            flex-direction: column;
        }
        
        .user-name {
            font-size: 14px;
            font-weight: 600;
            color: #333;
        }
        
        .user-role {
            font-size: 11px;
            color: #999;
        }
        
        .dropdown-menu-custom {
            position: absolute;
            top: 60px;
            right: 0;
            background: white;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
            min-width: 200px;
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: all 0.3s;
        }
        
        .user-dropdown:hover .dropdown-menu-custom {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }
        
        .dropdown-item-custom {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 20px;
            color: #666;
            text-decoration: none;
            transition: all 0.3s;
            border-bottom: 1px solid #f5f7fa;
        }
        
        .dropdown-item-custom:last-child {
            border-bottom: none;
        }
        
        .dropdown-item-custom:hover {
            background: #f5f7fa;
            color: #667eea;
        }
        
        /* ========== MAIN CONTENT ========== */
        .main-content {
            margin-left: 280px;
            margin-top: 70px;
            padding: 30px;
            transition: margin-left 0.3s;
            min-height: calc(100vh - 70px);
        }
        
        .sidebar.collapsed + .main-content {
            margin-left: 80px;
        }
        
        /* ========== FOOTER ========== */
        .footer {
            background: white;
            padding: 20px 30px;
            text-align: center;
            border-top: 1px solid #e1e8ed;
            color: #999;
            font-size: 13px;
        }
        
        /* ========== RESPONSIVE ========== */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }
            
            .sidebar.mobile-show {
                transform: translateX(0);
            }
            
            .main-content,
            .main-header {
                margin-left: 0;
                left: 0;
            }
            
            .search-box {
                width: 200px;
            }
            
            .user-info {
                display: none;
            }
            
            .mobile-toggle {
                display: block !important;
            }
        }
        
        .mobile-toggle {
            display: none;
            width: 40px;
            height: 40px;
            background: #f5f7fa;
            border-radius: 10px;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            color: #666;
        }
        
        /* Overlay for mobile */
        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 999;
        }
        
        @media (max-width: 768px) {
            .sidebar.mobile-show + .sidebar-overlay {
                display: block;
            }
        }
    </style>
    
    <script src="{{asset('backend/js/jquery2.0.3.min.js')}}"></script>
    <script src="{{asset('backend/js/raphael-min.js')}}"></script>
    <script src="{{asset('backend/js/morris.js')}}"></script>
</head>
<body>
    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <a href="{{URL::to('/dashboard')}}" class="logo">
                <div class="logo-icon">
                    <i class="fa fa-shopping-bag"></i>
                </div>
                <span class="logo-text">Trang quản trị</span>
            </a>
            
            <div class="toggle-btn" onclick="toggleSidebar()">
                <i class="fa fa-angle-left"></i>
            </div>
        </div>

        <ul class="sidebar-menu">
            @php
                $admin_name = Session::get('admin_name');
                $admin_id = Session::get('admin_id');
                $admin = App\Models\Admin::with('role')->find($admin_id);
            @endphp

            <!-- Dashboard -->
            <li class="menu-item">
                <a href="{{URL::to('/dashboard')}}" class="menu-link active">
                    <i class="fa fa-dashboard menu-icon"></i>
                    <span class="menu-text">Tổng quan</span>
                </a>
            </li>

            <!-- Banner -->
            @if($admin && ($admin->hasPermission('view_banner') || $admin->hasRole('admin')))
            <li class="menu-item">
                <a href="javascript:void(0)" class="menu-link" onclick="toggleSubmenu(this)">
                    <i class="fa fa-picture-o menu-icon"></i>
                    <span class="menu-text">Quản lý Banner</span>
                    <i class="fa fa-angle-right menu-arrow"></i>
                </a>
                <ul class="submenu">
                    @if($admin->hasPermission('create_banner') || $admin->hasRole('admin'))
                    <li><a href="{{URL::to('/add-banner')}}" class="submenu-link">
                        <i class="fa fa-plus"></i> Thêm banner
                    </a></li>
                    @endif
                    <li><a href="{{URL::to('/manage-banner')}}" class="submenu-link">
                        <i class="fa fa-list"></i> Danh sách banner
                    </a></li>
                </ul>
            </li>
            @endif

            <!-- Orders -->
            @if($admin && ($admin->hasPermission('view_order') || $admin->hasRole('admin')))
            <li class="menu-item">
                <a href="{{URL::to('/manage-order')}}" class="menu-link">
                    <i class="fa fa-shopping-cart menu-icon"></i>
                    <span class="menu-text">Đơn hàng</span>
                    <span class="badge bg-danger">5</span>
                </a>
            </li>
            @endif

            <!-- Categories -->
            @if($admin && ($admin->hasPermission('view_category') || $admin->hasRole('admin')))
            <li class="menu-item">
                <a href="javascript:void(0)" class="menu-link" onclick="toggleSubmenu(this)">
                    <i class="fa fa-list menu-icon"></i>
                    <span class="menu-text">Danh mục</span>
                    <i class="fa fa-angle-right menu-arrow"></i>
                </a>
                <ul class="submenu">
                    @if($admin->hasPermission('create_category') || $admin->hasRole('admin'))
                    <li><a href="{{URL::to('/add-category-product')}}" class="submenu-link">
                        <i class="fa fa-plus"></i> Thêm danh mục
                    </a></li>
                    @endif
                    <li><a href="{{URL::to('/all-category-product')}}" class="submenu-link">
                        <i class="fa fa-list"></i> Danh sách danh mục
                    </a></li>
                </ul>
            </li>
            @endif

            <!-- Brands -->
            @if($admin && ($admin->hasPermission('view_brand') || $admin->hasRole('admin')))
            <li class="menu-item">
                <a href="javascript:void(0)" class="menu-link" onclick="toggleSubmenu(this)">
                    <i class="fa fa-tag menu-icon"></i>
                    <span class="menu-text">Thương hiệu</span>
                    <i class="fa fa-angle-right menu-arrow"></i>
                </a>
                <ul class="submenu">
                    @if($admin->hasPermission('create_brand') || $admin->hasRole('admin'))
                    <li><a href="{{URL::to('/add-brand-product')}}" class="submenu-link">
                        <i class="fa fa-plus"></i> Thêm thương hiệu
                    </a></li>
                    @endif
                    <li><a href="{{URL::to('/all-brand-product')}}" class="submenu-link">
                        <i class="fa fa-list"></i> Danh sách thương hiệu
                    </a></li>
                </ul>
            </li>
            @endif

            <!-- Products -->
            @if($admin && ($admin->hasPermission('view_product') || $admin->hasRole('admin')))
            <li class="menu-item">
                <a href="javascript:void(0)" class="menu-link" onclick="toggleSubmenu(this)">
                    <i class="fa fa-cube menu-icon"></i>
                    <span class="menu-text">Sản phẩm</span>
                    <i class="fa fa-angle-right menu-arrow"></i>
                </a>
                <ul class="submenu">
                    @if($admin->hasPermission('create_product') || $admin->hasRole('admin'))
                    <li><a href="{{URL::to('/add-product')}}" class="submenu-link">
                        <i class="fa fa-plus"></i> Thêm sản phẩm
                    </a></li>
                    @endif
                    <li><a href="{{URL::to('/all-product')}}" class="submenu-link">
                        <i class="fa fa-list"></i> Danh sách sản phẩm
                    </a></li>
                </ul>
            </li>
            @endif

            <!-- Coupons -->
            @if($admin && ($admin->hasPermission('view_coupon') || $admin->hasRole('admin')))
            <li class="menu-item">
                <a href="javascript:void(0)" class="menu-link" onclick="toggleSubmenu(this)">
                    <i class="fa fa-ticket menu-icon"></i>
                    <span class="menu-text">Mã giảm giá</span>
                    <i class="fa fa-angle-right menu-arrow"></i>
                </a>
                <ul class="submenu">
                    @if($admin->hasPermission('create_coupon') || $admin->hasRole('admin'))
                    <li><a href="{{URL::to('/insert-coupon')}}" class="submenu-link">
                        <i class="fa fa-plus"></i> Thêm mã
                    </a></li>
                    @endif
                    <li><a href="{{URL::to('/list-coupon')}}" class="submenu-link">
                        <i class="fa fa-list"></i> Danh sách mã
                    </a></li>
                </ul>
            </li>
            @endif

            <!-- Shipping -->
            @if($admin && ($admin->hasPermission('view_shipping') || $admin->hasRole('admin')))
            <li class="menu-item">
                <a href="{{URL::to('/delivery')}}" class="menu-link">
                    <i class="fa fa-truck menu-icon"></i>
                    <span class="menu-text">Vận chuyển</span>
                </a>
            </li>
            @endif

            <!-- Admin Management -->
            @if($admin && $admin->hasRole('admin'))
            <li class="menu-item">
                <a href="javascript:void(0)" class="menu-link" onclick="toggleSubmenu(this)">
                    <i class="fa fa-users menu-icon"></i>
                    <span class="menu-text">Quản trị viên</span>
                    <i class="fa fa-angle-right menu-arrow"></i>
                </a>
                <ul class="submenu">
                    <li><a href="{{URL::to('/admin/add-admin')}}" class="submenu-link">
                        <i class="fa fa-plus"></i> Thêm admin
                    </a></li>
                    <li><a href="{{URL::to('/admin/manage-admin')}}" class="submenu-link">
                        <i class="fa fa-list"></i> Danh sách admin
                    </a></li>
                </ul>
            </li>

            <li class="menu-item">
                <a href="javascript:void(0)" class="menu-link" onclick="toggleSubmenu(this)">
                    <i class="fa fa-lock menu-icon"></i>
                    <span class="menu-text">Phân quyền</span>
                    <i class="fa fa-angle-right menu-arrow"></i>
                </a>
                <ul class="submenu">
                    <li><a href="{{URL::to('/admin/roles')}}" class="submenu-link">
                        <i class="fa fa-shield"></i> Vai trò
                    </a></li>
                    <li><a href="{{URL::to('/admin/permissions')}}" class="submenu-link">
                        <i class="fa fa-key"></i> Quyền hạn
                    </a></li>
                </ul>
            </li>
            @endif
        </ul>
    </aside>

    <!-- Sidebar Overlay (Mobile) -->
    <div class="sidebar-overlay" onclick="toggleMobileSidebar()"></div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Header -->
        <header class="main-header">
            <div class="mobile-toggle" onclick="toggleMobileSidebar()">
                <i class="fa fa-bars"></i>
            </div>
            
            <div class="search-box">
                <input type="text" placeholder="Tìm kiếm sản phẩm, đơn hàng...">
                <i class="fa fa-search"></i>
            </div>

            <div class="header-right">
                <div class="header-icon">
                    <i class="fa fa-bell"></i>
                    <span class="notification-badge">3</span>
                </div>

                <div class="header-icon">
                    <i class="fa fa-envelope"></i>
                    <span class="notification-badge">5</span>
                </div>

                <div class="user-dropdown">
                    <div class="user-avatar">
                        {{ substr($admin_name ?? 'A', 0, 1) }}
                    </div>
                    <div class="user-info">
                        <div class="user-name">{{ $admin_name ?? 'Admin' }}</div>
                        <div class="user-role">
                            {{ $admin && $admin->role ? $admin->role->role_desc : 'Administrator' }}
                        </div>
                    </div>
                    <i class="fa fa-angle-down"></i>

                    <div class="dropdown-menu-custom">
                        <a href="#" class="dropdown-item-custom">
                            <i class="fa fa-user"></i> Hồ sơ
                        </a>
                        <a href="#" class="dropdown-item-custom">
                            <i class="fa fa-cog"></i> Cài đặt
                        </a>
                        <a href="{{URL::to('/logout')}}" class="dropdown-item-custom">
                            <i class="fa fa-sign-out"></i> Đăng xuất
                        </a>
                    </div>
                    
                </div>
                
            </div>
        </header>

        <!-- Content Area -->
        <section class="content-wrapper">
            @yield('admin_content')
        </section>

        <!-- Footer -->
        <footer class="footer">
            <p>© 2025 E-Commerce Admin Panel. Thiết kế bởi <strong>Your Team</strong></p>
        </footer>
    </div>

    <script src="{{asset('backend/js/bootstrap.js')}}"></script>
    <script src="{{asset('backend/js/jquery.dcjqaccordion.2.7.js')}}"></script>
    <script src="{{asset('backend/js/scripts.js')}}"></script>
    <script src="{{asset('backend/js/jquery.slimscroll.js')}}"></script>
    <script src="{{asset('backend/js/jquery.nicescroll.js')}}"></script>
    <script src="{{asset('backend/js/jquery.scrollTo.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    

    <script>
        // Toggle Sidebar
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('collapsed');
        }

        // Toggle Submenu
        function toggleSubmenu(element) {
            const menuItem = element.parentElement;
            const isOpen = menuItem.classList.contains('open');
            
            // Close all other submenus
            document.querySelectorAll('.menu-item').forEach(item => {
                item.classList.remove('open');
            });
            
            // Toggle current submenu
            if (!isOpen) {
                menuItem.classList.add('open');
            }
        }

        // Mobile Sidebar
        function toggleMobileSidebar() {
            document.getElementById('sidebar').classList.toggle('mobile-show');
        }

        // Highlight active menu
        $(document).ready(function() {
            const currentPath = window.location.pathname;
            $('.menu-link, .submenu-link').each(function() {
                const href = $(this).attr('href');
                if (href && currentPath.includes(href.split('/').pop())) {
                    $(this).addClass('active');
                    $(this).closest('.menu-item').addClass('open');
                }
            });

            // Delivery functions
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