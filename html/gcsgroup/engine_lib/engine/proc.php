<?php

/*
 *  $Id: proc.php,v 1.10 2005/02/24 08:20:14 dave Exp $
 *
 *  $Log: proc.php,v $
 *  Revision 1.10  2005/02/24 08:20:14  dave
 *  �������������� ����������� ���� ���������
 *
 *  Revision 1.9  2004/12/26 11:47:27  dave
 *  ������������������ ����
 *
 *  Revision 1.8  2004/12/20 22:25:44  dave
 *  ���������� ��� � �������������� ���������
 *
 *
 */

include 'config.inc';

function del_doc($id)
{
        global $logged;
        $d = new Document($id);

        $sql = "INSERT INTO `engine_log` (  `log_date` , `user` , `text` , `document` )
                VALUES (
                        NOW( ) , '$logged[id]', '�������� ��������� \'" . $d->name . "\'', '$id'
                        )
                ";
        mysql_query("$sql") or die (mysql_error() . $sql);
        $r = mysql_query("select id from engine_documents where pid=$id");
        while ($f = mysql_fetch_array($r)) {
                del_doc($f[id]);
        }
        mysql_query("delete from engine_documents where id=$id");
}

function del_rub($id)
{
        $r = mysql_query("select id from engine_rubrique where pid=$id");
        while ($f = mysql_fetch_array($r)) {
                del_doc($f[id]);
        }
        mysql_query("delete from engine_rubrique where id=$id");
}

?>
<SCRIPT LANGUAGE="JavaScript">
<!--
var menu=window.parent.frms.menu;
//-->
</SCRIPT>

<html>
<head>
        <title></title>
<link rel=stylesheet href="style.css" type="text/css" title="CSS style">
</head>
<style>
td{
        color: #005597;
        font-family: Arial, Helvetica, sans-serif;
        font-size: 12px;
        font-weight: bold;
        }
</style>
<body leftmargin="0" topmargin="0" rightmargin="0" bottommargin="0" marginwidth="0" marginheight="0" bgcolor="#003399" >
<table cellspacing="0" width="100%" height=100% cellpadding="0" border="0">
<tr>
    <td><img src="img/ugol.gif" alt="" border="0"></td>
    <td background="img/fon5.gif" width="100%"  height="4"></td>
    <td><img src="img/ugol2.gif" alt="" border="0"></td>
        <td  rowspan="8" background="img/fon8.gif" width="1px" ><img src="img/fon8.gif" alt="" border="0"></td>
</tr>
<tr>
    <td valign="top" background="img/fon7.gif" style="background-repeat: y;"><img src="img/4.gif" alt="" border="0"></td>
    <td valign="top"><table cellspacing="0" width="100%" height="100%" cellpadding="0" border="0">
<tr>
    <td bgcolor="#003399" valign="top" width="100%" height="18" class ="WHITE"
                width=100%>

&nbsp;
<?php
if ($action == 'newdoc') echo "����������&nbsp;���������";
if ($action == 'newfolder')echo "����������&nbsp;�������";
if ($action == 'newrub') echo "����������&nbsp;�������";
if ($action == 'export') echo "�������";
if ($action == 'import') echo "������";

?>
</td>
<td ><a href='#' class ="WHITE"  onclick="window.parent.document.all.proc.style.display='none';">x</a>&nbsp;</td>
</tr>
<tr>
    <td width="100%" height="3" background="img/fon2.gif" colspan=2></td>
</tr>
<tr>
    <td width="100%" height="100%" bgcolor="#76C5F0"  colspan=2> <center>
 <?php
if ($action == '') {

        ?>
        <script>
        window.parent.document.all.proc.style.display='none';</script>
        <?php
        echo '<TABLE width=100% height=100% border=0><TR><TD valign=middle align=center><IMG SRC="img/belti.gif" WIDTH="133" HEIGHT="40"></TD></TR></TABLE>';
} else {

        ?>
        <script>window.parent.document.all.proc.style.display='';</script>
        <?php
}
if ($action == 'message') {
        if ($voskl) {

                ?>
                <table width=100% height=100%><tr><td><img src=img\icons\voskl_znak.gif border=0></td><td align=center width=100%><?=$mess?></td></tr>
                <td colspan=2 align=center valign=bottom><input type=button class=but2 onclick="window.parent.document.all.proc.style.display='none';" value='OK'></td></table>
        <?php
        } else {

                ?>
                <table width=100% height=100%><tr><td align=center width=100%><?=$mess?></td></tr>
                <td align=center valign=bottom><input type=button class=but2 onclick="window.parent.document.all.proc.style.display='none';" value='OK'></td></table>
        <?php
        }
}

if ($action == 'newfolder') {
        if (getrights($pid) != 1) {

                ?>
                                <SCRIPT LANGUAGE="JavaScript">
                                <!--
                                                        document.location='proc.php?voskl=1&action=message&mess=<?php
                echo urlencode('� ��� �� ����������� ��� �������� �����');

                ?>';

                                //-->
                                </SCRIPT>
                                <?php
                exit;
        }

        if (!$do) {
                $sql = "select name from engine_documents where id=$pid";
                list($nnn) = mysql_fetch_array(mysql_query($sql));

                ?>

                        <form action='proc.php?action=newfolder' method=post>
                        <INPUT class=dlg TYPE="hidden" name=do value='proc'>
                        <INPUT class=dlg TYPE="hidden" name=pid value='<?=$pid?>'>
                        <TABLE height=100% width=100% cellpadding=0 cellspacing=0>
                                <TR bgcolor=#76C5F0 >
                                        <TD class=top  >
                                        <center>����������&nbsp;�������         � ����� "<u><?=$nnn?></u>"</center>
                                        </TD>
                                </TR>
                                <TR bgcolor=#76C5F0 >
                                        <TD  align=center>
                                        �������� ������� <INPUT class=dlg TYPE="text" NAME="name">
                                        </TD>
                                </TR>
                                <TR bgcolor=#76C5F0 >
                                        <TD  align=center><INPUT class=but TYPE="submit" value='  Ok  '></TD>
                                </TR>
                                </TABLE>
                        </form>
                <?php
        } elseif ($do == 'proc' && $pid != '') {
                if (mysql_num_rows(mysql_query("select * from engine_documents where name='$name' and pid=$pid and type='FOLDER'"))) {

                        ?>
                        <SCRIPT LANGUAGE="JavaScript">
                        <!--
                                                document.location='proc.php?voskl=1&action=message&mess=<?php
                        echo urlencode('����� ������� ��� ����');

                        ?>';

                        //-->
                        </SCRIPT>
                        <?php
                } else {
                        $sql = "insert into engine_documents(name,pid,type,creation_date,title,meta,counter1,counter2,counter3,code)
                                        values('$name',$pid,'FOLDER',NOW(),'"
                         . db_quote($def_title) . "','"
                         . db_quote($def_meta) . "','"
                         . db_quote($def_counter1) . "','"
                         . db_quote($def_counter2) . "','"
                         . db_quote($def_counter3) . "','"
                         . db_quote(engine_get_preferred_document_code($name)) . "')";
                        mysql_query($sql)or die("SQL error " . mysql_error() . " in: $sql\n");
                        $sql = "INSERT INTO `engine_log` (  `log_date` , `user` , `text` , `document` )
                                VALUES (
                                        NOW( ) , '$logged[id]', '�������� ����� \'$name\'', '" . mysql_insert_id() . "'
                                        )
                                ";

                        mysql_query("$sql") or die (mysql_error() . $sql);

                        ?>
                        <SCRIPT LANGUAGE="JavaScript">
                        <!--
                                                menu.document.location='menu.php';
                                                document.location='proc.php?action=message&mess=<?php
                        echo urlencode('������ ��������');

                        ?>';
                        //-->
                        </SCRIPT>
                        <?php
                }
        } else {
                echo $do;
        }
}
if ($action == 'delfolder') {
        if (getrights($pid) != 1) {

                ?>
                                <SCRIPT LANGUAGE="JavaScript">
                                <!--
                                                        document.location='proc.php?voskl=1&action=message&mess=<?php
                echo urlencode('� ��� �� ������� ���� ��� �������� ���� �����');

                ?>';

                                //-->
                                </SCRIPT>
                                <?php
                exit;
        }

        if (!$do) {

                ?>

                        <form action='proc.php?action=delfolder' method=post>
                        <INPUT class=dlg TYPE="hidden" name=do value='proc'>
                        <INPUT class=dlg TYPE="hidden" name=id value='<?=$id?>'>
                        <TABLE height=100% width=100% cellpadding=0 cellspacing=0>
                                <TR bgcolor=#76C5F0 >
                                        <td><img src=img\icons\voskl_znak.gif border=0></td>
                                        <TD class=top  >
                                        <center>������� �������<?=$rname?>?</center>
                                        </TD>
                                </TR>
                                <TR bgcolor=#76C5F0 >
                                        <TD  align=center><INPUT class=but TYPE="submit" value='  Ok  '></TD>
                                </TR>
                                </TABLE>
                        </form>
                <?php
        } elseif ($do == 'proc' && $id != -1) {
                del_rubric($id);

                ?>
                <SCRIPT LANGUAGE="JavaScript">
                        <!--
                                                menu.document.location='menu.php';
                                                document.location='proc.php?voskl=1&action=message&mess=<?php
                echo urlencode('������� �������');

                ?>';
                        //-->
                </SCRIPT>
                <?php
        }
}

if ($action == 'newdoc') {
        if (getrights($pid) != 1) {

                ?>
                                <SCRIPT LANGUAGE="JavaScript">
                                <!--
                                                        document.location='proc.php?voskl=1&action=message&mess=<?php
                echo urlencode('� ��� �� ����������� ��� �������� �������� � ���� �����');

                ?>';

                                //-->
                                </SCRIPT>
                                <?php
                exit;
        }
        if (!$do) {

                ?>
<script>
//alert(window.parent.menu.document.location);
</script>
<?php
                $sql = "select name from engine_documents where id=$pid";
                list($nnn) = mysql_fetch_array(mysql_query($sql));

                ?>
                        <form action='proc.php?action=newdoc' method=post>
                        <INPUT class=dlg TYPE="hidden" name=do value='proc'>
                        <INPUT class=dlg TYPE="hidden" name=pid value='<?=$pid?>'>
                        <TABLE height=100% width=100% cellpadding=0 cellspacing=0 border=0>
                                <TR bgcolor=#76C5F0 >
                                        <TD  colspan=2 align=center>
                                        �������� ��������� � ����� "<u><?=$nnn?></u>"
                                        </TD>
                                </TR>
                                <TR bgcolor=#76C5F0 >
                                        <TD  >
                                        &nbsp;&nbsp;��������
                                        </TD>
                                        <TD  align=center>

                                        <INPUT class=dlg TYPE="text" NAME="name">
                                        </TD>
                                </TR>
                                <TR bgcolor=#76C5F0 >
                                        <TD  >
                                        &nbsp;&nbsp;���
                                        </TD>
                                        <TD  align=center>
                                        <select class=dlg class=dlg name="type">
                                                <?php
                $handle = opendir('doc_types');
                while (false !== ($dtype = readdir($handle))) {
                        if ($dtype != "." && $dtype != ".." && is_dir("doc_types/{$dtype}") && $dtype != "FOLDER") {
                                if (testdoc_type($dtype)) {
                                        $filename = "doc_types/{$dtype}/name.txt";
                                        if (file_exists($filename)) {
                                                $ff = file($filename);
                                                if ($ff[1] == '����������') {
                                                        echo "<option value=$dtype>";
                                                        echo $ff[0];
                                                        echo "</option>";
                                                }
                                        }
                                }
                        }
                }
                closedir($handle);

                ?>
                                        </select>
                                        </TD>
                                </TR>
                                <TR bgcolor=#76C5F0 >
                                        <TD colspan=2 align=center><BR><INPUT class=but TYPE="submit" value='  Ok  '></TD>
                                </TR>
                                </TABLE>
                        </form>
                <?php
        } else {
                if ($do == 'proc' and $pid) {
                        $d = new Document($pid);
                        if ($type != 'NEW' and $type != 'CATALOGITEM') {
                                while ($d->type != 'FOLDER') {
                                        $d = new Document($d->pid);
                                }
                        }
                        $pid = $d->id;
                        if (mysql_num_rows(mysql_query("select * from engine_documents where name='$name' and pid=$pid")) and strtoupper($type) != 'NEW'and strtoupper($type) != 'CATALOGITEM') {

                                ?>
                                <SCRIPT LANGUAGE="JavaScript">
                                <!--
                                                        document.location='proc.php?voskl=1&action=message&mess=<?php
                                echo urlencode('����� �������� ��� ���� � ���� �������');

                                ?>';

                                //-->
                                </SCRIPT>
                                <?php
                        } else {
                                $sql = 'INSERT INTO engine_documents';
                                $sql .= ' (name, pid, creation_date, type, title, meta, counter1, counter2, counter3)';
                                $sql .= ' VALUES (';
                                $sql .= "'" . $name . "', ";
                                $sql .= $pid . ', ';
                                $sql .= 'NOW(), ';
                                $sql .= "'" . db_quote(strtoupper($type)) . "', ";
                                $sql .= "'" . db_quote($def_title) . "', ";
                                $sql .= "'" . db_quote($def_meta) . "', ";
                                $sql .= "'" . db_quote($def_counter1) . "', ";
                                $sql .= "'" . db_quote($def_counter2) . "', ";
                                $sql .= "'" . db_quote($def_counter3) . "')";
                                $newdoc_id = db_insert($sql);

                                $sql='UPDATE engine_documents SET code = ';

                                if ((strtoupper($type)=='NEW')||($name==''))
                                     $sql .= "'N" . db_quote($newdoc_id) . "'";
                                else
                                    $sql .= "'" . db_quote(engine_get_preferred_document_code($name)) . "'";

                                $sql.= ' WHERE id=' . $newdoc_id;
                                $a=mysql_query($sql);


                                $sql = "INSERT INTO engine_log (log_date, `user`, `text`, document)";
                                $sql .= " VALUES (NOW(), ";
                                $sql .= "'" . $logged[id] . "', ";
                                $sql .= "'�������� ��������� \'" . $name . "\'', ";
                                $sql .= "'" . $newdoc_id . "')";
                                $insert_id = db_insert($sql);
                                if ($back == 'this')
                                        $back = $insert_id;
                                if (!$back) {

                                        ?>
                                        <SCRIPT LANGUAGE="JavaScript">
                                        <!--
                                                                parent.frms.view.document.location='view.php?action=showdoc&id=<?=$newdoc_id?>';
                                        <?
                                        if ((strtoupper($type) != 'NEW') && (strtoupper($type) != 'CATALOGITEM'))
                                        {
                                        ?>
                                        menu.document.location='menu.php';
                                        <?
                                        }
                                        ?>

                                	document.location='proc.php?action=message&mess=<?php
                                        echo urlencode('�������� ��������');

                                        ?>';
                                        //-->
                                        </SCRIPT>
                                        <?php
                                } else {

                                        ?>
                                        <SCRIPT LANGUAGE="JavaScript">
                                        <!--
                                        <?
                                        if ((strtoupper($type) != 'NEW') && (strtoupper($type) != 'CATALOGITEM'))
                                        {
                                        ?>
                                        menu.document.location='menu.php';
                                        <?
                                        }
                                        ?>
                                                                document.location='view.php?action=showdoc&id=<?=$back?>';
                                        //-->
                                        </SCRIPT>
                                        <?php
                                }
                        }
                }
        }
}
if ($action == 'deldoc') {
        $dct = new Document($id);
        if (getrights($dct->pid) != 1) {

                ?>
                                <SCRIPT LANGUAGE="JavaScript">
                                <!--
                                                        document.location='proc.php?voskl=1&action=message&mess=<?php
                echo urlencode('� ��� �� ����������� �������� ��������');

                ?>';

                                //-->
                                </SCRIPT>
                                <?php
                exit;
        }
        if (!$do) {
                if ($dct->type != 'NEW')
                        $rname = $dct->name;
                else
                        $rname = $dct->spec[header];
                if (!$dct->undeletable) {

                        ?>

                        <form action='proc.php?action=deldoc' method=post>
                        <INPUT class=dlg TYPE="hidden" name=do value='proc'>
                        <INPUT class=dlg TYPE="hidden" name=id value='<?=$id?>'>
                        <TABLE height=100% width=100% cellpadding=0 cellspacing=0 border=0>
                                <TR bgcolor=#76C5F0 >
                                        <td valign=middle colspan=2 align=center>
                                        <table >
                                        <td class=midl align=right width=20%><img src=img\icons\voskl_znak.gif border=0 align=right></td>
                                        <td class=midlr width=80%>������� �������� '<?=$rname?>'</TD>
                                        </table>
                                        </td>
                                </TR>
                                <TR bgcolor=#76C5F0>
                                        <TD  align=center  ><INPUT class=but TYPE="submit" value='  ��  '></TD>
                                        <TD  align=center  ><INPUT class=but TYPE="button" onclick="window.parent.document.all.proc.style.display='none';" value='  ���  '></TD>
                                </TR>
                                </TABLE>
                        </form>
                <?php
                } else {

                        ?>
                        <SCRIPT LANGUAGE="JavaScript">
                                <!--
                                document.location='proc.php?voskl=1&action=message&mess=<?php
                        echo urlencode('�������� ' . $rname . ', �� ����� ���� ������ �.� ��� ������� ����������� �����.');

                        ?>';
                                -->
                        </SCRIPT>
                        <?php
                }
        } elseif ($do == 'proc' && $id != -1) {
                if ($dct->type == 'NEW')
                        $npid = $dct->pid;
                else
                        $npid = -1;
                del_doc($id);
                // mysql_query("delete from engine_documents where id=$id");
                if (!$back) {

                        ?>
                        <SCRIPT LANGUAGE="JavaScript">
                                <!--
                                                        parent.frms.view.document.location='view.php?action=showdoc&id=<?=$npid?>';
                                                        <?php
                        if ($dct->type != 'NEW')
                                echo "menu.document.location='menu.php';";

                        ?>
                                                        document.location='proc.php?voskl=1&action=message&mess=<?php
                        echo urlencode('�������� ������');

                        ?>';
                                //-->
                        </SCRIPT>
                        <?php
                } else {

                        ?>
                        <SCRIPT LANGUAGE="JavaScript">
                        <!--
                                                menu.document.location='menu.php';
                                                document.location='view.php?action=showdoc&id=<?=$back?>';
                        //-->
                        </SCRIPT>
                        <?php
                }
        }
}

if ($action == 'newtpl')
{
        if (!$do)
        {
        ?>
<form action='proc.php?action=<?=$action?>' method=post>
<INPUT class=dlg TYPE="hidden" name=do value='proc'>
<TABLE height=100% width=100% cellpadding=0 cellspacing=0>
                                <TR bgcolor=#76C5F0 >
                                        <TD class=top  >
                                        <center>����������&nbsp;�������</center>
                                        </TD>
                                </TR>
                                <TR bgcolor=#76C5F0 >
                                        <TD  align=center>
                                        �������� �������  <INPUT class=dlg TYPE="text" NAME="name">
                                        </TD>
                                </TR>
                                <TR bgcolor=#76C5F0 >
                                        <TD  align=center><INPUT class=but TYPE="submit" value='  Ok  '></TD>
                                </TR>
                                </TABLE>
                        </form>
                <?php
        } elseif ($do == 'proc')
        {
                if (mysql_num_rows(mysql_query("select * from engine_tpl where name='$name'")))
                {

                        ?>
                        <SCRIPT LANGUAGE="JavaScript">
                        <!--
                                                document.location='proc.php?voskl=1&action=message&mess=<?php
                        echo urlencode('����� ������ ��� ����');

                        ?>';

                        //-->
                        </SCRIPT>
                        <?php
                } else
                {
                        mysql_query("insert into engine_tpl(name) values('$name')");

                        $text = '���������� ������� \''.$name.'\'';
                        $sql = 'INSERT INTO engine_log (log_date, user, text, document)
                                                VALUES (NOW(), '.$logged['id'].', "'.mysql_real_escape_string($text).'", -'.mysql_insert_id().');';

                        if (!($result = mysql_query($sql)))
                        {
                                die("SQL error " . mysql_error() . " in: $sql\n");
                        }

                        ?>
                        <SCRIPT LANGUAGE="JavaScript">
                        <!--
                                                menu.document.location='menu.php?action=tpl';
                                                document.location='proc.php?action=message&mess=<?php
                        echo urlencode('������ ��������');

                        ?>';
                        //-->
                        </SCRIPT>
                        <?php
                }
        } else {
                echo $do;
        }
}

if ($action == 'deltpl') {
        if (!$do) {
                list($tname) = mysql_fetch_array(mysql_query("select name from engine_tpl where id=$id")) ;

                ?>

                        <form action='proc.php?action=<?=$action?>' method=post>
                        <INPUT class=dlg TYPE="hidden" name=do value='proc'>
                        <INPUT class=dlg TYPE="hidden" name=id value='<?=$id?>'>
                        <INPUT class=dlg TYPE="hidden" name=tname value='<?=$tname?>'>
                        <TABLE height=100% width=100% cellpadding=0 cellspacing=0>
                                <TR bgcolor=#76C5F0 >
                                        <td valign=middle  align=center colspan=2>
                                        <table >
                                        <td class=midl align=right width=20%><img src=img\icons\voskl_znak.gif border=0 align=right></td>
                                        <td class=midlr width=80%>������� ������ '<?=$tname?>'?</TD>
                                        </table>
                                        </td>
                                </TR>
                                <TR bgcolor=#76C5F0 >
                                        <TD  align=center><INPUT class=but TYPE="submit" value='  Ok  '></TD>
                                        <TD  align=center  ><INPUT class=but TYPE="button" onclick="window.parent.document.all.proc.style.display='none';" value='  ���  '></TD>

                                </TR>
                                </TABLE>
                        </form>
                <?php
        } elseif ($do == 'proc' && $id != -1) {
                mysql_query("delete from engine_tpl where id=$id");

                $text = '�������� ������� \''.$tname.'\'';
                $sql = 'INSERT INTO engine_log (log_date, user, text, document)
                                        VALUES (NOW(), '.$logged['id'].', "'.mysql_real_escape_string($text).'", -'.$id.');';

                if (!($result = mysql_query($sql)))
                {
                        die("SQL error " . mysql_error() . " in: $sql\n");
                }

                ?>
                <SCRIPT LANGUAGE="JavaScript">
                        <!--
                                                menu.document.location='menu.php?action=tpl';
                                                document.location='proc.php?voskl=1&action=message&mess=<?php
                echo urlencode('������ ������');

                ?>';
                        //-->
                </SCRIPT>
                <?php
        }
}

if ($action == 'newsend') {
        if (!$do) {

                ?>

                        <form action='proc.php?action=<?=$action?>' method=post>
                        <INPUT class=dlg TYPE="hidden" name=do value='proc'>
                        <TABLE height=100% width=100% cellpadding=0 cellspacing=0>
                                <TR bgcolor=#76C5F0 >
                                        <TD class=top  >
                                        <center>����������&nbsp;��������</center>
                                        </TD>
                                </TR>
                                <TR bgcolor=#76C5F0 >
                                        <TD  align=center>
                                        �������� ��������  <INPUT class=dlg TYPE="text" NAME="name">
                                        </TD>
                                </TR>
                                <TR bgcolor=#76C5F0 >
                                        <TD  align=center><INPUT class=but TYPE="submit" value='  Ok  '></TD>
                                </TR>
                                </TABLE>
                        </form>
                <?php
        } elseif ($do == 'proc') {
                if (mysql_num_rows(mysql_query("select * from engine_send where name='$name'"))) {

                        ?>
                        <SCRIPT LANGUAGE="JavaScript">
                        <!--
                                                document.location='proc.php?voskl=1&action=message&mess=<?php
                        echo urlencode('����� �������� ��� ����');

                        ?>';

                        //-->
                        </SCRIPT>
                        <?php
                } else {
                        mysql_query("insert into engine_send(name) values('$name')");

                        ?>
                        <SCRIPT LANGUAGE="JavaScript">
                        <!--
                                                menu.document.location='menu.php?action=send';
                                                document.location='proc.php?action=message&mess=<?php
                        echo urlencode('�������� ���������');

                        ?>';
                        //-->
                        </SCRIPT>
                        <?php
                }
        } else {
                echo $do;
        }
}

if ($action == 'delsend') {
        if (!$do) {
                list($tname) = mysql_fetch_array(mysql_query("select name from engine_send where id=$id")) ;

                ?>

                        <form action='proc.php?action=<?=$action?>' method=post>
                        <INPUT class=dlg TYPE="hidden" name=do value='proc'>
                        <INPUT class=dlg TYPE="hidden" name=id value='<?=$id?>'>
                        <TABLE height=100% width=100% cellpadding=0 cellspacing=0>
                                <TR bgcolor=#76C5F0 >
                                        <td valign=middle  align=center colspan=2>
                                        <table >
                                        <td class=midl align=right width=20%><img src=img\icons\voskl_znak.gif border=0 align=right></td>
                                        <td class=midlr width=80%>������� �������� '<?=$tname?>'?</TD>
                                        </table>
                                        </td>
                                </TR>
                                <TR bgcolor=#76C5F0 >
                                        <TD  align=center><INPUT class=but TYPE="submit" value='  Ok  '></TD>
                                        <TD  align=center  ><INPUT class=but TYPE="button" onclick="window.parent.document.all.proc.style.display='none';" value='  ���  '></TD>

                                </TR>
                                </TABLE>
                        </form>
                <?php
        } elseif ($do == 'proc' && $id != -1) {
                mysql_query("delete from engine_send where id=$id");

                ?>
                <SCRIPT LANGUAGE="JavaScript">
                        <!--
                                                menu.document.location='menu.php?action=send';
                                                document.location='proc.php?voskl=1&action=message&mess=<?php
                echo urlencode('�������� �������');

                ?>';
                        //-->
                </SCRIPT>
                <?php
        }
}

if ($action == 'newstyle') {
        if (!$do) {

                ?>

                        <form action='proc.php?action=<?=$action?>' method=post enctype="multipart/form-data">
                        <INPUT class=dlg TYPE="hidden" name=do value='proc'>
                        <TABLE height=100% width=100% cellpadding=0 cellspacing=0>
                                <TR bgcolor=#76C5F0 >
                                        <TD class=top  colspan=2 >
                                        <center>����������&nbsp;�����</center>
                                        </TD>
                                </TR>
                                <TR bgcolor=#76C5F0 >
                                        <TD  align=center>
                                        ��������
                                        </TD>
                                        <TD  align=center>
                                        <INPUT class=dlg TYPE="text" NAME="name">
                                        </TD>
                                </TR>
                                <TR bgcolor=#76C5F0 >
                                        <TD  align=center>
                                        ����
                                        </TD>
                                        <TD  align=center>
                                        <INPUT class=dlg TYPE="file" NAME="filename">
                                        </TD>
                                </TR>
                                <TR bgcolor=#76C5F0 >
                                        <TD  align=center><INPUT class=but TYPE="submit" value='  Ok  '></TD>
                                </TR>
                                </TABLE>
                        </form>
                <?php
        } elseif ($do == 'proc') {
                if (mysql_num_rows(mysql_query("select * from engine_styles where name='$name'"))) {

                        ?>
                        <SCRIPT LANGUAGE="JavaScript">
                        <!--
                                                document.location='proc.php?action=message&mess=<?php
                        echo urlencode('����� ����� ��� ����');

                        ?>';
                        //-->
                        </SCRIPT>
                        <?php
                } else {
                        $fn = explode(".", $filename_name);
                        $ext = $fn[count($fn)-1];
                        if ($ext != "css") {

                                ?>
                                <SCRIPT LANGUAGE="JavaScript">
                                <!--
                                                        document.location='proc.php?action=message&mess=<?php
                                echo urlencode('�������� ������ �����');

                                ?>';
                                //-->
                                </SCRIPT>
                                <?php
                        } else {
                                mysql_query("insert into engine_styles(name) values('$name')");

                                copy ($filename, "$engine_show_root/engine/styles/style" . mysql_insert_id() . ".css");
                                chmod("$engine_show_root/engine/styles/style" . mysql_insert_id() . ".css", 0777);

                                ?>
                                <SCRIPT LANGUAGE="JavaScript">
                                <!--
                                                        menu.document.location='menu.php?action=style';
                                                        document.location='proc.php?action=message&mess=<?php
                                echo urlencode('����� ��������');

                                ?>';
                                //-->
                                </SCRIPT>
                                <?php
                        }
                }
        } else {
                echo $do;
        }
}

if ($action == 'delstyle') {
        if (!$do) {
                list($sname) = mysql_fetch_array(mysql_query("select name from engine_styles where id=$id")) ;

                ?>

                        <form action='proc.php?action=<?=$action?>' method=post>
                        <INPUT class=dlg TYPE="hidden" name=do value='proc'>
                        <INPUT class=dlg TYPE="hidden" name=id value='<?=$id?>'>
                        <TABLE height=100% width=100% cellpadding=0 cellspacing=0>
                                <TR bgcolor=#76C5F0 >
                                        <td valign=middle  align=center colspan=2>
                                        <table >
                                        <td class=midl align=right width=20%><img src=img\icons\voskl_znak.gif border=0 align=right></td>
                                        <td class=midlr width=80%>������� ����� '<?=$sname?>'?</TD>
                                        </table>
                                        </td>
                                </TR>
                                <TR bgcolor=#76C5F0 >
                                        <TD  align=center><INPUT class=but TYPE="submit"         value='  Ok  '></TD>
                                        <TD  align=center  ><INPUT class=but TYPE="button" onclick="window.parent.document.all.proc.style.display='none';" value='  ���  '></TD>

                                </TR>
                                </TABLE>
                        </form>
                <?php
        } elseif ($do == 'proc' && $id != -1) {
                mysql_query("delete from engine_styles where id=$id");
                @unlink("$engine_show_root/engine/styles/style" . $id . ".css");

                ?>
                <SCRIPT LANGUAGE="JavaScript">
                        <!--
                                                menu.document.location='menu.php?action=style';
                                                document.location='proc.php?action=message&mess=<?php
                echo urlencode('����� ������');

                ?>';
                        //-->
                </SCRIPT>
                <?php
        }
}

if ($action == 'newgroup') {
        if (!$do) {

                ?>

                        <form action='proc.php?action=<?=$action?>' method=post enctype="multipart/form-data">
                        <INPUT class=dlg TYPE="hidden" name=do value='proc'>
                        <TABLE height=100% width=100% cellpadding=0 cellspacing=0>
                                <TR bgcolor=#76C5F0 >
                                        <TD class=top  colspan=2 >
                                        <center>����������&nbsp;������</center>
                                        </TD>
                                </TR>
                                <TR bgcolor=#76C5F0 >
                                        <TD  align=center>
                                        ��������
                                        </TD>
                                        <TD  align=center>
                                        <INPUT class=dlg TYPE="text" NAME="name">
                                        </TD>
                                </TR>
                                <TR bgcolor=#76C5F0  >
                                        <TD  align=center><INPUT class=but TYPE="submit" value='  Ok  '></TD>
                                        <TD  align=center  ><INPUT class=but TYPE="button" onclick="window.parent.document.all.proc.style.display='none';" value='  ������  '></TD>
                                </TR>
                                </TABLE>
                        </form>
                <?php
        } elseif ($do == 'proc') {
                if (mysql_num_rows(mysql_query("select * from engine_groups where name='$name'"))) {

                        ?>
                        <SCRIPT LANGUAGE="JavaScript">
                        <!--
                                                document.location='proc.php?action=message&mess=<?php
                        echo urlencode('����� ������ ��� ����');

                        ?>';
                        //-->
                        </SCRIPT>
                        <?php
                } else {
                        mysql_query("insert into engine_groups(name) values('$name')");

                        ?>
                                <SCRIPT LANGUAGE="JavaScript">
                                <!--
                                                        menu.document.location='menu.php?action=group';
                                                        document.location='proc.php?action=message&mess=<?php
                        echo urlencode('������ ���������');

                        ?>';
                                //-->
                                </SCRIPT>
                                <?php
                }
        } else {
                echo $do;
        }
}

if ($action == 'delgroup') {
        if (!$do) {
                list($gname) = mysql_fetch_array(mysql_query("select name from engine_groups where id=$id")) ;

                ?>

                        <form action='proc.php?action=<?=$action?>' method=post>
                        <INPUT class=dlg TYPE="hidden" name=do value='proc'>
                        <INPUT class=dlg TYPE="hidden" name=id value='<?=$id?>'>
                        <TABLE height=100% width=100% cellpadding=0 cellspacing=0>
                                <TR bgcolor=#76C5F0 >
                                        <td valign=middle  align=center colspan=2>
                                        <table >
                                        <td class=midl align=right width=20%><img src=img\icons\voskl_znak.gif border=0 align=right></td>
                                        <td class=midlr width=80%>������� ������ '<?=$gname?>'?</TD>
                                        </table>
                                        </td>
                                </TR>
                                <TR bgcolor=#76C5F0 >
                                        <TD  align=center><INPUT class=but TYPE="submit"         value='  Ok  '></TD>
                                        <TD  align=center  ><INPUT class=but TYPE="button" onclick="window.parent.document.all.proc.style.display='none';" value='  ���  '></TD>

                                </TR>
                                </TABLE>
                        </form>
                <?php
        } elseif ($do == 'proc' && $id != -1) {
                mysql_query("delete from engine_groups where id=$id");

                ?>
                <SCRIPT LANGUAGE="JavaScript">
                        <!--
                                                menu.document.location='menu.php?action=group';
                                                document.location='proc.php?action=message&mess=<?php
                echo urlencode('������ �������');

                ?>';
                        //-->
                </SCRIPT>
                <?php
        }
}
/**
* ���������� �������                   *
* /****************************************************
*/

if ($action == 'newrub') {
        if (!$do) {

                ?>
<?php
                if ($pid > 0) {
                        $sql = "select name from engine_rubrique where id=$pid";
                        list($nnn) = mysql_fetch_array(mysql_query($sql));
                        $mes = "������� ���������� � ������� '" . $nnn . "'";
                } else
                        $mes = "������� �������";

                ?>
                        <form action='proc.php?action=newrub' method=post>
                        <INPUT class=dlg TYPE="hidden" name=do value='proc'>
                        <INPUT class=dlg TYPE="hidden" name=pid value='<?=$pid?>'>
                        <TABLE height=100% width=100% cellpadding=0 cellspacing=0 border=0>
                                <TR bgcolor=#76C5F0 >
                                        <TD  colspan=2 align=center>
                                        <u><?=$mes?></u>
                                        </TD>
                                </TR>
                                <TR bgcolor=#76C5F0 >
                                        <TD  >
                                        &nbsp;&nbsp;��������
                                        </TD>
                                        <TD  align=center>

                                        <INPUT class=dlg TYPE="text" NAME="name">
                                        </TD>
                                </TR>
                                <TR bgcolor=#76C5F0 >
                                        <TD colspan=2 align=center><BR><INPUT class=but TYPE="submit" value='  Ok  '></TD>
                                </TR>
                                </TABLE>
                        </form>
                <?php
        } else {
                if ($do == 'proc') {
                        if (mysql_num_rows(mysql_query("select * from engine_rubrique where name='$name' and pid='$pid'"))) {

                                ?>
                                <SCRIPT LANGUAGE="JavaScript">
                                <!--
                                                        document.location='proc.php?voskl=1&action=message&mess=<?php
                                echo urlencode('����� ������� ��� ����������.');

                                ?>';

                                //-->
                                </SCRIPT>
                                <?php
                        } else {
                                $sql = "insert into engine_rubrique(name,pid) values('$name',$pid)";
                                mysql_query($sql)or die("SQL error " . mysql_error() . " in: $sql\n");
                                $newrub_id = mysql_insert_id();

                                ?>
                                        <SCRIPT LANGUAGE="JavaScript">
                                        <!--
                                                                menu.document.location='menu.php?action=rubrique';
                                                                parent.frms.view.document.location='view.php?action=showdoc&id=<?=$newdoc_id?>';
                                                                document.location='proc.php?action=message&mess=<?php
                                echo urlencode('������� ���������');

                                ?>';
                                        //-->
                                        </SCRIPT>
                                        <?php
                        }
                }
        }
}

if ($action == 'delrub') {
        if (!$do) {
                list($tname) = mysql_fetch_array(mysql_query("select name from engine_rubrique where id=$id")) ;

                ?>

                        <form action='proc.php?action=<?=$action?>' method=post>
                        <INPUT class=dlg TYPE="hidden" name=do value='proc'>
                        <INPUT class=dlg TYPE="hidden" name=id value='<?=$id?>'>
                        <TABLE height=100% width=100% cellpadding=0 cellspacing=0>
                                <TR bgcolor=#76C5F0 >
                                        <td valign=middle  align=center colspan=2>
                                        <table >
                                        <td class=midl align=right width=20%><img src=img\icons\voskl_znak.gif border=0 align=right></td>
                                        <td class=midlr width=80%>������� ������� '<?=$tname?>'?</TD>
                                        </table>
                                        </td>
                                </TR>
                                <TR bgcolor=#76C5F0 >
                                        <TD  align=center><INPUT class=but TYPE="submit" value='  Ok  '></TD>
                                        <TD  align=center  ><INPUT class=but TYPE="button" onclick="window.parent.document.all.proc.style.display='none';" value='  ���  '></TD>

                                </TR>
                                </TABLE>
                        </form>
                <?php
        } elseif ($do == 'proc' && $id != -1) {
                del_rub($id);

                ?>
                <SCRIPT LANGUAGE="JavaScript">
                        <!--
                                                menu.document.location='menu.php?action=rubrique';
                                                document.location='proc.php?voskl=1&action=message&mess=<?php
                echo urlencode('������� �������');

                ?>';
                        //-->
                </SCRIPT>
                <?php
        }
}
if ($action == 'newforum') {
        if (!$do) {

                ?>

                        <form action='proc.php?action=<?=$action?>' method=post>
                        <INPUT class=dlg TYPE="hidden" name=do value='proc'>
                        <TABLE height=100% width=100% cellpadding=0 cellspacing=0>
                                <TR bgcolor=#76C5F0 >
                                        <TD class=top  >
                                        <center>����������&nbsp;������</center>
                                        </TD>
                                </TR>
                                <TR bgcolor=#76C5F0 >
                                        <TD  align=center>
                                        �������� ������  <INPUT class=dlg TYPE="text" NAME="name">
                                        </TD>
                                </TR>
                                <TR bgcolor=#76C5F0 >
                                        <TD  align=center><INPUT class=but TYPE="submit" value='  Ok  '></TD>
                                </TR>
                                </TABLE>
                        </form>
                <?php
        } elseif ($do == 'proc') {
                if (mysql_num_rows(mysql_query("select * from engine_forum where name='$name'"))) {

                        ?>
                        <SCRIPT LANGUAGE="JavaScript">
                        <!--
                                                document.location='proc.php?voskl=1&action=message&mess=<?php
                        echo urlencode('����� ����� ��� ����');

                        ?>';

                        //-->
                        </SCRIPT>
                        <?php
                } else {
                        mysql_query("insert into engine_forum(name) values('$name')");

                        ?>
                        <SCRIPT LANGUAGE="JavaScript">
                        <!--
                                                menu.document.location='menu.php?action=forum';
                                                document.location='proc.php?action=message&mess=<?php
                        echo urlencode('����� ��������');

                        ?>';
                        //-->
                        </SCRIPT>
                        <?php
                }
        } else {
                echo $do;
        }
}

if ($action == 'delforum') {
        if (!$do) {
                list($tname) = mysql_fetch_array(mysql_query("select name from engine_forum where id=$id")) ;

                ?>

                        <form action='proc.php?action=<?=$action?>' method=post>
                        <INPUT class=dlg TYPE="hidden" name=do value='proc'>
                        <INPUT class=dlg TYPE="hidden" name=id value='<?=$id?>'>
                        <TABLE height=100% width=100% cellpadding=0 cellspacing=0>
                                <TR bgcolor=#76C5F0 >
                                        <td valign=middle  align=center colspan=2>
                                        <table >
                                        <td class=midl align=right width=20%><img src=img\icons\voskl_znak.gif border=0 align=right></td>
                                        <td class=midlr width=80%>������� ����� '<?=$tname?>'?</TD>
                                        </table>
                                        </td>
                                </TR>
                                <TR bgcolor=#76C5F0 >
                                        <TD  align=center><INPUT class=but TYPE="submit" value='  Ok  '></TD>
                                        <TD  align=center  ><INPUT class=but TYPE="button" onclick="window.parent.document.all.proc.style.display='none';" value='  ���  '></TD>

                                </TR>
                                </TABLE>
                        </form>
                <?php
        } elseif ($do == 'proc' && $id != -1) {
                mysql_query("delete from engine_forum where id=$id");

                ?>
                <SCRIPT LANGUAGE="JavaScript">
                        <!--
                                                menu.document.location='menu.php?action=forum';
                                                document.location='proc.php?voskl=1&action=message&mess=<?php
                echo urlencode('����� ������');

                ?>';
                        //-->
                </SCRIPT>
                <?php
        }
}

?></center >
</td>
</tr>
</table>
</td>
    <td background="img/fon4.gif" valign="top"><img src="img/5.gif" alt="" border="0"></td>
</tr>
<tr>
    <td bgcolor="#D4D0C8"></td>
    <td background="img/fon5.gif"  height="4"></td>
    <td valign="bottom"><img src="img/ugol4.gif" alt="" border="0"></td>
</tr>
<tr><td colspan="3" background="img/fon8.gif" height="2"></td></tr>
</table>



</body>
</html>