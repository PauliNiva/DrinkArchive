<?php

class DrinkType {

	private $drink_type_id, $drink_type_name;

	public function _construct($drink_type_id, $drink_type_name) {
		$this->drink_type_id = $drink_type_id;
		$this->drink_type_name = $drink_type_name;
	}

	public static function listDrinkTypes() {
		$query = DB::connection()->prepare('SELECT * FROM DrinkType');
		$query->execute();
		$rows = $query->fetchAll(PDO::FETCH_OBJ);
		$drinkTypes = array();

		foreach ($rows as $row) {
			$drinkTypes[] = DrinkType::fillAttributesFromQuery($row);
		}
		return $drinkTypes;
	}

	public function fillAttributesFromQuery($row) {
		$drinkType = new DrinkType();

		$drinkType->setDrink_type_id($row->drink_type_id);
		$drinkType->setDrink_type_name($row->drink_type_name);

		return $drinkType;
	}

	public function getDrink_type_id() {
		return $this->drink_type_id;
	}

	public function setDrink_type_id($drink_type_id) {
		$this->drink_type_id = $drink_type_id;
	}

	public function getDrink_type_name() {
		return $this->drink_type_name;
	}

	public function setDrink_type_name($drink_type_name) {
		$this->drink_type_name = $drink_type_name;
	}
}