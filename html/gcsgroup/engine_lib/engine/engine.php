<?php

/*
 *  $Id: engine.php,v 1.14 2006/10/17 06:29:08 ereih Exp $
 *
 *  $Log: engine.php,v $
 *  Revision 1.14  2006/10/17 06:29:08  ereih
 *  Переименование в Absolute
 *
 *  Revision 1.9  2005/02/24 08:21:55  dave
 *  Убрано добавление таба при неверном логине/пароле
 *
 *  Revision 1.8  2005/01/10 18:00:35  dave
 *  пароли в MD5
 *
 *  Revision 1.7  2004/12/26 11:47:27  dave
 *  Переформатирование кода
 *
 *  Revision 1.6  2004/12/23 22:11:56  dave
 *  1. Убран "синий квадрат" у старых браузеров;
 *  2. Убрана "звездочка" в админе
 *
 *  Revision 1.5  2004/12/19 22:53:35  dave
 *  Вывод в приветствии логина имени и фамилии
 *
 *
 */

header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
header ("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");

// always modified
header ("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header ("Pragma: no-cache"); // HTTP/1.0

ini_set('session.cache_expire','480');

@session_start();
session_register("logged");
@session_register("engine_htroot");
@session_register("engine_root");
@session_register("engine_show_htroot");
@session_register("engine_show_root");
@session_register("db_host");
@session_register("db_user");
@session_register("db_pass");
@session_register("db_name");

/*if (!$engine_show_root)
        $engine_show_root=$dir;
if (!$engine_show_htroot)
        $engine_show_htroot=$htroot;
*/

@include "$engine_show_root/engine/config.inc";
@include $engine_root . '/engine/config.inc';

if (($logged[time] && (time() - $logged[time] > 60*4*60))){
	//превысили время
	$logged[time] = '';
	$PHP_SELF = $PHP_SELF."?logout=1&&err=2";
       header("Location: $PHP_SELF");
        exit();
}
//проверка что соединение есть
$sql = "select * from engine_documents limit 1";
if (!$news_r = mysql_query($sql)){
	$PHP_SELF = $PHP_SELF."?logout=1&&err=2";
	echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0; URL=".$PHP_SELF."\">";
      //header("Location: $PHP_SELF");
       exit();
}

if ($logout)
{
        if ($logged)
        {
                $sql = 'UPDATE engine_documents
                           SET opened=0
                         WHERE opener="'.$logged['id'].'"';
                $result = @mysql_query("$sql");
        }
        $logged['id'] = "";
        if ($_GET[err] != 2) $PHP_SELF = str_replace("logout=1", "", $PHP_SELF);
	 else  $PHP_SELF = str_replace("logout=1", "err=".$err, $PHP_SELF);
        $logged[time] = '';
        header("Location: $PHP_SELF");
        exit();
}

if (!$login)
{
        if ($logged['id'])
        {
                if ($logged['engine'] != $engine_show_root)
                {
                        $logged = 0;
                        $login = "";
                }
        }
}

if (!$logged['id'])
{
        if (!$login)
        {
        	if ($_GET[err] == 2) echo "<script>alert('Время вашей сессии истекло')</script>";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 3.2 Final//EN">
<html>
<head>
  <title>CMS Absolute - Авторизация</title>
  <LINK href="<?=$engine_htroot?>/engine/main.css" rel="stylesheet" type="text/css">
</head>

<body>
<table style="height: 100%" width="100%">
  <tr><td style="height: 35%"></td></tr>
  <tr><td align="center">
    <form method="post" action="" name="admission">
    <table width="350" cellspacing="1" cellpadding="5" class="line">
        <tr>
          <th colspan=2 align=center>Вход</th>
        </tr>
        <tr>
          <td align="right" width="35%">Логин:&nbsp;</td>
          <td><input name="lgn_" type="text" class="com_input"></td>
        </tr>
        <tr>
          <td align="right">Пароль:&nbsp;</td>
          <td><input name="pwd_" type="password" class="com_input"></td>
        </tr>
        <tr>
          <td align="center" colspan="2"><input name="login" type="submit" value='Войти' class="com_button"></td>
        </tr>
    </table>
    </form>
  </td></tr>
  <tr><td style="height: 65%"></td></tr>
</table>
<script>
function show(){
 	var fsel = document.admission;
	fsel.lgn_.focus();
}
setTimeout('show()', 1);
</script>
</body>
</html>
<?php
                exit;
        }
        else
        {

                if (check_login_pair('engine_users',$lgn_, $pwd_))
                {

                        $sql = 'SELECT *
                                FROM engine_users
                                WHERE login="'.mysql_real_escape_string($lgn_).'"';

                        $result = mysql_query($sql);

                        $userdata = mysql_fetch_array($result, MYSQL_ASSOC);

                        if ($userdata['role'] == 'Гость')
                        {
                                echo "
                                <script>
                                        document.location='/$engine_show_htroot';
                                </script>
                                ";

                                unset($logged);
                                exit;
                        }
                        else
                        {
                                $script = "<script>alert ('Здравствуйте, " . $userdata[name] . ($userdata[name] != '' && $userdata[lname] != '' ? ' ' : '') . $userdata[lname] . "!')</script>";
                                $logged = $userdata;
                                $logged[engine] = $engine_show_root;
                                $logged[time] = time();
                        }
                }
                else
                {
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 3.2 Final//EN">
<html>
<head>
  <title>CMS Absolute - Авторизация</title>
  <LINK href="<?=$engine_htroot?>/engine/main.css" rel="stylesheet" type="text/css">
</head>

<body>
<table style="height: 100%" width="100%">
  <tr><td style="height: 35%"></td></tr>
  <tr><td align="center">
    <form method="post" action="" name="admission">
    <table width="350" cellspacing="1" cellpadding="5" class="line">
        <tr>
          <th colspan=2 align=center>Вход</th>
        </tr>
        <tr><th class="error" colspan="2">Неправильный пароль</th></tr>
        <tr>
          <td align="right" width="35%">Логин:&nbsp;</td>
          <td><input name="lgn_" type="text" class="com_input"></td>
        </tr>
        <tr>
          <td align="right">Пароль:&nbsp;</td>
          <td><input name="pwd_" type="password" class="com_input"></td>
        </tr>
        <tr>
          <td align="center" colspan="2"><input name="login" type="submit" value='Войти' class="com_button"></td>
        </tr>
    </table>
    </form>
  </td></tr>
  <tr><td style="height: 65%"></td></tr>
</table>
<script>
function show(){
 	var fsel = document.admission;
	fsel.lgn_.focus();
}
setTimeout('show()', 1);
</script>
</body>
</html>
<?php
                        exit;
                }
        }
}

//include './../'.$engine_htroot.'/engine/frames.php';
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>
  <TITLE>CMS Absolute - Панель управления</TITLE>
</HEAD>
<?=$script?>

<body style="margin: 0; scroll:no">
  <iframe scrolling="no" style="display: none; left: 400; top:200; position: absolute; filter: alpha(opacity=90); z-index: 10; border: 0;" id="proc" src="<?=$engine_htroot?>/engine/proc.php" name="proc" frameborder="0" ></iframe>
  <iframe scrolling="no" style="display: none; left: 400; top:200; height:300; position: absolute; filter: alpha(opacity=90); z-index: 11;border: 0;" id="move_to" src="<?=$engine_htroot?>/engine/moveto.php" name="move_to" frameborder="0" ></iframe>
  <iframe src="<?=$engine_htroot?>/engine/frames.php?session_time=<? echo $logged[time]?>" name="frms" width="100%" height="100%"></iframe>
</BODY>
</HTML>
