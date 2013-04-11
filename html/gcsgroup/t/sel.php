<script language=javascript>
function changeval()
{
 var val1 = document.sform.sel1.value;
 var optionArray = eval(val1);
 for(var df=0; df<optionArray.length; df++)
 {
  var ss = document.sform.sel2;
  ss.options.length = 0;
  for(var ff=0; ff<optionArray.length; ff++)
  {
   var val = optionArray[ff];
   ss.options[ff] = new Option(val,val);
  }
 }
}

<?php

require_once "_global.php";
_db();


$t=_db_exe("select distinct nomos from hotels");

$i=1;
$tnum="var n_number = new Array(";
$tnam="var n_name = new Array(";
while($tt = mysql_fetch_array($t)) {
    $tnum.="\"nom".$i."\",";
    $tnam.="\"".$tt['nomos']."\",";
    $i++;
} 
$tnum.="\"\");\n";
$tnam.="\"\");\n";
echo $tnum.$tnam;
$i=1;
$t=_db_exe("select distinct nomos from hotels");
while($tt = mysql_fetch_array($t)) {

    $tn=_db_exe("select distinct isl_id from hotels where nomos='".$tt['nomos']."'");
    if (mysql_num_rows($tn)>1) {
        $is_name="nom".$i."=new Array(";
        while($ttn = mysql_fetch_array($tn)) {
            $is_name.="\"".$ttn['isl_id']."\",";
        }
        $is_name.="\"\");\n";
        echo $is_name;
    }
$i++;
}
?>
var aa = new Array("state1","state2","state3");
state1 = new Array("city1","city2");
state2 = new Array("city21","city22","city23");
state3 = new Array("city31","city32","city33");

</script>

<form name=sform>
<select name=sel1 onchange=changeval()>
<script language=javascript>
for(var dd=0; dd<n_number.length; dd++)
{
 document.write("<option value=\""+n_number[dd]+"\">"+n_name[dd]+"</option>");
}
</script>
</select>

<select name=sel2>
</select>

</form>
<?

$bo=split(";", "shops;thalassotherapy");
$hf=$_POST['hf'];

if  ($hf) {

  $th=  "select * from hotels where ";
  $i=0;
  foreach ($hf as $hfk=>$hfv) {
    if ($i>0) $th.=" and ";
    $th.=$hfk."='".$hfv."'";
    $i++;
  }
  echo $th."<br>";  
}
$s_nomos="<select name=hf[nomos]>";
$t=_db_exe("select distinct nomos, isl_id  from hotels");

        while($tt = mysql_fetch_array($t)) {
        $s_nomos.="<option value=\"".$tt['nomos']."\"";
        if ($tt['isl_id']) $s_nomos.=" onFocus=\"alert('".$tt['isl_id']."')\"";
        $s_nomos.=">".$tt['nomos']."</option>\n";
        }
$s_nomos.="</select>";

echo "<form method=post>".$s_nomos;
foreach ($bo as $bov) {
    echo ("<br><input type=checkbox value=1 name=hf[".$bov."]> ".$bov);
}
echo "<input type=submit>";


?>