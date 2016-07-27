<?php
namespace lbsmvc\action;

use lbsmvc\core\View;

class BaseAction
{
    public static function rspPage($tpl_data, $tpl_name = '')
    {
    	if (empty($tpl_name))
    	{
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
