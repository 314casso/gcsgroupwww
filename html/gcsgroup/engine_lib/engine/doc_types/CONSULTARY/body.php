<?

/*
 *  $Id: body.php,v 1.9 2006/10/19 09:44:53 ereih Exp $
 *
 *  $Log: body.php,v $
 *  Revision 1.9  2006/10/19 09:44:53  ereih
 *  Обновление функционала. Добавление возможности настройки шаблонов
 *
 *  Revision 1.6  2004/12/25 15:32:30  dave
 *  Вывод текущей номера страницы неактивным
 *
 *  Revision 1.5  2004/12/25 14:10:20  dave
 *  В листалку добавлены разделители
 *
 *  Revision 1.4  2004/12/25 13:31:00  dave
 *  Расширена листалка (3105)
 *
 *
 */

global $lang, $lang_text, $doc;

if (empty($lang))
{	$lang = 'ru';
}

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
}
else
{
	$table = 'engine_CONSULTARY';
}

$lang_text = array();
$lang_text['ru']['Next'] = 'След.';
$lang_text['ru']['Previous'] = 'Пред.';

${"cons".$this->id."_page"}+=0;
$page+=0;

$p_id       = $this->id;
$p_do       = $_REQUEST['cons'.$p_id.'_do'];
$p_page     = intval($_REQUEST['cons'.$p_id.'_page']);

if (!get_magic_quotes_gpc())
{	$p_name     = $_REQUEST['cons'.$p_id.'_name'];
	$p_question = $_REQUEST['cons'.$p_id.'_quest'];
}
else
{	$p_name     = stripslashes($_REQUEST['cons'.$p_id.'_name']);
	$p_question = stripslashes($_REQUEST['cons'.$p_id.'_quest']);
}

if ($p_do == $p_id)
{
	$p_question = strip_tags($p_question);
	$p_name = strip_tags($p_name);
	$sql = 'INSERT INTO '.$table.' (date, question, author, doc_id)
	                        VALUES (NOW(),"'.mysql_real_escape_string(htmlspecialchars($p_question)).'","'.mysql_real_escape_string(htmlspecialchars($p_name)).'","'.$p_id.'");';

	if (!$result = @mysql_query($sql))
	{		die('SQL error: '.$sql);
	}
}

$sql = 'SELECT count(*) as total
        FROM '.$table.'
        WHERE doc_id="'.$p_id.'"';

if (!$result = mysql_query($sql))
{	die ('SQL Error: '.mysql_error().' '.$sql);
}
$total = mysql_fetch_array($result, MYSQL_ASSOC);
$total = $total['total'];

// Определение размера страницы по умолчанию
if (!defined ('ENGINE_CONSULTARY_PAGESIZE'))
{	define ('ENGINE_CONSULTARY_PAGESIZE', 5);
}

if (!function_exists('generate_pagination'))
{
	function append_sid($string)
	{		return $string;
	}

	function generate_pagination($base_url, $num_items, $per_page, $start_item, $page_var = 'page', $add_prevnext_text = TRUE)
	{
		global $lang_text, $lang;

		$total_pages = ceil($num_items/$per_page);

		if ( $total_pages == 1 )
		{
			return '';
		}

		$on_page = floor($start_item / $per_page) + 1;

		$page_string = '';
		if ( $total_pages > 10 )
		{
			$init_page_max = ( $total_pages > 3 ) ? 3 : $total_pages;

			for($i = 1; $i < $init_page_max + 1; $i++)
			{
				$page_string .= ( $i == $on_page ) ? '<b>' . $i . '</b>' : '<a href="' . append_sid($base_url . $page_var . "=" . ( ( $i - 1 ) * $per_page ) ) . '">' . $i . '</a>';
				if ( $i <  $init_page_max )
				{
					$page_string .= ", ";
				}
			}

			if ( $total_pages > 3 )
			{
				if ( $on_page > 1  && $on_page < $total_pages )
				{
					$page_string .= ( $on_page > 5 ) ? ' ... ' : ', ';

					$init_page_min = ( $on_page > 4 ) ? $on_page : 5;
					$init_page_max = ( $on_page < $total_pages - 4 ) ? $on_page : $total_pages - 4;

					for($i = $init_page_min - 1; $i < $init_page_max + 2; $i++)
					{
						$page_string .= ($i == $on_page) ? '<b>' . $i . '</b>' : '<a href="' . append_sid($base_url . $page_var . "=" . ( ( $i - 1 ) * $per_page ) ) . '">' . $i . '</a>';
						if ( $i <  $init_page_max + 1 )
						{
							$page_string .= ', ';
						}
					}

					$page_string .= ( $on_page < $total_pages - 4 ) ? ' ... ' : ', ';
				}
				else
				{
					$page_string .= ' ... ';
				}

				for($i = $total_pages - 2; $i < $total_pages + 1; $i++)
				{
					$page_string .= ( $i == $on_page ) ? '<b>' . $i . '</b>'  : '<a href="' . append_sid($base_url . $page_var . "=" . ( ( $i - 1 ) * $per_page ) ) . '">' . $i . '</a>';
					if( $i <  $total_pages )
					{
						$page_string .= ", ";
					}
				}
			}
		}
		else
		{
			for($i = 1; $i < $total_pages + 1; $i++)
			{
				$page_string .= ( $i == $on_page ) ? '<b>' . $i . '</b>' : '<a href="' . append_sid($base_url . $page_var . "=" . ( ( $i - 1 ) * $per_page ) ) . '">' . $i . '</a>';
				if ( $i <  $total_pages )
				{
					$page_string .= ', ';
				}
			}
		}

		if ( $add_prevnext_text )
		{
			if ( $on_page > 1 )
			{
				$page_string = ' <a href="' . append_sid($base_url . $page_var . "=" . ( ( $on_page - 2 ) * $per_page ) ) . '">' . $lang_text[$lang]['Previous'] . '</a>&nbsp;&nbsp;' . $page_string;
			}

			if ( $on_page < $total_pages )
			{
				$page_string .= '&nbsp;&nbsp;<a href="' . append_sid($base_url . $page_var . "=" . ( $on_page * $per_page ) ) . '">' . $lang_text[$lang]['Next'] . '</a>';
			}

		}

		return $page_string;
	}
}

$pagination = generate_pagination('?', ceil($total / ENGINE_CONSULTARY_PAGESIZE), 1, $p_page, 'cons'.$p_id.'_page');

if (empty($this->spec['cons_body']))
{	$cons_format = '
<form action="" method="post">
  <input type="hidden" name="cons{cons_id}_do" value="{cons_id}" />
  <table align="center" cellspacing="0"  class="cons_htable">
    <tr class="cons_htable_tr1"><td class="cons_htable_td1">Ваше имя</td><td class="cons_htable_td2"><input class="cons_name" name="cons{cons_id}_name" value=""></td></tr>
    <tr class="cons_htable_tr2"><td class="cons_htable_td1">Ваш вопрос</td><td class="cons_htable_td2"><textarea name="cons{cons_id}_quest" class="cons_quest"></textarea></td></tr>
    <tr class="cons_htable_tr3"><td class="cons_htable_td3" colspan="2"><input type="submit" class="cons_submit" value ="Отправить"></td></tr>
  </table>
  {pagination}
</form>
  <table class="cons_table" cellpadding="3" cellspacing="1">
  {cons_body}
  </table>
';
}
else
{	$cons_format = $this->spec['cons_body'];
}

if (empty($this->spec['cons_line']))
{	$cons_line = '
    <tr class="cons_table_tr1">
      <td class="cons_table_td1" rowspan="2" valign="top"><b>{author}</b><br />({fdate})</td>
      <td class="cons_table_td2"><p align="justify" class="cons_question_p">{question}</p></td>
    </tr>
    <tr class="cons_table_tr2">
      <td class="cons_table_td3"><p class="cons_answer_p">{answer}</p></td>
    </tr>
';
}
else
{	$cons_line = $this->spec['cons_line'];
}

if (empty($this->spec['cons_answer']))
{
	$cons_answer = '</p><p class="cons_answer_p">';
}
else
{
	$cons_answer = $this->spec['cons_answer'];
}

if (empty($this->spec['cons_question']))
{
	$cons_question = '</p><p class="cons_question_p">';
}
else
{
	$cons_question = $this->spec['cons_question'];
}

$vars = array('cons_id' => $p_id,
              'pagination' => $pagination);
//STST
$p_page_item = ENGINE_CONSULTARY_PAGESIZE * $p_page;
$sql = 'SELECT *
        FROM '.$table.'
        WHERE doc_id='.$p_id.'
        ORDER BY date DESC
        LIMIT '.$p_page_item.','.ENGINE_CONSULTARY_PAGESIZE;
//        LIMIT '.$p_page.','.ENGINE_CONSULTARY_PAGESIZE;

if (!$result = @mysql_query($sql))
{	die ('SQL Error: '.mysql_error().' '.$sql);
}

while($row = @mysql_fetch_array($result))
{	$row['answer'] = str_replace("\n", $cons_answer, $row['answer']);
	$row['question'] = str_replace("\n" , $cons_question, $row['question']);

	if (empty($row['question']))
	{		$row['question'] = '&nbsp;';
	}

	if (empty($row['answer']))
	{
		$row['answer'] = '&nbsp;';
	}

	$row['fdate'] = date('d.m.Y', strtotime($row['date']));

	$vars['cons_body'] .= AssignVars($row, $cons_line);
}

$this->body = AssignVars($vars, $cons_format);
?>
