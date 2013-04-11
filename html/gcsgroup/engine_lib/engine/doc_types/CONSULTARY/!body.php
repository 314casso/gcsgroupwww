<?

/*
 *  $Id: body.php,v 1.6 2004/12/25 15:32:30 dave Exp $
 *
 *  $Log: body.php,v $
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

global $cons_do,${"cons".$this->id."_name"},${"cons".$this->id."_quest"},${"cons".$this->id."_page"},$page,$doc;
${"cons".$this->id."_page"}+=0;
$page+=0;

if($cons_do==$id ) {
        mysql_query("insert into  engine_CONSULTARY(date,question,author,doc_id) values(NOW(),'".${"cons".$this->id."_quest"}."','".${"cons".$this->id."_name"}."',".$this->id.")") or die (mysql_error());
        }

$do="'?doc=$id&cons_do=$id'";
$DBResult = mysql_query("select count(*) count  from engine_CONSULTARY where doc_id=$id") or die (mysql_error());
                                        $cnt= mysql_fetch_array($DBResult );
                                        $cnt=$cnt[count];

// Определение размера страницы по умолчанию
if (!defined ('ENGINE_CONSULTARY_PAGESIZE'))
    define ('ENGINE_CONSULTARY_PAGESIZE', 5);

if (!defined ('ENGINE_CONSULTARY_PAGENUM_MIDDLE'))
    define ('ENGINE_CONSULTARY_PAGENUM_MIDDLE', 10);

$page_num = intval (($cnt + ENGINE_CONSULTARY_PAGESIZE - 1) / ENGINE_CONSULTARY_PAGESIZE);

if ($page_num >= 1) {
    // Выводить листалку только если число страниц >= 1
    if ($cnt > $page + ENGINE_CONSULTARY_PAGESIZE)
        $pgsF = "<strong><a href='?doc=".$doc."&page=".($page + ENGINE_CONSULTARY_PAGESIZE)."'>Вперед</a></strong>";
    if ($page)
        $pgsB = "<strong><a href='?doc=".$doc."&page=".($page - ENGINE_CONSULTARY_PAGESIZE)."'>Назад</a></strong>";
    if ($page_num >= 2) {
        // Выводить постраничный навигатор если число страниц >= 2
        $pgsM = '';
        for ($i = 0; $i < $page_num; $i++) {
            for ($i = 0; $i < $page_num; $i++) {
                if ($i == intval (($page + ENGINE_CONSULTARY_PAGESIZE - 1) / ENGINE_CONSULTARY_PAGESIZE)) {
                    $pgsM .= ' <strong>'.($i + 1).'</strong> ';
                } else {
                    $pgsM .= " <strong><a href='?doc=".$doc."&page=".$i * ENGINE_CONSULTARY_PAGESIZE."'>".($i + 1)."</a></strong> ";
                }
                $i_new = 0;
                if ($i == 2) {
                    $i_new = ($page_num > ENGINE_CONSULTARY_PAGENUM_MIDDLE) ? (intval ($page_num / 2) - 3 < 0 ? $i : intval ($page_num / 2) - 3) : ($page_num - 4 < $i ? 0 : $page_num - 4);
                } elseif ($page_num > ENGINE_CONSULTARY_PAGENUM_MIDDLE && $i == intval ($page_num / 2)) {
                    $i_new = $page_num - 4 < 0 ? $i : $page_num - 4;
                }
                if ($i_new > $i) {
                    $i = $i_new;
                    $pgsM .= ' ... ';
                }
            }
        }
    }
    $pgs = $pgsB.($pgsB != '' && ($pgsM != '' || $pgsF != '') ? ' | ' : '').
        $pgsM.($pgsF != '' && ($pgsM != '' || $pgsB != '') ? ' | ' : '').$pgsF;
}

$this->body="
<form action=".$do." method=post>
<table align=center cellspacing=0  class=cons_htable>
  <tr class=cons_htable_tr1><td class=cons_htable_td1>Ваше имя</td><td class=cons_htable_td2 ><input class=cons_name name =cons".$this->id."_name></td></tr>
  <tr class=cons_htable_tr2><td class=cons_htable_td1>Ваш вопрос</td><td class=cons_htable_td2 ><textarea  name=cons".$this->id."_quest class=cons_quest></textarea></td></tr>
  <tr class=cons_htable_tr3><td class=cons_htable_td3 colspan=2><input type=submit class=cons_submit  value ='Отправить'></td></tr>
</table>
".$pgs."
<br>

<table class=cons_table cellpadding=3 cellspacing=1>
<input type=hidden name=cons_do value=".$id.">
</form>
";

$sql = 'SELECT author, question, answer, date, date_format(date,"%d.%m.%Y") fdate
        FROM engine_CONSULTARY
        WHERE doc_id='.$id.'
        ORDER BY date DESC
        LIMIT '.$page.','.ENGINE_CONSULTARY_PAGESIZE;

$result = mysql_query($sql) or die (mysql_error());
while($row = mysql_fetch_array($result))
{
         $row['question'] .= "&nbsp;";
         $row['answer']   .= "&nbsp;";
         $this->body.= "
<tr class=cons_table_tr1>
  <td class=cons_table_td1 rowspan=2 valign=top><strong>".$row['author']."</strong> (".$row['fdate'].")</td>
  <td class=cons_table_td2><p align=justify class=cons_question_p>".str_replace("\n" , "</p><p  class=cons_question_p>", $row['question'])."</p></td>
</tr>
<tr class=cons_table_tr2>
  <td class=cons_table_td3><p  class=cons_answer_p>".str_replace("\n", "</p><p  class=cons_answer_p>", $row['answer'])."</p></td>
</tr>";
}

$this->body .= '</table>';
?>
