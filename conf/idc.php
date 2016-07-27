<?php
return array(
    'mysql' => array(
        'host' => '172.26.40.50',
        'port' => 6306,
        'dbname' => 'test',
        'username' => 'boketest',
        'password' => 'boke45731',
        'charset' => 'utf8',
        'table_aliases' => array()
    ),
    'redis' => array(
        'host' => '127.0.0.1',
        'port' => 6393,
        'database' => 0,
        'timeout' => 0.5,
        'read_write_timeout' => 0.5,
    ),
    'memcached' => array(
        'host' => '172.27.128.4',
        'port' => 11211,
    ),
    'log' => array(
        'log_path' => '/data/weblogs/business/',
        'min_log_level' => 1,
        'log_file_mode' => 0777,
        'log_file_maxsize' => 209715200,
    ),
    // fallback to common
    '__COMMON__' => require __DIR__. DS . 'common.php',
);  

