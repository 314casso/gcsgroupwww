<?

/*
 *  $Id: edit.php,v 1.5 2004/12/19 22:51:08 dave Exp $
 *
 *  $Log: edit.php,v $
 *  Revision 1.5  2004/12/19 22:51:08  dave
 *  Оптимизация запросов к БД -- избавление от лишних OUTER JOIN
 *
 *
 */

global $arclist;
if (empty($arclist)) {$arclist='';}

$sql = 'select * from engine_NEWSGROUP where doc_id='.$parent_doc['pid'];
if (!($result = mysql_query($sql)))
{
	die($sql);
}

if (!($new_settings = mysql_fetch_array($result, MYSQL_ASSOC)))
{
	die('Не найдены настройки новостной ленты.');
}

$date_field = (mysql_fetch_assoc(mysql_query("SHOW COLUMNS FROM engine_NEW LIKE 'new_date';")))?
			"n.new_date":"d.creation_date";

$mn['01']="Январь";
$mn['02']="Февраль";
$mn['03']="Март";
$mn['04']="Апрель";
$mn['05']="Май";
$mn['06']="Июнь";
$mn['07']="Июль";
$mn['08']="Август";
$mn['09']="Сентябрь";
$mn['10']="Октябрь";
$mn['11']="Ноябрь";
$mn['12']="Декабрь";

$frm= <<<HTM
<select class=arclist id=arclist name=arclist  onchange='{
if (document.all.arclist.value) ;
document.location="view.php?action=showdoc&id=$id&arclist="+document.all.arclist.value;}'>
<option value=''>Последние {$new_settings['ncount']}</option>
HTM;

$date_field = (mysql_fetch_assoc(mysql_query("SHOW COLUMNS FROM engine_NEW LIKE 'new_date';")))?
			"n.new_date":"d.creation_date";
	
$sql = <<<SQL
SELECT date_format($date_field, '%Y') AS year, date_format($date_field, '%m') AS month
FROM engine_documents d, engine_NEW n 
WHERE d.visible=1 
	AND n.doc_id=d.id 
	AND d.pid={$parent_doc['pid']} and n.new_date != ''
GROUP BY YEAR($date_field) DESC, MONTH($date_field) DESC
SQL;
$DBResult = mysql_query($sql) or die (mysql_error());
while ($res=mysql_fetch_assoc($DBResult))
{
    $al = "{$res['month']}.{$res['year']}";
	$selected = ($arclist == $al)?'selected':'';
	$frm.= "<option $selected value='$al'>{$mn[$res['month']]} {$res['year']}</option>\n";
}
//движок 1.62
$sql="select date_format(d.creation_date, '%Y') AS year, date_format(d.creation_date, '%m') AS month from engine_documents d, engine_NEW n where n.doc_id=d.id and d.pid=".$parent_doc['pid']." and n.new_date IS NULL GROUP BY YEAR(d.creation_date) DESC, MONTH(d.creation_date) DESC";

$DBResult = mysql_query($sql) or die (mysql_error());
while ($res=mysql_fetch_assoc($DBResult))
{
    $al = "{$res['month']}.{$res['year']}";
	$selected = ($arclist == $al)?'selected':'';
	$frm.= "<option $selected value='$al'>{$mn[$res['month']]} {$res['year']}</option>\n";
}

$frm.= "</select>";

$limit='';
if ($arclist)
{
	$arclist=" and date_format($date_field,'%m.%Y')='$arclist' ";
}
else
{
    $limit="LIMIT ".$new_settings['ncount'];
}

if ($date_field == "n.new_date") $where_ = " and n.new_date != '' ";

$sql = <<<SQL
SELECT d.id as did, d.creation_date, n.*
FROM (
	engine_documents d
	LEFT JOIN engine_NEW n ON n.doc_id = d.id
	 )
WHERE d.pid='{$parent_doc['pid']}'
$arclist
$where_
ORDER BY $date_field DESC
$limit
SQL;

if (!$news_r = mysql_query($sql))
{
	die($sql);
}

$news="";
$n=0;

while ($news_f = mysql_fetch_array($news_r))
{
	if (++$n%2==0)
	{
		$td_class = "row2";
	}
	else
	{
		$td_class = "row1";
	}

	$news.= '<tr class="'.$td_class.'">
  <td><a class="com_link" href="view.php?action=showdoc&id='.$news_f['did'].'">'.((isset($news_f['new_date'])) ? $news_f['new_date'] : $news_f['creation_date']).'</a></td>
  <td><a class="com_link" href="view.php?action=showdoc&id='.$news_f['did'].'">'.$news_f['header'].'</a></td>
  <td align=center><a href="#" onclick="proc.document.location=\'proc.php?action=deldoc&id='.$news_f['did'].'\'"><img src="http://dev-sites.belti.ru/ruscon/engine/doc_types/FORM/img/del.gif" border="0" alt="Удалить"></a></td>
</tr>
';
	$did_id_n_[] = $news_f['did'];
}

//старый движок 1.622
if ($where_){

	$where_ = "";
	if (count($did_id_n_) > 0) $where_ = " and d.id not in (". implode(', ', $did_id_n_) .") " ;
	$arclist_ = str_replace("n.new_date","d.creation_date",$arclist);
	$sql = "select d.id as did,date_format(d.creation_date,'%d.%m.%Y') creation_date,n.header from engine_documents d, engine_NEW n where n.doc_id=d.id  $where_  and d.pid=".$parent_doc['pid']." $arclist_ order by d.creation_date desc $limit";

	//echo $sql;
	$news_r_= mysql_query($sql) or die (mysql_error()." in $sql");
	while ($news_f = mysql_fetch_array($news_r_)){
		if (++$n%2==0)
		{
			$td_class = "row2";
		}
		else
		{
			$td_class = "row1";
		}
		$news.= '<tr class="'.$td_class.'">
<td><a class="com_link" href="view.php?action=showdoc&id='.$news_f['did'].'">'.((isset($news_f['new_date'])) ? $news_f['new_date'] : $news_f['creation_date']).'</a></td>
<td><a class="com_link" href="view.php?action=showdoc&id='.$news_f['did'].'">'.$news_f['header'].'</a></td>
<td align=center><a href="#" onclick="proc.document.location=\'proc.php?action=deldoc&id='.$news_f['did'].'\'"><img src="img/ico_del.gif" border="0" alt="Удалить"></a></td>
</tr>';
	}
}

if ($news )
{
	$temp  = '<table class="line" width="90%" cellspacing="1" cellpadding="3" border="0" >';
	$temp .= '<tr><th>Дата</th><th>Заголовок</th><th>Удалить</th></tr>';
	$temp .= $news;
	$temp .= '</table>';

	$news = $temp;
}

if (file_exists("$engine_show_root/engine/pics/news/pic1_".$id.".jpg"))
{
	$pic1="<img src='$engine_show_htroot/engine/pics/news/pic1_".$id.".jpg'>";
	$http1="$engine_show_htroot/engine/pics/news/pic1_".$id.".jpg";
}
elseif (file_exists("$engine_show_root/engine/pics/news/pic1_".$id.".gif"))
{
	$pic1="<img src='$engine_show_htroot/engine/pics/news/pic1_".$id.".gif'>";
	$http1="$engine_show_htroot/engine/pics/news/pic1_".$id.".gif";
}
else
{
	$pic1 = '';
}

if (file_exists("$engine_show_root/engine/pics/news/pic2_".$id.".jpg"))
{
	$pic2="<img src='$engine_show_htroot/engine/pics/news/pic2_".$id.".jpg'>";
	$http2="$engine_show_htroot/engine/pics/news/pic2_".$id.".jpg";
}
elseif (file_exists("$engine_show_root/engine/pics/news/pic2_".$id.".gif"))
{
	$pic2="<img src='$engine_show_htroot/engine/pics/news/pic2_".$id.".gif'>";
	$http2="$engine_show_htroot/engine/pics/news/pic2_".$id.".gif";
}
else
{
	$pic2 = '';
}

$sql = "SELECT *
        FROM engine_groups";

if (!$result = mysql_query($sql))
{
	die($sql);
}

$grpsel="";
while($row = mysql_fetch_array($result))
{
	if ($parent_doc_spec['grpassign'] != $row['id'])
	{
		$grpsel .= '<option value="'.$row['id'].'">'.$row['name'].'</option>';
	}
	else
	{
		$grpsel .= '<option value="'.$row['id'].'" SELECTED>'.$row['name'].'</option>';
	}
}

$usrsel="";

$sql = "SELECT *
	FROM engine_users";

if (!$result = mysql_query($sql))
{
	die($sql);
}

while($row = mysql_fetch_array($result))
{
	if ($parent_doc_spec['usrassign'] != $row['id'])
	{
		$usrsel .= '<option value="'.$row['id'].'">'.$row['login'].'</option>';
	}
	else
	{
		$usrsel .= '<option value="'.$row['id'].'" SELECTED>'.$row['login'].'</option>';
	}
}

unset($tpl->PARSEVARS['TEXT']);
if ($parent_doc_spec['new_date_start'] == "0000-00-00 00:00:00") $parent_doc_spec['new_date_start'] = '';
if ($parent_doc_spec['new_date_end'] == "0000-00-00 00:00:00") $parent_doc_spec['new_date_end'] = '';
include_once $engine_root.'/engine/spaw/spaw_control.class.php';
$sw = new SPAW_Wysiwyg('html' /*name*/,$parent_doc_spec['html'] /*value*/);
$html_1 = $sw->getHtml();
$parent_doc_spec['html'] = $html_1;

$tpl->assign(
		array
		(
			'{NEW_PID}'    => $parent_doc['pid'],
			'{NEW_DATE}'   => isset($parent_doc_spec['new_date']) ? $parent_doc_spec['new_date'] : $parent_doc['creation_date'],
			'{NEW_DATE_START}' => isset($parent_doc_spec['new_date_start']) ? $parent_doc_spec['new_date_start'] : $parent_doc['new_date_start'],
			'{NEW_DATE_END}' => isset($parent_doc_spec['new_date_end']) ? $parent_doc_spec['new_date_end'] : $parent_doc['new_date_end'],
			'{NEW_FRM}'    => $frm,
			'{NEWS}'       => $news,
			'{NEW_GRPSEL}' => $grpsel,
			'{NEW_USRSEL}' => $usrsel,
			'{NEW_PIC1}'   => $pic1,
			'{NEW_HTTP_PIC1}'   => $http1,
			'{NEW_PIC2}'   => $pic2,
			'{NEW_HTTP_PIC2}'   => $http2,
			'{NEW_HEADER}' => htmlspecialchars($parent_doc_spec['header']),
			'{NEW_TEXT}'   => htmlspecialchars($parent_doc_spec['text']),
			'{NEW_HTML}'   => $parent_doc_spec['html']
		)
	    );

?>