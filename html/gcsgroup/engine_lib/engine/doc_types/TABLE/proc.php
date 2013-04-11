<?
	   	/*	echo "<pre>";
   		print_r($_POST);	   
   		echo "</pre>";*/
	$sql="select * from  engine_TABLE where doc_id=$id";
	$r=mysql_query($sql) or die("SQL error ".mysql_error()." in: $sql\n"); 
	
	if (mysql_num_rows($r)==0) {
		$sql="insert into  engine_TABLE(tblname,format,begin,end,doc_id) values('$tblname','$format','$begin','$end',$id)";
		mysql_query($sql) or die("SQL error ".mysql_error()." in: $sql\n"); 
		}
	else {
		$sql="update engine_TABLE set tblname='$tblname',format='$format',begin='$begin',end='$end' where doc_id=$id";
		mysql_query($sql) or die("SQL error ".mysql_error()." in: $sql\n"); 
		}

if ($tblname == $_POST[table_old]){
	//учли случай переключения между базами данных
	$r=mysql_query("delete from $tblname") or die (mysql_error());
	for ($i=1;$i<=$cnt;$i++){
		$sql="insert into $tblname values(";
		for($j=1;$j<=$len;$j++){
			$sql.="'".str_replace("'","\\'",${"fld".$i."_".$j})."'";
			if ($j<=$len-1)$sql.=",";
			}
		$sql.=")";
		//echo $sql." $cnt $len" ;exit;
		if (!${"del".$i."_".$j})
			$r=mysql_query("$sql") or die (mysql_error());
		}
	$nf=0;
	$sql="insert into $tblname values(";
	for($j=1;$j<=$len;$j++){
		$sql.="'".str_replace("'","\\'",${"fld".$j."_n"})."'";
		if ($j<=$len-1)$sql.=",";
		if (${"fld".$j."_n"})$nf=1;
		}
	$sql.=")";

	if ($nf)
		$r=mysql_query("$sql") or die (mysql_error());
}

?>
