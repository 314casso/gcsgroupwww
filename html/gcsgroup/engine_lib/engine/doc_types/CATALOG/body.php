<?php

/*
 *  $Id: body.php,v 1.10 2005/08/02 10:50:38 aavakyan Exp $
 *
 *  $Log: body.php,v $
 *  Revision 1.10  2005/08/02 10:50:38  aavakyan
 *  Не работала функция "Отображать" для элемента каталога, элемент не скрывался
 *
 *  Revision 1.9  2005/06/20 08:50:32  aavakyan
 *  Добавлен вывод элементов WYSIWYG , в коротком формате вывода каталога
 *
 *  Revision 1.8  2005/01/11 18:46:51  dave
 *  Убран модификатор 'u' в регулярных выражениях
 *
 *  Revision 1.7  2004/12/26 11:48:22  dave
 *  Переформатирование кода
 *
 *  Revision 1.6  2004/12/19 22:50:27  dave
 *  Оптимизация запросов к БД -- избавление от лишних OUTER JOIN
 *
 *
 */

global $engine_show_root, $engine_show_htroot, $page, $cat_lines, $cat_delim;

//подключаем файл, который формирует блок фильтра
include_once("filter.php");

// $this->body=$this->spec[prefix];

/*-----------------------------------------------------------------------*/
//теперь вытаскиваем модели.
$house_arr = array();

if (!count($form_id)){

	//нет фильтра
	$sql = "select 
			ci.ord,
			ci.price,
			ci.name,
			d.id as id_d
		from 
			engine_documents d,
			engine_CATALOGITEM ci
		where 
			d.visible=1 and 
			ci.doc_id=d.id and
			d.pid=".$id."

		order by ci.ord,ci.name $limit";
	$r_item = mysql_query("$sql") or die (mysql_error());
	while ($item = mysql_fetch_array($r_item)) {
		$house_arr[] = $item[id_d];
	}

}
else{
	//есть фильтр
	for ($i=0;$i < count($id_arr);$i++){

		if (is_numeric($form_id[$i]) && $no_result != 1 && is_numeric($form_id[$i])){
			//узнаем тип переменной
			$type_val = return_type_date($id_arr[$i]);
			$where = '';
			if (count($house_arr)) {
				$where = " d.id in (".implode(', ', $house_arr).") and";
				$house_arr = array();
			}
			if ($type_val[select]){
				//тип селект
				$sql = "select 
					ci.ord,
					ci.price,
					ci.name,
					d.id as id_d
				from 
					engine_documents d,
					engine_CATALOGITEM ci,
					engine_CATALOG_param as ecp,
					engine_CATALOG_values ecv,
					engine_CATALOG_possvals as ecpo
				where 
					d.visible=1 and 
					ci.doc_id=d.id and 
					ecp.catalog = d.pid and
					ecp.id = '".$id_arr[$i]."' and
					d.pid=".$id." and 
					ecv.item = d.id and
					ecv.param=ecp.id and
					".$where."
					ecpo.id = ecv.poss_val_id and
					ecpo.id = ".$form_id[$i]."
				order by ci.ord,ci.name $limit";
			}
			else{
				$sql = "select 
					ci.ord,
					ci.price,
					ci.name,
					d.id as id_d
				from 
					engine_documents d,
					engine_CATALOGITEM ci,
					engine_CATALOG_param as ecp,
					engine_CATALOG_values ecv
				where 
					d.visible=1 and 
					ci.doc_id=d.id and 
					ecp.catalog = d.pid and
					ecp.id = '".$id_arr[$i]."' and
					d.pid=".$id." and 
					ecv.item = d.id and
					".$where."
					ecv.param=ecp.id and
					ecv.value = ".$form_id[$i]."
				order by ci.ord,ci.name";

			}

			$r_item = mysql_query("$sql") or die (mysql_error());
			while ($item = mysql_fetch_array($r_item)) {
				$house_arr[] = $item[id_d];
			}

			if (count($house_arr) == 0) $no_result = 1;
		}
	}
}

/*-----------------------------------------------------------------------*/
$count_catalog_model = count($house_arr); //кол-во моделей

/*-----------------------------------------------------------------------*/
//делаем листинг
$limit = $this->spec[icount];

if (!$_GET[page]) $_GET[page] = 1;
if ($count_catalog_model > $limit && $limit != 0) {
	$page = $_GET[page];
	$count = count($house_arr);
	$i = 0;
	if ($page != 1)
		$pages .= "<a href='?page=1'><<<</a>&nbsp;&nbsp;";
	while ($p < $count) {
		$i++;
		if ($i != $page)
			$pages .= "<a href='?page=$i'>$i</a>&nbsp;&nbsp;";
		else
			$pages .= "<b>$i</b>&nbsp;&nbsp;";
		$p+=$limit ;
	} 
	if ($page*$limit < $count)
		$pages .= "<a href='?page=" . ($i) . "'>>>></a>&nbsp;&nbsp;";
}

/*-----------------------------------------------------------------------*/
$house_arr = array_slice($house_arr, ($page-1)*$limit, $limit); 
$where = '';
if (count($house_arr)) {
	$where = " d.id in (".implode(', ', $house_arr).") and";
}
$pages=str_replace("page",$pr_link."page",$pages);

$this->body .= str_replace("[pages]", "Страницы " . $pages . "<br><br>".$filter_text."------", $this->spec[prefix]);
$sql = "select ci.ord,ci.price,ci.name,d.id from engine_documents d, engine_CATALOGITEM ci where d.visible=1 and ci.doc_id=d.id and ".$where." d.pid=$id order by ci.ord,ci.name";
$r_item = mysql_query("$sql") or die (mysql_error());

// Added 25-11-04 by Meremin
$cntr = 1;
// \\\Added 25-11-04 by Meremin


if ($no_result != 1){
	while ($item = mysql_fetch_array($r_item)) {

	$sql = "select * from engine_CATALOG_param where catalog=" . $this->id;
	$r = mysql_query("$sql") or die (mysql_error());
	// Added 25-11-04 by Meremin
	if (isset($cat_lines) && $cat_lines != 0 && $cntr != 1) {
		if (($cntr % $cat_lines)-1 == 0) {
			$this->body .= $cat_delim;
		} 
	} 
	$cntr++;
	// \\\Added 25-11-04 by Meremin
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
   		/*echo "<pre>";
   		print_r($sql);	   
   		echo "</pre>";*/
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
	if (++$item_num % 2 == 0 and $this->spec[short_format2])
		$buf = $this->spec[short_format2];
	else
		$buf = $this->spec[short_format];
	$i = 0;

	preg_match_all("|\[(fld\d+)\]|", $this->spec[short_format], $reg, PREG_SET_ORDER);
	while ($reg[$i][0]) {
		$buf = str_replace($reg[$i][0], ${$reg[$i][1]}, $buf);
		${$reg[$i][1]} = "";
		$i++;
	} 
	$buf = str_replace('[LINK]', geturl($item[id]), $buf);
	$buf = str_replace('[PRICE]', $item[price], $buf);
	$buf = str_replace('[CAPTION]', $item[name], $buf);
	global $buscet;
	$buf = str_replace('[AMOUNT]', "<input id='amount_{$item[id]}' class=cat_amount name='buscet[0]' value='" . ($buscet[$item[id]] * 1) . "'>", $buf);
	$buf = str_replace('[BUYLINK]', "javascript:document.location=\"?buy=$item[id]&amount=\"+document.all.amount_{$item[id]}.value", $buf);

	$this->body .= $buf;
  } 
}
if ($pages) $this->body .= str_replace("[pages]", "Страницы " . $pages . "<br><br>", $this->spec[postfix]);
else $this->body .= str_replace("[pages]", "", $this->spec[postfix]);
$this->body = str_replace("[filter]", $filter_text, $this->body);
// $this->body.="<br><br>Страницы ".$pages;

?>