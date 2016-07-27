<?php
namespace lbsmvc\core;

class View
{
    public static $tpl_ext = '.tpl';
    
    public static function render($__tpl_name, $__tpl_data)
    {
    	if (empty($__tpl_name))
    	{
    	    return '';
    	}
        
    	$__tpl_file = TPL_PATH . str_replace('.', DS, $__tpl_name) . self::$tpl_ext;
    	
    	ob_start();
    	ob_implicit_flush(false);
    	extract($__tpl_data, EXTR_OVERWRITE);
    	require $__tpl_file;
    	return ob_get_clean();
    }
}
