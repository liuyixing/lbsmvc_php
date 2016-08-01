<?php
namespace lbsmvc\core\http;

use lbsmvc\core\Response;

class HttpResponse extends Response
{
	public function display($tpl_data, $tpl_name = '')
	{
		if (empty($tpl_name))
		{
			$tpl_name = $this->request->route;
		}
		$this->setContent(View::render($tpl_name, $tpl_data));
		return true;
	}
}