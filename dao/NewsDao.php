<?php
namespace dao;

use core\MysqlDao;

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
