<?

/*
 *  $Id: NEWS.php,v 1.11 2006/09/26 07:05:58 ereih Exp $
 *
 *  $Log: NEWS.php,v $
 *  Revision 1.11  2006/09/26 07:05:58  ereih
 *  ���� ����� ��������� � ���������� � �������
 *
 *  Revision 1.10  2006/02/28 10:46:28  ereih
 *  ��������� ����������� ��������� ����� ��� �������� � �������.
 *
 *  Revision 1.9  2005/12/26 12:26:13  ereih
 *  ���������� ������ � ������� �������� ��� ��������.
 *
 *  Revision 1.8  2005/05/30 09:00:31  aavakyan
 *  ������������� ����������� new document ���� �� ����������� ���� �������, ����� ��� �� ����
 *
 *  Revision 1.7  2005/02/01 21:49:23  dave
 *  ������������ ���� "���������� �������"
 *
 *  Revision 1.6  2004/12/19 22:51:53  dave
 *  ����������� �������� � �� -- ���������� �� ������ OUTER JOIN
 *
 *
 */
$DBResult=mysql_query("SHOW COLUMNS FROM engine_NEW LIKE 'new_date%'") or die (mysql_error());
$date_field = "d.creation_date";
$filter = $date_field_start = $date_field_end = '';
while ($field=mysql_fetch_assoc($DBResult))
{
    switch ($field['Field'])
    {
    	case 'new_date':
    		$date_field = "n.new_date";
    		break;
    	case 'new_date_start':
    		$date_field_start = "n.new_date_start";
    		break;
    	case 'new_date_end':
    		$date_field_end = "n.new_date_end";
			break;
    }
}
if (!empty($date_field_start))
{
	$filter	.= "AND (($date_field_end IS NULL) OR NOW() >= $date_field_start) ";
}
if (!empty($date_field_end))
{
	$filter	.= "AND (($date_field_end IS NULL) OR NOW() <= $date_field_end) ";
}

$ng = new Document($id,0);

global $arclist, $logged;
$arclist1='';

$id=$ng->id;

if ($count)
{
    $limit="LIMIT ".$count;
}
else
{
    $limit="LIMIT ".($ng->spec['ncount']+0);
}

if (!$logged['id'])
{
    $sql = <<<SQL
	SELECT d.id AS doc_id, date_format(d.creation_date,"%d.%m.%Y") creation_date, n.*
	    FROM engine_documents d, engine_NEW n
	    WHERE d.visible=1 AND
	          n.doc_id = d.id AND
	          d.pid = '$id' AND
	          grpassign=-1 AND
	          usrassign=-1
	          $arclist1
	          $filter
	    ORDER BY $date_field DESC 
	    $limit
SQL;
}
else
{
    $sql = 'SELECT ugroup
            FROM engine_users
            WHERE id='.$logged['id'];

    $result = mysql_query($sql) or die (mysql_error());

    list($loggedgrp) = mysql_fetch_array($result);
    $sql = <<<SQL
    SELECT d.id AS doc_id, date_format(d.creation_date,"%d.%m.%Y") creation_date, n.*
        FROM engine_documents d, engine_NEW n
        WHERE d.visible=1 AND
              n.doc_id=d.id AND
              d.pid='$id' AND
              (grpassign=-1 or grpassign='$loggedgrp') AND
              (usrassign=-1 or usrassign='{$logged['id']}')
              $arclist1
              $filter
        ORDER BY $date_field DESC 
        $limit
SQL;
}

$r = mysql_query($sql) or die (mysql_error()." in $sql");

if (!$format)
{
    $format=$ng->spec['format'];
}
if ($format == ''){
$format = "<p>NEW_DATE</p>
	<p>NEW_HEADER</p>
	<p>NEW_TEXT</p>
	<p>NEW_HREF</p>";
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
