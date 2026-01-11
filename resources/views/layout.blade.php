<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<meta name="description" content="{{ $meta_desc }}">
<meta name="keywords" content="{{ $meta_keyword }}">
<meta name="title" content="{{ $meta_title }}">

<meta name="csrf-token" content="{{ csrf_token() }}">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<link rel="canonical" href="{{ $url_canonical }}">

<meta property="og:url" content="{{ $url_canonical ?? Request::url() }}" />
<meta property="og:type" content="product" />
<meta property="og:title" content="{{ $meta_title ?? 'Tiêu đề mặc định' }}" />
<meta property="og:description" content="{{ Str::limit(strip_tags($meta_desc ?? ''), 200) }}" />
<meta property="og:image" content="{{ $meta_image ?? asset('images/logo.png') }}" />
<meta property="og:image:width" content="1200" />
<meta property="og:image:height" content="630" />
<meta property="og:site_name" content="Tên Website" />
<meta property="og:locale" content="vi_VN" />

    <title>Home | E-Shopper</title>
    <link href="{{asset('public/frontend/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('public/frontend/css/font-awesome.min.css')}}" rel="stylesheet">
    <link href="{{asset('public/frontend/css/prettyPhoto.css')}}" rel="stylesheet">
    <link href="{{asset('public/frontend/css/price-range.css')}}" rel="stylesheet">
    <link href="{{asset('public/frontend/css/animate.css')}}" rel="stylesheet">
    <link href="{{asset('public/frontend/css/main.css')}}" rel="stylesheet">
     
    <link href="{{asset('public/frontend/css/responsive.css')}}" rel="stylesheet">

    <script src="{{asset('public/frontend/js/sweetalert.css')}}"></script>

    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->       
    <link rel="shortcut icon" href="{{('frontend/images/favicon.ico')}}">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="images/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="images/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="images/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="images/ico/apple-touch-icon-57-precomposed.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head><!--/head-->
<style>
    /* Khung chứa các nút liên hệ */
    .contact-widgets {
        position: fixed;
        bottom: 20px;
        right: 20px;
        z-index: 9999;
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    /* Định dạng chung cho nút */
    .contact-btn {
        width: 55px;
        height: 55px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        position: relative; /* Quan trọng để định vị dòng chữ */
        transition: all 0.3s ease;
    }

    /* Tạo dòng chữ khi hover */
    .contact-btn::after {
        content: attr(data-label); /* Lấy nội dung từ thuộc tính data-label */
        position: absolute;
        right: 70px; /* Cách icon một khoảng */
        background: rgba(0, 0, 0, 0.8);
        color: white;
        padding: 5px 12px;
        border-radius: 5px;
        font-size: 14px;
        white-space: nowrap;
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s ease;
        pointer-events: none;
        font-family: Arial, sans-serif;
    }

    /* Hiển thị chữ khi hover */
    .contact-btn:hover::after {
        opacity: 1;
        visibility: visible;
        right: 65px;
    }

    .contact-btn img {
        width: 30px;
        height: 30px;
        z-index: 2;
    }

    /* Màu sắc và Hiệu ứng riêng */
    .btn-call { background-color: #4CAF50; animation: quick-shake 2s infinite; }
    .btn-messenger { background-color: #0084ff; }
    .btn-zalo { background-color: #0068ff; }

    .contact-btn:hover { transform: scale(1.1); }

    @keyframes quick-shake {
        0%, 80%, 100% { transform: rotate(0); }
        85% { transform: rotate(15deg); }
        95% { transform: rotate(-15deg); }
    }
</style>

<div class="contact-widgets">
    <a href="tel:0325927212" class="contact-btn btn-call" data-label="Liên hệ với chúng tôi">
        <img src="https://img.icons8.com/ios-filled/50/ffffff/phone.png" alt="Call">
    </a>

    <a href="https://m.me/YourPage" target="_blank" class="contact-btn btn-messenger" data-label="Chat với chúng tôi">
        <img src="https://upload.wikimedia.org/wikipedia/commons/b/be/Facebook_Messenger_logo_2020.svg" alt="FB">
    </a>

    <a href="https://zalo.me/0325927212" target="_blank" class="contact-btn btn-zalo" data-label="Chat qua Zalo">
        <img src="https://upload.wikimedia.org/wikipedia/commons/9/91/Icon_of_Zalo.svg" alt="Zalo">
    </a>
</div>
  

<body>

    <header id="header"><!--header-->
 
        <div class="header_top"><!--header_top-->
            <div class="container">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="contactinfo">
                            <ul class="nav nav-pills">
                                <li><a href="#"><i class="fa fa-phone"></i> +2 95 01 88 821</a></li>
                                <li><a href="#"><i class="fa fa-envelope"></i> info@domain.com</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="social-icons pull-right">
                            <ul class="nav navbar-nav">
                                <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                                <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                                <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                                <li><a href="#"><i class="fa fa-dribbble"></i></a></li>
                                <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div><!--/header_top-->
        
        <div class="header-middle"><!--header-middle-->
            <div class="container">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="logo pull-left">
                            <a href="index.html"><img src="{{('frontend/images/home/logo.png')}}" alt="" /></a>
                        </div>
                        <div class="btn-group pull-right">
                            <div class="btn-group">
                                <button type="button" class="btn btn-default dropdown-toggle usa" data-toggle="dropdown">
                                    USA
                                    <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a href="#">Canada</a></li>
                                    <li><a href="#">UK</a></li>
                                </ul>
                            </div>
                            
                            <div class="btn-group">
                                <button type="button" class="btn btn-default dropdown-toggle usa" data-toggle="dropdown">
                                    DOLLAR
                                    <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a href="#">Canadian Dollar</a></li>
                                    <li><a href="#">Pound</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <div class="shop-menu pull-right">
                            <ul class="nav navbar-nav">
                               
                                <li><a href="#"><i class="fa fa-star"></i> Yêu thích</a></li>
                                <?php
                                   $customer_id = Session::get('customer_id');
                                   $shipping_id = Session::get('shipping_id');
                                   if($customer_id!=NULL && $shipping_id==NULL){ 
                                 ?>
                                  <li><a href="{{URL::to('/checkout')}}"><i class="fa fa-crosshairs"></i> Thanh toán</a></li>
                                
                                <?php
                                 }elseif($customer_id!=NULL && $shipping_id!=NULL){
                                 ?>
                                 <!-- <li><a href="{{URL::to('/payment')}}"><i class="fa fa-crosshairs"></i> Thanh toán</a></li> -->
                                 <?php 
                                }else{
                                ?>
                                 <li><a href="{{URL::to('/login-checkout')}}"><i class="fa fa-crosshairs"></i> Thanh toán</a></li>
                                <?php
                                 }
                                ?>
                                

                                <!-- <li><a href="{{URL::to('/show-cart')}}"><i class="fa fa-shopping-cart"></i> Giỏ hàng</a></li> -->
                                <li><a href="{{URL::to('/gio-hang')}}"><i class="fa fa-shopping-cart"></i> Giỏ hàng </a></li> 

                                  @if(Session::get('customer_id')) 
                                        {{-- Hiển thị tên nếu đã đăng nhập --}}
                                        <!-- <li><a href="#"><i class="fa fa-user"></i> {{ Session::get('customer_name') }}</a></li> -->
                                        <div class="btn-group">
                                        <button type="button" class="btn fa fa-user" data-toggle="dropdown">
                                            {{ Session::get('customer_name') }}
                                           
                                        </button>
                                        <ul class="dropdown-menu">
                                          <li>
                                            <a href="{{ route('customer.edit', ['customer_id' => Session::get('customer_id')]) }}">
                                                Chỉnh sửa thông tin cá nhân
                                            </a>
                                        </li>
                                            <li><a href="#">UK</a></li>
                                        </ul>
                                        </div>
                                      <li>
                                            <a href="{{URL::to('/logout-checkout')}}" 
                                            onclick="return confirm('Bạn có chắc chắn muốn đăng xuất không?')">
                                            <i class="fa fa-lock"></i> Đăng xuất
                                            </a>
                                        </li>
                                        
                                    @else
                                        {{-- Hiển thị nút Đăng nhập nếu chưa có Session --}}
                                        <li><a href="{{URL::to('/login-checkout')}}"><i class="fa fa-lock"></i> Đăng nhập</a></li>
                                    @endif
                                      
      
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            
        </div><!--/header-middle-->
    
        <div class="header-bottom"><!--header-bottom-->
            <div class="container">
                <div class="row">
                    <div class="col-sm-7">
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                        </div>
                        <div class="mainmenu pull-left">
                            <ul class="nav navbar-nav collapse navbar-collapse">
                                <li><a href="{{URL::to('/trang-chu')}}" class="active">Trang chủ</a></li>
                                <li class="dropdown"><a href="#">Sản phẩm<i class="fa fa-angle-down"></i></a>
                                    <ul role="menu" class="sub-menu">
                                        <li><a href="shop.html">Products</a></li>
                                       
                                    </ul>
                                </li> 
                                <li class="dropdown"><a href="#">Tin tức<i class="fa fa-angle-down"></i></a>
                               
                                </li> 
                                <li><a href="{{URL::to('/my-orders')}}">Đơn hàng</a></li>
                                <li><a href="{{URL::to('/contact')}}">Liên hệ</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-5">
                        <form action="{{URL::to('/tim-kiem')}}" method="POST">
                            {{csrf_field()}}
                        <div class="search_box pull-right">
                            <input type="text" name="keywords_submit" placeholder="Tìm kiếm sản phẩm"/>
                            <input type="submit" style="margin-top:0;color:#666" name="search_items" class="btn btn-primary btn-sm" value="Tìm kiếm">
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div><!--/header-bottom-->
    </header><!--/header-->
      <!-- @if(session('message') || session('error'))
            <div id="flash-message"
                class="alert {{ session('error') ? 'alert-danger' : 'alert-success' }} text-center">
                {{ session('error') ?? session('message') }}
            </div>

            <script>
                setTimeout(() => {
                    const msg = document.getElementById('flash-message');
                    if (msg) msg.remove();
                }, 2000);
            </script>
        @endif -->
        <script>
    @if(session('message'))
        Swal.fire({
            icon: 'success',
            title: 'Thành công!',
            text: "{{ session('message') }}",
            timer: 2000,
            showConfirmButton: false
        });
    @endif

    @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Lỗi rồi!',
            text: "{{ session('error') }}",
            timer: 2000,
            showConfirmButton: false
        });
    @endif
</script>
    <section id="slider"><!--slider-->
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
    <div id="slider-carousel" class="carousel slide" data-ride="carousel">
        

    <div class="carousel-inner">
    @if(count($banner) > 0)
        @foreach($banner as $key => $ban)
            <div class="item {{ $key == 0 ? 'active' : '' }}">
                <div class="col-sm-6">
                    <h1><span>E</span>-SHOPPER</h1>
                    <p>{{ $ban->banner_desc }}</p>
                    <button type="button" class="btn btn-default get">Get it now</button>
                </div>
                <div class="col-sm-6">
                    <img src="{{ asset('public/uploads/banner/' . $ban->banner_image) }}"
                        width="100%" 
                        class="img-responsive img" 
                        alt="{{ $ban->banner_desc ?? 'Banner' }}"
                        onerror="this.src='{{ asset('public/frontend/images/no-image.jpg') }}'">
                </div>
            </div>
        @endforeach
    @else
        <div class="item active">
            <div class="col-sm-12 text-center">
                <p>Aucune bannière disponible</p>
            </div>
        </div>
    @endif
</div>

        {{-- Controls --}}
        <a href="#slider-carousel" class="left control-carousel hidden-xs" data-slide="prev">
            <i class="fa fa-angle-left"></i>
        </a>
        <a href="#slider-carousel" class="right control-carousel hidden-xs" data-slide="next">
            <i class="fa fa-angle-right"></i>
        </a>

    </div>
</div>

            </div>
        </div>
    </section><!--/slider-->
    
    <section>
        <div class="container">
            <div class="row">
                <div class="col-sm-3">
                    <div class="left-sidebar">
                        <h2>Danh mục sản phẩm</h2>
                        <div class="panel-group category-products" id="accordian"><!--category-productsr-->
                          @foreach($cate_product as $key => $cate)
                           
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title"><a href="{{URL::to('/danh-muc-san-pham/'.$cate->category_id)}}">{{$cate->category_name}}</a></h4>
                                </div>
                            </div>
                        @endforeach
                        </div><!--/category-products-->
                    
                        <div class="brands_products"><!--brands_products-->
                            <h2>Thương hiệu sản phẩm</h2>
                            <div class="brands-name">
                                <ul class="nav nav-pills nav-stacked">
                                    @foreach($brand_product as $key => $brand)
                                    <li><a href="{{URL::to('/thuong-hieu-san-pham/'.$brand->brand_id)}}"> <span class="pull-right">(50)</span>{{$brand->brand_name}}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                        </div><!--/brands_products-->
                        
                     
                    
                    </div>
                </div>
                
                <div class="col-sm-9 padding-right">

                   @yield('content')
                    
                </div>
            </div>
        </div>
    </section>
    
    <footer id="footer"><!--Footer-->
        <div class="footer-top">
            <div class="container">
                <div class="row">
                    <div class="col-sm-2">
                        <div class="companyinfo">
                            <h2><span>e</span>-shopper</h2>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit,sed do eiusmod tempor</p>
                        </div>
                    </div>
                    <div class="col-sm-7">
                        <div class="col-sm-3">
                            <div class="video-gallery text-center">
                                <a href="#">
                                    <div class="iframe-img">
                                        <img src="{{('public/frontend/images/iframe1.png')}}" alt="" />
                                    </div>
                                    <div class="overlay-icon">
                                        <i class="fa fa-play-circle-o"></i>
                                    </div>
                                </a>
                                <p>Circle of Hands</p>
                                <h2>24 DEC 2014</h2>
                            </div>
                        </div>
                        
                        <div class="col-sm-3">
                            <div class="video-gallery text-center">
                                <a href="#">
                                    <div class="iframe-img">
                                         <img src="{{('frontend/images/iframe2.png')}}" alt="" />
                                    </div>
                                    <div class="overlay-icon">
                                        <i class="fa fa-play-circle-o"></i>
                                    </div>
                                </a>
                                <p>Circle of Hands</p>
                                <h2>24 DEC 2014</h2>
                            </div>
                        </div>
                        
                        <div class="col-sm-3">
                            <div class="video-gallery text-center">
                                <a href="#">
                                    <div class="iframe-img">
                                         <img src="{{('frontend/images/iframe3.png')}}" alt="" />
                                    </div>
                                    <div class="overlay-icon">
                                        <i class="fa fa-play-circle-o"></i>
                                    </div>
                                </a>
                                <p>Circle of Hands</p>
                                <h2>24 DEC 2014</h2>
                            </div>
                        </div>
                        
                        <div class="col-sm-3">
                            <div class="video-gallery text-center">
                                <a href="#">
                                    <div class="iframe-img">
                                         <img src="{{('frontend/images/iframe4.png')}}" alt="" />
                                    </div>
                                    <div class="overlay-icon">
                                        <i class="fa fa-play-circle-o"></i>
                                    </div>
                                </a>
                                <p>Circle of Hands</p>
                                <h2>24 DEC 2014</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="address">
                            <img src="public/frontend/images/map.png" alt="" />
                            <p>505 S Atlantic Ave Virginia Beach, VA(Virginia)</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="footer-widget">
            <div class="container">
                <div class="row">
                    <div class="col-sm-2">
                        <div class="single-widget">
                            <h2>Service</h2>
                            <ul class="nav nav-pills nav-stacked">
                                <li><a href="#">Online Help</a></li>
                                <li><a href="#">Contact Us</a></li>
                                <li><a href="#">Order Status</a></li>
                                <li><a href="#">Change Location</a></li>
                                <li><a href="#">FAQ’s</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="single-widget">
                            <h2>Quock Shop</h2>
                            <ul class="nav nav-pills nav-stacked">
                                <li><a href="#">T-Shirt</a></li>
                                <li><a href="#">Mens</a></li>
                                <li><a href="#">Womens</a></li>
                                <li><a href="#">Gift Cards</a></li>
                                <li><a href="#">Shoes</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="single-widget">
                            <h2>Policies</h2>
                            <ul class="nav nav-pills nav-stacked">
                                <li><a href="#">Terms of Use</a></li>
                                <li><a href="#">Privecy Policy</a></li>
                                <li><a href="#">Refund Policy</a></li>
                                <li><a href="#">Billing System</a></li>
                                <li><a href="#">Ticket System</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="single-widget">
                            <h2>About Shopper</h2>
                            <ul class="nav nav-pills nav-stacked">
                                <li><a href="#">Company Information</a></li>
                                <li><a href="#">Careers</a></li>
                                <li><a href="#">Store Location</a></li>
                                <li><a href="#">Affillate Program</a></li>
                                <li><a href="#">Copyright</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-3 col-sm-offset-1">
                        <div class="single-widget">
                            <h2>About Shopper</h2>
                            <form action="#" class="searchform">
                                <input type="text" placeholder="Your email address" />
                                <button type="submit" class="btn btn-default"><i class="fa fa-arrow-circle-o-right"></i></button>
                                <p>Get the most recent updates from <br />our site and be updated your self...</p>
                            </form>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
        
        <div class="footer-bottom">
            <div class="container">
                <div class="row">
                    <p class="pull-left">Copyright © 2013 E-SHOPPER Inc. All rights reserved.</p>
                    <p class="pull-right">Designed by <span><a target="_blank" href="http://www.themeum.com">Themeum</a></span></p>
                </div>
            </div>
        </div>
        
    </footer><!--/Footer-->
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  
    <script src="{{asset('public/frontend/js/sweetalert.js')}}"></script>
    <script src="{{asset('public/frontend/js/jquery.js')}}"></script>
    <script src="{{asset('public/frontend/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('public/frontend/js/jquery.scrollUp.min.js')}}"></script>
    <script src="{{asset('public/frontend/js/price-range.js')}}"></script>
    <script src="{{asset('public/frontend/js/jquery.prettyPhoto.js')}}"></script>
    <script src="{{asset('public/frontend/js/main.js')}}"></script>

    <script>
    
$(document).ready(function(){

    $('.add-to-cart').click(function(){
        
        var id = $(this).data('id_product');
        var product_id    = $('.cart_product_id_' + id).val();
        var product_name  = $('.cart_product_name_' + id).val();
        var product_image = $('.cart_product_image_' + id).val();
        var product_price = $('.cart_product_price_' + id).val();
        var product_qty   = $('.cart_product_qty_' + id).val();
        var _token        = $('input[name="_token"]').val();
       
        $.ajax({
            url: "{{ url('/add-cart-ajax') }}",
            method: "POST",
            data: {
                product_id: product_id,
                product_name: product_name,
                product_image: product_image,
                product_price: product_price,
                product_qty: product_qty,
                _token: _token
            },
            success: function (data) {
                // --- PHẦN MỚI THÊM: KIỂM TRA LỖI TỒN KHO ---
                if(data.status == 'error'){
                    Swal.fire({
                        icon: 'error',
                        title: 'Không đủ hàng!',
                        text: data.message, // Hiển thị thông báo từ Controller
                        confirmButtonText: 'Đã hiểu'
                    });
                } 
                // --- NẾU THÀNH CÔNG THÌ CHẠY CODE CŨ ---
                else {
                    var cartList = '';
                    // Kiểm tra xem data.cart có tồn tại không trước khi lặp
                    if(data.cart){
                        data.cart.forEach(function(item, index){
                            cartList += (index+1) + '. ' + item.product_name 
                                    + ' - SL: ' + item.product_qty 
                                    + ' - Giá: ' + Number(item.product_price).toLocaleString() + 'đ\n';
                        });
                    }

                    Swal.fire({
                        title: 'Đã thêm sản phẩm vào giỏ hàng',
                        html: '<pre style="text-align:left; font-family: sans-serif;">' + cartList + '</pre>',
                        icon: 'success',
                        showCancelButton: true,
                        cancelButtonText: 'Xem tiếp',
                        confirmButtonText: 'Đi đến giỏ hàng',
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33'
                    }).then((result) => {
                        if(result.isConfirmed){
                            window.location.href = "{{ url('/gio-hang') }}";
                        }
                    });
                }
            },
            // Xử lý lỗi hệ thống (500, 404)
            error: function() {
                Swal.fire('Lỗi!', 'Có lỗi xảy ra, vui lòng thử lại sau.', 'error');
            }
        });
    });

});
</script>
<script>
    $(document).ready(function(){
    $('.choose').on('change', function(){
    var action = $(this).attr('id');
    var _token = $('input[name="_token"]').val();
    var result = '';
    
    if(action == 'city'){
        var matp = $(this).val();
        result = 'province';
        $.ajax({
            url: '{{ URL::to("/select-delivery-home") }}',
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
            url: '{{ URL::to("/select-delivery-home") }}',
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

    <script>
        $(document).ready(function(){
            $('.calculate_devilevy').click(function(){

                var matp  = $('.city').val();
                var maqh  = $('.province').val();
                var maxa  = $('.wards').val(); 
                var _token = $('input[name="_token"]').val();

                if(matp == '' || maqh == '' || maxa == ''){
                    alert('Vui lòng chọn đầy đủ thông tin để tính phí vận chuyển');
                    return false;
                }

                $.ajax({
                    url: '{{ URL::to("/calculate-fee") }}',
                    method: 'POST',
                    data: {
                        matp: matp,
                        maqh: maqh,
                        maxa: maxa,
                        _token: _token
                    },
                    success: function(){
                        alert('Tính phí vận chuyển thành công');
                        location.reload(); 
                    

                    },
                    error: function(xhr){
                        console.log(xhr.responseText);
                    }
                });
            });
        });
</script>
<script>
$(document).ready(function () {

    $('.send_order').click(function (e) {
        e.preventDefault(); // chặn submit form mặc định

        Swal.fire({
            title: 'Xác nhận thanh toán',
            text: 'Bạn có chắc chắn muốn tiến hành thanh toán cho đơn hàng này không?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Có, thanh toán ngay',
            cancelButtonText: 'Không, quay lại'
        }).then((result) => {

            if (result.isConfirmed) {

                var shipping_name    = $('.shipping_name').val();
                var shipping_phone   = $('.shipping_phone').val();
                var shipping_email   = $('.shipping_email').val();
                var shipping_address = $('.shipping_address').val();
                var shipping_notes   = $('.shipping_notes').val();
                var shipping_method  = $('.payment_select').val();
                var order_fee        = $('.order_fee').val();
                var order_coupon     = $('.order_coupon').val();
                var _token           = $('input[name="_token"]').val();

                $.ajax({
                    url: "{{ url('/confirm-order') }}",
                    method: "POST",
                    data: {
                        shipping_name: shipping_name,
                        shipping_email: shipping_email,
                        shipping_phone: shipping_phone,
                        shipping_address: shipping_address,
                        shipping_notes: shipping_notes,
                        shipping_method: shipping_method,
                        order_fee: order_fee,
                        order_coupon: order_coupon,
                        _token: _token
                    },
                    success: function (data) {

                        Swal.fire(
                            'Thanh toán thành công!',
                            'Đơn hàng của bạn đã được xử lý.',
                            'success'
                        );

                        setTimeout(function () {
                            location.reload();
                        }, 3000);
                    },
                    error: function () {
                        Swal.fire(
                            'Lỗi!',
                            'Có lỗi xảy ra, vui lòng thử lại.',
                            'error'
                        );
                    }
                });

            } else {
                Swal.fire(
                    'Đã hủy',
                    'Bạn đã hủy thanh toán.',
                    'info'
                );
            }

        });
    });

});

</script>
<script>
    $('.confirm-order').click(function(){
    // ... lấy các thông tin vận chuyển ...

    $.ajax({
        url: "{{url('/confirm-order')}}",
        method: 'POST',
        data: { /* các biến dữ liệu của bạn */ },
        success: function(data){
            // Nếu thành công thì hiện thông báo và chuyển trang
            Swal.fire("Thành công!", data.message, "success").then(() => {
                window.location.href = "{{url('/thanks')}}";
            });
        },
        error: function(xhr){
            // Nếu kho không đủ, hàm error sẽ nhận response code 400
            var res = JSON.parse(xhr.responseText);
            Swal.fire({
                icon: 'error',
                title: 'Lỗi đặt hàng',
                text: res.message
            });
        }
    });
});
</script>


</body>
</html>