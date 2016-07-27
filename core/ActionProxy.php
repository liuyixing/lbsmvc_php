<?php
namespace lbsmvc\core;

class ActionProxy
{
    public static function route($pack_func, $unpack_func)
    {
        // 请求解包
        $req = $pack_func();

        if (false === $req)
        {

        }

        // preAction
        // 1.入口参数校验
        
        $ret = call_user_func_array($req['action'], array($req['params']));

        // postAction
        
        return $ret;
    }
}
