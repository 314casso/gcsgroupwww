<?php

/*
 *  $Id: FORUM.php,v 1.5 2005/01/11 18:40:28 dave Exp $
 *
 *  $Log: FORUM.php,v $
 *  Revision 1.5  2005/01/11 18:40:28  dave
 *  Убран модификатор 'u' в регулярных выражениях
 *
 *
 */

global $topic,$replay,$doreplay,$topic_,$text,$author,$page,$newtopic,$donewtopic,$sitelogged,$user,$edit,$del,$do,$forum_doc_id,$forum_doc;

$count=6;

$page=$page+0;

if ($topic==$del){
   $topic="";
   }
if ($forum_name){

      $frm=mysql_fetch_array(mysql_query("select * from engine_forum where name='$forum_name'"));



      if ($forum_doc){

            $fd=new Document($forum_doc,0);

            $sql="select * from engine_forum_msg where forum='$frm[id]' and doc={$fd->id} and pid='-1'";

            $r=mysql_query($sql);

            $tp=mysql_fetch_array($r);

            if ($tp[id]){

               $topic=$tp[id];

               $replay=1;

               $topic_=$fd->name;

               }

            else {

                  $forum_doc_id=$fd->id;

                  $newtopic=1;

                  $topic_=$fd->name;

                  }



            }

        }

$form_edit="

<form method=post>

<input type=hidden name=do value=1>

<table class=forum_tbl width=\"100%\" cellspacing=\"1\" cellpadding=\"3\" border=\"0\" bgcolor=#F3F3F3 >

        <tr>

                <th class=\"thHead\" colspan=\"2\" height=\"25\"><b>Редактирование</b></th>

        </tr>

        <tr>

                <td class=\"row1\"><span class=\"gen\"><b>Имя</b></span></td>

                <td class=\"row2\"><span class=\"genmed\"><input type=\"text\" class=\"post\" tabindex=\"1\" name=\"author\" size=\"25\" maxlength=\"25\" value=\"{-NAME-}\" /></span></td>

        </tr>

        <tr>

          <td class=\"row1\" width=\"22%\"><span class=\"gen\"><b>Тема</b></span></td>

          <td class=\"row2\" width=\"78%\"> <span class=\"gen\">

                <input type=\"text\" name=\"topic_\" size=\"45\" maxlength=\"60\" style=\"width:450px\" tabindex=\"2\" class=\"post\" value=\"{-TOPIC-}\" />

                </span> </td>

        </tr>

        <tr>

          <td class=\"row1\" valign=\"top\">

                <table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"1\">

                  <tr>

                        <td><span class=\"gen\"><b>Сообщение</b></span><BR> </td>

                  </tr>

                </table>

          </td>

          <td class=\"row2\" valign=\"top\"><span class=\"gen\">



                <table width=\"450\" border=\"0\" cellspacing=\"0\" cellpadding=\"2\">

                  <tr>

                        <td colspan=\"9\"><span class=\"gen\">

                          <textarea name=\"text\" rows=\"15\" cols=\"35\" wrap=\"virtual\" style=\"width:450px\" tabindex=\"3\" class=\"post\">{-TEXT-}</textarea>

                          </span></td>

                  </tr>

                </table>

                </span></td>

        </tr>





        <tr>

          <td class=\"catBottom\" colspan=\"2\" align=\"center\" height=\"28\">

          <input type=\"submit\" tabindex=\"6\" class=\"mainoption\" value=\"Отправить\" /></td>

        </tr>

  </table>

";



$form_new="

<form method=post>

<input type=hidden name=donewtopic value=1>

<input type=hidden name=user value={-USER-}>

<input type=hidden name=forum_doc_id value=$forum_doc_id>



<table class=forum_tbl width=\"100%\" cellspacing=\"1\" cellpadding=\"3\" border=\"0\" bgcolor=#F3F3F3 >

        <tr>

                <th class=\"thHead\" colspan=\"2\" height=\"25\"><b>Новая тема</b></th>

        </tr>

        <tr>

                <td class=\"row1\"><span class=\"gen\"><b>Имя</b></span></td>

                <td class=\"row2\"><span class=\"genmed\"><input type=\"text\" class=\"post\" tabindex=\"1\" name=\"author\" size=\"25\" maxlength=\"25\" value=\"{-NAME-}\" /></span></td>

        </tr>

        <tr>

          <td class=\"row1\" width=\"22%\"><span class=\"gen\"><b>Тема</b></span></td>

          <td class=\"row2\" width=\"78%\"> <span class=\"gen\">

                <input type=\"text\" name=\"topic_\" size=\"45\" maxlength=\"60\" tabindex=\"2\" class=\"post\" value=\"$topic_\" />

                </span> </td>

        </tr>

        <tr>

          <td class=\"row1\" valign=\"top\">

                <table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"1\">

                  <tr>

                        <td><span class=\"gen\"><b>Сообщение</b></span><BR> </td>

                  </tr>

                </table>

          </td>

          <td class=\"row2\" valign=\"top\"><span class=\"gen\">



                <table border=\"0\" cellspacing=\"0\" cellpadding=\"2\">

                  <tr>

                        <td colspan=\"9\"><span class=\"gen\">

                          <textarea name=\"text\" rows=\"15\" cols=\"35\" wrap=\"virtual\" tabindex=\"3\" class=\"post\"></textarea>

                          </span></td>

                  </tr>

                </table>

                </span></td>

        </tr>





        <tr>

          <td class=\"catBottom\" colspan=\"2\" align=\"center\" height=\"28\">

          <input type=\"submit\" tabindex=\"6\" class=\"mainoption\" value=\"Отправить\" /></td>

        </tr>

  </table>

";

$form="

<form method=post>

<input type=hidden name=doreplay value=1>

<input type=hidden name=user value={-USER-}>

<table class=forum_tbl width=\"100%\" cellspacing=\"1\" cellpadding=\"3\" border=\"0\" bgcolor=#F3F3F3>

        <tr>

                <th class=\"thHead\" colspan=\"2\" height=\"25\"><b>Ответить</b></th>

        </tr>

        <tr>

                <td class=\"row1\"><span class=\"gen\"><b>Имя</b></span></td>

                <td class=\"row2\"><span class=\"genmed\"><input type=\"text\" class=\"post\" tabindex=\"1\" name=\"author\" value=\"{-NAME-}\" /></span></td>

        </tr>

        <tr>

          <td class=\"row1\" width=\"22%\"><span class=\"gen\"><b>Тема</b></span></td>

          <td class=\"row2\" width=\"78%\"> <span class=\"gen\">

                <input type=\"text\" name=\"topic_\" tabindex=\"2\" class=\"post\" value=\"$topic_\" />

                </span> </td>

        </tr>

        <tr>

          <td class=\"row1\" valign=\"top\">

                <table width=\"100%\" border=\"0\" cellspacing=\"2\" cellpadding=\"1\">

                  <tr>

                        <td><span class=\"gen\"><b>Сообщение</b></span><BR> </td>

                  </tr>

                </table>

          </td>

          <td class=\"row2\" valign=\"top\"><span class=\"gen\">



                <table border=\"0\" cellspacing=\"0\" cellpadding=\"2\">

                  <tr>

                        <td colspan=\"9\"><span class=\"gen\">

                          <textarea name=\"text\" wrap=\"virtual\" tabindex=\"3\" class=\"post\"></textarea>

                          </span></td>

                  </tr>

                </table>

                </span></td>

        </tr>





        <tr>

          <td class=\"catBottom\" colspan=\"2\" align=\"center\" height=\"28\">

          <input type=\"submit\" tabindex=\"6\" class=\"mainoption\" value=\"Отправить\" /></td>

        </tr>

  </table>

";



$answer1="

                <tr class=forum_answer1_tr>



                <td width=\"34%\" align=\"left\" valign=\"top\" bgcolor=\"#EFEFEF\" class=forum_answer1_td1>

                        <b><a name='hr2589' class=forum_answer1_authorhref>{-AUTHOR-}</b><br>Добавлено: {-DATE-}  <br>

                        <img src=\"http://dietolog.ru/forum/user_images/1x1.gif\" alt=\"\" border=\"0\" /></td>

                <td bgcolor=\"#EFEFEF\" width=\"66%\" height=\"28\" valign=\"top\"  forum_answer1_td2>



                <table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" height=100% forum_answer1_tbl>

                        <tr class=forum_answer1_tbl_tr1>

                                <td class=forum_answer1_topictd width=\"100%\">Заголовок сообщения: <b>{-TOPIC-}</b></td>

                                ";

if ($sitelogged[ugroup]==$frm[moderator_gr] and $sitelogged)

$answer1.="

                                <td class=forum_answer1_topictd align=right valign=top nowrap>

                          <a href='?topic=$topic&page=$page&del={-ID-}'>Удалить</a> <a href='?topic=$topic&page=$page&edit={-ID-}'>Редактировать</a>

                                </td>";

$answer1.="

                        </tr>

                        <tr class=forum_answer1_hr_tr>

                                <td class=forum_answer1_hr_td colspan=2><hr class=forum_answer1_hr /></td>

                        </tr>

                        <tr class=forum_answer1_text_tr>

                                <td class=forum_answer1_text_td colspan=2>{-TEXT-}</td>

                        </tr>

                        <tr>

                                <td colspan=2><br>



                                </td>

                        </tr>

                </table>

                </td>



        </tr>

<form>

  ";



$answer2="

                <tr class=forum_answer2_tr>



                <td width=\"150\" align=\"left\" valign=\"top\" bgcolor=\"#DEE3E7\" class=forum_answer2_td1>

                        <b><a name='hr2589' class=forum_answer2_authorhref>{-AUTHOR-}</b><br>Добавлено: {-DATE-}  <br>

                        <img src=\"http://dietolog.ru/forum/user_images/1x1.gif\" alt=\"\" border=\"0\" /></td>

                <td bgcolor=\"#DEE3E7\" width=\"100%\" height=\"28\" valign=\"top\"  forum_answer2_td2>



                <table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" height=100% forum_answer2_tbl>

                        <tr class=forum_answer2_tbl_tr1>

                                <td class=forum_answer2_topictd width=\"100%\">Заголовок сообщения: <b>{-TOPIC-}</b></td>

                                ";

if ($sitelogged[ugroup]==$frm[moderator_gr] and $sitelogged)

$answer2.="

                                <td class=forum_answer1_topictd align=right valign=top nowrap>

                          <a href='?topic=$topic&page=$page&del={-ID-}'>Удалить</a> <a href='?topic=$topic&page=$page&edit={-ID-}'>Редактировать</a>

                                </td>";

$answer2.="

                        </tr>

                        <tr class=forum_answer2_hr_tr>

                                <td class=forum_answer2_hr_td colspan=2><hr class=forum_answer2_hr /></td>

                        </tr>

                        <tr class=forum_answer2_text_tr>

                                <td class=forum_answer2_text_td colspan=2>{-TEXT-}</td>

                        </tr>

                        <tr>

                                <td colspan=2><br>



                                </td>

                        </tr>

                </table>

                </td>



        </tr>

";



$topic_frmt="

                <tr bgcolor=\"#f3f3f3\">

                        <td  style=\"padding-left: 5px; padding-right: 5px;\"><a href='?topic={-ID-}'>&nbsp;{-TOPIC-}</a>

";

if ($sitelogged[ugroup]==$frm[moderator_gr] and $sitelogged)

        $topic_frmt.="

                          <a href='?del={-ID-}'>Удалить</a> <a href='?topic=$topic&page=$page&edit={-ID-}'>Редактировать</a>

                   ";

        $topic_frmt.="

                        </td>

                        <td bgcolor=\"#F3F3F3\">

                                <table cellspacing=0 cellpadding=2 class=forum_info width=100%>

                                        <tr><td style=\"padding-left: 5px;\" width=50%>Автор</td><td  style=\"padding-right: 5px;\"  width=50%>{-AUTHOR-}</td></tr>

                                        <tr><td nowrap  style=\"padding-left: 5px;\" width=50%>Ответов</td><td nowrap  style=\"padding-right: 5px;\" width=50%>{-COUNT-}</td></tr>

                                        <tr><td nowrap  style=\"padding-left: 5px;\" width=50%>Последнее&nbsp;сообщение:&nbsp;</td><td nowrap  style=\"padding-right: 5px;\" width=50%>{-MAXDATE-}</td></tr>

                                </table>

                        </td>

                </tr>

        ";





if ($forum_name){



//        Подменяем URL в тексте на ссылки

           $text=strip_tags($text);

           $text=preg_replace("|(\S)([\.,\?\!;-])(\S)|si","\\1\\2 \\3",$text);

           while($text1!=$text){

                   if ($text1) $text=$text1;

                   $text1=preg_replace("|(\S{26,})|sie","substr('\\1',0,25).' '.substr('\\1',25)",$text);

                   }

                   $text=$text1;

        $text=preg_replace("|(http://\S+)|si","<a href=\\'\\1\\'>\\1</a>",$text);

//        Получаем инфу о форуме

      $frm=mysql_fetch_array(mysql_query("select * from engine_forum where name='$forum_name'"));

//        Обработка ответа

        if ($doreplay){

           $sql="insert into engine_forum_msg(`user`,`pid`,`topic`,`text`,`date`,`author`,`forum`)values('$user','$topic','$topic_','$text',NOW(),'$author','$frm[id]')";

           mysql_query($sql) or die(mysql_error());

           //пересылаем на страницу с добавленым сообщением

           list($cnt)=mysql_fetch_array(mysql_query("select count(id) from engine_forum_msg where pid=$topic"));

//           $cnt--;

           if (!mysql_error())

         echo "

         <script>

                 document.location='?topic=$topic&page=".($cnt-$cnt%$count)."';

         </script>

         ";

         else exit;

           }

        if ($donewtopic){

// Обработка добавления темы

           if (!$forum_doc_id)

                      $sql="insert into engine_forum_msg(user,pid,topic,text,date,author,forum)values('$user','-1','$topic_','$text',NOW(),'$author','$frm[id]')";

           else

                      $sql="insert into engine_forum_msg(doc,user,pid,topic,text,date,author,forum)values($forum_doc_id,'$user','-1','$topic_','$text',NOW(),'$author','$frm[id]')";

         mysql_query($sql);

           list($cnt)=mysql_fetch_array(mysql_query("select count(id) from engine_forum_msg where pid=-1 and forum=$frm[id]"));

           $cnt--;

         echo "

         <script>

                 document.location='?page=0';

         </script>

         ";

           }

//        Вывод списка тем

      if (!$topic){

      //обработка удаления темы

        if ($del and $sitelogged[ugroup]==$frm[moderator_gr] and $sitelogged){

                        $sql="delete from  engine_forum_msg

                        where forum=$frm[id] and id=$del";

                  mysql_query($sql);

                  //удаление ответов

                        $sql="delete from  engine_forum_msg

                        where pid=$del";

                  mysql_query($sql);

                  $topic="";



                }

// Обработка редактирования



        if ($edit and $sitelogged[ugroup]==$frm[moderator_gr] and $sitelogged){

                if (!$do){

                $sql="select * from engine_forum_msg where forum=$frm[id] and id=$edit";

                $tp=mysql_fetch_array(mysql_query($sql));

                $out=str_replace("{-NAME-}",str_replace('"','\\"',$tp[author]),$form_edit);

                $out=str_replace("{-TOPIC-}",str_replace('"','\\"',$tp[topic]),$out);

                echo $out=str_replace("{-TEXT-}",str_replace('"','\\"',$tp[text]),$out);

                }

              else {

                        $sql="update engine_forum_msg

                        set topic='$topic_',

                            text='$text',

                            author='$author'

                        where forum=$frm[id] and id=$edit";

                  mysql_query($sql);



                        }



                }

// Вывод формы создания темы

        if ($newtopic){

                      $out=str_replace("{-NAME-}",$sitelogged[login],$form_new);

                        echo str_replace("{-USER-}",$sitelogged[id],$out);

                        }



//  Вывод тем

    ?>

<table class=forum_tbl width="100%" cellspacing="1" cellpadding="0" border="0" bgcolor=#003664 >

        <tr align="center" class=forum_tr>

                <td colspan=2 align=center>

                        <table width=100% align=center cellspacing="2" cellpadding="2">

                                <td><a class=new_theam href="?newtopic=1">Новая тема</a></td>

                                <td align=right>

                                <?

//Получаем к-во тем в форуме

                        list($cnt)=mysql_fetch_array(mysql_query("select count(id) from engine_forum_msg where pid=-1 and forum=$frm[id] "));

                        $cnt--;

// Листалка

                                    echo "<a class=forum href=?page=0>Первая</a> <span class=forum_split>|</span> ";

                                    echo "<a class=forum href=?page=".($cnt-$cnt%$count).">Последняя</a> <br>";



                                if (($page-$page%($count*3)-$count*3)>=0)

                                            echo "<a href=?page=".($page-$page%$count-$count*3)."><<<</a> ";

                                for ($i=($page-$page%($count*3));$i<min($page-$page%($count*3)+3*$count,$cnt-$cnt%$count+$count);$i+=$count){

                                            if ($page!=$i)echo "<a class=forum href=?page=$i>".($i/$count+1)."</a> ";

                                            else echo "<b class=forum>".($i/$count+1)."</b> ";

                                        }

                                if (($page-$page%($count*3)+$count*3)<=$cnt)

                                            echo "<a class=forum href=?page=".($page-$page%$count+$count*3).">>>></a> ";

                                ?>

                                </td>

                        </table>

                <td>

        </tr>



        <tr class=forum_tbl_tr1>

                <th bgcolor=#0D5B8C class=forum_tbl_thRight width=80% nowrap="nowrap">Тема</th>

                <th bgcolor=#0D5B8C class=forum_tbl_thLeft height="26" width=20% nowrap="nowrap">Инфо</th>

        </tr>

        <?

// Выводим темы

        $sql="select * from engine_forum_msg where forum=$frm[id] and pid=-1 order by `date` desc limit $page,$count ";

      $r=mysql_query($sql);

      while($f=mysql_fetch_array($r)){

            list($cnt,$md)=mysql_fetch_array(mysql_query("select count(id),max(date) from engine_forum_msg where pid=$f[id]"));

                $out=dbparserow($f,$topic_frmt);

                $out=str_replace("{-MAXDATE-}",$md,$out);

                echo $out=str_replace("{-COUNT-}",$cnt,$out);

                }









      ?>

    </table>



    <?

        }

    else {

// Вывод отдельной темы

        if ($replay){

                // вывод формы ответа

                      $out=str_replace("{-NAME-}",$sitelogged[login],$form);

                        echo str_replace("{-USER-}",$sitelogged[id],$out);

                }

//обработка редактирования ответа

        if ($edit and $sitelogged[ugroup]==$frm[moderator_gr] and $sitelogged){

                if (!$do){

                $sql="select * from engine_forum_msg where forum=$frm[id] and id=$edit";

                $tp=mysql_fetch_array(mysql_query($sql));

                $out=str_replace("{-NAME-}",str_replace('"','\\"',$tp[author]),$form_edit);

                $out=str_replace("{-TOPIC-}",str_replace('"','\\"',$tp[topic]),$out);

                echo $out=str_replace("{-TEXT-}",str_replace('"','\\"',$tp[text]),$out);

                }

              else {

                        $sql="update engine_forum_msg

                        set topic='$topic_',

                            text='$text',

                            author='$author'

                        where forum=$frm[id] and id=$edit";

                  mysql_query($sql);



                        }



                }

//Обработка удаления ответа

        if ($del and $sitelogged[ugroup]==$frm[moderator_gr] and $sitelogged){

                $sql="select * from engine_forum_msg where forum='$frm[id]' and id='$del'";

            $r=mysql_query($sql);

            $tp=mysql_fetch_array($r);



                        $sql="delete from  engine_forum_msg

                        where forum=$frm[id] and id=$del";

                  mysql_query($sql);

                        $sql="delete from  engine_forum_msg

                        where pid=$del";

                  mysql_query($sql);

                if ($tp[pid]==-1)$topic="";



                }

?>

<table class=forum_tbl width="100%" cellspacing="1" cellpadding="3" border="0" bgcolor=#003664 >

        <tr align="right" class=forum_tr>

                <td class=forum_tbl_navtd  colspan="2" height="28">

                        <table width=100% align=left>

                                <td><a class=new_theam href="?newtopic=1">Новая тема</a>&nbsp;&nbsp;&nbsp;<a  class=new_theam href="?topic=<?=$topic?>&replay=1">Ответить</a></td>

                                <td align=right>

                                <?

                        list($cnt)=mysql_fetch_array(mysql_query("select count(id) from engine_forum_msg where pid=$topic"));

//                        $cnt--;



//листалка

                                    echo "<a class=forum href=?topic=$topic&page=0>Первая</a> <span class=forum_split>|</span> ";

                                    echo "<a class=forum href=?topic=$topic&page=".($cnt-$cnt%$count).">Последняя</a> <br>";



                                if (($page-$page%($count*3)-$count*3)>=0)

                                            echo "<a  class=forum href=?topic=$topic&page=".($page-$page%($count*3)-$count*3)."><<<</a> ";

                                for ($i=($page-$page%($count*3));$i<min($page-$page%($count*3)+3*$count,$cnt-$cnt%$count+$count);$i+=$count){



                                            if ($page!=$i)echo "<a href=?topic=$topic&page=$i>".($i/$count+1)."</a> ";

                                            else echo "<b class=forum>".($i/$count+1)."</b> ";

                                        }

                                if (($page-$page%($count*3)+$count*3)<=$cnt)

                                            echo "<a class=forum href=?topic=$topic&page=".($page-$page%(3*$count)+$count*3).">>>></a> ";

                                ?>

                                </td>

                        </table>

              </td>

        </tr>



        <tr class=forum_tbl_tr1>

                <th bgcolor=#006699 class=forum_tbl_thLeft height="26" nowrap="nowrap">Автор</th>

                <th bgcolor=#006699 class=forum_tbl_thRight width=60% nowrap="nowrap">Сообщение</th>

        </tr>

<?



//вывод ответов



        $sql="select * from engine_forum_msg where forum=$frm[id] and pid=$topic or id=$topic order by `date`  limit $page,$count";

          echo dbparse($sql,$answer1,$answer2);



      ?>

    </table>



    <?



        }

    }



?>
