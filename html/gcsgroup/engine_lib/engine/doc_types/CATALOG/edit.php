<?

/*
 *  $Id: edit.php,v 1.8 2004/12/19 22:50:27 dave Exp $
 *
 *  $Log: edit.php,v $
 *  Revision 1.8  2004/12/19 22:50:27  dave
 *  ����������� �������� � �� -- ���������� �� ������ OUTER JOIN
 *
 *  Revision 1.7  2004/12/16 22:16:12  dave
 *  ����������� �������� � ��, ���������� �� �������� OUTER JOIN'��
 *
 */


/*
<!-- 	<tr>
		<td><input name=name$f[id] value='$f[name]'></td>
		<td><input name=type$f[id] value='$f[type]'></td>
		<td><input type =checkbox name=select $f[id] value='$f[select]'></td>
		<td><input type =checkbox name=multiselect $f[id] value='$f[multiselect]'></td>
	</tr>
 -->*/

$sql="select * from engine_CATALOG_param where catalog=$id";
$r=mysql_query("$sql") or die (mysql_error());
$param = '<table width="100%" class="line" cellpadding="3" cellspacing="1">
<tr>
  <th>&nbsp;</th>
  <th>�����������</th>
  <th>��������</th>
  <th>���</th>
  <th>���������� �� ������</th>
  <th>������������</th>
  <th>&nbsp;</th>
</tr>
';

while($f=mysql_fetch_array($r))
{	if (++$n%2!=0)
	{		$class_id = 1;
	}
	else
	{		$class_id = 2;
	}

	if ($f[select])
	{		$f[select]='��';
	}
	else
	{		$f[select]='���';
	}

	if ($f[multiselect])
	{		$f[multiselect]='��';
	}
	else
	{		$f[multiselect]='���';
	}

	$param.='
	<tr class="row'.$class_id.'">
		<td>&nbsp;';
	if ($f[select]=="��" || $f[multiselect]=='��')
	{
		$param .= "<img border=0 style='cursor: hand;' src='img/plus.gif' OnClick='{
			if (document.all.add$f[id]_1.style.display==\"none\"){";

		if ($f[multiselect]=='��')
			$param .= "
					document.all.add$f[id]_0.style.display=\"\";";
		$param .= "
				document.all.add$f[id]_1.style.display=\"\";
				document.all.add$f[id]_2.style.display=\"\";
				this.src=\"img/minus.gif\";
				}
			else{";
		if ($f[multiselect]=='��')
			$param .= "
					document.all.add$f[id]_0.style.display=\"none\";";
		$param .= "
				document.all.add$f[id]_1.style.display=\"none\";
				document.all.add$f[id]_2.style.display=\"none\";
				this.src=\"img/plus.jpg\";
				}
			}'>";
	} else {
		$param.="&nbsp;";
	}
	$param.='
  </td>
  <td align="center"><b>fld'.$f['id'].'</b></td>
  <td><input class="com_input" name="name'.$f['id'].'" value="'.htmlspecialchars($f['name']).'"></td>
  <td align="center">'.$f['type'].'</td>
  <td align="center">'.$f['select'].'</td>
  <td align="center">'.$f['multiselect'].'</td>
  <td align="center"><a href="javascript:{document.all.delparam.value=\''.$f['id'].'\';document.forms[0].submit()}" class="com_link">�������</a></td>
</tr>';

	if ($f[select]=="��" || $f[multiselect]=='��')
	{
		if ($f[multiselect]=='��')
			$param.="
			<tr $bgcolor id=add$f[id]_0 style='display:none;'>
			<td></td>
			<td colspan=7>
				<table cellpadding=0 cellspcing=0 width=300 border=0>
					<tr $bgcolor>
						<td class=top>������</td>
						<td colspan=5><textarea cols=60 rows=3 name=ms_format$f[id]>$f[ms_format]</textarea></td>
					</tr>
				</tr>
				</table>
				</td>
					";
			$param.="
			<tr $bgcolor id=add$f[id]_1 style='display:none;'>
				<td></td>
				<td class=top>�������� ���������� ��������:</td>
			";
			if ($f['type']=="�����������")
			{				$param .= '<td colspan="5"><input name="npv'.$f['id'].'"><input type="file" name="npv_pic'.$f['id'].'">';
			}

			if ($f['type']=="�����")
			{				$param .= '<td colspan="5"><input name="npv'.$f['id'].'" class="com_input">';
			}

			$param .= ' <input type=submit class="com_button" value="��������" onclick="document.all.npv_paramid.value=\''.$f['id'].'\';">
				</td>
			</tr>
			';
			$param.="
				<tr $bgcolor id=add$f[id]_2 style='display:none;'>
					<td></td>
					<td class=top>���������� ��������</td >
					<td colspan=5>
					<table>
					";
			$sql="select * from  engine_CATALOG_possvals where param=$f[id]";
			$r1=mysql_query("$sql") or die (mysql_error());
			while($f1=mysql_fetch_array($r1))
			{
				if ($f[type]=="�����������")
				{
						$pic="";
						if (file_exists("$engine_show_root/engine/pics/catalog/pv_".$f1[id].".jpg"))
							$pic="<img src='$engine_show_htroot/engine/pics/catalog/pv_".$f1[id].".jpg'>";
						if (file_exists("$engine_show_root/engine/pics/catalog/pv_".$f1[id].".gif"))
							$pic="<img src='$engine_show_htroot/engine/pics/catalog/pv_".$f1[id].".gif'>";
						$param.="<tr><td>$f1[val]</td><td>$pic</td>";
				}

				if ($f['type'] == "�����")
				{
					$param .= '<tr><td>'.$f1['val'].'</td>';
				}

				$param .= '<td><a href="javascript:{document.all.delpossval.value=\''.$f1['id'].'\';document.forms[0].submit()}" class="com_link">�������</a></td>';
			}
				$param.="
					</tr>
					</table>
					</td>
			</tr>
			";

			}
		}
		$param.="</table>";
$sql="select ci.ord,ci.id ciid,ci.name,d.id from engine_documents d, engine_CATALOGITEM ci where ci.doc_id=d.id
and d.pid=$id order by ci.ord,ci.name";

$items='<table width="100%" class="line" cellpadding="3" cellspacing="1">
<tr>
  <th width="80%">��������</th>
  <th width="20%">������� ������</th>
  <th colspan="2">��������</th>
</tr>
';
$r=mysql_query("$sql") or die (mysql_error());
while($f=mysql_fetch_array($r)){
	if (++$n%2!=0)
	{
		$class_id = "2";
	}
	else
	{
		$class_id = "1";
	}

	$items .= '<tr class="row'.$class_id.'">
  <td><a class="com_link" href="view.php?action=showdoc&id='.$f['id'].'">'.(empty($f['name']) ? '��� �������� '.$f['id'] : $f['name']).'</a></td>
  <td align="center"><input name="ord'.$f['ciid'].'" value="'.$f['ord'].'" class="com_input" size="2"></td>
  <td><a class="com_link" href="view.php?action=showdoc&id='.$f['id'].'">�������������</a></td>
  <td><a class="com_link" href="javascript:{document.all.delitem.value=\''.$f['id'].'\'; document.forms[0].submit();}">�������</a></td>
</tr>
';
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
							COPYPARAM		=>	$copyparam,
							FRM				=>  $frm,
							PARAM			=>  $param,
							ITEMS			=>  $items,
							ICOUNT			=>	$parent_doc_spec[icount],
							PREFIX			=>	$parent_doc_spec[prefix],
							POSTFIX			=>	$parent_doc_spec[postfix],
							SHORT_FORMAT2	=>	$parent_doc_spec[short_format2],
							SHORT_FORMAT	=>	$parent_doc_spec[short_format],
							FULL_FORMAT		=>	$parent_doc_spec[full_format],
							FILTER		=>	$parent_doc_spec[filter],
							EMAIL		=>	$parent_doc_spec[email]
						)
					);

?>