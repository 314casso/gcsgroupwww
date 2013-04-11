<?

/*
 *  $Id: MENU.php,v 1.19 2006/10/17 11:02:44 ereih Exp $
 *
 *  $Log: MENU.php,v $
 *  Revision 1.19  2006/10/17 11:02:44  ereih
 *  ��������� ����������� ������ ���������� �� ��������� ����������
 *
 *  Revision 1.18  2006/10/16 08:44:33  ereih
 *  ����������� ������ � ��������� ������ ��������� ���������
 *
 *  Revision 1.17  2006/10/13 07:29:56  ereih
 *  ���������� �������� � ��������� �����������
 *
 *  Revision 1.16  2006/09/26 07:08:20  ereih
 *  ���������� ��������� ����� ������� ������.
 *
 *  Revision 1.15  2006/09/11 12:59:02  ereih
 *  ��������� ����������� ��� ������ ����� �����
 *
 *  Revision 1.10  2005/05/20 08:06:47  aavakyan
 *  �������� ������ ����� ���� item_creation_date
 *
 *  Revision 1.9  2004/12/29 15:29:46  meremin
 *  *** empty log message ***
 *
 *  Revision 1.8  2004/12/19 22:51:53  dave
 *  ����������� �������� � �� -- ���������� �� ������ OUTER JOIN
 *
 *
 */

global $logged, $id;


function RecursiveMenu($tag_iteration,$in_iteration, $folder, $format, $format_postfix, $separator, $prefix, $postfix, $type, $no_docs, $deep_search, $text_to_show, $sformat, $open_docs, $only_open_docs, $bin_format)
{
		global $doc;

if (!$folder)
{
        $d = $doc;
}
else
{
        if ($folder == 'topfolder')
        {
                $where = 'id='.$doc->id;
                while (($row['pid'] !=- 1) and !(mysql_error()))
                {
                        $sql = 'SELECT id, pid
                                FROM engine_documents
                                WHERE '.$where;

                        if (!$result = @mysql_query($sql))
                        {
                        	die($sql);
                        }
                        $row    = @mysql_fetch_array($result);
                        $resid  = $row['id'];
                        $where  = 'id='.$row['pid'];
                }
                $d=new Document($resid,0);
        }
        elseif ($folder == 'parent')
        {
                $d = new Document($doc->pid,0);
        }
        elseif (preg_match('/^up(\d+)$/i', $folder, $match))
        {
                $row['pid'] = $doc->id;
                $where = $row['pid'];
                $resid = $row['pid'];
                for($i = intval($match[1]); $i>0; $i--)
                {
                        if ($row['pid'] != -1)
                        {
                                $sql = 'SELECT id, pid
                                        FROM engine_documents
                                        WHERE id = '.$where;

                                if (!$result = @mysql_query($sql))
                        	{
                        		die($sql);
                        	}
                                $row    = @mysql_fetch_array($result);
                                $resid  = $row['id'];
                                $where  = $row['pid'];
                        }
                }
                $d = new Document($resid,0);
        }
        else
        {
                $d = new Document($folder,0);
        }
}

if (($d->id != -1)&&($dont_search_folder != '1'))
{
        while($d->type != 'FOLDER')
        {
                $d = new Document($d->pid,0);
        }
}

if ($in_iteration !== true)
{
	$open_docs = array();
	$row['id'] = $doc->id;
	$row['pid'] = $doc->pid;
	$open_docs[$row['id']] = true;
	while (($row['pid'] != -1)&&($row))
	{		$sql = 'SELECT id, pid
		        FROM engine_documents
		        WHERE id = '.$row['pid'];
		if (!$result = @mysql_query($sql))
		{			die($sql);
		}
		$row = @mysql_fetch_array($result, MYSQL_ASSOC);

		$open_docs[$row['id']] = true;
	}
}

$path  = str_replace(".html","",($d->geturl()));

if (!ereg('/$', $path))
{
        $path = $path.'/';
}

$folder = $d->id;

if (strcasecmp($type, 'documents') == 0)
{
	$sql_where = ' AND type != "FOLDER" ';
}
elseif (strcasecmp($type, 'folders') == 0)
{
	$sql_where = ' AND type = "FOLDER" ';
}
elseif (empty($type))
{
	$sql_where = '';
}
else
{
	$sql_where = ' AND type IN ('.$type.') ';
}

if ($logged)
{

        $sql = 'SELECT *
                FROM engine_documents
                WHERE pid="'.$folder.'" AND
                      visible != 0
                      '.$sql_where.'
                ORDER BY ord, name';
}
else
{
        $sql = 'SELECT *
                FROM engine_documents
                WHERE pid="'.$folder.'" AND
                      visible != 0
                      '.$sql_where.'
                ORDER BY ord, name';
}

if (!$result = @mysql_query($sql))
{
	die($sql);
}

$size = intval(@mysql_num_rows($result));
$i = 1;

$g_vars = array();
foreach($d as $key_id => $key_value)
{
	if ($key_id != 'spec')
	{
		$g_vars['doc_'.$key_id] = $key_value;
	}
}

if (is_array($d->spec))
{
	$doc_type = strtolower($d->type);
	foreach($d->spec as $key_id => $key_value)
	{
		if (!is_int($key_id))
		{
			$g_vars[$doc_type.'_'.$key_id] = $key_value;
		}
	}
}

$g_vars['item_num'] = $size;
$g_vars['doc_num']  = 0;

if ($size > 0)
{
	echo str_replace(array_keys($g_vars), array_values($g_vars), $prefix);
}

if (!$format)
{
	?>
<table cellpadding="1" cellspacing="0" border="0" width="100%">
        <?
        if ($view != 'horizontal')
        {
        	?>
  <tr bgcolor="#EFEFEF">
    <td colspan="3" class="top">
      <a class="menu" href="<?=$path;?>.html"><img border="0" src="img/up.gif">..</a>
    </td>
  </tr>
		<?
	}
	else
	{
		?>
  <tr bgcolor="#EFEFEF">
		<?
	}
}

while ($row = @mysql_fetch_array($result))
{
	$i++;
	$img = 'document.gif';
	$fld = 0;

	if (empty($row['code']))
	{
		$a = $row['id'];
	}
	else
	{
		$a = strtolower($row['code']);
	}

	if ($row['type'] == 'FOLDER')
	{
		$img="fopened.gif";
		$fld=1;
	}

	if ($row['id'] == $doc->id || ($row['type'] == 'FOLDER' && $row['id'] == $doc->pid))
	{
		if (file_exists('engine/doc_icons/actimg'.$row['id'].'.gif'))
		{
			$img = '/engine/doc_icons/actimg'.$row['id'].'.gif';
		}
		elseif (file_exists('engine/doc_icons/actimg'.$row['id'].'.jpg'))
		{
			$img = '/engine/doc_icons/actimg'.$row['id'].'.jpg';
		}
		elseif ($row['type'] == 'FOLDER')
		{
			$img = '/engine/doc_icons/default/actfld.gif';
		}
		else
		{
			$img = '/engine/doc_icons/default/actdoc.gif';
		}

		$vars['ITEM_SELECTED'] = $item_selected;

		$g_vars['doc_num'] = ($i-1);
	}
	else
	{
		if (file_exists('engine/doc_icons/unactimg'.$row['id'].'.gif'))
		{
			$img = '/engine/doc_icons/unactimg'.$row['id'].'.gif';
		}
		elseif (file_exists('engine/doc_icons/unactimg'.$row['id'].'.jpg'))
		{
			$img = '/engine/doc_icons/unactimg'.$row['id'].'.jpg';
		}
		elseif ($row['type']=='FOLDER')
		{
			$img = '/engine/doc_icons/default/uactfld.gif';
		}
		else
		{
			$img = '/engine/doc_icons/default/uactdoc.gif';
		}

		$vars['ITEM_SELECTED'] = $item_unselected;
	}

	$show = true;

	global $hide_private_docs;

	if ($hide_private_docs != 0)
	{
		if ($row['private'])
		{
			if ($sitelogged)
			{
				$sql = 'SELECT *
                           		FROM engine_users u, engine_group_rights r
                           		WHERE u.ugroup=r.ugroup AND
                           		      r.document='.$row['id'].' AND
                           		      granted=1 AND
                           		      u.id='.$sitelogged['id'];

				if (!$result_prv = @mysql_query($sql))
				{
					die($sql);
				}

				if (mysql_num_rows($result_prv) > 0)
				{
					$show = true;
				}
				else
				{
					$show = false;
				}
			}

		}
	}

	if ($show)
	{
		$name = $row['name'];

		if ($row['type']=='NEW')
		{
			$new  = new Document($row['id'], false);
			$name = $new->spec['header'];
		}

		if ($text_to_show=='caption_short')
		{
			$name = $row['caption_short'];
		}

		if ($text_to_show=='caption_medium')
		{
			$name = $row['caption_medium'];
		}

		if ($text_to_show=='caption_long')
		{
			$name = $row['caption_long'];
		}

		if (empty($format))
		{
			if ($view != 'horizontal')
			{
				?>
  <tr bgcolor="#EFEFEF">
				<?
			}
			?>
    <td colspan="3" class="top">
      <img border="0" src="<?=$img;?>" /> <a class="menu"  href="<?=$path.$a;?>.html"><?=$name;?> <?=$row['id'];?> <?=$doc->pid;?></a>
    </td>
			<?
			if ($view!='horizontal')
			{
				?>
  </tr>
				<?
			}
		}
		else
		{
			$vars = array('ITEM_IMG' => $img,
                        	      'ITEM_TEXT' => $name,
                        	      'ITEM_CAPTION_LONG' => $row['caption_long'],
                        	      'ITEM_CAPTION_MEDIUM' => $row['caption_medium'],
                        	      'ITEM_CAPTION_SHORT' => $row['caption_short'],
                        	      'ITEM_CODE' => $row['code'],
                        	      'ITEM_CREATION_DATE' => substr($row['creation_date'],0,10),
                        	      'ITEM_USER' => $row['user'],
                        	      'ITEM_RESUME' => $row['resume'],
                        	      'ITEM_ID' => $row['id'],
                        	      'ITEM_NUM' => ($i - 1),
                        	      'ITEM_COUNT' => $size,
                        	      'ITEM_PID' => $row['pid'],
                        	      'ITEM_TYPE' => $row['type']
                        	      );

			if ($row['type'] != 'BINARYDOC')
			{
				$vars['ITEM_LINK'] = $path.$a.'.html';
				$vars['ITEM_BINARY'] = '';
				$echo_link = true;
			}
			else
			{
				$sql = 'SELECT ext
				        FROM engine_BINARYDOC
				        WHERE doc_id='.$row['id'];

				if (!$result_bin = @mysql_query($sql))
				{
					die($sql);
				}
				else
				{
					$vars['ITEM_BINARY'] = '';
					$echo_link = false;
					if ($row_bin = mysql_fetch_array($result_bin))
					{
						$vars['ITEM_LINK'] = '/engine/documents/document'.$row['id'].'.'.$row_bin['ext'];

						if (file_exists('engine/documents/document'.$row['id'].'.'.$row_bin['ext']))
						{
							$echo_link = true;

                                                        $f_size = filesize('engine/documents/document'.$row['id'].'.'.$row_bin['ext']);

							$i=0;
							$iec = array("�", "��", "��", "��", "��");
							while ((($f_size/1024)>1)&&($i<5))
							{
								$f_size=$f_size/1024;
								$i++;
							}
							$size_text = substr($f_size,0,strpos($f_size,'.')+2).' '.$iec[$i];

							$sub_vars = array('BIN_SIZE' => $size_text,
							                  'BIN_TYPE' => $row_bin['ext']);

							$vars['ITEM_BINARY'] = str_replace(array_keys($sub_vars), array_values($sub_vars), $bin_format);
						}
                                        }

				}
			}

			if ($echo_link == true)
			{
				if ((array_key_exists($row['id'], $open_docs))&&($sformat))
				{
					$out = str_replace(array_keys($vars), array_values($vars), $sformat);
				}
				else
				{
					$out = str_replace(array_keys($vars), array_values($vars), $format);
				}
			}
			else
			{
				$out = '';
			}

			echo $out;
			if (($i <= $size)&&($out))
			{
				echo str_replace(array_keys($vars), array_values($vars), $separator);
			}

			if ((($row['type'] == 'FOLDER')||($row['type'] == 'NEWSARC'))&&($tag_iteration < $deep_search))
			{
				if ($only_open_docs == '1')
				{
					if (array_key_exists($row['id'], $open_docs))
					{
						$t_iteration = $tag_iteration+1;
						$t_format    = (${'format'.$t_iteration}) ? ${'format'.$t_iteration}: $format;
						$t_bin_format = (${'bin_format'.$t_iteration}) ? ${'bin_format'.$t_iteration}: $bin_format;
						$t_format_postfix = isset(${'format_postfix'.$t_iteration}) ? ${'format_postfix'.$t_iteration}: $format_postfix;
						$t_separator = (${'separator'.$t_iteration}) ? ${'separator'.$t_iteration}: $separator;
						$t_prefix    = (${'prefix'.$t_iteration}) ? ${'prefix'.$t_iteration}: $prefix;
						$t_postfix = (${'postfix'.$t_iteration}) ? ${'postfix'.$t_iteration}: $postfix;
						$t_type = (${'type'.$t_iteration}) ? ${'type'.$t_iteration}: $type;
						$t_no_docs = (${'no_docs'.$t_iteration}) ? ${'no_docs'.$t_iteration}: $no_docs;
						$t_text_to_show = (${'text_to_show'.$t_iteration}) ? ${'text_to_show'.$t_iteration}: $text_to_show;
						$t_sformat = (${'sformat'.$t_iteration}) ? ${'sformat'.$t_iteration}: $sformat;
						RecursiveMenu($t_iteration,true,$row['id'], $t_format, $t_format_postfix, $t_separator, $t_prefix, $t_postfix, $t_type, $t_no_docs, $deep_search, $t_text_to_show, $t_sformat, $open_docs, $only_open_docs, $t_bin_format);
					}
				}
				else
				{
					$t_iteration = $tag_iteration+1;
					$t_format    = (${'format'.$t_iteration}) ? ${'format'.$t_iteration}: $format;
					$t_bin_format  = (${'bin_format'.$t_iteration}) ? ${'bin_format'.$t_iteration}: $bin_format;
					$t_format_postfix = isset(${'format_postfix'.$t_iteration}) ? ${'format_postfix'.$t_iteration}: $format_postfix;
					$t_separator = (${'separator'.$t_iteration}) ? ${'separator'.$t_iteration}: $separator;
					$t_prefix    = (${'prefix'.$t_iteration}) ? ${'prefix'.$t_iteration}: $prefix;
					$t_postfix = (${'postfix'.$t_iteration}) ? ${'postfix'.$t_iteration}: $postfix;
					$t_type = (${'type'.$t_iteration}) ? ${'type'.$t_iteration}: $type;
					$t_no_docs = (${'no_docs'.$t_iteration}) ? ${'no_docs'.$t_iteration}: $no_docs;
					$t_text_to_show = (${'text_to_show'.$t_iteration}) ? ${'text_to_show'.$t_iteration}: $text_to_show;
					$t_sformat = (${'sformat'.$t_iteration}) ? ${'sformat'.$t_iteration}: $sformat;
					RecursiveMenu($t_iteration,true,$row['id'], $t_format, $t_format_postfix, $t_separator, $t_prefix, $t_postfix, $t_type, $t_no_docs, $deep_search, $t_text_to_show, $t_sformat, $open_docs, $only_open_docs, $t_bin_format);
				}
			}

			echo $format_postfix;
		}
	}
}//while

if (!$format)
{
	if ($view=='horizontal')
	{
?>
  </tr>
<?
	}

?>
</table>
<?
}

if ($size == 0)
{
	echo str_replace(array_keys($g_vars), array_values($g_vars), $no_docs);
}

if ($size > 0)
{
	echo str_replace(array_keys($g_vars), array_values($g_vars), $postfix);
}
}//function
?>