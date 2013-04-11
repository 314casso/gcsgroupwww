<?

global ${"arclist_$id"},$lang;

if (empty($id))
{
	$id = $doc;
}

$ngrp=new Document($id,0);

if ($ngrp->type == 'NEWSGROUP')
{
	$id=$ngrp->id;
	$ng=mysql_fetch_array(mysql_query("select * from engine_NEWSGROUP where doc_id={$id}"));

	$mn_e[1]="January";
	$mn_e[2]="February";
	$mn_e[3]="March";
	$mn_e[4]="April";
	$mn_e[5]="May";
	$mn_e[6]="June";
	$mn_e[7]="July";
	$mn_e[8]="August";
	$mn_e[9]="September";
	$mn_e[10]="October";
	$mn_e[11]="November";
	$mn_e[12]="December";

	$mn[1]="Январь";
	$mn[2]="Февраль";
	$mn[3]="Март";
	$mn[4]="Апрель";
	$mn[5]="Май";
	$mn[6]="Июнь";
	$mn[7]="Июль";
	$mn[8]="Август";
	$mn[9]="Сентябрь";
	$mn[10]="Октябрь";
	$mn[11]="Ноябрь";
	$mn[12]="Декабрь";

	$today = getdate();
	$year=$today['year'];
	$month = $today['mon'];

                                $sql="select

                                        date_format(min(d.creation_date),'%Y') y,

                                        date_format(min(d.creation_date),'%m') m

                                        from engine_documents d, engine_NEW n where d.visible=1 and n.doc_id=d.id and d.pid={$id} order by d.creation_date desc";

                                $DBResult = mysql_query($sql) or die (mysql_error());

                                $f=mysql_fetch_array($DBResult);

                                $f[m]+=0;

                                if ($lang=='en'){



                                        $frm= "

                                                <select class=arclist id=arclist_$id name=arclist_$id  onchange='{

                                                        if (document.all.arclist_$id.value) ;

                                                                document.location=\"".(geturl($id))."?arclist_$id=\"+document.all.arclist_$id.value;

                                                        }'><option value=''>Last {$ng[ncount]}</option>";

                                                        }

                                else{

                                        $frm= "

                                                <select class=arclist id=arclist_$id name=arclist_$id  onchange='{

                                                        if (document.all.arclist_$id.value) ;

                                                                document.location=\"".(geturl($id))."?arclist_$id=\"+document.all.arclist_$id.value;

                                                        }'><option value=''>Последние {$ng[ncount]}</option>";

                                                }

                                $m1=$month;

                                if ($lang=='en')

                                        $mn=$mn_e;

                                if ($f[y])

                                for ($y=$year;$y>=$f[y];$y--){

                                        for ($m=$m1;(($m>=$f[m]) or ($y>$f[y] and $m>=1)) ;$m--){

                                                if (${"arclist_$id"}=="$m.$y") $sltd='selected';

                                                else $sltd='';

                                                if (strlen($m)==2)

                                                        $al="$m.$y";

                                                else

                                                        $al="0$m.$y";



                                                $sql="select d.id from engine_documents d, engine_NEW n where d.visible=1 and n.doc_id=d.id and d.pid={$id} and date_format(d.creation_date,'%m.%Y')='$al'";

                                                if (mysql_num_rows(mysql_query ($sql))){

                                                        $frm.= "<option $sltd value='$al'>{$mn[$m]} $y</option>\n";

                                                        }

                                                }

                                        $m1=12;

                                        }

                                echo $frm.= "</select>";

                                }





?>
