<?php

$router->define([
  // all controlers are in the controller folder
  '' => 'IndexController', // Main window of the application
  'index' => 'IndexController',
  'signup' => 'UserController@signingUp',
  'signin' => 'UserController@connection',
  'disconnect' => 'UserController@disconnect',
  'getbiome' => 'BiomeController@getBiome',
  'getallbiomes' => 'BiomeController@getAllBiomes'
]);
