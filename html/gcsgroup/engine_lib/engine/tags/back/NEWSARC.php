<?
global $lang;
if (empty($id))
{
	$id = $doc;
}

$ngrp=new Document($id,0);

if ($ngrp->type == 'NEWSGROUP')
{
	$id=$ngrp->id;
	$ng=mysql_fetch_array(mysql_query("SELECT * FROM engine_NEWSGROUP WHERE doc_id={$id}"));

	$mn_e['01']="January";
	$mn_e['02']="February";
	$mn_e['03']="March";
	$mn_e['04']="April";
	$mn_e['05']="May";
	$mn_e['06']="June";
	$mn_e['07']="July";
	$mn_e['08']="August";
	$mn_e['09']="September";
	$mn_e['10']="October";
	$mn_e['11']="November";
	$mn_e['12']="December";

	$mn['01']="������";
	$mn['02']="�������";
	$mn['03']="����";
	$mn['04']="������";
	$mn['05']="���";
	$mn['06']="����";
	$mn['07']="����";
	$mn['08']="������";
	$mn['09']="��������";
	$mn['10']="�������";
	$mn['11']="������";
	$mn['12']="�������";

	$_url = geturl($id);
	$frm=<<<HTM
<select class=arclist id=arclist_$id name=arclist_$id  onchange='{
if (document.all.arclist_$id.value) ;
	document.location="{$_url}?arclist_$id="+document.all.arclist_$id.value;}'>
HTM;
    if ($lang=='en')
    {
		$frm .= "<option value=''>Last {$ng['ncount']}</option>";
	}
    else
    {
		$frm .= "<option value=''>��������� {$ng['ncount']}</option>";
	}

	if ($lang=='en') $mn=$mn_e;

	$arclist_id = $_REQUEST["arclist_$id"];
	
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
		$filter	.= "AND (($date_field_end IS NULL) OR NOW() >= $date_field_start)  and n.new_date != ''";
    }
    if (!empty($date_field_end))
    {
		$filter	.= "AND (($date_field_end IS NULL) OR NOW() <= $date_field_end)  and n.new_date != ''";
    }
	$sql = <<<SQL
SELECT d.id, date_format($date_field, '%Y') AS year, date_format($date_field, '%m') AS month
FROM engine_documents d, engine_NEW n 
WHERE d.visible=1 
	AND n.doc_id=d.id 
	AND d.pid={$id}
	$filter
GROUP BY YEAR($date_field) DESC, MONTH($date_field) DESC
SQL;
    $DBResult = mysql_query($sql) or die (mysql_error());
    while ($res=mysql_fetch_assoc($DBResult))
    {
    	$al = "{$res['month']}.{$res['year']}";
		$selected = ($arclist_id == $al)?'selected':'';
		$frm.= "<option $selected value='$al'>{$mn[$res['month']]} {$res['year']}</option>\n";
		$news_arr_[] = $res[id];
    }
//������ ������
	if (count($news_arr_)){
		$where_ = " and d.pid not in (".implode(", ", $news_arr_).") ";
	}

	$sql = <<<SQL
SELECT date_format(d.creation_date, '%Y') AS year, date_format(d.creation_date, '%m') AS month
FROM engine_documents d, engine_NEW n 
WHERE d.visible=1 
	AND n.doc_id=d.id 
	AND d.pid={$id}
 	and n.new_date IS NULL
	$where_
GROUP BY YEAR(d.creation_date) DESC, MONTH(d.creation_date) DESC
SQL;

    $DBResult = mysql_query($sql) or die (mysql_error());
    while ($res=mysql_fetch_assoc($DBResult))
    {
    	$al = "{$res['month']}.{$res['year']}";
		$selected = ($arclist_id == $al)?'selected':'';
		$frm.= "<option $selected value='$al'>{$mn[$res['month']]} {$res['year']}</option>\n";
    }


    echo $frm.= "</select>";

}

?>
