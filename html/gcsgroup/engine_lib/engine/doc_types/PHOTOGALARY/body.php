<?
global $page,$engine_show_root,$engine_show_htroot;
$page=(int)$page;

global $total;
$lister = lister("?",($this->spec[rows]*$this->spec[cols]),"engine_PHOTOGALARY_cells","gal_id=".$this->id);

if ($total <= $this->spec[rows]*$this->spec[cols])
{
    $lister = '';
}

$this->body.= "<table class=PHOTOGALARY_table  border=0 cellpadding=2 width=10>
<TR class=PHOTOGALARY_listertr><TD class=PHOTOGALARY_listertd colspan={$this->spec[cols]}>".$lister.
"</TD></TR>";
$r=mysql_query("select * from engine_PHOTOGALARY_cells where gal_id={$this->id} order by ord limit $page,".($this->spec[rows]*$this->spec[cols]));
while($f=mysql_fetch_array($r)) {

    if (($i%($this->spec[cols]))==0){
        $this->body.= "<tr class=PHOTOGALARY_tr>";
        }
    if (file_exists("$engine_show_root/engine/pics/PHOTOGALARY/spic$f[id].jpg"))
        $spic="/engine/pics/PHOTOGALARY/spic$f[id].jpg";
    else if (file_exists("$engine_show_root/engine/pics/PHOTOGALARY/spic$f[id].gif"))
        $spic="/engine/pics/PHOTOGALARY/spic$f[id].gif";
    else {
        $spic="/engine_lib/engine/img/1x1.gif";
        $sz=" width=120 height=100 ";

        }
    if (file_exists("$engine_show_root/engine/pics/PHOTOGALARY/bpic$f[id].jpg")) {
        $bpic="/engine/pics/PHOTOGALARY/bpic$f[id].jpg";
        $bbpic="$engine_show_root/engine/pics/PHOTOGALARY/bpic$f[id].jpg";
    }
    else if (file_exists("$engine_show_root/engine/pics/PHOTOGALARY/bpic$f[id].gif")) {
        $bpic="/engine/pics/PHOTOGALARY/bpic$f[id].gif";
        $bbpic="$engine_show_root/engine/pics/PHOTOGALARY/bpic$f[id].gif";
    }
    else {
        $bpic="$engine_show_htroot/engine_lib/engine/img/1x1.gif";
        }
        $is=getimagesize($bbpic);
      $this->body.= "
            <td class=PHOTOGALARY_td><a href=# onclick='window.open(\"".$bpic."\", \"\", \"width=".($is[0]+20).",height=".($is[1]+30).",toolbar=no,menubar=no,resizable=no,status=no\");return false;'><img border=0 class=\"photo_image\" $sz src='$engine_show_htroot$spic?".filesize($engine_show_root.$spic)."'></a></td>
        ";
    $buf1.="<td class=PHOTOGALARY_text1>".str_replace("\\","",$f[text1])."</td>";
    $buf2.="<td class=PHOTOGALARY_text2>$f[text2]</td>";
    $buf3.="<td class=PHOTOGALARY_text3>$f[text3]</td>";
    $i++;
    if (($i%($this->spec[cols]))==0 || $i==mysql_num_rows($r)){
        $this->body.= "</tr>" ;
        $this->body.= "<tr>$buf1</tr>" ;
        $this->body.= "<tr>$buf2</tr>" ;
        $this->body.= "<tr>$buf3</tr>" ;
        $buf1="";
        $buf2="";
        $buf3="";
        }
      }
$this->body.= "</table>";


?>