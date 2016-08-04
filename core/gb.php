<?php
//------------------ 别名 ------------------------
use framework\MysqlDao as DB;
use framework\ConfigManager as Conf;
use framework\Logger as Log;

//------------------ 常量 ------------------------
define("ERR_ACTION_CLASS_NOT_EXISTS", 4000);
define("ERR_ACTION_METHOD_NOT_EXISTS", 4001);
define("ERR_REQUEST_PARSE_FAILED", 4003);


//------------------ 函数 ------------------------