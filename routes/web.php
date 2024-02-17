<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ColorController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\HomeBannerController;
use App\Http\Controllers\Admin\InitController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProductReviewController;
use App\Http\Controllers\Admin\SizeController;
use App\Http\Controllers\Admin\TaxController;
use App\Http\Controllers\Frontend\FrontendController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::controller(FrontendController::class)->group(function () {
    Route::get('/', 'index');
    Route::get('/product/{slug}', 'product');
    Route::get('category/{slug}', 'category');
    Route::get('shop', 'shop');
    Route::get('search/{str}', 'search');
    Route::post('add_to_cart', 'add_to_cart');
    Route::get('cart', 'cart');
    Route::get('reg', 'reg');
    Route::get('login', 'login');
    Route::post('apply_coupon_code','apply_coupon_code');
    Route::post('remove_coupon_code','remove_coupon_code');
    Route::post('product_review_process','product_review_process');
    Route::post('reg_process', 'reg_process')->name('reg.reg_process');
    Route::post('login_process', 'login_process')->name('login.login_process');
    Route::get('logout', function () {
        session()->forget('FRONT_USER_LOGIN');
        session()->forget('FRONT_USER_ID');
        session()->forget('FRONT_USER_NAME');
        session()->forget('USER_TEMP_ID');
        return redirect('/');
    });
    Route::get('t', 't');
    Route::get('/verification/{id}', 'email_verification');
    Route::get('/checkout', 'checkout');
    Route::post('/place_order', 'place_order');
    Route::get('/order_placed', 'order_placed');
    Route::get('/order_fail', 'order_fail');
    Route::group(['middleware' => 'user_auth'], function () {
        Route::get('/order', 'order');
        Route::get('/order_detail/{id}', 'order_detail');
    });
    Route::get('forgot_password', 'forgot_password');
    Route::post('forgot_passwordb', 'forgot_passwordb');
    Route::get('/forgot_password_change/{id}', 'forgot_password_change');
    Route::post('forgot_password_change_process', 'forgot_password_change_process');
    Route::group(['middleware' => 'user_auth'], function () {
        Route::get('account', 'account');
        Route::post('account_process', 'account_process');
    });
});

Route::controller(AdminController::class)->group(function () {
    Route::get('admin', 'index');
    Route::post('admin/auth', 'auth')->name('admin.auth');
});

Route::group(['middleware' => 'admin_auth'], function () {
    Route::controller(AdminController::class)->group(function () {
        Route::get('admin/dashboard', 'dashboard');
    });

    Route::controller(CategoryController::class)->group(function () {
        Route::get('admin/category', 'index');
        Route::get('admin/category/manage_category', 'manage_category');
        Route::get('admin/category/manage_category/{id}', 'manage_category');
        Route::post('admin/category/manage_category_process', 'manage_category_process')->name('category.manage_category_process');
        Route::get('admin/category/delete/{id}', 'delete');
        Route::get('admin/category/status/{status}/{id}', 'status');
    });

    Route::controller(CouponController::class)->group(function () {
        Route::get('admin/coupon', 'index');
        Route::get('admin/coupon/manage_coupon', 'manage_coupon');
        Route::get('admin/coupon/manage_coupon/{id}', 'manage_coupon');
        Route::post('admin/coupon/manage_coupon_process', 'manage_coupon_process')->name('coupon.manage_coupon_process');
        Route::get('admin/coupon/delete/{id}', 'delete');
        Route::get('admin/coupon/status/{status}/{id}', 'status');
    });

    Route::controller(SizeController::class)->group(function () {
        Route::get('admin/size', 'index');
        Route::get('admin/size/manage_size', 'manage_size');
        Route::get('admin/size/manage_size/{id}', 'manage_size');
        Route::post('admin/size/manage_size_process', 'manage_size_process')->name('size.manage_size_process');
        Route::get('admin/size/delete/{id}', 'delete');
        Route::get('admin/size/status/{status}/{id}', 'status');
    });
    Route::controller(MenuController::class)->group(function () {
        Route::get('admin/menu', 'index');
        Route::get('admin/menu/manage_menu', 'manage_menu');
        Route::get('admin/menu/manage_menu/{id}', 'manage_menu');
        Route::post('admin/menu/manage_menu_process', 'manage_menu_process')->name('menu.manage_menu_process');
        Route::get('admin/menu/delete/{id}', 'delete');
        Route::get('admin/menu/status/{status}/{id}', 'status');
    });
    Route::controller(ColorController::class)->group(function () {
        Route::get('admin/color', 'index');
        Route::get('admin/color/manage_color', 'manage_color');
        Route::get('admin/color/manage_color/{id}', 'manage_color');
        Route::post('admin/color/manage_color_process', 'manage_color_process')->name('color.manage_color_process');
        Route::get('admin/color/delete/{id}', 'delete');
        Route::get('admin/color/status/{status}/{id}', 'status');
    });
    Route::controller(ProductController::class)->group(function () {
        Route::get('admin/product', 'index');
        Route::get('admin/product/manage_product', 'manage_product');
        Route::get('admin/product/manage_product/{id}', 'manage_product');
        Route::post('admin/product/manage_producty_process', 'manage_product_process')->name('product.manage_product_process');
        Route::get('admin/product/delete/{id}', 'delete');
        Route::get('admin/product/status/{status}/{id}', 'status');
        Route::get('admin/product/product_attr_delete/{paid}/{pid}', 'product_attr_delete');
        Route::get('admin/product/product_images_delete/{paid}/{pid}', 'product_images_delete');
    });
    Route::controller(BrandController::class)->group(function () {
        Route::get('admin/brand', 'index');
        Route::get('admin/brand/manage_brand', 'manage_brand');
        Route::get('admin/brand/manage_brand/{id}', 'manage_brand');
        Route::post('admin/brand/manage_brand_process', 'manage_brand_process')->name('brand.manage_brand_process');
        Route::get('admin/brand/delete/{id}', 'delete');
        Route::get('admin/brand/status/{status}/{id}', 'status');
    });
    Route::controller(TaxController::class)->group(function () {
        Route::get('admin/tax', 'index');
        Route::get('admin/tax/manage_tax', 'manage_tax');
        Route::get('admin/tax/manage_tax/{id}', 'manage_tax');
        Route::post('admin/tax/manage_tax_process', 'manage_tax_process')->name('tax.manage_tax_process');
        Route::get('admin/tax/delete/{id}', 'delete');
        Route::get('admin/tax/status/{status}/{id}', 'status');
    });
    Route::controller(CustomerController::class)->group(function () {
        Route::get('admin/customer', 'index');
        Route::get('admin/customer/show/{id}', 'show');
        Route::get('admin/customer/status/{status}/{id}', 'status');
    });
    Route::controller(HomeBannerController::class)->group(function () {

        Route::get('admin/home_banner', 'index');
        Route::get('admin/home_banner/manage_home_banner', 'manage_home_banner');
        Route::get('admin/home_banner/manage_home_banner/{id}', 'manage_home_banner');
        Route::post('admin/home_banner/manage_home_banner_process', 'manage_home_banner_process')->name('home_banner.manage_home_banner_process');
        Route::get('admin/home_banner/delete/{id}', 'delete');
        Route::get('admin/home_banner/status/{status}/{id}', 'status');
    });
    Route::controller(OrderController::class)->group(function () {
        Route::get('admin/order', 'index');
        Route::get('admin/order_detail/{id}', 'order_detail');
        Route::post('admin/order_detail/{id}', 'update_track_detail');
        Route::get('admin/update_payemnt_status/{status}/{id}', 'update_payemnt_status');
        Route::get('admin/update_order_status/{status}/{id}', 'update_order_status');
    });
    Route::controller(ProductReviewController::class)->group(function () {
        Route::get('admin/product_review', 'index');
        Route::get('admin/update_product_review_status/{status}/{id}', 'update_product_review_status');
    });
    Route::controller(InitController::class)->group(function () {
        Route::get('admin/init', 'index');
        Route::get('admin/init_install', 'init_i');
        Route::post('admin/init_edit/{id}', 'init_e')->name('init.edit');
    });
    Route::get('admin/logout', function () {
        session()->forget('ADMIN_LOGIN');
        session()->forget('ADMIN_ID');
        session()->flash('error', 'Logout sucessfully');
        return redirect('admin');
    });
    Route::get('/stor_link', function () {
        Artisan::call('storage:link');
        return 'Link Ok';
    });
});

Route::get('/clear', function () {
    Artisan::call('route:cache');
    Artisan::call('config:cache');
    Artisan::call('cache:clear');
    Artisan::call('view:clear');
    return 'clear';
});