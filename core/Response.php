<?php
namespace lbs;

abstract class Response
{
	public $is_sent;
	public $content;
	public $request;
	public $error;

	public function __construct($request)
	{
		$this->is_sent = false;
		$this->content = '';
		$this->request = $request;
	}

	public function setContent($content)
	{
		$this->content = $content;
	}

	public function setError($error)
	{
		$this->error = $error;
	}

	public function getContent()
	{
		return $this->content;
	}
}
