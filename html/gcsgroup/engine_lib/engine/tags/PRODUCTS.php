<?
$id=$doc->id;
$cols[]="F2F2F2";
$cols[]="FFFFFF";
$sql="SELECT id, name, type, resume FROM engine_documents WHERE pid='$id' order by ord";
$res=mysql_query($sql) or die(mysql_error());
echo "<table cellspacing=1 cellpadding=1 width=100%>";
while ($r=mysql_fetch_array($res)) {
	echo "<tr><td valign=top>";
	$i=0;
	echo "<table cellspacing=1 cellpadding=1 width=100%>";
	if ($id==181) { 
	echo "<tr><td><a class=cath href='/show.php?doc=".$r['id']."'>".$r['name']."</td></tr>"; 
	} else{
	echo "<tr><td bgcolor=".$cols[$i]."><a href='/show.php?doc=".$r['id']."' style='color: #0F2393'>".$r['name']."</a></td></tr>";
		$i++;
	}
	if ($id==181) {
	$cat_id=$r['id'];
	$sql2="SELECT id, name FROM engine_documents WHERE pid='$cat_id' AND visible=1";
	$res2=mysql_query($sql2) or die(mysql_error());
	while ($r2=mysql_fetch_array($res2)) {
		echo "<tr><td bgcolor=".$cols[$i]."><a href='/show.php?doc=".$r2['id']."' style='color: #0F2393'>".$r2['name']."</a></td></tr>";
		if ($i==1) $i=0; else $i=1;
		}
	}
	echo "</table>";

	if (intval($r['resume'])) {
		$picid=intval($r['resume']);
        	$imgdoc=new Document($picid); 
		$pict=$imgdoc->body;
		}
		else {
		$pict="";
		}
	echo "</td><td align=center>".$pict."</td></tr>";
	}
echo "</table>";
?>