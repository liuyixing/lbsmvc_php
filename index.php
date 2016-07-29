<?php
require __DIR__.'/core/init.php';

// 配置shutdown函数
\lbsmvc\core\ConfigManager::set('eh.shutdown_func', array('\lbsmvc\core\RspManager', 'send'));

\lbsmvc\core\ErrorHandler::init();

\lbsmvc\core\ActionProxy::handle('\lbsmvc\core\ReqManager', '\lbsmvc\core\RspManager');