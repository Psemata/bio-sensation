<?php

class App{
    // Initialize the app array which will stock important informations/values
    private static $app = [];

    // "Magic getter" which will be used to get element from the app array
    public static function get($name){
        return self::$app[$name];
    }

    // "Magic setter" which will be used to set element from the app array
    public static function set($name, $value){
        self::$app[$name] = $value;
    }

    // Function used to load the config into the app
    public static function load_config($file){
        self::$app['config'] = require($file);
    }
}
