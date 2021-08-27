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

Route::get('/', 'PageController@index');

Route::get('/keranjang-belanja', 'PageController@cart');

Route::get('/brand/{type}/{merch_name}', 'PageController@category');

Route::get('/detail/{slug}', 'PageController@detail');

Route::any('/add/cart/{harga}/{id}/{name}/{picture}', 'FunctionController@CART__add');

Route::any('/cart/remove/{rowId}/', 'FunctionController@CART__remove');

Route::any('/cart/destroy/', 'FunctionController@CART__emptyCart');

Route::any('/store/form/', 'FunctionController@ORDER__store');

Route::any('/keranjang-belanja/checkout/', 'PageController@formBill');

Route::any('/widget-bill/', 'PageController@widgetIframeFormBill');

Route::get('/terima-kasih/{hash}/', 'PageController@thankYouPage');

Route::get('/send-invoice/{hash}/', 'FunctionController@NOTIFICATION__sendInvoice');

Route::get('/tentang-kami/', 'PageController@aboutUs');

Route::get('/cara-belanja/', 'PageController@caraBelanja');

Route::get('/faq/', 'PageController@faq');

Route::any('/dropbox/perfect-corner-zip/', 'FunctionController@PERFECTCORNER__dropboxzip');