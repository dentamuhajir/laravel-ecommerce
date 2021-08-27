<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model {
	//
	protected $table = 'product';
	public $timestamps = false;
	public function category() {
		return $this->hasMany('Category::class');
	}
}
