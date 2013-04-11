<?
include "engine/config.inc";
include("$engine_root/engine/config.inc");
include_once "$engine_root/engine/document.inc";
include_once "$engine_root/engine/functions.php";

$sql="select * from engine_documents";
$r=mysql_query($sql);
while($f=mysql_fetch_array($r)){
	$msrch=1;
	echo "<A href=".geturl($f[id])."></a>\n";
	}
?>
