<?php
namespace LBS;

class ClassLoader
{   
    // 框架根据类的名称查找源文件进行加载，大小写敏感，此处可以设置别名映射
    public static $class_aliases = array( 
    );
    private static $file_ext = '.php';

    public static function init()
    {
	   spl_autoload_register(__CLASS__.'::loadClass', true, true);
    }

    public static function setAlias($class, $alias)
    {
        self::$class_aliases[$class] = $clias;
    }

    public static function loadClass($class_name)
    {
		if (isset(self::$class_aliases[$class_name]))
        {
            $class_name = self::$class_aliases[$class_name];
        }

        if (strpos($class_name, FRAMEWORK_NAME) === 0)
        {
            $file_path = CORE_PATH . str_replace(NS, DS, substr($class_name, strlen(FRAMEWORK_NAME) + 1)) . self::$file_ext;
        }
        elseif (substr_compare($class_name, 'Action', -strlen('Action')) === 0)
        {
            $file_path = ACTION_PATH . $class_name . self::$file_ext;
        }
        elseif (substr_compare($class_name, 'Service', -strlen('Service')) === 0)
        {
            $file_path = SERVICE_PATH . $class_name . self::$file_ext;
        }
        elseif (substr_compare($class_name, 'Dao', -strlen('Dao')) === 0)
    	{
            $file_path = DAO_PATH . $class_name . self::$file_ext;
        }

        // 文件存在而且可读
        if (is_readable($file_path)) {
            include $file_path;
        }
	} 
}
ClassLoader::init();
