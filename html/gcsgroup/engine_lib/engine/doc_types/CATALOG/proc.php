<?

/*
 *  $Id: proc.php,v 1.7 2004/12/19 22:50:27 dave Exp $
 *
 *  $Log: proc.php,v $
 *  Revision 1.7  2004/12/19 22:50:27  dave
 *  Оптимизация запросов к БД -- избавление от лишних OUTER JOIN
 *
 *
 */

 //echo $delpossval;exit;
$sql="select ci.id ciid,ci.ord,ci.name,d.id from engine_documents d, engine_CATALOGITEM ci where ci.doc_id=d.id
and d.pid=$id order by ci.name";
$r=mysql_query("$sql") or die (mysql_error());
while($f=mysql_fetch_array($r)){
	${"ord".$f[id]};
	if ($f[ord]!=${"ord".$f[id]}){
		mysql_query("update engine_CATALOGITEM set ord='".${"ord".$f[ciid]}."' where id=$f[ciid]") or die (mysql_error());
		}
	}
if ($npv_paramid){
	$sql="INSERT INTO `engine_CATALOG_possvals` (  `val` , `param` )
		VALUES (
			'".${"npv$npv_paramid"}."', '$npv_paramid'
		)";
	mysql_query($sql) or die("SQL error ".mysql_error()." in: $sql\n");
		if (${"npv_pic$npv_paramid"}){
			$fn=explode(".",${"npv_pic".$npv_paramid."_name"});
			$ext=strtolower($fn[count($fn)-1]);
			@unlink("$engine_show_root/engine/pics/catalog/pv_".mysql_insert_id().".jpg");
			@unlink("$engine_show_root/engine/pics/catalog/pv_".mysql_insert_id().".gif");
			copy(${"npv_pic$npv_paramid"},"$engine_show_root/engine/pics/catalog/pv_".mysql_insert_id().".$ext");
			chmod("$engine_show_root/engine/pics/catalog/pv_".mysql_insert_id().".$ext",0777);
		}
	}
if ($delitem){

	$sql="delete from `engine_CATALOG_values` where item=$delitem";
//	mysql_query($sql) or die("SQL error ".mysql_error()." in: $sql\n");
	$sql="select id from `engine_CATALOG_param` where catalog=$doc[id]";
	$r=mysql_query("$sql") or die (mysql_error());
	while($f=mysql_fetch_array($r)){
		@unlink("$engine_show_root/engine/pics/catalog/p_$f[id]_{$delitem}.jpg");
		@unlink("$engine_show_root/engine/pics/catalog/p_$f[id]_{$delitem}.gif");
		}
	$sql="delete from `engine_CATALOGITEM` where doc_id=$delitem";
	mysql_query($sql) or die("SQL error ".mysql_error()." in: $sql\n");
	$sql="delete from `engine_documents` where id=$delitem";
	mysql_query($sql) or die("SQL error ".mysql_error()." in: $sql\n");

	}

if ($delpossval){
	$sql="delete from `engine_CATALOG_possvals` where id=$delpossval";
	mysql_query($sql) or die("SQL error ".mysql_error()." in: $sql\n");
	@unlink("$engine_show_root/engine/pics/catalog/pv_".$delpossval.".jpg");
	@unlink("$engine_show_root/engine/pics/catalog/pv_".$delpossval.".gif");

	}
if ($delparam){
	$sql="delete from `engine_CATALOG_param` where id=$delparam";
	mysql_query($sql) or die("SQL error ".mysql_error()." in: $sql\n");
	$sql="delete from `engine_CATALOG_values` where param=$delparam";
	mysql_query($sql) or die("SQL error ".mysql_error()." in: $sql\n");
	$sql="select doc_id from `engine_CATALOGITEM`";
	$r=mysql_query("$sql") or die (mysql_error());
	while($f=mysql_fetch_array($r)){
		@unlink("$engine_show_root/engine/pics/catalog/p_{$delparam}_$f[doc_id].jpg");
		@unlink("$engine_show_root/engine/pics/catalog/p_{$delparam}_$f[doc_id].gif");
		}
	$sql="select id from `engine_CATALOG_possvals` where param=$delparam";
	$r=mysql_query("$sql") or die (mysql_error());
	while($f=mysql_fetch_array($r)){
		@unlink("$engine_show_root/engine/pics/catalog/pv_$f[id].jpg");
		@unlink("$engine_show_root/engine/pics/catalog/pv_$f[id].gif");
		}

	$sql="delete from `engine_CATALOG_possvals` where param=$delparam";
	mysql_query($sql) or die("SQL error ".mysql_error()." in: $sql\n");
	}

$sql="select * from  engine_CATALOG where doc_id=$id";
	$r=mysql_query($sql) or die("SQL error ".mysql_error()." in: $sql\n");
	if (mysql_num_rows($r)==0) {
		$sql="insert into  engine_CATALOG(short_format, full_format,icount,doc_id) values('$short_format','$full_format','$icount',$id)";
		mysql_query($sql) or die("SQL error ".mysql_error()." in: $sql\n");
		}
	else {
		$sql="update engine_CATALOG set
			email='$email',
			icount='$icount',
			short_format='$short_format',
			short_format2='$short_format2',
			full_format='$full_format',
			prefix='$prefix',
			postfix='$postfix'
			where doc_id=$id";
		mysql_query($sql) or die("SQL error ".mysql_error()." in: $sql\n");

			$sql="update engine_CATALOG set
				filter='$filter'
				where doc_id=$id";
			if (!$news_r = mysql_query($sql)){
				$err_title = 1;
			}


		}

$sql="select * from engine_CATALOG_param where catalog=$id";
$r=mysql_query("$sql") or die (mysql_error());
while($f=mysql_fetch_array($r)){
	$sql="update engine_CATALOG_param set
			name='".${"name$f[id]"}."',
			ms_format='".${"ms_format$f[id]"}."'
			where id=$f[id]";
	mysql_query($sql) or die("SQL error ".mysql_error()." in: $sql\n");
	}
if ($np){
	if ($np_select)
		$np_select=1;
	if ($np_multiselect)
		$np_multiselect=1;
	// Force select if there was multiselect
	if($np_multiselect == 1)
		$np_select = 1;
	$sql="INSERT INTO `engine_CATALOG_param` (  `catalog` , `name` , `select` , `multiselect` , `ms_format` , `type` )
			VALUES (
				$id,
				'$np_name',
				'$np_select',
				'$np_multiselect',
				'$ms_format',
				'$np_type'
				)";
	mysql_query($sql) or die("SQL error ".mysql_error()." in: $sql\n");
	}
if ($copyparam){
	$sql="select * from engine_CATALOG_param where catalog=$copyctlg";
	$r=mysql_query("$sql") or die (mysql_error());
	while($f=mysql_fetch_array($r)){

		$sql="INSERT INTO engine_CATALOG_param (  catalog, name , `select` , multiselect , ms_format , type )
				VALUES (
					$id,
					'".str_replace("'","\\'",$f[name])."',
					'".str_replace("'","\\'",$f[select])."',
					'".str_replace("'","\\'",$f[multiselect])."',
					'".str_replace("'","\\'",$f[ms_format])."',
					'".str_replace("'","\\'",$f[type])."'
					)";

		mysql_query($sql) or die("SQL error ".mysql_error()." in: $sql\n");

		$newparamid=mysql_insert_id();
		if ($f[select]){
			$sql="select * from engine_CATALOG_possvals where param=$f[id]";
			$r1=mysql_query("$sql") or die (mysql_error());
			while($f1=mysql_fetch_array($r1)){
	 				$sql="INSERT INTO `engine_CATALOG_possvals` (  `val` , `param` )
					VALUES (
						'".str_replace("'","\\'",$f1[val])."', '$newparamid'
					)";
				mysql_query($sql) or die("SQL error ".mysql_error()." in: $sql\n");
				@copy("$engine_show_root/engine/pics/catalog/pv_".$f1[id].".jpg","$engine_show_root/engine/pics/catalog/pv_".mysql_insert_id().".jpg");
				@copy("$engine_show_root/engine/pics/catalog/pv_".$f1[id].".gif","$engine_show_root/engine/pics/catalog/pv_".mysql_insert_id().".gif");
				}
			}
		}

	}


?>