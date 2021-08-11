<?php
// include our OAuth2 Server object
require_once __DIR__.'./server.php';

if (!$server->verifyResourceRequest(OAuth2\Request::createFromGlobals())) {
    $server->getResponse()->send();
    // set response code
    http_response_code(502);
    // token introuvable
    echo json_encode(array("message" => "token introuvable"));
    die;
}

$token = $server->getAccessTokenData(OAuth2\Request::createFromGlobals());
echo "User ID associated with this token is {$token['user_id']}";


 ?>
