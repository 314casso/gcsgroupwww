<?

/*
 *  $Id: edit.php,v 1.5 2004/12/19 22:49:49 dave Exp $
 *
 *  $Log: edit.php,v $
 *  Revision 1.5  2004/12/19 22:49:49  dave
 *  Оптимизация запросов к БД -- избавление от лишних OUTER JOIN
 *
 *  Revision 1.4  2004/12/16 22:15:37  dave
 *  Оптимизация запросов к БД, избавление от ненужных OUTER JOIN'ов
 *
 *
 */
 
$sql="SELECT * FROM `engine_CALC_param` WHERE calc=$id";
$r=mysql_query("$sql") or die (mysql_error());
$param="<table width=600 class=wnd cellpadding=2 cellspacing=0>
	<tr >
		<td class=header colspan=2>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Обозначение&nbsp;параметра&nbsp;в&nbsp;формуле&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td class=header style='text-align:left'>Название параметра</td>
		<td class=header>&nbsp;</td>
		
	</tr>
	";
while($f=mysql_fetch_array($r)){
	if (++$n%2!=0)$bgcolor="bgcolor='#76C5F0'";
	else $bgcolor="";
	if ($f[select]) $f[select]='Да';
	else $f[select]='Нет';
	if ($f[multiselect]) $f[multiselect]='Да';
	else $f[multiselect]='Нет';
	$param.="
		<tr $bgcolor>
			<td style=\"border-top:1 solid \">
				<img border=0 src='img/plus.jpg' style='cursor: hand;' OnClick='{
					if (document.all.add$f[id].style.display==\"none\"){
						document.all.add$f[id].style.display=\"\";
						this.src=\"img/minus.jpg\";
						}
					else{
						document.all.add$f[id].style.display=\"none\";
						this.src=\"img/plus.jpg\";
						}
					}'>
			</td>
			<td style=\"border-top:1 solid ;color:red\"><b>[$f[name]]</b></td>
			<td style=\"border-top:1 solid \"><input size=50 name=name$f[id] value='$f[name]'></td>
			<td style=\"border-top:1 solid \"><a  href='javascript:{document.all.delparam.value=\"$f[id]\";document.forms[0].submit()}'><img src='$engine_htroot/engine/doc_types/FORM/img/del.gif' border=0></a></td>
		</tr>
		<tr $bgcolor id=add$f[id] style='display:none;'>
		<td colspan=7>
			<table cellpadding=0 cellspcing=0 width=300 border=0>
				<tr $bgcolor>
					<td class=top colspan=2></td>
					<td class=header>Текст </td><td  class=header >Значение</td><td  class=header >Действие</td>
				</tr>
				<tr $bgcolor>
					<td class=top style='vertical-align:bottom' colspan=2>добавить&nbsp;вариант:</td>
					<td class=top >
						<input name=npvtext$f[id]>					
					</td>
					<td class=top >
						<input name=npv$f[id]>
					</td>
						<td colspan=2 align=center	>
						<INPUT type=submit value='Добавить' class='but3' onclick='document.all.npv_paramid.value=\"$f[id]\";'>
					</td>
				</tr>
				<tr $bgcolor >
					<td class=top colspan=2>Варианты</td >
					<td colspan=5>
				</tr>
					";
		$sql="select * from  engine_CALC_vals where param=$f[id]";
		$r1=mysql_query("$sql") or die (mysql_error());
		while($f1=mysql_fetch_array($r1)) {
				$param.="<tr><td></td><td></td><td><input name=text{$f[id]}_{$f1[id]} value='$f1[text]'></td> <td><input name=val{$f[id]}_{$f1[id]} value='$f1[val]'></td>
					<td>
<!--						<a  href='javascript:{document.all.delpossval.value=\"$f1[id]\";document.forms[0].submit()}' >удалить</a>-->
							<INPUT type=submit value='Удалить' class='but3' onclick='document.all.delpossval.value=\"$f1[id]\";'>
					</td>
				</tr>";
				}
		$param.="				
				</td>
			</tr>
			</table>
			</td>
		</tr>
		";
		}
		
$param.="</table>";
$sql="select ci.name,d.id from engine_documents d, engine_CATALOGITEM ci where ci.doc_id=d.id
and d.pid=$id order by ci.name";
$items="<table width=100% class=wnd cellpadding=2 cellspacing=0>";
$r=mysql_query("$sql") or die (mysql_error());
while($f=mysql_fetch_array($r)){	
	$items.="<tr><td><a href='view.php?action=showdoc&id=$f[id]'>!!!$f[name]</a></td></tr>";
	}
$items.="</table>";
	


$sql="select d.name, d.id from engine_CATALOG c, engine_documents d where c.doc_id=d.id
and d.id!='$id' order by d.name";
$r=mysql_query("$sql") or die (mysql_error());
while($f=mysql_fetch_array($r)){	
	$copyparam.="<option style=\"color:brown\" value=$f[id]>$f[name]</option>";
	}


$tpl->assign(
						array(
							PARAM		=>  $param,
							FORMULA	=>	$parent_doc_spec[formula],
						)
					);	
	
?>

