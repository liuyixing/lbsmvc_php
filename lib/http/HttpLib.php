<?php
class HttpLib
{
	static function get($url, $timeout = 5, $options = array())
	{
		$options[CURLOPT_HTTPGET] = true;
		return self::request($url, $timeout, $options);
	}

	static function post($url, $params, $timeout = 5, $options = array())
	{	
		$options[CURLOPT_POST] = true;
		$options[CURLOPT_POSTFIELDS] = http_build_query($params, '', '&');
		return self::request($url, $timeout, $options);
	}

	static function request($url, $timeout = 5, $options = array())
	{
		$ch = curl_init();
		if (false === $ch)
		{
			Log::error('curl init failed, args: ' . json_encode(func_get_args()) . ', error: ' . curl_error($ch));
			return false;
		}
		$options[CURLOPT_URL] = $url;
		$options[CURLOPT_RETURNTRANSFER] = true;
		$options[CURLOPT_CONNECTTIMEOUT] = $timeout;
		$options[CURLOPT_TIMEOUT] = $timeout;
		$ret = curl_setopt_array($ch, $options);
		if (false === $ret)
		{
			Log::error('curl set options failed, args: ' . json_encode(func_get_args()). ', error: ' . curl_error($ch));
			return false;
		}
		$ret = curl_exec($ch);
		if (false === $ret)
		{
			Log::error('curl exec failed, args: ' . json_encode(func_get_args()). ', error: ' . curl_error($ch));
			return false;
		}
		curl_close($ch);
		return $ret;
	}

}
