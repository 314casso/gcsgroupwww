<?
		if (mysql_num_rows(mysql_query("select * from engine_FEEDBACK where doc_id=$id")))
		   	$sql="update engine_FEEDBACK set
				text1='$txt1',
				text2='$txt2',
				btntext='$btntxt' where doc_id=$id";
		else
			$sql="insert into engine_FEEDBACK(text1,text2,btntext,doc_id) values('$txt1','$txt2','$btntxt','$id')";
		mysql_query($sql) or die("SQL error ".mysql_error()." in: $sql\n");

		$i=0;
		while (${"id$i"}) {
			$sql="update engine_FEEDBACK_questions set
			question='".${"q$i"}."',
			answer='".${"a$i"}."'
			 where id=".${"id$i"};
			mysql_query($sql) or die("SQL error ".mysql_error()." in: $sql\n");
			$i++;
			}

?>