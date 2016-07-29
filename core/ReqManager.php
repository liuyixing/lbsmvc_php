<?php
namespace lbsmvc\core;

class ReqManager
{
	public static $route = 'index_index';
	public static $class = 'IndexAction';
	public static $method = 'index';
	public static $params = array();
	public static $other = array();

	public static function init()
	{
		$route = empty($_GET['r']) ? 'index_index' : strtolower($_GET['r']);

	    list($action_class, $action_method) = explode('_', $route);

	    if (empty($action_method))
	    {
	        $action_method = 'index';
	    }

	    $action = '\\lbsmvc\\action\\'.ucfirst($action_class) . 'Action::' . $action_method;
	    $params = array_merge($_GET, $_POST);
	    unset($_GET, $_POST);
	    
	    return array('action' => $action, 'params' => $params);
	}
}