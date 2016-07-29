<?php
require __DIR__.'/core/init.php';

// 配置shutdown函数
\lbsmvc\core\ConfigManager::set('eh.shutdown_func', array('\lbsmvc\core\RspManager', 'send'));

\lbsmvc\core\ErrorHandler::init();

$ret = \lbsmvc\core\Proxy::route('\lbsmvc\core\ReqManager', '\lbsmvc\core\RspManager');

if (is_string($ret))
{
	echo $ret;
}