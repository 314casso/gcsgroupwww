<?
$dir = "/home/www-root/htdocs/";
if ($dir && $_POST[action] != "test"){
  $handle=opendir("$dir");
  while ($file = readdir($handle)) {
	//echo $dir.$file."/engine/config.inc<br>";
	if(file_exists($dir.$file."/engine/config.inc") && !strstr($file,"engine") && $file != "." && file_exists($dir.$file."/engine_lib/label")) {
		$option .= "<option value=\"".$file."\">".$file."</option>\n";
		$opt_arr[] = $file;
	}
  }
  closedir($handle);
}
	echo "<table border=\"1\">\n";
	echo "<tr>\n<td>Проект</td>\n<td>менять поля</td>\n<td>вставить поля</td>\n<td>создать таблицы</td>\n</tr>\n";
	for($i_ = 0; $i_ < count($opt_arr); $i_++){
		$_POST[project] = $opt_arr[$i_];
		if ($_POST[project] && $_POST[project]!= "---------"){
			//echo $dir.$_POST[project]."/engine/config.inc<br>";
			include($dir.$_POST[project]."/engine/config.inc");
			$_POST[db_user] = $db_user;
			$_POST[db_pass] = $db_pass;
			$_POST[db_name] = $db_name;

		}
		$db_user = $_POST[db_user];
		$db_pass = $_POST[db_pass];
		$db_name = $_POST[db_name];
			//echo $db_user."======".$db_pass."===============".$db_name;
		$db = mysql_connect($db_host, $db_user,$db_pass)
		or die("Unable to connect to sql server\n");
		mysql_select_db($db_name, $db) or die("Unable to select database\n");
		mysql_close();
		$db = 1;
		//читаем txt идеальной бд
		// указываем путь
		$dir_content = "/home/www-root/htdocs/engine1_8/script";
		$file = fopen ($dir_content.'/create_bd.sql',"r");
		if($file) {
			while(!feof($file)){ 
				$exist_foto = array();
				$str = fgets($file);
				$text .= $str;

			}
			fclose($file);
			$text = str_replace("\n"," ",$text);

		}
		preg_match_all("'CREATE TABLE(.*?);'i", $text, $date_arr);
		if (count($date_arr) == 2){
			//заносим все для идеальной бд
			$idial_arr = list_value($date_arr[1]);
		}


		//теперь указываем где лежит бд которая нам нужна
		//$dir = "/home/www-root/htdocs/engine_test";
		//include($dir."/engine/config.inc");
		$name_backup_file = $dir_content."/temp/bd.sql";
		system("mysqldump -Q -d -u'$db_user' -p'$db_pass' $db_name > $name_backup_file");
		$file = fopen ($name_backup_file,"r");
		$text = '';
		$date_arr = array();
		if($file) {
			while(!feof($file)){ 
				$exist_foto = array();
				$str = fgets($file);
				$text .= $str;
			}
			fclose($file);
			$text = str_replace("\n"," ",$text);
		}
		preg_match_all("'CREATE TABLE(.*?);'i", $text, $date_arr);
		if (count($date_arr) == 2){
			//заносим все для идеальной бд
			$now_arr = list_value($date_arr[1]);
	/*   echo "<pre>";
	   print_r($now_arr);	   
	   echo "</pre>";*/
		}
   	
		// 3. сравниваем две бд
		$idial_arr_temp = $idial_arr;
		while(list($key, $value) = each($now_arr)) {
			if ($idial_arr[$key]){
				//таблица под данным именем существует
				unset($idial_arr_temp[$key]);
				//4. сравниваем данные
				if ($idial_arr[$key][NOFORM] == $now_arr[$key][NOFORM]){
					//т.е. все нормально, одинаковы
				}
				else{

					//ишем в каком поле отличается от идеального
					$arr_temp_bd = array();
					$arr_temp_bd = $idial_arr[$key]["LIST"];
					reset($arr_temp_bd);

					for($f = 0; $f < count($now_arr[$key]["LIST"]); $f++){

						$exist_ = 0;
						$value = '';
						$name = '';

						for($i = 0; $i < count($idial_arr[$key]["LIST"]); $i++){	
							if ($idial_arr[$key]["LIST"][$i][NAME] == $now_arr[$key]["LIST"][$f][NAME]) {
								if ($idial_arr[$key]["LIST"][$i][VALUE] != $now_arr[$key]["LIST"][$f][VALUE]) {
									//случай обновления полей
									$exist_ = 1;
									$name = $idial_arr[$key]["LIST"][$i][NAME];
									$value = $idial_arr[$key]["LIST"][$i][VALUE];
									//удаляем из массива, чтоб знать какие поля следует вставлять
								}
								unset($arr_temp_bd[$i]);
							}
						}
						//echo $exist_;
						if ($exist_ == 1)  $now_arr[$key][CHANGE_SHIELD][] = array("NAME"=> $name, "VALUE" =>$value);

					}
					if (count($arr_temp_bd)){
						//значит чтото нет в текущей бд
						while(list($key2, $value2) = each($arr_temp_bd)) {
							$now_arr[$key][INSERT_SHIELD][] = array("NAME"=> $value2["NAME"], "VALUE" =>$value2["VALUE"]);
						}

					}
				}
			}
			else{
				/*echo "<pre>";
   				print_r($key);	   
   				echo "</pre>";*/		
			}
		}
		reset($now_arr);
		$text = "";
		$change_filed = 0;
		$insert_filed = 0;
		$create_filed = 0;
		while(list($key, $value) = each($now_arr)) {
			if ($value["CHANGE_SHIELD"]){
				//$text .= "<hr>Обновить свойства полей в <b>".$value["BD"]."</b>\n"; 
				while(list($key2, $value2) = each($value["CHANGE_SHIELD"])) {
					$text .= "<br>ALTER TABLE `".str_replace(" ","",$value["BD"])."` CHANGE `".str_replace(" ","",$value2["NAME"])."` `".str_replace(" ","",$value2["NAME"])."` ".$value2["VALUE"].";<br>\n"; 
					$change_filed++;
				}
			}
			if ($value["INSERT_SHIELD"]){
				//$text .= "<hr>Вставить поля в <b>".$value["BD"]."</b>\n"; 
				while(list($key2, $value2) = each($value["INSERT_SHIELD"])) {
					$insert_filed++;
					$text .= "<br>ALTER TABLE `".str_replace(" ","",$value["BD"])."` ADD  `".str_replace(" ","",$value2["NAME"])."` ".$value2["VALUE"].";<br>\n"; 
				}
			}
		}
		if (count($idial_arr_temp)){
			while(list($key, $value) = each($idial_arr_temp)) {
				//$text .= "<hr>Вставить новую таблицу в <b>".$value["BD"]."</b>\n";
				$text .= "<br>CREATE TABLE ".$value["NOFORM"].";<br>\n";  
				$create_filed++;
			}	
		}

		echo "<tr>\n<td>".$_POST[project]."</td>\n<td>".$change_filed."</td>\n<td>".$insert_filed."</td>\n<td>".$create_filed."</td>\n</tr>\n";
		//echo $text."<hr>UPDATE `engine_conf` SET `varvalue` = '1.8' WHERE `varname` ='version' LIMIT 1 ;";
	}
	echo "</table>\n";
			/*echo "<pre>";
   			print_r($idial_arr_temp);	   
   			echo "</pre>";*/
















function list_value ($text){
//заносим все для идеальной бд
	while(list($key, $value) = each($text)) {
		if (strstr($value,"engine")){

			$temp_arr = explode(" AUTO_INCREMENT",$value);
			$value = $temp_arr[0];
			$temp_arr = explode(", ",$value);
			$name_bd_arr = explode("(",$temp_arr[0]);
			$name_bd_arr = explode("`",$name_bd_arr[0]);
			if (count($name_bd_arr) == 3){
				$name_bd = $name_bd_arr[1];
				$temp_arr[0] = str_replace("`".$name_bd."` (  ", "",$temp_arr[0]);
				$temp_name_value_arr = array();
				for($f = 0; $f < count($temp_arr) - 1; $f++){
					$name_value_arr = explode("` ",$temp_arr[$f]);
					if (count($name_value_arr) == 2){
						//$name_value_arr[1] = str_replace("( ","(",$name_value_arr[1]);
						//$name_value_arr[1] = str_replace(" )",")",$name_value_arr[1]);
						$temp_name_value_arr[] = array("NAME" => str_replace(" `","",$name_value_arr[0]), "VALUE" => $name_value_arr[1]);
					}
				}
				$temp_name_bd_arr[$name_bd] = array("BD"=>$name_bd,"NOFORM"=>str_replace("  "," ",$value),"LIST"=>$temp_name_value_arr);
			}	
		}		
	}
	return $temp_name_bd_arr;
}
	
?> 