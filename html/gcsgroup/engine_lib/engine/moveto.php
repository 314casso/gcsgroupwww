
<HTML>
<HEAD>
<TITLE></TITLE><LINK rel="stylesheet" href="style.css" type="text/css" title="CSS style">
<script>

//alert ('<?=$action?>');
</script>

<?
include 'config.inc';

if ($action==''){
	?>
	<script>
	window.parent.document.all.move_to.style.display='none';</script>
	<?
	echo '<TABLE width=100% height=100% border=0><TR><TD valign=middle align=center><IMG SRC="img/belti.gif" WIDTH="133" HEIGHT="40"></TD></TR></TABLE>';
	}
else {
	?>
	<script>window.parent.document.all.move_to.style.display='';</script>
	<?
}
?>
  <link rel=stylesheet href="style.css" type="text/css" title="CSS style">
</HEAD>
<!-- 	color: #005597;
 -->
<STYLE>td{
	color: #FFFFFF;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	font-weight: bold;
	}</STYLE>
<BODY leftmargin="0" topmargin="0" rightmargin="0" bottommargin="0" marginwidth="0" marginheight="0" bgcolor="#003399">
	<TABLE cellspacing="0" width="100%" height="100%" cellpadding="0" border="0">
		<TR>
			<TD><IMG src="img/ugol.gif" alt="" border="0"></TD>
			<TD background="img/fon5.gif" width="100%" height="4">
			</TD>
			<TD><IMG src="img/ugol2.gif" alt="" border="0"></TD>
			<TD rowspan="8" background="img/fon8.gif" width="1px"><IMG src="img/fon8.gif" alt="" border="0">
			</TD>
		</TR>
		<TR>
			<TD valign="top" background="img/fon7.gif" style="background-repeat: y;"><IMG src="img/4.gif" alt="" border="0">
			</TD>
			<TD valign="top">
				<TABLE cellspacing="0" width="100%" height="100%" cellpadding="0" border="0">
					<TR>
						<TD bgcolor="#003399" valign="top" width="100%" height="18" class="WHITE" width="100%">	&nbsp;Перемещение&nbsp;документа
						</TD>
						<TD align=right><A href='#' class="WHITE" onClick="window.parent.document.all.move_to.style.display='none';">x</A>&nbsp;
						</TD>
					</TR>
					<TR>
						<TD width="100%" height="3" background="img/fon2.gif" colspan="2">
						</TD>
					</TR>
					<TR>
						<TD width="100%" height="100%" bgcolor="#FFFFFF" colspan="2" valign=top style="border-bottom:1 solid #006699">
						<CENTER>
<?
if ($action=='choose'){
?>
	<div style = " padding: 10;  width: 100%; height: 216; overflow-y: scroll ;">
	
	
	
	
	
	
	<SCRIPT LANGUAGE="JavaScript">
	var move_to=window.parent.move_to;
	var n=0;
	var d=-1;
	
	
	function swtch(num) {
	//	window.parent.view.document.location='view.php?action=showdoc&id='+num;
	
	//	window.parent.move_to.document.location='move_to.php';
		if (n){
			document.all['a'+n].style.background='#FFFFFF';
			document.all['a'+n].style.color='#005597'; 
			}
		if ( num!=n) {
			document.all['a'+num].style.background='#006699';
			document.all['a'+num].style.color='#FFFFFF'; 
			}
		n=num;
		}
	 document.execCommand("2D-Position", true, true);
	    document.execCommand("MultipleSelection", true, true);
	</SCRIPT>
	<script src="menu.js"></script>
	
	
	<table cellpadding=0 cellspacing=0 border=0 width=100% >
		<tr>
		<td height=25>
			<table cellpadding=0 cellspacing=0 border=0  >
				<tr bgcolor='#FFFFFF' height=25>
					<td class=top align=center  ><a class=link id=a-1 href='#' 
							onclick='{
								swtch(-1,-1);
								}'><img src="images/menu/folder_root.gif" style="border: none; width: 25px; height: 25px;"></a></td>
				</tr>
			</table>
			</td>
		</tr>
			
	<?
	$sql="select * from engine_documents where type='FOLDER' order by pid,name";
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
		global $i,$ids,$pids,$names,$types;
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
			echo "
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
				if ($last) echo "\n".'<td width=25   valign=top><img src="images/menu/bottom_connector.gif" style="border: none; width: 25px; height: 25px;"></td>';			
				else echo "\n".'<td width=25  background="images/menu/vertical_connector.gif" valign=top ><img src="images/menu/both_connector.gif" style="border: none; width: 25px; height: 25px;"></td>';			
				echo "\n".'<td width=25 valign=top>
						<a class=menu  href=\'javascript:{
							swtch('.$ids[$n].',-1);
							}\'><img src="images/menu/item.gif" style="border: none; width: 25px; height: 25px;"></a></td>';			
				}
			else 
				{
				if ($c>=1){
					if ($last) echo " \n<td width=25   valign=top ><a href=\"javascript:hierarchicalMenu_branchManager.act('navigation_menu:$count')\" style=\"text-decoration: none; color: black;\"><img src=\"images/menu/collapsed_marker_bottom.gif\" name=\"navigation_menu:$count\" style=\"border: none; width: 25px; height: 25px;\"></a></td>";
					else echo " \n<td width=25 background=\"images/menu/vertical_connector.gif\" valign=top><a href=\"javascript:hierarchicalMenu_branchManager.act('navigation_menu:$count')\" style=\"text-decoration: none; color: black;\"><img src=\"images/menu/collapsed_marker.gif\" name=\"navigation_menu:$count\" style=\"border: none; width: 25px; height: 25px;\"></a></td>";
					}
				else {
					if ($last) echo "\n".'<td width=25   valign=top><img src="images/menu/bottom_connector.gif" style="border: none; width: 25px; height: 25px;"></td>';			
					else echo "\n".'<td width=25  background="images/menu/vertical_connector.gif" valign=top ><img src="images/menu/both_connector.gif" style="border: none; width: 25px; height: 25px;"></td>';			
					}
				}
	
			echo"
				<td class=top name=td_navigation_menu:$count id=td_navigation_menu:$count align=center  >
				<a class=menu  href='javascript:{
							swtch(".$ids[$n].",-1);
							}'>
					<img border=0  id=img".$ids[$n]." src='$img'></a></td><td style='padding:2px' class=top align=left >
					<a class=menu id=a".$ids[$n]." href='javascript:{
							swtch(".$ids[$n].",-1);
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
	?>
	<tr bgcolor=#FFFFFF >
				<td class=top colspan=3 align=center height=100%>				
				</td>
			</tr>
	<script>
		hierarchicalMenu_branchManager.createBranch('navigation_menu', true);
		</script>		
	</TABLE>
	
	
	</div>
<?
	}
if ($action=='move'){
	$r=mysql_query("update engine_documents set pid=$where where id=$what") or die (mysql_error());
	?>
	<script>
	window.parent.frms.menu.location='menu.php';
	document.location='moveto.php';
	</script>
	<?
	}
?>
	
	
	

						
						
						
						</CENTER>
						</TD>
					</TR>
					<TR>
						<TD bgcolor="#FFFFFF" width=50%	 valign=top align=center>
						<br>
							<INPUT type="button" value="- ОК -" class="but2" onclick="{
								if (n){
									document.location='moveto.php?action=move&what=<?=$id?>&where='+n;
									}
								}">
						<br>
						</TD>
						<TD bgcolor="#FFFFFF" valign=top align=center>
						<br>
							<INPUT type="button" value="- CANCEL -" class="but2" onclick="{
									document.location='moveto.php';
								}">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<br>
						</TD>
					</TR>
				</TABLE>
			</TD>
			<TD background="img/fon4.gif" valign="top"><IMG src="img/5.gif" alt="" border="0"></TD>
		</TR>
		<TR>
			<TD bgcolor="#D4D0C8">
			</TD>
			<TD background="img/fon5.gif" height="4">
			</TD>
			<TD valign="bottom"><IMG src="img/ugol4.gif" alt="" border="0"></TD>
		</TR>
		<TR>
			<TD colspan="3" background="img/fon8.gif" height="2">
			</TD>
		</TR>
	</TABLE>
</BODY>
</HTML>
