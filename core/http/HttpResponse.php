<?php
namespace lbsmvc\core\http;

use lbsmvc\core\Response;
use lbsmvc\core\View;
use lbsmvc\core\Logger;

class HttpResponse extends Response
{
	public function __construct($request)
	{
		parent::__construct($request);
	}	

	public function display($tpl_data, $tpl_name = '')
	{
		if (empty($tpl_name))
		{
			$tpl_name = $this->request->route;
		}

		$content = View::render($tpl_name, $tpl_data);
		if (false === $content)
		{
			Logger::error("render page failed, args: ".json_encode(func_get_args()));
			return false;
		}

		$this->setContent($content);
		return true;
	}

	public function json($code, $msg, $data)
	{
		$json = json_encode(array('code' => $code, 'msg' => $msg, 'data' => $data));
		$this->setContent($json);
		return true;
	}

	public function header($name, $value)
	{
		header("$name: $value");
	}

	public function cookie($name, $value, $expire = 0, $path = '', $domain = '', $secure = false, $http_only = false)
	{	
		setcookie($name, $value, $expire, $path, $domain, $secure, $http_only);
	}
}
