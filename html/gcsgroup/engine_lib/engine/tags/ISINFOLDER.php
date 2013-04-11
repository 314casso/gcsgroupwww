<?
$belongs=0;
if  (!$doc_id)
	$doc_id=$doc->id;
	
$where ="id=".$doc_id;
if ($fldr_id){
	while (
			$f[pid]!=-1 and !(mysql_error())
				and (
					@mysql_num_rows($r)
					or
					($where =="id=".$doc_id)
					)
					){
		$sql="select pid from engine_documents where $where";
		$f=mysql_fetch_array($r=mysql_query($sql));
		$where ="id=$f[pid]";
		if ($f[pid]==$fldr_id && $fldr_id) 
			$belongs=1;
		}
	}
if ($fldr_id==$doc->id){
	$belongs=1;
	}


echo $belongs;


?>