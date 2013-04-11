<?php
/*
 *  $Id: view.php,v 1.20 2006/10/18 11:46:56 ereih Exp $
 *
 *  $Log: view.php,v $
 *  Revision 1.20  2006/10/18 11:46:56  ereih
 *  *** empty log message ***
 *
 *  Revision 1.19  2006/10/18 09:51:28  ereih
 *  Изменение времени ожидания редактирования документа и правка внешнего вида информации.
 *
 *  Revision 1.18  2006/06/15 10:02:28  ereih
 *  Редизайн и улучшение функционала
 *
 *  Revision 1.16  2005/05/20 15:26:39  aavakyan
 *  Добавлен вывод кода и шаблона документа (вверху, в постоянном заголовке)
 *
 *  Revision 1.15  2005/02/01 22:17:36  dave
 *  Пустой пароль отображается как *****
 *
 *  Revision 1.14  2005/01/26 00:28:28  dave
 *  Исправлена ошибка неверного вывода формы управления рассылками
 *
 *  Revision 1.13  2005/01/23 23:13:08  dave
 *  Корректная поддержка 20-байтных хешей MD5
 *
 *  Revision 1.12  2005/01/11 18:47:27  dave
 *  Убран модификатор 'u' в регулярных выражениях
 *
 *  Revision 1.11  2005/01/10 17:54:26  dave
 *  1. пароли в MD5
 *  2. убраны ссылки на картинку со "звездой"
 *
 *  Revision 1.10  2004/12/26 11:47:28  dave
 *  Переформатирование кода
 *
 *  Revision 1.9  2004/12/19 22:52:39  dave
 *  Оптимизация запросов к БД -- избавление от лишних OUTER JOIN
 *
 *  Revision 1.8  2004/12/16 22:14:55  dave
 *  Оптимизация запросов к БД, избавление от ненужных OUTER JOIN'ов
 *
 *
 */
ini_set('session.cache_expire','480');
@session_start();
@session_register("time");
if ($_GET[session_time]) $time = $_GET[session_time];
if ((!$time || (time() - $time > 60*4*60))){
	//превысили время
	echo "<script>alert('Время вашей сессии истекло')</script>";
	echo "<script>window.parent.parent.document.location=\"/engine/engine.php?logout=1%26err=2\";</script>";
       exit();
}


/*header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");    // Date in the past
header ("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
                                                      // always modified
header ("Cache-Control: no-cache, must-revalidate");  // HTTP/1.1
header ("Pragma: no-cache");                          // HTTP/1.0
*/
function get_rubdocs($id)
{
        global $dcs, $docarr, $topid, $path;
        if (!$topid)$topid = $id;
        $i = @count($docarr);
        $sql = "select * from engine_rubrique where id=$id";
        $f = mysql_fetch_array(mysql_query($sql));
        $path .= "<a  class=wnd href=?action=rubrique&id=$id>$f[name]</a> / ";
        $sql = "select * from engine_docsinrubriques where rub=$id and `in`=1";
        $r = mysql_query($sql);
        while ($f = mysql_fetch_array($r)) {
                $d = new Document($f[doc]);
                if (!@in_array($d->id, $docarr)) {
                        $name = $d->name;
                        if ($d->type == 'CATALOGITEM')
                                $name = $d->spec[caption];
                        if ($d->type == 'NEW')
                                $name = "Новость '" . $d->spec[header] . "'";
                        $dcs[$i] = "<tr ><td>$path<a class=wnd href='?action=showdoc&id={$d->id}'>$name</a></td><td><a style='color:red' href='?action=rubrique&id=$topid&del={$d->id}&rub=$id'>Удалить</a></td></tr>";
                        $docarr[$i++] = $d->id;
                }
        }
        $sql = "select * from engine_rubrique where pid=$id";
        $r = mysql_query($sql);
        while ($f = mysql_fetch_array($r)) {
                get_rubdocs($f[id]);
        }
        if (is_array($dcs)) {
                sort($dcs);
                $color[0] = "style='background-color:#c1c1ff'";
                $color[1] = "style='background-color:#9999ff'";
                foreach ($dcs as $d) {
                        $dcts .= str_replace("<tr >", "<tr " . ($color[((++$c) % 2)]) . ">", $d);
                }
        }
        return "<table width=100% cellspacing=1 class=wnd><tr><td class=header>документ</td><td class=header>Удалить</td></tr>$dcts</table>";
}

ob_start();

?>
<!--
<BODY bgproperties="fixed" background="img/fon.jpg" style="background-repeat:  repeat-x;" contentEditable=false unselectable >
<LINK href="style.css" rel="stylesheet" type="text/css">
<script>
function resz(){
}
window.onresize=resz;
resz();

</script>
-->

<?php

include("FastTemplate.php");
include("config.inc");

//проверка что соединение есть
$sql = "select * from engine_documents limit 1";
if (!$news_r = mysql_query($sql)){
	echo "<script>alert('Время вашей сессии истекло')</script>";
	echo "<script>window.parent.parent.document.location=\"/engine/engine.php?logout=1%26err=2\";</script>";
       exit();
}


$sql = "select * from engine_groups where id=$logged[ugroup]";
$r = mysql_query($sql) or die("SQL error " . mysql_error() . " in: $sql\n");
$grp = mysql_fetch_array($r);

if ($action == 'showdoc' and $id > 0) {
        $sql = "update  engine_documents  set opened=0 where id!=$id and opener=$logged[id]";
        mysql_query("$sql");
} else {
        $sql = "update  engine_documents  set opened=0 where opener=$logged[id]";
        mysql_query("$sql");
}

$tpl = new FastTemplate("./");
/*

echo "<SCRIPT LANGUAGE=\"JavaScript\">
<!--
var menu=window.parent.menu;

//-->
</SCRIPT>
";
*/
if ($action == 'message') {
        echo $mess;
}
if ($action == 'rubrique') {
        if ($del) {
                $sql = "update engine_docsinrubriques set `in`='0' where rub=$rub and doc=$del";
                mysql_query($sql) or die("SQL error " . mysql_error() . " in: $sql\n");
        }

        if (!$do and $id > 0) {
                if ($id) {
                        include $engine_root . '/engine/link_tree.php';

                        $tpl->define(
                                array(
                                        main => "tpl/rubrique.tpl"
                                        )
                                );
                        $sql = "select * from engine_documents where code!=''";
                        $r = mysql_query ($sql);
                        $sp = "var count=" . mysql_num_rows($r) . ";\n";
                        $sp .= "var codes=new Array(" . mysql_num_rows($r) . ");\n";
                        $sp .= "var ids=new Array(" . mysql_num_rows($r) . ");\n";
                        $sp .= "var durl='/show.php?doc=';\n";
                        $k = 0;
                        while ($f = mysql_fetch_array($r)) {
                                $sp .= "ids[$k]=" . $f[id] . ";\n";
                                $sp .= "codes[$k]='" . $f[code] . "';\n";
                                $k++;
                        }

                        $sql = "select * from engine_rubrique where id=$id";
                        $f = mysql_fetch_array(mysql_query($sql));

                        $tpl->assign(
                                array(
                                        ID => $f[id],
                                        NAME => $f[name],
                                        RUBDOCS => get_rubdocs($id),
                                        TREE => $tree,
                                        SCRIPTPART => $sp,
                                        '{engine_htroot}' => $engine_htroot

                                        )
                                );
                        $tpl->parse(MAIN, array("main"));
                        $tpl->FastPrint();
                }
        } elseif ($do == 1) {
                if ($code) {
                        $d = new Document($code);
                        if (mysql_num_rows(mysql_query("select `in` from engine_docsinrubriques  where rub=$id and doc={$d->id}")))
                                $sql = "update engine_docsinrubriques set `in`=1 where rub=$id and doc={$d->id}";
                        else
                                $sql = "insert into engine_docsinrubriques(rub,doc,`in`) values($id,{$d->id},1)";

                        mysql_query($sql) or die("SQL error " . mysql_error() . " in: $sql\n");
                }

                $sql = "update engine_rubrique set name='$name' where id=$id";
                mysql_query($sql) or die("SQL error " . mysql_error() . " in: $sql\n");
                if (!mysql_error())
                        echo "
                                <SCRIPT LANGUAGE='JavaScript'>
                                <!--
                                document.location='view.php?action=$action&id=$id';
                                menu.document.location='menu.php?action=$action';

                                //-->
                                </SCRIPT>
                                ";
        }
}
if ($action == 'showdoc')
{
        if ($id > 0)
        {
	 if ($logged[role] == "Администратор" && $_POST[delink] == 1){
		//отвязываем пользователя, считаем что он привязан
              $sql = "update  engine_documents  set opened=0,opener='' , lastopen='' where id= $id";
              mysql_query("$sql");
	 }

                $sql = "SELECT opened, opener,date_format(lastopen,'%Y-%m-%d %H:%i')  lastopen , u.login ologin,date_format(NOW( ),'%Y-%m-%d %H:%i')  now
FROM engine_documents, engine_users u WHERE u.id = engine_documents.opener
AND engine_documents.id = $id";

                list($opened, $opener, $lastopen, $ologin, $now) = mysql_fetch_array(mysql_query("$sql"));
                if ((!$opened or strtotime($lastopen.'+ 30 minutes') < strtotime($now)) or ($opener == $logged['id']))
                {
                        $sql = "update  engine_documents  set opened=1,opener=$logged[id],lastopen=NOW() where id=$id";
                        mysql_query("$sql");
                        include 'document.php';
                }
                else
                {
                	?>
<!DOCTYPE html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
  <link href="main.css" rel="stylesheet" type="text/css">
  <title>Ошибка доступа к документу</title>
</head>
<body>
<table cellspacing="0" cellpadding="0" width="100%" height="70%" align="center" border="0">
  <tr>
    <td width="100%" valign="middle" align=center >
      <table width="350" cellspacing="1" cellpadding="3" class="line">
        <tr><th class="error">Ошибка доступа</th></tr>
        <tr><td align="center" style="height: 60px;">Документ не доступен, так как пользователь <b><?=$ologin?></b> редактирует его с <b><?=date('H:i',strtotime($lastopen))?></b>.
<?
	if ($logged[role] == "Администратор"){
?><br><br>
<form name="form1" method="POST" action="">
  <input type="hidden" name="id" value="<? echo $id;?>">
  <input type="hidden" name="delink" value="1">
  Отвязать? <input type="submit" name="Submit" value="Да">
</form>
		
<?
	}
?>
</td></tr>
      </table>
    </td>
  </tr>
</table>
</body>
</html>
                        <?php
                        exit;
                }
        } else {

                $sql = "select * from engine_conf";
                $cr = mysql_query($sql) or die (mysql_error() . " in $sql");
                $c = 0;
                while ($conf = mysql_fetch_array($cr)) {
                        $$conf[varname] = $conf[varvalue];
                }

                /*
                echo "
                        <script>
                                if (window.parent.topp.document.all.doc_date!=null) {
                                window.parent.topp.document.all.doc_date.innerHTML='';
                                window.parent.topp.document.all.doc_id.innerHTML='';
                                window.parent.topp.document.all.doc_templ.innerHTML='';
                                window.parent.topp.document.all.doc_type.innerHTML='';
                                window.parent.topp.document.all.cur_code.innerHTML='';
                                }
                        </script>
                        ";
                */
                if (!$do) {
   		/*echo "<pre>";
   		print_r($_SESSION);	   
   		echo "</pre>";*/
                        $sql = "select * from engine_documents where pid=-1 order by ord,name";
                        $dor_r = mysql_query($sql) or die (mysql_error() . " in $sql");
                        $dor = "";

                        $n_rows = mysql_num_rows($dor_r);
                        while ($dor_f = mysql_fetch_array($dor_r)) {
                                $i++;
                                $dor .= "
                                                <tr id=tr$i>
                                                <td width=90% class=top>$dor_f[name]</td>
                                                <td align=right><input type=hidden name=ord$dor_f[id] id=ordtr$i value='$i'>
                                                <td><a id=uptr$i href='javascript:doup($i);'";
                                if ($i == 1)$dor .= "style='display:none;'";
                                $dor .= "><img border=0 src=doc_types/FORM/img/up.gif></a></td>
                                                <td><a id=downtr$i href='javascript:dodown($i);' ";
                                if ($i == ($n_rows))$dor .= "style='display:none;'";
                                $dor .= "><img border=0 src=doc_types/FORM/img/down.gif></a></td>
                                                </tr>";
                        }

                        $config .= "
                        <TABLE>
                                <TR><TD class=top>- Документ по умолчанию (главная страница) </TD></TR>
                                <TR><TD class=top><select name=bd_defdoc value=" . $defdoc . ">";
                        $sql = "select * from engine_documents where type!='NEW' and type!='CATALOGITEM'";
                        $r = mysql_query($sql) or die (mysql_error() . " in $sql");
                        $config .= "<option value=-1>-------------------</option>";
                        while ($f = mysql_fetch_array($r)) {
                                if ($f[id] == $defdoc)
                                        $config .= "<option value=$f[id] selected>$f[name]($f[id])</option>";
                                else
                                        $config .= "<option value=$f[id]>$f[name]($f[id])</option>";
                        }

                        $config .= "</select></TD></TR>
                                <TR><TD class=top>- Документ ненайденой страницы (404 ошибка) </TD></TR>
                                <TR><TD class=top><select name=bd_doc404 value=" . $doc404 . ">";
                        $sql = "select * from engine_documents where type!='NEW' and type!='CATALOGITEM'";
                        $r = mysql_query($sql) or die (mysql_error() . " in $sql");
                        $config .= "<option value=-1>-------------------</option>";
                        while ($f = mysql_fetch_array($r)) {
                                if ($f[id] == $doc404)
                                        $config .= "<option value=$f[id] selected>$f[name]($f[id])</option>";
                                else
                                        $config .= "<option value=$f[id]>$f[name]($f[id])</option>";
                        }

                        $config .= "
                                </select></TD></TR>
                                <TR><TD class=top>- Шаблон по умолчанию </TD></TR>
                                <TR><TD class=top><select name=bd_deftpl value=" . $deftpl . ">";
                        $sql = "select * from engine_tpl";
                        $r = mysql_query($sql) or die (mysql_error() . " in $sql");
                        $config .= "<option value=-1>-------------------</option>";
                        while ($f = mysql_fetch_array($r)) {
                                if ($f[id] == $deftpl)
                                        $config .= "<option value=$f[id] selected>$f[name]($f[id])</option>";
                                else
                                        $config .= "<option value=$f[id]>$f[name]($f[id])</option>";
                        }
                        $config .= "
                                </select></TD></TR>
                                <TR><TD class=top>- Шаблон поиска </TD></TR>
                                <TR><TD class=top><select name=bd_searchtpl value=" . $searchtpl . ">";
                        $sql = "select * from engine_tpl";
                        $r = mysql_query($sql) or die (mysql_error() . " in $sql");
                        $config .= "<option value=-1>-------------------</option>";
                        while ($f = mysql_fetch_array($r)) {
                                if ($f[id] == $searchtpl)
                                        $config .= "<option value=$f[id] selected>$f[name]($f[id])</option>";
                                else
                                        $config .= "<option value=$f[id]>$f[name]($f[id])</option>";
                        }
                        $config .= "
                                </select></TD></TR>
                                <TR><TD class=top>- Скрывать недоступные пользователю документы в меню </TD></TR>
                                <TR><TD class=top><input type=checkbox name=hideprivatedocs ";
                        if ($hide_private_docs)$config .= " checked ";
                        $config .= "></TD></TR>
                                <TR><TD class=top>- Код счетчика 1 </TD></TR>
                                <TR><TD class=top><textarea name=bd_def_counter1 class=header2 >" . $def_counter1 . "</textarea></TD></TR>
                                <TR><TD class=top>- Код счетчика 2 </TD></TR>
                                <TR><TD class=top><textarea name=bd_def_counter2 class=header2 >" . $def_counter2 . "</textarea></TD></TR>
                                <TR><TD class=top>- Код счетчика 3 </TD></TR>
                                <TR><TD class=top><textarea name=bd_def_counter3 class=header2 >" . $def_counter3 . "</textarea></TD></TR>
                                <TR><TD class=top>- META по умолчанию  </TD></TR>
                                <TR><TD class=top><textarea name=bd_def_meta class=header2 >" . $def_meta . "</textarea></TD></TR>
                                <TR><TD class=top>- TITLE по умолчанию  </TD></TR>
                                <TR><TD class=top><input name=bd_def_title type=text value='" . str_replace("'", "\\'", $def_title) . "'></TD></TR>
                                <TR><TD class=top>- Формат меню по умолчанию</TD></TR>
                                <TR><TD class=top><textarea name=bd_dflt_menu_format class=header2>" . htmlspecialchars($dflt_menu_format) . "</textarea></TD></TR>
                                <TR><TD class=top>- Группа, в которую попадают пользователи после регистрации  </TD></TR>
                                <TR><TD class=top><select style='width:300' name=bd_regform_group value=" . $regform_group . ">";
                        $sql = "select * from engine_groups where name!='belti'";
                        $r = mysql_query($sql) or die (mysql_error() . " in $sql");
                        $config .= "<option value=-1>----------------------------------------------------------------------------</option>";
                        while ($f = mysql_fetch_array($r)) {
                                if ($f[id] == $regform_group)
                                        $config .= "<option value=$f[id] selected>$f[name]($f[id])</option>";
                                else
                                        $config .= "<option value=$f[id]>$f[name]($f[id])</option>";
                        }
                        $config .= "</select></TD></TR>
                                <TR><TD class=top>- Заголовок письма , отправляемого регистрационной формой </TD></TR>
                                <TR><TD class=top><textarea name=bd_top_add class=header2 >" . $top_add . "</textarea></TD></TR>
                                <TR><TD class=top>- Email для заказов  </TD></TR>
                                <TR><TD class=top><input name=shopemail type=text value='" . $shop_email . "'></TD></TR>
                                <TR><TD class=top>- Форма заказа  </TD></TR>
                                <TR><TD class=top><textarea name=buyform class=header2 >" . $buy_form . "</textarea></TD></TR>
                                <TR><TD class=top>- HTML Перед регистрационной формой </TD></TR>
                                <TR><TD class=top><textarea name=bd_regform_prefix class=header2 >" . htmlspecialchars($regform_prefix) . "</textarea></TD></TR>
                                <TR><TD class=top>- HTML После регистрационной формы </TD></TR>
                                <TR><TD class=top><textarea name=bd_regform_postfix class=header2 >" . htmlspecialchars($regform_postfix) . "</textarea></TD></TR>
                                <TR><TD class=top>- HTML Формы логина формы </TD></TR>
                                <TR><TD class=top><textarea name=loginhtml class=header2 >" . htmlspecialchars($login_html) . "</textarea></TD></TR>
                                <TR><TD class=top>- HTML Сообщение для залогиненых пользователей </TD></TR>
                                <TR><TD class=top><textarea name=loggedinfo class=header2 >" . htmlspecialchars($logged_info) . "</textarea></TD></TR>

                        </TABLE>";

                        $dor = "
                                <link rel=stylesheet href='style.css' type='text/css' title='CSS style'>
                                <form method=post>
                                        <input type=hidden name=do value=1>
                                        <input type=hidden name=do value=1>
                                        <input type=hidden name=tree value=1>
                                        <table width=100%>
                                                <tr><td class=top>- Порядок отображения разделов в корневом  меню<br><br></td></tr>
                                                <tr><td>
                                                <table width=100%><tbody id=doc_ord>" . $dor . "</tbody></table>
                                                </td></tr>
                                                <tr><td>$config
</td></tr>
                                                <tr><td align=center>
                                                <input type=submit class=but2         value='  Применить   '>
                                                </td></tr>
                                        </table>

                                        </form>";
                        echo $dor;

                        ?>
<script>
function shupdown(){
        for (i=0;i<document.all.doc_ord.childNodes.length;i++){
                var tr=document.all.doc_ord.childNodes[i];
                var up=eval("document.all.up"+tr.id);
                var down=eval("document.all.down"+tr.id);
                if (i==0){
                        up.style.display='none';
                        down.style.display='';
                        }
                else{
                        if(i== (document.all.doc_ord.childNodes.length-1)){
                                up.style.display='';
                                down.style.display='none';
                                }
                        else {
                                up.style.display='';
                                down.style.display='';
                                }
                        }
                }
        }

function doup(n){
        var tr=eval("document.all.tr"+n),i=0;
        while(document.all.doc_ord.childNodes[i]!=tr){
                i++;
                }
        if (i>0) {
                var ntr=document.all.doc_ord.childNodes[i-1];
                ntr.insertAdjacentElement("beforeBegin",  tr );
                var ord1=eval("document.all.ord"+tr.id);
                var ord2=eval("document.all.ord"+ntr.id);
                var buf_ord=ord1.value;
                ord1.value=ord2.value;
                ord2.value=buf_ord;
                }
        shupdown();
        }
function dodown(n){
        var tr=eval("document.all.tr"+n),i=0;
        while(document.all.doc_ord.childNodes[i]!=tr){
                i++;
                }
        if (i<document.all.doc_ord.childNodes.length-1) {
                var ntr=document.all.doc_ord.childNodes[i+1];
                ntr.insertAdjacentElement("afterEnd",  tr );
                var ord1=eval("document.all.ord"+tr.id);
                var ord2=eval("document.all.ord"+ntr.id);
                var buf_ord=ord1.value;
                ord1.value=ord2.value;
                ord2.value=buf_ord;
                }
        shupdown();

        }


</script>

<?php
                } else {
                        // редактируем конфиг
                        $sql = "select * from engine_conf";
                        $cr = mysql_query($sql) or die (mysql_error() . " in $sql");
                        $c = 0;
                        while ($conf = mysql_fetch_array($cr)) {
                                $cfg[$c++] = $conf[varname];
                        }
			if ($_POST[tree] == 1){
                        if (in_array("defdoc", $cfg)) {
                                mysql_query("update engine_conf set varvalue='$bd_defdoc' where varname='defdoc'");
                        } else {
                                mysql_query("insert into  engine_conf ( varvalue,varname) values('$bd_defdoc', 'defdoc')");
                        }
                        if (in_array("doc404", $cfg)) {
                                mysql_query("update engine_conf set varvalue='$bd_doc404' where varname='doc404'");
                        } else {
                                mysql_query("insert into engine_conf (varvalue, varname) values('$bd_doc404', 'doc404')");
                        }
                        if (in_array("deftpl", $cfg)) {
                                mysql_query("update engine_conf set varvalue='$bd_deftpl' where varname='deftpl'");
                        } else {
                                mysql_query("insert into  engine_conf ( varvalue,varname) values('$bd_deftpl', 'deftpl')");
                        }
                        if (in_array("searchtpl", $cfg)) {
                                mysql_query("update engine_conf set varvalue='$bd_searchtpl' where varname='searchtpl'");
                        } else {
                                mysql_query("insert into  engine_conf ( varvalue,varname) values('$bd_searchtpl', 'searchtpl')");
                        }
                        if (in_array("def_counter1", $cfg)) {
				    if ($bd_def_counter1)
                                mysql_query("update engine_conf set varvalue='$bd_def_counter1' where varname='def_counter1'");
                        } else {
                                mysql_query("insert into  engine_conf ( varvalue,varname) values('$bd_def_counter1', 'def_counter1')");
                        }
                        if (in_array("def_counter2", $cfg)) {
				    if ($bd_def_counter2)
                                mysql_query("update engine_conf set varvalue='$bd_def_counter2' where varname='def_counter2'");
                        } else {
                                mysql_query("insert into  engine_conf ( varvalue,varname) values('$bd_def_counter2)', 'def_counter2')");
                        }
                        if (in_array("def_counter3", $cfg)) {
				    if ($bd_def_counter3)
                                mysql_query("update engine_conf set varvalue='$bd_def_counter3' where varname='def_counter3'");
                        } else {
                                mysql_query("insert into  engine_conf ( varvalue,varname) values('$bd_def_counter3)', 'def_counter3')");
                        }
                        if (in_array("def_title", $cfg)) {
                                mysql_query("update engine_conf set varvalue='$bd_def_title' where varname='def_title'");
                        } else {
                                mysql_query("insert into  engine_conf ( varvalue,varname) values('$bd_def_title)', 'def_title')");
                        }
                        if (in_array("def_meta", $cfg)) {
                                mysql_query("update engine_conf set varvalue='$bd_def_meta' where varname='def_meta'");
                        } else {
                                mysql_query("insert into  engine_conf ( varvalue,varname) values('$bd_def_meta', 'def_meta')");
                        }
                        if (in_array("dflt_menu_format", $cfg)) {
                                mysql_query("update engine_conf set varvalue='$bd_dflt_menu_format' where varname='dflt_menu_format'");
                        } else {
                                mysql_query("insert into  engine_conf ( varvalue,varname) values('$bd_dflt_menu_format', 'dflt_menu_format')");;
                        }
                        if (in_array("regform_group", $cfg)) {
                                mysql_query("update engine_conf set varvalue='$bd_regform_group' where varname='regform_group'");
                        } else {
                                mysql_query("insert into  engine_conf ( varvalue,varname) values('$bd_regform_group', 'regform_group')");
                        }
                        if (in_array("top_add", $cfg)) {
                                mysql_query("update engine_conf set varvalue='$bd_top_add' where varname='top_add'");
                        } else {
                                mysql_query("insert into  engine_conf ( varvalue,varname) values('$bd_top_add', 'top_add')");
                        }
                        if (in_array("regform_prefix", $cfg)) {
                                mysql_query("update engine_conf set varvalue='$bd_regform_prefix' where varname='regform_prefix'");
                        } else {
                                mysql_query("insert into  engine_conf ( varvalue,varname) values('$bd_regform_prefix', 'regform_prefix')");
                        }
                        if (in_array("regform_postfix", $cfg)) {
                                mysql_query("update engine_conf set varvalue='$bd_regform_postfix' where varname='regform_postfix'");
                        } else {
                                mysql_query("insert into  engine_conf ( varvalue,varname) values('$bd_regform_postfix', 'regform_postfix')");
                        }

                        $hideprivatedocs?$hideprivatedocs = 1:$hideprivatedocs = 0;
                        if (in_array("hide_private_docs", $cfg)) {
                                mysql_query("update engine_conf set varvalue='$hideprivatedocs' where varname='hide_private_docs'");
                        } else {
                                mysql_query("insert into  engine_conf ( varvalue,varname) values('$hideprivatedocs', 'hide_private_docs')") or die(mysql_error());
                        }
                        if (in_array("buy_form", $cfg)) {
                                mysql_query("update engine_conf set varvalue='$buyform' where varname='buy_form'");
                        } else {
                                mysql_query("insert into  engine_conf ( varvalue,varname) values('$buyform', 'buy_form')") or die(mysql_error());
                        }
                        if (in_array("shop_email", $cfg)) {
                                mysql_query("update engine_conf set varvalue='$shopemail' where varname='shop_email'");
                        } else {
                                mysql_query("insert into  engine_conf ( varvalue,varname) values('$shopemail', 'shop_email')") or die(mysql_error());
                        }
                        if (in_array("login_html", $cfg)) {
                                mysql_query("update engine_conf set varvalue='$loginhtml' where varname='login_html'");
                        } else {
                                mysql_query("insert into  engine_conf ( varvalue,varname) values('$loginhtml', 'login_html')") or die(mysql_error());
                        }
                        if (in_array("logged_info", $cfg)) {
                                mysql_query("update engine_conf set varvalue='$loggedinfo' where varname='logged_info'");
                        } else {
                                mysql_query("insert into  engine_conf ( varvalue,varname) values('$loggedinfo', 'logged_info')") or die(mysql_error());
                        }

                        $sql = "select * from engine_documents where pid=-1 ";
                        $dor_r = mysql_query($sql) or die (mysql_error() . " in $sql");
                        $dor = "";
                        while ($dor_f = mysql_fetch_array($dor_r)) {
                                if (!${"ord".$dor_f[id]}) ${"ord".$dor_f[id]} = 0;
                                mysql_query("update engine_documents set ord=" . ${"ord".$dor_f[id]} . " where id=$dor_f[id] ");
                        }
			}
		$link = "view.php?action=showdoc&id=-1";
		echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0; URL=".$link."\">";
                        ?><!--<script>document.location='view.php?action=showdoc&id=-1';</script>--><?php

                }
        }
}
if ($action == 'tpl')
{
        $tpl_id = $_REQUEST['id'];
        $action = $_REQUEST['do'];
        if ($action != 1)
        {
                if ($tpl_id)
                {
                        $tpl->define(array(
                                            main => "tpl/tpl.tpl"
                                          )
                                     );

                        $sql = 'SELECT *
                                FROM engine_tpl
                                WHERE id='.$tpl_id;

                        $result = mysql_query($sql);
                        $row = mysql_fetch_array($result);
                        $tpl->assign(array(
                                           '{tpl_id}'   => $row[id],
                                           '{tpl_body}' => htmlspecialchars($row['body']),
                                           '{tpl_name}' => htmlspecialchars($row['name'])
                                          )
                                     );
                        $tpl->parse(MAIN, array("main"));
                        $tpl->FastPrint();
                }
        }
        else
        {
                if (!get_magic_quotes_gpc())
                {
                        $tpl_name = $_REQUEST['name'];
                        $tpl_body = $_REQUEST['body'];
                }
                else
                {
                        $tpl_name = stripslashes($_REQUEST['name']);
                        $tpl_body = stripslashes($_REQUEST['body']);
                }


                $sql = 'UPDATE engine_tpl
                           SET name="'.mysql_real_escape_string($tpl_name).'",
                               body="'.mysql_real_escape_string($tpl_body).'"
                         WHERE id='.$tpl_id;

                if (!($result = mysql_query($sql)))
                {
                        die("SQL error " . mysql_error() . " in: $sql\n");
                }
                else
                {
                        echo "
                                <SCRIPT LANGUAGE='JavaScript'>
                                <!--
                                document.location='view.php?action=tpl&id=$tpl_id';
                                menu.document.location='menu.php?action=tpl';
                                //-->
                                </SCRIPT>
                                ";
                }

                $text = 'Изменение шаблона \''.$tpl_name.'\'';
                $sql = 'INSERT INTO engine_log (log_date, user, text, document)
                                        VALUES (NOW(), '.$logged['id'].', "'.mysql_real_escape_string($text).'", -'.$tpl_id.');';

                if (!($result = mysql_query($sql)))
                {
                        die("SQL error " . mysql_error() . " in: $sql\n");
                }
        }
}

if ($action == 'style')
{
        if (!$do) {
                if ($id) {
                        $tpl->define(
                                array(
                                        main => "tpl/style.tpl"
                                        )
                                );
                        $sql = "select * from engine_styles where id=$id";
                        $f = mysql_fetch_array(mysql_query($sql));
                        $tpl->assign(
                                array(
                                        ID => $f[id],
                                        NAME => $f[name]
                                        )
                                );
                        $tpl->parse(MAIN, array("main"));
                        $tpl->FastPrint();
                }
        } elseif ($do == 1) {
                global $filename_name;
                $sql = "update engine_styles set name='$name' where id=$id";
                mysql_query($sql) or die("SQL error " . mysql_error() . " in: $sql\n");
                if ($filename) {
                        $fn = explode(".", $filename_name);
                        $ext = $fn[count($fn)-1];
                        if ($ext != "css") {
                                echo '
                                        <TABLE cellspacing="0" cellpadding="0" width=100% height=60% align=center border="0"  >
                                                <TR>
                                                        <TD width=100% valign="middle" align=center >
                                                                <TABLE width=350 height=100 cellspacing="0" cellpadding="10"          bgcolor="F6F6F6"  style="border:1 solid ">
                                                                        <TR  >
                                                                                <TD align=center>
                                                                                        Файл не является таблицей стилей.<br>
                                                                                        <a href="view.php?action=style&id=' . $id . '">Вернуться</a>

                                                                                </TD>
                                                                        </TR>
                                                                </TABLE>
                                                        </TD>
                                                </TR>
                                        </TABLE>
                                ';
                                exit;
                        } else {
                                unlink ("$engine_show_root/engine/styles/style" . $id . ".css");
                                copy ($filename, "$engine_show_root/engine/styles/style" . $id . ".css");
                                chmod("$engine_show_root/engine/styles/style" . $id . ".css", 0777);
                        }
                }

                if (!mysql_error())
                        echo "
                                <SCRIPT LANGUAGE='JavaScript'>
                                <!--
                                document.location='view.php?action=$action&id=$id';
                                menu.document.location='menu.php?action=$action';

                                //-->
                                </SCRIPT>
                                ";
        }
}

if ($action == 'showgroup')
{
	if ($usrid)
	{
		$sql = 'SELECT *
		        FROM engine_users
		        WHERE id = '.$usrid;

		if (!$result = mysql_query($sql))
		{			die (mysql_error());
		}

		$user = mysql_fetch_array($result, MYSQL_ASSOC);
		$ltr = substr($user['login'], 0, 1);
		$user_id = $user['id'];
		$id = $user['ugroup'];
        }

	if (($userid) && ($userid != -1))
	{
		if (!$del)
		{
			if (isset($_POST['active']))
			{				$active = 1;
			}
			else
			{				$active = 0;
			}

			$sql = 'UPDATE engine_users
				   SET login = "'.mysql_real_escape_string($userlogin).'", ';
			if ($userpass != '*****')
			{				$sql .= 'pass = "'.md5(trim($userpass)).'", ';
			}

			$sql .= 'name="'.mysql_real_escape_string($username).'",
                                 mname = "'.mysql_real_escape_string($usermname).'",
                                 lname = "'.mysql_real_escape_string($userlname).'",
                                 phone = "'.mysql_real_escape_string($userphone).'",
                                 firm = "'.mysql_real_escape_string($userfirm).'",
                                 email = "'.mysql_real_escape_string($useremail).'",
                                 info = "'.mysql_real_escape_string($userinfo).'",
                                 role = "'.mysql_real_escape_string($role).'",
                                 ugroup = "'.mysql_real_escape_string($group).'",
                                 active = "'.$active.'"
                                 WHERE id='.$userid;
			//echo $sql;
		}
		else
                {
			$sql = 'DELETE FROM engine_users
			        WHERE id = '.$userid;
		}

		if (!$result = mysql_query($sql))
		{			die (mysql_error().' '.$sql);
		}

		if (!$del)
		{
			echo "<script>document.location='view.php?action=showgroup&usrid=$userid&id=$groupid';</script>";
		}
		else
		{			echo "<script>document.location='view.php?action=showgroup&id=$groupid';</script>";
		}

		exit;
	}

	if ($userid)
	{		$sql = 'SELECT *
		        FROM engine_users
		        WHERE login="'.mysql_real_escape_string($userlogin).'"';

		if (!$result = mysql_query($sql))
		{			die($sql);
		}

		if (mysql_num_rows($result) > 0)
		{
?>
<!DOCTYPE html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
  <link href="main.css" rel="stylesheet" type="text/css">
  <title>Ошибка создания пользователя</title>
</head>
<body>
<table cellspacing="0" cellpadding="0" width="100%" height="70%" align="center" border="0">
  <tr>
    <td width="100%" valign="middle" align=center >
      <table width="350" cellspacing="1" cellpadding="3" class="line">
        <tr><th class="error">Ошибка</th></tr>
        <tr><td align="center" style="height: 60px;">Пользователь с логином <b><?=$userlogin?></b><br />уже зарегестрирован.</td></tr>
      </table>
    </td>
  </tr>
</table>
</body>
</html>
<?php
		}
		else
		{			if (isset($_POST['active']))
			{				$active = 1;
			}
			else
			{				$active = 0;
			}

			$sql = 'INSERT INTO engine_users (active, role, login, pass, name, mname, lname, phone, firm, email, info, ugroup)
			                          VALUES ("'.$active.'","'.$role.'","'.$userlogin.'","'.md5(trim($userpass)).'","'.$username.'","'.$usermname.'","'.$userlname.'","'.$userphone.'","'.$userfirm.'","'.$useremail.'","'.$userinfo.'","'.$groupid.'");';

			if (!$result = mysql_query($sql))
			{				die (mysql_error().' '.$sql);
			}

			echo "<script>document.location='view.php?action=showgroup&usrid=".mysql_insert_id()."';</script>";
                }
                exit;
        }

	$tpl->define(
		array(
			main => "tpl/users.tpl"
		)
	);

        $sql = 'SELECT DISTINCT SUBSTRING( login, 1, 1) as letter
	        FROM engine_users
	        WHERE ugroup = '.$id.'
	        HAVING letter != ""
	        ORDER BY letter';

	if (!$result = mysql_query($sql))
	{		die($sql);
	}

	$letters = '';
	while ($row = mysql_fetch_array($result, MYSQL_ASSOC))
	{		$row['letter'] = strtolower($row['letter']);		if (strtolower($ltr) != $row['letter'])
		{			$letters .= '&nbsp;<a href="view.php?action=showgroup&ltr='.urlencode($row['letter']).'&id='.$id.'">'.$row['letter'].'</a>&nbsp;<br />';
		}
		else
		{			$letters .= '&nbsp;<a href="view.php?action=showgroup&ltr='.urlencode($row['letter']).'&id='.$id.'"><b>'.$row['letter'].'</b></a>&nbsp;<br />';
		}
	}

	$tpl->assign(
		array(
			'{LETTERS}' => $letters
		)
	);

	if ($ltr)
	{		$sql = 'SELECT *
		        FROM engine_users
		        WHERE ugroup = '.$id.'
		          AND login LIKE "'.mysql_real_escape_string($ltr).'%"
		        ORDER BY login';

		if (!$result = mysql_query("$sql"))
		{			die ($sql . "<br><br>" . mysql_error());
		}

		$user_list = '';
		while ($row = mysql_fetch_array($result, MYSQL_ASSOC))
		{			$user_img = $row['active'] ? 'user.gif' : 'user_gray.gif';
			if ($row['id'] == $user_id)
			{				$user_list .= '<tr><td><img src="img/'.$user_img.'" border="0" alt="" /></td><td><a href="view.php?action=showgroup&usrid='.$row['id'].'"><b>'.$row['login'].'</b></a></td></tr>';
			}
			else
			{				$user_list .= '<tr><td><img src="img/'.$user_img.'" border="0" alt="" /></td><td><a href="view.php?action=showgroup&usrid='.$row['id'].'">'.$row['login'].'</a></td></tr>';
			}
                }

		$tpl->assign(
			array(
				'{USERLIST}' => $user_list
			)
		);
	}
	else
	{
		$tpl->assign(
			array(
				'{USERLIST}' => ''
			)
		);
	}

	$role_array = array('Гость', 'Автор', 'Редактор', 'Разработчик', 'Администратор');
	$role = '';

	if ($usrid)
	{
		$sql = 'SELECT *
		        FROM engine_users
		        WHERE id ='.$usrid;

		if (!$result = mysql_query($sql))
		{			die (mysql_error());
		}

		$user = mysql_fetch_array($result, MYSQL_ASSOC);

		foreach($role_array as $role_id => $role_name)
		{
			$role .= '<option'.(($user['role'] == $role_name) ? ' SELECTED' : '').'>'.$role_name.'</option>';
		}

                if ($grp['name'] == 'belti')
		{			$sql = 'SELECT *
			        FROM engine_groups';
		}
                else
		{			$sql = 'SELECT *
			        FROM engine_groups
			        WHERE name != "belti"';
		}

                if (!$result = mysql_query($sql))
                {                	die("SQL error " . mysql_error() . ' in: '.$sql);
                }

		$moveto = '';
		while ($row = mysql_fetch_array($result, MYSQL_ASSOC))
		{
			if ($user['ugroup'] == $row['id'])
			{				$moveto .= '<option selected="selected" value="'.$row['id'].'">'.$row['name'].'</option>';
			}
			else
			{				$moveto .= '<option value="'.$row['id'].'">'.$row['name'].'</option>';
			}
                }
                $moveto = '<tr><td>Группа: </td><td><select name="group" class="com_input">'.$moveto.'</select></td></tr>';

                $tpl->assign(
                        array(
				'{MOVETOGROUP}' => $moveto,
				'{ROLE}'        => $role,
				'{GROUPID}'     => $user['ugroup'],
				'{USERLOGIN}'   => $user['login'],
				'{USERPASS}'    => (strlen($user['pass']) == 32 || strlen($user['pass']) == 20) ? '*****' : $user['pass'],
				'{USERNAME}'    => $user['name'],
				'{USERMNAME}'   => $user['mname'],
				'{USERLNAME}'   => $user['lname'],
				'{USERPHONE}'   => $user['phone'],
				'{USERFIRM}'    => $user['firm'],
				'{USEREMAIL}'   => $user['email'],
				'{USERINFO}'    => $user['info'],
				'{ACTIVE}'      => $user['active'] ? 'checked' : '',
				'{USERID}'      => $user['id'],

				'{SUBMIT}'      => 'Применить',
				'{CAPTION}'     => 'Редактирование пользователя',
				'{DEL}'         => ''
                                )
                        );
	}
	else
	{		if ($grp['name'] != 'belti')
		{
			unset($role_array[3]);
		}

		foreach($role_array as $role_id => $role_name)
		{			$role .= '<option'.(($role_name == 'Гость') ? ' SELECTED' : '').'>'.$role_name.'</option>';
		}

		$tpl->assign(
			array(
				'{MOVETOGROUP}' => '',
				'{ROLE}'        => $role,
				'{USERID}'      => '-1',
				'{GROUPID}'     => $id,
				'{USERLOGIN}'   => '',
				'{USERPASS}'    => '',
				'{USERNAME}'    => '',
				'{USERINFO}'    => '',
				'{USERMNAME}'   => '',
				'{USERLNAME}'   => '',
				'{USERPHONE}'   => '',
				'{USERFIRM}'    => '',
				'{USEREMAIL}'   => '',

				'{SUBMIT}'      => 'Создать',
				'{CAPTION}'     => 'Создание  пользователя',
				'{ACTIVE}'      => 'checked',
				'{DEL}'         => ''
			)
		);
	}

	$tpl->parse('MAIN', array("main"));
	$tpl->FastPrint();
}

if ($action == 'send') {
        if (!$do) {
                if ($id) {
                        $tpl->define(
                                array(
                                        main => "tpl/send.tpl"
                                        )
                                );
                        $sql = "select * from engine_send where id=$id";
                        $sql = "select se.id,se.name,se.doc_id,d.name dname from engine_send se, engine_documents d where d.id=se.doc_id and se.id=$id";
                        $r = mysql_query($sql) or die("SQL error " . mysql_error() . " in: $sql\n");
                        $f = mysql_fetch_array($r);
                        $tpl->assign(
                                array(
                                        DOC_ID => $f[doc_id],
                                        ID => $id,
                                        DOCNAME => $f[dname],
                                        NAME => $f[name]
                                        )
                                );
                        $sql = "select * from engine_send_emails where send_id=$id";
                        $r = mysql_query($sql);
                        while ($f = mysql_fetch_array($r)) {
                                if (++$i % 2)$bgcolor = "bgcolor='#76C5F0'";
                                else $bgcolor = "";

                                $emls .= "<tr><TD $bgcolor style='border-top:1 solid' class=top>$f[email]</TD><TD style='border-top:1 solid' $bgcolor class=top><a href='javascript:{document.all.deleml.value=\"$f[id]\";document.forms[0].submit();}'><img src='img/icons/del.gif' border=0></a></TD></tr>\n";
                        }
                        include $engine_root . '/engine/send_tree.php';
                        $tpl->assign(
                                array(
                                        DOCLIST => $tree,
                                        EMAILS => $emls
                                        ));

                        $tpl->parse(MAIN, array("main"));
                        $tpl->FastPrint();
                }
        } elseif ($do == 1) {
                if ($deleml) {
                        $sql = "delete from engine_send_emails where id=$deleml";
                        mysql_query($sql) or die("SQL error " . mysql_error() . " in: $sql\n");
                }
                if ($neweml) {
                        $sql = "insert into engine_send_emails(email,send_id) values('$new_email',$id)";
                        mysql_query($sql) or die("SQL error " . mysql_error() . " in: $sql\n");
                }

                $sql = "update engine_send set name='$name',doc_id='$doc_id' where id=$id";
                mysql_query($sql) or die("SQL error " . mysql_error() . " in: $sql\n");
                if (!mysql_error())
                        echo "
                                <SCRIPT LANGUAGE='JavaScript'>
                                <!--
                                document.location='view.php?action=$action&id=$id';
                                menu.document.location='menu.php?action=$action';

                                //-->
                                </SCRIPT>
                                ";
        }
}

if ($action == 'forum') {
        if (!$do) {
                if ($id) {
                        $tpl->define(
                                array(
                                        main => "tpl/forum.tpl"
                                        )
                                );
                        $sql = "select * from engine_forum where id=$id";
                        $r = mysql_query($sql) or die("SQL error " . mysql_error() . " in: $sql\n");
                        $f = mysql_fetch_array($r);

                        $sql = "select * from engine_groups order by name";
                        $gr = mysql_query($sql) or die("SQL error " . mysql_error() . " in: $sql\n");
                        while ($gf = mysql_fetch_array($gr)) {
                                if ($f[moderator_gr] == $gf[id])
                                        $mgr .= "<option selected value=$gf[id]>$gf[name]</option>";
                                else
                                        $mgr .= "<option value=$gf[id]>$gf[name]</option>";
                        }

                        $tpl->assign(
                                array(
                                        ID => $f[id],
                                        NAME => $f[name],
                                        FRMT1 => $f[answer_frmt1],
                                        FRMT2 => $f[answer_frmt2],
                                        TOPIC_FRMT => $f[topic_frmt],
                                        MGR => $mgr,
                                        DESCR => $f[descr]
                                        )
                                );
                        $tpl->parse(MAIN, array("main"));
                        $tpl->FastPrint();
                }
        } elseif ($do == 1) {
                $sql = "update engine_forum set
                                name='$name',
                                answer_frmt1='$frmt1',
                                answer_frmt2='$frmt2',
                                topic_frmt='$topic_frmt',
                                descr='$descr',
                                moderator_gr='$mgr'

                                where id=$id";
                mysql_query($sql) or die("SQL error " . mysql_error() . " in: $sql\n");
                if (!mysql_error())
                        echo "
                                <SCRIPT LANGUAGE='JavaScript'>
                                <!--
                                document.location='view.php?action=$action&id=$id';
                                menu.document.location='menu.php?action=$action';

                                //-->
                                </SCRIPT>
                                ";
        }
}

if ($action == 'log')
{	?>
<!DOCTYPE html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
  <link href="main.css" rel="stylesheet" type="text/css">
  <title>Ошибка доступа к документу</title>
</head>
<body>
<table cellspacing="1" cellpadding="3" border="0" width="100%" class="line">
  <tr>
    <th>Дата</th>
    <th>Пользователь</th>
    <th width="40%">Документ</th>
    <th width="60%">Действие</th>
  </tr>
	<?php
	$month = intval($_GET['date_month']);
	$year  = intval($_GET['date_year']);

	$sql = 'SELECT el.*, eu.login, ed.name
	        FROM (
	              engine_log el
	              LEFT JOIN engine_documents ed ON ed.id = el.document
	              LEFT JOIN engine_users eu ON eu.id = el.user
	             )
	        WHERE DATE_FORMAT( log_date, "%c" ) = "'.$month.'" AND DATE_FORMAT( log_date, "%Y" ) = "'.$year.'"';

	if (!$result = mysql_query($sql))
	{		die($sql);
	}

	while($row = mysql_fetch_array($result, MYSQL_ASSOC))
	{		echo '<tr><td nowrap="nowrap" valign="top" align="center"><u class="com_link">'.date('d.m.y H:i', strtotime($row['log_date'])).'</u></td><td valign="top"><a href="view.php?action=showgroup&usrid='.$row['user'].'">'.$row['login'].'</a></td><td valign="top"><a href="view.php?action=showdoc&id='.$row['document'].'">'.$row['name'].'</td><td valign="top"><span class="row2_text">'.$row['text'].'</span></td></tr>'."\n";
	}
	?>
</table>
</body>
</html>
	<?php
}

if (!$admin)echo "
<script>
if (document.all.adminpart!=null)
        document.all.adminpart.style.display='none';
if (document.all.stdadmpart!=null)
        document.all.stdadmpart.style.display='none';
</script>";

?>
</body>
<?php

$ret_str = ob_get_contents();
ob_end_clean();
//$ret_str = preg_replace("| +|s", " ", $ret_str);
echo $ret_str;

?>