<?php

/*
 * @Descr Панель дополнительных инструментов (tools)
 *  $Id: tools.php,v 1.7 2004/12/27 13:12:58 dave Exp $
 *
 *  $Log: tools.php,v $
 *  Revision 1.7  2004/12/27 13:12:58  dave
 *  Переформатирование кода
 *
 *  Revision 1.6  2004/12/27 13:08:42  dave
 *  Переформатирование кода
 *
 */

?>
<SCRIPT LANGUAGE="JavaScript">
var proc = window.parent.proc;
var selected_id = -1;
window.parent.view.document.location = 'view.php';

function GetInfo(tool_id, doc)
{	window.parent.view.document.location=doc;
	window.parent.proc.document.location='proc.php';

	if (selected_id >= 0)
	{		doc = document.getElementById('tool_'+selected_id);
		doc.className = 'tree';	}

	if (tool_id >= 0)
	{		doc = document.getElementById('tool_'+tool_id);
		doc.className = 'tree_selected';	}
	selected_id = tool_id;
}

document.execCommand("2D-Position", true, true);
document.execCommand("MultipleSelection", true, true);
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
  <tr><td height="100%">
    <table cellpadding="0" cellspacing="0" border="0" style="margin-top: 5px;" class="line_blue" width="100%" height="100%">
      <tr>
        <td valign="top">
        <div style="height:100%; width: 100%; overflow-y: scroll; overflow-x: scroll; padding: 3px;">
        <table width="100%" cellpadding="0" cellspacing="0" border="0">
          <tr><td><img src="img/doc_root.gif" border="0"></td><td colspan="2" width="100%" class="tree_td"><span class="tree">Список расширений</span></td></tr>
			<?php
			// разблокируем документы
			$sql = 'UPDATE engine_documents
			        SET opened=0
			        WHERE opener="'.$logged['id'].'"';

			$result = mysql_query("$sql");

			$tools_count = 0;
			$handle = opendir($engine_show_root.'/engine/tools');
			while (false !== ($tool = readdir($handle)))
			{				if ($tool != "." && $tool != ".." && is_dir($engine_show_root.'/engine/tools/'.$tool))
				{					$filename = $engine_show_root.'/engine/tools/'.$tool.'/name.txt';
					if (file_exists($filename))
					{						$tools_count++;
					}
				}
			}
			closedir($handle);
			if ($logged['role'] == 'Администратор'){

				$handle = opendir($engine_show_root.'/engine_lib/tools');
				while (false !== ($tool = readdir($handle))){

					if ($tool != "." && $tool != ".." && is_dir($engine_show_root.'/engine_lib/tools/'.$tool)){								$filename =$engine_show_root.'/engine_lib/tools/'.$tool.'/name.txt';
						if (file_exists($filename)){                               			
							$tools_count++;
						}
					}
				}
				closedir($handle);
				$handle = opendir($engine_show_root.'/engine_lib/tools');
				while (false !== ($tool = readdir($handle))){				
					if ($tool != "." && $tool != ".." && is_dir($engine_show_root.'/engine_lib/tools/'.$tool)){								$filename = $engine_show_root.'/engine_lib/tools/'.$tool.'/name.txt';
						if (file_exists($filename)){
						$file_array = file($filename);
						$tool_name = $file_array[0];
						$tool_link = $engine_show_htroot.'/engine_lib/tools/'.$tool.'/'.$file_array[1];

						$tools_count--;
		            			if ($tools_count > 0)
                				{
                					$line_id = 2;
                				}
                				else
                				{
                					$line_id = 3;
                				}
                				echo '<tr><td align="center" style="background: url(\'img/line_'.$line_id.'.gif\');" valign="top"><img src="img/spacer.gif" border="0" width="16" height="1"></td><td valign="top"><img src="img/doc_textdoc.gif" border="0"></td><td width="100%" class="tree_td"><a id="tool_'.$tools_count.'" href="javascript:GetInfo('.$tools_count.', \''.$tool_link.'\');" class="tree">'.$tool_name.'</a></td></tr>'."\n";
					}
				}
			}
			closedir($handle);
                     }
			$handle = opendir($engine_show_root.'/engine/tools');
			while (false !== ($tool = readdir($handle))){				
				if ($tool != "." && $tool != ".." && is_dir($engine_show_root.'/engine/tools/'.$tool))
				{					$filename = $engine_show_root.'/engine/tools/'.$tool.'/name.txt';
					if (file_exists($filename))
					{
						$file_array = file($filename);
						$tool_name = $file_array[0];
						$tool_link = $engine_show_htroot.'/engine/tools/'.$tool.'/'.$file_array[1];

						$tools_count--;
		            			if ($tools_count > 0)
                				{
                					$line_id = 2;
                				}
                				else
                				{
                					$line_id = 3;
                				}
                				echo '<tr><td align="center" style="background: url(\'img/line_'.$line_id.'.gif\');" valign="top"><img src="img/spacer.gif" border="0" width="16" height="1"></td><td valign="top"><img src="img/doc_textdoc.gif" border="0"></td><td width="100%" class="tree_td"><a id="tool_'.$tools_count.'" href="javascript:GetInfo('.$tools_count.', \''.$tool_link.'\');" class="tree">'.$tool_name.'</a></td></tr>'."\n";
					}
				}
			}
			closedir($handle);
			?>
        </table>
        </div>
        </td>
      </tr>
    </table>
  </td></tr>
</table>