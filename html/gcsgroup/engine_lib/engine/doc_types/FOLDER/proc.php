<?
		$notinpath?$notinpath=1:$notinpath=0;


		$format=trim($format);
		if (!$format)
			$format='format=\\\''.$dflt_menu_format.'\\\'';//"format=\'<li><a href=ITEM_LINK>ITEM_TEXT</a></li>\'";
		else
			$format='format=\\\''.$format.'\\\'';
		$format=str_replace('\\"','"',$format);

		$sql="select * from  engine_FOLDER where doc_id=$id";
		$r=mysql_query($sql) or die("SQL error ".mysql_error()." in: $sql\n");
		if (mysql_num_rows($r)==0) {
			$sql="insert into  engine_FOLDER(notinpath,doctoshow,format,doc_id) values('$notinpath','$doctoshow','$format',$id)";
			mysql_query($sql) or die("SQL error ".mysql_error()." in: $sql\n");
			}
		else {
			$sql="update engine_FOLDER set
				doctoshow='$doctoshow',
				notinpath='$notinpath',
				format='$format'
				 where doc_id=$id";
			mysql_query($sql) or die("SQL error ".mysql_error()." in: $sql\n");
			}
		$sql="select * from engine_documents where pid=$id order by name";
		$dor_r= mysql_query($sql) or die (mysql_error()." in $sql");
		$dor="";
		while ($dor_f = mysql_fetch_array($dor_r)) {
			if (!${"ord".$dor_f[id]}) ${"ord".$dor_f[id]}=0;
			mysql_query("update engine_documents set ord=".${"ord".$dor_f[id]}." where id=$dor_f[id] ");
			}

?>