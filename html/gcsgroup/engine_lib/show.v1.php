<?php

/*
 *  $Id: show.php,v 1.26 2005/02/24 08:16:04 dave Exp $
 *
 *  $Log: show.php,v $
 *  Revision 1.26  2005/02/24 08:16:04  dave
 *  Исправлена орфография
 *
 *  Revision 1.25  2005/01/19 20:03:06  dave
 *  1. Изменена процедура logout'а для выполнения logout в IC
 *  2. Подключение шаблонов через [INCLUDE ...]
 *
 *  Revision 1.23  2005/01/15 14:49:16  dave
 *  404-я ошибка через redirect
 *
 *  Revision 1.22  2005/01/11 18:52:53  dave
 *  Убран модификатор 'u' в регулярных выражениях
 *
 *  Revision 1.21  2005/01/10 18:14:01  dave
 *  пароли в MD5
 *
 *  Revision 1.20  2004/12/28 00:10:01  dave
 *  Поддержка статистики по referer-ам
 *
 *  Revision 1.19  2004/12/26 09:27:11  dave
 *  Переформатирование кода
 *
 */

if (!preg_match("|yandex|Usi", $_SERVER["HTTP_USER_AGENT"])) {
    session_start();
    session_register("sitelogged");
    session_register("buscet");
    session_register("wrong_path_404");
    session_register("icshop");
    session_register("iclogged");
    session_register("back");
    session_register("icsession");
    session_register("ics");
    setcookie("MV_SESSION_ID", $icsession, time() + 3600000, '/cgi-bin/mag_max.cgi');
}
//echo "ic session: $icsesson<br>";

include_once "$engine_root/engine/config.inc";
include_once "$engine_root/engine/document.inc";
include_once "$engine_root/engine/functions.php";

//if (preg_match("|yandex|Usi", $_SERVER["HTTP_USER_AGENT"]))
//    echo "<!--!!!!!!!!!!!!!!!!!!!!!-->";
ob_start();
if ($logout)
{
	$sitelogged = false;
	$iclogged = "";

	//$hdr = "GET http://$ichost/cgi-bin/$iccat.cgi/fast_logout.html?id=$icsession&".list_cmsic_url()."\r\n";
	$hdr = "GET http://$ichost/cgi-bin/$iccat.cgi/fast_logout.html\r\n";
	$hdr .= "Host: http://$ichost\r\n\r\n";

	if ($ichost)
	{
		$fp = fsockopen("$ichost", 80);
		fputs($fp, $hdr);

		while (!feof($fp))
		{
			$response .= fgets($fp, 1024);
		}
		fclose($fp);

		$out_ = $response;

		if (preg_match("|Logged out|Usi", $response))
		{
			preg_match("|id=>(\S*)<BR>|Usi", $response, $sid);

			//if (!$icsession)
			//{
				$icsession = $sid[1];
			//}
			$ics = $sid[1];
		}

		$url = preg_replace("|id=([^&]*)|si", "id=$icsession", $url);
		echo "<script>document.location=document.location+' ';</script>";
		exit;
	}
}

if ($login)
{
	if (check_login_pair($login, $pass))
	{
		$sql = 'SELECT *
		        FROM engine_users
		        WHERE login = "'.mysql_real_escape_string($login).'"';

		$result = @mysql_query("select * from engine_users where login='$login'");
		$row    = @mysql_fetch_array($result, MYSQL_ASSOC);

 		$sitelogged = $row;

		$name = empty($row['name']) ? $row['lname'] : '';
		$name = empty($name) ? $row['login'] : $name;

		echo "<script>alert('Здравствуйте, ".addslashes($name)."!')</script>";

		$iclogged = 1;
		$hdr = "GET http://$ichost/cgi-bin/$iccat.cgi/fast_login.html?login=$sitelogged[login]&pass=$pass&id=$icsession&".list_cmsic_url()."\r\n";
		$hdr .= "Host: http://$ichost\r\n\r\n";

		if ($ichost)
		{
			$fp = fsockopen("$ichost", 80);
			fputs($fp, $hdr);

			while (!feof($fp))
			{
				$response .= fgets($fp, 1024);
			}
			fclose($fp);
			$out_ = $response;

			if (preg_match("|logged_in=>1|Usi", $response))
			{
				preg_match("|id=>(\S*)<BR>|Usi", $response, $sid);
				if (!$icsession)
				{
					$icsession = $sid[1];
				}
				$ics = $sid[1];
			}

			$url = preg_replace("|id=([^&]*)|si", "id=$icsession", $url);
			echo "<script>document.location=document.location+' ';</script>";
			exit;
		}
	}
	else
	{
		$sitelogged = false;
		$iclogged = "";
		echo "<script>alert ('Неверный пароль!')</script>";
	}
}
elseif ($sitelogged)
{	$sql = 'SELECT *
	        FROM engine_users
	        WHERE login="'.mysql_real_escape_string($sitelogged['login']).'" AND pass="'.mysql_real_escape_string($sitelogged['pass']).'"';

	$result = @mysql_query($sql);

	if (@mysql_num_rows($result) > 0)
	{
		$sitelogged = mysql_fetch_array($result, MYSQL_ASSOC);
	}
	else
	{
		$sitelogged = false;
	}
}

if ($buy)
{
	$buscet[$buy]++;
	if ($amount != "")
	{
		$buscet[$buy] = $amount;
	}
}

// Добавляем подписавшихся на рассылку
$i = 0;
$email = trim($email);
if ($email)
{
	while ($send[$i])
	{
		$sql = "select * from engine_send where id={$send[$i]}";
		if (mysql_num_rows(mysql_query("$sql")))
		{
			$sql = "select * from engine_send_emails where send_id={$send[$i]} and email='$email'";
			if (!mysql_num_rows(mysql_query("$sql")))
			{
				$sql = "insert into engine_send_emails(email,send_id) values('$email',{$send[$i]})";
				$r = mysql_query("$sql") or die (mysql_error());
			}
		}
		$i++;
	}
}

if (!$doc and !$search and !$sku and !$iccard) $doc = $defdoc;
if ($search) {
    $doc = -2;
}
if (!$doc and $sku) {
    $doc = -4;
}
if (!$doc and $iccard) {
    $doc = -5;
}

$doc_vars = array();
// Парсит параметры тага, создает переменные $[Имя параметра]='значение параметра'
// И скармливает их обработчику (./tags/[имя тага].php) если таковой есть
function tag($name, $param)
{
	$given = trim($param);
	global $doc, $DOCUMENT_ROOT, $engine_root, $msrch, $doc_vars;

	//$ptrn[0]="/(\w+)\s*=\s*'(.+[^~]|[^'])'/Usi";
	$ptrn[0] = "/(\w+)\s*=\s*'((~'|[^'])+)'/Usi";
	$ptrn[1] = "/(\w+)\s*=\s*(.+)($|\s)/Usi";

	$vars = array();
	foreach($doc as $key_id => $key_value)
	{
		if ($key_id != 'spec')
		{
			$vars['doc_'.$key_id] = $key_value;
		}
	}

	if (is_array($doc->spec))
	{		$doc_type = strtolower($doc->type);
		foreach($doc->spec as $key_id => $key_value)
		{			if (!is_int($key_id))
			{
				$vars[$doc_type.'_'.$key_id] = $key_value;
			}
		}
	}

	//дополнение массива глобальным массивом переменных
	$vars = $vars + $doc_vars;

	$param = AssignVars($vars, $param, '/\(%((?:(?!(?:%\)|\(%)).)*)%\)/s', $replace_all_vars);

	for ($j = 0;$j < 2;$j++)
	{		preg_match_all($ptrn[$j], $param, $regs, PREG_SET_ORDER);
		$i = 0;

		while ($regs[$i][0])
		{
			if ($j == 0)
			{
				$regs[$i][2] = str_replace("~'", "'", $regs[$i][2]);
			}

			${strtolower($regs[$i][1])} = $regs[$i][2];
			$i++;
		}

		$param = preg_replace($ptrn[$j], "", $param);
	}

	if (file_exists($engine_root.'/engine/tags/'.$name.'.php'))
	{
		if ($name != "DOCFIELD" and
		    $name != "BODY" and
		    $name != "ICPAGE" and
		    $name != "ICSHOP" and
		    $name != "ICLINK" and
		    $name != "ICMINBASKET" and $msrch)
		{
			return true;
		}

		$param = $reg[$i][3];
		$tag_iteration = -1;
		include($engine_root.'/engine/tags/'.$name.'.php');
		return true;
	}
	else
	{		return false;
	}
}

$doc = new Document($doc);
if (($doc->lastchange)&&($doc->lastchange != '0000-00-00 00:00:00'))
{	$doc->lastchange = strtotime($doc->lastchange);	header('Last-Modified: '.gmdate('D, d M Y H:i:s \G\M\T', $doc->lastchange));
}

$curl = $REQUEST_URI;
$param = preg_replace("|\?doc=\d+|si", "?", strstr($curl, '?'));
$curl = str_replace(strstr($curl, '?'), "", $curl);
$param = str_replace('?&', "?", $param);
if ($param == "?")$param = "";
$curl = strtolower($curl);

if ($doc->id != $defdoc)
{	if ($doc->geturl() != $curl and $doc->id > 0 and (!preg_match("@^/(shop_redirect|srch_shop|shop)/.*@Usi", $REQUEST_URI) or $showdoc or $showurl))
	{		if (strtolower(strrchr($curl, ".")) == ".html")
		{			if (!$wrong_path_404 or $showdoc or $showurl)
			{				if (preg_match("|([?&])showdoc=[^&]+(.)|si", $param))$param = "";
				header ("Location: " . ($doc->geturl()) . $param);
				exit;
			}
			else
			{				$r = db_select("select varvalue as id from engine_conf c where c.varname='doc404'");
				if (db_get_rows_affected() == 0)
				{					header("HTTP/1.0 404 Not Found");
					echo "Документ <br><b>$url</b><br> не найден! Код ".$doc->id;
					exit;
				}

				$r_ = db_get_array($r);

				include_once "engine_lib/engine/config.inc";
				include_once "engine_lib/engine/document.inc";

				$doc = new Document ($r_['id'],0);
				header("HTTP/1.0 301 Moved");
				header("Location: ".$doc->geturl());
				exit;
			}
		}
		else
		{			// echo "Location: ".($doc->geturl()).$param."   ".$doc->id;
			header ("Location: " . ($doc->geturl()) . $param);
			exit;
		}
	}
}

if (!$doc->tpl)
{	$doc->tpl = -1;
}

if ($msrch)
{	$f_ = fopen("engine/forsearch.txt", "r");
	$tpl = fread($f_, filesize("engine/forsearch.txt"));
	fclose($f_);
}
elseif ($forprint)
{
	if (isset($template))
	{
		$tpl = get_template ($template);
	}
	else
	{
	    	$f_ = fopen("engine/forprinttpl.txt", "r");
		$tpl = fread($f_, filesize ("engine/forprinttpl.txt"));
		fclose($f_);
	}
}
elseif ($doc->tpl != -1 and $doc->tpl != "")
{
	$sql = 'SELECT body
	          FROM engine_tpl
	         WHERE id='.($doc->tpl);

	list($tpl) = mysql_fetch_array(mysql_query($sql));
}
else
{
	if ($doc->tpl == "")
	{
		$doc->tpl = -1;
	}

	$file_path = 'engine/deftpl.txt';
	$file_temp = fopen($file_path, "r");
	$tpl       = fread($file_temp, filesize ($file_path));
	fclose($file_temp);
}

$regexp = '/\[INCLUDE\s+([\w|\d]+)\]/';
while (preg_match($regexp, $tpl, $m)) {
        $tpl = preg_replace ($regexp, get_template($m[1]), $tpl, 1);
}

function get_template ($template)
{
        list($tpl) = mysql_fetch_array(mysql_query("select body from engine_tpl where name='".db_quote($template)."'"));
        return $tpl;
}

$stls[0] = $doc->style;
$dct = $doc ;
while ($dct->id != -1)
{
	$dct = new Document($dct->pid,0);
	if ($dct->style != -1)
	{
		$i++;
		$stls[$i] = $dct->style;
	}
}
$head_link = '';
$head_link .= "\n".'  <link rel=stylesheet href="' . $engine_show_htroot . '/engine/styles/style-1.css" type="text/css">';

while ($i >= 0)
{
    $head_link .= "\n".'  <link rel=stylesheet href="' . $engine_show_htroot . '/engine/styles/style' . $stls[$i] . '.css" type="text/css">';
    $i--;
}

?>

<?php

//$pattern = '/(\[|<!--\[).*(\S+)(\s.*){0,1}(\]-->|\])/Usi';
//$pattern = '/(\[|<!--\[).*(\S+)(\s.*){0,1}(\]-->|([^~])\])/Usi';
$pattern = '/(\[|<!--\[).*(\S+)(\s.*([^~])){0,1}(\]-->|\])/Usi';

preg_match_all($pattern, $tpl, $reg, PREG_SET_ORDER);
$txt = preg_split ($pattern, $tpl);

$i = 0;

while ($reg[$i][0])
{	//if (!$msrch)
	{
		echo $txt[$i]; //."<B>".($reg[$i][2])."</B>";
	}

	if (!tag($reg[$i][2], str_replace('~]', ']', $reg[$i][3])))
	{
		echo $reg[$i][0];
	}
	$i++;
}

//if (!$msrch)
{	echo $txt[$i];
}

$ret_str = ob_get_contents();
ob_end_clean();
// Подставляем реальное значение URL вместо  хранящегося в базе [SHOWHTROOT]
$ret_str = str_replace("[SHOWHTROOT]", $engine_show_htroot, $ret_str);

if (strpos($ret_str, '</head>') || strpos($ret_str, '</HEAD>'))
{
        $ret_str = str_replace("</head>", $head_link."\n</head>", $ret_str);
        $ret_str = str_replace("</HEAD>", $head_link."\n</HEAD>", $ret_str);
}
else
{
        echo $head_link;
}

/*
if ($msrch)
        echo strip_tags(preg_replace("|<\?IMPORT.*>|Usi","",$ret_str),"<a><script><base><style><title><meta>");
else
      echo $ret_str;
*/
echo $ret_str;

// Регистрация хитов
//echo "ic session: $icsesson<br>";
//echo "session: ".session_id()."<br>";
if (defined('ENGINE_USE_STATISTICS'))
{	session_register("referer");
	session_register("referer_fixed");
	if ($referer_fixed != 1 && session_id() != '')
	{		//echo "write<br>";
		$referer = $GLOBALS['HTTP_REFERER'];
		// Запрет регистрации локальных referer-ов
		if (preg_match ('/^http\:\/\/'.$GLOBALS['HTTP_HOST'].'\//', $referer))
		{
			$referer = '';
		}

		$referer_fixed = 1;
		$query = "insert into engine_stat_referer (sess_id, ic_sess_id, referer) values ('".session_id()."', '$icsession', '".db_quote($referer)."')";
		//echo "q: $query";
		@mysql_query($query);
		session_register("icsession_");
		$icsession_ = $icsession;
	}
	//$referer = '';
}
if ($icsession != $icsession_) {
        //echo "<br>icsession changed: $icsesson -- $icsession_<br>";
}
// Конец модуля регистрации хитов


?>
