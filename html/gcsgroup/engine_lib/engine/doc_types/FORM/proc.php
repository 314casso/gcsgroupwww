<?
	if ($send_URL)$send_URL=1;else $send_URL=0;
	if ($send_bd)$send_bd=1;else $send_bd=0;
	if ($send_email)$send_email=1;else $send_email=0;
	if ($send_reg)$send_reg=1;else $send_reg=0;
	if ($_POST[send_control])$send_control=1;else $send_control=0;
	//вначале узнаем есть ли в бд поле send_control
       $sql = "select send_control from engine_FORM where doc_id=$id";
	if (!$news_r = mysql_query($sql)){
		mysql_query("ALTER TABLE `engine_FORM` ADD `send_control` TINYINT( 4 ) NOT NULL");
	}
       $sql = "select text_control from engine_FORM where doc_id=$id";
	if (!$news_r = mysql_query($sql)){
		mysql_query("ALTER TABLE `engine_FORM` ADD `text_control` TEXT NOT NULL");
	}
       $sql = "select form_format from engine_FORM where doc_id=$id";
	if (!$news_r = mysql_query($sql)){
		mysql_query("ALTER TABLE `engine_FORM` ADD `form_format` TEXT NOT NULL");
	}

	if (mysql_num_rows(mysql_query("select * from engine_FORM where doc_id=$id"))){
		mysql_query("update engine_FORM set 
			email='$form_email',
			action='$form_action',
			bd='$form_bd',
			button='$form_button',
			text='$form_text',
			`desc`='$form_desc',
			`coding`='$form_email_coding',
			send_URL='$send_URL',
			send_bd='$send_bd',
			send_reg='$send_reg',
			send_control='$send_control',
			form_format='$form_format',
			text_control='$_POST[text_control]',
			send_email='$send_email'
			where doc_id=$id") or die (mysql_error());
			}
	else {
		mysql_query("insert into engine_FORM (`coding`,`desc`,email,action,text,button,doc_id) values('$form_email_coding','$form_desc','$form_email','$form_action','$form_text','$form_button',$id)");
		}

	//вытаскиваем список всех полей
	$f_sql="select * from engine_FORM_fields where doc_id=$id";
	$f_r=mysql_query($f_sql);
	while($f_f=mysql_fetch_array($f_r)){
		$ex_arr_[$f_f[id]] = 1;
	}

	for($i=0;$i<=$field_count;$i++){
		if (${"required".$i})${"required".$i}=1;
		else ${"required".$i}=0;
		if (${"field".$i}){
			//проверка на то что записи есть
			if (mysql_query("select * from engine_FORM_fields where doc_id=$id and id = ".${"id_field".$i}) && ${"id_field".$i} != ''){
				//echo ${"id_field".$i}."<br>";
				mysql_query("update engine_FORM_fields set 
					required = '".${"required".$i}."',
					field_name = '".${"name".$i}."',
					field_bd_name = '".${"bdfield".$i}."',
					field_text = '".${"field".$i}."',
					field_ord = '".${"ord".$i}."',
					field_caption = '".${"caption$i"}."'
					where doc_id=$id and id = ".${"id_field".$i}) or die (mysql_error());
				unset($ex_arr_[${"id_field".$i}]);
			}
			else{
				mysql_query("insert into engine_FORM_fields(required,field_name,field_bd_name,field_text,field_ord,field_caption,doc_id)  values('".${"required".$i}."','".${"name".$i}."','".${"bdfield".$i}."','".${"field".$i}."','".${"ord".$i}."','".${"caption$i"}."',$id)") or die (mysql_error());
			}
		}
	}
	if (count($ex_arr_) > 0){
		while(list($key, $value) = each($ex_arr_)) {
			mysql_query("delete from engine_FORM_fields where doc_id=$id and id = ".$key) or die (mysql_error());
		}
	}
?>