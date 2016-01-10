<?php

class User {

	public $user_id, $username, $password, $admin, $last_login;

	public function _construct($user_id, $username, $password, $admin, $last_login) {
		$this->user_id = $user_id;
		$this->username = $username;
		$this->password = $password;
		$this->admin = $admin;
		$this->last_login = $last_login;
	}

	public static function findAllUsers() {
		$query = DB::connection()->prepare('SELECT * FROM Users');
		$query->execute();
		$rows = $query->fetchAll(PDO::FETCH_OBJ);
		$users = array();

		foreach ($rows as $row) {
			$users[] = User::fillUserAttributesFromQuery($row);
		}
		return $users;
	}

	public function findOneUser($user_id) {
		$query = DB::connection()->prepare('SELECT * FROM Users WHERE user_id = :user_id');
		$query->execute(array($user_id));
		$row = $query->fetch(PDO::FETCH_OBJ);

		if($row) {
			return User::fillUserAttributesFromQuery($row);
		} else {
			return null;
		}
	}

	public function fillUserAttributesFromQuery($row) {
		$user = new User();

		$user->setUser_id($row->user_id);
		$user->setUsername($row->username);
		$user->setPassword($row->password);
		$user->setAdmin($row->admin);
		$user->setLast_login($row->last_login);

		return $user;
	}

	public function saveUser() {
		$query = DB::connection()->prepare('INSERT INTO
			Users(username, password, admin, last_login) VALUES
			(?, ?, ?, ?) RETURNING user_id');
		$query->execute(array($this->getUsername(), $this->getPassword(),
			'FALSE', 'NOW()'));
		$row = $query->fetch();
		$this->user_id = $row['user_id'];
	}

	public function findUserByLoginInfo($username, $password) {
		$query = DB::connection()->prepare('SELECT * FROM Users WHERE username = :username
			AND password = :password');
		$query->execute(array($username, $password));
		$row = $query->fetch(PDO::FETCH_OBJ);

		if($row) {
			$user = User::fillUserAttributesFromQuery($row);
			return $user;
		} else {
			return null;
		}
	}

	public function destroyUser() {
		$query = DB::connection()->prepare('DELETE FROM Users WHERE user_id = ?');
		$query->execute(array($this->user_id));
	}

	public function updateUser() {
		$query = DB::connection()->prepare('UPDATE Users SET
			username = ?, password = ?, admin = ?, last_login = ? WHERE user_id = ?');
		$query->execute(array($this->username, $this->password,
			$this->admin, $this->last_login, $this->user_id));
	}

	public function validateUsername($name){
  		$errors = array();
  		if ($name == '' || $name == null){
    		$errors[] = 'Username cannot be empty!';
  		}
  		if (strlen($name) < 3){
    		$errors[] = 'Username must be atleast 3 symbols long!';
  		}
  		if (User::nameAlreadyExists($name)) {
  			$errors[] = 'Username already exists!';
  		}
  		return $errors;
	}

	public function validatePassword($password){
  		$errors = array();
  		if ($password == '' || $password == null){
    		$errors[] = 'Password cannot be empty!';
  		}
  		if (strlen($password) < 3){
    		$errors[] = 'Password must be atleast 3 symbols long!';
  		}
  		return $errors;
	}

	public static function nameAlreadyExists($username) {
		$query = DB::connection()->prepare('SELECT COUNT(*) FROM Users WHERE username = :username');
		$query->execute(array($username));
        $result = $query->fetchColumn();
        if ($result > 0) {
            return true;
        } else {
            return FALSE;
        }
    }

	public function getUser_id() {
		return $this->user_id;
	}

	public function setUser_id($user_id) {
		$this->user_id = $user_id;
	}

	public function getUsername() {
		return $this->username;
	}

	public function setUsername($username) {
		$this->username = $username;
	}

	public function getPassword() {
		return $this->password;
	}

	public function setPassword($password) {
		$this->password = $password;
	}

	public function getAdmin() {
		return $this->admin;
	}

	public function setAdmin($admin) {
		if ($admin == TRUE) {
			$this->admin = TRUE;
		} else {
			$this->admin = FALSE;
		}
	}

	public function makeAdmin() {
		$this->admin = TRUE;
	}

	public function getLast_login() {
		return $this->last_login;
	}

	public function setLast_login($last_login) {
		$this->last_login = $last_login;
	}
}