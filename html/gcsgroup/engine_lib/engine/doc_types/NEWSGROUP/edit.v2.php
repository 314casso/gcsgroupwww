<?

/*
 *  $Id: edit.php,v 1.4 2004/12/19 22:51:27 dave Exp $
 *
 *  $Log: edit.php,v $
 *  Revision 1.4  2004/12/19 22:51:27  dave
 *  Оптимизация запросов к БД -- избавление от лишних OUTER JOIN
 *
 *
 */
//debugbreak();

global $arclist;

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

    $parent_doc_spec['ncount'] = ($parent_doc_spec['ncount'])?$parent_doc_spec['ncount']:5;
$frm= <<<HTM
<select class=arclist id=arclist name=arclist  onchange='{
	if (document.all.arclist.value) ;
		document.location="view.php?action=showdoc&id=$id&arclist="+document.all.arclist.value;
	}'><option value=''>Последние {$parent_doc_spec['ncount']}</option>
HTM;

$date_field = (mysql_fetch_assoc(mysql_query("SHOW COLUMNS FROM engine_NEW LIKE 'new_date';")))?
			"n.new_date":"d.creation_date";
	
$sql = <<<SQL
SELECT date_format($date_field, '%Y') AS year, date_format($date_field, '%m') AS month
FROM engine_documents d, engine_NEW n 
WHERE d.visible=1 
	AND n.doc_id=d.id 
	AND d.pid={$id} 
GROUP BY YEAR($date_field) DESC, MONTH($date_field) DESC
SQL;

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
	$arclist=" AND date_format($date_field,'%m.%Y')='$arclist' ";
}
else
{
    $limit="LIMIT ".$parent_doc_spec['ncount'];
}


$sql = <<<SQL
SELECT d.id as did, creation_date, n.*
FROM (
	engine_documents d
	LEFT JOIN engine_NEW n ON n.doc_id = d.id
   )
WHERE d.pid='$id'
 $arclist
ORDER BY $date_field DESC
 $limit
SQL;

$news_r= mysql_query($sql) or die (mysql_error()." in $sql");

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
<td align=center><a href="#" onclick="proc.document.location=\'proc.php?action=deldoc&id='.$news_f['did'].'\'"><img src="img/ico_del.gif" border="0" alt="Удалить"></a></td>
</tr>';
}

if ($news )
{
	$temp  = '<table class="line" width="90%" cellspacing="1" cellpadding="3" border="0" >';
	$temp .= '<tr><th>Дата</th><th>Заголовок</th><th>Удалить</th></tr>';
	$temp .= $news;
	$temp .= '</table>';

	$news = $temp;
}

if ($parent_doc_spec['ncount']=="")$parent_doc_spec['ncount']=5;

$tpl->assign(
		array(
			'FRM'		=>  $frm,
			'NEWS'	=>	$news,
			'NCOUNT'	=>	$parent_doc_spec['ncount'],
			'FORMAT'	=>	$parent_doc_spec['format']
		)
	);



?>
