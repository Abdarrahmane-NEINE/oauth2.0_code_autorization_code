<?php
// header requis
header("Access-Control-Allow-Origin:  http://localhost/api-authentication/"); // autorisation
header("Content-Type: application/json; charset=UTF-8");// contenu de la réponse
header("Access-Control-Allow-Methods: GET");// méthode acccépté pour la requette en question
header("Access-Control-Max-Age: 3600"); // durée de vie la requette
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With"); // le header qu'on autorise vis à vis du poste de client

// on verifie que la methode utilisée est correscte
if($_SERVER['REQUEST_METHOD'] == 'GET'){
  //pour verifier si la méthode de la requet est bon
  // on inclut les fichiers de configurations et d'accès aux donnéelse
  include_once './config/Database.php';
  include_once './models/User.php';
  require_once __DIR__.'./server.php';
  // on instancie la base de donnée
  $database = new Database();
  // on cree notre Connexion
  $db = $database ->getConnection();

  // on instancie le user
  $user = new User($db);

  // on recupère les informations envoyées en JSON
  // on cree un objet qui contient les info de user
  $donnees = json_decode(file_get_contents("php://input"));
 // var_dump($donnees);
  // $user->Id = $donnees->Id;
   $user->Email = $donnees->Email;
   $email_exists = $user->emailExists();
   $user->Password = $donnees->Password;
   $password_exists = $user->passwordExist();

    // verification si l'email et e mot de passe sont correct
    if(
      !empty($user->Email) &&
      !empty($user->Password)
      ){
      // vérifier si le token exist ou valid
      include_once './resource.php';

        // on envoie le code réponse 200 ok
        http_response_code(200);
        echo json_encode(
                array(
                    "message" => "login Réussi",
                    "user ID associated with this token is" => "$user->Id"
                ));
   }
   else{

      // set response code
      http_response_code(501);
      // login echou
      echo json_encode(array("message" => "login echou"));
   }
}
else{
  // on gère l'erreur
  http_response_code(405);
  echo json_encode(["message"=> "la méthode n'est pas autorisée"]);
}
?>
