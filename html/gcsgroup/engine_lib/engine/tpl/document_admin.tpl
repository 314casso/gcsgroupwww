<!DOCTYPE html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<HTML>
<head>
  <LINK href="main.css" rel="stylesheet" type="text/css">
  <META content="text/html; charset=windows-1251" http-equiv="Content-Type">
</head>
<body style="margin: 5px;">
<script>
var selected_id = 'spec';

function ShowTable(table_id)
{
        table = document.getElementById('table_'+selected_id);
        table.style.display = 'none';
        td    = document.getElementById('td_'+selected_id);
        td.className = 'td_bookmark_off';

        table = document.getElementById('table_'+table_id);
        table.style.display = '';
        td    = document.getElementById('td_'+table_id);
        td.className = 'td_bookmark_on';

        selected_id = table_id;
}
</script>

<table cellspacing="1" cellpadding="3" border="0" width="100%" class="line">
  <tr><th colspan="5" align="left">&nbsp;&nbsp;&nbsp;{DOC_NAME}</th></tr>
  <tr>
    <th class="row2" width="20%">Дата создания</th>
    <th class="row2" width="20%">Тип</th>
    <th class="row2" width="20%">Шаблон</th>
    <th class="row2" width="20%">ID документа</th>
    <th class="row2" width="20%">Код документа</th>
  </tr>
  <tr>
    <td align="center"><u class="com_link">{DOC_CREATION_DATE}</u></td>
    <td align="center"><u class="com_link">{DOC_TYPE}</u></td>
    <td align="center"><u class="com_link">{DOC_TEMPLATE}</u></td>
    <td align="center"><u class="com_link">{DOC_ID}</u></td>
    <td align="center"><u class="com_link">{DOC_CODE}</u></td>
  </tr>
  <tr><td colspan="5" class="row2">{DOC_LAST_ACTION}</td></tr>
</table>

<table cellspacing="0" cellpadding="0" border="0" style="margin-top: 8px;">
  <tr>
    <td>
      <table cellspacing="1" cellpadding="3" border="0" class="table_bookmark">
        <tr><td class="td_bookmark_on" align="center" id="td_spec" nowrap="nowrap">&nbsp;<a href="javascript:ShowTable('spec');" class="doc_menu">{DOC_TYPE}</a>&nbsp;</td></tr>
      </table>
    </td>
    <td>
      <table cellspacing="1" cellpadding="3" border="0" class="table_bookmark">
        <tr><td class="td_bookmark_off" align="center" id="td_doc">&nbsp;<a href="javascript:ShowTable('doc');" class="doc_menu">Документ</a>&nbsp;</td></tr>
      </table>
    </td>
    <td>
      <table cellspacing="1" cellpadding="3" border="0" class="table_bookmark">
        <tr><td class="td_bookmark_off" align="center" id="td_rubrique">&nbsp;<a href="javascript:ShowTable('rubrique');" class="doc_menu">Рубрики</a>&nbsp;</td></tr>
      </table>
    </td>
    <td>
      <table cellspacing="1" cellpadding="3" border="0" class="table_bookmark">
        <tr><td class="td_bookmark_off" align="center" id="td_rights">&nbsp;<a href="javascript:ShowTable('rights');" class="doc_menu">Права</a>&nbsp;</td></tr>
      </table>
    </td>
  </tr>
</table>
<FORM name="editor" method="post" action='?action=showdoc' onSubmit='{SUBMIT}' enctype="multipart/form-data" style="margin: 0px; padding: 0px;">
  <input type="hidden" name="do" value=1>
  <input type="hidden" name="id" value="{DOC_ID}">
  <input type="hidden" name="page" value="{PAGE}">
<table cellspacing="1" cellpadding="3" border="0" width="100%" class="line" style="margin-top: 10px;" id="table_spec">
  <tr><td>{DOC_SPEC}</td></tr>
</table>

<table cellspacing="1" cellpadding="3" border="0" width="100%" class="line" style="margin-top: 10px; display: none;" id="table_doc">
  <tr>
    <td align="center">
      <table>
        <tr>
          <td><span class="cat"><img src="img/arrow.gif" brder="0" vspace="2"> Шаблон</span></td>
          <td><span class="cat"><img src="img/arrow.gif" brder="0" vspace="2"> Стиль</span></td>
          <td><span class="cat"><img src="img/arrow.gif" brder="0" vspace="2"> Код</span></td>
        </tr>
        <tr>
          <td>
            <select name="tpldoc" class="com_input">
            <!-- BEGIN DYNAMIC BLOCK: doc_tpl -->
              <option value="TPL_ID" TPL_SELECTED>TEXT</OPTION>
            <!-- END DYNAMIC BLOCK: doc_tpl -->
            </select>
          </td>
          <td>
            <select name="doc_style" class="com_input">
            <!-- BEGIN DYNAMIC BLOCK: doc_style -->
              <option value="STL_ID" STYLE_SELECTED>STYLE_NAME</option>
            <!-- END DYNAMIC BLOCK: doc_style -->
            </select>
          </td>
          <td>
            <input type="text" name="code" value="{DOC_CODE}" class="com_input">
          </td>
        </tr>
      </table>
    </td>
  </tr>
  <tr><td>
    <table>
      <tr><td><input type="checkbox" id="undeletable" name="undeletable" {DOC_UNDELETABLE}></td><td><span class="cat"><label for="undeletable">Не может быть удален</label></span></td></tr>
      <tr><td><input type="checkbox" id="visible" name="visible" {DOC_VISIBLE}></td><td><span class="cat"><label for="visible">Отображать</label></span></td></tr>
      <tr><td><input type="checkbox" id="private" name="private" {DOC_PRIVATE}></td><td><span class="cat"><label for="private">Для зарегистрированных</label></span></td></tr>
    </table>
  </td></tr>
  <tr><td><span class="cat"><img src="img/arrow.gif" brder="0" vspace="2"> Название</span></td></tr>
  <tr><td><input type="text" name="name_" value="{DOC_NAME}" class="com_input" style="width: 350px;"></td></tr>

  <tr><td><span class="cat"><img src="img/arrow.gif" brder="0" vspace="2"> Заголовок короткий</span></td></tr>
  <tr><td><textarea name="caption_short" style="width: 500px;" rows="5">{DOC_CAPT_S}</textarea></td></tr>

  <tr><td><span class="cat"><img src="img/arrow.gif" brder="0" vspace="2"> Заголовок средний</span></td></tr>
  <tr><td><textarea name="caption_medium" style="width: 500px;" rows="5">{DOC_CAPT_M}</textarea></td></tr>

  <tr><td><span class="cat"><img src="img/arrow.gif" brder="0" vspace="2"> Заголовок длинный</span></td></tr>
  <tr><td><textarea name="caption_long" style="width: 500px;" rows="5">{DOC_CAPT_L}</textarea></td></tr>

  <tr><td><span class="cat"><img src="img/arrow.gif" brder="0" vspace="2">Резюме</span></td></tr>
  <tr><td><textarea name="resume" style="width: 500px;" rows="7">{DOC_RESUME}</textarea></td></tr>

  <tr>
    <td align="center">
      <table>
        <tr>
          <td><span class="cat"><img src="img/arrow.gif" brder="0" vspace="2"> Изображение (активное состояние)</span></td>
          <td><span class="cat"><img src="img/arrow.gif" brder="0" vspace="2"> Изображение (неактивное состояние)</span></td>
        </tr>
        <tr>
          <td><IMG src="{DOC_ACTIMG}" alt="" border="0"></td>
          <td><IMG src="{DOC_UNACTIMG}" alt="" border="0"></td>
        </tr>
        <tr>
          <td><input type="file" name="actimg" class="com_input"></td>
          <td><input type="file" name="unactimg" class="com_input"></td>
        </tr>
      </table>
    </td>
  </tr>
</table>

<table cellspacing="1" cellpadding="2" border="0" width="100%" class="line" style="margin-top: 10px; display: none;" id="table_html">
  <tr><td><span class="cat"><img src="img/arrow.gif" brder="0" vspace="2"> Meta</span></td></tr>
  <tr><td><textarea name="meta" style="width: 500px;" rows="5">{DOC_META}</textarea></td></tr>
  <input type="hidden" name="title_old" value="{DOC_TITLE_OLD}">

  <tr><td><span class="cat"><img src="img/arrow.gif" brder="0" vspace="2"> Title</span></td></tr>
  <tr><td><input class="com_input" name="title" value="{DOC_TITLE}" style="width: 500px;"></td></tr>

  <tr><td><span class="cat"><img src="img/arrow.gif" brder="0" vspace="2"> Счетчик №1</span></td></tr>
  <tr><td><textarea name="counter1" style="width: 500px;" rows="5">{DOC_COUNTER1}</textarea></td></tr>

  <tr><td><span class="cat"><img src="img/arrow.gif" brder="0" vspace="2"> Счетчик №2</span></td></tr>
  <tr><td><textarea name="counter2" style="width: 500px;" rows="5">{DOC_COUNTER2}</textarea></td></tr>

  <tr><td><span class="cat"><img src="img/arrow.gif" brder="0" vspace="2"> Счетчик №3</span></td></tr>
  <tr><td><textarea name="counter3" style="width: 500px;" rows="5">{DOC_COUNTER3}</textarea></td></tr>
</table>

<table cellspacing="1" cellpadding="3" border="0" width="100%" class="line" style="margin-top: 10px; display: none;" id="table_rubrique">
  <tr><td>
  {DOC_RUBRIQUE}
  PRODLINK
  DOC_PROD
  </td></tr>
</table>

<table cellspacing="1" cellpadding="3" border="0" width="100%" class="line" style="margin-top: 10px; display: none;" id="table_rights">
  <tr><td>
  {DOC_RIGHTS}
  </td></tr>
</table>

<input type="submit" value="Сохранить" class="com_button" style="margin-top: 10px;">
</FORM>
</body>
</html>