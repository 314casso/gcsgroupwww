<?php

/*
 *  $Id: proc.php,v 1.6 2005/01/11 18:44:12 dave Exp $
 *
 *  $Log: proc.php,v $
 *  Revision 1.6  2005/01/11 18:44:12  dave
 *  Убран модификатор 'u' в регулярных выражениях
 *
 */

/*

Скрипт для установки новой версии новостей

ALTER TABLE `engine_NEW` ADD `new_date` DATETIME NOT NULL ,
ADD `new_stick` TINYINT NOT NULL ;

UPDATE engine_NEW n, engine_documents d
SET n.new_date = d.creation_date
WHERE n.doc_id = d.id

< ? !!!!!!!!!!!!!!!!!
        $html=stripslashes($html);
        $html=strip_tags ($html,'<hr><BLOCKQUOTE><img><a><u><b><i><table><tr><td><ol><ul><li><h1><strong><p><strike><sup><sub><center>');
        $html=preg_replace ("|<([^(a )A\W]\w*) .*(align\s*=\s*\S+)? >|Usie","('\\1'=='IMG')?'\\0':'<\\1 class=genhtml \\2>'",$html);
        $html=str_replace ('\"','"',$html);
        $html=str_replace("'","\'",$html);
*/
$i = 0;
function bg()
{
	global $i;
	if (++$i % 2 == 0)
	{
		return "tr2";
	}
	else
	{
		return "tr1";
	}
}
if (get_magic_quotes_gpc())
{
	$html   = stripslashes($_POST['html']);
	$text   = stripslashes($_POST['text']);
	$header = stripslashes($_POST['header']);
}
else
{
	$html   = $_POST['html'];
	$text   = $_POST['text'];
	$header = $_POST['header'];
}

// вырезаем ненужные таги
$html = strip_tags($html, '<pre><hr><div><BLOCKQUOTE><img><a><u><b><i><span><table><th><tr><td><ol><ul><li><h1><strong><p><strike><sup><sub><center>');
// вырезаем объявления классов
// ? >!!!                $html=preg_replace ("|(<[^>]*)(class=\s*[\"']?\w+[\"']?)(\s[^>]*)? >|Usi","\\1  \\3>",$html);
// проставляем классы вида new_[название тага]
$html = preg_replace("|<(\w+)([ >])|sie", "(strtolower('\\1')!='tr')?'<\\1 class=new \\2':'<\\1 class=new_'.bg().' \\2'", $html);
// убираем классы из якорей
$html = preg_replace ("|<A class=new_a([^>]*)>|Usie", "(stristr(\"\\1\",'href'))?'<a class=new_a'.\"\\1\".'>':'<a '.\"\\1\".'>'", $html);
// Убираем вставленные классы от туда где проставлены пользовательские
$html = preg_replace ("|<(\w+) class=new ([^>]*)(class=[^>]*)>|Usi", "<\\1 \\2\\3>", $html);
// подменяем пути на относительные
// $imgpath=preg_replace("|^http://[^/]*[/$]|Usi","./",$engine_show_htroot);
// $html=preg_replace ("|$engine_show_htroot|Usi","[SHOWHTROOT]",$html);
$sn = preg_replace("|^www\.|Usi", "", $SERVER_NAME);
$html = preg_replace("^((href|src|background) *= *([\"'])?)(https://|http://)?(www\.)?$sn" . "^Usi", "\\1", $html);

if ($pic1)
{
	$fn = explode(".", $pic1_name);
	$ext = strtolower($fn[count($fn)-1]);
	@unlink("$engine_show_root/engine/pics/news/pic1_" . $id . ".jpg");
	@unlink("$engine_show_root/engine/pics/news/pic1_" . $id . ".gif");
	copy($pic1, "$engine_show_root/engine/pics/news/pic1_" . $id . ".$ext");
	chmod("$engine_show_root/engine/pics/news/pic1_" . $id . ".$ext", 0777);
}

if ($pic2)
{
	$fn = explode(".", $pic2_name);
	$ext = strtolower($fn[count($fn)-1]);
	@unlink("$engine_show_root/engine/pics/news/pic2_" . $id . ".jpg");
	@unlink("$engine_show_root/engine/pics/news/pic2_" . $id . ".gif");
	copy($pic2, "$engine_show_root/engine/pics/news/pic2_" . $id . ".$ext");
	chmod("$engine_show_root/engine/pics/news/pic2_" . $id . ".$ext", 0777);
}

if ($delpic1)
{
	@unlink("$engine_show_root/engine/pics/news/pic1_" . $id . ".jpg");
	@unlink("$engine_show_root/engine/pics/news/pic1_" . $id . ".gif");
}

if ($delpic2)
{
	@unlink("$engine_show_root/engine/pics/news/pic2_" . $id . ".jpg");
	@unlink("$engine_show_root/engine/pics/news/pic2_" . $id . ".gif");
}

$sql = 'DESCRIBE engine_NEW';

$result = @mysql_query($sql);

if (!$result)
{
	die('Ошибка SQL: '.mysql_error().'<br />'.$sql);
}

while($field = mysql_fetch_array($result, MYSQL_ASSOC))
{
	$fields[$field['Field']] = $field;
}

$sql = 'SELECT *
          FROM engine_NEW
         WHERE doc_id='.$id;

if (!($result = mysql_query($sql)))
{
	die('Ошибка SQL: '.mysql_error().'<br />'.$sql);
}

$html   = mysql_real_escape_string($html);
$text   = mysql_real_escape_string($text);
$header = mysql_real_escape_string($header);

if (mysql_num_rows($result) == 0)
{
	$sql = <<<SQL
	INSERT INTO engine_NEW 
	(grpassign, usrassign, header, text, doc_id, html)
	VALUES ('$grpassign','$usrassign','$header','$text','$id','$html');
SQL;
	if (!($result = mysql_query($sql)))
	{
		die('Ошибка SQL: '.mysql_error().'<br />'.$sql);
	}
	$news_id = mysql_insert_id();
	
	
	// добавляем в рассылку
	$sql = 'SELECT *
	          FROM engine_send
	         WHERE doc_id='.$doc['pid'];

	if (!($result = mysql_query($sql)))
	{
		die('Ошибка SQL: '.mysql_error().'<br />'.$sql);
	}
	else
	{
		if (mysql_num_rows($result))
		{
			$sql = 'UPDATE engine_documents
			           SET send=1
			         WHERE id='.$id;

			if (!($result = mysql_query($sql)))
			{
				die('Ошибка SQL: '.mysql_error().'<br />'.$sql);
			}
		}
	}

	$sql = 'UPDATE engine_documents
	           SET name = "'.$header.'"
                 WHERE id = '.$id;

	if (!($result = mysql_query($sql)))
	{
		die('Ошибка SQL: '.mysql_error().'<br />'.$sql);
	}
}
else
{
	$sql = <<<SQL
	UPDATE engine_NEW
	SET 
	html  = '$html'
	,text      = '$text'
	,header    = '$header'
	,grpassign = '$grpassign'
	,usrassign = '$usrassign'
	WHERE doc_id='$id'
SQL;
	if (!($result = mysql_query($sql)))
	{
		die('Ошибка SQL: '.mysql_error().'<br />'.$sql);
	}

	$sql = <<<SQL
	UPDATE engine_documents
	SET name = '$header'
	WHERE id = '$id'
SQL;

	if (!($result = mysql_query($sql)))
	{
		die('Ошибка SQL: '.mysql_error().'<br />'.$sql);
	}
}

if (!isset($fields['new_date']))
{
	$creation_date = (empty($ndate))? date("Y-m-d"):mysql_real_escape_string($ndate);
	preg_match("/^(\d\d).(\d\d).(\d\d\d\d)$/",$ndate, $date_arr);
	if (count($date_arr) == 4){
		$creation_date = $date_arr[3]."-".$date_arr[2]."-".$date_arr[1]." 00:00:00";
	}
	$sql = <<<SQL
	UPDATE engine_documents
	SET creation_date = '$creation_date'
	WHERE id='$id'
SQL;

	if (!($result = mysql_query($sql)))
	{
		die('Ошибка SQL: '.mysql_error().'<br />'.$sql);
	}
}
if (isset($fields['new_date']))
{
	$new_stick = intval($new_stick);
	$ndate = (empty($ndate))? date("Y-m-d"):mysql_real_escape_string($ndate);
	$sql = <<<SQL
	UPDATE engine_NEW SET
	new_stick = '$new_stick'
	, new_date = '$ndate'
	WHERE doc_id = '$id'
SQL;
	if (!($result = mysql_query($sql)))
	{
		die('Ошибка SQL: '.mysql_error().'<br />'.$sql);
	}
}
if (isset($fields['new_date_start']))
{
	$new_date_start = (empty($new_date_start))? 'NULL':"'".mysql_real_escape_string($new_date_start)."'";
	$sql = <<<SQL
	UPDATE engine_NEW SET
	new_date_start = $new_date_start
	WHERE doc_id = '$id'
SQL;
	if (!($result = mysql_query($sql)))
	{
		die('Ошибка SQL: '.mysql_error().'<br />'.$sql);
	}

}
if (isset($fields['new_date_end']))
{
	$new_date_end = (empty($new_date_end))? 'NULL':"'".mysql_real_escape_string($new_date_end)."'";
	$sql = <<<SQL
	UPDATE engine_NEW SET
	new_date_end = $new_date_end
	WHERE doc_id = '$id'
SQL;
	if (!($result = mysql_query($sql)))
	{
		die('Ошибка SQL: '.mysql_error().'<br />'.$sql);
	}
}


?>