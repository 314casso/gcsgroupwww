<?

$sql="select * from engine_documents where visible=1 order by ord";
$r=mysql_query($sql) or die("SQL error ".mysql_error()." in: $sql\n");

$i=0;
while($f=mysql_fetch_array($r)){
        $ids[$i]=$f[id];
        $pids[$i]=$f[pid];
        $names[$i]=$f[name];
        $types[$i]=$f[type];
	 if ($names[$i]) $name_arr[$names[$i]] = $ids[$i];
       //echo "$names[$i] $pids[$i] $ids[$i]<br>";
        $i++;
        }
function tree($ids,$pids,$names,$types,$i,$folder,$id,$n,$cnt){
        if ($types[$n]=='FOLDER' or $n==-1){
                echo "<table cellpadding=0 cellspacing=0 border=0>";
                //считаем принадлежащие документы
                for($k=0;$k<$i;$k++) {
                        if($pids[$k]==$id and $types[$k]!='NEW'){
                                $count++;
                                }
                        }


                echo "<tr>";
                if ($id!=$folder){
                        if ($cnt)
                                echo "<td valign=top width=25 rowspan=".($count+1)." background='/images/menu/vertical_connector.gif' width=25 height=25><img src='/images/menu/both_connector.gif' border=0></td>";
                        else
                                echo "<td valign=top width=25 rowspan=".($count+1)."  width=25 height=25><img src='/images/menu/bottom_connector.gif' border=0></td>";
                        echo "<td><img src='/images/menu/folder.gif' border=0></td>";
                        }
                else {
                                echo "<td><img src='/images/menu/folder_root.gif' border=0></td>";
                        }
                echo "<td colspan=2 width=100%>$names[$n]</td>";
                echo "</tr>";
                for($k=0;$k<$i;$k++) {
                        if($pids[$k]==$id and $types[$k]=='FOLDER'){
                                $count--;
                                echo "<tr>";
                                echo "<td colspan=3>";
                                tree($ids,$pids,$names,$types,$i,$folder,$ids[$k],$k,$count);
                                echo "</td>";
                                echo "</tr>";
                                }
                        }

                for($k=0;$k<$i;$k++) {
                        if($pids[$k]==$id){
                                if ($types[$k]!='FOLDER' and $types[$k]!='NEW'){
                                        $count--;
                                        echo "<tr>";
                                        if ($count)
                                                echo "<td width=25  valign=top  background='/images/menu/vertical_connector.gif' width=25 height=25><img src='/images/menu/both_connector.gif' border=0></td>";
                                        else
                                                echo "<td valign=top   width=25 height=25><img src='/images/menu/bottom_connector.gif' border=0></td>";
                                        echo "<td><img src='/images\menu\item.gif' border=0></td>";
                                        echo "<td width=100%><a href='".(geturl($ids[$k]))."'>".$names[$k]."</a></td>";
                                        echo "</tr>";
                                        }
                                }
                        }
                echo "</table>";

                }
        }

if (!is_numeric($folder) && $name_arr[$folder]) $folder = $name_arr[$folder];

if (!$folder){
        $folder=-1;
        $n=-1;
        }
else {
        for($k=0;$k<$i;$k++)
                if ($ids[$k]==$folder) $n=$k;
        }
	 //$name_arr[$names[$i]] = $ids[$i];

tree($ids,$pids,$names,$types,$i,(int)$folder,(int)$folder,$n,0);

?>