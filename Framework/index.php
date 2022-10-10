<?php

// get the bootstrap.php file
require("core/bootstrap.php");

// call the uri function in request
$uri = Request::uri(); // remove the / from the url

$router = Router::load('routes.php'); // create the rooter and loads the routes.php

$router->direct($uri); // Show $uri while staying in index.php
