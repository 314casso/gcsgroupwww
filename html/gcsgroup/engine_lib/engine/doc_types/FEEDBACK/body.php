<?
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

if  ($cnt>$page+5) $pgsF="<strong><a href='?doc=".$doc."&page=".($page+5)."'>Предыдущая страница</a></strong>";
if  ($page) 	$pgsB="<strong><a href='?doc=".$doc."&page=".($page-5)."'>Следующая страница</a></strong>";
if ($pgsB!="" and $pgsF!="") $pgs="$pgsF | $pgsB";
else $pgs=$pgsB.$pgsF;

$this->body="
<form action=$do method=post>
<table align=center cellspacing=0  class=cons_htable>
<tr class=cons_htable_tr1><td class=cons_htable_td1 >{$this->spec[text1]}</td><td class=cons_htable_td2 ><input class=cons_name name =cons".$this->id."_name></td></tr>
<tr class=cons_htable_tr2><td class=cons_htable_td1 >{$this->spec[text2]}</td><td class=cons_htable_td2 ><textarea  name=cons".$this->id."_quest class=cons_quest></textarea></td></tr>
<tr class=cons_htable_tr3><td class=cons_htable_td3  colspan=2><input type=submit class=cons_submit  value ='{$this->spec[btntext]}'></td></tr>
</table>
$pgs
<br>
<table class=cons_table cellpadding=3 cellspacing=1>
<input type=hidden name=cons_do value=$id>
</form>
";
$r= mysql_query("select author,question,answer,date,date_format(date,'%d.%m.%Y') fdate  from engine_CONSULTARY where doc_id=$id order by date desc limit $page,5") or die (mysql_error());
while($f = mysql_fetch_array($r)){
	 $f[question].="&nbsp;";
	 $f[answer].="&nbsp;";
	 $this->body.= "
	 <tr class=cons_table_tr1>
	 			<td  class=cons_table_td1 rowspan=2 valign=top><strong>$f[author]</strong> ($f[fdate])</td>
				<td  class=cons_table_td2><p align=justify class=cons_question_p>".str_replace("
","</p><p  class=cons_question_p>",$f[question])."</p></td>
	  </tr>
		<tr  class=cons_table_tr2>
			<td  class=cons_table_td3><p  class=cons_answer_p>".str_replace("
","</p><p  class=cons_answer_p>",$f[answer])."</p></td>
		</tr>";
	}

 $this->body.='</table>';
?>
