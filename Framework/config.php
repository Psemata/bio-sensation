<?php
// return the app's config : database
return $config = [
    "database" => [
        "dbname" => "biosensation",
        "hostname" => "localhost",
        "username" => "root",
        "password" => "",
        /*"password" => "vz161",*/
        "connectiondesc" => "mysql:host=127.0.0.1",
        "connectionport" => "3306",
        "install_prefix" => "\\awb-g1-biosensation\\",
        /* "install_prefix" => "\\php\\", */
        "options" => array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)
    ],
    "install_prefix" => "awb-g1-biosensation/Framework"
    /*"install_prefix" => "php/Framework"*/
];
