<?php
namespace service;

use dao\NewsDao;

class NewsService
{
    public static function getNewsList($page, $size)
    {	
        $offset = max($page - 1, 0) * $size;
        return NewsDao::getNewsList($offset, $size); 
    }
}
