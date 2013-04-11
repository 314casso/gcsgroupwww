<?
	if ($rowsperpage!=$parent_doc_spec[rowsperpage])
		$flag=1;
	else $flag=0;

	if (mysql_num_rows(mysql_query("select * from engine_PHOTOGALARYold  where doc_id=$id"))){
		$sql="update engine_PHOTOGALARYold
			set
				rowsperpage='$rowsperpage',
				format='$format'

			 where doc_id=$id";
		mysql_query($sql);
		}
	else {
		$sql="insert into engine_PHOTOGALARYold(rowsperpage,format,doc_id)
			values ('$rowsperpage','$format',$id)";

		mysql_query($sql);

		}


	$sql="SELECT
			(max( x ) + 1) cols,
			(max( y ) + 1) rows
		 from engine_PHOTOGALARYold_cells where doc_id=$id";


	list($cols, $rows)=mysql_fetch_array(mysql_query($sql));
	$table="";
	$table.="<table cellspacing=1 style='border:1 solid black'>\n";
	if (!$parent_doc_spec[rowsperpage])
		$parent_doc_spec[rowsperpage]=$rows;
	for ($x=0;$x<$cols;$x++){
		$table.="<tr>\n";
		for ($y=$page/$cols;$y<$page_/$cols+$parent_doc_spec[rowsperpage];$y++){
			$sql="update engine_PHOTOGALARYold_cells set value='".${"val".$x.$y}."' where doc_id=$id and x=$x and y=$y";
			mysql_query("$sql") or die (mysql_error());
			}
		}

	if ((int)($cell_x+1))
		$cell_x=(int)$cell_x;
	else
		$cell_x=-1;
	if ((int)($cell_y+1))
		$cell_y=(int)$cell_y;
	else
		$cell_y=-1;
	$cell_colspan=(int)$cell_colspan;
	$cell_rowspan=(int)$cell_rowspan;
	if ($celledit and $cell_x>-1 and $cell_y>-1){
		$sql="update engine_PHOTOGALARYold_cells set
			value='".$cell_value."',
			colspan='".$cell_colspan."',
			rowspan='".$cell_rowspan."'
			where doc_id=$id and x=$cell_x and y=$cell_y";
		mysql_query("$sql") or die (mysql_error());

		if ($cellimg){

					$sql="SELECT
							 id
							 from engine_PHOTOGALARYold_cells where doc_id=$id and x=$cell_x and y=$cell_y";


					list($cell_id)=mysql_fetch_array(mysql_query($sql));


					$fn=explode(".",$cellimg_name);
					$ext=strtolower($fn[count($fn)-1]);
					@unlink("$engine_show_root/engine/pics/PHOTOGALARY/pic{$id}_".$cell_id.".jpg");
					@unlink("$engine_show_root/engine/pics/PHOTOGALARY/pic{$id}_".$cell_id.".gif");
					copy($cellimg,"$engine_show_root/engine/pics/PHOTOGALARY/pic{$id}_".$cell_id.".$ext");
					chmod("$engine_show_root/engine/pics/PHOTOGALARY/pic{$id}_".$cell_id.".$ext",0777);
					}

		if ($cellimgbig){

					$sql="SELECT
							 id
							 from engine_PHOTOGALARYold_cells where doc_id=$id and x=$cell_x and y=$cell_y";


					list($cell_id)=mysql_fetch_array(mysql_query($sql));


					$fn=explode(".",$cellimgbig_name);
					$ext=strtolower($fn[count($fn)-1]);
					@unlink("$engine_show_root/engine/pics/PHOTOGALARY/pic{$id}_".$cell_id."_big.jpg");
					@unlink("$engine_show_root/engine/pics/PHOTOGALARY/pic{$id}_".$cell_id."_big.gif");
					copy($cellimgbig,"$engine_show_root/engine/pics/PHOTOGALARY/pic{$id}_".$cell_id."_big.$ext");
					chmod("$engine_show_root/engine/pics/PHOTOGALARY/pic{$id}_".$cell_id."_big.$ext",0777);
					}
		}
	if ($addcol){
		if (!$cell_x)$cell_x=0;
		$sql="update engine_PHOTOGALARYold_cells
			set x=x+1 where x>=$cell_x and doc_id=$id";
		mysql_query("$sql") or die (mysql_error());
		for ($y=0;$y<$rows;$y++){
			$sql="insert into engine_PHOTOGALARYold_cells(x,y,doc_id)
				values($cell_x,$y,$id)";
			mysql_query("$sql") or die (mysql_error());
			}
		if (!$rows){
			$sql="insert into engine_PHOTOGALARYold_cells(x,y,doc_id)
				values($cell_x,0,$id)";
			mysql_query("$sql") or die (mysql_error());
			}
		}
	if ($addrow){
		if (!$cell_y){
			if ($colls)
				$cell_y=$page_/$cols;
			else
				$cell_y=0;
			}
		$sql="update engine_PHOTOGALARYold_cells
			set y=y+1 where y>=$cell_y and doc_id=$id";
		mysql_query("$sql") or die (mysql_error());

		for ($x=0;$x<$cols;$x++){
			$sql="insert into engine_PHOTOGALARYold_cells(x,y,doc_id)
				values($x,$cell_y,$id)";
			mysql_query("$sql") or die (mysql_error());
			}
		if (!$cols){
			$sql="insert into engine_PHOTOGALARYold_cells(x,y,doc_id)
				values(0,$cell_y,$id)";
			mysql_query("$sql") or die (mysql_error());
			}
		}

	if ($addcol_after){
		if (!$cell_x)$cell_x=0;
		list($colspan,$rowspan)=mysql_fetch_array(mysql_query("select colspan,rowspan from engine_PHOTOGALARYold_cells where doc_id=$id and x=$cell_x and y=$cell_y"));
		$cell_x+=$colspan+1;
		$sql="update engine_PHOTOGALARYold_cells
			set x=x+1 where x>=$cell_x and doc_id=$id";
		mysql_query("$sql") or die (mysql_error());
		for ($y=0;$y<$rows;$y++){
			$sql="insert into engine_PHOTOGALARYold_cells(x,y,doc_id)
				values($cell_x,$y,$id)";
			mysql_query("$sql") or die (mysql_error());
			}
		}
	if ($addrow_after){
		if (!$cell_y)$cell_y=0;
		list($colspan,$rowspan)=mysql_fetch_array(mysql_query("select colspan,rowspan from engine_PHOTOGALARYold_cells where doc_id=$id and x=$cell_x and y=$cell_y"));
		$cell_y+=$rowspan+1;
		$sql="update engine_PHOTOGALARYold_cells
			set y=y+1 where y>=$cell_y and doc_id=$id";
		mysql_query("$sql") or die (mysql_error());

		for ($x=0;$x<$cols;$x++){
			$sql="insert into engine_PHOTOGALARYold_cells(x,y,doc_id)
				values($x,$cell_y,$id)";
			mysql_query("$sql") or die (mysql_error());
			}
		}
	if ($del_col!=""){
		$sql="delete from engine_PHOTOGALARYold_cells
			where x=$del_col and doc_id=$id";
		mysql_query("$sql") or die (mysql_error());
		$sql="update engine_PHOTOGALARYold_cells
			set x=x-1 where x>$del_col and doc_id=$id";
		mysql_query("$sql") or die (mysql_error());

		}

	if ($del_row!=""){
		$sql="delete from engine_PHOTOGALARYold_cells
			where y=$del_row and doc_id=$id";
		mysql_query("$sql") or die (mysql_error());
		$sql="update engine_PHOTOGALARYold_cells
			set y=y-1 where y>$del_row and doc_id=$id";
		mysql_query("$sql") or die (mysql_error());

		}

if ($flag)$page=0;
?>
