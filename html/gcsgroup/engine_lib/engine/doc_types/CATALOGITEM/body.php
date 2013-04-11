<?php

/*
 *  $Log: body.php,v $
 *  Revision 1.10  2005/08/02 10:50:25  aavakyan
 *  Не работала функция "Отображать" для элемента каталога, элемент не скрывался
 *
 *  Revision 1.9  2005/08/02 10:48:56  aavakyan
 *  *** empty log message ***
 *
 *  Revision 1.8  2005/01/19 19:29:26  dave
 *  Добавлен WYSIWYG как тип параметра
 *
 *  Revision 1.7  2005/01/11 18:46:17  dave
 *  Убран модификатор 'u' в регулярных выражениях
 *
 *  Revision 1.6  2004/12/26 11:48:39  dave
 *  Переформатирование кода
 *
 *  Revision 1.5  2004/12/19 22:50:44  dave
 *  Оптимизация запросов к БД -- избавление от лишних OUTER JOIN
 *
 *
 */

global $engine_show_root, $engine_show_htroot, $page;

$ctlg = new Document($this->pid);

$this->body = "";
$sql = "select ci.name,d.id from engine_documents d, engine_CATALOGITEM ci where d.visible=1 and ci.doc_id=d.id and d.id=$id order by ci.name";
$r_item = mysql_query("$sql") or die (mysql_error());
while ($item = mysql_fetch_array($r_item)) {
	$sql = "select * from engine_CATALOG_param where catalog=" . $this->pid;
	$r = mysql_query("$sql") or die (mysql_error());
	$param .= "<table border=1>";
	while ($f = mysql_fetch_array($r)) {
		if (!$f[select]) {
			$sql = "select * from engine_CATALOG_values where item={$item[id]} and param=$f[id]";
			$r1 = mysql_query("$sql") or die (mysql_error());
			$f1 = mysql_fetch_array($r1);
			if ($f[type] == "Изображение") {
				$pic = "$engine_show_htroot/engine/pics/catalog/0.gif";
				if (file_exists("$engine_show_root/engine/pics/catalog/p_" . $f[id] . "_" . $item[id] . ".jpg"))
					$pic = "$engine_show_htroot/engine/pics/catalog/p_" . $f[id] . "_" . $item[id] . ".jpg";
				if (file_exists("$engine_show_root/engine/pics/catalog/p_" . $f[id] . "_" . $item[id] . ".gif"))
					$pic = "$engine_show_htroot/engine/pics/catalog/p_" . $f[id] . "_" . $item[id] . ".gif";
				${"fld".$f[id]} = $pic;
			}
			if ($f[type] == "Текст" || $f[type] == "WYSIWYG") {
				${"fld".$f[id]} = $f1[value];
			}
		} else {
			if (!$f[multiselect]) {
				$sql = "select * from engine_CATALOG_values where item=$item[id] and param=$f[id]";
				$r2 = mysql_query("$sql") or die (mysql_error() . " $sql");
				$f2 = mysql_fetch_array($r2);
				if (!$f2[id]) {
					$sql = "select * from  engine_CATALOG_possvals where  param=$f[id] limit 1";
				} else {
					$sql = "select * from  engine_CATALOG_possvals where  id=" . $f2[poss_val_id];
				}
				$r1 = mysql_query("$sql") or die (mysql_error() . " $sql");
				$f1 = mysql_fetch_array($r1);
				if ($f[type] == "Изображение") {
					$pic = "$engine_show_htroot/engine/pics/catalog/0.gif";
					if (file_exists("$engine_show_root/engine/pics/catalog/pv_" . $f1[id] . ".jpg"))
						$pic = "$engine_show_htroot/engine/pics/catalog/pv_" . $f1[id] . ".jpg";
					if (file_exists("$engine_show_root/engine/pics/catalog/pv_" . $f1[id] . ".gif"))
						$pic = "$engine_show_htroot/engine/pics/catalog/pv_" . $f1[id] . ".gif";
					${"fld".$f[id]} = $pic;
				}
				if ($f[type] == "Текст" || $f[type] == "WYSIWYG") {
					${"fld".$f[id]} = $f1[val];
				}
			} else {
				$buf = "";
				$sql = "select * from  engine_CATALOG_possvals where param=$f[id]";
				$r1 = mysql_query("$sql") or die (mysql_error());
				while ($f1 = mysql_fetch_array($r1)) {
					$sql = "select id from engine_CATALOG_values where item=$item[id] and param=$f[id] and poss_val_id=$f1[id]";
					$r2 = mysql_query("$sql") or die (mysql_error());
					$f2 = mysql_fetch_array($r2);
					if ($f[type] == "Изображение") {
						$pic = "$engine_show_htroot/engine/pics/catalog/0.gif";
						if (file_exists("$engine_show_root/engine/pics/catalog/pv_" . $f1[id] . ".jpg"))
							$pic = "$engine_show_htroot/engine/pics/catalog/pv_" . $f1[id] . ".jpg";
						if (file_exists("$engine_show_root/engine/pics/catalog/pv_" . $f1[id] . ".gif"))
							$pic = "$engine_show_htroot/engine/pics/catalog/pv_" . $f1[id] . ".gif";
						if ($f2[id]) {
							$buf = str_replace("TEXT", $f1[val], $f[ms_format]);
							$buf = str_replace("PIC", $pic, $buf);
						} else $buf = "";
					}
					if ($f[type] == "Текст" || $f[type] == "WYSIWYG") {
						if ($f2[id]) {
							$buf = str_replace("TEXT", $f1[val], $f[ms_format]);
						}
					}

					${"fld".$f[id]} .= $buf;
					$buf = "";
				}
			}
		}
	}
	$buf = $ctlg->spec[full_format];
	$i = 0;
	preg_match_all("|\[(fld\d+)\]|", $ctlg->spec[full_format], $reg, PREG_SET_ORDER);
	while ($reg[$i][0])
	{
		$buf = str_replace($reg[$i][0], ${$reg[$i][1]}, $buf);
		${$reg[$i][1]} = "";
		$i++;
	}

	$buf = str_replace('[CAPTION]', $item[name], $buf);
	$buf = str_replace('[ITEM_ID]', $item['id'], $buf);
	$this->body .= $buf;
}

?>