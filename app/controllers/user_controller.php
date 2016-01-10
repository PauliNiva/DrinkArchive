<?php

require 'app/models/user.php';
require 'app/models/drink.php';
require 'lib/utilities.php';

class UserController extends BaseController {

	public static function registration(){
   	  View::make('/drink/register.html');
    }

    public static function showLogin(){
   	  View::make('/drink/login.html');
    }

    public static function login(){
    	$username = $_POST["username"];
    	$password = $_POST["password"];

    	$user = User::findUserByLoginInfo($username, $password);

    	if ($user) {
    		$_SESSION['user'] = $user->user_id;
    		Redirect::to('/drink', array('message' => 'User has been logged in.'));
		} else {
    		Redirect::to('/login', array('message' => 'No such user'));
		}
    }

    public static function logout(){
    	$_SESSION['user'] = null;
    	Redirect::to('/login', array('message' => 'You have been logged out'));
    }

    public static function registerUser() {
		$newUser = new User();
		$username = $_POST['username'];
		$password = $_POST['password'];
		$password2 = $_POST['password2'];
		$boo = FALSE;
		$errors = User::validateUsername($username);
		if (count($errors) > 0) {	
  			View::make('/drink/register.html', array('message' => $errors[0]));
  		}
  		$errors = User::validatePassword($password);
		if (count($errors) > 0) {	
  			View::make('/drink/register.html', array('username' => $username, 'message' => $errors[0]));
  		}

    	$newUser->setUsername($username);
    	$newUser->setPassword($password);
    	$newUser->setAdmin($boo);
    	if ($password == $password2) {
    		$newUser->saveUser();
    		$_SESSION['user'] = $newUser->user_id;
    	} else {
    		Redirect::to('/register', array('username' => $username, 'message' => 'Passwords do not match.'));
    	}

    	Redirect::to('/', array('message' => 'User has been registered.'));
  	}

  	public static function showFavorites() {
  		$user = $_SESSION['user'];
  		$favorites = Drink::getFavorites($user);
   	  	View::make('/drink/favorites.html', array('favorites' => $favorites));
    }

    public static function removeFav($drink) {
    	$user = $_SESSION['user'];
    	Drink::removeFavorite($user, $drink);
		Redirect::to('/favorites', array('message' => 'Favorite has been deleted.'));
    }

    public static function addFav($drink) {
    	$user = $_SESSION['user'];
    	$errors = Drink::validateFavoriteDoesntExist($user, $drink);
    	if (count($errors) > 0) {
    		Redirect::to('/drink', array('message' => $errors[0]));
  		}
    	Drink::addFavorite($user, $drink);
		Redirect::to('/drink', array('message' => 'Favorite has been added.'));
    }

    public static function showUsers() {
    	$users = User::findAllUsers();
		View::make('drink/userlist.html', array('users' => $users));
    }

    public static function showUser($id) {
    	$drinks = Drink::findUsersDrinks($id);
		$user = User::findOneUser($id);
		$admin = $user->getAdmin();
		View::make('drink/specific_user.html', array('user' => $user, 'drinks' => $drinks, 'admin' => $admin));
	}

	public static function destroyUser($id) {
		$user = User::findOneUser($id);
		$user->destroyUser();
		Redirect::to('/users', array('message' => 'User has been deleted.'));
	}

	public static function editUser($id) {
		$drinks = Drink::findUsersDrinks($id);
		$user = User::findOneUser($id);
		$admin = $user->getAdmin();
		View::make('drink/edit_user.html', array('user' => $user, 'drinks' => $drinks, 'admin' => $admin));
	}

	public static function updateUser($id) {
		$user = User::findOneUser($id);
		if ($user->getAdmin() == TRUE) {
			Redirect::to('/users', array('message' => 'Admin rights cannot be revoked.'));
		} else {
			$user->makeAdmin();
			$user->updateUser($id);
			Redirect::to('/users', array('message' => 'Chosen user has been promoted to an admin status.'));
		}
	}
}