<?php
namespace core;

class ErrorHandler
{
    public static $conf;

    public static function init()
    {
        // error_reporting display_errors log_errors error_log
        register_shutdown_function(__CLASS__.'::handleFatalError');
    	set_error_handler(__CLASS__.'::handleError');
    	set_exception_handler(__CLASS__.'::handleException');
    }
    
    // 开始执行这个函数的时候，PHP会将error_handler恢复成默认的error_handler，执行完毕才恢复成用户设置的error_handler。通过这种方式来避免死循环 
    public static function handleError($code, $message, $file, $line)
    {
        switch ($code)
        {
            case E_USER_ERROR:
                $msg = "PHP ERROR $message";
                break;
            case E_USER_WARNING:
            case E_WARNING:
                $msg = "PHP WARNING $message";
                break;
            case E_USER_NOTICE:
            case E_NOTICE:
                $msg = "PHP NOTICE $message";
                break;
            default:
                $msg = "PHP Unknown error type: [$code] $message";
                break;
        }
        Logger::log(Logger::LEVEL_PHPERROR, $msg, 'default', $file, $line);
        // 返回false将继续执行PHP内部的错误处理器
    	return true;
    }
    
    public static function handleException($exc)
    {
        Logger::log(Logger::LEVEL_PHPERROR, $exc->getMessage(), 'default', $exc->getFile(), $exc->getLine());
    }

    public static function handleFatalError()
    {   
        $last_error = error_get_last();
        if (NULL !== $last_error)
        {
            $stack_traces = debug_backtrace();
            $msg = "php shutdown, fatal error: " . var_export($last_error, true) . ", stack traces: " . var_export($stack_traces, true);
            Logger::log(Logger::LEVEL_PHPERROR, $msg, 'shutdown_errors', __FILE__, __LINE__);
        }

        // 回调注册的shutdown函数
        if (isset(self::$conf['shutdown_func']) && is_callable(self::$conf['shutdown_func'])) {
            call_user_func(self::$conf['shutdown_func']);
        }
    }
}
ErrorHandler::$conf = ConfigManager::get('eh');
