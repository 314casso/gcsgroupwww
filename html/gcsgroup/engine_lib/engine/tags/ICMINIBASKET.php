<?

global $icshop,$back,$_SERVER,$icsession,$iclogged,$sitelogged,$_GET,$icurl,$QUERY_STRING,$REQUEST_URI;
global $ichost,$iccat,$engine_show_htroot,$ichostinurl,$msrch;
$cmshost=$engine_show_htroot;

/*
$cmshost='dm.dev.belti.ru';
$ichost='dm.dev.belti.ru';
$iccat='dmshop';
*/
//echo $icsession;

$page='korz';
if($page and $cmsdoccode) {
//echo "id=$icsession<br><br><br><br>";
	$icurl="http://$ichost/cgi-bin/$iccat.cgi/$page.html?id=$icsession";
// 	$icurl="http://$ichost/cgi-bin/$iccat.cgi/$page.html";


      $icpage=geticpage($icurl,0);
      if ($msrch){
	      //$curl="http://".$_SERVER['HTTP_HOST']."/cntnt/".$cmsdoccode.".html?";
		$curl="http://".$_SERVER['HTTP_HOST']."/srch_shop";
      	}
      else    {
//	      $curl="http://".$_SERVER['HTTP_HOST']."/cntnt/".$cmsdoccode.".html?";
		$curl="http://".$_SERVER['HTTP_HOST']."/shop";
		}



      //Подмена ссылок

//      echo preg_replace ("@(action|href)\s*=\s*(['\"])\s*(http:\/\/$ichostinurl/cgi-bin/$iccat.cgi(.*))(['\"].*>)@Usie","str_replace(\"\\\\'\",\"'\",\"\\1=\\2\".\"$curl\".\"icurl=\".urlencode(\"\\3\").\"\\5\")",$icpage);
//      echo $icpage=preg_replace ("@(action|href)\s*=\s*(['\"])\s*(http:\/\/$ichost/cgi-bin/$iccat.cgi(.*))(['\"].*>)@Usie","str_replace(\"\\\\'\",\"'\",\"\\1=\\2\".\"$curl\".\"icurl=\".urlencode(\"\\3\").\"\\5\")",$icpage);
//	echo preg_replace ("@(action|href)\s*=\s*(['\"])\s*http:\/\/$ichostinurl/cgi-bin/$iccat.cgi((.*))(['\"].*>)@Usie","str_replace(\"\\\\'\",\"'\",\"\\1=\\2\".\"$curl\".\"\\3\".\"\\5\")",$icpage);
	echo preg_replace ("@(action|href)\s*=\s*(['\"])\s*http:\/\/$ichostinurl/cgi-bin/$iccat.cgi(.*)(['\"].*>)@Usie","str_replace(\"\\\\'\",\"'\",\"\\1=\\2\".urlconvert('".str_replace("'","\\'",$curl)."','\\3').\"\\4\")",$icpage);


	}


/*	$page='korz';
      $fp = fsockopen("mag.dev.belti.ru",80);
      $hdr="GET http://mag.dev.belti.ru/cgi-bin/mag_max.cgi/$page.html?id=".$icsession." HTTP/1.0\r\n";
      $hdr.="Host: http://mag.dev.belti.ru\r\n\r\n";
      fputs($fp,$hdr);
      while(!feof($fp)){
      $response.=fgets($fp,1024);
      }
      echo $response=preg_replace("|.*

|Usi","",$response,1);
      fclose($fp);
      */
//echo $icsession;

  ?>