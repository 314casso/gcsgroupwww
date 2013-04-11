<?
	include $_SERVER[DOCUMENT_ROOT]."/engine/config.inc";
	$name_dir_b = 'backup';
	$dir = $engine_show_root.'/'.$name_dir_b.'/';
	$date = date("YmdHis");
	$date_f = date("Y.m.d H:i:s");

	if (!file_exists($dir)) {
		mkdir($dir);
		chmod($dir,0775);
	}

	$name_backup_file = $dir."bd_".date("Ymdhis").".sql";
	$text = $date_f."##".$name_backup_file."##".$date."##\n";

	if (file_exists($dir.'list')) $file = fopen ($dir.'list',"r");
	if($file) {
		//вначале читаем 
		while(!feof($file)){ 
			$str=fgets($file);
			$text .= $str;
			$text_arr = explode("##",$str);
			if (count($text_arr) == 4){
				$select .= "<option value=\"".$text_arr[2]."\">".$text_arr[0]."</option>\n";
				$dir_arr_b[$text_arr[2]] = $text_arr[1];
			}
		}
		fclose($file);
	}
	if ($_POST[action] == "rebuild"){

		if (file_exists($dir_arr_b[$_POST[db]])){
			if ($testdb = @mysql_connect($db_host, $db_user,$db_pass)){
				//проверяем наличие БД с указанным именем
				if( !(@mysql_select_db($db_name, $testdb))){
					$dbmess="указано неверное имя базы";
					$err_bd = 1;
				}
				else {
					//очишаем бд
  					$t_list=mysql_list_tables($db_name);
					for($i=0;$i<mysql_num_rows($t_list);$i++) {
						//echo " - ".mysql_tablename($t_list,$i)."<br>\n";
						mysql_query("DROP TABLE ".mysql_tablename($t_list,$i));
						//$fields=mysql_list_fields($r_db->Database);
 					}
					//теперь обновляем ее
					if (file_exists($dir_arr_b[$_POST[db]])){
						$file = fopen($dir_arr_b[$_POST[db]], 'rb');
			            		$content = fread($file, filesize($dir_arr_b[$_POST[db]]));
						$content = str_replace(" select "," `select` ",$content);
						$content = str_replace(" desc "," `desc` ",$content);
						$content = str_replace(" in smallint"," `in` smallint",$content);
						//echo $content;
						//$content = str_replace("`","\"",$content);
			            		fclose($file);
						$f = fopen($dir_arr_b[$_POST[db]], "w+");
						if($f) {
							fwrite($f, $content);
							fclose($f);
						}

						$dir_ = "mysql -u'".$db_user."' -p'".$db_pass."' ".$db_name." < ". $dir_arr_b[$_POST[db]];
						system($dir_);
						//echo $dir_;
						$err = 4;
					}
				}
				mysql_close($testdb);
			}
		}
		else{
			$err = 3;
		}
	}
	IF ($_POST[action] == "back"){
		//echo "mysqldump -u'$db_user' -p'$db_pass' $db_name > $name_backup_file";
		system("mysqldump -Q -u'$db_user' -p'$db_pass' $db_name > $name_backup_file");
		chmod($name_backup_file,0775);
		//записываем в список бекапов
		$f = fopen($dir.'list', "w+");
		if($f) {
			fwrite($f, $text);
			fclose($f);
			$err = 2;
		}
		else{
			$err = 1;
		}
	}
	if (($err) && $_POST[action]){
  		?>
		<META HTTP-EQUIV="Refresh" CONTENT="0; URL=?err=<? echo $err;?>">
		<?
	}


?>
<style>
form{
margin-top:10px;
}
</style>
<?
 if ($select){
?>
<form action="" method="post">
<input name="action" type="hidden" value="rebuild">
Восстановление 
<?
	echo "<select name=\"db\">".$select."</select>\n";

?>
<input name="Да" type="submit" value="Да"> <? if ($_GET[err] == 4) echo "<span style=color:red>Восстановлено</span>";?>

</form>
<hr>
<?
}
?>

<form action="" method="post">
<input name="action" type="hidden" value="back">

Сделать backUp БД
<input name="Да" type="submit" value="Да"> <? if ($_GET[err] == 2) echo "<span style=color:red>Добавлено</span>";?>

</form>


<?
function PMA_splitSqlFile(&$ret, $sql, $release)
{
    $sql          = trim($sql);
    $sql_len      = strlen($sql);
    $char         = '';
    $string_start = '';
    $in_string    = FALSE;
    $time0        = time();

    for ($i = 0; $i < $sql_len; ++$i) {
        $char = $sql[$i];

        // We are in a string, check for not escaped end of strings except for
        // backquotes that can't be escaped
        if ($in_string) {
            for (;;) {
                $i         = strpos($sql, $string_start, $i);
                // No end of string found -> add the current substring to the
                // returned array
                if (!$i) {
                    $ret[] = $sql;
                    return TRUE;
                }
                // Backquotes or no backslashes before quotes: it's indeed the
                // end of the string -> exit the loop
                else if ($string_start == '`' || $sql[$i-1] != '\\') {
                    $string_start      = '';
                    $in_string         = FALSE;
                    break;
                }
                // one or more Backslashes before the presumed end of string...
                else {
                    // ... first checks for escaped backslashes
                    $j                     = 2;
                    $escaped_backslash     = FALSE;
                    while ($i-$j > 0 && $sql[$i-$j] == '\\') {
                        $escaped_backslash = !$escaped_backslash;
                        $j++;
                    }
                    // ... if escaped backslashes: it's really the end of the
                    // string -> exit the loop
                    if ($escaped_backslash) {
                        $string_start  = '';
                        $in_string     = FALSE;
                        break;
                    }
                    // ... else loop
                    else {
                        $i++;
                    }
                } // end if...elseif...else
            } // end for
        } // end if (in string)

        // We are not in a string, first check for delimiter...
        else if ($char == ';') {
            // if delimiter found, add the parsed part to the returned array
            $ret[]      = substr($sql, 0, $i);
            $sql        = ltrim(substr($sql, min($i + 1, $sql_len)));
            $sql_len    = strlen($sql);
            if ($sql_len) {
                $i      = -1;
            } else {
                // The submited statement(s) end(s) here
                return TRUE;
            }
        } // end else if (is delimiter)

        // ... then check for start of a string,...
        else if (($char == '"') || ($char == '\'') || ($char == '`')) {
            $in_string    = TRUE;
            $string_start = $char;
        } // end else if (is start of string)

        // ... for start of a comment (and remove this comment if found)...
        else if ($char == '#'
                 || ($char == ' ' && $i > 1 && $sql[$i-2] . $sql[$i-1] == '--')) {
            // starting position of the comment depends on the comment type
            $start_of_comment = (($sql[$i] == '#') ? $i : $i-2);
            // if no "\n" exits in the remaining string, checks for "\r"
            // (Mac eol style)
            $end_of_comment   = (strpos(' ' . $sql, "\012", $i+2))
                              ? strpos(' ' . $sql, "\012", $i+2)
                              : strpos(' ' . $sql, "\015", $i+2);
            if (!$end_of_comment) {
                // no eol found after '#', add the parsed part to the returned
                // array if required and exit
                if ($start_of_comment > 0) {
                    $ret[]    = trim(substr($sql, 0, $start_of_comment));
                }
                return TRUE;
            } else {
                $sql          = substr($sql, 0, $start_of_comment)
                              . ltrim(substr($sql, $end_of_comment));
                $sql_len      = strlen($sql);
                $i--;
            } // end if...else
        } // end else if (is comment)

        // ... and finally disactivate the "/*!...*/" syntax if MySQL < 3.22.07
        else if ($release < 32270
                 && ($char == '!' && $i > 1  && $sql[$i-2] . $sql[$i-1] == '/*')) {
            $sql[$i] = ' ';
        } // end else if

        // loic1: send a fake header each 30 sec. to bypass browser timeout
        $time1     = time();
        if ($time1 >= $time0 + 30) {
            $time0 = $time1;
            header('X-pmaPing: Pong');
        } // end if
    } // end for

    // add any rest to the returned array
    if (!empty($sql) && ereg('[^[:space:]]+', $sql)) {
        $ret[] = $sql;
    }

    return TRUE;
} // end of the 'PMA_splitSqlFile()' function


?>
	
