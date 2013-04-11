<script>
function ShowElement(elem_id)
{
        doc = document.getElementById(elem_id);
        if (doc)
        {
                doc.style.display = (doc.style.display == 'none') ? '' : 'none';
        }
}
</script>

<tr>
  <td><span class="cat"><img src="img/arrow.gif" border="0" vspace="2"> Обнулить</span> <input type="checkbox" name="clear" /></td>
</tr>
<tr>
  <td><span class="cat"><img src="img/arrow.gif" border="0" vspace="2"> Надпись на кнопке</span></td>
</tr>
<tr>
  <td><input class="com_input" size="40" name="button" value="{ELECT_BUTTON}"></td>
</tr>
<tr>
  <td><span class="cat"><img src="img/arrow.gif" border="0" vspace="2"> Тип голосования</span></td>
</tr>
<tr>
  <td>
    <select name="elect_type">
      <option value="0"{ELECT_TYPE_0}>Обычный</option>
      <option value="1"{ELECT_TYPE_1}>С проверкой по Cookies</option>
      <option value="2"{ELECT_TYPE_2}>C проверкой по IP</option>
    </select>
  </td>
</tr>
<tr>
  <td><span class="cat"><img src="img/arrow.gif" border="0" vspace="2"> Сообщение после голосования</span></td>
</tr>
<tr>
  <td><input class="com_input" size="40" name="msg" value="{ELECT_MSG}"></td>
</tr>
<tr>
  <td><span class="cat"><img src="img/arrow.gif" border="0" vspace="2"> Вопрос</span></td>
</tr>
<tr>
  <td><textarea name="question" rows="2" style="width: 450px">{ELECT_QUESTION}</textarea></td>
</tr>
<tr>
  <td>
    <table border="0" width="98%" align="center" class="line" cellspacing="1" cellpadding="3">
      <tr>
        <th>Вопросы</th>
        <th>Голосов ({ELECT_TOTAL})</th>
        <th>%</th>
      </tr>
      <tr>
        <td><input class="com_input" size="60" value="{QVAL1}" name="quest1" /></td>
        <td align="center">{QUEST1}</td>
        <td align="center">{QUESTP1}</td>
      </tr>
      <tr>
        <td><input class="com_input" size="60" value="{QVAL2}" name="quest2" /></td>
        <td align="center">{QUEST2}</td>
        <td align="center">{QUESTP3}</td>
      </tr>
      <tr>
        <td><input class="com_input" size="60" value="{QVAL3}" name="quest3" /></td>
        <td align="center">{QUEST3}</td>
        <td align="center">{QUESTP3}</td>
      </tr>
      <tr>
        <td><input class="com_input" size="60" value="{QVAL4}" name="quest4" /></td>
        <td align="center">{QUEST4}</td>
        <td align="center">{QUESTP4}</td>
      </tr>
      <tr>
        <td><input class="com_input" size="60" value="{QVAL5}" name="quest5" /></td>
        <td align="center">{QUEST5}</td>
        <td align="center">{QUESTP5}</td>
      </tr>
      <tr>
        <td><input class="com_input" size="60" value="{QVAL6}" name="quest6" /></td>
        <td align="center">{QUEST6}</td>
        <td align="center">{QUESTP6}</td>
      </tr>
      <tr>
        <td><input class="com_input" size="60" value="{QVAL7}" name="quest7" /></td>
        <td align="center">{QUEST7}</td>
        <td align="center">{QUESTP7}</td>
      </tr>
      <tr>
        <td><input class="com_input" size="60" value="{QVAL8}" name="quest8" /></td>
        <td align="center">{QUEST8}</td>
        <td align="center">{QUESTP8}</td>
      </tr>
      <tr>
        <td><input class="com_input" size="60" value="{QVAL9}" name="quest9" /></td>
        <td align="center">{QUEST9}</td>
        <td align="center">{QUESTP9}</td>
      </tr>
      <tr>
        <td><input class="com_input" size="60" value="{QVAL10}" name="quest10" /></td>
        <td align="center">{QUEST10}</td>
        <td align="center">{QUESTP10}</td>
      </tr>
    </table>
  </td>
</tr>
<tr>
  <td><span class="cat"><img src="img/arrow.gif" border="0" vspace="2"> <a href="javascript:ShowElement('tr_elect_format');" class="cat">Общий формат вывода</a></span></td>
</tr>
<tr id="tr_elect_format" style="display: none;">
  <td><textarea name="elect_format" rows="7" style="width: 450px">{ELECT_FORMAT}</textarea></td>
</tr>
<tr>
  <td><span class="cat"><img src="img/arrow.gif" border="0" vspace="2"> <a href="javascript:ShowElement('tr_elect_item');" class="cat">Формат вывода элемента</a></span></td>
</tr>
<tr id="tr_elect_item" style="display: none;">
  <td><textarea name="elect_item" rows="3" style="width: 450px">{ELECT_ITEM}</textarea></td>
</tr>
<tr>
  <td><span class="cat"><img src="img/arrow.gif" border="0" vspace="2"> <a href="javascript:ShowElement('tr_elect_voted');" class="cat">Формат вывода после голосования</a></span></td>
</tr>
<tr id="tr_elect_voted" style="display: none;">
  <td><textarea name="elect_voted" rows="3" style="width: 450px">{ELECT_VOTED}</textarea></td>
</tr>
<tr>
  <td><span class="cat"><img src="img/arrow.gif" border="0" vspace="2"> <a href="javascript:ShowElement('tr_elect_voted_item');" class="cat">Формат вывода после голосованиея (элемент)</a></span></td>
</tr>
<tr id="tr_elect_voted_item" style="display: none;">
  <td><textarea name="elect_voted_item" rows="3" style="width: 450px">{ELECT_VOTED_ITEM}</textarea></td>
</tr>
<tr>
  <td><span class="cat"><img src="img/arrow.gif" border="0" vspace="2"> <a href="javascript:ShowElement('tr_elect_message');" class="cat">Формат вывода после голосованиея (сообщение)</a></span></td>
</tr>
<tr id="tr_elect_message" style="display: none;">
  <td><textarea name="elect_message" rows="3" style="width: 450px">{ELECT_MESSAGE}</textarea></td>
</tr>