<?php

class DrinkIngredient {

	private $amount, $unit, $ingredient_id, $drink_id, $name;

	public function _construct($amount, $unit, $ingredient_id, $drink_id, $name) {
		$this->amount = $amount;
		$this->unit = $unit;
		$this->ingredient_id = $ingredient_id;
		$this->drink_id = $drink_id;
		$this->name = $name;
	}

	public static function listDrinkIngredients($drink_id) {
		$query = DB::connection()->prepare('SELECT * FROM DrinkIngredient WHERE drink_id = :drink_id');
		$query->execute(array($drink_id));
		$rows = $query->fetchAll(PDO::FETCH_OBJ);
		$ingredients = array();

		foreach ($rows as $row) {
			$ingredient = new DrinkIngredient();

			$ingredient->setAmount($row->amount);
			$ingredient->setUnit($row->unit);
			$ingredient->setIngredient_id($row->ingredient_id);
			$ingredient->setDrink_id($row->drink_id);
			$ingredient->setIngredientName($row->ingredient_id);

			$ingredients[] = $ingredient;
		}

		return $ingredients;
	}

	public function getIngredientName() {
		return $this->name;
	}

	public function setIngredientName($ingredient_id) {
       $query = DB::connection()->prepare('SELECT ingredient_name FROM Ingredients
       		WHERE ingredient_id = :ingredient_id');
       $query->execute(array($ingredient_id));
       $puuh = $query->fetchObject();
       $this->name = $puuh->ingredient_name;
    }

	public function getAmount() {
		return $this->amount;
	}

	public function setAmount($amount) {
		$this->amount = $amount;
	}

	public function getUnit() {
		return $this->unit;
	}

	public function setUnit($unit) {
		$this->unit = $unit;
	}

	public function getIngredient_id() {
		return $this->ingredient_id;
	}

	public function setIngredient_id($ingredient_id) {
		$this->ingredient_id = $ingredient_id;
	}

	public function getDrink_id() {
		return $this->drink_id;
	}

	public function setDrink_id($drink_id) {
		$this->drink_id = $drink_id;
	}
}