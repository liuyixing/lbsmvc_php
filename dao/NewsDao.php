<?php
class NewsDao extends DB
{
	private static $news = array(
		array('id' => 1, 'title' => '标题一', 'content' => '内容一'),
		array('id' => 1, 'title' => '标题一', 'content' => '内容一'),
		array('id' => 1, 'title' => '标题一', 'content' => '内容一'),
		array('id' => 1, 'title' => '标题一', 'content' => '内容一'),
		array('id' => 1, 'title' => '标题一', 'content' => '内容一'),
	);

    public static function getNewsList($offset, $limit)
    {
    	return selef::$news;
	    $condition = array(
    	    'table' => 'news',
            'limit' => "$offset, $limit",
        );
        return self::getAll($condition);
    }
}
