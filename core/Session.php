<?php
namespace LBS;
abstract class Session
{
	public $user;

	public function isLogin()
	{
		return NULL !== $this->user;
	}
}