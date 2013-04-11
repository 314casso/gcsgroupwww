<?
global $engine_show_htroot,$engine_show_root,$page;




 	$sql="SELECT
			(max( x ) + 1) cols,
			(max( y ) + 1) rows
		 from engine_PHOTOGALARYold_cells where doc_id=".$id;


	list($cols, $rows)=mysql_fetch_array(mysql_query($sql));
	if ($this->spec[rowsperpage]!=0){
		$page=(int)$page;
		$limit = "limit $page,".($this->spec[rowsperpage]*$cols);
		$count=$rows*$cols;
		$p=0;
		if ($page!=0)
			$pages.="<a href='?page=".($page-$this->spec[rowsperpage]*$cols)."'><<<</a>&nbsp;&nbsp;";
		while ($p<$count){
			$i++;
			if ($p!=$page)
				$pages.="<a href='?page=$p'>$i</a>&nbsp;&nbsp;";
			else
				$pages.="<b>$i</b>&nbsp;&nbsp;";
			$p+=$this->spec[rowsperpage]*$cols;
			}
		if ($page!=($p-$this->spec[rowsperpage]*$cols)){
			$pages.="<a href='?page=".($page+$this->spec[rowsperpage]*$cols)."'>>>></a>&nbsp;&nbsp;";
			$rows=$this->spec[rowsperpage];//min($rows%$this->spec[rowsperpage],$this->spec[rowsperpage]);
			}
		else {
			if (!($rows=$rows%$this->spec[rowsperpage]))
				$rows=$this->spec[rowsperpage];
			}
		}
		if ($cols*$this->spec[rowsperpage]!=0){
			if ($count/($cols*$this->spec[rowsperpage])<1)
				$pages="";
			else
				 $pages="<strong>Страницы</strong> $pages";
			}
		else
				$pages="";




	$sql="select * from engine_PHOTOGALARYold_cells where doc_id=$id order by  y,x $limit";
	$r=mysql_query("$sql") or die (mysql_error());
	while($f=mysql_fetch_array($r)){
		$cells[$f[x]][$f[y]][value]=$f[value];
		$cells[$f[x]][$f[y]][colspan]=$f[colspan];
		$cells[$f[x]][$f[y]][rowspan]=$f[rowspan];
		$cells[$f[x]][$f[y]][ids]=$f[id];
		}

	$table="";
	$table.="<table cellspacing=1 cellpadding=1 class=photo>\n";
	if ($cols!=0) $my=$page/$cols;
	else $my=0;
	for ($y=$my;$y<$my+$rows;$y++){
		$table.="<tr>\n";
		$cspn=0;
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


//				$table.="<td  rowspan=".($cells[$x][$y][rowspan]+1)." colspan=".($cells[$x][$y][colspan]+1)." class=photo x=$x y=$y v=\"".$cells[$x][$y][value]."\"	 cs=\"".$cells[$x][$y][colspan]."\" rs=\"".$cells[$x][$y][rowspan]."\"
//	 >\n";
				$table.="<td class=tbldoc rowspan=".($cells[$x][$y][rowspan]+1)." colspan=".($cells[$x][$y][colspan]+1)." >\n";
				if (file_exists("$engine_show_root/engine/pics/PHOTOGALARY/pic{$id}_".$cells[$x][$y][ids].".gif")){
					$img="$engine_show_htroot/engine/pics/PHOTOGALARY/pic{$id}_".$cells[$x][$y][ids].".gif";
					}
				else if (file_exists("$engine_show_root/engine/pics/PHOTOGALARY/pic{$id}_".$cells[$x][$y][ids].".jpg")){
					$img="$engine_show_htroot/engine/pics/PHOTOGALARY/pic{$id}_".$cells[$x][$y][ids].".jpg";
					}
				else
					$img="$engine_show_htroot/engine/pics/PHOTOGALARY/0.gif";

				if (file_exists("$engine_show_root/engine/pics/PHOTOGALARY/pic{$id}_".$cells[$x][$y][ids]."_big.gif")){
					$imgbig="$engine_show_htroot/engine/pics/PHOTOGALARY/pic{$id}_".$cells[$x][$y][ids]."_big.gif";
					}
				else if (file_exists("$engine_show_root/engine/pics/PHOTOGALARY/pic{$id}_".$cells[$x][$y][ids]."_big.jpg")){
					$imgbig="$engine_show_htroot/engine/pics/PHOTOGALARY/pic{$id}_".$cells[$x][$y][ids]."_big.jpg";
					}
				else
					$imgbig="$engine_show_htroot/engine/pics/PHOTOGALARY/0.gif";

				$buf=$this->spec[format];
				$buf=str_replace('PICTUREBIG',$imgbig,$buf);
				$buf=str_replace('PICTURE',$img,$buf);
				$buf=str_replace('TEXT',$cells[$x][$y][value],$buf);
				$table.=$buf;
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
	$this->body.="$pages
			$table
		";

?>