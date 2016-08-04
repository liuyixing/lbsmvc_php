<?php
require __DIR__.'/core/init.php';

\framework\ErrorHandler::init();

$request = new \framework\http\HttpRequest;
$response = new \framework\http\HttpResponse($request);
\framework\ReqHandler::handle($request, $response);
$response->send();