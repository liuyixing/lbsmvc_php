<?php
namespace framework;

abstract class Response
{
	public $is_sent;
	public $content;
	public $request;
	public $code;
	

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

	public function getContent()
	{
		return $this->content;
	}
}
