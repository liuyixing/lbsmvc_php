<?php
// 路径和常量定义
define('DS', DIRECTORY_SEPARATOR);
define('NS', '\\');
define('FRAMEWORK_NAME', 'LBS');
define('ROOT_PATH', dirname(__DIR__) . DS);
define('ACTION_PATH', ROOT_PATH . 'action' . DS);
define('CORE_PATH', ROOT_PATH . 'core' . DS);
define('CONF_PATH', ROOT_PATH . 'conf' . DS);
define('DAO_PATH', ROOT_PATH . 'dao' . DS);
define('SERVICE_PATH', ROOT_PATH . 'service' . DS);
define('LIB_PATH', ROOT_PATH . 'lib' . DS);
define('TPL_PATH', ROOT_PATH . 'static' . DS . 'tpl' . DS);

// 注册类加载器
require CORE_PATH.'/ClassLoader.php';

// 全局
require CORE_PATH.'/gb.php';

// 加载配置文件
C::init();
