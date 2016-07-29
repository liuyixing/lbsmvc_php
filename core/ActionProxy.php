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

        if (!class_exists($req_class::$action_class))
        {
            return $rsp_class::send(CODE_CLASS_NOT_EXISTS);
        }

        if (!method_exists($req_class::$action_class, $req_class::$action_method))
        {
            return $rsp_class::send(CODE_METHOD_NOT_EXISTS);
        }

        // call preActions
        foreach ($pre_actions as $act)
        {
            $ret = call_user_func($act, $req_class::$params);
            if (false == $ret)
            {
                $rsp_class::send();
            }
        }

        $ret = call_user_func_array($action, array($target['params']));

        // call postActions
        foreach ($post_actions as $act)
        {
            $ret = call_user_func($act);
        }

        return $ret;
    }
}
