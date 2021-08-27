<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */

Route::middleware('auth:api')->get('/user', function (Request $request) {
	return $request->user();
});

Route::get('/v1.0/grab-tokopedia-merchant-data', 'DataScrapeController@get_tokopedia_merchant');

Route::get('/not_storage', 'DataScrapeController@get_tokopedia_merchant_test_not_storage');

Route::post('/v1.0/grab-rajaongkir-city', 'FunctionController@ONGKIR__listCity');
Route::post('/v1.0/grab-rajaongkir-cost', 'FunctionController@ONGKIR__cost');

Route::get('/v1.0/grab-tokopedia-merchant-data/test', 'DataScrapeController@get_tokopedia_merchant_test');

Route::get('/v1.0/grab-tokopedia-merchant-data/all', 'DataScrapeController@rolled_scrape');

Route::get('/mail', 'FunctionController@MAIL__send');

Route::post('/save/order-form', 'PageController@saveOrderForm');

Route::get('/awshop-merchant-tokopedia/{startfrom}/{scriptorder}', 'CronJobController@MERCHANT__AWShopTokopedia');

Route::get('/awshop-merchant-tokopedia/finishing', 'CronJobController@MERCHANT__STOPAWShopTokopedia');



