<?php
return array(
    'mysql' => array(
        'default' => array(
            'host' => '172.26.41.3',
            'port' => 3306,
            'dbname' => 'db_test',
            'username' => 'root',
            'password' => 'root',
            'charset' => 'utf8',
            'table_aliases' => array()
        )
    ),
    'redis' => array(
        'host' => '127.0.0.1',
        'port' => 6379,
        'database' => 0,
        'timeout' => 0.5,
        'read_write_timeout' => 0.5,
    ),
    'memcached' => array(
        'host' => '172.27.128.4',
        'port' => 11211,
    ),
    'log' => array(
        'min_log_level' => 1,
    ),
    // fallback to common
    '__COMMON__' => require __DIR__. DS . 'common.php',
);  

