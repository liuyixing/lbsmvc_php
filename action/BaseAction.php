<?php
namespace lbsmvc\action;

use lbsmvc\core\View;
use lbsmvc\core\ReqManager;

class BaseAction
{
    public static function display($tpl_data, $tpl_name = '')
    {
    	if (empty($tpl_name))
    	{
            $tpl_name = ReqManager::$route;
    	}
        return View::render($tpl_name, $tpl_data);	
    }
    
    public static function rspJson($code, $msg = '', $data = array())
    {
        return json_encode(array(  
            'code' => $code,
            'msg' => $msg,
            'data' => $data
        ));
    }
}
