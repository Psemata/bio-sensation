<?php

/**
* Index controller, he will send you to the main page if you can
*/
class IndexController {

    /**
     * Go to the main page
     * 
     * @param void
     * 
     * @return void
     */
    public function index() {
      // Check if a user is connected or not
      if(isset($_SESSION['user'])){
        // Move to the index view
        Helper::view("index");
      } else {
        // If the user is not connected, move to the connection view
        header("Location:signin");
        exit(0);
      }
    }

}
