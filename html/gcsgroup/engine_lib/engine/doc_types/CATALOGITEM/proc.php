<?php
/* 
*  $Id: proc.php,v 1.7 2005/01/19 19:26:56 dave Exp $
* пришлось поправить, а то код был в куче 
*/
// echo $delpossval; exit;
$iprice = $iprice * 1;
$sql = "select * from  engine_CATALOGITEM where doc_id=$id";
$r = mysql_query($sql) or die("SQL error " . mysql_error() . " in: $sql\n");
if (mysql_num_rows($r) == 0) {
        $sql = "insert into  engine_CATALOGITEM(name,price,doc_id) values('$iname','$iprice',$id)";
        mysql_query($sql) or die("SQL error " . mysql_error() . " in: $sql\n");
} else {
        $sql = "update engine_CATALOGITEM set name='$iname', price='$iprice' where doc_id=$id";
        mysql_query($sql) or die("SQL error " . mysql_error() . " in: $sql\n");
}
$i=0;
function bg(){
        global $i;
        if (++$i%2==0){              
  		return "tr2";        
	}        
	else{         
	       return "tr1";
       }
}
$ArrDel_ID=((!isset($_POST["del_pics"]))?"":$_POST["del_pics"]);
//удаление фоток
if (is_array($ArrDel_ID)) {
    foreach ($ArrDel_ID as $val) {
		$del_arr[$val] = 1;
    }
}


// $sql="delete from  engine_CATALOG_values where item=$id";
// mysql_query($sql) or die("SQL error ".mysql_error()." in: $sql\n");

$sql = "select * from  engine_CATALOG_param where catalog=$doc[pid]";
$r = mysql_query($sql) or die("SQL error " . mysql_error() . " in: $sql\n");
while ($f = mysql_fetch_array($r)) {
        if (!$f[select]) {
                if ($f[type] == 'Текст' || $f[type] == 'WYSIWYG') {
                        if ($f[type] == 'WYSIWYG') {
                                ${"val_forparam".$f[id]} = stripslashes(${"val_forparam".$f[id]});
                                ${"val_forparam".$f[id]} = strip_tags(${"val_forparam".$f[id]},'<BR><pre><hr><div><BLOCKQUOTE><img><a><u><b><i><span><table><th><tr><td><ol><ul><li><h1><h2><h3><h4><strong><p><strike><sup><sub><center>');
                                ${"val_forparam".$f[id]} = preg_replace("|<(\w+)([ >])|sie","(strtolower('\\1')!='tr')?'<\\1 class=textdoc \\2':'<\\1 class=textdoc_'.bg().' \\2'",${"val_forparam".$f[id]});
                                ${"val_forparam".$f[id]} = preg_replace("|<A class=textdoc_a([^>]*)>|Usie","(stristr(\"\\1\",'href'))?'<a class=textdoc_a'.\"\\1\".'>':'<a '.\"\\1\".'>'",${"val_forparam".$f[id]});
                                ${"val_forparam".$f[id]} = preg_replace("|<(\w+) class=textdoc ([^>]*)(class=[^>]*)>|Usi","<\\1 \\2\\3>",${"val_forparam".$f[id]});                                $sn = preg_replace("|^www\.|Usi","",$SERVER_NAME);
                                ${"val_forparam".$f[id]} = preg_replace("^((href|src|background) *= *([\"'])?)(https://|http://)?(www\.)?$sn"."^Usi","\\1",${"val_forparam".$f[id]});
                        }
                        $sql = "select * from engine_CATALOG_values where param=$f[id] and item=$id";
                        if (!mysql_num_rows(mysql_query("$sql")))
                                $sql = "insert into engine_CATALOG_values(param,value,item) values($f[id],'" . ${"val_forparam".$f[id]} . "',$id)";
                        else
                                $sql = "update engine_CATALOG_values set value='" . ${"val_forparam".$f[id]} . "' where param=$f[id] and item=$id";
                        mysql_query($sql) or die("SQL error " . mysql_error() . " in: $sql\n");
                } else {
			if ($del_arr[$f[id]]){
                                @unlink("$engine_show_root/engine/pics/catalog/p_" . $f[id] . "_" . $id . ".jpg");
                                @unlink("$engine_show_root/engine/pics/catalog/p_" . $f[id] . "_" . $id . ".gif");
			}
                        if (${"val_forparam".$f[id]}) {
                                $fn = explode(".", ${"val_forparam".$f[id]."_name"});
                                $ext = strtolower($fn[count($fn)-1]);
                                @unlink("$engine_show_root/engine/pics/catalog/p_" . $f[id] . "_" . $id . ".jpg");
                                @unlink("$engine_show_root/engine/pics/catalog/p_" . $f[id] . "_" . $id . ".gif");
                                copy(${"val_forparam".$f[id]}, "$engine_show_root/engine/pics/catalog/p_" . $f[id] . "_" . $id . ".$ext");
                                chmod("$engine_show_root/engine/pics/catalog/p_" . $f[id] . "_" . $id . ".$ext", 0777);
                        }
                }
        } else {
                if (!$f[multiselect]) {
                        $sql = "select * from  engine_CATALOG_possvals where param=$f[id]";
                        $r1 = mysql_query($sql) or die("SQL error " . mysql_error() . " in: $sql\n");
                        while ($f1 = mysql_fetch_array($r1)) {
                                $sql = "select * from engine_CATALOG_values where param=$f[id] and item=$id";
                                if (!mysql_num_rows(mysql_query("$sql")))
                                        $sql = "insert into engine_CATALOG_values(param,poss_val_id,item) values($f[id],'" . ${"val_forparam".$f[id]} . "',$id)";
                                else
                                        $sql = "update  engine_CATALOG_values set poss_val_id='" . ${"val_forparam".$f[id]} . "' WHERE  param=$f[id] and item=$id";
                                mysql_query($sql) or die("SQL error " . mysql_error() . " in: $sql\n");
                        }
                } else {
                        $sql = "select * from  engine_CATALOG_possvals where param=$f[id]";
                        $r1 = mysql_query("$sql") or die (mysql_error());
                        while ($f1 = mysql_fetch_array($r1)) {
                                if (${"val".$f1[id]."_forparam".$f[id]}) {
                                        $sql = "select * from engine_CATALOG_values where param=$f[id] and item=$id and poss_val_id='" . $f1[id] . "'";
                                        if (!mysql_num_rows(mysql_query("$sql"))) {
                                                $sql = "insert into engine_CATALOG_values(param,poss_val_id,item) values($f[id],'" . $f1[id] . "',$id)";
                                                mysql_query($sql) or die("SQL error " . mysql_error() . " in: $sql\n");
                                        }
                                } else {
                                        $sql = "delete from  engine_CATALOG_values where param=$f[id] and item=$id and poss_val_id='" . $f1[id] . "'";
                                        mysql_query($sql) or die("SQL error " . mysql_error() . " in: $sql\n");
                                }
                        }
                }
        }
}
// exit;
?>