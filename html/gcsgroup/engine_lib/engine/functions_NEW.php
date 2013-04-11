<?php

/*
 *  $Id: $
 *
 *  $Log: $
 */

  function stripspaces($string){



 	$spaces[0]=" ";

 	$spaces[1]="	";



	$qt=0;  //счетчик двойных кавычек

	$qt1=0; //счетчик одинарных кавычек

	$buf="";//Буфер

	// пробегаемся по тексту

	for ($j=0;$j<strlen($string);$j++){

		//если текущий символ - двойная кавычка не заключенная в одинарные и она не экранирована увеличиваем счетчик

		if ($string[$j]=='"' and ($qt1%2)==0

				and (

					($string[$j-1]!='\\' and ($qt%2)==1)

					or

					($qt%2)==0

					)

				)

			$qt++;

		//если текущий символ - одинарная кавычка не заключенная в двойные и она не экранирована увеличиваем счетчик

		if ($string[$j]=="'" and ($qt%2)==0

				and (

					($string[$j-1]!='\\' and ($qt1%2)==1)

					or

					($qt1%2)==0

					)

				)

			$qt1++;

		//если текущий символ - не пробел или первый пробел после другого символа находящийся вне кавычек выводим

		if (($qt%2)!=0 or ($qt1%2)!=0)

			$buf.=$string[$j];

		else if (!in_array ($string[$j],$spaces)  and ord($string[$j])!="13" and ord($string[$j])!="10" )

			$buf.=$string[$j];

		else

			 if  ((!in_array ($string[$j],$spaces) or !in_array ($string[$j-1],$spaces)) and ord($string[$j])!="13" and ord($string[$j])!="10")

				$buf.=$string[$j];

		}

	if (!preg_replace("|[

]|usi","",$buf))$buf="";

 	return $buf;

 	}







 function htmlstripspaces($string){

 	$pre=0;

	$script=0;

	$textarea=0;

	$button=0;

	$buf="";

//  получаем массив HTML тагов из строки

	$pattern='|<(/)?\w+[^\>]*>|si';

	preg_match_all($pattern,$string,$reg,PREG_SET_ORDER);

//	разрезаем текст по тагам

	$txt=preg_split ($pattern,$string);

	$i=0;

	$buf.=stripspaces($txt[$i]);

	while($reg[$i][0]){

		if (preg_match("'<pre(|\s[^>]*)>'Usi",$reg[$i][0]))

			$pre++;

		if (preg_match("'</\s*pre(|\s[^>]*)>'Usi",$reg[$i][0]))

			$pre--;

		if (preg_match("'<script(|\s[^>]*)>'Usi",$reg[$i][0]))

			$script++;

		if (preg_match("'</script(|\s[^>]*)>'Usi",$reg[$i][0]))

			$script--;

		if (preg_match("'<textarea(|\s[^>]*)>'Usi",$reg[$i][0]))

			$textarea++;

		if (preg_match("'</textarea(|\s[^>]*)>'Usi",$reg[$i][0]))

			$textarea--;

		if (preg_match("'<button(|\s[^>]*)>'Usi",$reg[$i][0]))

			$button++;

		if (preg_match("'</button(|\s[^>]*)>'Usi",$reg[$i][0]))

			$button--;



		//получаем текст в таговых скобках

		$str=$reg[$i][0];

//		отключил вырезание в таговых скобках (< .... >)

//		$buf.= stripspaces($str);

		$buf.= $str;





		//кладем в буфер текст предшествующий текущему тагу

		if (!$script and !$pre and !$textarea and !$button){

			$buf.= preg_replace("|<!--.*-->|Usi","",stripspaces($txt[$i+1]));

			}

		else {

			$buf.=  $txt[$i+1];

			}

		$i++;

		}

	//exit;

	return $buf;

//		return $string;

	}

//Получает Списое ID документов рубрики и ее подрубрик

function get_subrubsdocs($id,$rubdocs){

        global $rubs;



        $rubs.=$id;



        if (!($id*1)){

           $sql="select * from engine_rubrique where name='$id'";

           list($id)=mysql_fetch_array(mysql_query($sql));

           }

        $sql="select * from engine_docsinrubriques where rub=$id and `in`=1";

        $r=mysql_query($sql);

        while($f=mysql_fetch_array($r)){

             if ($rubdocs)$rubdocs.=", ";

             $rubdocs.=$f[doc];

             }

        $sql="select * from engine_rubrique where pid=$id";

        $r=mysql_query($sql);

        while($f=mysql_fetch_array($r)){

               get_subrubsdocs($f[id],&$rubdocs);

               }

        return  $rubs;

        }

// выполняет sql и возвращает все элементы наложенные на формат ({-[имя поля большими буквами]-})



function dbparse($sql,$format1,$format2=""){

	$format[0]=$format1;

      if (!$format2)

      	$format[1]=$format[0];

      else

      	$format[1]=$format2;

	$r=mysql_query($sql);



	while($f=mysql_fetch_array($r)){

	    	$buf=$format[(($i++)%2)];

/*	    	if ($vals){

	    	    	$bv=$vals;

                  foreach ($bv as $k =>$v){

                       foreach ($f as $key =>$val){

                           $v=str_replace("{-".strtoupper($key)."-}",$val,$v);

                           }

 	                 $buf=str_replace($k,$v,$buf);

                       }

	    	    	}

	    	    	*/

	    	foreach ($f as $key =>$val){

                $buf=str_replace("{-".strtoupper($key)."-}",$val,$buf);

	    	    }

	    	$res.=$buf;

      	}

      return $res;

	}



function dbparserow($f,$format){

      $buf=$format;

      foreach ($f as $key =>$val){

          $buf=str_replace("{-".strtoupper($key)."-}",$val,$buf);

          }

      $res.=$buf;

      return $res;

	}

function lister($url,$count,$table,$cause="",$pcount=10){

	global $page;

      list($cnt)=mysql_fetch_array(mysql_query("select count(*) from $table where $cause"));

      $cnt--;

// Листалка

      $out.= "<a class=lister href=".$url."page=0>Первая</a> | ";

      $out.= "<a class=lister href=".$url."page=".($cnt-$cnt%$count).">Последняя</a> <br>";



      if (($page-$page%($count*$pcount)-$count*$pcount)>=0)

            $out.= "<a class=lister href=".$url."page=".($page-$page%$count-$count*$pcount)."><<<</a> ";

      for ($i=($page-$page%($count*$pcount));$i<min($page-$page%($count*$pcount)+$pcount*$count,$cnt-$cnt%$count+$count);$i+=$count){

            if ($page!=$i)$out.= "<a class=lister href=".$url."page=$i>".($i/$count+1)."</a> ";

            else $out.= "<b>".($i/$count+1)."</b> ";

            }

      if (($page-$page%($count*$pcount)+$count*$pcount)<=$cnt)

            $out.= "<a class=lister href=".$url."page=".($page-$page%$count+$count*$pcount).">>>></a> ";

      return    $out;

	}







function geticpage($url,$sendvars=1,$docid=0){

	global $HTTP_COOKIE_VARS,$HTTP_POST_VARS,$_POST,$_SERVER,$icsession,$iclogged,$sitelogged,$class;



	$cmshost='dm.dev.belti.ru';

	$ichost='dm.dev.belti.ru';

	$iccat='dmshop';



      $ah=apache_request_headers();

	if  ($sendvars){

           //Формируем строку пост переменных

           foreach($HTTP_POST_VARS as $var=>$val){

                 if (!is_array($val)){

//                     $post.="&$var=".urlencode($val);

                     $post.="&$var=".$val;

                     }

                 else {

                     foreach ($val as $k=>$v)

                     	$post.="&$var=$v";

//                     	$post.="&$var=".urlencode($v);

                     }

                 if ($var=='mv_session_id'){

                       $icsession=$val;

                       }

                 }

	     $post.="&sessid=$icsession";

           $post=substr($post,1,strlen($post)-1);

           }

      else {

      	$post.="docid=$docid";

      	$post.="sessid=$icsession";

      	}





     //Ищем значение id сесссии  в GET

     if (preg_match("|[&?]id=([^&]*)|si",$url,$m)){

//	     $icsession=$m[1];

           }



     //Проверяем залогинины ли мы

     //флаг повтора для while (для обработки редиректа)

     $loop=1;









     while ($loop){

	if (preg_match("|http://$cmshost/cgi-bin/$iccat.cgi/login.html.*|si",$url))

		return ("<div>Залогиньтесь пожалуйста!</div>");



     if (preg_match("|id=([^&]*)|si",$url,$m)){

//	     $icsession=$m[1];

           }

	if (strstr($url,'?'))

		$url.="&id=$icsession";

	else

		$url.="?id=$icsession";

     $response="";

     $hdr="";

     //Получаем Хост из URL

     preg_match("/^(http:\/\/)?([^\/]+)/i",$url, $matches);

     $host = $matches[2];



     //Формируем строку запроса (если есть пост переменные POST если нет - GET)

     if  (strtolower(substr($url,0,7))!='http://')

           $url="http://$url";

     if ($post)

           $hdr.="POST $url HTTP/1.0\r\n";

     else

           $hdr.="GET $url HTTP/1.0\r\n";

     //Прописываем Content-length в заголовок

     $hdr.="Content-length:".strlen($post)."\r\n\r\n";

     //Прописываем пост переменные в заголовок

     $hdr.=$post."\r\n\r\n";

//--     echo $icsession."!!!!!!!!!!!!!!!!!!!!!";

//--     echo "<PRE>$hdr</pre>";

     //Получаем страницу

     $fp = fsockopen($host, 80,  &$errno, &$errstr,10);

     if ($fp)

     {

     // отправляем заголовок

     fputs($fp, $hdr);

     // получаем ответ

     while (!feof($fp))

     $response .= fgets($fp, 128);

     }

     else {

     //Н получилось открыть сокет

     return "ERROR: $errno - $errstr\n";

     }





     //Закрываем сокет

     fclose($fp);



     //Если ответ - редиректит loop=true: повторяем действия со страницей на к-ю редиректнулось

     if (preg_match("|Location: (http:\/\/.*)

|Ui",$response,$mtch) ){

           $url=$mtch[1];

           if (preg_match("|id=([^&]*)|si",$url,$m)){

			$icsession=$m[1];

                 }

           $loop++;

           if ($loop>3) {

           		return "Ошибка proxy!!!";

           		}



           $post="";

           }

     else

           $loop=0;

     }



//вытаскиваем сессию из кук

/*foreach ($HTTP_COOKIE_VARS as $k=>$v){

	echo "<pre>$k=$v\n<pre>";

	}



     $resp=preg_match("|(.*SESSION=(\w+)[& ].*)



|Usi",$response,$res);

*/

if ($res[2]) $icsession=$res[2];

//echo $icsession."<BR>".$res[1];



     //Вырезаем заголовок из ответа

     $response=preg_replace("|.*



|Usi","",$response,1);



	return $response;

	}

?>