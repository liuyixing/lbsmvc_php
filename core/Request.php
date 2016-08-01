<?php
namespace LBS;

abstract class Request
{
	public $route;
	public $action_class;
	public $action_method;
	public $action_params;
	public $client_ip;
}