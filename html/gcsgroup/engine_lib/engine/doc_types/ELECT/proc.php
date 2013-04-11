<?

if (get_magic_quotes_gpc())
{
	$question   = mysql_real_escape_string(stripslashes($_POST['question']));
	$msg        = mysql_real_escape_string(stripslashes($_POST['msg']));
	$button     = mysql_real_escape_string(stripslashes($_POST['button']));

	$elect_item   = mysql_real_escape_string(stripslashes($_POST['elect_item']));
	$elect_format = mysql_real_escape_string(stripslashes($_POST['elect_format']));
	$elect_type   = intval($_POST['elect_type']);
	$elect_voted  = mysql_real_escape_string(stripslashes($_POST['elect_voted']));
	$elect_v_item = mysql_real_escape_string(stripslashes($_POST['elect_voted_item']));
	$elect_mess   = mysql_real_escape_string(stripslashes($_POST['elect_message']));

	$clear = isset($_POST['clear']);

	$quest = array();
	for($i=1; $i<=10; $i++)
	{
		$quest['q'.$i] = mysql_real_escape_string(stripslashes($_POST['quest'.$i]));
	}
}
else
{
	$question   = mysql_real_escape_string($_POST['question']);
	$msg        = mysql_real_escape_string($_POST['msg']);
	$button     = mysql_real_escape_string($_POST['button']);

	$elect_item   = mysql_real_escape_string($_POST['elect_item']);
	$elect_format = mysql_real_escape_string($_POST['elect_format']);
	$elect_type   = intval($_POST['elect_type']);
	$elect_voted  = mysql_real_escape_string($_POST['elect_voted']);
	$elect_v_item = mysql_real_escape_string($_POST['elect_voted_item']);
	$elect_mess   = mysql_real_escape_string($_POST['elect_message']);

	$clear = isset($_POST['clear']);

	$quest = array();
	for($i=1; $i<=10; $i++)
	{
		$quest['q'.$i] = mysql_real_escape_string($_POST['quest'.$i]);
	}
}

$sql = 'DESCRIBE engine_ELECT';

$result = @mysql_query($sql);

if (!$result)
{
	die('Ошибка во время выполнения SQL запроса:<br \>'.$sql.'<br \>'.mysql_error());
}

$fields = array();
while($field = mysql_fetch_array($result, MYSQL_ASSOC))
{
	$fields[$field['Field']] = $field;
}

$sql='SELECT *
      FROM engine_ELECT
      WHERE doc_id='.$id;

if (!$result = mysql_query($sql))
{
	die($sql);
}

if (mysql_num_rows($result) == 0)
{
	if (isset($fields['elect_format']))
	{
		$sql='INSERT INTO engine_ELECT
	                          (question, msg, button, quest1, quest2, quest3, quest4, quest5, quest6, quest7, quest8, quest9, quest10, doc_id, elect_item, elect_format, elect_type, elect_voted, elect_voted_item, elect_message)
	                   VALUES ("'.$question.'", "'.$msg.'", "'.$button.'","'.$quest['q1'].'","'.$quest['q2'].'","'.$quest['q3'].'","'.$quest['q4'].'","'.$quest['q5'].'","'.$quest['q6'].'","'.$quest['q7'].'","'.$quest['q8'].'","'.$quest['q9'].'","'.$quest['q10'].'",'.$id.',"'.$elect_item.'","'.$elect_format.'","'.$elect_type.'","'.$elect_voted.'","'.$elect_v_item.'","'.$elect_mess.'")';
	}
	else
	{
		$sql='INSERT INTO engine_ELECT
	                          (question, msg, button, quest1, quest2, quest3, quest4, quest5, quest6, quest7, quest8, quest9, quest10, doc_id)
	                   VALUES ("'.$question.'", "'.$msg.'", "'.$button.'","'.$quest['q1'].'","'.$quest['q2'].'","'.$quest['q3'].'","'.$quest['q4'].'","'.$quest['q5'].'","'.$quest['q6'].'","'.$quest['q7'].'","'.$quest['q8'].'","'.$quest['q9'].'","'.$quest['q10'].'",'.$id.')';
	}

	if (!$result = mysql_query($sql))
	{
		die($sql);
	}
}
else
{
	if ($clear)
	{		if (isset($fields['elect_format']))
		{			$sql = 'DELETE FROM engine_ELECT_IP
			        WHERE elect_id = '.$id;

			if (!$result = mysql_query($sql))
			{				die($sql);
			}

			$sql = 'OPTIMIZE TABLE engine_ELECT_IP';

			if (!$result = mysql_query($sql))
			{
				die($sql);
			}
		}
		$sql_ex =', quest1_n = 0,
			    quest2_n = 0,
			    quest3_n = 0,
			    quest4_n = 0,
			    quest5_n = 0,
			    quest6_n = 0,
			    quest7_n = 0,
			    quest8_n = 0,
			    quest9_n = 0,
			    quest10_n= 0';
	}
	else
	{
		$sql_ex = '';
	}

	if (isset($fields['elect_format']))
	{
		$sql_ex .= ', elect_item = "'.$elect_item.'",
		              elect_type = "'.$elect_type.'",
		              elect_format = "'.$elect_format.'",
		              elect_voted  = "'.$elect_voted.'",
		              elect_voted_item = "'.$elect_v_item.'",
		              elect_message = "'.$elect_mess.'"
		              ';
	}

	$sql = 'UPDATE engine_ELECT
	           SET	msg = "'.$msg.'",
			button = "'.$button.'",
			question = "'.$question.'",
			quest1 = "'.$quest1.'",
			quest2 = "'.$quest2.'",
			quest3 = "'.$quest3.'",
			quest4 = "'.$quest4.'",
			quest5 = "'.$quest5.'",
			quest6 = "'.$quest6.'",
			quest7 = "'.$quest7.'",
			quest8 = "'.$quest8.'",
			quest9 = "'.$quest9.'",
			quest10 = "'.$quest10.'"'
			.$sql_ex.'
		 WHERE doc_id='.$id;

	if (!$result = mysql_query($sql))
	{
		die($sql);
	}
}
?>