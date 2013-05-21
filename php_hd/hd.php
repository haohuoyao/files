<?php

$u="http://www.fuwugu.com/post/132";

if(count($argv)>1){
$u = array_pop($argv);
	if(strpos($u,"http")===false){
		$u="http://".$u;
	}
}
echo "\n";

print_r(get_headers($u));
echo "from ".$u."\n";
