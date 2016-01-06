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

    	$newUser->setUsername($username);
    	$newUser->setPassword($password);
    	$newUser->setAdmin($boo);
    	if ($password == $password2) {
    		$newUser->saveUser();
    	} else {
    		// TODO throw errorRedirect::to('/drink', array('message' => 'Drink has been deleted.'));
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
    	Drink::addFavorite($user, $drink);
		Redirect::to('/drink', array('message' => 'Favorite has been added.'));
    }
}