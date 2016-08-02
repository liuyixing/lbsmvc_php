<?php
namespace action;

use service\NewsService;

class IndexAction
{
    public static function index($req, $rsp)
    {
    	$page = empty($req->params['p']) ? 1 : (int)$req->params['p'];
    	$size = 10;
        $data = array(
            'news' => NewsService::getNewsList($page, $size)
        );
    	return $rsp->display($data);
    }
}
