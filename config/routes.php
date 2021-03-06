<?php

  $routes->get('/', function() {
    DrinkController::front();
  });

  $routes->get('/register', function() {
    UserController::registration();
  });

  $routes->post('/register', function() {
    UserController::registerUser();
  });

  $routes->get('/login', function() {
    UserController::showLogin();
  });

  $routes->post('/login', function() {
    UserController::login();
  });

  $routes->get('/logout', function(){
    UserController::logout();
  });

  $routes->get('/users', function() {
    UserController::showUsers();
  });

  $routes->get('/user/:id', function($id) {
    UserController::showUser($id);
  });

  $routes->post('/users/:id/destroy', function($id){
    UserController::destroyUser($id);
  });

  $routes->get('/users/:id/edit', function($id){
    UserController::editUser($id);
  });

  $routes->post('/users/:id/edit?', function($id){
    UserController::updateUser($id);
  });

  $routes->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
  });

  $routes->get('/favorites', function() {
    UserController::showFavorites();
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

  $routes->get('/search', function() {
    DrinkController::showSearchPage();
  });

  $routes->post('/search', function() {
    DrinkController::showSearchResults();
  });

  $routes->post('/favorites/:id/destroy', function($id){
  UserController::removeFav($id);
  });

  $routes->post('/drink/:id/favorite', function($id){
  UserController::addFav($id);
  });