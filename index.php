<?php
require __DIR__.'/core/init.php';

// 配置shutdown函数
\lbs\ConfigManager::set('eh.shutdown_func', array('\lbs\RspManager', 'send'));

\lbs\ErrorHandler::init();

$request = new \lbs\http\HttpRequest;
$response = new \lbs\http\HttpResponse($request);

$ret = \lbs\Proxy::route($request, $response);

echo $ret ? $response->getContent() : $response->getError();