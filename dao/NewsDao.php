<?php
class NewsDao extends DB
{
	public static $db = 'test';
	public static $table = 'news';

	private static $news = array(
		array('id' => 1, 'title' => '标题一', 'content' => '内容一', 'created_at' => '2016-08-04 11:11:11'),
		array('id' => 1, 'title' => '标题一', 'content' => '内容一', 'created_at' => '2016-08-04 11:11:11'),
		array('id' => 1, 'title' => '标题一', 'content' => '内容一', 'created_at' => '2016-08-04 11:11:11'),
		array('id' => 1, 'title' => '标题一', 'content' => '内容一', 'created_at' => '2016-08-04 11:11:11'),
		array('id' => 1, 'title' => '标题一', 'content' => '内容一', 'created_at' => '2016-08-04 11:11:11'),
	);

    public static function getNewsList($offset, $limit)
    {
    	return self::$news;
	    $condition = array(
    	    'table' => 'news',
            'limit' => "$offset, $limit",
        );
        return self::getAll($condition);
    }
}