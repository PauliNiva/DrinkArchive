<?php

require 'app/models/drink.php';
require 'app/models/drink_ingredient.php';

class DrinkController extends BaseController {

	public static function index() {
		$count = Drink::countDrinks();
		$drinks = Drink::findAll();
		View::make('drink/index.html', array('drinks' => $drinks, 'count' => $count));
	}

	public static function show($id) {
		$drink = Drink::findOne($id);
		$drink_ingredients = DrinkIngredient::listDrinkIngredients($id);
		View::make('drink/aaa.html', array('drink' => $drink, 'drink_ingredients' => $drink_ingredients));
	}
}