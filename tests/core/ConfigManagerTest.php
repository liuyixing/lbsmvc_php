<?php
require "../../core/init.php";

use lbsmvc\core\ConfigManager as CM;

var_dump(CM::set('a', 111));
var_dump(CM::set('a.b', 222));
var_dump(CM::set('a.b.c', 333));
var_dump(CM::set('d.e', array(123, 234)));

var_dump(CM::get("a"));
var_dump(CM::get("a.b"));
var_dump(CM::get("a.c.c"));
var_dump(CM::get("d.e"));


var_dump(CM::$conf);
