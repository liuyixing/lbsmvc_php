<?php
namespace lbsmvc\core;

class RspManager
{
	private static $is_sent = false;

	public static function pack($ret = '')
	{
		if (self::$is_sent)
		{
			return;
		}

		$code = is_int($ret) ? $ret : $ret[0];
		switch ($code)
		{
			case CODE_OUTPUT_HTML:
				return self::packHtml($ret[1]);
			case CODE_OUPUT_JSON:
				return self::packJson($ret[1]);
			default:
				return self::packError($code);
		}
	}

	public static function packHtml($content)
	{
		header("Content-Type:text/html;charset=UTF-8");
		return $content;
	}

	public static function packJson($content)
	{
		header('Content-type:application/json;charset=UTF-8');
		return json_encode($content);
	}

	public static function packError($code)
	{
	}
}
