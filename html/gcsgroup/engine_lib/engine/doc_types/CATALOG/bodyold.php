<?
global $engine_show_root,$engine_show_htroot,$page;
//$this->body=$this->spec[prefix];
if ($this->spec[icount]!=0){
        $page=(int)$page;
        $limit = "limit $page,".$this->spec[icount];
        $sql="select count(*)        from engine_documents d
left join engine_CATALOGITEM ci on ci.doc_id=d.id
where d.pid=$id order by ci.name";
        list($count)=mysql_fetch_array(mysql_query("$sql"));
        $p=0;
        if ($page!=0)
                $pages.="<a href='?page=".($page-$this->spec[icount])."'><<<</a>&nbsp;&nbsp;";
        while ($p<$count){
                $i++;
                if ($p!=$page)
                        $pages.="<a href='?page=$p'>$i</a>&nbsp;&nbsp;";
                else
                        $pages.="<b>$i</b>&nbsp;&nbsp;";
                $p+=$this->spec[icount];
                }
        if ($page!=$p-$this->spec[icount])
                $pages.="<a href='?page=".($page+$this->spec[icount])."'>>>></a>&nbsp;&nbsp;";
        }
$this->body.=str_replace("[pages]","Страницы ".$pages."<br><br>",$this->spec[prefix]);
$sql="select ci.ord,ci.price,ci.name,d.id from engine_documents d
left join engine_CATALOGITEM ci on ci.doc_id=d.id
where d.pid=$id order by ci.ord,ci.name  $limit";
$r_item=mysql_query("$sql") or die (mysql_error());
while($item=mysql_fetch_array($r_item)){
        $sql="select * from engine_CATALOG_param where catalog=".$this->id;
        $r=mysql_query("$sql") or die (mysql_error());
        $param.="<table border=1>";
        while($f=mysql_fetch_array($r)){
                if (!$f[select]){

                        $sql="select * from engine_CATALOG_values where item={$item[id]} and param=$f[id]";
                        $r1=mysql_query("$sql") or die (mysql_error());
                        $f1=mysql_fetch_array($r1);
                        if ($f[type]=="Изображение"){
                                $pic="$engine_show_htroot/engine/pics/catalog/0.gif";
                                if (file_exists("$engine_show_root/engine/pics/catalog/p_".$f[id]."_".$item[id].".jpg"))
                                        $pic="$engine_show_htroot/engine/pics/catalog/p_".$f[id]."_".$item[id].".jpg";
                                if (file_exists("$engine_show_root/engine/pics/catalog/p_".$f[id]."_".$item[id].".gif"))
                                        $pic="$engine_show_htroot/engine/pics/catalog/p_".$f[id]."_".$item[id].".gif";
                                ${"fld".$f[id]}=$pic;
                                }
                        if ($f[type]=="Текст"){
                                ${"fld".$f[id]}=$f1[value];
                                }
                        }
                else {
                        if (!$f[multiselect]){
                                $sql="select * from engine_CATALOG_values where item=$item[id] and param=$f[id]";
                                $r2=mysql_query("$sql") or die (mysql_error()." $sql");
                                $f2=mysql_fetch_array($r2);
                                if (!$f2[id]){
                                        $sql="select * from  engine_CATALOG_possvals where  param=$f[id] limit 1";
                                        }
                                else{
                                        $sql="select * from  engine_CATALOG_possvals where  id=".$f2[poss_val_id];
                                        }
                                $r1=mysql_query("$sql") or die (mysql_error()." $sql");
                                $f1=mysql_fetch_array($r1);
                                if ($f[type]=="Изображение"){
                                                $pic="$engine_show_htroot/engine/pics/catalog/0.gif";
                                                if (file_exists("$engine_show_root/engine/pics/catalog/pv_".$f1[id].".jpg"))
                                                        $pic="$engine_show_htroot/engine/pics/catalog/pv_".$f1[id].".jpg";
                                                if (file_exists("$engine_show_root/engine/pics/catalog/pv_".$f1[id].".gif"))
                                                        $pic="$engine_show_htroot/engine/pics/catalog/pv_".$f1[id].".gif";
                                                ${"fld".$f[id]}=$pic;
                                        }
                                if ($f[type]=="Текст"){
                                        ${"fld".$f[id]}=$f1[val];
                                        }
                                }
                        else {
                                $buf="";
                                $sql="select * from  engine_CATALOG_possvals where param=$f[id]";
                                $r1=mysql_query("$sql") or die (mysql_error());
                                while($f1=mysql_fetch_array($r1)) {
                                        $sql="select id from engine_CATALOG_values where item=$item[id] and param=$f[id] and poss_val_id=$f1[id]";
                                        $r2=mysql_query("$sql") or die (mysql_error());
                                        $f2=mysql_fetch_array($r2);
                                        if ($f[type]=="Изображение"){
                                                        $pic="$engine_show_htroot/engine/pics/catalog/0.gif";
                                                        if (file_exists("$engine_show_root/engine/pics/catalog/pv_".$f1[id].".jpg"))
                                                                $pic="$engine_show_htroot/engine/pics/catalog/pv_".$f1[id].".jpg";
                                                        if (file_exists("$engine_show_root/engine/pics/catalog/pv_".$f1[id].".gif"))
                                                                $pic="$engine_show_htroot/engine/pics/catalog/pv_".$f1[id].".gif";
                                                        if ($f2[id]){
                                                                $buf=str_replace("TEXT",$f1[val],$f[ms_format]);
                                                                $buf=str_replace("PIC",$pic,$buf);
                                                                }
                                                        else $buf="";
                                                }
                                        if ($f[type]=="Текст"){
                                                        if ($f2[id])                {
                                                                $buf=str_replace("TEXT",$f1[val],$f[ms_format]);
                                                                }
                                                }

                                        ${"fld".$f[id]}.=$buf;
                                        $buf="";
                                        }
                                }
                        }
                }
        if (++$item_num%2==0 and $this->spec[short_format2])
                $buf=$this->spec[short_format2];
        else
                $buf=$this->spec[short_format];
        $i=0;



        preg_match_all("|\[(fld\d+)\]|u",$this->spec[short_format],$reg,PREG_SET_ORDER);
        while ($reg[$i][0]){
                $buf=str_replace($reg[$i][0],${$reg[$i][1]},$buf);
                ${$reg[$i][1]}="";
                $i++;
                }
        $buf=str_replace('[LINK]',geturl($item[id]),$buf);
        $buf=str_replace('[PRICE]',$item[price],$buf);
        $buf=str_replace('[CAPTION]',$item[name],$buf);
        global $buscet;
        $buf=str_replace('[AMOUNT]',"<input id='amount_{$item[id]}' class=cat_amount name='buscet[0]' value='".($buscet[$item[id]]*1)."'>",$buf);
        $buf=str_replace('[BUYLINK]',"javascript:document.location=\"?buy=$item[id]&amount=\"+document.all.amount_{$item[id]}.value",$buf);

        $this->body.=$buf;
        }
$this->body.=str_replace("[pages]","Страницы ".$pages."<br><br>",$this->spec[postfix]);
//$this->body.="<br><br>Страницы ".$pages;

?>