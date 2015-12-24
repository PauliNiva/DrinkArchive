<?php

class Drink extends BaseModel {

	private $drink_id, $drink_name, $instructions, $date, $adder_id, $drink_type;

	public function __construct($attributes) {
		$this->drink_id = $drink_id;
		$this->drink_name = $drink_name;
		$this->instructions = $instructions;
		$this->date = $date;
		$this->adder_id = $adder_id;
		$this->drink_type = $drink_type;
	}

	public static function findAll() {
		$query = DB::connection()->prepare('SELECT * FROM Drinks');
		$query->execute();
		$rows = $query->fetchAll();
		$drinks = array();

		foreach ($rows as $row) {
			$drinks[] = fillAttributesFromQuery($row);
		}
		return $drinks;
	}

	public static function findOne($drink_id) {
		$query = DB::connection()->prepare('SELECT * FROM Drinks WHERE drink_id = ?');
		$query->execute(array($drink_id));
		$row = $query->fetch();

		if($row) {
			return fillAttributesFromQuery($row);
		} else {
			return null;
		}
	}

	private static function fillAttributesFromQuery($row) {
		$drink = new Drink();

		$drink->setDrink_id($row->drink_id);
		$drink->setDrink_name($row->drink_name);
		$drink->setInstructions($row->instructions);
		$drink->setDate($row->date);
		$drink->setAdder_id($row->adder_id);
		$drink->setDrink_type($row->drink_type);

		return $drink;
	}

	public function getDrink_id() {
		return $this->drink_id;
	}

	public function setDrink_id($drink_id) {
		$this->drink_id = $drink_id;
	}

	public function getDrink_name() {
		return $this->drink_name;
	}

	public function setDrink_name($drink_name) {
		$this->drink_name = $drink_name;
	}

	public function getInstructions() {
		return $this->instructions;
	}

	public function setInstructions() {
		$this->instructions = $instructions;
	}

	public function getDate() {
		return $this->date;
	}

	public function setDate($date) {
		$this->date = $date;
	}

	public function getAdder_id() {
		return $this->adder_id;
	}

	public function setAdder_id($adder_id) {
		$this->adder_id = $adder_id;
	}

	public function getDrink_type() {
		return $this->drink_type;
	}

	public function setDrink_type($drink_type) {
		$this->drink_type = $drink_type;
	}
}
?>