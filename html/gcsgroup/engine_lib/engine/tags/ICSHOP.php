<?

/*
 *  $Id: ICSHOP.php,v 1.4 2005/01/11 22:20:08 dave Exp $
 *
 *  $Log: $
 *
 *  Revision 1.3  2005/01/10 18:07:57  dave
 *  Кеширование
 *
 */

global $icshop,$back,$_SERVER,$icsession,$iclogged,$sitelogged,$_GET,$icurl,$QUERY_STRING,$REQUEST_URI;
global $ichost,$iccat,$engine_show_htroot,$ichostinurl,$msrch;
global $forprint;
$cmshost=$engine_show_htroot;

/*
$cmshost='dm.dev.belti.ru';
$ichost='dm.dev.belti.ru';
$iccat='dmshop';
*/
//echo $icsession;
//echo $icurl;

if (!$icurl)
        $icurl="http://$ichost/cgi-bin/$iccat.cgi/index.html?id=$icsession";
    //$icurl="http://$ichost/cgi-bin/$iccat.cgi/index.html";

$icpage=geticpage($icurl, 1, 0, ($forprint == 1), true);
//$icpage=geticpage($icurl);
//$curl="http://".$_SERVER['HTTP_HOST'].str_replace($QUERY_STRING,"",$REQUEST_URI);//$_SERVER['REQUEST_URI'];
if ($msrch) {
    $curl="http://".$_SERVER['HTTP_HOST']."/srch_shop";
} else {
    $curl="http://".$_SERVER['HTTP_HOST']."/shop";
}


/*if ($_GET)
        $curl.="&";
else
        $curl.="?";*/
//Подмена ссылок
//echo "@(action|href)\s*=\s*(['\"])\s*(http:\/\/$ichost/cgi-bin/$iccat.cgi(.*))(['\"].*>)@Usie";
//echo $icpage=preg_replace ("@(action|href)\s*=\s*(['\"])\s*(http:\/\/$ichostinurl/cgi-bin/$iccat.cgi(.*))(['\"].*>)@Usie","str_replace(\"\\\\'\",\"'\",\"\\1=\\2\".\"$curl\".\"icurl=\".urlencode(\"\\3\").\"\\5\")",$icpage);
//echo $icpage=preg_replace ("@(action|href)\s*=\s*(['\"])\s*http:\/\/$ichostinurl/cgi-bin/$iccat.cgi((.*))(['\"].*>)@Usie","str_replace(\"\\\\'\",\"'\",\"\\1=\\2\".\"$curl\".\"\\3\".\"\\5\")",$icpage);

echo $icpage=preg_replace ("@(action|href)\s*=\s*(['\"])\s*http:\/\/$ichostinurl/cgi-bin/$iccat.cgi(.*)(['\"].*>)@Usie","str_replace(\"\\\\'\",\"'\",\"\\1=\\2\".urlconvert('".str_replace("'","\\'",$curl)."','\\3').\"\\4\")",$icpage);
?>
