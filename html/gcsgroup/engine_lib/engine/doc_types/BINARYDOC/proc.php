<?
set_time_limit(180);
if ($binary)
{	$fn=explode(".",$binary_name);
	$ext=strtolower($fn[count($fn)-1]);
	@unlink("$engine_show_root/engine/documents/document".$id.".*");
	copy($binary,"$engine_show_root/engine/documents/document".$id.".$ext");
	chmod("$engine_show_root/engine/documents/document".$id.".$ext",0777);

	$sql="select * from  engine_BINARYDOC where doc_id=$id";
	$r=mysql_query($sql) or die("SQL error ".mysql_error()." in: $sql\n");
	if (mysql_num_rows($r)==0)
	{		$sql='INSERT INTO engine_BINARYDOC(ext, doc_id)
		                           VALUES ("'.$ext.'",'.$id.')';

		mysql_query($sql) or die("SQL error ".mysql_error()." in: $sql\n");
	}
	else
	{		$sql='UPDATE engine_BINARYDOC
		         SET ext="'.$ext.'"
		      WHERE doc_id='.$id;

		mysql_query($sql) or die("SQL error ".mysql_error()." in: $sql\n");
	}
}
?>