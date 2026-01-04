<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CategoryProductController;
use App\Http\Controllers\BrandProduct;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\DeliveryController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\OrderController;
use Barryvdh\DomPDF\Facade\PDF;
use App\Http\Controllers\BannerController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// -------------------- FRONTEND --------------------
Route::get('/', [HomeController::class, 'index']);
Route::get('/trang-chu', [HomeController::class, 'index']);
Route::post('/tim-kiem', [HomeController::class, 'search']);

// Danh mục sản phẩm trang chủ
Route::get('/danh-muc-san-pham/{slug_category_product}', [CategoryProductController::class, 'show_category_home']);
Route::get('/thuong-hieu-san-pham/{brand_slug}', [BrandProduct::class, 'show_brand_home']);
Route::get('/chi-tiet-san-pham/{product_slug}', [ProductController::class, 'details_product']);

// -------------------- BACKEND --------------------
Route::get('/admin', [AdminController::class, 'index']);
Route::get('/dashboard', [AdminController::class, 'show_dashboard']);
Route::get('/logout', [AdminController::class, 'logout']);
Route::post('/admin-dashboard', [AdminController::class, 'dashboard']);
Route::post('/filter-by-date', [AdminController::class, 'filter_by_date']);



// -------------------- CATEGORY PRODUCT --------------------
Route::get('/add-category-product', [CategoryProductController::class, 'add_category_product']);
Route::get('/edit-category-product/{category_product_id}', [CategoryProductController::class, 'edit_category_product']);
Route::get('/delete-category-product/{category_product_id}', [CategoryProductController::class, 'delete_category_product']);
Route::get('/all-category-product', [CategoryProductController::class, 'all_category_product']);

Route::post('/admin/export-product', [CategoryProductController::class, 'export_csv']);
Route::post('/admin/import-csv', [CategoryProductController::class, 'import_csv']);

Route::get('/unactive-category-product/{category_product_id}', [CategoryProductController::class, 'unactive_category_product']);
Route::get('/active-category-product/{category_product_id}', [CategoryProductController::class, 'active_category_product']);

Route::post('/save-category-product', [CategoryProductController::class, 'save_category_product']);
Route::post('/update-category-product/{category_product_id}', [CategoryProductController::class, 'update_category_product']);

// -------------------- BRAND PRODUCT --------------------
Route::get('/add-brand-product', [BrandProduct::class, 'add_brand_product']);
Route::get('/edit-brand-product/{brand_product_id}', [BrandProduct::class, 'edit_brand_product']);
Route::get('/delete-brand-product/{brand_product_id}', [BrandProduct::class, 'delete_brand_product']);
Route::get('/all-brand-product', [BrandProduct::class, 'all_brand_product']);

Route::get('/unactive-brand-product/{brand_product_id}', [BrandProduct::class, 'unactive_brand_product']);
Route::get('/active-brand-product/{brand_product_id}', [BrandProduct::class, 'active_brand_product']);

Route::post('/save-brand-product', [BrandProduct::class, 'save_brand_product']);
Route::post('/update-brand-product/{brand_product_id}', [BrandProduct::class, 'update_brand_product']);

// -------------------- PRODUCT --------------------
Route::get('/add-product', [ProductController::class, 'add_product']);
Route::get('/edit-product/{product_id}', [ProductController::class, 'edit_product']);
Route::get('/delete-product/{product_id}', [ProductController::class, 'delete_product']);
Route::get('/all-product', [ProductController::class, 'all_product']);

Route::get('/unactive-product/{product_id}', [ProductController::class, 'unactive_product']);
Route::get('/active-product/{product_id}', [ProductController::class, 'active_product']);

Route::post('/save-product', [ProductController::class, 'save_product']);
Route::post('/update-product/{product_id}', [ProductController::class, 'update_product']);

Route::post('/admin/export-product', [ProductController::class, 'export_product']);
Route::post('/admin/import-product', [ProductController::class, 'import_product']);

// -------------------- CART --------------------
Route::post('/update-cart-quantity', [CartController::class, 'update_cart_quantity']);
Route::post('/save-cart', [CartController::class, 'save_cart']);
Route::get('/show-cart', [CartController::class, 'show_cart']);
Route::get('/delete-to-cart/{rowId}', [CartController::class, 'delete_to_cart']);
// AJAX add to cart
Route::post('/add-cart-ajax', [CartController::class, 'add_cart_ajax'])->name('cart.add');
Route::get('/gio-hang', [CartController::class, 'gio_hang'])->name('cart.show');
Route::post('/update-cart', [CartController::class, 'update_cart'])->name('cart.update');
Route::delete('/delete-cart/{session_id}', [CartController::class, 'delete_cart'])
    ->name('cart.delete');
Route::get('/delete-all-cart', [CartController::class, 'delete_all_cart'])->name('cart.delete.all');
// -------------------- COUPON --------------------
Route::post('/check-coupon', [CartController::class, 'check_coupon'])->name('check_coupon');
Route::get('/insert-coupon', [CouponController::class, 'insert_coupon'])->name('insert.coupon');
Route::post('/insert-coupon-code', [CouponController::class, 'insert_coupon_code'])->name('insert.coupon.code');
Route::get('/list-coupon', [CouponController::class, 'list_coupon'])->name('list.coupon');
Route::get('/delete-coupon/{coupon_id}', [CouponController::class, 'delete_coupon'])->name('delete.coupon');
Route::get('/unset-coupon', [CouponController::class, 'unset_coupon'])->name('unset.coupon');

// -------------------- CHECKOUT --------------------
Route::get('/login-checkout', [CheckoutController::class, 'login_checkout'])->name('login.checkout');
Route::get('/logout-checkout', [CheckoutController::class, 'logout_checkout']);
Route::post('/add-customer', [CheckoutController::class, 'add_customer']);
Route::post('/order-place', [CheckoutController::class, 'order_place']);
Route::post('/login-customer', [CheckoutController::class, 'login_customer']);
Route::get('/checkout', [CheckoutController::class, 'checkout'])->name('checkout');
Route::get('/payment', [CheckoutController::class, 'payment']);
Route::post('/save-checkout-customer', [CheckoutController::class, 'save_checkout_customer']);
Route::post('/save-checkout-customer', [CheckoutController::class, 'save_checkout_customer']);
Route::post('/select-delivery-home', [CheckoutController::class, 'select_delivery_home'])->name('select-delivery-home');
Route::post('/calculate-fee', [CheckoutController::class, 'calculate_fee'])->name('calculate-fee');
Route::get('/unset-fee', [CheckoutController::class, 'unset_fee'])->name('unset.fee');
Route::post('/confirm-order', [CheckoutController::class, 'confirm_order'])->name('confirm.order');

// -------------------- ORDER --------------------

Route::get('/manage-order', [OrderController::class, 'manage_order']);
Route::get('/view-order/{order_code}', [OrderController::class, 'view_order']);
Route::get('/print-order/{checkout_code}', [OrderController::class, 'print_order']);
Route::post('/update-order-status', [OrderController::class, 'update_order_status']);
Route::post('/add-cart-ajax', [CartController::class, 'add_cart_ajax']);

// Route::get('/manage-order', [CheckoutController::class, 'manage_order']);
// Route::get('/view-order/{orderId}', [CheckoutController::class, 'view_order']);
Route::get('/delete-order/{orderId}', [CheckoutController::class, 'delete_order']);

// -------------------- PURCHASE ORDER --------------------
Route::get('/my-orders', [CheckoutController::class, 'my_orders'])->name('my.orders');
//  -------------------- edit SHIPPING --------------------
Route::get('/edit-shipping/{shipping_id}', [CheckoutController::class, 'edit_shipping']);
Route::post('/update-shipping/{shipping_id}', [CheckoutController::class, 'update_shipping']);
Route::get('/cancel-order/{order_id}', [CheckoutController::class, 'cancel_order']);


// -------------------- CONTACT INFORMATION --------------------use App\Http\Controllers\Admin\ContactController;

use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Frontend\HomeController as FrontHome;
Route::get('/contact', [FrontHome::class, 'contact'])->name('frontend.contact');
Route::prefix('admin')->middleware('auth')->group(function () {
    Route::get('/contact', [ContactController::class, 'index'])->name('admin.contact.index');
    Route::post('/contact', [ContactController::class, 'store'])->name('admin.contact.store');
});

// --------------------authentication rols --------------------
use App\Http\Controllers\AuthController;
Route::get('/register-auth', [AuthController::class, 'register_auth']);
Route::get('/login-auth', [AuthController::class, 'login_auth']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// -------------------- delivery--------------------
Route::get('/delivery', [DeliveryController::class, 'delivery']);
Route::post('/select-delivery', [DeliveryController::class, 'select_delivery']);
Route::post('/save-delivery', [DeliveryController::class, 'save_delivery']);
Route::get('/select-feeship', [DeliveryController::class, 'select_feeship']);
Route::post('/update-feeship', [DeliveryController::class, 'update_feeship']);

Route::post('/update-delivery', [DeliveryController::class, 'update_delivery']);

// -------------------- banner--------------------
Route::get('/manage-banner', [BannerController::class, 'manage_banner']);
Route::get('/add-banner', [BannerController::class, 'add_banner']);
Route::post('/insert-banner', [BannerController::class, 'insert_banner'])->name('insert.banner');
Route::get('/unactive-banner/{banner_id}', [BannerController::class, 'unactive_banner']);
Route::get('/active-banner/{banner_id}', [BannerController::class, 'active_banner']);
Route::get('/delete-banner/{banner_id}', [BannerController::class, 'delete_banner']);

