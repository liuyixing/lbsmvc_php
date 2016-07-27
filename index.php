<?php
require __DIR__.'/core/init.php';

// 设置shutdown函数
\lbsmvc\core\ErrorHandler::$shutdown_func = function()
{
    echo "PHP shutdown";
};
//\lbsmvc\core\ErrorHandler::init();

// 解包函数
$pack_func = function ()
{
    $route = empty($_GET['r']) ? 'index_index' : strtolower($_GET['r']);
    if (!preg_match('/^[a-z][a-z0-9]+(_[a-z][a-z0-9]+)?$/', $route))
    {
        return false;
    }

    list($action_class, $action_method) = explode('_', $route);

    if (empty($action_method))
    {
        $action_method = 'index';
    }

    $action = '\\lbsmvc\\action\\'.ucfirst($action_class) . 'Action::' . $action_method;
    $params = array_merge($_GET, $_POST);
    unset($_GET, $_POST);
    
    return array('action' => $action, 'params' => $params);
};

// 打包函数
$unpack_func = function ()
{

};

$ret = \lbsmvc\core\ActionProxy::route($pack_func, $unpack_func);

if (is_string($ret))
{
    echo $ret;
}
