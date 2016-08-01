<?php
require __DIR__.'/core/init.php';

// 配置shutdown函数
\lbsmvc\core\ConfigManager::set('eh.shutdown_func', array('\lbsmvc\core\RspManager', 'send'));

\lbsmvc\core\ErrorHandler::init();

$request = new \lbsmvc\core\http\HttpRequest;
$response = new \lbsmvc\core\http\HttpResponse($request);

$ret = \lbsmvc\core\Proxy::route($request, $response);

echo $ret ? $response->getContent() : $response->getError();
