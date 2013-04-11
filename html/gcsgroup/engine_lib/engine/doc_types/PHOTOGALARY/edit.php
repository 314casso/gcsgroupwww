<?php

/*
 *  $Id: edit.php,v 1.5 2004/12/28 17:49:42 dave Exp $
 *
 *  $Log: edit.php,v $
 *  Revision 1.5  2004/12/28 17:49:42  dave
 *  Исправлен невывод списка при незаданных rows и cols
 *
 */

$page = intval($_REQUEST['page']);;

if ($parent_doc_spec['cols'] == 0)
{
        $parent_doc_spec['cols'] = 3;
}

if ($parent_doc_spec['rows'] == 0)
{
        $parent_doc_spec['rows'] = 3;
}

$sql = 'SELECT *
        FROM engine_PHOTOGALARY_cells
        WHERE gal_id='.$id.'
        ORDER BY ord
        LIMIT '.$page.','.($parent_doc_spec['rows'] * $parent_doc_spec['cols']);

if (!$result = mysql_query($sql))
{
        die($sql);
}

while ($row = mysql_fetch_array($result, MYSQL_ASSOC))
{
        if (file_exists($engine_show_root.'/engine/pics/PHOTOGALARY/spic'.$row['id'].'.jpg'))
        {
                $spic = '/engine/pics/PHOTOGALARY/spic'.$row['id'].'.jpg';
        }
        elseif (file_exists($engine_show_root.'/engine/pics/PHOTOGALARY/spic'.$row['id'].'.gif'))
        {
                $spic = '/engine/pics/PHOTOGALARY/spic'.$row['id'].'.gif';
        }
        else
        {
                $spic = "/engine_lib/engine/img/1x1.gif";
                $sz = " width=120 height=100 ";
        }

        if (file_exists($engine_show_root.'/engine/pics/PHOTOGALARY/bpic'.$row['id'].'.jpg'))
        {
                $bpic = '/engine/pics/PHOTOGALARY/bpic'.$row['id'].'.jpg';
        }
        elseif (file_exists($engine_show_root.'/engine/pics/PHOTOGALARY/bpic'.$row['id'].'.gif'))
        {
                $bpic = '/engine/pics/PHOTOGALARY/bpic'.$row['id'].'.gif';
        }
        else
        {
                $bpic = $engine_show_htroot.'/engine_lib/engine/img/1x1.gif';
        }

        $PICS .= '<tr class="row'.((++$i % 2)+1).'">
  <td><a href="#" onclick="{window.open(\''.$engine_show_htroot.$bpic.'\');return false;}"> <img border="0" '.$sz.' src="'.$engine_show_htroot.$spic.'?'.filesize($engine_show_root.$spic).'"></a></td>
  <td>'.$row['text1'].'<br>'.$row['text2'].'<br>'.$row['text3'].'</td>
  <td align="center">
                        <img style="cursor:hand"
                        onclick="showdlg('.$row['id'].',\'' . addslashes($row['text1']) . '\',\'' . addslashes($row['text2']) . '\',\'' . addslashes($row['text3']) . '\','.$row['ord'].');"
                        src="img/edit.gif">
                        </td>
                        <td>
                        <img style="cursor:hand"
                        onclick="{
                        document.all.cellid.value='.$row['id'].';
                        document.all.delcell.value=\'1\';
                        document.all.editor.submit();
                        }"
                        src="img/del.gif">
                        </td>
                        </td>

  </td>
</tr>
';
        /*
             onMouseOver='this.src=\"$engine_show_htroot/engine/pics/PHOTOGALARY/bpic$f[id].jpg\"'
             onMouseLeave='this.src=\"$engine_show_htroot/engine/pics/PHOTOGALARY/spic$f[id].jpg\"'

    <table>
                        <td>
                        <img style=\"cursor:hand\"
                        onclick=`showdlg($f[id],'" . str_replace("'", "\\'", $f[text1]) . "','" . str_replace("'", "\\'", $f[text2]) . "','" . str_replace("'", "\\'", $f[text3]) . "',$f[ord])`
                        src='img/edit.gif'>
                        </td>
                        <td>
                        <img style=\"cursor:hand\"
                        onclick='{
                        document.all.cellid.value=$f[id];
                        document.all.delcell.value=\"1\";
                        document.all.editor.submit();
                        }'
                        src='img/del.gif'>
                        </td>
                        </table>

             */
}

if ($parent_doc_spec[nwnd])$nwnd = ' checked ';
else $nwnd = '';
$tpl->assign(
        array(
                '{PICS}' => $PICS,
                '{ROWS}' => $parent_doc_spec[rows],
                '{COLS}' => $parent_doc_spec[cols],
                '{FORMAT}' => $parent_doc_spec[format],
                '{NWND}' => $nwnd,
                '{LISTER}' => lister("view.php?action=showdoc&id=$id&", ($parent_doc_spec[rows] * $parent_doc_spec[cols]), "engine_PHOTOGALARY_cells", "gal_id=$id")
                )
        );

?>
