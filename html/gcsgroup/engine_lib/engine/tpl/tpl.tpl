<LINK href="main.css" rel="stylesheet" type="text/css">
      <table class="line" width="100%" cellSpacing="1" cellPadding="2">
      <form method=post action='?action=tpl'>
      <input type="hidden" name="do" value=1>
      <input type="hidden" name="id" value="{tpl_id}">
        <tr><th>Изменение параметров шаблона</th></tr>
        <tr>
          <td><span class="cat"><img src="img/arrow.gif" brder="0" vspace="2"> Название</span></td>
        </tr>
        <tr>
          <td><input type="text" name="name" value='{tpl_name}' class="com_input"></td>
        </tr>
        <tr>
          <td><span class="cat"><img src="img/arrow.gif" brder="0" vspace="2"> Тело</span></td>
        </tr>
        <tr>
          <td>
            <textarea name="body" rows="30" cols="70" class="com_input" style="font-family: 'Courier New', Courier, monospace; font-size: 8pt;width:100%">{tpl_body}</textarea>
          </td>
        </tr>
        <tr>
          <td align=center><input type="submit" value="Сохранить" class="com_button"></td>
        </tr>
        </form>
      </table>