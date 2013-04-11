<!DOCTYPE html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
  <link href="main.css" rel="stylesheet" type="text/css">
  <title>Ошибка доступа к документу</title>
</head>
<body>

<style>
.div_letters
{	margin: 0px;
	padding: 0px;
	font-family: Courier;
	font-size: 12pt;
}

.div_letters a
{	font-family: Courier;
	font-size: 12pt;
}
</style>

<table cellspacing="1" cellpadding="3" border="0" width="100%" class="line">
  <form method="post" action="">
  <input type="hidden" name="userid" value="{USERID}">
  <input type="hidden" name="groupid" value="{GROUPID}">
  <tr>
    <th width="30%">Пользователи</th>
    <th width="60%">{CAPTION}</th>
  </tr>
  <tr>
    <td valign="top">
      <table width="100%">
        <tr>
          <td valign="top"><div class="div_letters">{LETTERS}</div></td>
          <td width="100%" valign="top">
            <div style = "overflow-y: scroll; overflow-x: scroll; width: 100%; height: 380px;" class="line_blue">
              <table cellpadding="0" cellspacing="3">{USERLIST}</table>
            </div>
          </td>
        </tr>
      </table>
    </td>
    <td valign="top">
      <table>
        <tr><td><input type="checkbox" name="active" id="user_active" {ACTIVE} /></td><td><label for="user_active">Пользователь активен</label></td></tr>
      </table>
      <table>
        <tr><td>Логин: </td><td><input type="text" name="userlogin" class="com_input" value="{USERLOGIN}" /></td></tr>
        <tr><td>Пароль: </td><td><input type="text" name="userpass" class="com_input" value="{USERPASS}" /></td></tr>
        <tr><td>Роль: </td><td><select name="role" class="com_input">{ROLE}</select></td></tr>

        {MOVETOGROUP}

        <tr><td>Фамилия: </td><td><input type="text" name="userlname" class="com_input" value="{USERLNAME}" /></td></tr>
        <tr><td>Имя: </td><td><input type="text" name="username" class="com_input" value="{USERNAME}" /></td></tr>
        <tr><td>Отчество: </td><td><input type="text" name="usermname" class="com_input" value="{USERMNAME}" /></td></tr>

        <tr><td>E-mail: </td><td><input type="text" name="useremail" class="com_input" value="{USEREMAIL}" /></td></tr>
        <tr><td>Телефон: </td><td><input type="text" name="userphone" class="com_input" value="{USERPHONE}" /></td></tr>
        <tr><td>Организация: </td><td><input type="text" name="userfirm" class="com_input" value="{USERFIRM}" /></td></tr>

        <tr><td colspan="2">Дополнительная информация: </td></tr>
        <tr><td colspan="2"><textarea name="userinfo" class="con_input" cols="60" rows="5">{USERINFO}</textarea></td></tr>

        <tr><td align="center" colspan="2"><input value="{SUBMIT}" class="com_button" type="submit" name="sbm" />&nbsp;&nbsp;<input value="Удалить" class="com_button" type="button" onclick="document.location='view.php?action=showgroup&groupid={GROUPID}&userid={USERID}&del=1'" name="sbm" /></td></tr>

      </table>
    </td>
  </tr>
  </form>
</table>
</body>
</html>