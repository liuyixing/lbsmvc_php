<?php
namespace core;

abstract class Session
{
	public $user;

	public function isLogin()
	{
		return NULL !== $this->user;
	}
}
