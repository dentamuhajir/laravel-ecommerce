<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model {
	protected $table = 'master_category';
	public function product() {
		return $this->belongsTo('Product::class');
	}
	public $timestamps = false;

}
