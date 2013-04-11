<?php

include 'config.inc';
ob_start();

$action = $_REQUEST['action'];

function DieError($title, $text)
{
        ?>
  <tr><th class="error"><?=$title?></th></tr>
  <tr>
    <td style="height: 50px;" align="center"><?=$text?></td>
  </tr>
  <tr>
    <td align="center"><input type="button" name="close" value="Закрыть" class="com_button" onclick="javascript:window.close();"></td>
  </tr>
</table>
        <?
}

function GetDocInfo($doc_id)
{	$sql = 'SELECT *
	        FROM engine_documents
	        WHERE id = '.$doc_id;

	if ($result = @mysql_query($sql))
	{		if ($row = @mysql_fetch_array($result, MYSQL_ASSOC))
		{			return $row;
		}
	}

	return false;
}

function CheckUnDel($doc_id)
{	$sql = 'SELECT *
	        FROM engine_documents
	        WHERE pid = '.$doc_id;

	$fun_res = false;

	if ($result = @mysql_query($sql))
	{		while ($row = @mysql_fetch_array($result, MYSQL_ASSOC))
		{			if ($row['undeletable'] == 0)
			{				$fun_res = CheckUnDel($row['id']);
				if ($fun_res !== false)
				{					return $fun_res;
				}
			}
			else
			{				return $row['name'];
			}
		}
	}

	return $fun_res;
}

function DelDoc($doc_id)
{	global $logged;
	$sql = 'SELECT *
	        FROM engine_documents
	        WHERE pid = '.$doc_id;

	if ($result = @mysql_query($sql))
	{		while ($row = @mysql_fetch_array($result, MYSQL_ASSOC))
		{			if (DelDoc($row['id']) === false)
			{				return false;
			}
		}
	}
	else
	{		DieError('SQL Error', $sql);
		return false;
	}

	$sql = 'SELECT *
	        FROM engine_documents
	        WHERE id = '.$doc_id;

	if ($result = @mysql_query($sql))
	{		if ($row = @mysql_fetch_array($result, MYSQL_ASSOC))
		{			$doc = $row;
		}
		else
		{			DieError('Документ не найден', 'Указанный документ не найден');
			return false;
		}
	}
	else
	{		DieError('SQL Error', $sql);
		return false;
	}

	$text = 'Удаление документа \''.$doc['name'].'\'';
	$sql = 'INSERT INTO engine_log (log_date, user, text, document)
                                 VALUES (NOW(), "'.$logged['id'].'", "'.mysql_real_escape_string($text).'", '.$doc_id.')';

	if (!($result = @mysql_query($sql)))
	{		DieError('SQL Error', $sql);
		return false;
	}

	$sql = 'DELETE FROM engine_documents
	        WHERE id = '.$doc_id;

	if (!($result = @mysql_query($sql)))
	{
		DieError('SQL Error', $sql);
		return false;
	}

	return true;

}

if ($action == 'newfolder')
{
        ?>
<table border="0" cellSpacing="2" cellPadding="3" class="line" width="100%" align="center" style="height: 100%;">
        <?
        $p_name = $_REQUEST['folder_name'];
        $p_action = isset($_REQUEST['create']);
        $pid = intval($_REQUEST['pid']);
        if (($pid == 0)||($pid < -1))
        {
                $title = 'Некорректная папка';
                DieError($title, 'Вы можете добавлять папки только к папкам.');
        }
        elseif (getrights($pid) != 1)
        {
                $title = 'Недостаточно прав';
                DieError($title, 'У вас недостаточно прав для добавления папки.');
        }
        elseif (empty($p_name)&&$p_action)
        {        	$title = 'Некорректное имя';
                DieError($title, 'Вы не можете создавать папку с путым именем.');
        }
        else
        {
                $sql = 'SELECT id, type
                        FROM engine_documents
                        WHERE id = "'.$pid.'"';

                $result = @mysql_query($sql);
                if (($row = @mysql_fetch_array($result, MYSQL_ASSOC))||($pid == -1))
                {
                        if (($row['type'] == 'FOLDER')||($pid == -1))
                        {
                                if ($p_action)
                                {
                                        $p_code = $_REQUEST['folder_code'];
                                        $p_pid  = $_REQUEST['pid'];
						//'.mysql_real_escape_string($def_title).'
                                        $sql = 'INSERT INTO engine_documents (name, pid, type, creation_date, title, meta, counter1, counter2, counter3, code)
                                                                      VALUES ("'.mysql_real_escape_string($p_name).'", '.$p_pid.', "FOLDER", NOW(), "", "'.mysql_real_escape_string($def_meta).'", "'.mysql_real_escape_string($def_counter1).'", "'.mysql_real_escape_string($def_counter2).'", "'.mysql_real_escape_string($def_counter3).'", "'.mysql_real_escape_string(engine_get_preferred_document_code($p_name, $p_code)).'")';

                                        if ($result = @mysql_query($sql))
                                        {
                                                $sql = 'INSERT INTO engine_log (log_date, user, text, document)
                                                                        VALUES (NOW(), "'.$logged['id'].'", "'.mysql_real_escape_string('Создание папки \''.$p_name.'\'').'", "'. mysql_insert_id() . '")';

                                                if (!$result = @mysql_query($sql))
                                                {
                                                        $title = 'SQL ошибка';
                                                        DieError($title, 'SQL ошибка: '.$sql);
                                                }

                                                $sql = 'SELECT id, pid, name, type, ord
                                                        FROM engine_documents
                                                        WHERE type NOT IN ("CATALOGITEM", "NEW") AND pid = '.$p_pid.'
                                                        ORDER BY ord, name';

                                                if (!$result = @mysql_query($sql))
                                                {
                                                        $title = 'SQL ошибка';
                                                        DieError($title, 'SQL ошибка: '.$sql);
                                                }
                                                ?>
                                                <script>
                                                <?
                                                $temp_str = 'sData.doc_pids['.$p_pid.'] = new Array(';
                                                while ($row = @mysql_fetch_array($result, MYSQL_ASSOC))
                                                {
                                                        echo "sData.SetDocInfo('".$row['id']."', '".$row['pid']."', '".addslashes($row['name'])."', '".strtolower($row['type'])."', '".$row['ord']."');\n";
                                                        $temp_str .= "'".$row['id']."', ";
                                                }
                                                $temp_str = substr($temp_str, 0, -2);
                                                $temp_str .= ");\n\n";
                                                echo $temp_str;
                                                ?>
                                                sData.ReDrawDoc(<?=$p_pid?>);
  function CreateWindow()
  {
          window.close();
          sData.showModalDialog("actions.php?action=newfolder&pid=<?=$pid?>", sData, "dialogHeight: 500px; dialogWidth: 300px; center: Yes; scroll: No; help: No;");
  }
                                                </script>
  <tr><th>Папка добавлена</th></tr>
  <tr>
    <td style="height: 50px;" align="center">Папка была успешено добавлена.</td>
  </tr>
  <tr>
    <td align="center"><input type="button" name="close" value="Добавить еще" class="com_button" onclick="javascript:CreateWindow();">&nbsp;<input type="button" name="close" value="Закрыть" class="com_button" onclick="javascript:window.close();"></td>
  </tr>
</table>
                                                <?
                                        }
                                        else
                                        {
                                                $title = 'SQL ошибка';
                                                DieError($title, 'SQL ошибка: '.$sql);
                                        }

                                }
                                else
                                {
                                        $title = 'Создание новой папки';
                                        ?>
  <tr><th>Добавление папки</th></tr>
  <tr>
    <td>
      <table border="0" cellSpacing="0" cellPadding="0">
        <tr><td nowrap="nowrap" valign="top"><span class="cat"><img src="img/arrow.gif" border="0" vspace="2"> В папку:&nbsp;</span></td><td width="100%"><u id="folder_name" class="com_link"></u></td></tr>
      </table>
    </td>
  </tr>
  <form action="" name="form1">
  <tr>
    <td><span class="cat"><img src="img/arrow.gif" brder="0" vspace="2"> Наименование папки</span></td>
  </tr>
  <tr>
    <td><input type="text" name="folder_name" value="" class="com_input" id="folder_name"></td>
  </tr>
  <tr>
    <td><span class="cat"><img src="img/arrow.gif" brder="0" vspace="2"> Код папки (не обязательно)</span></td>
  </tr>
  <tr>
    <td><input type="text" name="folder_code" value="" class="com_input" id="folder_code"></td>
  </tr>
  <script>
  function SubmitForm()
  {
          fn = form1.folder_name.value;
          fc = form1.folder_code.value;
          window.close();
          sData.showModalDialog("actions.php?action=newfolder&pid=<?=$pid?>&create=1&folder_code="+fc+"&folder_name="+fn, sData, "dialogHeight: 500px; dialogWidth: 300px; center: Yes; scroll: No; help: No;");
  }
  </script>
  <tr>
    <td align="center"><input type="button" name="create" value="Создать" class="com_button" onclick="javascript:SubmitForm();"></td>
  </tr>
    <input type="hidden" name="action" value="newfolder">
    <input type="hidden" name="pid" value="<?=$pid;?>">
  </form>
</table>
                                        <?
                                }
                        }
                        else
                        {
                                $title = 'Не папка';
                                DieError($title, 'Вы можете добавлять папки только к папкам.');
                        }
                }
                else
                {
                        $title = 'SQL ошибка';
                        DieError($title, 'SQL ошибка: '.$sql);
                }
        }
}
elseif ($action == 'deldoc')
{	?>
<table border="0" cellSpacing="2" cellPadding="3" class="line" width="100%" align="center" style="height: 100%;">
	<?
	$doc_id = intval($_REQUEST['id']);
	$doc = GetDocInfo($doc_id);
	if ($doc_id <= 0)
	{		$title = 'Некорректная папка';
		DieError($title, 'Вы не можете удалять корневую папку');
	}
	elseif (getrights($doc['pid']) != 1)
	{		$title = 'Недостаточно прав';
		DieError($title, 'У вас недостаточно прав для добавления папки.');
	}
	else
	{		if ($doc['undeletable'] != 0)
		{			$title = 'Невозможно удалить';
			DieError($title, 'Удаление этого документа нарушит целостность сайта.');
		}
		else
		{			$yes = intval($_REQUEST['yes']);
			if ($yes != 1)
			{				if ($doc['type'] == 'NEW')
				{					$sql = 'SELECT *
					        FROM engine_NEW
					        WHERE id = '.$doc['id'];

					if ($result = @mysql_query($sql))
					{						if ($row = @mysql_fetch_array($result, MYSQL_ASSOC))
						{							$doc['name'] = $row['header'];
						}
					}
				}				?>
<script>
function SubmitForm()
{	window.close();
	sData.showModalDialog("actions.php?action=deldoc&id=<?=$doc_id?>&yes=1", sData, "dialogHeight: 500px; dialogWidth: 300px; center: Yes; scroll: No; help: No;");
}
</script>

<tr><th colspan="2">Удаление документа</th></tr>
<tr><td valign="top" nowrap="nowrap"><span class="cat"><img src="img/arrow.gif" border="0" vspace="2"> Документ:&nbsp;</span></td><td width="100%"><u id="doc_name" class="com_link"><?=$doc['name']?></u></td></tr>
<tr><td colspan="2" align="center">Вы уверены, что хотите удалить этот документ?</td></tr>
<tr><td colspan="2" align="center"><input type="button" class="com_input" value="Да" style="width: 75px;" onclick="javascript:SubmitForm();" /> <input type="button" class="com_input" value="Нет" style="width: 75px;" onclick="javascript:window.close();" /></td></tr>
</table>
				<?
			}
			else
			{				if (($result = CheckUnDel($doc_id)) === false)
				{					if (DelDoc($doc_id) !== false)
					{						?>
<tr><th>Удаление документа</th></tr>
<tr><td align="center">Документ был успешно удален.</td></tr>
<tr><td align="center"><input type="button" class="com_input" value="Закрыть" style="width: 75px;" onclick="javascript:window.close();" /></td></tr>
</table>
<script>
						<?
							$sql = 'SELECT id, pid, name, type, ord
								FROM engine_documents
								WHERE type NOT IN ("CATALOGITEM", "NEW") AND pid = '.$doc['pid'].'
								ORDER BY ord, name';

							if (!$result = @mysql_query($sql))
							{								$title = 'SQL ошибка';
								DieError($title, 'SQL ошибка: '.$sql);
							}

							$temp_str = 'sData.doc_pids['.$doc['pid'].'] = new Array(';

							while ($row = @mysql_fetch_array($result, MYSQL_ASSOC))
       							{       								echo "sData.SetDocInfo('".$row['id']."', '".$row['pid']."', '".addslashes($row['name'])."', '".strtolower($row['type'])."', '".$row['ord']."');\n";
								$temp_str .= "'".$row['id']."', ";
							}

							$temp_str = substr($temp_str, 0, -2);
							$temp_str .= ");\n\n";
							echo $temp_str;
						?>
sData.ReDrawDoc(<?=$doc['pid']?>);
</script>
						<?
					}
				}
				else
				{					$title = 'Невозможно удалить';
					DieError($title, 'Этот документ содержит неудаляемый документ <u class="com_link">'.$result.'</u>.');
				}			}
		}
	}
}
elseif ($action == 'newdoc')
{
        ?>
<table border="0" cellSpacing="2" cellPadding="3" class="line" width="100%" align="center" style="height: 100%;">
        <?
        $pid = intval($_REQUEST['pid']);
        $p_name = $_REQUEST['doc_name'];
        $p_action = isset($_REQUEST['create']);
        if (($pid == 0)||($pid < -1))
        {
                $title = 'Некорректная папка';
                DieError($title, 'Вы можете добавлять папки только к папкам.');
        }
        elseif (getrights($pid) != 1)
        {
                $title = 'Недостаточно прав';
                DieError($title, 'У вас недостаточно прав для добавления папки.');
        }
        elseif (empty($p_name)&&$p_action)
        {
        	$title = 'Некорректное имя';
                DieError($title, 'Вы не можете создавать документ с путым именем.');
        }
        else
        {
                $sql = 'SELECT id, type
                        FROM engine_documents
                        WHERE id = "'.$pid.'"';

                $result = @mysql_query($sql);
                if (($row = @mysql_fetch_array($result, MYSQL_ASSOC))||($pid == -1))
                {                	$p_type = $_REQUEST['doc_type'];
                	$p_code = trim($_REQUEST['doc_code']);

                        if (($row['type'] == 'FOLDER')||($pid == -1)||(($row['type'] == 'CATALOG')&&($p_type == 'CATALOGITEM'))||(($row['type'] == 'NEWSGROUP')&&($p_type == 'NEW')))
                        {
                                if ($p_action)
                                {
                                        $p_pid  = $_REQUEST['pid'];
//'.mysql_real_escape_string($def_title).'
                                        $sql = 'INSERT INTO engine_documents (name, pid, type, creation_date, title, meta, counter1, counter2, counter3, code)
                                                                      VALUES ("'.mysql_real_escape_string($p_name).'", '.$p_pid.', "'.mysql_real_escape_string($p_type).'", NOW(), "", "'.mysql_real_escape_string($def_meta).'", "'.mysql_real_escape_string($def_counter1).'", "'.mysql_real_escape_string($def_counter2).'", "'.mysql_real_escape_string($def_counter3).'", "'.mysql_real_escape_string(engine_get_preferred_document_code($p_name, $p_code)).'")';

                                        if ($result = @mysql_query($sql))
                                        {
		   					if ($p_type == 'NEWSGROUP'){
                                       			$sql_1 = "INSERT INTO engine_NEWSGROUP (doc_id) VALUES ('".mysql_insert_id()."')";
								//echo $sql_1;
								mysql_query($sql_1);
				    			}


                                                $sql = 'INSERT INTO engine_log (log_date, user, text, document)
                                                                        VALUES (NOW(), "'.$logged['id'].'", "'.mysql_real_escape_string('Создание документа \''.$p_name.'\'').'", "'. mysql_insert_id() . '")';

                                                if (!$result = @mysql_query($sql))
                                                {
                                                        $title = 'SQL ошибка';
                                                        DieError($title, 'SQL ошибка: '.$sql);
                                                }

                                                if (($d_type != 'CATALOGITEM')&&($d_type != 'NEW'))
                                                {                                                	$sql = 'SELECT id, pid, name, type, ord
                                                                FROM engine_documents
                                                                WHERE type NOT IN ("CATALOGITEM", "NEW") AND pid = '.$p_pid.'
                                                                ORDER BY ord, name';

                                                	if (!$result = @mysql_query($sql))
                                                	{                                                		$title = 'SQL ошибка';
                                                        	DieError($title, 'SQL ошибка: '.$sql);
                                                	}
                                                	?>
                                                	<script>
                                                	<?
                                                	$temp_str = 'sData.doc_pids['.$p_pid.'] = new Array(';
                                                	while ($row = @mysql_fetch_array($result, MYSQL_ASSOC))
                                                	{
                                                        	echo "sData.SetDocInfo('".$row['id']."', '".$row['pid']."', '".addslashes($row['name'])."', '".strtolower($row['type'])."', '".$row['ord']."');\n";
                                                        	$temp_str .= "'".$row['id']."', ";
                                                	}
                                                	$temp_str = substr($temp_str, 0, -2);
                                                	$temp_str .= ");\n\n";
                                                	echo $temp_str;
                                                	?>
  sData.ReDrawDoc(<?=$p_pid?>);
  function CreateWindow()
  {
          window.close();
          sData.showModalDialog("actions.php?action=newdoc&pid=<?=$pid?>", sData, "dialogHeight: 500px; dialogWidth: 300px; center: Yes; scroll: No; help: No;");
  }
                                                </script>
                                                <?
                                                }
                                                ?>
  <tr><th>Документ создан</th></tr>
  <tr>
    <td style="height: 50px;" align="center">Документ был успешено создан.</td>
  </tr>
  <tr>
    <td align="center"><?if (($d_type != 'CATALOGITEM')&&($d_type != 'NEW')) {?><input type="button" name="close" value="Добавить еще" class="com_button" onclick="javascript:CreateWindow();">&nbsp;<?}?><input type="button" name="close" value="Закрыть" class="com_button" onclick="javascript:window.close();"></td>
  </tr>
</table>
                                                <?
                                        }
                                        else
                                        {
                                                $title = 'SQL ошибка';
                                                DieError($title, 'SQL ошибка: '.$sql);
                                        }

                                }
                                else
                                {
                                        $title = 'Создание нового документа';
                                        ?>
  <tr><th>Добавление документа</th></tr>
  <tr>
    <td>
      <table border="0" cellSpacing="0" cellPadding="0">
        <tr><td nowrap="nowrap" valign="top"><span class="cat"><img src="img/arrow.gif" border="0" vspace="2"> В папку:&nbsp;</span></td><td width="100%"><u id="folder_name" class="com_link"></u></td></tr>
      </table>
    </td>
  </tr>
  <form action="" name="form1">
  <tr>
    <td><span class="cat"><img src="img/arrow.gif" brder="0" vspace="2"> Наименование документа</span></td>
  </tr>
  <tr>
    <td><input type="text" name="doc_name" value="" class="com_input" id="doc_name"></td>
  </tr>
  <tr>
    <td><span class="cat"><img src="img/arrow.gif" brder="0" vspace="2"> Код документа (не обязательно)</span></td>
  </tr>
  <tr>
    <td><input type="text" name="doc_code" value="" class="com_input" id="doc_code"></td>
  </tr>
  <tr>
    <td><span class="cat"><img src="img/arrow.gif" brder="0" vspace="2"> Тип документа</span></td>
  </tr>
  <tr>
    <td>
    <select name="doc_type" class="com_input" id="doc_type">
    <?
    $handle = opendir('doc_types');
    while (false !== ($dtype = readdir($handle)))
    {    	if ($dtype != "." && $dtype != ".." && is_dir('doc_types/'.$dtype) && $dtype != 'FOLDER')
    	{    		if (testdoc_type($dtype))
    		{    			$filename = 'doc_types/'.$dtype.'/name.txt';
			if (file_exists($filename))
			{				$ff = file($filename);
				if ($ff[1] == 'отображать')
				{					echo '<option value="'.$dtype.'">';
					echo $ff[0];
					echo '</option>';
				}
			}
		}
	}
    }
    closedir($handle);
    ?>
    </td>
    </select>
  </tr>
  <script>
  function SubmitForm()
  {
          dn = form1.doc_name.value;
          dt = form1.doc_type.value;
          dc = form1.doc_code.value;
          window.close();
          sData.showModalDialog("actions.php?action=newdoc&pid=<?=$pid?>&create=1&doc_code="+dc+"&doc_name="+dn+"&doc_type="+dt, sData, "dialogHeight: 500px; dialogWidth: 300px; center: Yes; scroll: No; help: No;");
  }
  </script>
  <tr>
    <td align="center"><input type="button" name="create" value="Создать" class="com_button" onclick="javascript:SubmitForm();"></td>
  </tr>
    <input type="hidden" name="action" value="newfolder">
    <input type="hidden" name="pid" value="<?=$pid;?>">
  </form>
</table>
                                        <?
                                }
                        }
                        else
                        {
                                $title = 'Не папка';
                                DieError($title, 'Вы можете добавлять документы только к папкам.');
                        }
                }
                else
                {
                        $title = 'SQL ошибка';
                        DieError($title, 'SQL ошибка: '.$sql);
                }
        }
}
elseif($action == 'moveto')
{        ?>
<table border="0" cellSpacing="2" cellPadding="3" class="line" width="100%" align="center" style="height: 100%;">
        <?
        $pid = intval($_REQUEST['pid']);
        if (($pid == 0)||($pid < -1))
        {
                $title = 'Некорректная папка';
                DieError($title, 'Вы можете добавлять папки только к папкам.');
        }
        elseif (getrights($pid) != 1)
        {
                $title = 'Недостаточно прав';
                DieError($title, 'У вас недостаточно прав для добавления папки.');
        }
        else
        {        	;
        }
}
else
{	?>
<table border="0" cellSpacing="2" cellPadding="3" class="line" width="100%" align="center" style="height: 100%;">
	<?
	$title = 'Неизвестное действие';
	DieError($title, 'Данное действие не зарегестрировано в этом модуле. Обратитесь к администратору.');
}


$content = ob_get_contents();
ob_end_clean();

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 3.2 Final//EN">
<html>
<head>
  <title><?=$title?></title>
  <LINK href="<?=$engine_htroot?>/engine/main.css" rel="stylesheet" type="text/css">
</head>
<body onload="javascript: resize();">
<script>
var sData = window.dialogArguments;;
function resize()
{
        folder = document.getElementById("folder_name");
        if (folder)
        {
                value = sData.GetDocInfo(<?=$pid?>)[2];
                folder.innerHTML = value;
        }

        st = document.getElementById("screen_table");
        sth = st.clientHeight; //155   220
        mt = document.getElementById("main_table");
        mth = mt.clientHeight; //107   211
        window.dialogHeight = (Math.abs(500-sth)+mth+4)+'px';
}
</script>
  <table width="100%" style="height: 100%;" id="screen_table">
    <tr><td id="main_table">
<?
echo $content;
?>
    </tr></td>
    <tr>
      <td style="height: 100%;"><img alt="" src="img/spacer.gif" height="1" width="1" border="0"></td>
    </tr>
  </table>
</body>
</html>
