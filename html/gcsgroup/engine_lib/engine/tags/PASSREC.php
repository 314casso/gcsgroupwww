<?php
$email = '';
$login = '';
$us_id = 0;
//вытаскиваем из формы имя таблицы в которую храним переменную
if ($doc_id){
	$sql = "select * from engine_FORM where doc_id=$doc_id";

	$spec_f = @mysql_fetch_array(mysql_query($sql));
   	/*	echo "<pre>";
   		print_r();	   
   		echo "</pre>";*/
	$db = $spec_f[bd];
	$tmpl = $doc->body; //шаблон
}
if (!$db || $db == '') $db = "engine_users";

if (isset($_REQUEST['lost_login']))
{	$login = trim($_REQUEST['lost_login']);
	$login_str = $login;
	if (get_magic_quotes_gpc())
	{		$login = stripslashes($login);
	}
	$sql = 'SELECT *
	        FROM '.$db.'
	        WHERE login = "'.mysql_real_escape_string($login).'"';

	if ($result = mysql_query($sql))
	{
		if ($row = mysql_fetch_array($result, MYSQL_ASSOC))
		{
			$email = $row['email'];
			$login = $row['login'];
			$us_id = $row['id'];
		}
		else
		{	
			$err = 1;
			$result_pass = 'Пользователя с указанным вами ником не существует';
		}
	}
	else
	{		$result_pass = 'Ошибка в SQL запросе: '.$sql;
		$err = 1;
	}
}
elseif (isset($_REQUEST['lost_mail']))
{	$login = '';	$email = trim($_REQUEST['lost_mail']);

	$email_str = $email;
	if (get_magic_quotes_gpc())
	{
		$email = stripslashes($email);
	}

	$sql = 'SELECT *
	        FROM '.$db.'
	        WHERE email = "'.mysql_real_escape_string($email).'"';

	if ($result = mysql_query($sql))
	{
		if ($row = mysql_fetch_array($result, MYSQL_ASSOC))
		{
			$email = $row['email'];
			$login = $row['login'];
			$us_id = $row['id'];
		}
		else
		{
			$err = 1;
			$result_pass = 'Пользователя с указанным вами e-mail не существует';
		}
	}
	else
	{
		$err = 1;
		$result_pass = 'Ошибка в SQL запросе: '.$sql;
	}
}

if ((!empty($login))&&(!empty($email))&&($us_id != 0)&&($err != 1))
{	$to  = $email;

	// subject
	$server_name = $_SERVER["SERVER_NAME"];
	$subject = 'Восстановление пароля ['.$server_name.']';


	$password = substr(md5(uniqid(rand(), true)) ,0, 10);

	// message
	$message  = '<p>Ваш пароль на сайте '.$server_name.'</p>';
	$message .= 'Логин: '.$login."<br>\n";
	$message .= 'Пароль: '.$password."\n";

	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=windows-1251' . "\r\n";
	$headers .= 'From: Робот <noreply@'.$server_name.'>' . "\r\n";

	// Mail it
	if (mail($to, $subject, $message, $headers))
	{		$sql = 'UPDATE '.$db.'
		           SET pass = "'.mysql_real_escape_string($password).'"
		         WHERE id = '.$us_id;

		if ($result = mysql_query($sql))
		{			$result_pass = 'Информация о вашем пароле отправлена на ваш почтовый ящик';
		}
		else
		{			$result_pass = 'Ошибка в SQL запросе: '.$sql;
		}	}
	else
	{		$result_pass=  'Во время отправления письма произошла ошибка';
	}
}

?>
<!-- форма -->
<?
if (!$tmpl){
/*
	$tmpl = '
                      <table cellspacing="2" cellpadding="5" border="0" style="margin-top: 5px;" width="100%">
                        <tr>
                          <td width="50%" valign="top">
                            <form action="" method="post">
                            <table cellspacing="2" cellpadding="2" class="sub_form" border="0" width="100%">
                              <tr><th colspan="2">Восстановление пароля по логину</th></tr>
                              <tr><td nowrap="nowrap">Логин:&nbsp;</td><td width="100%"><input type="text" value="[login]" name="lost_login" class="form_input" /></td></tr>
                              <tr><td colspan="2" align="center"> <input name="" type="submit"></td></tr>
                            </table>
                            </form>
                          </td>
                          <td width="50%" valign="top">
                            <form action="" method="post">
                            <table cellspacing="2" cellpadding="2" class="sub_form" border="0" width="100%">
                              <tr><th colspan="2">Восстановление пароля по e-mail</th></tr>
                              <tr><td nowrap="nowrap">E-mail:&nbsp;</td><td width="100%"><input type="text" value="[email]" name="lost_mail" class="form_input" /></td></tr>
                              <tr><td colspan="2" align="center"> <input name="" type="submit"> </td></tr>
                            </table>
                            </form>
                          </td>
                        </tr>
                      </table>';
	if ($result_pass)
	$tmpl .= '
                      <table cellspacing="0" cellpadding="0" border="0" style="margin-top: 5px;" width="100%">
                        <tr>
                          <td width="100%" align="center">[PASSREC]</td>
                        </tr>
                      </table>';
*/
	$tmpl = '';
}

$tmpl = str_replace("[login]",$login_str,$tmpl);
$tmpl = str_replace("[email]",$email_str,$tmpl);
$tmpl = str_replace("[PASSREC]",$result_pass,$tmpl);
echo $tmpl;
?>