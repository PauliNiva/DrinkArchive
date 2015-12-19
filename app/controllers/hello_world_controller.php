<?php

  class HelloWorldController extends BaseController{

    public static function index(){
      // make-metodi renderöi app/views-kansiossa sijaitsevia tiedostoja
   	  View::make('/plans/frontpage.html');
    }

    public static function sandbox(){
      // Testaa koodiasi täällä
      View::make('helloworld.html');
    }

    public static function listDrinks(){
      // Testaa koodiasi täällä
      View::make('/plans/drinklist.html');
    }

    public static function specificDrink(){
      // Testaa koodiasi täällä
      View::make('/plans/specificdrink.html');
    }

    public static function editPage(){
      // Testaa koodiasi täällä
      View::make('/plans/editpage.html');
    }

    public static function favorites(){
      // Testaa koodiasi täällä
      View::make('/plans/favorites.html');
    }
  }
