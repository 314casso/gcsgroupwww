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
  <td><span class="cat"><img src="img/arrow.gif" brder="0" vspace="2"> Порядок вывода документов</span></td>
</tr>
<tr>
  <td>DOCSORDER</td>
</tr>
<tr>
  <td><span class="cat"><img src="img/arrow.gif" brder="0" vspace="2"> Документ для отображения</span></td>
</tr>
<tr>
  <td valign="top">
    <select name="doctoshow">
      <option value=-1>---------</option>
      DOCSTOSHOW
    </select>
  </td>
</tr>
<tr>
  <td>
    <table cellspacing="0" cellpadding="0" border="0">
      <tr><td><input type="checkbox" id="notinpath" NOTINPATH name="notinpath"></td><td><span class="cat"> <label for="notinpath">Не отображать в пути</label></span></td></tr>
    </table>
  </td>
</tr>
<tr>
  <td></td>
</tr>
<tr>
  <td><span class="cat"><img src="img/arrow.gif" brder="0" vspace="2"> <a href="javascript:ShowElement('tr_format');" class="cat">Формат вывода меню</a></span></td>
</tr>
<tr id="tr_format" style="display: none;">
  <td><textarea style="width: 450px" name="format" rows="5">FORMAT</textarea></td>
</tr>
