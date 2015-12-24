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