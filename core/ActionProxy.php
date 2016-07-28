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

    public static function run($target)
    {
        // call preActions
        foreach ($pre_actions as $act)
        {
            $ret = call_user_func($act);
        }

        if (!class_exists($target['class']))
        {
            return false;
        }

        if (!method_exists($target['class'], $target['method']))
        {
            return false;
        }
        
        $action = $target['class'].'::'.$target['method'];
        $ret = call_user_func_array($action, array($target['params']));

        // call postActions
        foreach ($post_actions as $act)
        {
            $ret = call_user_func($act);
        }

        return $ret;
    }
}
