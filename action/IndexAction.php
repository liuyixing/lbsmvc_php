<?php
namespace lbsmvc\action;

use lbsmvc\service\NewsService;

class IndexAction extends BaseAction
{
    public static function index($req)
    {
    	$page = empty($req[]) ? 1 : (int)$req->$params['p'];
    	$size = 10;
        $data = array(
            'news' => $news_list = NewsService::getNewsList($page, $size)
        );
    	return self::Html($data, 'index_index');
    }
}