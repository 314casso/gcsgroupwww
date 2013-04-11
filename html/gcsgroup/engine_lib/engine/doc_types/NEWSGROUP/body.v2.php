<?php
/*
 *  $Id: body.php,v 1.8 2005/08/02 10:32:05 aavakyan Exp $
 *
 *  $Log: body.php,v $
 *  Revision 1.8  2005/08/02 10:32:05  aavakyan
 *  *** empty log message ***
 *
 *  Revision 1.7  2004/12/26 11:51:15  dave
 *  Переформатирование кода
 *
 *  Revision 1.6  2004/12/19 22:51:27  dave
 *  Оптимизация запросов к БД -- избавление от лишних OUTER JOIN
 */
global ${"arclist_".$this->id}, $engine_show_root, $engine_show_htroot;
$arclist = ${"arclist_".$this->id};
$date_field = (mysql_fetch_assoc(mysql_query("SHOW COLUMNS FROM engine_NEW LIKE 'new_date';")))?
			"n.new_date":"d.creation_date";

if ($arclist) $arclist1 = " AND date_format($date_field,'%m.%Y')='$arclist' ";
else $limit = "limit " . ($this->spec['ncount'] + 0);

if (empty($logged['id']))
{
	$sql =<<<SQL
	SELECT d.id AS doc_id, date_format(d.creation_date,"%d.%m.%Y.%T") creation_date, n.*
	        FROM engine_documents d, engine_NEW n
	        WHERE d.visible=1 AND
	              n.doc_id = d.id AND
	              d.pid = '$id' AND
	              grpassign=-1 AND
	              usrassign=-1
	              $arclist1
	        ORDER BY $date_field DESC $limit
SQL;
}
else
{
	$sql = 'SELECT ugroup
	        FROM engine_users
	        WHERE id='.$logged['id'];

	$result = mysql_query($sql) or die (mysql_error());

	list($loggedgrp) = mysql_fetch_array($result);
	$sql = <<<SQL
	SELECT d.id AS doc_id, date_format(d.creation_date,"%d.%m.%Y.%T") creation_date, n.*
	        FROM engine_documents d, engine_NEW n
	        WHERE d.visible=1 AND
	              n.doc_id=d.id AND
	              d.pid='$id' AND
	              (grpassign=-1 or grpassign='$loggedgrp') AND
	              (usrassign=-1 or usrassign='{$logged['id']}')
	              $arclist1
	        ORDER BY $date_field DESC $limit
SQL;
}

$news_r = mysql_query($sql) or die (mysql_error() . " in $sql");
$news = "";

while ($news_f = mysql_fetch_array($news_r)) {
	if (file_exists("$engine_show_root/engine/pics/news/pic1_" . $news_f[id] . ".jpg"))
		$pic1 = "<img src='$engine_show_htroot/engine/pics/news/pic1_" . $news_f[id] . ".jpg' align=left>";
	else if (file_exists("$engine_show_root/engine/pics/news/pic1_" . $news_f[id] . ".gif"))
		$pic1 = "<img src='$engine_show_htroot/engine/pics/news/pic1_" . $news_f[id] . ".gif' align=left>";
	else $pic1 = "";

	if (isset($news_f['new_date']))
	{
		$new_date = strtotime($news_f['new_date']);
		$new_date = date('d.m.Y', $new_date);
	}
	else
	{
		$new_date = substr($news_f['creation_date'], 0, 10);
	}

	$out = str_replace("NEW_HREF", (geturl($news_f['doc_id'])), $this->spec[format]);
	$out = str_replace("NEW_HEADER", $news_f['header'], $out);
	$out = str_replace("NEW_DATE", $new_date, $out);
	$out = str_replace("NEW_TEXT", $news_f['text'], $out);

	$pic1 = "";
	$pic2 = "";

	if (file_exists("$engine_show_root/engine/pics/news/pic1_" . $news_f['doc_id'] . ".jpg"))
		$pic1 = "<img src='$engine_show_htroot/engine/pics/news/pic1_" . $news_f['doc_id'] . ".jpg' align=left>";
	else if (file_exists("$engine_show_root/engine/pics/news/pic1_" . $news_f['doc_id'] . ".gif"))
		$pic1 = "<img src='$engine_show_htroot/engine/pics/news/pic1_" . $news_f['doc_id'] . ".gif' align=left>";
	else $pic1 = "";

	if (file_exists("$engine_show_root/engine/pics/news/pic2_" . $news_f['doc_id'] . ".jpg"))
		$pic2 = "<img src='$engine_show_htroot/engine/pics/news/pic2_" . $news_f['doc_id'] . ".jpg' align=left>";
	else if (file_exists("$engine_show_root/engine/pics/news/pic2_" . $news_f['doc_id'] . ".gif"))
		$pic2 = "<img src='$engine_show_htroot/engine/pics/news/pic2_" . $news_f['doc_id'] . ".gif' align=left>";
	else $pic2 = "";

	if (!$pic1) {
		$out = preg_replace("|\[NEW_PIC1\].*\[/NEW_PIC1\]|Usi", "", $out);
	} else {
		$out = preg_replace("|\[NEW_PIC1\]|Usi", "", $out);
		$out = preg_replace("|\[/NEW_PIC1\]|Usi", "", $out);
	}
	if (!$pic2) {
		$out = preg_replace("|\[NEW_PIC2\].*\[/NEW_PIC2\]|Usi", "", $out);
	} else {
		$out = preg_replace("|\[NEW_PIC2\]|Usi", "", $out);
		$out = preg_replace("|\[/NEW_PIC2\]|Usi", "", $out);
	}
	$out = str_replace("NEW_PIC1", $pic1, $out);
	$out = str_replace("NEW_PIC2", $pic2, $out);

	$news .= $out;
}
$this->body = $news;

?>
