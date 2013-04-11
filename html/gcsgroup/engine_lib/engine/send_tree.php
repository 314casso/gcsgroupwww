<?
$tree='
<div  id=doclst
style = "display:none;background-color:#C1C1C1; padding: 10;height:300 ;  width: 300; overflow-y: scroll ;overflow-x: scroll ;
background-color:#FFFFFF;
border-left:1 solid #000000;
border-top:1 solid #000000;
border-right:1 solid #000000;
border-bottom:1 solid #000000;
padding:5;
" >
<table cellpadding=0 cellspacing=0 border=0 width=100% height=100% 
>
	<tr>
	<td height=25>
		<table cellpadding=0 cellspacing=0 border=0  >
			<tr bgcolor=#FFFFFF height=25>
				<td class=top align=center  ><a class=link id=a-1 href="#" 
						onclick=\'{
							swtch1(-1,"Корень");
							}\'><img src="images/menu/folder_root.gif" style="border: none; width: 25px; height: 25px;"><!-- <B>./</B> --></a></td>
			</tr>
		</table>
		</td>
	</tr>
';
$sql="select * from engine_documents order by pid,name";
$r=mysql_query($sql) or die("SQL error ".mysql_error()." in: $sql\n"); 

$i=0;
while($f=mysql_fetch_array($r)){
	$ids[$i]=$f[id];
	$pids[$i]=$f[pid];
	$names[$i]=$f[name];
	$types[$i]=$f[type];
	$i++;
	}


function tree($id,$n,$level,$l='',$count='') {
	global $i,$ids,$pids,$names,$types,$tree;
//	if ($count=='2.') exit;
	if ($n!=-1)	{
		$img="img/1x1.gif";
		$fld=0;
		$c=0;
		for ($k=0;$k<$i;$k++){
			if ($pids[$k]==$id) {
				$c++;
				}
			}
		for ($k=0;$k<$i;$k++){
			if ($pids[$k]==$pids[$n]) {
				if ($types[$k]=='FOLDER' )
					$last=$k;
				}
			}
		for ($k=0;$k<$i;$k++){
			if ($pids[$k]==$pids[$n]) {
				if ($types[$k]!='FOLDER' )
					$last=$k;
				}
			}
		if ($last==$n)$last=true;
		else $last=false;
	
		if (strstr($count,'.'))$vis='style="display: none;"';
		else $vis='';
		$tree.= "
				<tr bgcolor=#FFFFFF  id='navigation_menu:$count' $vis>
			<td><table cellpadding=0 cellspacing=0 border=0>

		<tr >
		$l";		
		if ($types[$n]=='FOLDER'){
			$img="images/menu/folder.gif";
			$fld=1;
			if ($last)$l1=$l."\n<td width=25></td>";
			else $l1=$l."\n".'<td width=25 background="images/menu/vertical_connector.gif"><img src="images/menu/vertical_connector.gif" style="border: none; width: 25px; height: 25px;"></td>';
			}


		
		if ($types[$n]!='FOLDER'){
			global $engine_root,$engine_htroot;
			$itm="images/menu/item.gif";
//			$tree.= "$engine_root/engine/doc_types/{$types[$n]}/icon.gif";
			if (file_exists("$engine_root/engine/doc_types/{$types[$n]}/icon.gif")){
				$itm="$engine_htroot/engine/doc_types/{$types[$n]}/icon.gif";
				}
			if ($last) $tree.= "\n".'<td width=25   valign=top><img src="images/menu/bottom_connector.gif" style="border: none; width: 25px; height: 25px;"></td>';			
			else $tree.= "\n".'<td width=25  background="images/menu/vertical_connector.gif" valign=top ><img src="images/menu/both_connector.gif" style="border: none; width: 25px; height: 25px;"></td>';			
			$tree.= "\n".'<td width=25 valign=top>
					<a class=menu  href=\'javascript:{
						swtch1('.$ids[$n].',\"'.$names[$n].'\");
						}\'><img src="'.$itm.'" style="border: none; width: 25px; height: 25px;"></a></td>';			
			}
		else 
			{
			if ($c>=1){
				if ($last) $tree.= " \n<td width=25   valign=top ><a href=\"javascript:hierarchicalMenu_branchManager.act('navigation_menu:$count')\" style=\"text-decoration: none; color: black;\"><img src=\"images/menu/collapsed_marker_bottom.gif\" name=\"navigation_menu:$count\" style=\"border: none; width: 25px; height: 25px;\"></a></td>";
				else $tree.= " \n<td width=25 background=\"images/menu/vertical_connector.gif\" valign=top><a href=\"javascript:hierarchicalMenu_branchManager.act('navigation_menu:$count')\" style=\"text-decoration: none;  color: black;\"><img src=\"images/menu/collapsed_marker.gif\" name=\"navigation_menu:$count\" style=\"border: none; width: 25px; height: 25px;\"></a></td>";
				}
			else {
				if ($last) $tree.= "\n".'<td width=25   valign=top><img src="images/menu/bottom_connector.gif" style="border: none; width: 25px; height: 25px;"></td>';			
				else $tree.= "\n".'<td width=25  background="images/menu/vertical_connector.gif" valign=top ><img src="images/menu/both_connector.gif" style="border: none; width: 25px; height: 25px;"></td>';			
				}
			}

		$tree.="
			<td class=top name=td_navigation_menu:$count id=td_navigation_menu:$count align=center  >
			<a class=menu   href='javascript:{
						swtch1(".$ids[$n].",'".$names[$n]."');
						}'>
				<img border=0  id=img".$ids[$n]." src='$img'></a></td><td style='padding:2px' class=top align=left >
				<a style='	
				
				
				
				
				
				
				
				
				
				
				
				
				font-weight: normal;
				
				
				
				
				
				
				
				
				
				
				
				
				' class=menu id=a".$ids[$n]." href='javascript:{
						swtch1(".$ids[$n].",\"".$names[$n]."\");
							}'>&nbsp".$names[$n]."</a> 
						<input type=hidden id=fld".$ids[$n]." value=$fld>
			</td>
		</tr>
	</table></td></tr>			
		";
		}
	if ($types[$n]=='FOLDER' || $n==-1) {
		$cnt=1;
		if (!$count)$dot='';else $dot='.';
		for ($k=0;$k<$i;$k++){
			if ($pids[$k]==$id) {
				if ($types[$k]=='FOLDER' )
					tree($ids[$k],$k,$level+1,$l1,$count.$dot.($cnt++));
				}
			}
		for ($k=0;$k<$i;$k++){
			if ($pids[$k]==$id) {
				if ($types[$k]!='FOLDER' )
					tree($ids[$k],$k,$level+1,$l1,$count.$dot.($cnt++));
				}
			}
		}
	}

	tree(-1,-1,-1);
$tree.='
<tr bgcolor=#FFFFFF >
			<td class=top colspan=3 align=center height=100%>				
			</td>
		</tr>
<script>
	hierarchicalMenu_branchManager.createBranch(\'navigation_menu\', true);
	</script>		
</TABLE>
</div>';
?>
