<?php
// include our OAuth2 Server object
require_once __DIR__.'/server.php';

// code Authorization
$server->handleTokenRequest(OAuth2\Request::createFromGlobals())->send();
// var_dump($server);

 ?>
