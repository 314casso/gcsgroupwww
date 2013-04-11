<?php

/*
 *  $Id: dosend.php,v 1.7 2005/07/04 12:11:24 aavakyan Exp $
 *
 *  $Log: dosend.php,v $
 *  Revision 1.7  2005/07/04 12:11:24  aavakyan
 *  Исправлена кодировка исходящих писем, зашита в заголовок.
 *
 *  Revision 1.6  2005/07/04 11:25:03  aavakyan
 *  Исправлена ошибка в функционировании расслыки
 *
 *  Revision 1.5  2005/01/11 18:57:39  dave
 *  Убран модификатор 'u' в регулярных выражениях
 *
 *  Revision 1.4  2004/12/26 09:27:11  dave
 *  Переформатирование кода
 *
 *  Revision 1.3  2004/12/19 22:52:16  dave
 *  Оптимизация запросов к БД -- избавление от лишних OUTER JOIN
 *
 */

include "$engine_root/engine/config.inc";
//include "$engine_root/engine/document.inc";

$sql = "SELECT s.name, s.id, s.doc_id, cd.id nid
    FROM engine_send s, engine_documents d, engine_documents cd
    WHERE
        d.id = s.doc_id
        AND cd.pid = d.id
        AND ( ((d.type = 'NEWSGROUP' OR d.type = 'FOLDER') AND cd.send = 1)
        OR (d.type != 'FOLDER' AND d.type != 'NEWSGROUP' AND d.send = 1) )";
$r_ = mysql_query("$sql") or die (mysql_error());
while ($f_ = mysql_fetch_array($r_)) {
    $doc = "";
    $sql = "select * from engine_send_emails  where send_id=$f_[id]";
    $r_1 = mysql_query("$sql") or die (mysql_error());
    while ($f_1 = mysql_fetch_array($r_1)) {
        if ($eml) {
            if ($emls)
                $emls .= "," . $f_1[email];
            else
                $emls .= $f_1[email];
        } else
            $eml = $f_1[email];
    } 
    if ($f_[nid]) {
        $doc = new Document($f_[nid]);
        echo $f_[nid] . "!!!";
    } else {
        $doc = new Document($f_[doc_id]);
        echo $f_[doc_id] . "!!!";
    } 

    $msg = " <div>&nbsp;</div>  ";
    $ret_str = $doc->body;
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
        $msg .= $txt[$i];
        $doc = $reg[$i][1];
        // $msg.=
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
                $path[$k] = $f1[name];
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
        $msg .= strtolower ($pth);

        $i++;
    } 
    $msg .= $txt[$i];

    $f_[name]=convert_cyr_string($f_[name],w,k);
    $msg=convert_cyr_string($msg,w,k);

    mail($eml, $f_[name], $msg, "bcc:$emls\nContent-Type: text/html; charset=koi8-r; name=message1.html;");
    $eml = "";
    $emls = "";
} 
$sql = "update  engine_documents set send=0";
mysql_query("$sql") or die (mysql_error());

?>