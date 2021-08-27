<?php

namespace App\Http\Traits;
use Storage;

trait ShippingTrait {
	private $jsonProvince;

	public function __construct() {
		$this->jsonProvince = Storage::disk('local')->get('public/json/province.json');
		$this->jsonCity = Storage::disk('local')->get('public/json/city.json');
	}
	public static function getProvince() {
		$dataProvince = json_decode(Storage::disk('local')->get('public/json/province.json'), true);
		return $dataProvince;
	}
	public function getCity($idProvince) {
		$dataCity = json_decode($this->jsonCity, true);

		$my_array = $dataCity;

		$allowed = array('province_id' => $idProvince);
		$filtered = array_filter(
			$my_array,
			function ($val_array) use ($allowed) {
				$intersection = array_intersect_assoc($val_array, $allowed);
				return (count($intersection)) == count($allowed);
			}
		);
		$html = "";
		//$html .= "<select class='form-control' id='select-city'>";
		$num = 0;
		foreach ($filtered as $saring) {

			$html .= " <option value='" . $saring['city_id'] . "'>" . $saring['type'] . " " . $saring['city_name'] . "</option>";
		}
		//$html .= "</select>";

		return $html;
	}
	public function getOngkir($getCityID) {

		$originPackage = 22;
		$cityID = $getCityID;
		$courier = 'jne';
		$weight = 1000;

		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => "http://api.rajaongkir.com/starter/cost",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_POSTFIELDS => "origin=" . $originPackage . "&destination=" . $cityID . "&weight=" . $weight . "&courier=" . $courier . "",
			CURLOPT_HTTPHEADER => array(
				"content-type: application/x-www-form-urlencoded",
				"key: de9f095b6930016a15eba1cd42fee322",
			),
		));

		$response = curl_exec($curl);

		$err = curl_error($curl);

		curl_close($curl);

		$data = json_decode($response, true);

		$gabung = "";

		for ($i = 0; $i < count($data['rajaongkir']['results']); $i++) {

			for ($j = 0; $j < count($data['rajaongkir']['results'][$i]['costs']); $j++) {

				$gabung .= $data['rajaongkir']['results'][0]['costs'][$j]['service'] . " = ";
				for ($k = 0; $k < count($data['rajaongkir']['results'][0]['costs'][$j]['cost']); $k++) {

					$gabung .= $data['rajaongkir']['results'][0]['costs'][$j]['cost'][$k]['value'] . ",";
				}
			}
			preg_match('/REG\s=\s(.*?),/', $gabung, $result);
			return $result[1];

		}
	}
}
