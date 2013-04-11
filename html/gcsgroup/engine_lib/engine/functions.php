<?php

/*
 *  $Id: functions.php,v 1.29 2006/10/17 06:29:25 ereih Exp $
 *
 *  $Log: functions.php,v $
 *  Revision 1.29  2006/10/17 06:29:25  ereih
 *  Корректирование функций для работы с кодом
 *
 *  Revision 1.27  2006/06/15 10:02:28  ereih
 *  Редизайн и улучшение функционала
 *
 *  Revision 1.23  2005/05/19 17:53:36  aavakyan
 *  *** empty log message ***
 *
 *  Revision 1.22  2005/05/19 12:39:04  aavakyan
 *  *** empty log message ***
 *
 *  Revision 1.21  2005/02/24 13:03:34  dave
 *  Убрана отладочная информация
 *
 *  Revision 1.20  2005/01/21 18:50:28  dave
 *  Изменения в обращениях к IC
 *
 *  Revision 1.19  2005/01/18 18:48:58  dave
 *  Исправлена работа с cmsic_*
 *
 *  Revision 1.18  2005/01/17 22:59:52  dave
 *  Поддержка тегов SETVAR и SHOWVAR
 *
 *  Revision 1.17  2005/01/12 18:30:58  dave
 *  Кеширование без учета URL
 *
 *  Revision 1.16  2005/01/11 18:51:29  dave
 *  Убран модификатор 'u' в регулярных выражениях
 *
 *  Revision 1.15  2005/01/11 18:10:13  dave
 *  Настраиваемый префикс контента в URL
 *
 *  Revision 1.14  2005/01/11 17:57:02  dave
 *  Проверка MD5-паролей поддерживает 20-символьные хеши (совместимость с существующей структурой базы)
 *
 *  Revision 1.13  2005/01/11 17:22:41  dave
 *  В geticpage разделены параметры включения кеша на запись и чтение
 *
 *  Revision 1.12  2005/01/10 17:58:08  dave
 *  1. кеширование в geticpage
 *  2. функция проверки паролей
 *
 *  Revision 1.11  2004/12/26 11:47:27  dave
 *  Переформатирование кода
 *
 *  Revision 1.9  2004/12/20 22:27:19  dave
 *  Подключение библиотеки sitelib.php
 *
 *
 */
// Allow only one instance of functions.php
if (!defined('ENGINE_FUNCTIONS_INCLUDED')) {
        define('ENGINE_FUNCTIONS_INCLUDED', true);

    if (!defined('ENGINE_CONTENT_PREFIX'))
        define ('ENGINE_CONTENT_PREFIX', 'cntnt');

        include_once 'sitelib.php';

        function stripspaces($string)
        {
                $spaces[0] = " ";
                $spaces[1] = "        ";

                $qt = 0; //счетчик двойных кавычек
                $qt1 = 0; //счетчик одинарных кавычек
                $buf = ""; //Буфер
                // пробегаемся по тексту
                for ($j = 0;$j < strlen($string);$j++) {
                        // если текущий символ - двойная кавычка не заключенная в одинарные и она не экранирована увеличиваем счетчик
                        if ($string[$j] == '"' and ($qt1 % 2) == 0
                                        and (
                                                ($string[$j-1] != '\\' and ($qt % 2) == 1)
                                                or
                                                ($qt % 2) == 0
                                                )
                                        )
                                $qt++;
                        // если текущий символ - одинарная кавычка не заключенная в двойные и она не экранирована увеличиваем счетчик
                        if ($string[$j] == "'" and ($qt % 2) == 0
                                        and (
                                                ($string[$j-1] != '\\' and ($qt1 % 2) == 1)
                                                or
                                                ($qt1 % 2) == 0
                                                )
                                        )
                                $qt1++;
                        // если текущий символ - не пробел или первый пробел после другого символа находящийся вне кавычек выводим
                        if (($qt % 2) != 0 or ($qt1 % 2) != 0)
                                $buf .= $string[$j];
                        else if (!in_array ($string[$j], $spaces) and ord($string[$j]) != "13" and ord($string[$j]) != "10")
                                $buf .= $string[$j];
                        else
                        if ((!in_array ($string[$j], $spaces) or !in_array ($string[$j-1], $spaces)) and ord($string[$j]) != "13" and ord($string[$j]) != "10")
                                $buf .= $string[$j];
                }
                if (!preg_replace("|[
]|si", "", $buf))$buf = "";
                return $buf;
        }

        function htmlstripspaces($string)
        {
                $pre = 0;
                $script = 0;
                $textarea = 0;
                $button = 0;
                $buf = "";
                // получаем массив HTML тагов из строки
                $pattern = '|<(/)?\w+[^\>]*>|usi';
                preg_match_all($pattern, $string, $reg, PREG_SET_ORDER);
                // разрезаем текст по тагам
                $txt = preg_split ($pattern, $string);
                $i = 0;
                $buf .= stripspaces($txt[$i]);
                while ($reg[$i][0]) {
                        if (preg_match("'<pre(|\s[^>]*)>'Usi", $reg[$i][0]))
                                $pre++;
                        if (preg_match("'</\s*pre(|\s[^>]*)>'Usi", $reg[$i][0]))
                                $pre--;
                        if (preg_match("'<script(|\s[^>]*)>'Usi", $reg[$i][0]))
                                $script++;
                        if (preg_match("'</script(|\s[^>]*)>'Usi", $reg[$i][0]))
                                $script--;
                        if (preg_match("'<textarea(|\s[^>]*)>'Usi", $reg[$i][0]))
                                $textarea++;
                        if (preg_match("'</textarea(|\s[^>]*)>'Usi", $reg[$i][0]))
                                $textarea--;
                        if (preg_match("'<button(|\s[^>]*)>'Usi", $reg[$i][0]))
                                $button++;
                        if (preg_match("'</button(|\s[^>]*)>'Usi", $reg[$i][0]))
                                $button--;
                        // получаем текст в таговых скобках
                        $str = $reg[$i][0];
                        // отключил вырезание в таговых скобках (< .... >)
                        // $buf.= stripspaces($str);
                        $buf .= $str;
                        // кладем в буфер текст предшествующий текущему тагу
                        if (!$script and !$pre and !$textarea and !$button) {
                                $buf .= preg_replace("|<!--.*-->|Usi", "", stripspaces($txt[$i + 1]));
                        } else {
                                $buf .= $txt[$i + 1];
                        }
                        $i++;
                }
                // exit;
                return $buf;
                // return $string;
        }
        // Получает Списое ID документов рубрики и ее подрубрик
        function get_subrubsdocs($id, $rubdocs)
        {
                global $rubs;

                $rubs .= $id;

                if (!($id * 1)) {
                        $sql = "select * from engine_rubrique where name='$id'";
                        list($id) = mysql_fetch_array(mysql_query($sql));
                }
                $sql = "select * from engine_docsinrubriques where rub=$id and `in`=1";
                $r = mysql_query($sql);
                while ($f = mysql_fetch_array($r)) {
                        if ($rubdocs)$rubdocs .= ", ";
                        $rubdocs .= $f[doc];
                }
                $sql = "select * from engine_rubrique where pid=$id";
                $r = mysql_query($sql);
                while ($f = mysql_fetch_array($r)) {
                        get_subrubsdocs($f[id], &$rubdocs);
                }
                return $rubs;
        }
        // выполняет sql и возвращает все элементы наложенные на формат ({-[имя поля большими буквами]-})
        function dbparse($sql, $format1, $format2 = "")
        {
                $format[0] = $format1;
                if (!$format2)
                        $format[1] = $format[0];
                else
                        $format[1] = $format2;
                $r = mysql_query($sql);

                while ($f = mysql_fetch_array($r)) {
                        $buf = $format[(($i++) % 2)];
                        /*                    if ($vals){
                                $bv=$vals;
                  foreach ($bv as $k =>$v){
                       foreach ($f as $key =>$val){
                           $v=str_replace("{-".strtoupper($key)."-}",$val,$v);
                           }
                          $buf=str_replace($k,$v,$buf);
                       }
                                }
                                */
                        foreach ($f as $key => $val) {
                                $buf = str_replace("{-" . strtoupper($key) . "-}", $val, $buf);
                        }
                        $res .= $buf;
                }
                return $res;
        }

        function dbparserow($f, $format)
        {
                $buf = $format;
                foreach ($f as $key => $val) {
                        $buf = str_replace("{-" . strtoupper($key) . "-}", $val, $buf);
                }
                $res .= $buf;
                return $res;
        }
        function lister($url, $count, $table, $cause = "", $pcount = 10)
        {
                global $page, $total;
                list($cnt) = mysql_fetch_array(mysql_query("select count(*) from $table where $cause"));
                $total = $cnt;
                $cnt--;
                // Листалка
                $out .= "<a class=lister href=" . $url . "page=0>Первая</a> | ";
                $out .= "<a class=lister href=" . $url . "page=" . ($cnt - $cnt % $count) . ">Последняя</a> <br>";

                if (($page - $page % ($count * $pcount) - $count * $pcount) >= 0)
                        $out .= "<a class=lister href=" . $url . "page=" . ($page - $page % $count - $count * $pcount) . "><<<</a> ";
                for ($i = ($page - $page % ($count * $pcount));$i < min($page - $page % ($count * $pcount) + $pcount * $count, $cnt - $cnt % $count + $count);$i += $count) {
                        if ($page != $i)$out .= "<a class=lister href=" . $url . "page=$i>" . ($i / $count + 1) . "</a> ";
                        else $out .= "<b>" . ($i / $count + 1) . "</b> ";
                }
                if (($page - $page % ($count * $pcount) + $count * $pcount) <= $cnt)
                        $out .= "<a class=lister href=" . $url . "page=" . ($page - $page % $count + $count * $pcount) . ">>>></a> ";
                return $out;
        }

        function geticpage($url, $sendvars = 1, $docid = 0, $use_cache_read = false, $use_cache_write = false)
        {
                global $HTTP_POST_VARS, $_POST, $_SERVER, $icsession, $iclogged, $sitelogged, $class, $loginplease, $HTTP_COOKIE_VARS;
                global $cmshost, $ichost, $iccat, $ichost, $ichostinurl;
                global $SERVER_NAME, $REQUEST_URI;
                $debug = 0;
                unset($post);
                if ($debug) echo "!!!" . $icsession;
                $ah = getallheaders();
                // приписываем в URL параметры cmsic_*
                $cmsic_url = list_cmsic_url();
                if ($cmsic_url)
                        $url .= (strpos($url, '?') ? '&' : '?').list_cmsic_url();
                // заменяем id в GET на $icsessionid
                if ($icsession) {
                        $url1 = preg_replace("|&id=([^&]*)|si", "&id=$icsession", $url);
                        $url1 = preg_replace("|\?id=([^&]*)|si", "?id=$icsession", $url);
                } else
                        $url1 = $url;
                $url = preg_replace("|id=([^&]*)|si", "", $url);

                if ($url == $url1 and $icsession) {
                        if (strstr($url, "?"))
                                $url1 = $url . "&id=$icsession";
                        else
                                $url1 = $url . "?id=$icsession";
                }
                //echo "<hr>UP: $url_param<hr>";


                if ($sendvars) {
                        $fin = file("php://input");
                        $post = $fin[0];
                        if (preg_match("|[&?]id=([^&]*)|si", $post, $m)) {
                                $icsession = $m[1];
                        }
               	// echo "<hr>UP: ".$fin."<hr>";


                } else {
                        //$post = "&mv_session_id=$icsession";
                        //$post .= "&docid=$docid";
                        //$post .= "&cmsurl=" . urlencode("http://" . $SERVER_NAME . $REQUEST_URI);
                }

                // Передаем через POST переменные из URL
                if (strpos($url1, '?') > 0) {
                        $url_param = substr($url1, strpos($url1, '?') + 1, strlen($url1) - strpos($url1, '?') - 1);
                        $post .= '&'.$url_param;
                }

                //echo "<hr>$post";
                // Собираем переменные, которые надо передать в POST
                $vars = array('mv_session_id' => $icsession, 'docid' => $docid, 'cmsurl' => urlencode("http://".$SERVER_NAME.$REQUEST_URI));
                foreach ($_SESSION as $s => $v) {
                        if (substr($s, 0, 6) == 'cmsic_')
                                $vars[$s] = $v;
                }

                //$vars['mv_arg']=503;

                //echo "<hr>";
                //print_r ($vars);
                //echo "<hr>";

                // Прописываем переменные в POST (если есть хотя бы одна непустая)

                foreach ($vars as $var => $val)
                {
                        if ($val) {
                                if (preg_match("|\?".$var."=([^&]*)|si", $post))
                                {
                                        $post = preg_replace("|\?".$var."=([^&]*)|si", '?'.$var.'='.$val, $post);
                                }
                                else
                                {
                                        $post .= "&$var=$val";
                                }
                        }
                }

                //echo "$post<hr>";
                $url = $url1;

                // флаг повтора для while (для обработки редиректа)
                $loop = 1;

                while ($loop) {
                        if (preg_match("|http://$ichostinurl/cgi-bin/$iccat.cgi/login.html.*|si", $url))
                                return ($loginplease);
                        $response = "";
                        $hdr = "";
                        // Получаем Хост из URL
                        preg_match("/^(http:\/\/)?([^\/]+)/i", $url, $matches);
                        $host = $matches[2];
                        // Формируем строку запроса (если есть пост переменные POST если нет - GET)
                        $url = preg_replace("|=(.*)/|Usie", "'='.urlencode('\\1').'/'", $url);


            // Проверяем кеш
            if ($use_cache_read && isset($_SESSION['ic_cache'])) {
                // return $_SESSION['ic_cache'][$url.'|'.$icsession]; -- для хранения раздельных URL
                return $_SESSION['ic_cache'];
            }

                        if (strtolower(substr($url, 0, 7)) != 'http://')
                                $url = "http://$url";
                        if ($post)
                                $hdr .= "POST $url HTTP/1.0\r\n";
                        else
                                $hdr .= "GET $url HTTP/1.0\r\n";

                        //echo "HDR: $hdr<br>";
                        //echo "POST: $post<hr>";
                        // если был редирект запоминаем сессию из GET
                        if ($loop > 1 and preg_match("|id=([^&]*)|usi", $url, $m)) {
                                $icsession = $m[1];
                        }
                        // Прописываем Content-length в заголовок
                        $post = preg_replace("|^&|Usi", "", $post);
                        $hdr .= "Cookie: MV_SESSION_ID=$icsession\r\n";
                        if ($post) $hdr .= "Content-length:" . strlen($post) . "\r\n\r\n";
                        // Прописываем пост переменные в заголовок
                        $hdr .= $post . "\r\n\r\n";
   
                        /**
                        */
	                  if ($debug|| $_GET[debug]) echo "<PRE>$hdr</pre>";
                        /**
                        */
					/*echo "<pre>";
   					print_r($host);	   
   					echo "</pre>";*/
                        // Получаем страницу
                        $fp = fsockopen($host, 80, &$errno, &$errstr, 10);
                        if ($fp) {
                                // отправляем заголовок
                                fputs($fp, $hdr);
                                // получаем ответ
                                while (!feof($fp))
                                $response .= fgets($fp, 128);
                        } else {
                                // Н получилось открыть сокет
                                return "ERROR: $errno - $errstr\n";
                        }
				if ($sendvars) {
					/*echo "<pre>";
   					print_r($hdr);	   
   					echo "</pre>";
					echo "<pre>";
   					print_r($response);	   
   					echo "</pre>";*/
				}
                        $response1 = preg_replace("|\r\n\r\n.*|si", "", $response);
                        /**
                        */
                        if ($debug) echo "<PRE>" . $response1 . "</pre>";
                        /**
                        */
                        // if (!$icsession){
                        preg_match("|X-Track\: SESSION=(\w+)&|Usi", $response1, $m);
                        $icsession = $m[1];
                        // }
                        // Закрываем сокет
                        fclose($fp);
                        // Если ответ - редиректит loop=true: повторяем действия со страницей на к-ю редиректнулось
                        if (preg_match("|Location: (http:\/\/.*)
|Ui", $response, $mtch)) {
                                $url = $mtch[1];
                                /*           if (preg_match("|id=([^&]*)|si",$url,$m)){
                           echo "!!!";
                 echo $icsession=$m[1];
                 }*/
                                $loop++;
                                if ($loop > 3) {
                                        return "Ошибка proxy!!!";
                                }

                                $post = "";
                        } else
                                $loop = 0;
                }
                // Вырезаем заголовок из ответа

                $response = preg_replace("|.*\r\n\r\n|Usi", "", $response, 1);
		
        // Кешируем страницу
        if ($use_cache_write && $response != '') {
            //$_SESSION['ic_cache'][$url.'|'.$icsession] = $response; -- для хранения раздельных URL
            $_SESSION['ic_cache'] = $response;
            //print_r($_SESSION['ic_cache']);
        }
        get_cmsic_vars($response);
                return $response;
        }

        function urlconvert($curl, $url)
        {
                $url = preg_replace("|([&?])id=([^&]*)|sie", "('\\1'=='?' and '\\3'=='&')?'?':''", $url);
                return $curl . $url;
        }

        /**
        *
        * @desc Transliterates russian characters in string
        * @return string
        * @param string $string
        */
        function engine_translit ($string)
        {
                $rus = array ('/а/', '/б/', '/в/', '/г/', '/д/', '/е/', '/ё/', '/ж/', '/з/', '/и/', '/к/', '/л/',
                        '/м/', '/н/', '/о/', '/п/', '/р/', '/с/', '/т/', '/у/', '/ф/', '/х/', '/ч/', '/ц/', '/щ/', '/ш/', '/й/', '/ы/',
                        '/ъ/', '/ь/', '/э/', '/ю/', '/я/', '/А/', '/Б/', '/В/', '/Г/', '/Д/', '/Е/', '/Ё/', '/Ж/', '/З/', '/И/', '/К/',
                        '/Л/', '/М/', '/Н/', '/О/', '/П/', '/Р/', '/С/', '/Т/', '/У/', '/Ф/', '/Х/', '/Ч/', '/Ц/', '/Щ/', '/Ш/', '/Й/',
                        '/Ы/', '/Ъ/', '/Ь/', '/Э/', '/Ю/', '/Я/');

                $trans = array ('a', 'b', 'v', 'g', 'd', 'e', 'yo', 'j', 'z', 'i', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's',
                        't', 'u', 'f', 'h', 'ch', 'ch', 'sh', 'sh', 'y', 'i', '', '', 'e', 'u', 'ya', 'A', 'B', 'V', 'G', 'D', 'E', 'YO',
                        'J', 'Z', 'I', 'K', 'L', 'M', 'N', 'O', 'P', 'R', 'S', 'T', 'U', 'F', 'H', 'Ch', 'Ch', 'Sh', 'Sh', 'Y', 'I', '',
                        '', 'E', 'U', 'Ya');

                $string = preg_replace ($rus, $trans, $string);
                return $string;
        }

        /**
        *
        * @desc Removes special characters from sting
        * @return string
        * @param string $string
        */
        function engine_remove_nonprint ($string)
        {
                $nonprint = array ('/ /', '/\"/', '/\\\'/', '/\`/', '/\~/', '/\@/', '/\&/', '/\*/', '/\=/', '/\+/', '/\\\\/', '/\:/',
                        '/\;/', '/\</', '/\>/', '/\,/', '/\./', '/\//', '/\?/');
                $empty = array ('', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
                $string = preg_replace ($nonprint, $empty, $string);
                return $string;
        }

        /**
        *
        * @desc Quotes '%' and '_' for SQL LIKE argument
        * @return string
        * @param string $string
        */
        function engine_like_quote ($string)
        {
                $string = preg_replace (array ('/\%/', '/\_/'), array ('\%', '\_'), $string);
                return $string;
        }

        /**
        *
        * @desc Checks code existance in database
        * @return bool
        * @param string $code
        */
        function engine_check_code ($code)
        {
                $sql = 'SELECT count(*) as total
                        FROM engine_documents
                        WHERE code="'.mysql_real_escape_string($code).'"';
                if (!($result = mysql_query($sql)))
                {
                        return false;
                }

                if ($row = mysql_fetch_array($result, MYSQL_ASSOC))
                {
                        if ($row['total'] <= 0)
                        {
                                return true;
                        }
                }
                mysql_free_result($result);

                return false;
        }

        function GenerateCode($name, $do_substr = true)
        {
                $trans = array(' ' => '_', 'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd', 'е' => 'e', 'ё' => 'yo',
                               'ж' => 'zh','з' => 'z', 'и' => 'i', 'й' => 'j', 'к' => 'k', 'л' => 'l', 'м' => 'm', 'н' => 'n',
                               'о' => 'o', 'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't', 'у' => 'u', 'ф' => 'f', 'х' => 'h',
                               'ц' => 'c', 'ч' => 'ch','ш' => 'sh','щ' => 'sh','ъ' => '',  'ы' => 'y', 'ь' => '' , 'э' => 'e', //E'
                               'ю' => 'yu','я' => 'ya',

                               '0' => '0', '1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5', '6' => '6', '7' => '7',
                               '8' => '8', '9' => '9',

                               'А' => 'A', 'Б' => 'B', 'В' => 'V', 'Г' => 'G', 'Д' => 'D', 'Е' => 'E', 'Ё' => 'YO','Ж' => 'ZH',
                               'З' => 'Z', 'И' => 'I', 'Ё' => 'J', 'К' => 'K', 'Л' => 'L', 'М' => 'M', 'Н' => 'N', 'О' => 'O',
                               'П' => 'P', 'Р' => 'R', 'С' => 'S', 'Т' => 'T', 'У' => 'U', 'Ф' => 'F', 'Х' => 'H', 'Ц' => 'Z',
                               'Ч' => 'CH','Ш' => 'SH','Щ' => 'SH','Ъ' => '' , 'Ы' => 'Y', 'Ь' => '' , 'Э' => 'E', //E'
                               'Ю' => 'YU', 'Я' => 'YA',

                               'a' => 'a', 'b' => 'b', 'c' => 'c', 'd' => 'd', 'e' => 'e', 'f' => 'f', 'g' => 'g', 'h' => 'h',
                               'i' => 'i', 'j' => 'j', 'k' => 'k', 'l' => 'l', 'm' => 'm', 'n' => 'n', 'o' => 'o', 'p' => 'p',
                               'q' => 'q', 'r' => 'r', 's' => 's', 't' => 't', 'u' => 'u', 'v' => 'v', 'w' => 'w', 'x' => 'x',
                               'y' => 'y', 'z' => 'z',

                               'A' => 'A', 'B' => 'B', 'C' => 'C', 'D' => 'D', 'E' => 'E', 'F' => 'F', 'G' => 'G', 'H' => 'H',
                               'I' => 'I', 'J' => 'J', 'K' => 'K', 'L' => 'L', 'M' => 'M', 'N' => 'N', 'O' => 'O', 'P' => 'P',
                               'Q' => 'Q', 'R' => 'R', 'S' => 'S', 'T' => 'T', 'U' => 'U', 'V' => 'V', 'W' => 'W', 'X' => 'X',
                               'Y' => 'Y', 'Z' => 'Z',

                               '_' => '_'
                               );

                $buffer = '';
                for($i=0; $i<strlen($name); $i++)
                {
                        $buffer .= $trans[$name[$i]];
                }
                if ($do_substr)
                {                	$buffer = substr($buffer, 0, 10);
                }
                return $buffer;
        }

        /**
        *
        * @desc Gets preferred document code
        * @return bool
        * @param string $name
        * @param string $code
        * @param string $type
        */
        function engine_get_preferred_document_code ($name, $code = '', $type = '')
        {
                if (!empty($code))
                {                	$name = $code;
                }

                $name = trim($name);
                $new_code = GenerateCode($name, ($code) ? false : true);
                $new_code = correct_output_code($new_code);

                $sql = 'SELECT code
                        FROM engine_documents
                        WHERE code LIKE "'.mysql_real_escape_string($new_code).'%"';

                $result = mysql_query($sql);
                $max_code = 0;
                $temp_code = '';
                while($row = mysql_fetch_array($result, MYSQL_ASSOC))
                {
                        $num = intval(substr($row['code'], strlen($new_code)));
                        $max_code = max($max_code, $num);
                        $temp_code = $new_code.($max_code+1);
                }
                mysql_free_result($result);

                if (!empty($temp_code))
                {
                        $new_code = $temp_code;
                }
                return $new_code;
        }

        function correct_output_code($name)
        {
                if (ctype_digit($name{0}))
                {
                        $name = 'N'.$name;
                }
                return $name;
        }

        /**
        *
        * @desc Checks login/password pair
        * @return bool
        * @param string $login
        * @param string $password
        */
        function check_login_pair ($db_f,$login, $password) {
        	if ($login == '')
           		return false;

		$where = " and active=1";
	 	if (!$db_f || $db_f == '') {
			$db_f = "engine_users";
		}
		else{
			$where = '';
		}
        	$query = "select pass from ".$db_f." where login='".db_quote($login)."' ".$where;
        	$r = db_get_array (db_select($query));
       	if (db_get_rows_affected() == 0) {
           	 	return false;
        	}
        	$password_db = trim ($r['pass']);
        	if (strlen($password_db) == 32 || strlen($password_db) == 20) {
            		// md5 password
                	//echo $password_db.' == '.substr(md5($password), 0, strlen($password_db));exit;
            		if ($password_db == substr(md5($password), 0, strlen($password_db)))
                    //echo "true";exit;
                		return true;
       	} else {
            		// text password
            		if ($password_db == $password)
                		return true;
        	}
        	return false;
    	}

        /**
        *
        * @desc Returns "cmsic_*" session variables as HTML comments
        * @return string
        */
        function list_cmsic_vars () {
                $str = '';
                foreach ($_SESSION as $s => $v) {
                        if (substr($s, 0, 6) == 'cmsic_')
                                $str .= "<!-- ICVARS $s=\"$v\" -->";
                }
                return $str;
        }

        /**
        *
        * @desc Get "cmsic_*" session variables from HTML comments
        * @return void
        */
        function get_cmsic_vars ($buffer) {
                preg_match_all('<!--\s*ICVARS\s+([\d|\w]+)=\"([\d|\w]+)\"\s*-->', $buffer, $vars);
                for ($i = 0; $i < count($vars[0]); $i++) {
                        $_SESSION[$vars[1][$i]] = $vars[2][$i];
                }
        }

        /**
        *
        * @desc Returns "cmsic_*" variables as URL part
        * @return string
        */
        function list_cmsic_url () {
                $p = array();
                foreach ($_SESSION as $s => $v) {
                        if (substr($s, 0, 6) == 'cmsic_')
                                array_push ($p, urlencode(trim($s)).'='.urlencode(trim($v)));
                }
                return join('&', $p);
        }



//
// Функция для замены {Имя_ключа_массива} на значение этого ключа.
//
function AssignVars($assign_vars, $template, $pattern = "/{(.*?)}/", $all_vars = true)
{
	$size = preg_match_all($pattern, $template, $found_vars);

	for($i = 0; $i < $size; $i++)
	{		if ($all_vars)
		{			$template = str_replace($found_vars[0][$i], $assign_vars[$found_vars[1][$i]], $template);
		}
		else
		{			if (isset($assign_vars[$found_vars[1][$i]]))
			{				$template = str_replace($found_vars[0][$i], $assign_vars[$found_vars[1][$i]], $template);
			}
		}
	}
  
	//возвращаем шаблон после замены в нем ключей
	return $template;
}

function file_php($file_name){
	$file_name = str_replace("php",".php",$file_name);
	$file_name = str_replace("..",".",$file_name);
	if (file_exists($file_name)){
	     include_once $file_name;
    	}
}
}
?>