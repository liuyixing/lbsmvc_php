<?php
namespace framework\http;

use framework\Response;
use framework\View;
use framework\ConfigManager;
use framework\Logger;

class HttpResponse extends Response
{
	public function __construct($request)
	{
		parent::__construct($request);
	}	

	public function page($tpl_data, $tpl_name = '')
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

	public function json($code = 0, $msg = '', $data = array())
	{
		$json_str = json_encode(array('code' => $code, 'msg' => $msg, 'data' => $data));
		$this->setContent($json_str);
		return true;
	}

	public function error($code)
	{
		$this->code = $code;
	}

	public function header($name, $value)
	{
		header("$name: $value");
	}

	public function cookie($name, $value, $expire = 3600, $path = '', $domain = '', $secure = false, $http_only = false)
	{	
		if (empty($path))
		{
			$path = ConfigManager::get('domain');
		}
		if (empty($domain))
		{
			$domain = ConfigManager::get('domain');
		}
		setcookie($name, $value, $expire, $path, $domain, $secure, $http_only);
	}

	public function send()
	{
		if (!$this->is_sent)
		{
			return;
		}

		if ($this->code === 0)
		{
			echo $this->content;
		}
		else
		{
			echo $this->code;
		}

		$this->is_sent = true;
	}

}
