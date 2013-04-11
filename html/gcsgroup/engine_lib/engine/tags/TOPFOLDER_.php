<?
if  (!$doc_id)
	$doc_id=$doc->id;
	
$where ="id=".$doc_id;
while (	$f[pid]!=-1 and !(mysql_error())){
		$sql="select id,pid from engine_documents where $where";
		$f=@mysql_fetch_array($r=@mysql_query($sql));
		$resid=$f[id];
		$where ="id=$f[pid]";
	}
if (!mysql_error())
	echo $resid;
else 
	echo "-1";


?>