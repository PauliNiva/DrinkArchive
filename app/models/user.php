<?php

class User {
	private $user_id, $username, $password, $admin, $last_login;

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

	public static function findOneUser($user_id) {
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
		$this->admin = $admin;
	}

	public function getLast_login() {
		return $this->last_login;
	}

	public function setLast_login($last_login) {
		$this->last_login = $last_login;
	}
}