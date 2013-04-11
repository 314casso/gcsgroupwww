<?php

/*
 *  $Id: proc.php,v 1.7 2005/02/24 08:19:05 dave Exp $
 *
 *  $Log: proc.php,v $
 *  Revision 1.7  2005/02/24 08:19:05  dave
 *  Разрешено использование тега <EM>
 *
 *  Revision 1.6  2005/01/11 18:42:16  dave
 *  Убран модификатор 'u' в регулярных выражениях
 *
 */
$temp_ = $_POST['html'];
for ($i = 0; $i < count($url_old); $i++){
	if ($url_old[$i] != '' && $url_new[$i] != ''){
		$temp_ = str_replace($url_old[$i],$url_new[$i],$temp_);

	}
}
$temp_ = str_replace("//","/",$temp_);
$temp_ = str_replace(".html&",".html?",$temp_);
$_POST['html'] = $temp_;
$sql = 'DELETE FROM engine_TEXTDOC
        WHERE doc_id='.$id;

if (!$result = mysql_query($sql))
{	die("SQL error ".mysql_error()." in: $sql\n");
}

if (get_magic_quotes_gpc())
{
	$html = mysql_real_escape_string(stripslashes($_POST['html']));
}
else
{
	$html = mysql_real_escape_string($_POST['html']);
}

                                $i=0;

function GetClass()
{
	global $i;

	if (++$i%2==0)
	{
		return "tr2";
	}
	else
	{
		return "tr1";
	}
}

$html = preg_replace("|<(\w+)([ >])|sie","(strtolower('\\1')!='tr')?'<\\1 class=textdoc \\2':'<\\1 class=textdoc_'.GetClass().' \\2'",$html);
$html = preg_replace ("|<(\w+) class=textdoc ([^>]*)(class=[^>]*)>|Usi","<\\1 \\2\\3>",$html);


$sql = 'INSERT INTO engine_TEXTDOC( html,doc_id)
                            VALUES ("'.$html.'","'.intval($id).'");';
//echo $sql;

if (!$result = mysql_query($sql))
{	die("SQL error ".mysql_error()." in: $sql\n");
}

?>