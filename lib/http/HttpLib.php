<?php
class HttpLib
{
	static function get($url, $timeout = 5, $options = array())
	{
		$options[CURLOPT_HTTPGET] = true;
		return self::request($url, $params, $timeout, $options);
	}

	static function post($url, $params, $timeout = 5, $options = array())
	{	
		$options[CURLOPT_POST] = true;
		$options[CURLOPT_POSTFIELDS] = http_build_query($params, '', '&');
		return self::request($url, $params, $timeout, $options);
	}

	static function request($url, $params, $timeout = 5, $options = array())
	{
		$ch = curl_init();
		if (false === $ch)
		{
			Log::error('curl init failed, args: ' . json_encode(func_get_args()) . ', error: ' . curl_error($ch));
			return false;
		}
		$opts = array(
			CURLOPT_URL => $url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_CONNECTTIMEOUT => $timeout,
			CURLOPT_TIMEOUT => $timeout,
		);
		$opts = array_merge($options, $opts);
		$ret = curl_setopt_array($ch, $opts);
		if (false === $ret)
		{
			Log::error('curl set options failed, args: ' . json_encode(func_get_args()). ', error: ' . curl_error($ch));
			return false;
		}
		$ret = curl_exec($ch);
		if (false === $ret)
		{
			Log::erro('curl exec failed, args: ' . json_encode(func_get_args()). ', error: ' . curl_error($ch));
			return false;
		}
		curl_close($ch);
		return $ret;
	}
}