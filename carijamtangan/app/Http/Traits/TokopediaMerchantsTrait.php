<?php

namespace App\Http\Traits;

ini_set('max_execution_time', 0); // Unlimited execution time

use App\Product;
use DB;
use Intervention\Image\Exception\NotReadableException;
use Response;
use Storage;

trait TokopediaMerchantsTrait {

	static function scrapeMerchantAwShopTokopedia($getFromNum) {
		
		$merchant_url = 'https://ace.tokopedia.com/search/v2.6/product?shop_id=202414&ob=10&rows=30&start=' . $getFromNum . '&full_domain=www.tokopedia.com&scheme=https&device=desktop&source=shop_product';
		$curl_data = self::get_data($merchant_url);

		if (!$curl_data) // nothing grabbing
		{
			// display error message
			return Response::json(array(
				'code' => 503,
				'date' => date('Y-m-d h:i:sa'),
				'message' => 'Connection Error',

			));
			// send telegram report
		}

		$result = json_decode($curl_data);

		$number = 0;

		foreach ($result->data as $key => $val) {

			//
			$product_check_available = DB::table('product')
				->where('PRODUCT_MERCHANT_ID', '=', $val->id)
				//->orWhere('PRODUCT_NAME', '=', $val->name)
				->exists();

		

			if ($product_check_available == TRUE) {
			    DB::table('product')
				->where('PRODUCT_MERCHANT_ID', '=', $val->id)
				->update(['PRODUCT_STATUS_TEMP' => 1]);
				
				
				$id_category = DB::table('product')
				->select('PRODUCT_CATEGORY_ID')
				->where('PRODUCT_MERCHANT_ID', '=', $val->id)
				->first();
			
				
				
				DB::table('master_category')
				->where('CATEGORY_ID', '=', $id_category->PRODUCT_CATEGORY_ID)
				->update(['CATEGORY_STATUS_TEMP' => 1]);
				

				$check_main_image = "cjt-" . $val->id;
				$check_main_image_hash = "img_" . self::cryptor('encrypt', $check_main_image) . ".jpg";
				$image_exists = Storage::disk('images')->exists($check_main_image_hash);

				if ($image_exists) {

					// picture exists
					//echo "gambar ada";

					continue;

				} else {

					$folder_220X290 = 'photo/' . $check_main_image_hash;
					//$folder_600X500 = 'storage/uploads/'.$main_image_hash_600X500;
					$toped_image = $val->image_uri_700; // maybe stored in parameter
					try
					{
						$image_220x290 = \Image::make($toped_image);
						//$image_600x500 = \Image::make($toped_image);
					} catch (NotReadableException $e) {
						// If error, stop and continue looping to next iteration
						continue;
					}
					// If no error ...
					/*$image_220x290->fit(220, 290, function ($constraint) {
						$constraint->aspectRatio();
					});
*/
					$image_220x290->save($folder_220X290);

					//echo "ditambahkan";

				}
				continue;

			} else {
			    
				// --------------------< G E T  C A T E G O R Y >--------------------------
				$url_category = 'https://www.tokopedia.com/ajax/product-prev-next.pl?p_id=' . $val->id . '&action=prev_next&s_id=202414&lang=id';

				//echo "masuk sini pengecekan di category";

				$get_data_category = self::get_data($url_category);

				if (!preg_match('/titl.*?"(.*?)"/', $get_data_category)) {

					continue;

				}
				preg_match('/titl.*?"(.*?)"/', $get_data_category, $result_data_category);

				$get_merch = rtrim($result_data_category[1], '\\');

				if (substr($get_merch, 0, 10) === 'JAM TANGAN') {
					$get_merch = preg_replace("/\s\(.*?\)/", "", $get_merch);

					$get_merch = str_replace("JAM TANGAN ", "", $get_merch);
				} else {
					//echo " tidak sesuai category";

					continue;

				}

				// --------------------< / G E T  C A T E G O R Y >-------------------------
				goto SECTION_IMAGE;
			}

			// --------------------< I M A G E >---------------------------------------

			SECTION_IMAGE:

			$main_image = "cjt-" . $val->id;
			$main_image_hash = "img_" . self::cryptor('encrypt', $main_image);
			/*	$main_image_hash_300X400 = "img_" . self::cryptor('encrypt', $main_image) . "_300x400.jpg";
			$main_image_hash_220X290 = "img_" . self::cryptor('encrypt', $main_image) . "_220x290.jpg";*/
			$main_image_hash_origin = "img_" . self::cryptor('encrypt', $main_image) . ".jpg";
/*
$folder_300X400 = 'photo/' . $main_image_hash_300X400;
$folder_220X290 = 'photo/' . $main_image_hash_220X290;
 */$folder_origin = 'photo/' . $main_image_hash_origin;
			$toped_image = $val->image_uri_700; // maybe stored in parameter

			try
			{
				$image_origin = \Image::make($toped_image);
				/*	$image_300x400 = \Image::make($toped_image);
					$image_220X290 = \Image::make($toped_image);
				*/} catch (NotReadableException $e) {
				// If error, stop and continue looping to next iteration
				continue;
			}
			// If no error ...
			/*	$image_300x400->fit(300, 400, function ($constraint) {
				$constraint->aspectRatio();
			});

			$image_220X290->fit(220, 290, function ($constraint) {
				$constraint->aspectRatio();
			});*/

			$image_origin->save($folder_origin);
			/*$image_300x400->save($folder_300X400);
			$image_220X290->save($folder_220X290);*/

			// --------------------< / I M A G E>--------------------------------------

			// --------------------<  D E T A I L  P R O D U C T >----------------------

			$url_detail = self::get_data($val->uri);

			$format_regex = self::clean_data($url_detail);

			if (!preg_match('/er:description\".*?\"(.*?)>/', $format_regex, $result_description)) {
				continue;
			}

			preg_match('/er:description\".*?\"(.*?)>/', $format_regex, $result_description);

			$result_description_match = "";
			$result_description_match = $result_description[1];
			$result_description_match = str_replace('Display :', '<br/>Display :', $result_description_match);
			$result_description_match = str_replace('Diameter :', '<br/>Diameter :', $result_description_match);
			$result_description_match = str_replace('Tali :', '<br/>Tali :', $result_description_match);

			$result_description_match = preg_replace('/BUBBLE WRAP AGAR.*/', '', $result_description_match);

			$result_description_match = preg_replace('/bubble wrap agar.*/', '', $result_description_match);

			// --------------------< / D E T A I L  P R O D U C T >---------------------

			// --------------------< P R I C E  M A R K U P >---------------------------

			$val->price = preg_replace('/Rp/', '', $val->price);

			$val->price = preg_replace('/\./', '', $val->price);

			$toped_supplier_price = $val->price;

			if ($toped_supplier_price <= 50000) {

				$markup_percentige = 45;
			} else if (($toped_supplier_price > 50000) AND ($toped_supplier_price <= 125000)) {

				$markup_percentige = 35;
			} else if (($toped_supplier_price > 125000) AND ($toped_supplier_price <= 250000)) {

				$markup_percentige = 27;
			} else {

				$markup_percentige = 18;
			}

			//die("not saved");
			// ------------------< / P R I C E  M A R K U P >--------------------------

			// --------------------< G E T  P R O D U C T  V A L U E >-----------------

			$category_check_available = DB::table('master_category')
				->where('CATEGORY_MERCH', '=', $get_merch)
				->exists();

			if ($category_check_available === TRUE) {

				DB::table('master_category')
					->where('CATEGORY_MERCH', '=', $get_merch)
					->update(['CATEGORY_STATUS_TEMP' => 1]);

				$get_id_category = DB::table('master_category')
					->select('CATEGORY_ID')
					->where('CATEGORY_MERCH', '=', $get_merch)
					->first();

				$FIELD_PRODUCT_ID_CATEGORY = $get_id_category->CATEGORY_ID;

			} else {

				$FIELD_CATEGORY_MERCH = $get_merch;
				$FIELD_CATEGORY_MERCH_SLUG = str_slug($FIELD_CATEGORY_MERCH, "-");
				$FIELD_CATEGORY_NAME = 'Watch';
				$FIELD_CATEGORY_NAME_SLUG = str_slug($FIELD_CATEGORY_NAME, "-");

				if (strpos($FIELD_CATEGORY_MERCH, 'ORIGINAL') !== false) {

					$FIELD_PRODUCT_ID_CATEGORY = DB::table('master_category')->insertGetId(
						['CATEGORY_NAME' => $FIELD_CATEGORY_NAME, 'CATEGORY_NAME_SLUG' => $FIELD_CATEGORY_NAME_SLUG, 'CATEGORY_MERCH' => $FIELD_CATEGORY_MERCH, 'CATEGORY_MERCH_SLUG' => $FIELD_CATEGORY_MERCH_SLUG, 'CATEGORY_STATUS_TEMP' => 1, 'CATEGORY_ORIGINAL' => 1]
					);

				} else {

					$FIELD_PRODUCT_ID_CATEGORY = DB::table('master_category')->insertGetId(
						['CATEGORY_NAME' => $FIELD_CATEGORY_NAME, 'CATEGORY_NAME_SLUG' => $FIELD_CATEGORY_NAME_SLUG, 'CATEGORY_MERCH' => $FIELD_CATEGORY_MERCH, 'CATEGORY_MERCH_SLUG' => $FIELD_CATEGORY_MERCH_SLUG, 'CATEGORY_STATUS_TEMP' => 1]
					);

				}

			}

			$product_name = "";
			$product_name = str_replace('TERMURAH ', '', $val->name);

			$FIELD_PRODUCT_NAME = $product_name;
			$FIELD_PRODUCT_NAME_SLUG = str_slug($FIELD_PRODUCT_NAME, "-");
			$FIELD_PRODUCT_MERCHANT_PRICE = $val->price;
			$FIELD_PRODUCT_CJT_PRICE = $val->price * ((100 + $markup_percentige) / 100);
			$FIELD_PRODUCT_MERCHANT_ID = $val->id;
			$FIELD_PRODUCT_CJT_CODE = "CJT-" . $val->id;
			$FIELD_PRODUCT_MAIN_IMAGE = $main_image_hash;
			$FIELD_PRODUCT_DESCRIPTION = $result_description_match;
			$FIELD_PRODUCT_PROFIT = $FIELD_PRODUCT_CJT_PRICE - $FIELD_PRODUCT_MERCHANT_PRICE;
			$product_table = new Product;
			$product_table->PRODUCT_CATEGORY_ID = $FIELD_PRODUCT_ID_CATEGORY;
			$product_table->PRODUCT_CJT_CODE = $FIELD_PRODUCT_CJT_CODE;
			$product_table->PRODUCT_MERCHANT_ID = $FIELD_PRODUCT_MERCHANT_ID;
			$product_table->PRODUCT_NAME = $FIELD_PRODUCT_NAME;
			$product_table->PRODUCT_NAME_SLUG = $FIELD_PRODUCT_NAME_SLUG;
			$product_table->PRODUCT_MERCHANT_PRICE = $FIELD_PRODUCT_MERCHANT_PRICE;
			$product_table->PRODUCT_CJT_PRICE = $FIELD_PRODUCT_CJT_PRICE;
			$product_table->PRODUCT_PROFIT = $FIELD_PRODUCT_PROFIT;
			$product_table->PRODUCT_DESCRIPTION = $FIELD_PRODUCT_DESCRIPTION;
			$product_table->PRODUCT_MAIN_IMAGE = $FIELD_PRODUCT_MAIN_IMAGE;
			$product_table->PRODUCT_TODAY_NEW = 1;
			$product_table->PRODUCT_SHIPPING_ID = 12;
			$product_table->PRODUCT_STATUS_TEMP = 1;
			$product_table->save();

		}
		//DB::table('product')->update(['PRODUCT_STATUS' => DB::raw("`PRODUCT_STATUS_TEMP`")]);
		//DB::table('master_category')->update(['CATEGORY_STATUS' => DB::raw("`CATEGORY_STATUS_TEMP`")]);
	}

	static function cryptor($encrypt_decrypt, $string) {
		$password = 'ZsdjcxRURGUjZOOTVi';
		$method = 'aes-128-cbc';
		$iv = substr(hash('sha256', $password), 0, 16);
		$output = '';
		if ($encrypt_decrypt == 'encrypt') {
			$output = openssl_encrypt($string, $method, $password, 0, $iv);
			$output = base64_encode($output);
		} else if ($encrypt_decrypt == 'decrypt') {
			$output = base64_decode($string);
			$output = openssl_decrypt($output, $method, $password, 0, $iv);
		}
		return $output;
	}
	static function get_data($url) {
		$ch = curl_init();
		$timeout = 500000000;
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
		$data = curl_exec($ch);
		curl_close($ch);
		return $data;
	}
	static function clean_data($data) {
		$web = $data;
		$web = str_replace("\n", '', $web);
		$web = str_replace("\r", '', $web);
		$web = str_replace("\r\n", '', $web);
		$web = str_replace("\n\r", '', $web);
		$web = str_replace(PHP_EOL, '', $web);
		return $web;
	}

	static function swappingStatus() {
		DB::table('product')->update(['PRODUCT_STATUS' => DB::raw("`PRODUCT_STATUS_TEMP`")]);
		DB::table('master_category')->update(['CATEGORY_STATUS' => DB::raw("`CATEGORY_STATUS_TEMP`")]);
		
		DB::table('product')->update(['PRODUCT_STATUS_TEMP' => 0]);
		DB::table('master_category')->update(['CATEGORY_STATUS_TEMP' => 0]);
		//DB::table('product')->update(['PRODUCT_TODAY_NEW' => 0]);
	}

}
