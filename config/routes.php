<?php

  $routes->get('/', function() {
    DrinkController::front();
  });

  $routes->get('/register', function() {
    DrinkController::registration();
  });

  $routes->post('/register', function() {
    DrinkController::registerUser();
  });

  $routes->get('/login', function() {
    DrinkController::showLogin();
  });

  $routes->post('/login', function() {
    DrinkController::login();
  });

  $routes->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
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

  $routes->get('/drink/:id/edit', function($id){
  DrinkController::edit($id);
  });

  $routes->post('/drink/:id/edit?', function($id){
  DrinkController::update($id);
  });