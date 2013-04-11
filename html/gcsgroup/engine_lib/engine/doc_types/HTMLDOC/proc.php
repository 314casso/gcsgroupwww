<?
				$html=stripslashes($html);
				$sql="delete from  engine_HTMLDOC where doc_id=$id";
				mysql_query($sql) or die("SQL error ".mysql_error()." in: $sql\n"); 
				$html=str_replace("'","\'",$html);
				
				$sql="insert into  engine_HTMLDOC(html,doc_id) values('$html',$id)";
				mysql_query($sql) or die("SQL error ".mysql_error()." in: $sql\n"); 
?>