<?
include 'config.inc';
/*$f=fopen('data.csv','r');
$str=fread($f,filesize($f));*/
$str="<table>\n";
$f=file('data.csv');
foreach($f as $l){
	$str.="<tr><td>".str_replace(";","</td><td>",substr($l,0,strlen($l)-1))."</td></tr>\n";
}
$str.="</table>\n";
$DBResult = mysql_query("update engine_TEXTDOC 
set html='$str'
where doc_id=$id") or die (mysql_error());
@unlink('data.csv');
echo "<script>window.close()</script>";
?>

