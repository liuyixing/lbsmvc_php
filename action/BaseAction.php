<?php
namespace lbsmvc\action;

use lbsmvc\core\View;
use lbsmvc\core\ConfigManager;

class BaseAction
{
    public static function Html($tpl_data, $tpl_name = '')
    {
    	if (empty($tpl_name))
    	{
            $tpl_name = ReqManager::$route;
    	}
        return array(CODE_HTML, View::render($tpl_name, $tpl_data));	
    }

    public static function GoHome()
    {
        return self::jumpTo(ConfigManager::get('index_url'));
    }

    public static function GoBack()
    {
        return CODE_GO_BACK;
    }

    public static function JumpTo($url)
    {
        return array(CODE_JUMP_TO, $url);
    }

    public static function Json($code, $msg = '', $data = array())
    {
        return array(CODE_JSON, json_encode(array(  
            'code' => $code,
            'msg' => $msg,
            'data' => $data
        )));
    }
}
