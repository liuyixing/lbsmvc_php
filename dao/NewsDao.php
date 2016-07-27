<?php
namespace lbsmvc\dao;

use lbsmvc\core\MysqlDao;

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
