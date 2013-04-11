
<?php

/************************** формируем фильтр блок ***************/

if ($this->spec[filter]) $filter_text = $this->spec[filter];

/*-----------------------------------------------------------------------*/
//попытаемся выташить id характеристик которые будут использоваться в фильтре
preg_match_all("'\[fld(.*?)\]'i",$filter_text,$par_arr);
if (count($par_arr) == 2){
	for ($i=0;$i < count($par_arr[1]);$i++){
		if ($par_arr[1][$i]) {
			$id_arr[] = $par_arr[1][$i];
			if (is_numeric($_GET["par".$i])){
				$form_id[$i] = $_GET["par".$i];
			}

  		}
	}

	for ($i=0;$i < count($id_arr);$i++){
		//узнаем тип данных, если тип данных select то выборка по таблице engine_CATALOG_possvals иначе по engine_CATALOG_values
		$f = return_type_date($id_arr[$i]);
		if ($f[select]){
			//тип селект
			$sql = "select * from engine_CATALOG_possvals where param = ".$id_arr[$i]." and id != 216";
		}
		else{
			$sql = "select value as val, value as id from engine_CATALOG_values where param = ".$id_arr[$i]." group by value";
		}
		$r2 = mysql_query("$sql") or die (mysql_error());
		//формируем  селект html
		$text_select = "<select name=\"par".$i."\" class=\"sel_search\">\n";
		$text_select .= "<option value=''>--------------</option>\n";

		$date_sql_arr = array();
		while ($select_value = mysql_fetch_array($r2)) {
			$date_sql_arr[] = $select_value;
		}
		usort($date_sql_arr, "low"); //сортируем
		for ($ii=0;$ii < count($date_sql_arr);$ii++){
			$selected = '';
			if ($form_id[$i] == $date_sql_arr[$ii][id]) {
				$selected = " selected";
				$pr_link .= "par".$i."=".$form_id[$i]."&";
			}
			$text_select .="<option value=\"".$date_sql_arr[$ii][id]."\"".$selected.">".$date_sql_arr[$ii][val]."</option>\n";
		}
		$text_select .= "</select>";
		$filter_text = str_replace("[fld".$id_arr[$i]."]",$text_select,$filter_text);
	}
}

/********** возврат типа данных*************************/
function return_type_date($id_date){
	//возврат типа данных
	$sql = "select * from engine_CATALOG_param where id = ".$id_date;
	$r = mysql_query("$sql") or die (mysql_error());
	$f = mysql_fetch_array($r);
	return $f;
}
 /********** Вспомогательная функция для сортировки *************************/
  function low($a, $b) 
  {
	if ($a['val'] == $b['val'])
	{
		return strcmp($a['val'], $b['val']);
	} 
	else return ($a['val'] < $b['val']) ? -1 : 1;
  }
?>
