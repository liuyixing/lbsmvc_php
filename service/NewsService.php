<?php
namespace service;

use lbs\NewsDao;

class NewsService
{
    public static function getNewsList($page, $size)
    {	
        $offset = max($page - 1, 0) * $size;
        return NewsDao::getNewsList($offset, $size); 
    }
}
