<?

mysql_num_rows($tables=mysql_list_tables($db_name)); 
while (list($tbl)=mysql_fetch_array($tables)) 
{ 

if (!substr_count($tbl,"engine"))
    if ($parent_doc_spec[tblname]==$tbl)
        $tblname.="<option selected>".$tbl."</option>"; 
    else {
        	$tblname.="<option>".$tbl."</option>"; 
		$tbl_null = $tbl;
    }
}
if ($parent_doc_spec[tblname] == '-1') {
	$parent_doc_spec[tblname] = $tbl_null;
	$tblname = str_replace("<option>".$tbl_null,"<option selected>".$tbl_null,$tblname);
}


if ($parent_doc_spec[tblname]){
    $result = mysql_list_fields($db_name, $parent_doc_spec[tblname]); 
    $Nr = mysql_num_fields($result); 
    for ($count = 0; $count < $Nr; $count++) { 
        $fld=mysql_field_name($result, $count);
//      if ($fld!='id')
            $flds.="<td class=top>".$fld."</td>" ;
        } 
    $flds.="<td class=top>Удалить</td>" ;
    $sql="select * from $parent_doc_spec[tblname]";
    $r=mysql_query("$sql") or die (mysql_error());
    $i=0;
    while($f=mysql_fetch_array($r)){
        $i++;
        $values.="<tr>\n";
        $j=0;
        for($j=0;$j<mysql_num_fields($result);$j++){
            $v=$f[$j];
            $v=str_replace("'","\\'",$v);
            $values.="  <td class=top><input name=fld{$i}_".($j+1)." value='$v'></td>\n";
            }
        $values.="  <td class=top><input name=del{$i}_".($j+1)." type=Checkbox></td>\n";
        $values.="</tr>\n";
        }
    $values.="<tr><td colspan=".mysql_num_fields($result).">Новая запись</td></tr><tr>\n";
    $j=0;
    for($j=0;$j<mysql_num_fields($result);$j++){
        $values.="  <td class=top><input name=fld".($j+1)."_n value=''></td>\n";
        }
    $values.="</tr>\n";
        
        
    $values.="<input type=hidden name=len value=".($j).">\n";
    $values.="<input type=hidden name=cnt value=".($i).">\n";
    }

                $tpl->assign(
                        array(
                            FORMAT=>$parent_doc_spec[format],
                            BEGIN=>$parent_doc_spec[begin],
                            END=>$parent_doc_spec[end],
                            TBL =>  $tblname,
                            FLDS=>$flds,
				 TABLE_OLD=>$parent_doc_spec[tblname],
                            VALUES =>$values
                        )
                    );

?>
