<?php // include our OAuth2 Server object
require_once __DIR__.'/server.php';


$request = OAuth2\Request::createFromGlobals();
$response = new OAuth2\Response();

// validate the authorize request
if (!$server->validateAuthorizeRequest($request, $response)) {
    $response->send();
    die;
}
// display an authorization form
// if (empty($_POST)) {
//   exit('
// <form method="POST" >
//   <label>Do You Authorize TestClient?</label><br />
//   <input type="submit" name="authorized" value="yes">
//   <input type="submit" name="authorized" value="no">
// </form>');
// }

// print the authorization code if the user has authorized your client
$is_authorized = true;
// var_dump($is_authorized);
//
// $userid = '123'; // A value on your server that identifies the user
$userid = '12';
$server->handleAuthorizeRequest($request, $response, $is_authorized, $userid);
// $server->handleAuthorizeRequest($request, $response, $is_authorized);
if ($is_authorized) {
// c'est seulement ici pour que vous puissiez voir votre code dans la requête cURL. Sinon, nous redirigerions vers le client
$data = substr($response->getHttpHeader('Location'), strpos($response->getHttpHeader('Location'), 'code=')+5, 40);

// echo ("code = ".$data);
exit("SUCCESS! Authorization Code: $data");
}
  $response->send();

?>
