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

$sql = 'select * from engine_NEWSGROUP where doc_id='.$parent_doc['pid'];
if (!($result = mysql_query($sql)))
{	die($sql);
}

if (!($new_settings = mysql_fetch_array($result, MYSQL_ASSOC)))
{	die('Не найдены настройки новостной ленты.');
}

$mn['1']  = 'Январь';
$mn['2']  = 'Февраль';
$mn['3']  = 'Март';
$mn['4']  = 'Апрель';
$mn['5']  = 'Май';
$mn['6']  = 'Июнь';
$mn['7']  = 'Июль';
$mn['8']  = 'Август';
$mn['9']  = 'Сентябрь';
$mn['10'] = 'Октябрь';
$mn['11'] = 'Ноябрь';
$mn['12'] = 'Декабрь';

$today = getdate();

$year  = $today['year'];
$month = $today['mon'];

$sql = 'SELECT date_format(min(d.creation_date),"%Y") y,
               date_format(min(d.creation_date),"%m") m
        FROM engine_documents d, engine_NEW n
        WHERE n.doc_id=d.id and d.pid='.$parent_doc['pid'].'
        ORDER BY d.creation_date desc';

if (!$result = mysql_query($sql))
{	die($sql);
}

$row = mysql_fetch_array($result, MYSQL_ASSOC);
$row['m']+=0;

$frm= '
<select class=arclist id=arclist name=arclist  onchange=\'{
if (document.all.arclist.value) ;
document.location="view.php?action=showdoc&id='.$id.'&arclist="+document.all.arclist.value;
}\'><option value=\'\'>Последние '.$new_settings['ncount'].'</option>';

$m1=$month;
if ($f[y])
{	for ($y=$year;$y>=$f[y];$y--)
	{		for ($m=$m1;(($m>=$f[m]) or ($y>$f[y] and $m>=1)) ;$m--)
		{			if ($arclist=="$m.$y")
			{				$sltd='selected';
			}
			else
			{				$sltd='';
			}

			if (strlen($m)==2)
			{				$al = $m.$y;
			}
			else
			{				$al = '0'.$m.$y;
			}

			$sql='SELECT d.id
			      FROM engine_documents d, engine_NEW n
			      WHERE n.doc_id=d.id and d.pid='.$parent_doc['pid'].' and date_format(d.creation_date,"%m.%Y")="$al"';

 			if (!($result = mysql_query($sql)))
 			{ 				die($sql);
 			}
 			else
 			{ 				if (mysql_num_rows())
 				{ 					$frm.= '<option '.$sltd.' value="'.$al.'">'.$mn[$m].' '.$y.'</option>'."\n";
				}
 			}

 			$m1=12;
		}
	}
}

$frm.= "</select>";

if ($arclist)
{	$arclist=" and date_format(d.creation_date,'%m.%Y')='$arclist' ";
}

$sql = 'SELECT d.id as did, creation_date, n.*
	FROM (
		engine_documents d
		LEFT JOIN engine_NEW n ON n.doc_id = d.id
	     )
	WHERE d.pid='.$parent_doc['pid'].'
	'.$arclist.'
	ORDER BY d.creation_date desc';

if (!$news_r = mysql_query($sql))
{
	die($sql);
}

$news="";
$n=0;

while ($news_f = mysql_fetch_array($news_r))
{	if (++$n%2==0)
	{		$td_class = "row2";
	}
	else
	{		$td_class = "row1";
	}

	$news.= '<tr class="'.$td_class.'">
  <td><a class="com_link" href="view.php?action=showdoc&id='.$news_f['did'].'">'.((($news_f['new_date'])&&($news_f['new_date'] != '0000-00-00 00:00:00')) ? $news_f['new_date'] : $news_f['creation_date']).'</a></td>
  <td><a class="com_link" href="view.php?action=showdoc&id='.$news_f['did'].'">'.$news_f['header'].'</a></td>
  <td align=center><a href="#" onclick="proc.document.location=\'proc.php?action=deldoc&id='.$news_f['did'].'\'"><img src="http://dev-sites.belti.ru/ruscon/engine/doc_types/FORM/img/del.gif" border="0" alt="Удалить"></a></td>
</tr>
';
}

if ($news )
{	$temp  = '<table class="line" width="90%" cellspacing="1" cellpadding="3" border="0" >';
	$temp .= '<tr><th>Дата</th><th>Заголовок</th><th>Удалить</th></tr>';
	$temp .= $news;
	$temp .= '</table>';

	$news = $temp;
}

if (file_exists("$engine_show_root/engine/pics/news/pic1_".$id.".jpg"))
{	$pic1="<img src='$engine_show_htroot/engine/pics/news/pic1_".$id.".jpg'>";
}
elseif (file_exists("$engine_show_root/engine/pics/news/pic1_".$id.".gif"))
{	$pic1="<img src='$engine_show_htroot/engine/pics/news/pic1_".$id.".gif'>";
}
else
{	$pic1 = '';
}

if (file_exists("$engine_show_root/engine/pics/news/pic2_".$id.".jpg"))
{	$pic2="<img src='$engine_show_htroot/engine/pics/news/pic2_".$id.".jpg'>";
}
elseif (file_exists("$engine_show_root/engine/pics/news/pic2_".$id.".gif"))
{	$pic2="<img src='$engine_show_htroot/engine/pics/news/pic2_".$id.".gif'>";
}
else
{	$pic2 = '';
}

$sql = "SELECT *
        FROM engine_groups";

if (!$result = mysql_query($sql))
{
	die($sql);
}

$grpsel="";
while($row = mysql_fetch_array($result))
{	if ($parent_doc_spec['grpassign'] != $row['id'])
	{		$grpsel .= '<option value="'.$row['id'].'">'.$row['name'].'</option>';
	}
	else
	{		$grpsel .= '<option value="'.$row['id'].'" SELECTED>'.$row['name'].'</option>';
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
{	if ($parent_doc_spec['usrassign'] != $row['id'])
	{		$usrsel .= '<option value="'.$row['id'].'">'.$row['login'].'</option>';
	}
	else
	{		$usrsel .= '<option value="'.$row['id'].'" SELECTED>'.$row['login'].'</option>';
	}
}

unset($tpl->PARSEVARS['TEXT']);
$tpl->assign(
		array
		(
			'{NEW_PID}'    => $parent_doc['pid'],
			'{NEW_DATE}'   => isset($parent_doc_spec['new_date']) ? $parent_doc_spec['new_date'] : $parent_doc['creation_date'],
			'{NEW_FRM}'    => $frm,
			'{NEWS}'       => $news,
			'{NEW_GRPSEL}' => $grpsel,
			'{NEW_USRSEL}' => $usrsel,
			'{NEW_PIC1}'   => $pic1,
			'{NEW_PIC2}'   => $pic2,
			'{NEW_HEADER}' => htmlspecialchars($parent_doc_spec['header']),
			'{NEW_TEXT}'   => htmlspecialchars($parent_doc_spec['text']),
			'{NEW_HTML}'   => $parent_doc_spec['html']
		)
	    );

?>