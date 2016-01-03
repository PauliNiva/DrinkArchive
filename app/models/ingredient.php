<?php

class Ingredient {
	
	private $ingredient_id, $ingredient_name;

	public function _construct($ingredient_id, $ingredient_name) {
		$this->ingredient_id = $ingredient_id;
		$this->ingredient_name = $ingredient_name;
	}

	public static function alreadyInArchive($name) {
        $query = DB::connection()->prepare('SELECT * FROM Ingredients WHERE ingredient_name = :name');
        $query->execute(array($name));
        $result = $query->fetch();
        if ($result['ingredient_id'] > 0) {
            return $result['ingredient_id'];
        } else {
            return false;
        }
    }

    public function save() {
    	$query = DB::connection()->prepare('INSERT INTO Ingredients (ingredient_name)
    		VALUES(:ingredient_name) RETURNING ingredient_id');
        $query->execute(array($this->getIngredient_name()));
        return $query->fetchColumn();
    }

    public function update() {
		$query = DB::connection()->prepare('UPDATE Ingredients SET
			ingredenient_name = ? WHERE ingredient_id = ?');
		$query->execute(array($this->ingredient_name, $this->ingredient_id));
	}

	public function validateIngredient_name($name){
  		$errors = array();
  		if ($name == '' || $name == null){
    		$errors[] = 'Ingredient name cannot be empty!';
  		}
  		if (strlen($name) < 3){
    		$errors[] = 'Ingredient name must be atleast 3 symbols long!';
  		}
  		return $errors;
	}

	public function getIngredient_id() {
		return $this->ingredient_id;
	}

	public function setIngredient_id($ingredient_id) {
		$this->ingredient_id = $ingredient_id;
	}

	public function getIngredient_name() {
		return $this->ingredient_name;
	}

	public function setIngredient_name($ingredient_name) {
		$this->ingredient_name = $ingredient_name;
	}
}