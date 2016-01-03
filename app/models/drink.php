<?php

class Drink {

	private $drink_id, $drink_name, $instructions, $time_added, $adder_id, $drink_type;

	public function _construct($drink_id, $drink_name, $instructions, $time_added, $adder_id, $drink_type) {
		$this->drink_id = $drink_id;
		$this->drink_name = $drink_name;
		$this->instructions = $instructions;
		$this->time_added = $time_added;
		$this->adder_id = $adder_id;
		$this->drink_type = $drink_type;
		$this->validators = array('validateDrink_name');
	}

	public static function findAll() {
		$query = DB::connection()->prepare('SELECT * FROM Drinks');
		$query->execute();
		$rows = $query->fetchAll(PDO::FETCH_OBJ);
		$drinks = array();

		foreach ($rows as $row) {
			$drinks[] = Drink::fillAttributesFromQuery($row);
		}
		return $drinks;
	}

	public static function findOne($drink_id) {
		$query = DB::connection()->prepare('SELECT * FROM Drinks WHERE drink_id = :drink_id');
		$query->execute(array($drink_id));
		$row = $query->fetch(PDO::FETCH_OBJ);

		if($row) {
			return Drink::fillAttributesFromQuery($row);
		} else {
			return null;
		}
	}

	public function save() {
		$query = DB::connection()->prepare('INSERT INTO
			Drinks(drink_name, instructions, time_added, adder_id, drink_type) VALUES
			(:drink_name, :instructions, :time_added, :adder_id, :drink_type) RETURNING drink_id');
		$query->execute(array($this->getDrink_name(), $this->getInstructions(),
			'NOW()', $this->getAdder_id(), $this->getDrink_type()));
		$row = $query->fetch();
		$this->drink_id = $row['drink_id'];
	}

	public function update() {
		$query = DB::connection()->prepare('UPDATE Drinks SET
			drink_name = ?, instructions = ?, drink_type = ? WHERE drink_id = ?');
		$query->execute(array($this->drink_name, $this->instructions,
			$this->drink_type, $this->drink_id));
	}

	public function destroy() {
		$query = DB::connection()->prepare('DELETE FROM Drinks WHERE drink_id = ?');
		$query->execute(array($this->drink_id));
	}
 
	public function fillAttributesFromQuery($row) {
		$drink = new Drink();

		$drink->setDrink_id($row->drink_id);
		$drink->setDrink_name($row->drink_name);
		$drink->setInstructions($row->instructions);
		$drink->setTime_added($row->time_added);
		$drink->setAdder_id($row->adder_id);
		$drink->setDrink_type($row->drink_type);

		return $drink;
	}

	public function validateDrink_name($name){
  		$errors = array();
  		if ($name == '' || $name == null){
    		$errors[] = 'Drink name cannot be empty!';
  		}
  		if (strlen($name) < 3){
    		$errors[] = 'Drink name must be atleast 3 symbols long!';
  		}
  		if (Drink::nameAlreadyExists($name)) {
  			$errors[] = 'Drink name already exists!';
  		}
  		return $errors;
	}

	public static function nameAlreadyExists($drink_name) {
		$query = DB::connection()->prepare('SELECT COUNT(*) FROM DRINKS WHERE drink_name = :drink_name');
		$query->execute(array($drink_name));
        $result = $query->fetchColumn();
        if ($result > 0) {
            return true;
        } else {
            return FALSE;
        }
    }

    public function getAdderName() {
    	$query = DB::connection()->prepare('SELECT username FROM Users WHERE user_id = :adder_id');
		$query->execute(array($this->adder_id));
		$user = $query->fetchObject();
        return $user->username;
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

	public function setInstructions($instructions) {
		$this->instructions = $instructions;
	}

	public function getTime_added() {
		return $this->time_added;
	}

	public function setTime_added($time_added) {
		$this->time_added = $time_added;
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