<?php


namespace App\Http\Traits;

use URL;
use Storage;

trait DropboxZipPerfectCornerSupplierTrait {

	public function processExtractFilter(){
		$baseUrl = URL::to('/');
		//$file = Storage::disk('local')->get('public/upload_zip/oldstok.zip');
		//$path = pathinfo(realpath($file), PATHINFO_DIRNAME);
		//Storage::makeDirectory('tobedownload',$mode=0775);
		//dd(1);
		//$path=storage_path('/upload_zip/oldstok.zip');
		//dd(realpath($path));
		$file="dd";
		$zip = new \ZipArchive;
		$res = $zip->open(public_path('storage/upload_zip').'/oldstok.zip');
		if ($res === TRUE) {
 			//$zip->extractTo($path."/temp_extract/");
  			//zip->close();

  			echo "WOOT! $file extracted to $path";
		} else {
  			 echo "Doh! I couldn't open $file";
		}

		
	}

}

