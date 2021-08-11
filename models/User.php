<?php
// l'ojet user
class User{
  //Connexion
  private $connexion;
  private $table_name = "users";

  // propririétés de l'objet
  public $Id;
  public $Nom;
  public $Prenom;
  public $Email;
  public $Password;

  // Constructeur avec $db pour la connexion à la base de données
  public function __construct($db){
    $this->connexion = $db;
  }


   // un methode pour la création du user
   function creer_user(){

       $sql = "INSERT INTO  users
        SET
        Nom =:Nom,
        Prenom =:Prenom,
        Email =:Email,
        Password =:Password";
        // $sql ="INSERT INTO users (Nom, Prenom, Email, Password) VALUES (':Nom', ':Prenom', ':Email', ':Password')";

       //on prepare la requette
       $query = $this->connexion->prepare($sql);

       // pour éviter les failles xss
       // $this->Nom=htmlspecilachars(strip_tags($this->Nom));
       // $this->Prenom=htmlspecilachars(strip_tags($this->Prenom));
       // $this->Email=htmlspecilachars(strip_tags($this->Email));
       // $this->Password=htmlspecilachars(strip_tags($this->Password));


       // on fait le lien entre les parametres de la requette et de l'execute par bindParam
       $query->bindParam(':Nom', $this->Nom);
       $query->bindParam(':Prenom', $this->Prenom);
       $query->bindParam(':Email', $this->Email);
       $query->bindParam(':Password', $this->Password);
       // hachage de mot de passe
      // $password_hash = $password_hash($this->Password, PASSWORD_BCRYPT);
      // $query->bindParam(":Password", $password_hash);
      function check_email_address($Email)
      {
       return (!preg_match( "^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^", $Email)) ? false : true;
      }
       if($query->execute()){
         return true;
       }
       return false;


   }
   //Tester si le password exist
   function passwordExist(){
     $sql =" SELECT Id, Nom, Prenom
      FROM users
      WHERE Id= :Id AND Email= :Email AND Password= :Password";

      //on prepare la requette
      $query = $this->connexion->prepare($sql);

      // $this->Password=htmlspecilachars(strip_tags($this->Password));
      // on fait le lien entre les parametres de la requette et de l'execute par bindParam

      // $query->bindParam(1, $this->Password);

      $query->execute(array(':Id'=>$this->Id, ':Password'=>$this->Password, ':Email'=>$this->Email));

      $nombre = $query->rowCount();

      if($nombre==0){
        // get record details / values
          $row = $query->fetch(PDO::FETCH_ASSOC);
          // affecter des valeurs aux propriétés de l'objet
          $this->Id = $row['Id'];
          $this->Nom = $row['Nom'];
          $this->Prenom = $row['Prenom'];
          $this->Email = $row['Email'];
          $this->Password = $row['Password'];

          // return true because email exists in the database
          return true;
      }
      // return false if email does not exist in the database
      return false;

   }
   // validation de l'email

   //Tester si l'email exist
   function emailExists(){

       $sql = " SELECT Id, Nom, Prenom, Password
       FROM users
       WHERE Email = ?
       LIMIT 0,1";
       // $sql =" SELECT Id, Nom, Prenom, Email
       //  FROM users
       //  WHERE  Password= :Password";

      //on prepare la requette
      $query = $this->connexion->prepare($sql);

      // $this->Email=htmlspecilachars(strip_tags($this->Email));
      // on fait le lien entre les parametres de la requette et de l'execute par bindParam

      $query->bindParam(1, $this->Email);

      $query->execute();

      $nombre = $query->rowCount();

      if($nombre>0){
        // get record details / values
          $row = $query->fetch(PDO::FETCH_ASSOC);

          // affecter des valeurs aux propriétés de l'objet
          $this->Id = $row['Id'];
          $this->Nom = $row['Nom'];
          $this->Prenom = $row['Prenom'];
          $this->Password = $row['Password'];

          // return true because email exists in the database
          return true;
      }
      // return false if email does not exist in the database
      return false;

   }
}
 ?>
