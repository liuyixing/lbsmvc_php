<?php
require __DIR__.'/core/init.php';

// 设置shutdown函数
\lbsmvc\core\ErrorHandler::init(array('\lbsmvc\core\RspManager', 'send'));
\lbsmvc\core\ActionProxy::registerPreAction(array('\lbsmvc\core\ReqManager', 'valid'));

$target = \lbsmvc\core\ReqManager::init();
$ret = \lbsmvc\core\ActionProxy::run($target);
\lbsmvc\core\RspManager::send($ret);
