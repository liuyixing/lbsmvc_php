<?php
namespace lbs\http;

use lbs\Request;

class HttpRequest extends Request
{
	public function __construct()
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
		
		$this->route = $route;
		$this->action_class = $action_class;
		$this->action_method = $action_method;
		$this->action_params = $params;
		$this->client_ip = $_SERVER['REMOTE_ADDR'];

		return true;
	}

	public function header($name)
	{
		
	}

	public function cookie($name)
	{
		return isset($_COOKIE[$name]) ? $_COOKIE[$name] : NULL;
	}

	public function env($name)
	{

	}	
}
