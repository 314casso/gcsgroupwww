<?



		$sql="select * from  engine_CALC where doc_id=$id";
		$r=mysql_query($sql) or die("SQL error ".mysql_error()." in: $sql\n"); 
		if (mysql_num_rows($r)==0) {
			$sql="insert into  engine_CALC(formula,doc_id) values('$formula',$id)";
			mysql_query($sql) or die("SQL error ".mysql_error()." in: $sql\n"); 
			}
		else {
			$sql="update engine_CALC set 
				formula='$formula'
				where doc_id=$id";
			mysql_query($sql) or die("SQL error ".mysql_error()." in: $sql\n"); 
			}
		$sql="select * from engine_CALC_param where calc=$id";
		$r=mysql_query("$sql") or die (mysql_error());
		while($f=mysql_fetch_array($r)){	
			$sql="update engine_CALC_param set 
					name='".${"name$f[id]"}."'
					where id=$f[id]";

			mysql_query($sql) or die("SQL error ".mysql_error()." in: $sql\n"); 
			$sql="select * from engine_CALC_vals where param=$f[id]";
			$r1=mysql_query("$sql") or die (mysql_error());
			while($f1=mysql_fetch_array($r1)){	
				$sql="update `engine_CALC_vals` 
						set text='".${"text{$f[id]}_$f1[id]"}."',val= '".${"val{$f[id]}_$f1[id]"}."'
						where id=$f1[id]
					";
				mysql_query($sql) or die("SQL error ".mysql_error()." in: $sql\n"); 
				}
			
			}			
		if ($np){
			$sql="INSERT INTO `engine_CALC_param` (  `calc` , `name` ) 
					VALUES (
						$id,
						'$np_name'
						)";
			mysql_query($sql) or die("SQL error ".mysql_error()." in: $sql\n"); 			
			}
		if ($delparam){
			$sql="delete from `engine_CALC_param` where id=$delparam";
			mysql_query($sql) or die("SQL error ".mysql_error()." in: $sql\n"); 
			$sql="delete from `engine_CALC_vals` where param=$delparam";
			mysql_query($sql) or die("SQL error ".mysql_error()." in: $sql\n"); 
			}			
		if ($npv_paramid){
			$sql="INSERT INTO `engine_CALC_vals` (  `text`,`val` , `param` ) 
				VALUES (
					'".${"npvtext$npv_paramid"}."','".${"npv$npv_paramid"}."', '$npv_paramid'
				)";
			mysql_query($sql) or die("SQL error ".mysql_error()." in: $sql\n"); 
			}
		if ($delpossval){
			$sql="delete from `engine_CALC_vals` where id=$delpossval";
			mysql_query($sql) or die("SQL error ".mysql_error()." in: $sql\n"); 
			}		
		

?>