<?php

require_once("core/database/Model.php");

/**
 * The Biome class
 */
class Biome extends Model {
    // id - number
    private $id;
    // position x and y - numbers
    private $posX;
    private $posY;
    // radius of the biome - number
    private $radius;
    // genre of the biome - string
    private $genre;

    /**
     * Check if a biome exist at the given positions
     * 
     * @param int $posX position x of a biome
     * @param int $posY position y of a biome
     * 
     * @return int $id id of the found biome
     */
    public static function isExisting($posX, $posY){
        // Connection to the database
        $dbh = App::get("dbh");
        $stmt = $dbh->prepare("SELECT * FROM " . App::get("config")["database"]["dbname"] . "." . mb_strtolower(get_called_class()) . " WHERE SQRT(POW((pos_x - :element_posX), 2) + POW((pos_y - :element_posY), 2)) <= radius ORDER BY SQRT(POW((pos_x - :element_posX), 2) + POW((pos_y - :element_posY), 2)) LIMIT 1");
        // Bind the pos x and the pos y to the query
        $stmt->bindValue(":element_posX", $posX);
        $stmt->bindValue(":element_posY", $posY);
        // Execute the query
        $stmt->execute();
        // Get the element from the query
        $elem = $stmt->fetch(PDO::FETCH_ASSOC);

        $id = 0;
        if(!empty($elem)) {
            $id = $elem["id"];
        } else {
            $id = -1;
        }
        return $id;
    }

    /**
     * Get the name of the genre
     * 
     * @param int $id id of the biome
     * 
     * @return string $elem['name'] name of the found genre
     * @return string "notFound" if no genre if found
     */
    public static function getGenreName($id) {
        $dbh = App::get("dbh");
        $stmt = $dbh->prepare("SELECT * FROM " . App::get("config")["database"]["dbname"] . "." . mb_strtolower(get_called_class()) . " WHERE id=:element_id");
        $stmt->bindValue(":element_id", $id);
        $stmt->execute();
        // Get the element from the query
        $elem = $stmt->fetch(PDO::FETCH_ASSOC);
        if(!empty($elem)){
            return $elem['name'];
        } else {
            return "notFound";
        }
    }

    /**
     * Get a playlist from a biome id
     * 
     * @param int $id id of the biome
     * 
     * @return string $elem['name'] the name of the playlist
     */
    public static function getPlaylist($id) {
        // Connection to the database
        $string1 = App::get("config")["database"]["dbname"] . ".";
        $string2 = App::get("config")["database"]["dbname"] . "." . mb_strtolower(get_called_class());
        $dbh = App::get("dbh");
        $stmt = $dbh->prepare("SELECT * FROM " . $string2 . " JOIN " . $string1 . "genre on " . $string2 . ".genre = " . $string1 . "genre.id JOIN " . $string1 . "playlist on " . $string1 . "genre.playlist = " . $string1 . "playlist.id WHERE " . $string1 . "biome.id = :element_id");
        $stmt->bindValue(":element_id", $id);
        // Execute the query
        $stmt->execute();
        // Get the element from the query
        $elem = $stmt->fetch(PDO::FETCH_ASSOC);
        return $elem["name"];
    }
}
