<?php
namespace framework;

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

        if (strpos($class_name, 'framework') === 0) // 框架类
        {
            $class_name = substr($class_name, strlen('framework\\'));
            $file_path = CORE_PATH . str_replace(NS, DS, $class_name) . self::$file_ext;
        }
        elseif (substr_compare($class_name, 'Action', -strlen('Action')) === 0) // action类
        {
            $file_path = ACTION_PATH . $class_name . self::$file_ext;
        }
        elseif (substr_compare($class_name, 'Service', -strlen('Service')) === 0) // service类
        {
            $file_path = SERVICE_PATH . $class_name . self::$file_ext;
        }
        elseif (substr_compare($class_name, 'Dao', -strlen('Dao')) === 0) // dao类
        {
            $file_path = DAO_PATH . $class_name . self::$file_ext;
        }
        elseif (substr_compare($class_name, 'Lib', -strlen('Lib')) === 0) // lib类
        {
            $file_path = LIB_PATH . strtolower(substr($class_name, 0, -strlen('Lib'))) . DS . $class_name . self::$file_ext;
        }
        else
        {
            return;
        }

        // 文件存在而且可读
        if (is_readable($file_path)) {
            include $file_path;
        }
	} 
}
ClassLoader::init();
