<?php

  $routes->get('/', function() {
    HelloWorldController::index();
  });

  $routes->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
  });

  $routes->get('/drinklist', function() {
    HelloWorldController::listDrinks();
  });

  $routes->get('/specificdrink', function() {
    HelloWorldController::specificDrink();
  });

  $routes->get('/editpage', function() {
    HelloWorldController::editPage();
  });

  $routes->get('/favorites', function() {
    HelloWorldController::favorites();
  });

  $routes->get('/drink', function() {
    DrinkController::index();
  });

  $routes->get('/drink/:id', function($id) {
    DrinkController::show($id);
  });

  $routes->get('/addDrink', function() {
    DrinkController::addNew();
  });

  $routes->post('/addDrink', function() {
    DrinkController::store();
  });

  $routes->post('/drink/:id/destroy', function($id){
  DrinkController::destroy($id);
  });