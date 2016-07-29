<?php
namespace lbsmvc\core;

class ReqManager
{
	public static $route = 'index_index';
	public static $class = 'IndexAction';
	public static $method = 'index';
	public static $params = array();
	public static $other = array();

	public static function unpack()
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

	    $params = array_merge($_GET, $_POST);
	    unset($_GET, $_POST);
		
		self::$route = $route;
		self::$class = $action_class;
		self::$method = $action_method;
		self::$params = $params;
	    
	    return true;
	}
}
