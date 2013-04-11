<?
global $engine_htroot, $parent_doc;

ob_start();

if (empty($fun_name))
{
	$fun_name = 'SetCode';
}
?>
<script>
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

function SetDocInfo(doc_id, doc_pid, doc_name, doc_type, doc_ord, doc_code)
{
        docs[doc_id] = [doc_id, doc_pid, doc_name, doc_type, doc_ord, doc_code];
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
		{
			link.className = 'tree';
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
                                img = '<a href="#" onclick="javascript:OpenFolder('+doc_id+')"><img src="'+doc_img.src+'" hspace="3" vspace="3" style="margin-left: 1px;" border="0" id="img_'+doc_id+'"></a>';
                        }
                        else
                        {
                                img = '<a href="#" onclick="javascript:OpenFolder('+doc_id+')"><img src="img/plus.gif" hspace="3" vspace="3" style="margin-left: 1px;" border="0" id="img_'+doc_id+'"></a>';
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
	{
		link.className = 'tree';
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
                res += '<tr><td><img src="img/doc_root.gif" border="0"></td><td colspan="2" class="tree_td" width="100%"><a href="#" onclick="javascript:<?=$fun_name?>(-1)" id="doc_-1" class="tree">Корень</a></td></tr>';
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
                                img = '<a href="#" onclick="javascript:OpenFolder('+doc_id+')"><img src="img/plus.gif" hspace="3" vspace="3" style="margin-left: 1px;" border="0" id="img_'+doc_id+'"></a>';
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
                        res += '<tr><td align="center" style="background: url(\'img/line_'+line_id+'.gif\');" valign="top" id="doc_ico_'+doc_id+'">'+img+'</td><td valign="top" id="doc_style_'+doc_id+'"><img id="doc_img_'+doc_id+'" src="img/doc_'+doc[3]+'.gif" border="0"></td><td width="100%" class="tree_td"><a id="doc_'+doc_id+'" href="#" onclick="javascript:<?=$fun_name?>('+doc_id+');" class="tree">'+doc[2]+'</a></td></tr>';

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
</script>

<table cellpadding="0" cellspacing="0" border="0" class="line_blue" width="100%">
<tr><td>
<div style="height:300px; width: 100%; overflow-y: scroll; padding: 3px;" id="inner_-1" id="docs_tree" class="docs_tree">
<script type="">
var doc_types = new Array ();
var doc_pids  = new Array ();
var docs      = new Array ();

docs[-1] = ['-1', '', 'Корень', 'root', '0', '0'];

<?

$tree = '
';

$sql = "SELECT id, pid, name, type, ord, code
        FROM engine_documents
        WHERE type NOT IN ('')
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
			$temp_str .= "['".$doc['id']."', '".$doc['pid']."', '".addslashes($doc['name'])."', '".strtolower($doc['type'])."', '".$doc['ord']."', '".addslashes(strtolower($doc['code']))."'];\n";
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
</script>
</div>
</td></tr></table>
<?

$tree = ob_get_contents();
ob_clean();
?>