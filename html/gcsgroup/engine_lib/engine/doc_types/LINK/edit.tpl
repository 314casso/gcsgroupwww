<script type="text/javascript">
var selected_doc = -1;

function SetCode(doc_id)
{
        doc = GetDocInfo(doc_id);
        inp = document.getElementById('doccode');
        if (inp)
        {
                inp.value = doc[5];
        }

        if (doc_id != selected_doc)
        {
        	link = document.getElementById('doc_'+doc_id);
        	link.className = 'tree_selected';
        	link = document.getElementById('doc_'+selected_doc);
        	link.className = 'tree';
        	selected_doc = doc_id;
        }
}

</script>

<tr>
  <td valign="top"><span class="cat"><img src="img/arrow.gif" brder="0" vspace="2"> Имя отображаемого<br /><img src="img/spacer.gif" border="0" alt="" height="1" width="7" /> документа</span></td>
  <td valign="top">{LINK_DOC}</td>
</tr>
<tr>
  <td valign="top"><span class="cat"><img src="img/arrow.gif" brder="0" vspace="2"> Внешняя ссылка *</span></td>
  <td><input type="text" class="com_input" name="link_external" value="{LINK_EXTERNAL}" style="width: 250px;"></td>
</tr>
<tr>
  <td valign="top" nowrap="nowrap"><span class="cat"><img src="img/arrow.gif" border="0" vspace="2"> Изменить отображаемый<br /><img src="img/spacer.gif" border="0" alt="" height="1" width="7" /> документ **</span></td>
  <td width="100%">
    <input type="text" name="linkid" id="doccode" value="{LINK_CODE}" class="com_input"> редирект на ссылку (Да?) <input name="check_yes" type="checkbox" value="1"{CHECK_VALUE}><br>
    {LINK_TREE} 
  </td>
</tr>
<tr>
  <td colspan="2"><span class="com_link">* Переход по внешней ссылке будет осуществляться только в том случае, если не установлен документ для отображения<br>
                                 ** Необходимо ввести код документа или выбрать документ из списка</span></td>
</tr>
<script>
OpenTree({LINK_ID}, true)
</script>
