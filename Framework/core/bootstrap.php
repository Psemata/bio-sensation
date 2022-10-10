<?php

// Get the important files
require("core/Router.php");
require("core/Request.php");
require("core/App.php");
require("helpers/Helper.php");

// Load the configuration used for the app (database, etc...)
App::load_config("config.php");

// Database initialisation
App::set('dbh', new PDO(App::get('config')['database']['connectiondesc'] . ";" . App::get('config')['database']['dbname'] . ";charset=utf8", App::get('config')['database']['username'], App::get('config')['database']['password'], App::get('config')['database']['options']));

// Session start
session_start();
