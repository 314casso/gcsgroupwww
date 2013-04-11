<?php

/*
 *  $Id: edit.php,v 1.11 2007/06/08 06:54:02 vadimbond Exp $
 *
 *  $Log: edit.php,v $
 *  Revision 1.11  2007/06/08 06:54:02  vadimbond
 *  новый редактор
 *
 *  Revision 1.9  2006/03/13 13:13:08  ereih
 *  *** empty log message ***
 *
 *  Revision 1.8  2005/01/19 19:08:45  dave
 *  Добавлен WYSIWYG как тип параметра
 *
 *  Revision 1.7  2004/12/26 11:48:39  dave
 *  Переформатирование кода
 *
 */

$sql = "select * from engine_CATALOG where doc_id=$parent_doc[pid]";
$r = mysql_query("$sql") or die (mysql_error());
$cat = mysql_fetch_array($r);

$sql = "select * from engine_CATALOG_param where catalog=$parent_doc[pid]";
$r = mysql_query("$sql") or die (mysql_error());
$param .= "<table border=0>";
while ($f = mysql_fetch_array($r)) {
        if (!$f[select]) {
                $sql = "select * from engine_CATALOG_values where item=$id and param=$f[id]";
                $r1 = mysql_query("$sql") or die (mysql_error());
                $f1 = mysql_fetch_array($r1);
                if ($f[type] == "Изображение") {
                        $pic = "";
				$http = "";
                        if (file_exists("$engine_show_root/engine/pics/catalog/p_" . $f[id] . "_" . $id . ".jpg")){
                                $pic = "<img src='$engine_show_htroot/engine/pics/catalog/p_" . $f[id] . "_" . $id . ".jpg'>";
 					$http = "$engine_show_htroot/engine/pics/catalog/p_" . $f[id] . "_" . $id . ".jpg";
				}
                        if (file_exists("$engine_show_root/engine/pics/catalog/p_" . $f[id] . "_" . $id . ".gif")){
                                $pic = "<img src='$engine_show_htroot/engine/pics/catalog/p_" . $f[id] . "_" . $id . ".gif'>";
 					$http = "$engine_show_htroot/engine/pics/catalog/p_" . $f[id] . "_" . $id . ".gif";
				}
				if ($http) $http = "<br> Текушая картинка $http | <span style=\"font-weight: normal;\">Удалить?</span> <input type=checkbox name=del_pics[] value=$f[id]><br>";
                        $param .= "<tr><td class=top>$f[name]</td><td><input type=file name=val_forparam$f[id] name=val$f[id]>
						$http 
                                        <br>
                                        $pic
						
                                        </td></tr><tr><td colspan=2><hr></td></tr>";
                }
                elseif ($f[type] == "Текст") {
                        $param .= "<tr><td class=top>$f[name]</td><td><input value='$f1[value]' name=val_forparam$f[id] name=val$f[id]></td></tr>";
                }
                elseif ($f[type] == "WYSIWYG") {
				/*$param .= "<tr><td class=top>$f[name]</td><TD vAlign=top bgcolor=\"#76C5F0\" style=\"border-color: #000000; border-style:solid;border-width:1px;\">
                                        <textarea
                                        style=\"\"
                                        name=val_forparam$f[id] name=val$f[id] rows=7 cols=100>
                                        $f1[value]</textarea>
                                        <SCRIPT language=JavaScript>
                                        if (isMSIE5 || isOpera7)
                                        {
                                        document.write('<table border=0 width=100% height=\"300\"><td>');
                                        CreateEditor('editor','val_forparam$f[id]','val_forparam$f[id]','hedit',300);
                                        document.write('</td></table>');
                                        }
                                        </SCRIPT>
                                        </TD></tr>";*/
			   include_once $engine_root.'/engine/spaw/spaw_control.class.php';

			   $sw = new SPAW_Wysiwyg('val_forparam'.$f[id] /*name*/,$f1[value] /*value*/);
			   $html_1 = $sw->getHtml();
				$param .= "<tr><td class=top>$f[name]</td><TD vAlign=top>
                                        ".$html_1."<hr>
                                        </TD></tr>";


                }
        } else {
                if (!$f[multiselect])
                {
                        $sql = "select * from engine_CATALOG_values where item=$id and param=$f[id]";
                        $r2 = mysql_query("$sql") or die (mysql_error());
                        $f2 = mysql_fetch_array($r2);
                        $param .= "<tr><td class=top>$f[name]</td><td>
                                <select name=val_forparam$f[id] style='width=400;'>";
                        $sql = "select * from  engine_CATALOG_possvals where param=$f[id]";
                        $r1 = mysql_query("$sql") or die (mysql_error());

                	while ($f1 = mysql_fetch_array($r1))
                        {
                                if ($f2[poss_val_id] != $f1[id])
                                {
                                        $param .= "<option value=$f1[id]>$f1[val]</option>";
                                }
                                else
                                {
                                        $param .= "<option selected value=$f1[id]>$f1[val]</option>";
                                }
                        }
                        $param .= "</select></td></tr>";
                }
                else {
                        $param .= "<tr><td class=top>$f[name]</td><td><table         >";
                        $sql = "select * from  engine_CATALOG_possvals where param=$f[id]";
                        $r1 = mysql_query("$sql") or die (mysql_error());
                        while ($f1 = mysql_fetch_array($r1)) {
                                $sql = "select id from engine_CATALOG_values where item=$id and param=$f[id] and poss_val_id=$f1[id]";
                                $r2 = mysql_query("$sql") or die (mysql_error());
                                $f2 = mysql_fetch_array($r2);
                                if ($f[type] == "Изображение") {
                                        $pic = "";
                                        if (file_exists("$engine_show_root/engine/pics/catalog/pv_" . $f1[id] . ".jpg")){
                                                $pic = "<img src='$engine_show_htroot/engine/pics/catalog/pv_" . $f1[id] . ".jpg'>";
                                                $http = "$engine_show_htroot/engine/pics/catalog/pv_" . $f1[id] . ".jpg";
						}
                                        if (file_exists("$engine_show_root/engine/pics/catalog/pv_" . $f1[id] . ".gif")){
                                                $pic = "<img src='$engine_show_htroot/engine/pics/catalog/pv_" . $f1[id] . ".gif'>";
                                                $http = "$engine_show_htroot/engine/pics/catalog/pv_" . $f1[id] . ".gif";
						}

                                        $param .= "<tr><td valign=top alihn=right>$f1[val]</td><td>$pic</td><td>Текушая картинка $http</td><td align=right>";
                                        if (!$f2[id])
                                                $param .= "<input name=val$f1[id]_forparam$f[id] type=checkbox></td></tr>";
                                        else
                                                $param .= "<input checked name=val$f1[id]_forparam$f[id] type=checkbox></td></tr>";
                                }
                                if ($f[type] == "Текст") {
                                        if (!$f2[id])
                                                $param .= "<tr><td>$f1[val]</td><td align=right><input name=val$f1[id]_forparam$f[id] type=checkbox></td></tr>";
                                        else
                                                $param .= "<tr><td>$f1[val]</td><td align=right><input checked name=val$f1[id]_forparam$f[id] type=checkbox></td></tr>";
                                }
                        }
                        $param .= "</table></td></tr>";
                }
        }
}
$param .= "</table>";

$tpl->assign(
        array(
                PARAM => $param,
                INAME => htmlspecialchars($parent_doc_spec[name]),
                PRICE => $parent_doc_spec[price]
                )
        );

?>
