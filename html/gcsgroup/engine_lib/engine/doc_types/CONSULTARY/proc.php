<?
$sql = 'SHOW TABLES';
if (!$result = @mysql_query($sql))
{
	die('SQL error: '.mysql_error().' in: '.$sql);
}

while ($row = mysql_fetch_array($result, MYSQL_NUM))
{
	$tables[$row[0]] = true;
}

if (isset($tables['engine_CONSULTARY_quests']))
{
	$table = 'engine_CONSULTARY_quests';

	if (get_magic_quotes_gpc())
	{
		$cons_body  = mysql_real_escape_string(stripslashes($_POST['cons_body']));
		$cons_line  = mysql_real_escape_string(stripslashes($_POST['cons_line']));
		$cons_answer  = mysql_real_escape_string(stripslashes($_POST['cons_answer']));
		$cons_question  = mysql_real_escape_string(stripslashes($_POST['cons_question']));
		$cons_on_page  = intval($_POST['cons_on_page']);
	}
	else
	{
		$cons_body  = mysql_real_escape_string($_POST['cons_body']);
		$cons_line  = mysql_real_escape_string($_POST['cons_line']);
		$cons_answer  = mysql_real_escape_string($_POST['cons_answer']);
		$cons_question  = mysql_real_escape_string($_POST['cons_question']);
		$cons_on_page  = intval($_POST['cons_on_page']);
	}

	$sql = 'SELECT *
	        FROM engine_CONSULTARY
	        WHERE doc_id = '.$id;

	if (!$result = @mysql_query($sql))
	{
		die($sql);
	}

	if (mysql_num_rows($result) > 0)
	{
		$sql = 'UPDATE engine_CONSULTARY
		           SET cons_body = "'.$cons_body.'",
		               cons_line = "'.$cons_line.'",
		               cons_answer = "'.$cons_answer.'",
		               cons_question = "'.$cons_question.'",
		               cons_on_page = "'.$cons_on_page.'"
			WHERE doc_id='.$id;
	}
	else
	{
		$sql = 'INSERT INTO engine_CONSULTARY (doc_id, cons_body, cons_line, cons_answer, cons_question, cons_on_page)
	                                       VALUES ('.$id.', "'.$cons_body.'", "'.$cons_line.'", "'.$cons_answer.'", "'.$cons_question.'", "'.$cons_on_page.'");';
	}

	if (!$result = @mysql_query($sql))
	{
		die($sql);
	}
}
else
{
	$table = 'engine_CONSULTARY';
}


$i=0;
while ($_POST['id'.$i])
{
	if (get_magic_quotes_gpc())
	{
		$cons_q  = mysql_real_escape_string(stripslashes($_POST['q'.$i]));
		$cons_a  = mysql_real_escape_string(stripslashes($_POST['a'.$i]));
		$cons_id = intval($_POST['id'.$i]);
	}
	else
	{
		$cons_q  = mysql_real_escape_string($_POST['q'.$i]);
		$cons_a  = mysql_real_escape_string($_POST['a'.$i]);
		$cons_id = intval($_POST['id'.$i]);
	}

	$sql = 'UPDATE '.$table.'
	        SET question="'.$cons_q.'",
                    answer="'.$cons_a.'"
                WHERE id='.$cons_id;

	if (!$result = @mysql_query($sql))
	{
		die('SQL error: '.mysql_error().' in: '.$sql);
	}

	$i++;
}
?>