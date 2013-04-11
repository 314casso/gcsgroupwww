<script type="text/javascript">
var proc=window.parent.proc;
var move_to=window.parent.move_to;

var selected_doc = -1;

function GetInfo(doc_id)
{
        if (window.parent.view.document.location!='view.php?action=showdoc&id='+doc_id)
        {
                window.parent.view.document.location='view.php?action=showdoc&id='+doc_id;
        }

        window.parent.proc.document.location='proc.php';
        window.parent.move_to.document.location='moveto.php';

        if (doc_id != selected_doc)
        {           link = document.getElementById('doc_'+doc_id);
            link.className = 'tree_selected';
            link = document.getElementById('doc_'+selected_doc);
            link.className = 'tree';
            selected_doc = doc_id;
        }
}

document.execCommand("2D-Position", true, true);
document.execCommand("MultipleSelection", true, true);

function OpenFolder(folder_id, open)
{
        td = document.getElementById('inner_'+folder_id);
        if (td.innerHTML == '')
        {
                td.innerHTML = DrawTree(folder_id);
        }

        folder  = document.getElementById('folder_'+folder_id);
        image   = document.getElementById('img_'+folder_id);
        doc_img = document.getElementById('doc_img_'+folder_id);
        doc_stl = document.getElementById('doc_style_'+folder_id);

        if (folder.style.display == 'none')
        {
                folder.style.display = '';
                image.src = 'img/minus.gif';

                doc_stl.className = 'line_1_1';
                if (doc_img.src.indexOf('img/doc_folder.gif') >= 0)
                {
                        doc_img.src = 'img/doc_folder_open.gif';
                }
        }
        else
        {
                if (open != true)
                {
                        folder.style.display = 'none';
                        image.src = 'img/plus.gif';
                        doc_stl.className = '';
                        if (doc_img.src.indexOf('img/doc_folder_open.gif') >= 0)
                        {
                                doc_img.src = 'img/doc_folder.gif';
                        }
                }
        }
}

function GetDocInfo(doc_id)
{
        return docs[doc_id];
}

function SetDocInfo(doc_id, doc_pid, doc_name, doc_type, doc_ord)
{
        docs[doc_id] = [doc_id, doc_pid, doc_name, doc_type, doc_ord];
}

function OpenTree(doc_id, open_it)
{
        open_it = true;
        var docs_to_open = new Array();
        if (doc_id > 0)
        {
                var k = 0;
                doc = GetDocInfo(doc_id);

                while ((doc[1] != -1)&&(k<10))
                {
                        docs_to_open[k] = doc[1];
                        doc = GetDocInfo(doc[1]);
                        k++;
                }

                for(k=k-1; k>=0; k--)
                {
                        OpenFolder(docs_to_open[k], true);
                        cur_doc = docs_to_open[k];
                }

                if (open_it)
                {
                        if (doc_types[doc_id] == 'folder')
                        {
                                OpenFolder(doc_id, true);
                                cur_doc = doc_id;
                        }
                }

                link = document.getElementById('doc_'+cur_doc);
                link.className = 'tree_selected';

        link = document.getElementById('doc_'+selected_doc);

        if (link)
        {           link.className = 'tree';
        }
                selected_doc = cur_doc;
        }
}

function ReDrawDoc(folder_id)
{
        doc_id = folder_id;
        doc = GetDocInfo(doc_id);

        ico = document.getElementById('doc_ico_'+doc_id);
        if (ico)
        {
                if (doc_pids[doc_id])
                {
                        par = true;
                        doc_img = document.getElementById('img_'+doc_id);
                        if (doc_img)
                        {
                                img = '<a href="javascript:OpenFolder('+doc_id+')"><img src="'+doc_img.src+'" hspace="3" vspace="3" style="margin-left: 1px;" border="0" id="img_'+doc_id+'"></a>';
                        }
                        else
                        {
                                img = '<a href="javascript:OpenFolder('+doc_id+')"><img src="img/plus.gif" hspace="3" vspace="3" style="margin-left: 1px;" border="0" id="img_'+doc_id+'"></a>';
                        }
                }
                else
                {
                        par = false;
                        img = '<img src="img/spacer.gif" border="0" width="16" height="1">';
                }
                ico.innerHTML = img;
        }
        folder = document.getElementById('inner_'+doc_id);
        folder.innerHTML = DrawTree(doc_id);

        OpenTree(doc_id);

        link = document.getElementById('doc_'+selected_doc);

    if (link)
    {       link.className = 'tree';
        link = document.getElementById('doc_'+doc_id);
                link.className = 'tree_selected';
    }
    selected_doc = doc_id;
}

function DrawTree(folder_id)
{
        var i = 0;
        var res = '';
        var par = false;
        var doc_id = 0;
        var img = '';
        var line_id = 0;
        var style = '';
        var style2 = '';

        res += '<table width="100%" cellpadding="0" cellspacing="0" border="0">';

        if (folder_id == -1)
        {
                res += '<tr><td><img src="img/doc_root.gif" border="0"></td><td colspan="2" class="tree_td" width="100%"><a href="javascript:GetInfo(-1)" id="doc_-1" class="tree_selected">Корень</a></td></tr>';
        }

        if (doc_pids[folder_id])
        {
                while(doc_pids[folder_id][i])
                {
                        doc_id = doc_pids[folder_id][i];
                        doc = GetDocInfo(doc_id);

                        doc_types[doc_id] = doc[3];
                        if (doc_pids[doc_id])
                        {
                                par = true;
                                img = '<a href="javascript:OpenFolder('+doc_id+')"><img src="img/plus.gif" hspace="3" vspace="3" style="margin-left: 1px;" border="0" id="img_'+doc_id+'"></a>';
                        }
                        else
                        {
                                par = false;
                                img = '<img src="img/spacer.gif" border="0" width="16" height="1">';
                        }

                        if (doc_pids[folder_id][i+1])
                        {
                                line_id = 2;
                        }
                        else
                        {
                                line_id = 3;
                        }
                        doc[2] = (doc[2] == '') ? '&nbsp;' : doc[2];
                        res += '<tr><td align="center" style="background: url(\'img/line_'+line_id+'.gif\');" valign="top" id="doc_ico_'+doc_id+'">'+img+'</td><td valign="top" id="doc_style_'+doc_id+'"><a href="#" onclick="javascript:GetInfo('+doc_id+');"><img id="doc_img_'+doc_id+'" src="img/doc_'+doc[3]+'.gif" border="0"></a></td><td width="100%" class="tree_td"><a id="doc_'+doc_id+'" href="#" onclick="javascript:GetInfo('+doc_id+');" class="tree">'+doc[2]+'</a></td></tr>';

                        if ((par)||(doc[3] == 'folder'))
                        {
                                if (line_id == 3)
                                {
                                        style = '';
                                }
                                else
                                {
                                        style = ' style="background: url(\'img/line_1.gif\');"';
                                }
                                res += '<tr style="display: none;" id="folder_'+doc_id+'"><td'+style+'><img src="img/spacer.gif" border="0" width="16" height="1"></td><td colspan="2" id="inner_'+doc_id+'"></td></tr>';
                        }
                        i++;
                }
        }
        res += '</table>';

        return res;
}

function CreateFolder()
{
        if ((doc_types[selected_doc] == 'folder')||(selected_doc == -1))
        {
                window.showModalDialog("actions.php?action=newfolder&pid="+selected_doc, window, "dialogHeight: 500px; dialogWidth: 300px; center: Yes; scroll: No; help: No;");
        }
        else
        {
                alert('Вы можете создать папку только в другой папке');
        }
}

function CreateDoc()
{   if ((doc_types[selected_doc] == 'folder')||(selected_doc == -1))
    {
        window.showModalDialog("actions.php?action=newdoc&pid="+selected_doc, window, "dialogHeight: 500px; dialogWidth: 300px; center: Yes; scroll: No; help: No;");
    }
        else
        {
                alert('Вы можете создать документ только в папке');
        }
}

function MoveDoc()
{
        if (selected_doc != -1)
        {
                move_to.document.location="moveto.php?action=choose&id="+selected_doc;
        }
        else
        {
                alert('Вы не можете переместить корневой каталог');
        }
}

function DeleteDoc()
{   if (selected_doc != -1)
    {
        window.showModalDialog("actions.php?action=deldoc&id="+selected_doc,window,"dialogHeight:500px;dialogWidth:300px;center:Yes; scroll: No; help: No;");
    }
    else
    {       alert('Вы не можете удалить корневую папку');
    }}
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
              <td><a href="javascript: CreateFolder();"><img src="img/act_1.gif" alt="Создать папку" border="0" hspace="3" /></a></td>
              <td><a href="javascript: CreateDoc();"><img src="img/act_2.gif" alt="Создать документ" border="0" hspace="3" /></a></td>
              <td><a href="javascript: MoveDoc();"><img src="img/act_3.gif" alt="Переместить" border="0" hspace="3" /></a></td>
              <td><a href="javascript: DeleteDoc();"><img src="img/act_4.gif" alt="Удалить" border="0" hspace="3" /></a></td>

              <td width="100%">&nbsp;</td>

              <td><a href="#"><img src="img/act_5.gif" alt="Настройки (не работает)" border="0" hspace="3" /></a></td>
              <td><a href="#"><img src="img/act_6.gif" alt="Обновить деревно (не работает)" border="0" hspace="3" /></a></td>
              <td></td>
            </tr>
          </table>
        </td>
      </tr>
    </table>
  </td></tr>
  <tr><td><img src="img/spacer.gif" height="5" width="1" alt="" border="0" /></td></tr>
  <tr><td height="100%">
    <table cellpadding="0" cellspacing="0" border="0" class="line_blue" width="100%" height="100%">
      <tr>
        <td valign="top">
        <div style="height:100%; width: 100%; overflow-y: scroll; overflow-x: scroll; padding: 3px;" id="inner_-1">
          <script type="">
          var doc_types = new Array ();
          var doc_pids  = new Array ();
          var docs      = new Array ();

docs[-1] = ['-1', '', 'Корень', 'root', '0'];
          <?
          $sql = "SELECT id, pid, name, type, ord
                  FROM engine_documents
                  WHERE type NOT IN ('CATALOGITEM', 'NEW')
                  ORDER BY ord, name, creation_date DESC";

          $result = mysql_query($sql);

          if (mysql_num_rows($result) > 0)
          {
                  while($row = mysql_fetch_array($result, MYSQL_ASSOC))
                  {
                          $docs[$row['pid']][] = $row;
                  }

                  foreach($docs as $pid => $documents)
                  {
                          $temp_str = '';
                          foreach($documents as $is => $doc)
                          {
                                  $temp_str .= "docs[".$doc['id']."] = ";
                                  $temp_str .= "['".$doc['id']."', '".$doc['pid']."', '".addslashes($doc['name'])."', '".strtolower($doc['type'])."', '".$doc['ord']."'];\n";
                          }
                          echo $temp_str;
                  }

                  foreach($docs as $pid => $documents)
                  {
                          $temp_str = '';
                          $temp_str .= "doc_pids[".$pid."] = new Array(";
                          foreach($documents as $is => $doc)
                          {
                                  $temp_str .= "'".$doc['id']."', ";
                          }
                          $temp_str = substr($temp_str, 0, -2);
                          $temp_str .= ");\n";
                          echo $temp_str;
                  }
          }
          ?>
          document.write(DrawTree(-1));
          //OpenTree(selected_doc);
          </script>
        </div>
        </td>
      </tr>
    </table>
  </td></tr>
</table>