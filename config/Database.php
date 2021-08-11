<?php

class Database{
  //Connexion à la base de donées
  private $host = 'localhost';
  private $username = 'root';
  private $password = '';
  private $db_name= 'bd_oauth2.0';
  public $connexion;

  // connexion
  public function getConnection(){

    $this->connexion = null;

    //On essaie de se connecter
    try{
        $this->connexion = new PDO("mysql:host=" .$this->host . ";dbname=" . $this->db_name, $this->username, $this->password);

        //On définit le mode d'erreur de PDO sur Exception
        $this->connexion->exec("set names utf8");
        // echo 'Connexion réussie';
    }
    /*On capture les exceptions si une exception est lancée et on affiche
     *les informations relatives à celle-ci*/
    catch(PDOException $exception){
      echo "Erreur de connexion: " . $exception->getMessage();
    }

    return $this->connexion;
  }
}

 ?>
