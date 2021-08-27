<?php
namespace App\Helper;

Class Path {
	const BASE_PRODUCT_IMAGE = 'public/uploads/';

	public static function Image() {
		return self::BASE_PRODUCT_IMAGE;
	}
}