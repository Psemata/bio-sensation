<?php

require_once("app/models/User.php");

/**
* User controller
* He will sign in, sign up or disconnect the user
*/
class UserController {

  /**
   * Connect the user to the website and redirect him
   * 
   * @param void
   * 
   * @return void
   */
  public function connection() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      if(isset($_POST['email']) && isset($_POST['password'])) {
        // If the email exist and the password is the good one, then the user can connect
        if(User::isExisting($_POST['email']) && User::comparePassword($_POST['email'], $_POST['password'])){
          $_SESSION['user'] = User::getIDByEmail($_POST['email']);
          header("Location:index");
          exit(0);
        } else {
          $data = array("L'adresse email ou le mot de passe est incorrect");
          Helper::view("sign_in", $data);
        }
      }
    } else {
      Helper::view("sign_in");
    }
  }

  /**
   * Sign up the user
   * 
   * @return void
   * 
   * @param void
   */
  public function signingUp() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      if(isset($_POST['password']) && isset($_POST['email'])) {
        // If the email already exists    
        if(User::isExisting($_POST['email'])){
          $data = array("Cet email est lié à un compte déjà existant");
          Helper::view("sign_up", $data);
        // If the username already exists
        } else if(User::isUsernameExisting($_POST['username'])){
          $data = array("Ce pseudo est déjà utilisé par un autre utilisateur");
          Helper::view("sign_up", $data);
        } else {
          unset($_POST['password_confirmation']);
          $_POST['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
          $_POST['admin'] = 0;
          User::save($_POST);
          header("Location:signin");
          exit(0);
        }
      }
    } else {
      Helper::view("sign_up");
    }
  }

  /**
   * Disconnect the user
   * 
   * @return void
   * 
   * @param void
   */
  public function disconnect(){
    if(isset($_SESSION['user'])){
      $_SESSION = [];
      header("Location:signin");
      exit(0);
    }
  }
}