<?php

namespace App\Http\Controllers;


ini_set('max_execution_time', 0);
date_default_timezone_set('Asia/Jakarta');
//use App\Http\Traits\GoogleAPITrait;
//use App\Http\Traits\TelegramNotifTrait;
use App\Http\Traits\TokopediaMerchantsTrait;

class CronJobController extends Controller {
	use TokopediaMerchantsTrait;
	//use GoogleAPITrait;
	//use TelegramNotifTrait;

	// every 3 hour
	public function MERCHANT__AWShopTokopedia($startFrom = 0, $scriptNum) {
		$log = '';
		$log .= '=> CRON SCRIPT NO ' . $scriptNum . ' AW SHOP ';
		$log .= " --Eksekusi " . date("Y-m-d") . " " . date("h.i.sa");

		self::scrapeMerchantAwShopTokopedia($startFrom);
	    $detik=microtime(true) - LARAVEL_START;
        $detikBulat= round($detik,0);     
		$log .= " --Durasi :" .$detikBulat . " Detik " ;
		$log .= "| Status : OK Boss";
		
		

		$url = 'https://api.telegram.org/bot462989956:AAEFIUgRVc5GRpzzxO1hG6F1nGyUR6iWaYs/sendMessage?chat_id=256823672&text=' . $log . '&parse_mode=html';
		file_get_contents($url);

	}
	public function MERCHANT__STOPAWShopTokopedia()
	{
		self::swappingStatus();	
		$log = "";
		$log .= "=> FINISHER UPDATE PRODUK STATUS TEMP  ";
		$detik=microtime(true) - LARAVEL_START;
		$log .= " --Durasi :" .$detik . " Detik " ;
		$log .= "---------------------------------------";
		$url = 'https://api.telegram.org/bot462989956:AAEFIUgRVc5GRpzzxO1hG6F1nGyUR6iWaYs/sendMessage?chat_id=256823672&text=' . $log . '&parse_mode=html';
		file_get_contents($url);
		
	}



	public function MERCHANT__Shoes67Bukalapak() {
		//
	}

	// every friday at 12.00
	public function MERCHANT__PerfectCornerDownloadDropboxExtractRAR() {
		//
	}

}
