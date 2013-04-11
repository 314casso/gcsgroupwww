<?

global $page,$QUERY_STRING;
//type          - тип докумеента
//parent        - папка/НЛ/Каталог
//format        - формат вывода
//datecond      - дата создания
//order         - порядок сортировки
//count         - кол-во
//rubrique      - рубрики



if (trim($type)and $type!="''"){
    $typecond=" and (type='".str_replace(',', '\' or type=\'',$type)."')";
    $sql.=$typecond;
    }
if (trim($parent)and $parent!="''"){
   $pidcond=" and (pid='".str_replace(',', '\' or pid=\'',$parent)."')";
   $sql.=$pidcond;
   }

if (trim($date_cond)and $date_cond!="''"){
   $sql.="and $date_cond ";
   }

if (trim($rubrique)and $rubrique!="''"){
   foreach(explode(",",$rubrique) as $rub){
       get_subrubsdocs($rub,&$rubdocs);
       }
   $sql.="and id in($rubdocs) ";

   }


if (trim($order)and $order!="''"){
   if ($order=="random")
      $sql.=" order by  RAND()";
   else
       $sql.=" order by  $order";
   }

list($cnt)=mysql_fetch_array(mysql_query("select count(id) from engine_documents where 1 ".$sql));
if (trim($count)and $count!="''"){
    $page+=0;
    $sql.=" limit $page,$count";
    }
$sql="select * from engine_documents where 1 ".$sql;
$r=mysql_query($sql);
while($f=mysql_fetch_array($r)){
      $buf=$itemformat;
      foreach($f as $var=>$val){
         $buf=str_replace ("{-".strtolower($var)."-}",$val,$buf);
         $buf=str_replace ("{-".strtoupper($var)."-}",$val,$buf);
         }
      $did=$f[id];
      $f=mysql_fetch_array(mysql_query("select * from engine_$f[type] where doc_id=$f[id]"));
      if (stristr($buf,'{-BODY-}')){
         $d=new Document($did);
         $buf=str_replace ("{-body-}",$d->body,$buf);
         $buf=str_replace ("{-BODY-}",$d->body,$buf);
         }
      if (stristr($buf,'{-url-}')){
         $buf=str_replace ("{-url-}",geturl($did),$buf);
         $buf=str_replace ("{-URL-}",geturl($did),$buf);
         }

      if ($f)
      foreach($f as $var=>$val){
         $buf=str_replace ("{-".strtolower($var)."-}",$val,$buf);
         $buf=str_replace ("{-".strtoupper($var)."-}",$val,$buf);
         }
      $buf=preg_replace("|{-.*-}|Usi","",$buf);
      $f="";
      $items.=$buf;
      }


$cnt--;
if (!$pagecnt)$pagecnt=5;
$scroller.= "<a href=?page=0>Первая</a> | ";
$scroller.= "<a href=?page=".($cnt-$cnt%$count).">Последняя</a> <br>";

if (($page-$page%($count*$pagecnt)-$count*$pagecnt)>=0)
      $scroller.= "<a href=?page=".($page-$page%$count-$count*$pagecnt)."><<<</a> ";
for ($i=($page-$page%($count*$pagecnt));$i<min($page-$page%($count*$pagecnt)+$pagecnt*$count,$cnt-$cnt%$count+$count);$i+=$count){
      if ($page!=$i)$scroller.= "<a href=?page=$i>".($i/$count+1)."</a> ";
      else $scroller.= "<b>".($i/$count+1)."</b> ";
      }
if (($page-$page%($count*$pagecnt)+$count*$pagecnt)<=$cnt)
      $scroller.= "<a href=?page=".($page-$page%$count+$count*$pagecnt).">>>></a> ";


if  ($cnt>$page+$count) $pgsF="?&page=".($page+$count);
if  ($page)         $pgsB="?&page=".($page-$count);
$format=str_replace ("{-ITEMS-}",$items,$format);
$format=str_replace ("{-SCROLLER-}",$scroller,$format);

echo     $format;



?>