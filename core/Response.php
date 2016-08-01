<?php
namespace lbsmvc\core;

abstract class Response
{
	public $is_sent;
	public $content;
	public $request;
	public $error;

	public function __construct()
	{
		$this->is_sent = false;
		$this->content = '';
	}

	public function setContent($content)
	{
		$this->content = $content;
	}

	public function setError($error)
	{
		$this->error = $error;
	}
}