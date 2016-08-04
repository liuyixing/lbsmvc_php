<?php
namespace framework;

class ConfigManager
{
    public static $conf = array();
    private static $cache = array(); // 缓存已经获取过的配置，加快速度
    
    public static function init()
    {
    	$server_type = get_cfg_var('server_type');
    	$conf_file = CONF_PATH . $server_type . '.php'; 

        // 加载失败肯定是要跪的，因为继续执行没有意义
    	self::$conf = require $conf_file;
    }
    
    public static function get($key)
    {
    	if (!is_string($key) || trim($key) == false)
    	{
    	    return NULL;
    	}

    	if (isset(self::$cache[$key]))
    	{
    	    return self::$cache[$key];
    	}
    	
    	$parts = explode('.', $key);

    	$env_value = self::$conf;
        $com_value = isset(self::$conf['__COMMON__']) ? self::$conf['__COMMON__'] : array();
    	foreach ($parts as $part)
    	{
            // 特定环境配置
            $env_value = isset($env_value[$part]) ? $env_value[$part] : NULL;

            // 通用配置
            $com_value = isset($com_value[$part]) ? $com_value[$part] : NULL;

            if ($env_value === NULL && $com_value === NULL)
            {
                break;
            }
    	}

    	$value = is_null($env_value) ? $com_value : $env_value;
        self::$cache[$key] = $value;
    	return $value;
    }

    public static function set($key, $value)
    {
    	if (!is_string($key) ||	trim($key) == false)
        {
    	    return false; 
    	} 
		
		$parts = explode('.', $key);
		$count = count($parts);
		
		$conf = &self::$conf;
		for ($i = 0; $i < $count; ++$i)
		{
			if (!isset($conf[$parts[$i]]))
			{	
				$conf[$parts[$i]] = array();
				$conf = &$conf[$parts[$i]];	
				continue;
			}	
			if (is_array($conf[$parts[$i]] || ($i + 1) == $count))
			{
				$conf = &$conf[$parts[$i]];
				continue;
			}
			return false;
		}
		$conf = $value;
		unset($conf);
	
		self::$cache[$key] = $value;
    	return true;
    }

    public static function has($key)
    {
        return self::get($key) !== NULL;
    }
}
