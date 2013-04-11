<?php

/*
 *  $Id: functions.php,v 1.29 2006/10/17 06:29:25 ereih Exp $
 *
 *  $Log: functions.php,v $
 *  Revision 1.29  2006/10/17 06:29:25  ereih
 *  ��������������� ������� ��� ������ � �����
 *
 *  Revision 1.27  2006/06/15 10:02:28  ereih
 *  �������� � ��������� �����������
 *
 *  Revision 1.23  2005/05/19 17:53:36  aavakyan
 *  *** empty log message ***
 *
 *  Revision 1.22  2005/05/19 12:39:04  aavakyan
 *  *** empty log message ***
 *
 *  Revision 1.21  2005/02/24 13:03:34  dave
 *  ������ ���������� ����������
 *
 *  Revision 1.20  2005/01/21 18:50:28  dave
 *  ��������� � ���������� � IC
 *
 *  Revision 1.19  2005/01/18 18:48:58  dave
 *  ���������� ������ � cmsic_*
 *
 *  Revision 1.18  2005/01/17 22:59:52  dave
 *  ��������� ����� SETVAR � SHOWVAR
 *
 *  Revision 1.17  2005/01/12 18:30:58  dave
 *  ����������� ��� ����� URL
 *
 *  Revision 1.16  2005/01/11 18:51:29  dave
 *  ����� ����������� 'u' � ���������� ����������
 *
 *  Revision 1.15  2005/01/11 18:10:13  dave
 *  ������������� ������� �������� � URL
 *
 *  Revision 1.14  2005/01/11 17:57:02  dave
 *  �������� MD5-������� ������������ 20-���������� ���� (������������� � ������������ ���������� ����)
 *
 *  Revision 1.13  2005/01/11 17:22:41  dave
 *  � geticpage ��������� ��������� ��������� ���� �� ������ � ������
 *
 *  Revision 1.12  2005/01/10 17:58:08  dave
 *  1. ����������� � geticpage
 *  2. ������� �������� �������
 *
 *  Revision 1.11  2004/12/26 11:47:27  dave
 *  ������������������ ����
 *
 *  Revision 1.9  2004/12/20 22:27:19  dave
 *  ����������� ���������� sitelib.php
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

                $qt = 0; //������� ������� �������
                $qt1 = 0; //������� ��������� �������
                $buf = ""; //�����
                // ����������� �� ������
                for ($j = 0;$j < strlen($string);$j++) {
                        // ���� ������� ������ - ������� ������� �� ����������� � ��������� � ��� �� ������������ ����������� �������
                        if ($string[$j] == '"' and ($qt1 % 2) == 0
                                        and (
                                                ($string[$j-1] != '\\' and ($qt % 2) == 1)
                                                or
                                                ($qt % 2) == 0
                                                )
                                        )
                                $qt++;
                        // ���� ������� ������ - ��������� ������� �� ����������� � ������� � ��� �� ������������ ����������� �������
                        if ($string[$j] == "'" and ($qt % 2) == 0
                                        and (
                                                ($string[$j-1] != '\\' and ($qt1 % 2) == 1)
                                                or
                                                ($qt1 % 2) == 0
                                                )
                                        )
                                $qt1++;
                        // ���� ������� ������ - �� ������ ��� ������ ������ ����� ������� ������� ����������� ��� ������� �������
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
                // �������� ������ HTML ����� �� ������
                $pattern = '|<(/)?\w+[^\>]*>|usi';
                preg_match_all($pattern, $string, $reg, PREG_SET_ORDER);
                // ��������� ����� �� �����
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
                        // �������� ����� � ������� �������
                        $str = $reg[$i][0];
                        // �������� ��������� � ������� ������� (< .... >)
                        // $buf.= stripspaces($str);
                        $buf .= $str;
                        // ������ � ����� ����� �������������� �������� ����
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
        // �������� ������ ID ���������� ������� � �� ���������
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
        // ��������� sql � ���������� ��� �������� ���������� �� ������ ({-[��� ���� �������� �������]-})
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
                // ��������
                $out .= "<a class=lister href=" . $url . "page=0>������</a> | ";
                $out .= "<a class=lister href=" . $url . "page=" . ($cnt - $cnt % $count) . ">���������</a> <br>";

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
                // ����������� � URL ��������� cmsic_*
                $cmsic_url = list_cmsic_url();
                if ($cmsic_url)
                        $url .= (strpos($url, '?') ? '&' : '?').list_cmsic_url();
                // �������� id � GET �� $icsessionid
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

                // �������� ����� POST ���������� �� URL
                if (strpos($url1, '?') > 0) {
                        $url_param = substr($url1, strpos($url1, '?') + 1, strlen($url1) - strpos($url1, '?') - 1);
                        $post .= '&'.$url_param;
                }

                //echo "<hr>$post";
                // �������� ����������, ������� ���� �������� � POST
                $vars = array('mv_session_id' => $icsession, 'docid' => $docid, 'cmsurl' => urlencode("http://".$SERVER_NAME.$REQUEST_URI));
                foreach ($_SESSION as $s => $v) {
                        if (substr($s, 0, 6) == 'cmsic_')
                                $vars[$s] = $v;
                }

                //$vars['mv_arg']=503;

                //echo "<hr>";
                //print_r ($vars);
                //echo "<hr>";

                // ����������� ���������� � POST (���� ���� ���� �� ���� ��������)

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

                // ���� ������� ��� while (��� ��������� ���������)
                $loop = 1;

                while ($loop) {
                        if (preg_match("|http://$ichostinurl/cgi-bin/$iccat.cgi/login.html.*|si", $url))
                                return ($loginplease);
                        $response = "";
                        $hdr = "";
                        // �������� ���� �� URL
                        preg_match("/^(http:\/\/)?([^\/]+)/i", $url, $matches);
                        $host = $matches[2];
                        // ��������� ������ ������� (���� ���� ���� ���������� POST ���� ��� - GET)
                        $url = preg_replace("|=(.*)/|Usie", "'='.urlencode('\\1').'/'", $url);


            // ��������� ���
            if ($use_cache_read && isset($_SESSION['ic_cache'])) {
                // return $_SESSION['ic_cache'][$url.'|'.$icsession]; -- ��� �������� ���������� URL
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
                        // ���� ��� �������� ���������� ������ �� GET
                        if ($loop > 1 and preg_match("|id=([^&]*)|usi", $url, $m)) {
                                $icsession = $m[1];
                        }
                        // ����������� Content-length � ���������
                        $post = preg_replace("|^&|Usi", "", $post);
                        $hdr .= "Cookie: MV_SESSION_ID=$icsession\r\n";
                        if ($post) $hdr .= "Content-length:" . strlen($post) . "\r\n\r\n";
                        // ����������� ���� ���������� � ���������
                        $hdr .= $post . "\r\n\r\n";
   
                        /**
                        */
	                  if ($debug|| $_GET[debug]) echo "<PRE>$hdr</pre>";
                        /**
                        */
					/*echo "<pre>";
   					print_r($host);	   
   					echo "</pre>";*/
                        // �������� ��������
                        $fp = fsockopen($host, 80, &$errno, &$errstr, 10);
                        if ($fp) {
                                // ���������� ���������
                                fputs($fp, $hdr);
                                // �������� �����
                                while (!feof($fp))
                                $response .= fgets($fp, 128);
                        } else {
                                // � ���������� ������� �����
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
                        // ��������� �����
                        fclose($fp);
                        // ���� ����� - ���������� loop=true: ��������� �������� �� ��������� �� �-� ��������������
                        if (preg_match("|Location: (http:\/\/.*)
|Ui", $response, $mtch)) {
                                $url = $mtch[1];
                                /*           if (preg_match("|id=([^&]*)|si",$url,$m)){
                           echo "!!!";
                 echo $icsession=$m[1];
                 }*/
                                $loop++;
                                if ($loop > 3) {
                                        return "������ proxy!!!";
                                }

                                $post = "";
                        } else
                                $loop = 0;
                }
                // �������� ��������� �� ������

                $response = preg_replace("|.*\r\n\r\n|Usi", "", $response, 1);
		
        // �������� ��������
        if ($use_cache_write && $response != '') {
            //$_SESSION['ic_cache'][$url.'|'.$icsession] = $response; -- ��� �������� ���������� URL
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
                $rus = array ('/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/',
                        '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/',
                        '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/',
                        '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/',
                        '/�/', '/�/', '/�/', '/�/', '/�/', '/�/');

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
                $trans = array(' ' => '_', '�' => 'a', '�' => 'b', '�' => 'v', '�' => 'g', '�' => 'd', '�' => 'e', '�' => 'yo',
                               '�' => 'zh','�' => 'z', '�' => 'i', '�' => 'j', '�' => 'k', '�' => 'l', '�' => 'm', '�' => 'n',
                               '�' => 'o', '�' => 'p', '�' => 'r', '�' => 's', '�' => 't', '�' => 'u', '�' => 'f', '�' => 'h',
                               '�' => 'c', '�' => 'ch','�' => 'sh','�' => 'sh','�' => '',  '�' => 'y', '�' => '' , '�' => 'e', //E'
                               '�' => 'yu','�' => 'ya',

                               '0' => '0', '1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5', '6' => '6', '7' => '7',
                               '8' => '8', '9' => '9',

                               '�' => 'A', '�' => 'B', '�' => 'V', '�' => 'G', '�' => 'D', '�' => 'E', '�' => 'YO','�' => 'ZH',
                               '�' => 'Z', '�' => 'I', '�' => 'J', '�' => 'K', '�' => 'L', '�' => 'M', '�' => 'N', '�' => 'O',
                               '�' => 'P', '�' => 'R', '�' => 'S', '�' => 'T', '�' => 'U', '�' => 'F', '�' => 'H', '�' => 'Z',
                               '�' => 'CH','�' => 'SH','�' => 'SH','�' => '' , '�' => 'Y', '�' => '' , '�' => 'E', //E'
                               '�' => 'YU', '�' => 'YA',

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
// ������� ��� ������ {���_�����_�������} �� �������� ����� �����.
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
  
	//���������� ������ ����� ������ � ��� ������
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