<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//Frontend 

use Illuminate\Support\Facades\Route;

Route::get('/','HomeController@index' );
Route::get('/trang-chu','HomeController@index');
Route::post('/tim-kiem','HomeController@search');

//list category
Route::get('/danh-muc/{slug_category_product}','CategoryProduct@show_category_home');
Route::get('/thuong-hieu/{brand_slug}','BrandProduct@show_brand_home');
Route::get('/chi-tiet/{product_slug}','ProductController@details_product');

//Backend
// Route::get('/admin','AdminController@index');
Route::get('/dashboard','AdminController@show_dashboard');
// Route::get('/logout','AdminController@logout');
// Route::post('/admin-dashboard','AdminController@dashboard');
Route::post('/filter-by-date','AdminController@filter_by_date');
Route::post('/dashboard-filter','AdminController@dashboard_filter');
Route::post('/day-order','AdminController@day_order');
Route::get('/order-date','AdminController@order_date');


//Authentication roles
Route::get('/register-auth','AuthController@register_auth');
Route::post('/register','AuthController@register');
Route::get('/admin','AuthController@admin');
Route::post('/login','AuthController@login');
Route::get('/logout-auth','AuthController@logout_auth');

//Category Product
Route::get('/add-category-product','CategoryProduct@add_category_product')->middleware('auth.roles');
Route::get('/edit-category-product/{category_product_id}','CategoryProduct@edit_category_product')->middleware('auth.roles');
Route::get('/delete-category-product/{category_product_id}','CategoryProduct@delete_category_product');
Route::get('/all-category-product','CategoryProduct@all_category_product');

Route::post('/save-category-product','CategoryProduct@save_category_product');
Route::post('/update-category-product/{category_product_id}','CategoryProduct@update_category_product');

Route::get('/unactive-category-product/{category_product_id}','CategoryProduct@unactive_category_product');
Route::get('/active-category-product/{category_product_id}','CategoryProduct@active_category_product');

//Send Mail 
Route::get('/send-mail','HomeController@send_mail');


//Brand Product
Route::get('/add-brand-product','BrandProduct@add_brand_product')->middleware('auth.roles');
Route::get('/edit-brand-product/{brand_product_id}','BrandProduct@edit_brand_product')->middleware('auth.roles');
Route::get('/delete-brand-product/{brand_product_id}','BrandProduct@delete_brand_product');
Route::get('/all-brand-product','BrandProduct@all_brand_product');

Route::get('/unactive-brand-product/{brand_product_id}','BrandProduct@unactive_brand_product');
Route::get('/active-brand-product/{brand_product_id}','BrandProduct@active_brand_product');

Route::post('/save-brand-product','BrandProduct@save_brand_product');
Route::post('/update-brand-product/{brand_product_id}','BrandProduct@update_brand_product');

//Product
    Route::group(['middleware'=> 'auth.roles'], function(){
    Route::get('/add-product','ProductController@add_product');
    Route::get('/edit-product/{product_id}','ProductController@edit_product');
});


Route::get('/delete-product/{product_id}','ProductController@delete_product');
Route::get('/all-product','ProductController@all_product');
Route::get('/unactive-product/{product_id}','ProductController@unactive_product');
Route::get('/active-product/{product_id}','ProductController@active_product');
Route::post('/save-product','ProductController@save_product');
Route::post('/update-product/{product_id}','ProductController@update_product');

//Quick view
Route::post('/quickview','ProductController@quickview');

//Comment
Route::post('/load-comment','ProductController@load_comment');
Route::post('/send-comment','ProductController@send_comment');
Route::get('/list-comment','ProductController@list_comment');
Route::post('/browse-comment','ProductController@browse_comment');
Route::post('/reply-comment','ProductController@reply_comment');
Route::get('/delete-comment/{comment_id}','ProductController@delete_comment');

//Rating
Route::post('/insert-rating','ProductController@insert_rating');

//Gallery
Route::get('/add-gallery/{product_id}','GalleryController@add_gallery');
Route::post('/select-gallery','GalleryController@select_gallery');
Route::post('/insert-gallery/{pro_id}','GalleryController@insert_gallery');
Route::post('/update-gallery-name','GalleryController@update_gallery_name');
Route::post('/delete-gallery','GalleryController@delete_gallery');
Route::post('/update-gallery','GalleryController@update_gallery');

//Contact
Route::get('/contact','ContactController@contact');


//Coupon
Route::post('/check-coupon','CartController@check_coupon');
Route::get('/unset-coupon','CouponController@unset_coupon');
Route::get('/insert-coupon','CouponController@insert_coupon')->middleware('auth.roles');
Route::get('/delete-coupon/{coupon_id}','CouponController@delete_coupon');
Route::get('/list-coupon','CouponController@list_coupon');
Route::post('/insert-coupon-code','CouponController@insert_coupon_code');

//Cart
Route::post('/update-cart-quantity','CartController@update_cart_quantity');
Route::post('/update-cart','CartController@update_cart');
Route::post('/save-cart','CartController@save_cart');
Route::post('/add-cart-ajax','CartController@add_cart_ajax');
Route::get('/show-cart','CartController@show_cart');
Route::get('/gio-hang','CartController@gio_hang');
Route::get('/delete-to-cart/{rowId}','CartController@delete_to_cart');
Route::get('/del-product/{session_id}','CartController@delete_product');
Route::get('/del-all-product','CartController@delete_all_product');
Route::get('/cart-count','CartController@cart_count');

//Checkout
Route::get('/dang-nhap','CheckoutController@login_checkout');
Route::get('/del-fee','CheckoutController@del_fee');

Route::get('/logout-checkout','CheckoutController@logout_checkout');
Route::post('/add-customer','CheckoutController@add_customer');
Route::post('/order-place','CheckoutController@order_place');
Route::post('/login-customer','CheckoutController@login_customer');
Route::get('/checkout','CheckoutController@checkout');
Route::get('/payment','CheckoutController@payment');
Route::post('/save-checkout-customer','CheckoutController@save_checkout_customer');
Route::post('/calculate-fee','CheckoutController@calculate_fee');
Route::post('/select-delivery-home','CheckoutController@select_delivery_home');
Route::post('/confirm-order','CheckoutController@confirm_order');

//Order
Route::get('/print-order/{checkout_code}','OrderController@print_order');
Route::get('/manage-order','OrderController@manage_order')->middleware('auth.roles');
Route::get('/view-order/{order_code}','OrderController@view_order');
Route::post('/update-order-qty','OrderController@update_order_qty');
Route::post('/update-qty','OrderController@update_qty');

//Send mail
Route::get('/send-mail','MailController@send_mail');


//Delivery
Route::get('/delivery','DeliveryController@delivery')->middleware('auth.roles');
Route::post('/select-delivery','DeliveryController@select_delivery');
Route::post('/insert-delivery','DeliveryController@insert_delivery');
Route::post('/select-feeship','DeliveryController@select_feeship');
Route::post('/update-delivery','DeliveryController@update_delivery');

//Banner
Route::get('/manage-slider','SliderController@manage_slider');
Route::get('/add-slider','SliderController@add_slider')->middleware('auth.roles');
Route::post('/insert-slider','SliderController@insert_slider');
Route::get('/unactive-slide/{slide_id}','SliderController@unactive_slide');
Route::get('/active-slide/{slide_id}','SliderController@active_slide');
Route::get('/delete-slide/{slide_id}','SliderController@delete_slide');

//Menu Post
Route::get('/add-menu-post','MenuPostController@add_menu_post')->middleware('auth.roles');
Route::post('/save-menu-post','MenuPostController@save_menu_post');
Route::get('/all-menu-post','MenuPostController@all_menu_post');
Route::get('/danh-muc-menu-post/{menu_post_slug}','MenuPostController@danh_muc_menu_post');
Route::get('/edit-menu-post/{menu_post_id}','MenuPostController@edit_menu_post');
Route::post('/update-menu-post/{menu_post_id}','MenuPostController@update_menu_post');
Route::get('/delete-menu-post/{menu_post_id}','MenuPostController@delete_menu_post');

//Post
Route::get('/add-post','PostController@add_post')->middleware('auth.roles');
Route::post('/save-post','PostController@save_post');
Route::get('/all-post','PostController@all_post');
Route::get('/delete-post/{post_id}','PostController@delete_post');
Route::get('/edit-post/{post_id}','PostController@edit_post');
Route::post('/update-post/{post_id}','PostController@update_post');
Route::get('/danh-muc-post/{post_slug}','PostController@danh_muc_post');
Route::get('/see-post/{post_slug}','PostController@see_post');

//User
Route::get('/users','UserController@index')->middleware('auth.roles');
Route::get('/add-users','UserController@add_users')->middleware('auth.roles');
Route::post('/assign-roles','UserController@assign_roles')->middleware('auth.roles');
Route::post('/store-users','UserController@store_users');
Route::get('/delete-users-roles/{admin_id}','UserController@delete_users_roles')->middleware('auth.roles');








