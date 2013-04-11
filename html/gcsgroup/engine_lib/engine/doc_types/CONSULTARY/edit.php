<?

/*
 *  $Id: edit.php,v 1.8 2006/10/19 09:44:53 ereih Exp $
 *
 *  15.05.2007 https://bt.belti.ru/tasks/bug_view_page.php?bug_id=0007515
 *
 *  $Log: edit.php,v $
 *  Revision 1.8  2006/10/19 09:44:53  ereih
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

/*
ALTER TABLE `engine_CONSULTARY` RENAME `engine_CONSULTARY_quests` ;
CREATE TABLE `engine_CONSULTARY` (
`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`doc_id` INT NOT NULL ,
`cons_body` TEXT NOT NULL ,
`cons_line` TEXT NOT NULL ,
`cons_answer` VARCHAR( 255 ) NOT NULL ,
`cons_question` VARCHAR( 255 ) NOT NULL ,
`cons_on_page` INT NOT NULL ,
UNIQUE (
`doc_id`
)
) TYPE = MYISAM ;*/


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

if($del)
{
	$sql = 'DELETE FROM '.$table.'
	        WHERE doc_id='.$id.'
	          AND id='.intval($del);

	if (!$result = @mysql_query($sql))
	{
		die (mysql_error());
	}
}

$sql = 'SELECT count(*) AS count
        FROM '.$table.'
        WHERE doc_id='.$id;

if (!$result = @mysql_query($sql))
{
	die (mysql_error());
}

$cnt = @mysql_fetch_array($result);
$cnt = $cnt['count'];

$page = intval($page);
$sql = 'SELECT *
        FROM '.$table.'
        WHERE doc_id='.$id.'
        ORDER BY date DESC
        LIMIT '.$page.',5;';

if (!$result = mysql_query($sql))
{
	die(mysql_error());
}

$i=0;
$c = mysql_num_rows($result);

while($qst = mysql_fetch_array($result))
{

	$qsts .= '
<tr>
  <td><span class="cat"><img src="img/arrow.gif" brder="0" vspace="2"> Вопрос задал(а)</span> <b>'.$qst['author'].'</b> ['.$qst['date'].']
      <a class="com_link" href="view.php?action=showdoc&id='.$id.'&page='.$page.'&del='.$qst['id'].'">Удалить</a>
  </td>
</tr>
<tr>
  <td><textarea name="q'.$i.'" cols="75" rows="3">'.$qst['question'].'</textarea></td>
</tr>
<tr>
  <td class=top><span class="cat"><img src="img/arrow.gif" brder="0" vspace="2"> Ответ</span></td>
</tr>
<tr>
  <td><textarea name="a'.$i.'" cols="75" rows="6">'.$qst['answer'].'</textarea></td>
</tr>
<input type="hidden" name="id'.$i.'" value="'.$qst['id'].'" />
';


	if ($i<($c-1))
	{
		$qsts .= '
<tr>
  <td><hr color="#959595" size="1" width="100%"></td>
</tr>
';
	}
	$i++;
}

// Определение размера страницы по умолчанию
if (!defined ('ENGINE_CONSULTARY_PAGESIZE'))
{
	define ('ENGINE_CONSULTARY_PAGESIZE', 5);
}

if (!defined('ENGINE_CONSULTARY_PAGENUM_MIDDLE'))
{
	define('ENGINE_CONSULTARY_PAGENUM_MIDDLE', 10);
}

$page_num = intval (($cnt + ENGINE_CONSULTARY_PAGESIZE - 1) / ENGINE_CONSULTARY_PAGESIZE);

if ($page_num >= 1)
{
	// Выводить листалку только если число страниц >= 1
	if ($cnt > $page + ENGINE_CONSULTARY_PAGESIZE)
	{
		$pgsF = "<strong><a href='view.php?action=showdoc&id=$id&page=".($page + ENGINE_CONSULTARY_PAGESIZE)."'>Вперед</a></strong>";
	}

	if ($page)
	{
		$pgsB = "<strong><a href='view.php?action=showdoc&id=$id&page=".($page - ENGINE_CONSULTARY_PAGESIZE)."'>Назад</a></strong>";
	}

	if ($page_num >= 2)
	{
		// Выводить постраничный навигатор если число страниц >= 2
		$pgsM = '';
		for ($i = 0; $i < $page_num; $i++)
		{
			if ($i == intval (($page + ENGINE_CONSULTARY_PAGESIZE - 1) / ENGINE_CONSULTARY_PAGESIZE))
			{
				$pgsM .= ' <strong>'.($i + 1).'</strong> ';
			}
			else
			{
				$pgsM .= " <strong><a href='view.php?action=showdoc&id=$id&page=".$i * ENGINE_CONSULTARY_PAGESIZE."'>".($i + 1)."</a></strong> ";
			}

			$i_new = 0;
			if ($i == 2)
			{
				$i_new = ($page_num > ENGINE_CONSULTARY_PAGENUM_MIDDLE) ? (intval ($page_num / 2) - 3 < 0 ? $i : intval ($page_num / 2) - 3) : ($page_num - 4 < $i ? 0 : $page_num - 4);
			}
			elseif ($page_num > ENGINE_CONSULTARY_PAGENUM_MIDDLE && $i == intval ($page_num / 2))
			{
				$i_new = $page_num - 4 < 0 ? $i : $page_num - 4;
			}

			if ($i_new > $i)
			{
				$i = $i_new;
				$pgsM .= ' ... ';
			}
		}
	}

	$pgs = $pgsB.($pgsB != '' && ($pgsM != '' || $pgsF != '') ? ' | ' : '').
	$pgsM.($pgsF != '' && ($pgsM != '' || $pgsB != '') ? ' | ' : '').$pgsF;
}


$tpl->assign(array(
		'{CONS_PAGES}' =>$pgs,
		'{CONS_QUESTS}' =>$qsts,
		'{CONS_BODY}' => htmlspecialchars($parent_doc_spec['cons_body']),
		'{CONS_LINE}' => htmlspecialchars($parent_doc_spec['cons_line']),
		'{CONS_ANSWER}' => htmlspecialchars($parent_doc_spec['cons_answer']),
		'{CONS_QUESTION}' => htmlspecialchars($parent_doc_spec['cons_question']),
		'{CONS_ON_P}' => intval($parent_doc_spec['cons_on_page']),
		)
	);

?>