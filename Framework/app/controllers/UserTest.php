<?php

require_once("app/models/User.php");

/**
* Unit test of the User class
*/
class UserTest {
    
    /**
     * Testing the <isExisting> function
     * 
     * @param void
     * 
     * @return void
     */
    public static function testIsExisting() {
        // Existing address
        $email1 = "bruno.costa@he-arc.ch";
        // Fake address
        $email2 = "utilisateur.lambda@he-arc.ch";

        if(User::isExisting($email1)) {
            echo "La fonction est correcte";
        } else {
            echo "La fonction ne fonctionne pas";
        }

        if(User::isExisting($email2)) {
            echo "La fonction ne fonctionne pas";            
        } else {
            echo "La fonction est correcte";
        }
    }

    /**
     * Testing the <getIdByEmail> function
     * 
     * @param void
     * 
     * @return void
     */
    public static function testGetIDByEmail() {
        // Existing address
        $email1 = "bruno.costa@he-arc.ch";
        // Fake address
        $email2 = "utilisateur.lambda@he-arc.ch";

        if(User::getIDByEmail($email1) != -1) {
            echo "La fonction est correcte";
            echo "Id : " . User::getIDByEmail($email1);
        } else {
            echo "La fonction ne fonctionne pas";
        }

        if(User::getIDByEmail($email2) != -1) {
            echo "La fonction ne fonctionne pas";          
        } else {
            echo "La fonction est correcte";
            echo "Id : " . User::getIDByEmail($email2);
        }
    }

    /**
     * Testing the <getIdByEmail> function
     * 
     * @param void
     * 
     * @return void
     */
    public static function testComparePassword() {
        $email1 = "bruno.costa@he-arc.ch";
        $pwd1 = "1234";
        $pwd2 = "11234123123";

        $email2 = "diogo.lopesdas@he-arc.ch";
        $pwd1 = "1234";
        $pwd2 = "11234123123";

        // Compare different password for the email 1
        echo "Email 1 : " . $email1;
        if(User::comparePassword($email1, $pwd1)) {
            echo "La fonction est correcte";
        } else {
            echo "La fonction ne fonctionne pas";
        }

        if(User::comparePassword($email1, $pwd2)) {
            echo "La fonctione ne fonctionne pas";
        } else {
            echo "La fonction est correcte";
        }

        // Compare different password for the email 2
        echo "Email 2 : " . $email2;
        if(User::comparePassword($email2, $pwd1)) {
            echo "La fonction est correcte";
        } else {
            echo "La fonction ne fonctionne pas";
        }

        if(User::comparePassword($email2, $pwd2)) {
            echo "La fonctione ne fonctionne pas";
        } else {
            echo "La fonction est correcte";
        }
    }
}