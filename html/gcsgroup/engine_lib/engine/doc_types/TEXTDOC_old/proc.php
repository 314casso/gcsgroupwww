<?php

/*
 *  $Id: proc.php,v 1.7 2005/02/24 08:19:05 dave Exp $
 *
 *  $Log: proc.php,v $
 *  Revision 1.7  2005/02/24 08:19:05  dave
 *  Разрешено использование тега <EM>
 *
 *  Revision 1.6  2005/01/11 18:42:16  dave
 *  Убран модификатор 'u' в регулярных выражениях
 *
 */
 //echo "html: ".htmlspecialchars($html)."<br>";exit;

                                $i=0;

                                function bg(){

                                        global $i;

                                        if (++$i%2==0){

                                                return "tr2";

                                                }

                                        else

                                                return "tr1";

                                        }

                                $html=stripslashes($html);

//вырезаем ненужные таги

                                $html=strip_tags ($html,'<BR><pre><hr><div><BLOCKQUOTE><img><a><u><b><i><span><table><th><tr><td><ol><ul><li><h1><h2><h3><h4><strong><p><strike><sup><sub><center><em>');

//вырезаем объявления классов

//? >!!!                $html=preg_replace ("|(<[^>]*)(class=\s*[\"']?\w+[\"']?)(\s[^>]*)? >|Usi","\\1  \\3>",$html);

//проставляем классы вида textdoc_[название тага]

                                 $html=preg_replace("|<(\w+)([ >])|sie","(strtolower('\\1')!='tr')?'<\\1 class=textdoc \\2':'<\\1 class=textdoc_'.bg().' \\2'",$html);

//убираем классы из якорей

                                $html=preg_replace ("|<A class=textdoc_a([^>]*)>|Usie","(stristr(\"\\1\",'href'))?'<a class=textdoc_a'.\"\\1\".'>':'<a '.\"\\1\".'>'",$html);

//Убираем вставленные классы от туда где проставлены пользовательские

                                $html=preg_replace ("|<(\w+) class=textdoc ([^>]*)(class=[^>]*)>|Usi","<\\1 \\2\\3>",$html);





//подменяем пути на относительные

                                $sn=preg_replace("|^www\.|Usi","",$SERVER_NAME);

                                $html=preg_replace("^((href|src|background) *= *([\"'])?)(https://|http://)?(www\.)?$sn"."^Usi","\\1",$html);

//кладем в базу

                                $sql="delete from  engine_TEXTDOC where doc_id=$id";

                                mysql_query($sql) or die("SQL error ".mysql_error()." in: $sql\n");

                                $html=str_replace("'","\'",$html);

                                $sql="insert into  engine_TEXTDOC(html,doc_id) values('$html',$id)";

                                mysql_query($sql) or die("SQL error ".mysql_error()." in: $sql\n");





?>