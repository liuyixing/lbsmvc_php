<?php
namespace framework;

class Logger
{
	public static $log_path = '/data/weblogs/business/';
	public static $min_log_level = 1;
	public static $log_file_mode = 0777;
	public static $log_file_maxsize = 209715200;
	public static $log_file_ext = '.log';
	public static $cache_logs = true;
	public static $display_logs = true;
	private static $_messages = array();
	const LEVEL_DEBUG = 1;
	const LEVEL_INFO = 2;
	const LEVEL_WARN = 3;
	const LEVEL_ERROR = 4;
	const LEVEL_PHPERROR = 9;

	public static function init()
	{
		// 加载日志配置文件
		register_shutdown_function(
			function ()
			{
				self::flush();
				// 保证flush是最后一个shutdown执行的函数，从而保证log全部输出到文件
				register_shutdown_function(__CLASS__.'::flush');
			}
		); 
	}
	
	public static function info($message, $category = 'default')
	{
		self::log(self::LEVEL_INFO, $message, $category);
	}

	public static function error($message, $category = 'default')
	{
		self::log(self::LEVEL_ERROR, $message, $category); 
	}

	public static function debug($message, $category = 'default')
	{
		self::log(self::LEVEL_DEBUG, $message, $category);
	}

	public static function warn($message, $category = 'default')
	{
		self::log(self::LEVEL_WARN, $message, $category);
	}
	
	public static function log($level, $message, $category = 'default', $file = NULL, $line = NULL)
	{
		if ($file === NULL && $line === NULL) 
		{
			$stack_traces = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 2); // 5.4.0开始，debug_backtrace增加了limit参数
			if (isset($stack_traces[1]['class']) && $stack_traces[1]['class'] == __CLASS__)
			{
				$file = $stack_traces[1]['file'];
				$line = $stack_traces[1]['line'];
			}
			else
			{
				$file = $stack_traces[0]['file'];
				$line = $stack_traces[0]['line'];
			}
		}

		$file = empty($file) ? 'unknown file' : $file;
		$line = empty($line) ? 'unknown line' : $line;

		self::$_messages[] = array($message, $file, $line, $level, date('Y-m-d H:i:s'), $category);

		if (!self::$cache_logs) {
			self::flush();
		}
	}

	public static function flush()
	{
		if (empty(self::$_messages)) {
			return;
		}	
		$messages = self::$_messages;
		self::$_messages = array();

		static $level_names = array(
			self::LEVEL_DEBUG => 'debug',
			self::LEVEL_INFO => 'info',
			self::LEVEL_WARN => 'warn',
			self::LEVEL_ERROR => 'error',
			self::LEVEL_PHPERROR => 'phpError',
		);

		$logs = array();
		foreach ($messages as &$item)
		{
			// 判断日志记录的等级是否大于等于当前需要记录的日志等级
			if (!isset($item[3]) || $item[3] < self::$min_log_level)
			{
				continue;
			}

			// 获取日志记录的日期，用于将日志记录写到相应的日期目录
			$date = substr($item[4], 0, 10);
			  
			// 生成目标日志文件的全路径名
			$log_file = self::$log_path . DS . str_replace('-', '', $date) . DS . $item[5] . self::$log_file_ext;
			$log_file = realpath($log_file);
			
			if (!isset($logs[$log_file]))
			{
				$logs[$log_file] = '';
			}
			
			// 去掉日志信息中的换行符 
			$item[0] = str_replace(array("\r", "\n"), "\t", $item[0]);
			$item[3] = $level_names[$item[3]];
			$logs[$log_file] .= "{$item[4]}\t{$item[3]}\t{$item[1]}:{$item[2]}\t{$item[0]}\n";
		}
		unset($item);
		
		// 输出日志
		foreach ($logs as $file => $content)
		{
			if (self::$display_logs)
			{
				if (PHP_SAPI == 'cli')
				{
					echo "$file\n$content";
				}
				else
				{
					$content = str_replace("\n", "<br>", $content);
					echo "$file<br>$content";
				}
			}
			else
			{
				self::_writeFile($file, $content);
			}
		}
	}
	
	private static function _writeFile($file, $content)
	{
		// 判断目录是否存在，不存在的话就创建目录
		$dir = dirname($file);
		umask(0);
		if (!file_exists($dir) && !mkdir($dir, self::$log_file_mode, true))
		{
			trigger_error("Cant mkdir $dir");
			return;
		}
		// 判断目录是否可写
		if (!is_writable($dir) && !chmod($dir, self::$log_file_mode))
		{
			trigger_error("$dir is not writable");
			return;
		}
		// 多进程同时写同一个文件，在$content小于8KB的时候，能够保证日志内容不会乱序
		if (false === file_put_contents($file, $content, FILE_APPEND))
		{
			trigger_error("Can not write to $file");
			return;
		}
		// 保证最大日志文件大小
		if (filesize($file) > self::$log_file_maxsize && !rename($file, $file . '.' . date('His')))
		{
			trigger_error("Can not rename $file");
			return;
		}
	}
	
} 
Logger::init();
