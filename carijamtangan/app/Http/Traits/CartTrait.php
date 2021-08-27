<?php

namespace App\Http\Traits;
use Cart;
trait CartTrait {

	public function addToCart($price, $id, $name, $picture) {
		foreach (Cart::content() as $row) {
			if ($row->id == $id) {
				return "Kamu udah masukin produk ini :D";
				exit;
			}
			goto addToCart;
		}
		addToCart:
		Cart::add($id, $name, 1, $price, ['pic' => $picture]);
		return "add to cart";
	}
	public function remove($rowId) {
		return Cart::remove($rowId);
	}
	public function destroy() {
		return Cart::destroy();
	}

	public static function subTotal() {
		return Cart::subtotal();
	}
	public static function cartItems() {
		return  Cart::count();
	}

}