<?php

require_once("core/database/Model.php");

/**
 * The Login class
 */
class User extends Model {
    // id - number
    private $id;
    // email -text
    private $email;
    // password - text
    private $password;
    // pseudo - text
    private $username;
    // role - bool
    private $admin;

    /**
     * Function which checks if an email is present or not
     * 
     * @param string $email email of a user
     * 
     * @return boolean !empty($elem) value which tells if the email exists or not
     */
    public static function isExisting($email){
      // Connection to the database
      $dbh = App::get("dbh");
      // Prepare the query which get the element with an email
      $stmt = $dbh->prepare("SELECT * FROM " . App::get("config")["database"]["dbname"] . "." . mb_strtolower(get_called_class()) . " WHERE email=:element_email");
      // Bind the email to the query
      $stmt->bindValue(":element_email", $email);
      // Execute the query
      $stmt->execute();
      // Get the element from the query
      $elem = $stmt->fetch(PDO::FETCH_ASSOC);
      // if the email exist, return true / false
      return !empty($elem);
    }

    /**
     * Function which checks if a pseudo is present or not
     * 
     * @param string $pseudo pseudo of a user
     * 
     * @return boolean !empty($elem) value which tells if the pseudo exists or not
     */
    public static function isUsernameExisting($pseudo) {
      // Connection to the database
      $dbh = App::get("dbh");
      // Prepare the query which get the element with the wanted pseudo
      $stmt = $dbh->prepare("SELECT * FROM " . App::get("config")["database"]["dbname"] . "." . mb_strtolower(get_called_class()) . " WHERE username=:element_pseudo"); 
      // Bind the pseudo to the query
      $stmt->bindValue(":element_pseudo", $pseudo);
      // Execute the query
      $stmt->execute();
      // Get the element from the query
      $elem = $stmt->fetch(PDO::FETCH_ASSOC);
      // If the pseudo exist, return true / false;
      return !empty($elem);
    }

    /**
     * Function which returns an element's id by its email
     * 
     * @param $email
     * 
     * @return string $elem['id'] the id from a user found with its mail
     * @return int -1 if the email is not found
     */
    public static function getIDByEmail($email){
      // Connection to the database
      $dbh = App::get("dbh");
      // Prepare the query which get the element with an email
      $stmt = $dbh->prepare("SELECT * FROM " . App::get("config")["database"]["dbname"] . "." . mb_strtolower(get_called_class()) . " WHERE email=:element_email");
      // Bind the email to the query
      $stmt->bindValue(":element_email", $email);
      // Execute the query
      $stmt->execute();
      // Get the element from the query
      $elem = $stmt->fetch(PDO::FETCH_ASSOC);
      // return the user's id
      if (!empty($elem)) {
        return $elem['id'];
      } else {
        return -1;
      }
    }

    /**
     * Function which compares the password entered and the password in the database
     * 
     * @param string $email email of the user
     * @param string $password password of the user
     * 
     * @return boolean true if the passwords are the same, false if they aren't
     */
    public static function comparePassword($email, $password){
      // Connection to the database
      $dbh = App::get("dbh");
      // Prepare the query which get the element with an email
      $stmt = $dbh->prepare("SELECT * FROM " . App::get("config")["database"]["dbname"] . "." . mb_strtolower(get_called_class()) . " WHERE email=:element_email");
      // Bind the email to the query
      $stmt->bindValue(":element_email", $email);
      // Execute the query
      $stmt->execute();
      // Get the element from the query
      $elem = $stmt->fetch(PDO::FETCH_ASSOC);
      // return true if the password is the same, false otherwise
      return password_verify($password, $elem['password']);
    }
}
?>
