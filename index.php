<?php
require __DIR__.'/core/init.php';

// 配置shutdown函数
C::set('eh.shutdown_func', array('RspManager', 'send'));

ErrorHandler::init();

$request = new HttpRequest;
$response = new HttpResponse($request);

$ret = Proxy::route($request, $response);

echo $ret ? $response->getContent() : $response->getError();
