<?php
namespace App\Http\Controllers;

ini_set('max_execution_time', 300); //300 seconds = 5 minutes

use App\Http\Traits\CartTrait;
use App\Http\Traits\NotificationTrait;
use App\Http\Traits\ShippingTrait;
use DB;
use Illuminate\Http\Request;

class FunctionController extends Controller {

	use ShippingTrait;

	use CartTrait;

	use NotificationTrait;

	public function CART__add($price, $id, $name, $picture) {

		return $this->addToCart($price, $id, $name, $picture);

	}

	public function CART__remove($rowId) {

		return $this->remove($rowId);

	}

	public function CART__emptyCart() {

		return $this->destroy();

	}

	public function ONGKIR__listCity(Request $request) {

		return $this->getCity($request->province_id);

	}

	public function ONGKIR__cost(Request $request) {

		return $this->getOngkir($request->city_id);

	}

	public function ONGKIR__listProvince() {

		return $this->getProvince();
	}

	public static function toRupiah($angka) {

		$hasil_rupiah = "Rp " . number_format($angka, 2, ',', '.');

		return $hasil_rupiah;

	}

	public function NOTIFICATION__sendInvoice($hash) {

		$orderDetail = DB::table('master_order')
			->select('*')
			->where('ORDER_GENERATE_ID', $hash)
			->first();

		if ($orderDetail->ORDER_NOTIF_SEND == FALSE) {

			$noOrder = 'CJ-' . $orderDetail->ORDER_ID . '' . date("m") . '' . date("d");

			//DB::table('master_order')->update(['ORDER_NOTIF_SEND' => 0]);
			
			$this->mailInvoice($noOrder, $orderDetail->ORDER_NEW_EMAIL, $orderDetail->ORDER_PRODUCT_ALL, $orderDetail->ORDER_SUB_TOTAL, $orderDetail->ORDER_ONGKIR, $orderDetail->ORDER_NEW_CITY, $orderDetail->ORDER_UNIQUE_CODE);

			$this->telegramInvoice($noOrder,$orderDetail->ORDER_NEW_NAME, $orderDetail->ORDER_SUB_TOTAL, $orderDetail->ORDER_PRODUCT_ALL, $orderDetail->ORDER_NEW_CITY, $orderDetail->ORDER_ONGKIR,$orderDetail->ORDER_NEW_PHONE);

		}
		return;

	}

}