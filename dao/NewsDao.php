<?php
class NewsDao extends MysqlDao
{
    public static function getNewsList($offset, $limit)
    {
	    $condition = array(
    	    'table' => 'news',
            'limit' => "$offset, $limit",
        );
        return self::getAll($condition);
    }
}