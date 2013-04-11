<script type="text/javascript">
function HideTr(tr_id)
{	var tr = document.getElementById('tr_'+tr_id);
	if (tr)
	{		tr.style.display = (tr.style.display == 'none') ? '' : 'none';

		var img = document.getElementById('img_'+tr_id);
		if (img)
		{			img.src = (tr.style.display == 'none') ? 'img/plus.gif' : 'img/minus.gif';
		}
	}
}
</script>

<tr>
  <td width="100%">
    <table class="table_bookmark" cellspacing="1" cellpadding="3" style="width: 100%;">
      <tr><td class="td_bookmark2_on" width="100%"><img src="img/minus.gif" onclick="javascript:HideTr('quest');" id="img_quest" />&nbsp;<a href="javascript:HideTr('quest');" class="bookmark2">Ответы консультария</a></td></tr>
    </table>
  </td>
</tr>
<tr id="tr_quest">
  <td valign="top">
    <table cellspacing="1" cellpadding="1" border="0" width="100%">
      <tr>
        <td class="top">{CONS_PAGES}</td>
      </tr>
      <tr>
        <td>
          <table border="0" cellpadding="0" cellspacing="0" width="100%">
            {CONS_QUESTS}
          </table>
        </td>
      </tr>
    </table>
  </td>
</tr>
<tr>
  <td width="100%">
    <table class="table_bookmark" cellspacing="1" cellpadding="3" style="width: 100%;">
      <tr><td class="td_bookmark2_on" width="100%"><img src="img/plus.gif" onclick="javascript:HideTr('tpl');" id="img_tpl"  />&nbsp;<a href="javascript:HideTr('tpl');" class="bookmark2">Настройки и шаблоны вывода</a></td></tr>
    </table>
  </td>
</tr>
<tr id="tr_tpl" style="display: none;">
  <td valign="top">
    <table cellspacing="0" cellpadding="0" width="100%" boder="0">
      <!--tr><td><span class="cat"><img src="img/arrow.gif" border="0" vspace="2"> Количество вопросов на страницу</span></td></tr>
      <tr><td><input type="text" name="cons_on_page" size="3" class="com_input" value="{CONS_ON_P}"></textarea></td></tr-->
      <tr><td><span class="cat"><img src="img/arrow.gif" border="0" vspace="2"> Шаблон вывода</span></td></tr>
      <tr><td><textarea name="cons_body" cols="75" rows="4">{CONS_BODY}</textarea></td></tr>
      <tr><td><span class="cat"><img src="img/arrow.gif" border="0" vspace="2"> Шаблон одной линии консультария</span></td></tr>
      <tr><td><textarea name="cons_line" cols="75" rows="3">{CONS_LINE}</textarea></td></tr>
      <tr><td><span class="cat"><img src="img/arrow.gif" border="0" vspace="2"> Шаблон разделителя в вопросе</span></td></tr>
      <tr><td><textarea name="cons_answer" cols="75" rows="2">{CONS_ANSWER}</textarea></td></tr>
      <tr><td><span class="cat"><img src="img/arrow.gif" border="0" vspace="2"> Шаблон разделителя в ответе</span></td></tr>
      <tr><td><textarea name="cons_question" cols="75" rows="2">{CONS_QUESTION}</textarea></td></tr>
    </table>
  </td>
</tr>
