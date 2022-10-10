<?php

class Router {
  protected $routes = [];

  public function define($routes) {
    $this->routes = $routes;
  }

  public function direct($uri) {
    // example.com/about/us
    // Remove the parameters
    $uri = parse_url($uri)["path"];

    // remove installation prefix
    if (isset(App::get('config')['install_prefix'])) {
      if (strncmp($uri, App::get('config')['install_prefix'], strlen(App::get('config')['install_prefix'])) == 0) {
        if (!($uri = substr($uri, strlen(App::get('config')['install_prefix']) + 1))) {
          $uri = "";
        }
      }
    }

    if(array_key_exists ($uri, $this->routes)) {
        return $this->callAction(
            ...explode('@', $this->routes[$uri]) // ... splat operator, voir http://php.net/manual/fr/migration56.new-features.php
        );
    }
    throw new Exception("Not routes defined for this URI.", 1);
  }

  protected function callAction($controller, $action = 'index') {
      require_once ("app/controllers/" . $controller . ".php");
      $control = new $controller;

      if(!method_exists($control, $action)) {        
        throw new Exception("$controller does not respond to the action $action.");
      }
      return $control->$action();
  }

  public static function load($file) {
    $router = new static;
    require 'app/' . $file;

    return $router;
  }
}
