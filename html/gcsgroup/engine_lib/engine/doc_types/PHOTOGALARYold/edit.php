<script>
var fcell=0;
var fcellinput=0;
<?

	$sql="SELECT
			(max( x ) + 1) cols,
			(max( y ) + 1) rows
		 from engine_PHOTOGALARYold_cells where doc_id=$parent_doc[id]";


	list($cols, $rows)=mysql_fetch_array(mysql_query($sql));
//	if ($page/$cols>$rows ||$page%$parent_doc_spec[rowsperpage])
	//	$page=0;
	if ($parent_doc_spec[rowsperpage]!=0){
		$page=(int)$page;
		$limit = "limit $page,".($parent_doc_spec[rowsperpage]*$cols);
		$count=$rows*$cols;
		$p=0;
		if ($page!=0)
			$pages.="<a href='view.php?action=showdoc&id=$id&page=".($page-$parent_doc_spec[rowsperpage]*$cols)."'><<<</a>&nbsp;&nbsp;";
		while ($p<$count){
			$i++;
			if ($p!=$page)
				$pages.="<a href='view.php?action=showdoc&id=$id&page=$p'>$i</a>&nbsp;&nbsp;";
			else
				$pages.="<b>$i</b>&nbsp;&nbsp;";
			$p+=$parent_doc_spec[rowsperpage]*$cols;
			}
		if ($page!=($p-$parent_doc_spec[rowsperpage]*$cols)){
			$pages.="<a href='view.php?action=showdoc&id=$id&page=".($page+$parent_doc_spec[rowsperpage]*$cols)."'>>>></a>&nbsp;&nbsp;";
			$rows=$parent_doc_spec[rowsperpage];//min($rows%$parent_doc_spec[rowsperpage],$parent_doc_spec[rowsperpage]);
			}
		else {
			if (!($rows=$rows%$parent_doc_spec[rowsperpage]))
				$rows=$parent_doc_spec[rowsperpage];
			}
		}





	$sql="select * from engine_PHOTOGALARYold_cells where doc_id=$parent_doc[id] order by  y,x $limit";
	$r=mysql_query("$sql") or die (mysql_error());
	while($f=mysql_fetch_array($r)){
		$cells[$f[x]][$f[y]][value]=$f[value];
		$cells[$f[x]][$f[y]][colspan]=$f[colspan];
		$cells[$f[x]][$f[y]][rowspan]=$f[rowspan];
		$cells[$f[x]][$f[y]][ids]=$f[id];
		}
?>
</script>

<?
	$table="";
	$table.="<table cellspacing=1 cellpadding=1 style='border:1 solid black' bgcolor=#e9e9e9>\n";
	$table.="<tr>\n";
	$table.="<td align=center bgcolor='#c3c3c3'>&nbsp;</td>\n";

	for ($x=1;$x<=$cols;$x++){
		$table.="<td width=160 style=\"cursor:hand\" align=center bgcolor='#c3c3c3'
						onmouseover='{
							this.style.background=\"red\";
							this.innerHTML=\"Удалить\";
							}'
						onmouseleave='{
							this.style.background	=\"#c3c3c3\";
							this.innerHTML=\"<b>".($x)."</b>\";
							}'
						onclick='{
							if (window.confirm(\"Удалить столбец?\")) {
								document.all.del_col.value=\"".($x-1)."\";
								document.forms.editor.submit();
								}
							}'
						>
						<b>".($x)."</b></td>\n";
		}
	$table.="</tr>\n";
	if ($cols!=0) $my=$page/$cols;
	else $my=0;
	for ($y=$my;$y<$my+$rows;$y++){
		$table.="<tr>\n";
		$cspn=0;
		$table.="<td width=50	 bgcolor='#c3c3c3' style=\"cursor:hand\" align=center bgcolor='#c3c3c3'
						onmouseover='{
							this.style.background=\"red\";
							this.innerHTML=\"Удалить\";
							}'
						onmouseleave='{
							this.style.background	=\"#c3c3c3\";
							this.innerHTML=\"<b>".($y+1)."</b>\";
							}'
						onclick='{
							if (window.confirm(\"Удалить строку?\")) {
								document.all.del_row.value=\"".($y)."\";
								document.forms.editor.submit();
								}
							}'
						><b>".($y+1)."</b></td>\n";
		for ($x=0;$x<$cols;$x++){
			if (!$cspn && !${"rspan$x"}){
				if ($cells[$x][$y][colspan]){
					$cspn=$cells[$x][$y][colspan];
					if ($cspn>$cols-$x-1)$cspn=$cols-$x-1	;
					$cells[$x][$y][colspan]=$cspn;
					}

				if ($cells[$x][$y][rowspan]){
					for ($k=0;$k<=$cells[$x][$y][colspan];$k++){
						if (!$k)
							${"rspan".($x+$k)}=$cells[$x][$y][rowspan];
						else
							${"rspan".($x+$k)}=$cells[$x][$y][rowspan]+1;
						if (${"rspan".($x+$k)}>$rows-$y)${"rspan".($x+$k)}=$rows-$y	;
						}
					$cells[$x][$y][rowspan]=${"rspan".$x};
					}


				$table.="<td bgcolor=#f6f6f6 rowspan=".($cells[$x][$y][rowspan]+1)." colspan=".($cells[$x][$y][colspan]+1)." style='border:1 solid black' x=$x y=$y v=\"".$cells[$x][$y][value]."\"	 cs=\"".$cells[$x][$y][colspan]."\" rs=\"".$cells[$x][$y][rowspan]."\"
	 >\n";
				$table.="
					<textarea rows=1 style='height:".(30*(${"rspan$x"}+1)+3*(${"rspan$x"}-1))."px; width:".(160*($cspn+1)+3*($cspn-1))."px' name=val".$x."$y OnFocus=\"javascript:{
									this.parentElement.style.border='1 solid red';
									if (fcell)
										fcell.style.border='1 solid black';
									fcell=this.parentElement;
									fcellinput=this;
									document.all.cell_x.value=$x;
									document.all.cell_y.value=$y;
									document.all.cell_value.value=this.parentElement.v	;
									document.all.cell_colspan.value=this.parentElement.cs	;
									document.all.cell_rowspan.value=this.parentElement.rs	;
//									alert (document.images.cellimg.src);
									document.images.cellimg.src='";

									if (file_exists("$engine_show_root/engine/pics/PHOTOGALARY/pic{$parent_doc[id]}_".$cells[$x][$y][ids].".gif")){
										$table.="$engine_show_htroot/engine/pics/PHOTOGALARY/pic{$parent_doc[id]}_".$cells[$x][$y][ids].".gif";
										}
									else if (file_exists("$engine_show_root/engine/pics/PHOTOGALARY/pic{$parent_doc[id]}_".$cells[$x][$y][ids].".jpg")){
										$table.="$engine_show_htroot/engine/pics/PHOTOGALARY/pic{$parent_doc[id]}_".$cells[$x][$y][ids].".jpg";
										}
									else
										$table.="$engine_show_htroot/engine/pics/PHOTOGALARY/0.gif";
				$table.=			"';
									document.images.cellimgbig.src='";

									if (file_exists("$engine_show_root/engine/pics/PHOTOGALARY/pic{$parent_doc[id]}_".$cells[$x][$y][ids]."_big.gif")){
										$table.="$engine_show_htroot/engine/pics/PHOTOGALARY/pic{$parent_doc[id]}_".$cells[$x][$y][ids]."_big.gif";
										}
									else if (file_exists("$engine_show_root/engine/pics/PHOTOGALARY/pic{$parent_doc[id]}_".$cells[$x][$y][ids]."_big.jpg")){
										$table.="$engine_show_htroot/engine/pics/PHOTOGALARY/pic{$parent_doc[id]}_".$cells[$x][$y][ids]."_big.jpg";
										}
									else
										$table.="$engine_show_htroot/engine/pics/PHOTOGALARY/0.gif";
				$table.=
									"';



									}\" onkeyup=\"javascript:{
					document.all.cell_value.value=this.value;
					}\">".$cells[$x][$y][value]."</textarea>";
				}
			else {
				if ($cspn)
					$cspn--;
				if (${"rspan$x"})
					${"rspan$x"}--;
				}
			$flag=1;
			$table.="</td>\n";
			}
		$table.="</tr>\n";
		}
	$table.="</table>\n";
	if (!$flag)
		$table="";
	$tpl->assign(
			array(
				PHOTOGALARY		=>$table,
				ROWSPERPAGE		=>$parent_doc_spec[rowsperpage],
				FORMAT			=>$parent_doc_spec[format],
				PAGES			=>	$pages,
				PAGE			=>	$page
			)
		);
?>