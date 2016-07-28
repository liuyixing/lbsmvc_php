<?php
namespace lbsmvc\action;

use lbsmvc\service\NewsService;

class IndexAction extends BaseAction
{
    public static function index($params)
    {
    	$page = empty($params['p']) ? 1 : (int)$params['p'];
    	$size = 10;
        $data = array(
            'news' => $news_list = NewsService::getNewsList($page, $size)
        );
    	return self::display($data, 'index_index');
    }
}

