<?php
require_once __DIR__.'/vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

$request = Request::createFromGlobals();

$myIp = "127.0.0.1";

if ($myIp === $request->getClientIp()) {
  // the client is a known one, so give it some more privilege
  $name = $request->get('name', 'World');
  
  $response = new Response(sprintf('Hello %s', htmlspecialchars($name, ENT_QUOTES, 'UTF-8')));
  
  $response->send();
}
