<!-- 					<tr>
								<td class=top >Автор (дата)</td>
					</TR>
					<TR>
								<td class=top >Текст вопроса</td>
					</TR>
					<TR>
								<td class=top >Текст ответа</td>
							</tr>
 -->
	<?

					if($del){
						$DBResult = mysql_query("delete from engine_FEEDBACK_questions where doc_id=$id and id=$del") or die (mysql_error());
						}
					$DBResult = mysql_query("select count(*) count  from engine_FEEDBACK_questions where doc_id=$id") or die (mysql_error());
					$cnt= mysql_fetch_array($DBResult );
					$cnt=$cnt[count];
					$page+=0;
					$DBResult = mysql_query("select * from engine_FEEDBACK_questions where doc_id=$id order by date desc limit $page,5") or die (mysql_error());
					$i=0;$c=mysql_num_rows($DBResult );
					while($qst = mysql_fetch_array($DBResult )){
						$qsts.="
							<tr>
								<td valign=top class=top width=100%>- Вопрос задал(а) $qst[author] ($qst[date])
								<a class=link href='view.php?action=showdoc&id=$id&page=$page&del=$qst[id]'>Удалить</a>


								</td>
					</TR>
					<TR>
								<td width=100%><textarea name=q$i class=header2>$qst[question]</textarea></td>
					</TR>
					<tr><td class=top>- Ответ</td></tr>
					<TR >
								<td><textarea name=a$i  class=header3 style='height:200px'>$qst[answer]</textarea></td>
								<input type=hidden name=id$i value=$qst[id]>
							</tr>
							";
						if ($i<($c-1)){$qsts.="
						<tr>
							<TD>
<HR color=#005597 size=1 width=100%>
							</TD>
							</tr>
						";}
						$i++;

						}
					if  ($page) 	$pgsB="<strong><a  name=pp class=link href='view.php?action=showdoc&id=$id&page=".($page-5)."#np'>Предыдущая страница</a></strong>";
					if  ($cnt>$page*5-1) $pgsF="<strong><a name=np class=link href='view.php?action=showdoc&id=$id&page=".($page+5)."#pp'>Следующая страница</a></strong>";
					if ($pgsB!="" and $pgsF!="") $pgs="$pgsB | $pgsF";
					else $pgs=$pgsB.$pgsF;

					$tpl->assign(
						array(
								CONS_PAGES		=>$pgs,
								CONS_QUESTS	  =>$qsts ,
								TXT1		=>$parent_doc_spec[text1],
								TXT2		=>$parent_doc_spec[text2],
								BTNTXT		=>$parent_doc_spec[btntext]
								)
						);
?>