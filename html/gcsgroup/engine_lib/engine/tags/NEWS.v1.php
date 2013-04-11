<?

/*
 *  $Id: NEWS.php,v 1.11 2006/09/26 07:05:58 ereih Exp $
 *
 *  $Log: NEWS.php,v $
 *  Revision 1.11  2006/09/26 07:05:58  ereih
 *  Фикс багов связанных с картинками в новости
 *
 *  Revision 1.10  2006/02/28 10:46:28  ereih
 *  Добавлена возможность указывать стиль для картинки к новости.
 *
 *  Revision 1.9  2005/12/26 12:26:13  ereih
 *  Исправлена ошибка с выводом картинок для новостей.
 *
 *  Revision 1.8  2005/05/30 09:00:31  aavakyan
 *  Оптимизирован конструктор new document дабы не создавалось тело впустую, когда это не надо
 *
 *  Revision 1.7  2005/02/01 21:49:23  dave
 *  Задействован флаг "показывать новость"
 *
 *  Revision 1.6  2004/12/19 22:51:53  dave
 *  Оптимизация запросов к БД -- избавление от лишних OUTER JOIN
 *
 *
 */

$ng = new Document($id,0);

global $arclist, $logged;

$id=$ng->id;

if ($count)
{
    $limit="limit ".$count;
}
else
{
    $limit="limit ".($ng->spec['ncount']+0);
}

if (!$logged['id'])
{
    $sql = 'SELECT d.id AS doc_id, date_format(d.creation_date,"%d.%m.%Y") creation_date, n.*
            FROM engine_documents d, engine_NEW n
            WHERE d.visible=1 AND
                  n.doc_id = d.id AND
                  d.pid = '.$id.' AND
                  grpassign=-1 AND
                  usrassign=-1
                  '.$arclist1.'
            ORDER BY d.creation_date desc '.$limit;
}
else
{
    $sql = 'SELECT ugroup
            FROM engine_users
            WHERE id='.$logged['id'];

    $result = mysql_query($sql) or die (mysql_error());

    list($loggedgrp) = mysql_fetch_array($result);
    $sql = 'SELECT d.id AS doc_id, date_format(d.creation_date,"%d.%m.%Y") creation_date, n.*
            FROM engine_documents d, engine_NEW n
            WHERE d.visible=1 AND
                  n.doc_id=d.id AND
                  d.pid='.$id.' AND
                  (grpassign=-1 or grpassign='.$loggedgrp.') AND
                  (usrassign=-1 or usrassign='.$logged['id'].')
                  '.$arclist1.'
            ORDER BY d.creation_date desc '.$limit;
}

$r = mysql_query($sql) or die (mysql_error()." in $sql");

if (!$format)
{
    $format=$ng->spec['format'];
}

while($f= mysql_fetch_array($r))
{
    $nws =new Document($f['doc_id'],0);
    $out=str_replace("NEW_HREF",$nws->geturl(),$format);
    $out=str_replace("NEW_HEADER",$f['header'],$out);
    $out=str_replace("NEW_TEXT",$f['text'],$out);

    if (isset($f['new_date']))
    {
        $new_date = strtotime($f['new_date']);
        $new_date = date('d.m.Y', $new_date);
    }
    else
    {
        $new_date = substr($f['creation_date'], 0, 10);
    }

    $out=str_replace("NEW_DATE", $new_date, $out);
    $pic1 = '';
    $pic2 = '';

    $id = $f['doc_id'];

    $pic_style = (isset($style)) ? $style : "pic_class";

        if (file_exists('engine/pics/news/pic1_'.$id.'.jpg'))
        {
            $pic1 = '<img src="/engine/pics/news/pic1_'.$id.'.jpg" align="left" class="'.$pic_style.'">';
        }
    elseif (file_exists('engine/pics/news/pic1_'.$id.'.gif'))
    {
        $pic1 = '<img src="/engine/pics/news/pic1_'.$id.'.gif" align="left" class="'.$pic_style.'">';
    }

    if (file_exists('engine/pics/news/pic2_'.$id.'.jpg'))
    {
        $pic2 = '<img src="/engine/pics/news/pic2_'.$id.'.jpg" align="left" class="'.$pic_style.'">';
    }
        elseif (file_exists('engine/pics/news/pic2_'.$id.'.gif'))
        {
            $pic2 = '<img src="/engine/pics/news/pic2_'.$id.'.gif" align="left" class="'.$pic_style.'">';
        }

    if (!$pic1)
    {
        $out=preg_replace("|\[NEW_PIC1\].*\[/NEW_PIC1\]|Usi","",$out);
    }

    if (!$pic2)
    {
        $out=preg_replace("|\[NEW_PIC2\].*\[/NEW_PIC2\]|Usi","",$out);
    }

    $out=str_replace("NEW_PIC1",$pic1,$out);
    $out=str_replace("NEW_PIC2",$pic2,$out);
    $out=str_replace("NEW_ID",$f['doc_id'],$out);
    $out=str_replace("NEW_HTML",$f['html'],$out);

    echo $out;

}
?>
