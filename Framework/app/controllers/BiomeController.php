<?php

require_once("app/models/Biome.php");

/**
* Biome controller, used to get data biome from the database
*/
class BiomeController {

    /**
     * Get the id of one biome by its positions and return via an echo for AJAX
     * 
     * @param void
     * 
     * @return void
     */
    public function getBiome() {
        if(isset($_POST['posX']) && isset($_POST['posY'])) {
          $id = Biome::isExisting($_POST['posX'], $_POST['posY']);
          if($id == -1){
            echo "erreur";
            exit(0);
          }
          echo Biome::getPlaylist($id);
          exit(0);
        }
    }

    /**
     * Get all the biomes in the database
     * 
     * @param void
     * 
     * @return void
     */
    public function getAllBiomes(){
      echo json_encode(Biome::fetchAllAsArray());
    }

}
