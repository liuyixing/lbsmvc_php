<?php
class IndexAction
{
    public static function index($request, $response)
    {
    	$page = empty($request->params['p']) ? 1 : (int)$request->params['p'];
    	$size = 10;
        $data = array(
            'news' => NewsService::getNewsList($page, $size)
        );
    	return $response->display($data);
    }
}
