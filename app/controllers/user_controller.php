<?php

require 'app/models/user.php';
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
}