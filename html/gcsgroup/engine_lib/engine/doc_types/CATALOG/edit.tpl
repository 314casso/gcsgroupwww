<SCRIPT LANGUAGE="JavaScript">
var proc=window.parent.proc;

function ShowElement(elem_id)
{	doc = document.getElementById(elem_id);
	if (doc)
	{		doc.style.display = (doc.style.display == 'none') ? '' : 'none';
	}
}
</SCRIPT>

<tr>
  <td><span class="cat"><img src="img/arrow.gif" border="0" vspace="2"> E-mail для отправки заказов</span></td>
</tr>
<tr>
  <td><input type="text" class="com_input" size="40" name="email" value="EMAIL" /></td>
</tr>
<tr>
  <td><span class="cat"><img src="img/arrow.gif" border="0" vspace="2"> Количество выводимых элементов на страницу</span></td>
</tr>
<tr>
  <td><input type="text" size="3" class="com_input" name="icount" value="ICOUNT"></td>
</tr>
<tr>
  <td><span class="cat"><img src="img/arrow.gif" border="0" vspace="2"> Элементы каталога</span></td>
</tr>
<tr>
  <td><a href="#" onclick="{proc.document.location='proc.php?action=newdoc&do=proc&pid={DOC_ID}&type=CATALOGITEM';}"><img border=0 src="doc_types/FORM/img/add.gif"></a></td>
</tr>
<tr><td>ITEMS</td></tr>
<tr>
  <td><span class="cat"><img src="img/arrow.gif" border="0" vspace="2"> <a class="cat" href="javascript:ShowElement('tr_prefix');">HTML выдающийся перед списком элементов</a></span></td>
</tr>
<tr id="tr_prefix" style="display: none;">
  <td><textarea name="prefix" style="width: 450px;" rows="4">PREFIX</textarea></td>
</tr>
<tr>
  <td><span class="cat"><img src="img/arrow.gif" border="0" vspace="2"> <a class="cat" href="javascript:ShowElement('tr_postfix');">HTML выдающийся после списка элементов</a></span></td>
</tr>
<tr id="tr_postfix" style="display: none;">
  <td><textarea name="postfix" style="width: 450px;" rows="4">POSTFIX</textarea></td>
</tr>



<tr>
  <td><span class="cat"><img src="img/arrow.gif" border="0" vspace="2"> <a class="cat" href="javascript:ShowElement('tr_short_format');">Короткий Формат вывода</a></span></td>
</tr>
<tr id="tr_short_format" style="display: none;">
  <td><textarea name="short_format" style="width: 450px;" rows="4">SHORT_FORMAT</textarea></td>
</tr>
<tr>
  <td><span class="cat"><img src="img/arrow.gif" border="0" vspace="2"> <a class="cat" href="javascript:ShowElement('tr_short_format2');">Короткий Формат вывода (черезполосица)</a></span></td>
</tr>

<tr id="tr_short_format2" style="display: none;">
 <td><textarea name="short_format2" style="width: 450px;" rows="4">SHORT_FORMAT2</textarea></td>
</tr>

<tr>
  <td><span class="cat"><img src="img/arrow.gif" border="0" vspace="2"> <a class="cat" href="javascript:ShowElement('tr_full_format');">Полный Формат вывода</a></span></td>
</tr>
<tr id="tr_full_format" style="display: none;">
  <td><textarea name="full_format" style="width: 450px;" rows="4">FULL_FORMAT</textarea></td>
</tr>

<tr>
  <td><span class="cat"><img src="img/arrow.gif" border="0" vspace="2"> <a class="cat" href="javascript:ShowElement('tr_filter');">Формат вывода фильтра</a></span></td>
</tr>
<tr id="tr_filter" style="display: none;">
  <td><textarea name="filter" style="width: 450px;" rows="4">FILTER</textarea></td>
</tr>

<tr>
  <td><span class="cat"><img src="img/arrow.gif" border="0" vspace="2"> <a class="cat" href="javascript:ShowElement('tr_params');">Параметры</a></span></td>
</tr>
<tr id="tr_params" style="display: none;">
  <td>
    <input type="hidden" id="npv_paramid" name="npv_paramid">
    <input type="hidden" id="delpossval" name="delpossval">
    <input type="hidden" id="delparam" name="delparam">
    <input type="hidden" id="delitem" name="delitem">
    <table border="0" width="100%">
      <tr>
        <td width="50%">
	  <table width="100%" class="line" cellpadding="3" cellspacing="1">
	    <tr>
	      <th colspan="2">Добавить параметр</th>
	    </tr>
	    <tr>
	      <td><input name=np_name></td>
	      <td>
	        <select name=np_type>
		  <option style="color:green">Текст</option>
		  <option style="color:blue">Изображение</option>
		  <option style="color:red">WYSIWYG</option>
		</select>
	      </td>
	    </tr>
	    <tr>
	      <td>выбирается из списка</td>
	      <td><input type=checkbox name=np_select ></td>
	    </tr>
	    <tr>
	      <td>мультиселект</td>
	      <td><input type=checkbox name=np_multiselect ></td>
	    </tr>
	    <tr>
	      <td colspan="2"> Формат элемента списка для мультиселектного пар-ра</td>
	    </tr>
	    <tr>
	      <td colspan="4" align="center"><textarea rows="3" style="width: 350px;"></textarea></td>
	    </tr>
	    <tr>
	      <td colspan="4" align=center><input name=np type="submit" value="Добавить" class="com_button"></td>
	    </tr>
	  </table>
	</td>
	<td>&nbsp;</td>
	<td width="50%" valign="top">
	  <table width="100%" class="line" cellpadding="3" cellspacing="1">
	    <tr>
	      <th>Скопироать параметры из</th>
	    </tr>
	    <tr>
	      <td>
	 	<SELECT name="copyctlg" style="width:250px;">COPYPARAM</SELECT>
	      </td>
	    </tr>
	    <tr>
	      <td align=center><INPUT name="copyparam" type="submit" value="Скопировать" class="com_button"></td>
	    </tr>
	  </table>
	  <br>
	  <table width="100%" class="line" cellpadding="3" cellspacing="1">
	    <tr>
	      <th colspan="2">Импорт/Экспорт</th>
	    </tr>
	    <tr>
	      <td align="center" width="50%"><input name="copyparam" type="button" value="импорт" class="com_button" onclick="document.location='import.php?type=catalog&id={DOC_ID}'"></td>
	      <td align="center" width="50%"><input name="copyparam" type="button" value="экспорт" class="com_button" onclick="document.location='export.php?type=catalog&id={DOC_ID}'"></td>
	    </tr>
	  </table>
        </td>
      </tr>
    </table>
    <table width="98%">
      <tr>
        <td colspan="3">PARAM</td>
      </tr>
    </table>
  </td>
</tr>

