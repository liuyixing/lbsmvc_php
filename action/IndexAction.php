<?php
class IndexAction
{
	public static function index($req, $rsp)
    {
    	$page = $req->get('p', 1);
    	$size = 10;
        $data = array(
            'news' => NewsService::getNewsList($page, $size)
        );
    	return $rsp->page($data);  
    }

    public static function ajaxNews($req, $rsp)
    {
    	$page = empty($req->params['p']);
    	$ua = $req->header('user-agent');
    	$uid = $req->cookie('uid');
    	$size = 10;
        $data = array(
            'news' => NewsService::getNewsList($page, $size)
        );
    	return $rsp->json(0, '', $data);
    }
}


