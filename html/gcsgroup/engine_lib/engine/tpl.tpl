<LINK href="main.css" rel="stylesheet" type="text/css">
  <form method=post action='?action=tpl'>
    <input type="hidden" name="do" value=1>
    <input type="hidden" name="id" value="{tpl_id}">
      <table class="line" width="100%" cellSpacing="1" cellPadding="2">
        <tr><th>��������� ���������� �������</th></tr>
        <tr>
          <td><span class="cat"><img src="img/arrow.gif" brder="0" vspace="2"> ��������</span></td>
        </tr>
        <tr>
          <td><input type="text" name="name" value='{tpl_name}' class="com_input"></td>
        </tr>
        <tr>
          <td><span class="cat"><img src="img/arrow.gif" brder="0" vspace="2"> ����</span></td>
        </tr>
        <tr>
          <td>
            <textarea name="body" rows="20" cols="70" class="com_input" style="font-family: 'Courier New', Courier, monospace;width: 100%">{tpl_body}</textarea>
          </td>
        </tr>
        <tr>
          <td align=center><input type="submit" value="���������" class="com_button"></td>
        </tr>
      </table>