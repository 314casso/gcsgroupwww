<?php

/*
 *  $Id: show.php,v 1.8 2005/02/24 08:16:31 dave Exp $
 *
 *  $Log: show.php,v $
 *  Revision 1.8  2005/02/24 08:16:31  dave
 *  Исправлена орфография
 *
 *  Revision 1.7  2005/01/11 18:48:00  dave
 *  Убран модификатор 'u' в регулярных выражениях
 *
 *  Revision 1.6  2005/01/10 17:56:20  dave
 *  пароли в MD5
 *
 *  Revision 1.5  2004/12/26 11:47:28  dave
 *  Переформатирование кода
 *
 */

session_start();
session_register("logged");
include("$engine_root/engine/config.inc");
include_once "$engine_root/engine/document.inc";
ob_start();
if ($login) {
    if (check_login_pair($login, $pass)) {
        $r = mysql_query("select * from engine_users where login='$login'");
		$u = mysql_fetch_array($r);
		$sitelogged = $u[id];
		echo "<script>alert ('Здравствуйте, " . $u[name] . ($u[name] != '' && $u[lname] != '' ? ' ' : '') . $u[lname] . "!')</script>";
	} else {
		$sitelogged = false;
		echo "<script>alert ('Неверный пароль!')</script>";
	}
} else if ($sitelogged) {
    if (check_login_pair($sitelogged['login'], $sitelogged['pass'])) {
	    $r = mysql_query("select * from engine_users where login='$sitelogged[login]'");
		$u = mysql_fetch_array($r);
		$sitelogged = $u[id];
	} else {
		$sitelogged = false;
	} 
} 
// Добавляем подписавшихся на рассылку
$i = 0;
$email = trim($email);
if ($email)
	while ($send[$i]) {
	$sql = "select * from engine_send where id={$send[$i]}";
	if (mysql_num_rows(mysql_query("$sql"))) {
		$sql = "select * from engine_send_emails where send_id={$send[$i]} and email='$email'";
		if (!mysql_num_rows(mysql_query("$sql"))) {
			$sql = "insert into engine_send_emails(email,send_id) values('$email',{$send[$i]})";
			$r = mysql_query("$sql") or die (mysql_error());
		} 
	} 
	$i++;
} 

if (!$doc and !$search) $doc = $defdoc;
if (!$doc and $search) {
	$doc = -2;
} 
// Парсит параметры тага, создает переменные $[Имя параметра]='значение параметра'
// И скармливает их обработчику (./tags/[имя тага].php) если таковой есть
function tag($name, $param)
{
    echo "TAG: $name, $param<br>";
	global $doc, $DOCUMENT_ROOT, $engine_root;
	$ptrn[0] = "|(\w+)\s*=\s*'(.+)'|Usi";
	$ptrn[1] = "/(\w+)\s*=\s*(.+)($|\s)/Usi";
	for ($j = 0;$j < 2;$j++) {
		preg_match_all($ptrn[$j], $param, $regs, PREG_SET_ORDER);
		$i = 0;
		while ($regs[$i][0]) {
			${$regs[$i][1]} = $regs[$i][2];
			$i++;
		} 
		$param = preg_replace($ptrn[$j], "", $param);
	} 

	if (file_exists("$engine_root/engine/tags/" . ($name) . ".php")) {
		$param = $reg[$i][3];
		include("$engine_root/engine/tags/" . ($name) . ".php");
		return true;
	} else
		return false;
} 
$doc = new Document($doc);

if ($forprint) {
	$f_ = fopen("forprinttpl.txt", "r");
	$tpl = fread($f_, filesize ("forprinttpl.txt"));
	fclose($f_);
} else if ($doc->tpl != -1 and $doc->tpl != "") {
	$sql = "select body from engine_tpl where id=" . ($doc->tpl);
	list($tpl) = mysql_fetch_array(mysql_query($sql));
} else {
	$f_ = fopen("engine/deftpl.txt", "r");
	$tpl = fread($f_, filesize ("engine/deftpl.txt"));
	fclose($f_);
} 

?>
<link rel=stylesheet href="<?=$engine_show_htroot?>/engine/styles/style<?=$doc->style?>.css" type="text/css" title="CSS style">
<?php 
// echo htmlspecialchars($tpl)."<hr>\n";
$pattern = '/(\[|<!--\[).*(\S+)(\s.*){0,1}(\]-->|\])/Usi';
preg_match_all($pattern, $tpl, $reg, PREG_SET_ORDER);
$txt = preg_split ($pattern, $tpl);

$i = 0;
while ($reg[$i][0]) {
	echo $txt[$i]; //."<B>".($reg[$i][2])."</B>";
	if (!tag($reg[$i][2], $reg[$i][3]))
		echo $reg[$i][0];
	$i++;
} 
echo $txt[$i];

$ret_str = ob_get_contents();
ob_end_clean();

$buf = $ret_str;
$ret_str = preg_replace(";background=([\"' ])\s*((site_img|images).*)[\"' ];Usi", "background=\\1$engine_show_htroot/\\2\\1", $ret_str);
if ($buf == $ret_str)
	$ret_str = preg_replace("|background=([\"' ])\s*(img.*)[\"' ]|Usi", "background=\\1$engine_show_htroot/\\2\\1", $ret_str);

$buf = $ret_str;
$ret_str = preg_replace(";src=([\"' ])\s*((site_img|images).*)[\"' ];Usi", "src=\\1$engine_show_htroot/\\2\\1", $ret_str);
if ($buf == $ret_str)
	$ret_str = preg_replace("|src=([\"' ])\s*(img.*)[\"' ]|Usi", "src=\\1$engine_show_htroot/\\2\\1", $ret_str);

$ret_str =
preg_replace("|<a(.*)href=(.*)(show\.php.*>)|U", "<a\\1href=\\2$engine_show_htroot/\\3", $ret_str);

$pattern = '|show.php\?doc=(\w+)|si';
preg_match_all($pattern, $ret_str, $reg, PREG_SET_ORDER);

$txt = preg_split ($pattern, $ret_str);

$i = 0;
while ($reg[$i][0]) {
	echo $txt[$i];
	$doc = $reg[$i][1]; 
	// echo
	$sql = "select * from engine_documents where code=$doc or id=$doc";
	$r = mysql_query("$sql") ;
	if (mysql_num_rows($r)) {
		$path = "";
		$f = mysql_fetch_array($r);
		if ($f[id] == $doc and $f[code])
			$doc = $f[code];
		$pid = $f[pid];
		$path[0] = "$doc.html";
		$k = 0;
		while ($path[$k]) {
			$k++;
			$sql = "select * from engine_documents where id=$pid";
			$r1 = mysql_query("$sql") or die (mysql_error());
			$f1 = mysql_fetch_array($r1);
			if (!$f1[code]) {
				$arus = array('/"/', '/\'/', '/ /', '/а/', '/б/', '/в/', '/г/', '/д/', '/е/', '/ё/', '/ж/', '/з/', '/и/', '/к/', '/л/', '/м/', '/н/', '/о/', '/п/', '/р/', '/с/', '/т/', '/у/', '/ф/', '/х/', '/ч/', '/ц/', '/щ/', '/ш/', '/й/', '/ы/', '/ъ/', '/ь/', '/э/', '/ю/', '/я/', '/А/', '/Б/', '/В/', '/Г/', '/Д/', '/Е/', '/Ё/', '/Ж/', '/З/', '/И/', '/К/', '/Л/', '/М/', '/Н/', '/О/', '/П/', '/Р/', '/С/', '/Т/', '/У/', '/Ф/', '/Х/', '/Ч/', '/Ц/', '/Щ/', '/Ш/', '/Й/', '/Ы/', '/Ъ/', '/Ь/', '/Э/', '/Ю/', '/Я/');
				$atrans = array('', '', '_', 'a', 'b', 'v', 'g', 'd', 'e', 'yo', 'j', 'z', 'i', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f', 'h', 'ch', 'ch', 'sh', 'sh', 'y', 'i', '', '', 'e', 'u', 'ya', 'A', 'B', 'V', 'G', 'D', 'E', 'YO', 'J', 'Z', 'I', 'K', 'L', 'M', 'N', 'O', 'P', 'R', 'S', 'T', 'U', 'F', 'H', 'Ch', 'Ch', 'Sh', 'Sh', 'Y', 'I', '', '', 'E', 'U', 'Ya');
				$code = preg_replace($arus, $atrans, $f1[name]);
				$sql = "update engine_documents set code='$code' where id=$pid";
				$r1 = mysql_query("$sql") or die (mysql_error());
			} else
				$code = $f1[code];
			$path[$k] = $code;
			$pid = $f1[pid];
		} 
		$pth = "";
		for ($m = $k-1;$m >= 0;$m--) {
			if ($m != $k-1) $pth .= '/';
			$pth .= $path[$m];
		} 
	} 

	$arus = array('/"/', '/\'/', '/ /', '/а/', '/б/', '/в/', '/г/', '/д/', '/е/', '/ё/', '/ж/', '/з/', '/и/', '/к/', '/л/', '/м/', '/н/', '/о/', '/п/', '/р/', '/с/', '/т/', '/у/', '/ф/', '/х/', '/ч/', '/ц/', '/щ/', '/ш/', '/й/', '/ы/', '/ъ/', '/ь/', '/э/', '/ю/', '/я/', '/А/', '/Б/', '/В/', '/Г/', '/Д/', '/Е/', '/Ё/', '/Ж/', '/З/', '/И/', '/К/', '/Л/', '/М/', '/Н/', '/О/', '/П/', '/Р/', '/С/', '/Т/', '/У/', '/Ф/', '/Х/', '/Ч/', '/Ц/', '/Щ/', '/Ш/', '/Й/', '/Ы/', '/Ъ/', '/Ь/', '/Э/', '/Ю/', '/Я/');
	$atrans = array('', '', '_', 'a', 'b', 'v', 'g', 'd', 'e', 'yo', 'j', 'z', 'i', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f', 'h', 'ch', 'ch', 'sh', 'sh', 'y', 'i', '', '', 'e', 'u', 'ya', 'A', 'B', 'V', 'G', 'D', 'E', 'YO', 'J', 'Z', 'I', 'K', 'L', 'M', 'N', 'O', 'P', 'R', 'S', 'T', 'U', 'F', 'H', 'Ch', 'Ch', 'Sh', 'Sh', 'Y', 'I', '', '', 'E', 'U', 'Ya');
	$pth = preg_replace($arus, $atrans, $pth);
	echo strtolower ($pth);

	$i++;
} 
echo $txt[$i];

?>