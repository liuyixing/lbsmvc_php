<?php
require '../../core/init.php';
require '../../lib/http/HttpLib.php';

function writeCb($ch, $data)
{
	echo 111;
	echo $data;
	return strlen($data);
}

$opts = array(
	CURLOPT_WRITEFUNCTION => 'writeCb'
);

$ret = HttpLib::get('http://172.26.41.7/index.php?r=index_index', 3, $opts);

echo $ret;
