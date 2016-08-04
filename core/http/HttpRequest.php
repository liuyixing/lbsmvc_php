<?php
namespace framework\http;

use framework\Request;

class HttpRequest extends Request
{
	public $is_ajax;
	public $get_params;
	public $post_params;
	public $cookies;
	public $headers;

	public function parseRequest()
	{
		// 解析路由
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

	    // 获取请求参数
	   	$params = array_merge($_GET, $_POST);

		$this->route = $route;
		$this->action_class = ucfirst($action_class) . 'Action';
		$this->action_method = $action_method;
		$this->action_params = $params;
		$this->client_ip = $_SERVER['REMOTE_ADDR'];
		$this->get_params = $_GET;
		$this->post_params = $_POST;
		$this->cookies = $_COOKIE;
		$this->headers = $_SERVER;
		$this->is_ajax = (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
		unset($_GET, $_POST, $_REQUEST, $_COOKIE, $_SERVER);
		return true;
	}

	public function header($name)
	{
		$name = 'HTTP_' . strtoupper(str_replace('-', '_', $name));
		return isset($this->headers[$name]) ? $this->headers[$name] : NULL;
	}

	public function cookie($name)
	{
		return isset($this->cookies[$name]) ? $this->cookies[$name] : NULL;
	}

	public function get($name, $default_value = NULL)
	{
		return isset($this->action_params[$name]) ? $this->action_params[$name] : $default_value;
	}
}
