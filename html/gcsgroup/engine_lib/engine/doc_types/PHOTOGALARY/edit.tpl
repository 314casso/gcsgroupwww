<script>

function showdlg(id,txt1,txt2,txt3,ord)        {

        document.all.editor.reset();

        document.all.cellid.value=id;

        document.all.txt1.value=txt1;

        document.all.txt2.value=txt2;

        document.all.txt3.value=txt3;

        document.all.ord.value=ord;

        document.all.inscell.value='0';

        document.all.dlg.style.display='';

        document.location="#top";

        }

</script>
<tr>
  <td>
    <input type="hidden" name="cellid" id="cellid">
    <input type="hidden" name="inscell" id="inscell">
    <input type="hidden" name="delcell" id="delcell">

    <table class="line" id="dlg" style="display:none;position: absolute;z-index:5;left:200;top:100">
      <tr><th colspan="2">Настройка изображения</th></tr>
      <tr><td><span class="cat"><img src="img/arrow.gif" border="0" vspace="2"> Порядковый номер</span> </td><td><input type="text" id="ord" name="ord" value="" class="com_input" size="3" /></td></tr>
      <tr><td><span class="cat"><img src="img/arrow.gif" border="0" vspace="2"> Изображение</span></td><td><input id="bpic" name="bpic" type="file" class="com_input"></td></tr>
      <tr><td><span class="cat"><img src="img/arrow.gif" border="0" vspace="2"> Создать иконку из изображения</span></td><td><input checked onclick="{
      	if (!(this.checked)) document.all.icontr.style.display='';
      	else
      	document.all.icontr.style.display='none';
      	}"
      	name="crrprv" type="checkbox"></td></tr>
      <tr id=icontr style='display:none'><td>Иконка</td><td><input id=spic name=spic type=file></td></tr>
      <tr><td><span class="cat"><img src="img/arrow.gif" border="0" vspace="2"> Подпись 1</span></td><td><input id="txt1" name="txt1" class="com_input" /></td></tr>
      <tr><td><span class="cat"><img src="img/arrow.gif" border="0" vspace="2"> Подпись 2</span></td><td><input id="txt2" name="txt2" class="com_input" /></td></tr>
      <tr><td><span class="cat"><img src="img/arrow.gif" border="0" vspace="2"> Подпись 3</span></td><td><input id="txt3" name="txt3" class="com_input" /></td></tr>
      <tr>
        <td align="right" colspan="2"><input name="picedit" type="submit" class="com_button" value="Сохранить" />&nbsp;<input type="submit" value="Отменить" class="com_button" onclick="{document.all.dlg.style.display='none';return false;}"></td>
      </tr>
    </table>
  </td>
</tr>
<tr>
  <td><span class="cat"><img src="img/arrow.gif" border="0" vspace="2"> Количество строк на страницу</span></td>
</tr>
<tr>
  <td><input type="text" class="com_input" name="rows" value="{ROWS}" size="3" /></td>
</tr>
<tr>
  <td><span class="cat"><img src="img/arrow.gif" border="0" vspace="2"> Количество столбцов на страницу</span></td>
</tr>
<tr>
  <td><input name="cols" value="{COLS}" class="com_input" type="text" size="3" /></td>
</tr>
<!--
<tr>
  <td class="top"  valign="bottom" >- Показывать увеличенные изображения в отдельном окне</td>
</tr>
<tr>
  <td class="top"  valign="bottom" ><input name=nwnd {NWND} type=checkbox></td>
</tr>
<tr>
  <td class="top"  valign="bottom" >- Формат вывода</td>
</tr>
<tr>
  <td class="top"  valign="bottom" ><textarea name=format class=header2>{FORMAT}</textarea></td>
</tr>
-->
<tr>
  <td>
    <table>
      <tr>
        <td><img style="cursor:hand" onclick="{

        document.all.editor.reset();

        document.all.cellid.value=id;

        document.all.inscell.value='1';

        document.all.dlg.style.display='';

        document.location='#top';

        }" src ='/engine_lib/engine/img/add.gif'>
        </td>
        <td width=100%>{LISTER}</td>
      </tr>
    </table>
  </td>
</tr>
<tr>
  <td>
    <table class="line" width="100%">
      <tr>
        <th nowrap="nowrap">Изображение<BR>(<I>Клик -  увеличить</I>)</th>
        <th width="100%">Подписи</th>
        <th colspan="2">Действия</th>
      </tr>
      {PICS}
    </table>
  </td>
</tr>
