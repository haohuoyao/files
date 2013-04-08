<?php
 //require "File/Find";
 `echo vb.net demos>all.txt`;
 $i=0;
 foreach(glob("*/*/{module1,form1}.vb",GLOB_BRACE) as $dir){
 $i++;
       `echo -- $i-->>all.txt && cat $dir >> all.txt`;
 }