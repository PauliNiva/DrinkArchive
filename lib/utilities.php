<?php

class Utilities {

	private $drinkCount;

	public function _construct() {
	}

	public function countDrinks() {
		$query = DB::connection()->prepare('SELECT COUNT(*) FROM Drinks');
		$query->execute();
		$this ->count = $query->fetchColumn();
	}

	public function getDrinkCount() {
		return $this->count;
	}
}