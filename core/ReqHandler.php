<?php
namespace framework;

class ReqHandler
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

    public static function handle($req, $rsp)
    {
		$ret = $req->parseRequest();
		if (false === $ret)
        {
            $rsp->error(ERR_REQUEST_PARSE_FAILED);
            return false;
        }

        $action_class = $req->action_class;
        $action_method = $req->action_method;
        $action_params = $req->action_params;

        if (!class_exists($action_class))
        {
            $rsp->error(ERR_ACTION_CLASS_NOT_EXISTS);
            return false;
        }

        if (!method_exists($action_class, $action_method))
        {
            $rsp->error(ERR_ACTION_METHOD_NOT_EXISTS);
            return false;
        }

        // call preActions
        foreach (self::$pre_actions as $act)
        {
            $ret = call_user_func_array($act, array($req, $rsp));
            if (false === $ret)
            {
                return false;
            }
        }

        $ret = call_user_func_array(array($action_class, $action_method), array($req, $rsp));

        // call postActions
        foreach (self::$post_actions as $act)
        {
            $ret = call_user_func_array($act, array($req, $rsp));
            if (false === $ret)
            {
                return false;
            }
        }

        return $ret;
    }
}
