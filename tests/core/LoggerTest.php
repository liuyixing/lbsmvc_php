<?php
require "../../core/init.php";

use lbsmvc\core\Logger;

Logger::info("111");
function f1()
{
    Logger::log(Logger::LEVEL_INFO, "222", "default");
}
f1();
