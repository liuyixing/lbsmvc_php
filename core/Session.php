<?php
namespace lbsmvc\core;

class Session
{
	public static $user;

	public static function init()
	{

	}

	public static function isLogin()
	{
		return self::$user !== NULL;
	}
}