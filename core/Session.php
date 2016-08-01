<?php
namespace lbsmvc\core;

abstract class Session
{
	public $user;

	public function isLogin()
	{
		return NULL !== $this->user;
	}
}