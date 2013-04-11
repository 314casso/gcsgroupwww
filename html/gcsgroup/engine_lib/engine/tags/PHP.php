<?

if ($_GET[test] || strstr($do,";end;")){
//вариант с php кодом
/*
конструкции
1. [PHP do='if ($doc->code!="allnumbers") file_php(joke.php);else |BODY|;end;']
2. [PHP do='if ($doc->code!="allnumbers") file_php(joke.php);end;file_php(joke2.php);end;']
3. [PHP do='if ($doc->code=="allnumbers") file_php(joke.php);else {echo "<h1>";{|DOCFIELD type="caption_short"|;} echo "</h1>";};|BODY|;end;']
*/
	$do_arr = array();
	$do_arr = explode (";end;",$do);
	
	for ($do_i = 0; $do_i < count($do_arr); $do_i++) {
		if (!empty($do_arr[$do_i])){
			if (file_exists($do_arr[$do_i])){
				// конструкция типа xxxx.php;end;
	   	 	 	include_once $do_arr[$do_i];
     			}
			else {
				//сложная конструкция в которую внешний файл передается через file_php()
				if (strstr($do_arr[$do_i],"|")){
					//случай когда в php строчке есть спецтег |BODY|, спецтег заменяем спецфункцией
					preg_match_all("'\|(.*?)\|'i",$do_arr[$do_i],$do_tag_arr);

					if (count($do_tag_arr) == 2){
						for ($do_ii = 0; $do_ii < count($do_tag_arr[1]); $do_ii ++) {
							$do_tag_arr[1][$do_ii] = str_replace("  "," ",$do_tag_arr[1][$do_ii]);
							$do_tag_par_arr = explode (" ",$do_tag_arr[1][$do_ii],2);
							$do_tag_par_arr[1] = str_replace("\"","\'",$do_tag_par_arr[1]);
							$do_arr[$do_i] = str_replace("|".$do_tag_arr[1][$do_ii]."|","tag('".$do_tag_par_arr[0]."', '".$do_tag_par_arr[1]."');",$do_arr[$do_i]);
						}
						eval ($do_arr[$do_i].";");
					}
				}
				else{
					eval ($do_arr[$do_i].";");
				}
			}
		}
	}
}
else{
	//простой вариант
	if (file_exists($do)){
	     include $do;
     	}
	else {
		//echo $do;
		eval ($do);
	}
}



?>