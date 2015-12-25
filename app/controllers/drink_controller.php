<?php

require 'app/models/drink.php';
class DrinkController extends BaseController {

	public static function index() {
		$drinks = Drink::findAll();
		View::make('drink/index.html', array('drinks' => $drinks));
	}
}