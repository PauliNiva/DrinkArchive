<?php

require 'app/models/drink.php';
require 'app/models/drink_ingredient.php';
require 'app/models/drink_type.php';
require 'app/models/ingredient.php';
require 'app/models/user.php';
require 'lib/utilities.php';

class DrinkController extends BaseController {

	public static function front(){
   	  View::make('/drink/frontpage.html');
    }

	public static function index() {
		$count = new Utilities();
		$count->countDrinks();
		$drinks = Drink::findAll();
		View::make('drink/index.html', array('drinks' => $drinks, 'count' => $count));
	}

	public static function show($id) {
		$drink = Drink::findOne($id);
		$drink_ingredients = DrinkIngredient::listDrinkIngredients($id);
		View::make('drink/specific_drink.html', array('drink' => $drink, 'drink_ingredients' => $drink_ingredients));
	}

	public static function addNew() {
		$drink_types = DrinkType::listDrinkTypes();
		View::make('drink/new.html', array('drink_types' => $drink_types));
	}

	public static function destroy($id) {
		$drink = Drink::findOne($id);
		$drink->destroy();
		Redirect::to('/drink', array('message' => 'Drink has been deleted.'));
	}

	public static function edit($id) {
		$drink = Drink::findOne($id);
		$drink_types = DrinkType::listDrinkTypes();
		$drink_ingredients = DrinkIngredient::listDrinkIngredients($id);
		View::make('drink/edit.html', array('attributes' => $drink, 'drink_types' => $drink_types, 'drink_ingredients' => $drink_ingredients));
	}

	public static function update($id) {
		$modifiedDrink = Drink::findOne($id);
		$name = $_POST['drink_name'];
		$errors = Drink::validateEditedDrink_name($name);
		DrinkController::validateNameErrors($errors, $id);
		$ingredients = $_POST['ingredients'];
		DrinkController::validateIngredientsEdit($name, $ingredients, $id);
		$amounts = $_POST['amounts'];
		DrinkController::validateAmountEdit($name, $ingredients, $id, $amounts);	
    	$units = $_POST['units'];
    	$ingredient_ids = $_POST['ingredient_id'];
    	DrinkController::editIngredients($ingredients, $id, $ingredient_ids, $amounts, $units);
    	$modifiedDrink->setDrink_name($name);
    	$modifiedDrink->setDrink_type($_POST['drink_type']);
    	$modifiedDrink->setInstructions($_POST['instructions']);
    	$modifiedDrink->update();
    	Redirect::to('/drink/' . $modifiedDrink->getDrink_id(), array('message' => 'Drink has been modified.'));
  	}

	public static function store() {
		$newDrink = new Drink();
		$mockDrink = new Drink();
		$drink_types = DrinkType::listDrinkTypes();
		$name = $_POST['drink_name'];
		$ingredients = $_POST['ingredients'];
		$amounts = $_POST['amounts'];
		$units = $_POST['units'];
		$mockDrink->setDrink_name($name);
    	$mockDrink->setDrink_type($_POST['drink_type']);
    	$mockDrink->setInstructions($_POST['instructions']);
    	DrinkController::validateNew($name, $mockDrink, $drink_types, $ingredients, $amounts);	
    	$newDrink->setDrink_name($name);
    	$newDrink->setDrink_type($_POST['drink_type']);
    	$newDrink->setInstructions($_POST['instructions']);
    	$newDrink->setAdder_id($_SESSION['user']);
    	$newDrink->save();
    	DrinkController::addIngredients($ingredients, $newDrink, $amounts, $units);
    	Redirect::to('/drink/' . $newDrink->getDrink_id(), array('message' => 'Drink has been archived.'));
  	}

  	public static function validateNew($name, $mockDrink, $drink_types, $ingredients, $amounts) {
  		$errors = Drink::validateDrink_name($name);
		if (count($errors) > 0) {	
  			View::make('drink/new.html', array('drink_types' => $drink_types,
  				'mockDrink' => $mockDrink, 'message' => $errors[0]));
  		}
  		foreach ($ingredients as $ingredient) {
			$ingredient_errors = Ingredient::validateIngredient_name($ingredient);      
		}
		if (count($ingredient_errors) > 0) {
  			View::make('drink/new.html', array('drink_types' => $drink_types,
  				'mockDrink' => $mockDrink, 'message' => $ingredient_errors[0]));
  		}
		foreach ($amounts as $amount) {
    		$amount_errors = DrinkIngredient::validateAmount($amount);
    	}
    	if (count($amount_errors) > 0) {
  			View::make('drink/new.html', array('drink_types' => $drink_types,
  				'mockDrink' => $mockDrink, 'message' => $amount_errors[0]));
  		}
  	}

  	public static function addIngredients($ingredients, $newDrink, $amounts, $units) {
  		$i = 0;
    	foreach ($ingredients as $ingredient) {
    		$ingredient = strtolower($ingredient);
            if (Ingredient::alreadyInArchive($ingredient) > 0) {
                $ingredient_id = Ingredient::alreadyInArchive($ingredient);
            } else {
                $newIngredient = new Ingredient();
                $newIngredient->setIngredient_name($ingredient);           
                $ingredient_id = $newIngredient->save();
            }
    		$newDrinkIngredient = new DrinkIngredient();
        	$newDrinkIngredient->setDrink_id($newDrink->getDrink_id());
        	$newDrinkIngredient->setIngredient_id($ingredient_id);
        	$newDrinkIngredient->setAmount($amounts[$i]);
        	$newDrinkIngredient->setUnit($units[$i]);
        	$newDrinkIngredient->save();
        	$i++;
    	}
  	}

  	public static function editIngredients($ingredients, $id, $ingredient_ids, $amounts, $units) {
  		$i = 0;
    	foreach ($ingredients as $ingredient) {
    		$ingredient = strtolower($ingredient);
            if (Ingredient::alreadyInArchive($ingredient) > 0) {
            	$ingredient_id = Ingredient::alreadyInArchive($ingredient);
            	$old_ingredient_id = $ingredient_ids[$i];
            	$newDrinkIngredient = new DrinkIngredient();
    			$newDrinkIngredient->setIngredient_id($ingredient_id);
        		$newDrinkIngredient->setDrink_id($id);
        		$newDrinkIngredient->setAmount($amounts[$i]);
        		$newDrinkIngredient->setUnit($units[$i]);
        		$newDrinkIngredient->update($old_ingredient_id);
            } else {
            	$newIngredient = new Ingredient();
                $newIngredient->setIngredient_name($ingredient);
                $ingredient_id = $newIngredient->save();
                $old_ingredient_id = $ingredient_ids[$i];
            	$newDrinkIngredient = new DrinkIngredient();
    			$newDrinkIngredient->setIngredient_id($ingredient_id);
        		$newDrinkIngredient->setDrink_id($id);
        		$newDrinkIngredient->setAmount($amounts[$i]);
        		$newDrinkIngredient->setUnit($units[$i]);
        		$newDrinkIngredient->update($old_ingredient_id);
            }
        	$i++;
    	}
  	}

  	public static function validateIngredientsEdit($name, $ingredients, $id) {
  		foreach ($ingredients as $ingredient) {
			$ingredient_errors = Ingredient::validateIngredient_name($ingredient);
			if (count($ingredient_errors) > 0) {
				$drink = Drink::findOne($id);
				$drink_types = DrinkType::listDrinkTypes();
				$drink_ingredients = DrinkIngredient::listDrinkIngredients($id);
				View::make('drink/edit.html', array('attributes' => $drink, 'drink_types' => $drink_types,
					'drink_ingredients' => $drink_ingredients, 'message' => $ingredient_errors[0]));
  			}   
		}
  	}

  	public static function validateAmountEdit($name, $ingredients, $id, $amounts) {
  		foreach ($amounts as $amount) {
    		$amount_errors = DrinkIngredient::validateAmount($amount);
    		if (count($amount_errors) > 0) {
    			$drink = Drink::findOne($id);
				$drink_types = DrinkType::listDrinkTypes();
				$drink_ingredients = DrinkIngredient::listDrinkIngredients($id);
				View::make('drink/edit.html', array('attributes' => $drink, 'drink_types' => $drink_types,
					'drink_ingredients' => $drink_ingredients, 'message' => $amount_errors[0]));
  			}
  		}
  	}

  	public static function validateNameErrors($errors, $id) {
  		if (count($errors) > 0) {
    		$drink = Drink::findOne($id);
			$drink_types = DrinkType::listDrinkTypes();
			$drink_ingredients = DrinkIngredient::listDrinkIngredients($id);
			View::make('drink/edit.html', array('attributes' => $drink, 'drink_types' => $drink_types,
				'drink_ingredients' => $drink_ingredients, 'message' => $errors[0]));
  		}
  	}

  	public static function showSearchPage() {
   	  View::make('/drink/search.html');
    }

    public static function showSearchResults() {
			$searchword = $_POST['searchword'];
    		$drinks = Drink::search($searchword);
    		View::make('/drink/search.html', array('drinks' => $drinks));
		
    }
}