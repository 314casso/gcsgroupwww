<?
global $ichost,$iccat,$engine_show_htroot,$icsession,$msrch;
$cmshost=$engine_show_htroot;

/*
$cmshost='dm.dev.belti.ru';
$ichost='dm.dev.belti.ru';
$iccat='dmshop';
*/
if ($page and $cmsdoccode){
//	echo "http://".$_SERVER['HTTP_HOST']."/cntnt/".$cmsdoccode.".html?icurl=".urlencode("http://$ichost/cgi-bin/$iccat.cgi/$page.html?id=$icsession");
	if (!$msrch ){
		if (!$cmsdoccode)
			echo "http://".$_SERVER['HTTP_HOST']."/shop/$page.html";
		else
			echo "http://".$_SERVER['HTTP_HOST']."/shop_redirect/$cmsdoccode/$page.html";
		}
	else echo "http://".$_SERVER['HTTP_HOST']."/srch_shop/$page.html";
	}
else echo "#";

?>
