<?php

  class BaseController {

    public static function get_user_logged_in(){
    if (isset($_SESSION['user'])){
      $user_id = $_SESSION['user'];
      $user = User::findOneUser($user_id);
      return $user;
    }
    return null;
  }

  public static function get_user_logged_in_admin(){
    if (isset($_SESSION['user'])){
      $user_id = $_SESSION['user'];
      $user = User::findOneUser($user_id);
      if ($user->getAdmin()) {
        return true;
      } else {
        return false;
      }
    }
    return null;
  }

    public static function check_logged_in(){
      // Toteuta kirjautumisen tarkistus tähän.
      // Jos käyttäjä ei ole kirjautunut sisään, ohjaa hänet toiselle sivulle (esim. kirjautumissivulle).
    }

  }
