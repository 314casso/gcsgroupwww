<?

/*
 *  $Id: edit.php,v 1.4 2004/12/19 22:51:27 dave Exp $
 *
 *  $Log: edit.php,v $
 *  Revision 1.4  2004/12/19 22:51:27  dave
 *  ����������� �������� � �� -- ���������� �� ������ OUTER JOIN
 *
 *
 */

global $arclist;

$mn[1]="������";
$mn[2]="�������";
$mn[3]="����";
$mn[4]="������";
$mn[5]="���";
$mn[6]="����";
$mn[7]="����";
$mn[8]="������";
$mn[9]="��������";
$mn[10]="�������";
$mn[11]="������";
$mn[12]="�������";

$today = getdate();
$year=$today['year'];
$month = $today['mon'];

$sql="select date_format(min(d.creation_date),'%Y') y,
             date_format(min(d.creation_date),'%m') m
      from engine_documents d, engine_NEW n where n.doc_id=d.id and d.pid=$id order by d.creation_date desc";

$DBResult = mysql_query($sql) or die (mysql_error());

				$f=mysql_fetch_array($DBResult);

				$f[m]+=0;

				$frm= "

					<select class=arclist id=arclist name=arclist  onchange='{

						if (document.all.arclist.value) ;

							document.location=\"view.php?action=showdoc&id=$id&arclist=\"+document.all.arclist.value;

						}'><option value=''>��������� {$parent_doc_spec[ncount]}</option>";

				$m1=$month;

				if ($f[y])

				for ($y=$year;$y>=$f[y];$y--){

					for ($m=$m1;(($m>=$f[m]) or ($y>$f[y] and $m>=1)) ;$m--){

						if ($arclist=="$m.$y") $sltd='selected';

						else $sltd='';

						if (strlen($m)==2)

							$al="$m.$y";

						else

							$al="0$m.$y";



						$sql="select d.id from engine_documents d, engine_NEW n where n.doc_id=d.id and d.pid=$id and date_format(d.creation_date,'%m.%Y')='$al'";

						if (mysql_num_rows(mysql_query ($sql))){

							$frm.= "<option $sltd value='$al'>{$mn[$m]} $y</option>\n";

							}

						}

					$m1=12;

					}

				$frm.= "</select>";





				if ($arclist) $arclist=" and date_format(d.creation_date,'%m.%Y')='$arclist' ";


				$sql = 'SELECT d.id as did, creation_date, n.*
				          FROM (
				                engine_documents d
				                LEFT JOIN engine_NEW n ON n.doc_id = d.id
				               )
				         WHERE d.pid='.$id.'
				         '.$arclist.'
				         ORDER BY d.creation_date desc';

				$news_r= mysql_query($sql) or die (mysql_error()." in $sql");

				$news="";

				$n=0;

				while ($news_f = mysql_fetch_array($news_r))
				{
					if (++$n%2==0)
					{
						$td_class = "row2";
					}
					else
					{
						$td_class = "row1";
					}

					$news.= '<tr class="'.$td_class.'">
  <td><a class="com_link" href="view.php?action=showdoc&id='.$news_f['did'].'">'.(($news_f['new_date']) ? $news_f['new_date'] : $news_f['creation_date']).'</a></td>
  <td><a class="com_link" href="view.php?action=showdoc&id='.$news_f['did'].'">'.$news_f['header'].'</a></td>
  <td align=center><a href="#" onclick="proc.document.location=\'proc.php?action=deldoc&id='.$news_f['did'].'\'"><img src="img/ico_del.gif" border="0" alt="�������"></a></td>
</tr>';
				}

				if ($news )
				{
					$temp  = '<table class="line" width="90%" cellspacing="1" cellpadding="3" border="0" >';
					$temp .= '<tr><th>����</th><th>���������</th><th>�������</th></tr>';
					$temp .= $news;
					$temp .= '</table>';

					$news = $temp;
				}

				if ($parent_doc_spec[ncount]=="")$parent_doc_spec[ncount]=5;

				$tpl->assign(

						array(

							FRM		=>  $frm,

							NEWS	=>	$news,

							NCOUNT	=>	$parent_doc_spec[ncount],

							FORMAT	=>	$parent_doc_spec[format]

						)

					);



?>