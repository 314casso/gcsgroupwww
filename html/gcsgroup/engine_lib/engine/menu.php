<?php

/*
 * @Descr ����� ���� (����� �����)
 *  $Id: menu.php,v 1.11 2006/06/15 10:02:28 ereih Exp $
 *
 *  $Log: menu.php,v $
 *  Revision 1.11  2006/06/15 10:02:28  ereih
 *  �������� � ��������� �����������
 *
 *  Revision 1.10  2005/01/11 18:49:03  dave
 *  ����� ����������� 'u' � ���������� ����������
 *
 *  Revision 1.9  2004/12/26 11:47:27  dave
 *  ������������������ ����
 *
 *  Revision 1.8  2004/12/14 21:18:51  dave
 *  bugfix
 *
 *  Revision 1.7  2004/12/14 21:17:39  dave
 *  ������ ������ ������ ������, ���� ENGINE_VERSION �� ���������� (��� version.inc)
 *
 *  Revision 1.6  2004/12/14 20:45:27  dave
 *  ����� ������ ������
 *
 */

header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
header ("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
// always modified
header ("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header ("Pragma: no-cache"); // HTTP/1.0

include 'config.inc';
ob_start();

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 3.2 Final//EN">
<html>
<head>
  <title>������ ���������� - ����</title>
  <LINK href="main.css" rel="stylesheet" type="text/css">
<?
	$engine_htroot_ = str_replace("/engine_lib","",$engine_htroot);
?>
  <script>
  function logout()
  {
          window.parent.parent.document.location="<?=$engine_htroot_?>/engine/engine.php?logout=1";
  }
  </script>
</head>

<body style="margin: 5px; background-color: #2a5575;">
<table height="100%" width="100%" cellpadding="0" cellspacing="0" border="0">
  <tr><td>
<table class="line_blue" cellpadding="6" cellspacing="1" border="0" width="100%">
  <tr><td class="td_blue">
   <table cellpadding="0" cellspacing="0" border="0" width="100%">
  <tr>
	<td class="td_blue">
<b>�� ����� ���</b><br>
  <?
  echo '<u>'.$logged['login'].'</u> ('.$logged['role'].')<br>';
  ?>
  <b>������ CMS [��]:</b><br><u>
  <?
  if (ENGINE_VERSION == '')
  {
          echo '��� ������';
  }
  else
  {

	   echo ENGINE_VERSION;
          $sql = "select * from engine_conf  where varname = 'version'";
          $f = mysql_fetch_array(mysql_query($sql));
          $version = explode('.',$f[varvalue]);
          echo ' ['.$version[2].'.'.$version[3].']';

  }
  ?>
</u>
</td>
<td align="right">
<?
 if (file_exists("/img/logo_menu.gif")){
?>
	<img src="/img/logo_menu.gif" width=100 height=60 border="0">
<?
 }
?>
</td>
</tr>
<tr>
<td colspan="2">
<div class="null_div" align="right"><a href="#" class="logout" onclick="javascript:logout()">�����</a></div>
  </td></tr>
</table>
  </td></tr>
</table>
</td></tr>
<tr><td height="100%" valign="top">


<?php

switch ($action)
{
        case 'style':    if ($logged['role'] == '�����������')
                         {
                                 include 'styles.php';
                                 break;
                         }
        case   'tpl':    if ($logged['role'] == '�����������')
                         {
                                 include 'templates.php';
                                 break;
                         }
        case 'group':    if ($logged['role'] == '�������������')
                         {
                                 include 'group.php';
                                 break;
                         }
        case 'rubrique': include 'rubrique.php';
                         break;
        case 'tools':    include 'tools.php';
                         break;
        case 'send':     include 'send.php';
                         break;
        case 'log':      include 'log.php';
                         break;
        case 'forum':    include 'forum.php';
                         break;
        default:         include 'rubric.php';
                         break;
}
?>
</td></tr>
<table>
</body>
<?php

$ret_str = ob_get_contents();
ob_end_clean();
//$ret_str = preg_replace("| +|s", " ", $ret_str);

echo $ret_str;

?>