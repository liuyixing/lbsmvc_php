<?php
require __DIR__.'/core/init.php';

// 配置shutdown函数
//C::set('eh.shutdown_func', array('RspManager', 'send'));

\core\ErrorHandler::init();

$request = new \core\http\HttpRequest;
$response = new \core\http\HttpResponse($request);

$ret = \core\Proxy::route($request, $response);

echo $ret ? $response->getContent() : $response->getError();
