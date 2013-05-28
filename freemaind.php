<?php

echo "<map version=\"1.0.0\"><node text=\"demo\">\n";
foreach(glob("*.pdf") as $f){
$f=iconv("gbk","utf-8",$f);
$f=htmlspecialchars($f);

  echo  "<node text=\"$f\" />\n";
}

echo "</node></map>\n";