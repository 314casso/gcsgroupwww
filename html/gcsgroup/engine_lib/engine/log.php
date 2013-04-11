<script>
var selected_doc = -1;

function GetInfo(doc_id, date_month, date_year)
{	window.parent.view.document.location = 'view.php?action=log&date_month='+date_month+'&date_year='+date_year;

        link = document.getElementById('doc_'+doc_id);
        link.className = 'tree_selected';
        if (selected_doc != -1)
        {
                link = document.getElementById('doc_'+selected_doc);
                link.className = 'tree';
        }
        selected_doc = doc_id;
}
</script>
<table height="100%" width="100%" cellpadding="0" cellspacing="0" border="0">
  <tr><td>
    <table cellpadding="3" cellspacing="1" border="0" style="margin-top: 5px;" class="line_blue" width="100%">
      <tr>
        <td class="td_blue2">
        <table cellpadding="0" cellspacing="0" border="0">
          <tr>
            <td width="26" align="center"><a href="menu.php"><img src="img/ico_1.gif" alt="Дерево документов" border="0"></a></td>
            <td width="26" align="center"><a href="menu.php?action=rubrique"><img src="img/ico_2.gif" alt="Рубрикатор" border="0"></a></td>
            <?
            if ($logged['role'] == 'Администратор')
            {
            ?>
            <td width="26" align="center"><a href="menu.php?action=group"><img src="img/ico_8.gif" alt="Польователи" border="0"></a></td>
            <?
            }
            ?>
            <td width="26" align="center"><a href="menu.php?action=tools"><img src="img/ico_3.gif" alt="Инструменты" border="0"></a></td>
            <td width="26" align="center"><a href="menu.php?action=send"><img src="img/ico_4.gif" alt="Рассылки" border="0"></a></td>
            <td width="26" align="center"><a href="menu.php?action=forum"><img src="img/ico_5.gif" alt="Форум" border="0"></a></td>
            <?
            if ($logged['role']=='Разработчик')
            {
            ?>
            <td width="26" align="center"><a href="menu.php?action=tpl"><img src="img/ico_7.gif" alt="Шаблоны" border="0"></a></td>
            <td width="26" align="center"><a href="menu.php?action=style"><img src="img/ico_6.gif" alt="Стили" border="0"></a></td>
            <?
            }
            if ($logged['role'] == 'Администратор')
            {
            ?>
            <td width="26" align="center"><a href="menu.php?action=log"><img src="img/ico_9.gif" alt="Логи" border="0"></a></td>
            <?
            }
            ?>
          </tr>
        </table>
        </td>
      </tr>
    </table>
  </td></tr>
  <tr><td><img src="img/spacer.gif" height="5" width="1" alt="" border="0" /></td></tr>
  <tr><td height="100%">
    <table cellpadding="0" cellspacing="0" border="0" class="line_blue" width="100%" height="100%">
      <tr>
        <td valign="top">
        <div style="height:100%; width: 100%; overflow-y: scroll; overflow-x: scroll; padding: 3px;" id="inner_-1">
        <table width="100%" cellpadding="0" cellspacing="0" border="0">
          <tr><td><img src="img/doc_root.gif" border="0"></td><td colspan="2" width="100%" class="tree_td"><span class="tree">Группы логов</span></td></tr>
<?

$sql = 'SELECT DISTINCT DATE_FORMAT( log_date, "%m" ) as date_month, DATE_FORMAT( log_date, "%Y" ) as date_year
        FROM engine_log
        ORDER BY date_year DESC, date_month DESC;';

if (!$result =mysql_query($sql))
{	die("SQL error ".mysql_error()." in: $sql\n");
}

$month = array(
		'1' => 'Январь',
		'2' => 'Февраль',
		'3' => 'Март',
		'4' => 'Апрель',
		'5' => 'Май',
		'6' => 'Июнь',
		'7' => 'Июль',
		'8' => 'Август',
		'9' => 'Сентябрь',
		'10' => 'Октябрь',
		'11' => 'Ноябрь',
		'12' => 'Декабрь',
	);

$size = @mysql_num_rows($result);
while ($row = @mysql_fetch_array($result, MYSQL_ASSOC))
{	$i++;	if ($size == $i)
        {
                $line_id = 3;
        }
        else
        {
                $line_id = 2;
        }

        $row['date_month'] = (int) $row['date_month'];

	$date_name = $month[$row['date_month']].' '.$row['date_year'];	echo '<tr><td align="center" style="background: url(\'img/line_'.$line_id.'.gif\');" valign="top"><img src="img/spacer.gif" border="0" width="16" height="1"></td><td valign="top"><img src="img/doc_textdoc.gif" border="0"></td><td width="100%" class="tree_td"><a id="doc_'.$i.'" href="javascript:GetInfo('.$i.', \''.$row['date_month'].'\', \''.$row['date_year'].'\');" class="tree">'.$date_name.'</a></td></tr>'."\n";
	$tpl_unix = $tpl_unix + 7*24*60*60;

}
?>
        </table>
        </div>
        </td>
      </tr>
    </table>
  </td></tr>
</table>