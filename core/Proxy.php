<?php
namespace lbsmvc\core;

class Proxy
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

    public static function route($request, $response)
    {
		$action_class = "\\lbsmvc\\action\\".ucfirst($request->action_class)."Action";
		$action_method = $request->action_method;

        if (!class_exists($action_class))
        {
            $response->setError(ERR_ACTION_CLASS_NOT_EXISTS);
            return false;
        }

        if (!method_exists($action_class, $action_method))
        {
            $response->setError(ERR_ACTION_METHOD_NOT_EXISTS);
            return false;
        }

        // call preActions
        foreach (self::$pre_actions as $act)
        {
            $ret = call_user_func_array($act, array($request, $response));
            if (false === $ret)
            {
                return false;
            }
        }

        $ret = call_user_func_array(array($action_class, $action_method), array($request, $response));

        // call postActions
        foreach (self::$post_actions as $act)
        {
            $ret = call_user_func_array($act, array($request, $response));
            if (false === $ret)
            {
                return false;
            }
        }

        return $ret;
    }
}
