<?

/*
 * $Id: MENU.php,v 1.21 2007/01/30 13:21:45 serge Exp $
 *
 * $Log: MENU.php,v $
 * Revision 1.21 2007/01/30 13:21:45 serge
 * опечатка с сепаратором
 *
 * Revision 1.20 2007/01/12 11:16:07 serge
 * исправлена ошибка в рекурсии, добавлена возможность задавать only_open_docs для уровней
 *
 * Revision 1.19 2006/10/17 11:02:44 ereih
 * Добавлена возможность вывода информации по бинарному докумениту
 *
 * Revision 1.18 2006/10/16 08:44:33 ereih
 * Исправление ошибки с созданием ссылки бинарному документу
 *
 * Revision 1.17 2006/10/13 07:29:56 ereih
 * Исправлена проблема с бинарными документами
 *
 * Revision 1.16 2006/09/26 07:08:20 ereih
 * Добавление постфикса после формата вывода.
 *
 * Revision 1.15 2006/09/11 12:59:02 ereih
 * Добавлена возможность все дерево одним тегом
 *
 * Revision 1.10 2005/05/20 08:06:47 aavakyan
 * Причесан формат выода даты item_creation_date
 *
 * Revision 1.9 2004/12/29 15:29:46 meremin
 * *** empty log message ***
 *
 * Revision 1.8 2004/12/19 22:51:53 dave
 * Оптимизация запросов к БД -- избавление от лишних OUTER JOIN
 *
 *
 */



global $logged, $id;
$tag_iteration++;

if ($in_iteration !== true)
{

  for ($i=1;$i<$deep_search+1;$i++){
    $GLOBALS["tagvarsformat" .$i] = ${"format".$i};
    $GLOBALS["tagvarsformat_postfix" .$i] = ${"format_postfix".$i};
    $GLOBALS["tagvarscond" .$i] = ${"cond".$i};
    $GLOBALS["tagvarsseparator" .$i] = ${"separator".$i};
    $GLOBALS["tagvarsprefix" .$i] = ${"prefix".$i};
    $GLOBALS["tagvarspostfix" .$i] = ${"postfix".$i};
    $GLOBALS["tagvarstype" .$i] = ${"type".$i};
    $GLOBALS["tagvarsno_docs" .$i] = ${"no_docs".$i};
    $GLOBALS["tagvarsdeep_search" .$i] = ${"deep_search".$i};
    $GLOBALS["tagvarstext_to_show" .$i] = ${"text_to_show".$i};
    $GLOBALS["tagvarssformat" .$i] = ${"sformat".$i};
    $GLOBALS["tagvarsopen_docs" .$i] = ${"open_docs".$i};
    $GLOBALS["tagvarsonly_open_docs" .$i] = ${"only_open_docs".$i};
    $GLOBALS["tagvarsbin_format" .$i] = ${"bin_format".$i};
  
  }//for

}//if

if (function_exists('RecursiveMenu') == false) {
  function RecursiveMenu($folder, $format, $format_postfix, $cond, $separator, $prefix, $postfix, $type, $no_docs, $deep_search, $text_to_show, $sformat, $open_docs, $only_open_docs, $bin_format, $view_catalog, $view_all, $view_only_one, $view_only_one_link) {
    echo '<!--STST startrec ', $only_open_docs; echo '-->';
    global $tag_iteration, $doc;
    $in_iteration = true;
    $temp_i = $tag_iteration;
    //$view = 1 - выводить все дерево
    if ($view_catalog == 1) $view_all = 1;
    else $view_all = $view_catalog;
    include('MENU.php');
    $tag_iteration = $temp_i;
  }
}

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
            $row  = @mysql_fetch_array($result);
            $resid = $row['id'];
            $where = 'id='.$row['pid'];
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
                $row  = @mysql_fetch_array($result);
                $resid = $row['id'];
                $where = $row['pid'];
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
  {    $sql = 'SELECT id, pid
        FROM engine_documents
        WHERE id = '.$row['pid'];
    if (!$result = @mysql_query($sql))
    {      die($sql);
    }
    $row = @mysql_fetch_array($result, MYSQL_ASSOC);

    $open_docs[$row['id']] = true;

  }
}

$path = str_replace(".html","",($d->geturl()));

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
$g_vars['doc_num'] = 0;

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
//**********************************

while ($row = @mysql_fetch_array($result) )
{

$condition=0;
if ($cond) eval('if ('.$cond.') $condition=1;');
else $condition=1;

if ($condition)  {

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

  if ($row['type'] == 'FOLDER' && $view_all != 1)
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
      $new = new Document($row['id'], false);
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
   <img border="0" src="<?=$img;?>" /> <a class="menu" href="<?=$path.$a;?>.html"><?=$name;?> <?=$row['id'];?> <?=$doc->pid;?></a>
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
              $iec = array("Б", "Кб", "Мб", "Гб", "Тб");
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

	 /*  echo "<pre>";
	   print_r($row['id']);	   
	   echo "</pre>";*/

        if ((array_key_exists($row['id'], $open_docs))&&($sformat))
        {
         	//
		if ($view_only_one_link && $row['id'] != $doc->id){
         		$out = str_replace(array_keys($vars), array_values($vars), $format);
		}
		else{
			$out = str_replace(array_keys($vars), array_values($vars), $sformat);
		}
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

      if ((($row['type'] == 'FOLDER')||($row['type'] == 'NEWSARC'))&&($tag_iteration < $deep_search))
      {
        if ( (($only_open_docs == '1') && (array_key_exists($row['id'], $open_docs))) || ($only_open_docs == '0') || (!$only_open_docs && $deep_search))
          {
            $t_iteration = $tag_iteration+1;
            $t_format  = isset($GLOBALS['tagvarsformat'.$t_iteration]) ? $GLOBALS['tagvarsformat'.$t_iteration]: $format;
            $t_bin_format = isset($GLOBALS['tagvarsbin_format'.$t_iteration]) ? $GLOBALS['tagvarsbin_format'.$t_iteration]: $bin_format;
            $t_format_postfix = isset($GLOBALS['tagvarsformat_postfix'.$t_iteration]) ? $GLOBALS['tagvarsformat_postfix'.$t_iteration]: $format_postfix;
            $t_cond = isset($GLOBALS['tagvarscond'.$t_iteration]) ? $GLOBALS['tagvarscond'.$t_iteration]: $cond;
            $t_separator = isset($GLOBALS['tagvarsseparator'.$t_iteration]) ? $GLOBALS['tagvarsseparator'.$t_iteration]: $separator;
            $t_prefix  = isset($GLOBALS['tagvarsprefix'.$t_iteration]) ? $GLOBALS['tagvarsprefix'.$t_iteration]: $prefix;
            $t_postfix = isset($GLOBALS['tagvarspostfix'.$t_iteration]) ? $GLOBALS['tagvarspostfix'.$t_iteration]: $postfix;
            $t_type = isset($GLOBALS['tagvarstype'.$t_iteration]) ? $GLOBALS['tagvarstype'.$t_iteration]: $type;
            $t_no_docs = isset($GLOBALS['tagvarsno_docs'.$t_iteration]) ? $GLOBALS['tagvarsno_docs'.$t_iteration]: $no_docs;
            $t_text_to_show = isset($GLOBALS['tagvarstext_to_show'.$t_iteration]) ? $GLOBALS['tagvarstext_to_show'.$t_iteration]: $text_to_show;
            $t_sformat = isset($GLOBALS['tagvarssformat'.$t_iteration]) ? $GLOBALS['tagvarssformat'.$t_iteration]: $sformat;
            $t_only_open_docs = isset($GLOBALS['tagvarsonly_open_docs'.$t_iteration]) ? $GLOBALS['tagvarsonly_open_docs'.$t_iteration]: $only_open_docs;
            RecursiveMenu($row['id'], $t_format, $t_format_postfix, $t_cond, $t_separator, $t_prefix, $t_postfix, $t_type, $t_no_docs, $deep_search, $t_text_to_show, $t_sformat, $open_docs, $t_only_open_docs, $t_bin_format, $view_catalog, $view_all, $view_only_one, $view_only_one_link);
          }
      }

      if ((($row['type'] == 'CATALOG') && ($view_all == 1 || (($row['id'] == $doc->id || $row['id'] == $doc->pid) && $view_all == 2)) )&&($tag_iteration < $deep_search))
      {
		//вывод содержимого каталога
		//сделан только формат вывода, т.е. только по ITEM_LINK и по ITEM_TEXT (остальное нужно понять как будет выглядеть)
            $t_iteration = $tag_iteration+1;
	     if ($GLOBALS['tagvarsformat'.$t_iteration]){
	    	 $format_n  = $GLOBALS['tagvarsformat'.$t_iteration];
	     }
	     else{
	    	 $format_n  = "<ul>\n<li>\n<a href=\"ITEM_LINK\">ITEM_TEXT</a>\n<li>\n</ul>\n";
	     }
	     if ($GLOBALS['tagvarssformat'.$t_iteration]){
	    	 $sformat_n = $GLOBALS['tagvarssformat'.$t_iteration];
	     }
	     else{
	    	 $sformat_n = "<ul>\n<li>\n<a href=\"ITEM_LINK\">ITEM_TEXT</a>\n<li>\n</ul>\n";
	     }

		$sql="select 
				*,
				d.id as id_m
			from 
				engine_documents d, 
				engine_CATALOGITEM ci 
			where ci.doc_id=d.id
				and d.pid=".$row[id]." 
			order by 
				ci.ord,ci.name";
		$r = mysql_query("$sql") or die (mysql_error());
		$size = intval(@mysql_num_rows($r));
		if ($size > 0){
  			echo str_replace(array_keys($g_vars), array_values($g_vars), $GLOBALS['tagvarsprefix'.$t_iteration]);
		}
		while($f = mysql_fetch_array($r)){
			$f[url] = geturl($f[id_m]);
     	 		$vars = array(
             			'ITEM_TEXT' => $f[name],
            			'ITEM_LINK' => $f[url]
                	 );
      			if (($doc->id == $f[id_m])&&($sformat_n)){
          			$out = str_replace(array_keys($vars), array_values($vars), $sformat_n);
        		}
        		else{
          			$out = str_replace(array_keys($vars), array_values($vars), $format_n);
        		}
			echo $out;
		}
		echo str_replace(array_keys($vars), array_values($vars), $GLOBALS['tagvarsseparator'.$t_iteration]);
      }
     // if (($i <= $size)&&($out)){
      if (($i != 1 || $size == 1)&&($out) && $i != ($size + 1)){
      		echo str_replace(array_keys($vars), array_values($vars), $separator);
      }
      echo $format_postfix;
    }

  }
}//if condition
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
?>
