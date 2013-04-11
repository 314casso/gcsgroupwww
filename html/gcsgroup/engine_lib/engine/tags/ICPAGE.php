<?

global $icshop,$back,$_SERVER,$icsession,$iclogged,$sitelogged,$_GET,$QUERY_STRING,$REQUEST_URI;

global $ichost,$iccat,$engine_show_htroot,$ichostinurl,$msrch;



$cmshost=$engine_show_htroot;



/*

$cmshost='dm.dev.belti.ru';

$ichost='dm.dev.belti.ru';

$iccat='dmshop';

*/

//echo $icsession;



if($page and $cmsdoccode)
{
      foreach($_GET as $f_name => $f_value)
      {
//
			if($f_name=='mv_nextpage') continue;
			if($f_name=='mv_more_ip') continue;
//		echo "f_name=$f_name<BR>";
              $get .= '&'.$f_name .'='. urlencode($f_value);
			
      }



      $icpage=geticpage("http://$ichost/cgi-bin/$iccat.cgi/$page.html?id=$icsession".$get,0,$doc->id);

      if ($msrch){

                $curl="http://".$_SERVER['HTTP_HOST']."/srch_shop";

              }

      else    {

                $curl="http://".$_SERVER['HTTP_HOST']."/shop";

                }

      //�������
//      echo preg_replace ("@(action|href)\s*=\s*(['\"])\s*(http:\/\/$ichostinurl/cgi-bin/$iccat.cgi(.*))(['\"].*>)@Usie","str_replace(\"\\\\'\",\"'\",\"\\1=\\2\".\"$curl\".\"icurl=\".urlencode(\"\\3\").\"\\5\")",$icpage);

//        echo preg_replace ("@(action|href)\s*=\s*(['\"])\s*http:\/\/$ichostinurl/cgi-bin/$iccat.cgi((.*))(['\"].*>)@Usie","str_replace(\"\\\\'\",\"'\",\"\\1=\\2\".\"$curl\".\"\\3\".\"\\5\")",$icpage);

        echo preg_replace ("@(action|href)\s*=\s*(['\"])\s*http:\/\/$ichostinurl/cgi-bin/$iccat.cgi(.*)(['\"].*>)@Usie","str_replace(\"\\\\'\",\"'\",\"\\1=\\2\".urlconvert('".str_replace("'","\\'",$curl)."','\\3').\"\\4\")",$icpage);



        }







/*

global $icsession;

$cmshost='dm.dev.belti.ru';

$ichost='dm.dev.belti.ru';

$iccat='dmshop';

echo $icsession;

$host="dm.dev.belti.ru";

if($page) {



      $fp = fsockopen("dm.dev.belti.ru",80);



      $hdr="GET http://dm.dev.belti.ru/cgi-bin/dmshop.cgi/$page.html?id=".$icsession." HTTP/1.0\r\n";



      $hdr.="Host: http://dm.dev.belti.ru\r\n\r\n";



      fputs($fp,$hdr);



      while(!feof($fp)){



      $response.=fgets($fp,1024);



      }

$response=preg_replace("|.*\r\n\r\n|Usi","",$response,1);



/********************************************

//�������
$response=preg_replace ("@(action|href)\s*=\s*(['\"])http:\/\/$host(.*)(['\"])@Usi","\\1=\\2\\3\\4",$response);

$response=preg_replace ("@((action|href)\s*=\s*['\"])http:\/\/$host@Usi","\\1",$response);

$response=preg_replace ('@(action|href)\s*=\s*([\'"])(.*)([\'"])@Usie',"(substr(trim('\\3'),0,7)=='http://')?str_replace('\\\"','\"','\\0'):'\\1='.str_replace('\\\"','\"','\\2').'http://$cmshost'.str_replace('cgi-bin','ICSHOP','\\3').str_replace('\\\"','\"','\\4')",$response);

*******************************************



        echo $response;

      fclose($fp);



        }

*/

?>
