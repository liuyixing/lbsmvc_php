<?php
// 路径和常量定义
define('DS', DIRECTORY_SEPARATOR);
define('NS', '\\'); // NAMESPACE_SEPARATOR
define('FRAMEWORK_NAME', 'lbs');
define('ROOT_PATH', dirname(__DIR__) . DS);
define('CORE_PATH', ROOT_PATH . 'core' . DS);
define('CONF_PATH', ROOT_PATH . 'conf' . DS);
define('TPL_PATH', ROOT_PATH . 'static' . DS . 'tpl' . DS);

// 注册类加载器
require CORE_PATH.'/ClassLoader.php';

// 引入全局函数和常量
require CORE_PATH.'/gb.php';

// 加载配置文件
\lbs\ConfigManager::init();
