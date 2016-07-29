<?php
namespace lbsmvc\core;

class RspManager
{
	private static $is_sent = false;

	public static function send($ret = '')
	{
		if (self::$is_sent)
		{
			return;
		}

		$code = is_int($ret) ? $ret : $ret[0];
			
		switch ($code)
		{
			case (CODE_OUTPUT_HTML):
			//@TODO: 输出相关的响应头信息
				echo $ret[1];
				break;
			case (CODE_OUPUT_JSON):
				echo $ret[1];
				break;
		}
		self::$is_sent = true;
	}

}
