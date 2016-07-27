<?php
namespace lbsmvc\core;

class ErrorHandler
{
    public static $shutdown_func;

    public static function init()
    {
    	//error_reporting
    	//display_errors
    	//log_errors error_log
        register_shutdown_function(__CLASS__.'::handleFatalError');
    	set_error_handler(__CLASS__.'::handleError');
    	set_exception_handler(__CLASS__.'::handleException');
    }
    
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
        Logger::log(Logger::LEVEL_PHPERROR, $msg, $file, $line);
        // 返回false将继续执行PHP内部的错误处理器
    	return false;
    }
    
    public static function handleException($exc)
    {
        Logger::log(Logger::LEVEL_PHPERROR, $exc->getMessage(), $exc->getFile(), $exc->getLine());
    }

    public static function handleFatalError()
    {   
        $last_error = error_get_last();
        $stack_traces = debug_backtrace();
        $msg = "PHP shutdown, fatal error: " . print_r($last_error) . ", stack traces: " . print_r($stack_traces);
        Logger::log(Logger::LEVEL_PHPERROR, $msg, __FILE__, __LINE__);

        // 回调注册的shutdown函数
        if (self::$shutdown_func !== NULL) {
            self::$shutdown_func();
        }

    }
}
