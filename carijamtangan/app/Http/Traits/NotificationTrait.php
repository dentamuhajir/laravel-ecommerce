<?php

namespace App\Http\Traits;

use Mail;
trait NotificationTrait {
	public function telegramInvoice($noOrder, $name, $subTotal, $productCart, $city, $ongkir, $noHandphone) {
		$total = 0;
		$total = $subTotal + $ongkir;

		$data = json_decode($productCart);
		$productBuy = "";
		foreach ($data as $v) {
			$productBuy .= strtoupper($v->name) . ' ' . self::toRupiah($v->price) . ' ';
		}

		$urlNoHandphone = 'https://api.telegram.org/bot709772251:AAH7rrL_48p9rQ2qrS88j2MSdPzSkT1JK2U/sendMessage?chat_id=256823672&text=https://wa.me/62' . ltrim($noHandphone, "0") . '&parse_mode=html';
		file_get_contents($urlNoHandphone);

		$text = 'No Nota ' . $noOrder . 'Atas Nama ' . $name . ' Total pesanan anda ' . self::toRupiah($total) . '- Detail barang yang anda beli : - ' . $productBuy . ' Ongkir JNE REG ke ' . $city . ' ' . self::toRupiah($ongkir) . 'Untuk pembayaran bisa di transfer ke - Rekening Bank : BCA - Atas Nama : Denta Zamzam Yasin Muhajir - No Rekening : 0153579871 Setelah transfer kamu bisa konfirmasi lewat SMS/WA ke nomer ini dengan memberikan info sebagai berikut : contoh - No Nota : CJ-21811 - Dari Bank : BNI - Atas Nama : ' . $name . '- Jumlah transfer :' . self::toRupiah($total);

		$url = 'https://api.telegram.org/bot709772251:AAH7rrL_48p9rQ2qrS88j2MSdPzSkT1JK2U/sendMessage?chat_id=256823672&text=' . $text . '&parse_mode=html';
		return file_get_contents($url);

	}

	public function mailInvoice($noOrder, $getEmail, $productCart, $subTotal, $getOngkir, $getCity, $uniqueCode) {
		$total = 0;
		$total = $subTotal + $getOngkir + $uniqueCode;

		$data = array('productCart' => $productCart, 'ongkir' => $getOngkir, 'subTotal' => $subTotal, 'city' => $getCity, 'kodeUnik' => $uniqueCode, 'total' => $total, 'nOrder' => $noOrder);

		Mail::send('template_womensfashion.mail', $data, function ($message) use ($getEmail) {
			$message->to($getEmail, 'CariJamTangan  Invoice')->subject
				('Cari Jam Tangan Invoice');
			//$message->from('invoice@carijamtangan.com', 'Cari Jam Tangan');
			$message->from('bantuan@eclast-store.com', 'Cari Jam Tangan');
		});
		//die("sampai sini d");
		return "Basic Email Sent. Check your inbox.";
	}

}