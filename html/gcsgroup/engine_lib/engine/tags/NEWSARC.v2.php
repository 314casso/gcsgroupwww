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
	$mn['9']="��������";
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
	$date_field = (mysql_fetch_assoc(mysql_query("SHOW COLUMNS FROM engine_NEW LIKE 'new_date';")))?
				"n.new_date":"d.creation_date";
	
	$sql = <<<SQL
SELECT date_format($date_field, '%Y') AS year, date_format($date_field, '%m') AS month
FROM engine_documents d, engine_NEW n 
WHERE d.visible=1 
	AND n.doc_id=d.id 
	AND d.pid={$id} 
GROUP BY YEAR($date_field) DESC, MONTH($date_field) DESC
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
