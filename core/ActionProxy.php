<?php
namespace lbsmvc\core;

class ActionProxy
{
    public static $pre_actions = array();
    public static $post_actions = array();

    public static function registerPreAction($func)
    {
        self::$pre_actions[] = $func;
    }

    public static function registerPostAction($func)
    {
        self::$post_actions[] = $func;
    }

    public static function handle($req_class, $rsp_class)
    {
        $ret = $req_class::init();

        if (false == $ret)
        {
            return $rsp_class::send($ret); 
        }
		
		$action_class = "\\lbsmvc\\action\\".ucfirst($req_class::$class)."Action";
		$action_method = $req_class::$method;
		$action_params = $req_class::$params;

        if (!class_exists($action_class))
        {
            return $rsp_class::send(CODE_ACTION_CLASS_NOT_EXISTS);
        }

        if (!method_exists($action_class, $action_method))
        {
            return $rsp_class::send(CODE_ACTION_METHOD_NOT_EXISTS);
        }

        // call preActions
        foreach (self::$pre_actions as $act)
        {
            $ret = call_user_func($act, $req_class::$params);
            if (false == $ret)
            {
                $rsp_class::send();
            }
        }

        $ret =  call_user_func_array(array($action_class, $action_method), array($action_params));

        // call postActions
        foreach (self::$post_actions as $act)
        {
            $ret = call_user_func($act);
        }

        return $rsp_class::send($ret);
    }
}
