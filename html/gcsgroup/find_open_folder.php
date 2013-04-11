<?php
/**
  * Скрипт для поиска кода папки
  * находящейся в определенной папке
  */

// Скрипт чаще всего нужен для посмтроения дополнительных деревьев

global $doc_vars, $doc, $row_;

if ((empty($id))||($id==0))
{    $d = $doc;

}
else

{    $d = new Document($id);
}
//echo $in_folder."-ifold<br>";
//echo $pname."-pnam<br>";

if ($in_folder != '-1') {
$sql="select id from engine_documents where code='$in_folder' or id='$in_folder'";
        	if (!$result = @mysql_query($sql)){
            		die($sql);
        	}
        	$row    = @mysql_fetch_array($result);
        	$in_folder  = $row['id'];
}
//echo $in_folder."-ifoldid<br>";


$where = 'id='.$d->id;
$err_ = 1;
//если в качестве параметра использовали id документа
if ($pname != "folder"){
	while (($row['pid'] != $in_folder) && $err != 2 && !(@mysql_error())){

      		$sql = 'SELECT id, pid, code
               	 FROM engine_documents
                	WHERE '.$where;
        	if (!$result = @mysql_query($sql)){
            		die($sql);
        	}
        	$row    = @mysql_fetch_array($result);
        	$resid  = $row['id'];
        	$where  = ' id='.$row['pid'];
		if ($row['pid'] == ''){
			$err = 2;
		}
//		if ($pname) echo $row['code']."<br>";
	}
	if ($pname) {
		$row_[$pname] = $row['code'];
		$doc_vars[$pname] = $row['code'];
	}
	$doc_vars['folder'] = $row['code'];
//echo $doc_vars['folder']."-dwfold<br>";
}
//если в качестве параметра использовали имя переменной, то в случае если она была объявлена, то вытаскиваем id документа
if ($pname == "folder"){
	$par = "";
	$par = str_replace(array("%", "(", ")"),"",$in_folder);
//echo $par."-par<br>";
//echo $row_[$par]."-rowpar<br>";
	$doc_vars['folder'] = $row_[$par];
}

$pname = "";

/**
  * Использование скрипта:
  * 1. Вызывается скрипт так: [PHP do='find_open_folder.php' id='10' in_folder='-1']
  * 2. Скрипт в результате работы найдет папку, в которой лежит документ с id находящуюся в папке in_folder
  * Скрипт вызывается перед тегом MENU например
  * Если не указан id, то будет искаться текущий документ
  * В теге меню надо использовать так:
  * [MENU folder='(%folder%)'
  * ...
  * ]
  */
?>