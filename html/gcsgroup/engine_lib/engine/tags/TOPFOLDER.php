<?
if (!$doc_id) $doc_id=$doc->id;
//added by meremin
if (!$field) $field='id';	
//end addition
$where ="id=".$doc_id;
while (	$f[pid]!=-1 and !(mysql_error())){
                //original
                //$sql="select id,pid from engine_documents where $where";
		//added by meremin
		$sql="select id,pid, caption_short, caption_medium, caption_long, resume  from engine_documents where $where";
		//end addition
		$f=@mysql_fetch_array($r=@mysql_query($sql));
		$resid=$f[id];
		//added by meremin
		$res=$f[$field];
		//end addition
		$where ="id=$f[pid]";
	}
if (!mysql_error())
        //original
        //echo $resid;
	//added by meremin
	echo $res;
	//end addition
else 
	echo "-1";
?>