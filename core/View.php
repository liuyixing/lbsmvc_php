<?php
namespace LBS;
class View
{
    public static $tpl_ext = '.tpl';
    
    public static function render($__tpl_name, $__tpl_data)
    {
    	if (empty($__tpl_name))
    	{
            Logger::error("__tpl_name cant be empty");
    	    return false;
    	}
        
    	$__tpl_file = TPL_PATH . str_replace('.', DS, $__tpl_name) . self::$tpl_ext;

        if (!is_readable($__tpl_file))
        {
            Logger::error("$__tpl_file is not readable");
            return false;
        }
    	
    	ob_start();
    	ob_implicit_flush(false);
    	extract($__tpl_data, EXTR_OVERWRITE);
    	require $__tpl_file;
    	return ob_get_clean();
    }
}
