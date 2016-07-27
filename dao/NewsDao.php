<?php
namespace lbsmvc\dao;

class NewsDao
{
    public static function getNewsList($offset, $limit)
    {
	    $condition = array(
    	    'table' => 'news',
            'limit' => "$offset, $limit",
        );
        return MysqlDao::getAll($condition);
    }
}
