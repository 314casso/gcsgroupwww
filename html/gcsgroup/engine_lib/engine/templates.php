<SCRIPT LANGUAGE="JavaScript">
var proc=window.parent.proc;
var selected_doc = -1;

function GetInfo(doc_id)
{
        if (window.parent.view.document.location != 'view.php?action=tpl&id='+doc_id)
        {
                window.parent.view.document.location = 'view.php?action=tpl&id='+doc_id;
        }

        window.parent.proc.document.location='proc.php';

        link = document.getElementById('doc_'+doc_id);
        link.className = 'tree_selected';
        if (selected_doc != -1)
        {
                link = document.getElementById('doc_'+selected_doc);
                link.className = 'tree';
        }
        selected_doc = doc_id;
}

document.execCommand("2D-Position", true, true);
document.execCommand("MultipleSelection", true, true);

function CreateTpl()
{
        proc.document.location = "proc.php?action=newtpl&pid="+selected_doc;
}

function DeleteTpl()
{
        if (selected_doc != -1)
        {
                proc.document.location = "proc.php?action=deltpl&id="+selected_doc;
        }
}

</SCRIPT>
<table height="100%" width="100%" cellpadding="0" cellspacing="0" border="0">
  <tr><td>
    <table cellpadding="3" cellspacing="1" border="0" style="margin-top: 5px;" class="line_blue" width="100%">
      <tr>
        <td class="td_blue2">
        <table cellpadding="0" cellspacing="0" border="0">
          <tr>
            <td width="26" align="center"><a href="menu.php"><img src="img/ico_1.gif" alt="Дерево документов" border="0"></a></td>
            <td width="26" align="center"><a href="menu.php?action=rubrique"><img src="img/ico_2.gif" alt="Рубрикатор" border="0"></a></td>
            <?
            if ($logged['role'] == 'Администратор')
            {
            ?>
            <td width="26" align="center"><a href="menu.php?action=group"><img src="img/ico_8.gif" alt="Польователи" border="0"></a></td>
            <?
            }
            ?>
            <td width="26" align="center"><a href="menu.php?action=tools"><img src="img/ico_3.gif" alt="Инструменты" border="0"></a></td>
            <td width="26" align="center"><a href="menu.php?action=send"><img src="img/ico_4.gif" alt="Рассылки" border="0"></a></td>
            <td width="26" align="center"><a href="menu.php?action=forum"><img src="img/ico_5.gif" alt="Форум" border="0"></a></td>
            <?
            if ($logged['role']=='Разработчик')
            {
            ?>
            <td width="26" align="center"><a href="menu.php?action=tpl"><img src="img/ico_7.gif" alt="Шаблоны" border="0"></a></td>
            <td width="26" align="center"><a href="menu.php?action=style"><img src="img/ico_6.gif" alt="Стили" border="0"></a></td>
            <?
            }
            if ($logged['role'] == 'Администратор')
            {
            ?>
            <td width="26" align="center"><a href="menu.php?action=log"><img src="img/ico_9.gif" alt="Логи" border="0"></a></td>
            <?
            }
            ?>
          </tr>
        </table>
        </td>
      </tr>
    </table>
  </td></tr>
  <tr><td>
    <table cellpadding="3" cellspacing="1" border="0" style="margin-top: 5px;" class="line_blue" width="100%">
      <tr>
        <td class="td_blue2">
          <table cellpadding="0" cellspacing="0" border="0">
            <tr>
              <td width="36" align="center"><a href="javascript: CreateTpl();"><img src="img/act_2.gif" alt="Создать документ" border="0"></a></td>
              <td width="36" align="center"><a href="javascript: DeleteTpl()"><img src="img/act_4.gif" alt="Удалить" border="0"></a></td>
            </tr>
          </table>
        </td>
      </tr>
    </table>
  </td></tr>
  <tr><td><img src="img/spacer.gif" alt="" border="0" width="1" height="5" /></td></tr>
  <tr><td height="100%">
    <table cellpadding="0" cellspacing="0" border="0"class="line_blue" width="100%" height="100%">
      <tr>
        <td valign="top">
        <div style="height:100%; width: 100%; overflow-y: scroll; overflow-x: scroll; padding: 3px;">
        <table width="100%" cellpadding="0" cellspacing="0" border="0">
        <?
        $sql = "SELECT *
                  FROM engine_tpl
                ORDER BY name";

        $result = mysql_query($sql);

        $size = mysql_num_rows($result);
        ?>
          <tr><td><img src="img/doc_root.gif" border="0"></td><td colspan="2" width="100%" class="tree_td"><span class="tree">Список шаблонов (<?=$size;?>)</span></td></tr>
        <?
        $i = 0;
        while($row = mysql_fetch_array($result))
        {
                $i++;
                if ($size == $i)
                {
                        $line_id = 3;
                }
                else
                {
                        $line_id = 2;
                }
                echo '<tr><td align="center" style="background: url(\'img/line_'.$line_id.'.gif\');" valign="top"><img src="img/spacer.gif" border="0" width="16" height="1"></td><td valign="top"></td><td width="100%" class="tree_td"><a id="doc_'.$row['id'].'" href="javascript:GetInfo('.$row['id'].');" class="tree"><img src="img/doc_textdoc.gif" border="0" style="vertical-align:middle;margin-right: 2px;">'.$row['name'].'</a></td></tr>';

        }
        ?>
        </table>
        </div>
        </td>
      </tr>
    </table>
  </td></tr>
</table>
