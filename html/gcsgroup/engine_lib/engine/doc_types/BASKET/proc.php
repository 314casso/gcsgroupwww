<?
	if ($send_URL)$send_URL=1;else $send_URL=0;
	if ($send_bd)$send_bd=1;else $send_bd=0;
	if ($send_email)$send_email=1;else $send_email=0;
	if ($send_reg)$send_reg=1;else $send_reg=0;

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
			send_email='$send_email'
			where doc_id=$id") or die (mysql_error());
			}
	else {
		mysql_query("insert into engine_FORM (`coding`,`desc`,email,action,text,button,doc_id) values('$form_email_coding','$form_desc','$form_email','$form_action','$form_text','$form_button',$id)");
		}
	mysql_query("delete from engine_FORM_fields where doc_id=$id") or die (mysql_error());

	for($i=0;$i<=$field_count;$i++){
		if (${"required".$i})${"required".$i}=1;
		else ${"required".$i}=0;
		if (${"field".$i})
			mysql_query("insert into engine_FORM_fields(required,field_name,field_bd_name,field_text,field_ord,field_caption,doc_id)  values('".${"required".$i}."','".${"name".$i}."','".${"bdfield".$i}."','".${"field".$i}."','".${"ord".$i}."','".${"caption$i"}."',$id)") or die (mysql_error());
		}
?>