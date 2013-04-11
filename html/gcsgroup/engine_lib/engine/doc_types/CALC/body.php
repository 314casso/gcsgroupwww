<?
$this->body="
<script>
	function doit(){
		try{
	";
		$sql="select * from engine_CALC_param where calc=".$this->id;
		$r=mysql_query("$sql") or die (mysql_error());
		$formula=$this->spec[formula];
		while($f=mysql_fetch_array($r)){
			$formula=str_replace('['.$f[name].']',"document.all.param$f[id].value*1",$formula);
			}
			
		$this->body.="
		var k=$formula;
		k=k*100;
		k=Math.round(k);
		k=k/100;
		document.all.res.innerHTML=k;
/*		
alert (document.all.param2.value*1);		
alert (document.all.param1.value*1);		
alert (a1[document.all.param2.value*1][document.all.param1.value*1]);
*/
		}
	catch(e){
		document.all.res.innerHTML='ошибка!!!';
		}
	}
</script>		";
$this->body.="

<table	border=1 cellpadding=4>
";
	$r=mysql_query("$sql") or die (mysql_error());
	while($f=mysql_fetch_array($r)){
		$this->body.="<tr><td>$f[name]</td><td>";
		$sql="select * from  engine_CALC_vals where  param=".$f[id];
		$r1=mysql_query("$sql") or die (mysql_error()." $sql");
		if (mysql_num_rows($r1)){
			$this->body.="<select name=param$f[id] id=param$f[id] >";
			while($f1=mysql_fetch_array($r1)){
				$this->body.="<option value='$f1[val]'>$f1[text]</option>";
				}
			$this->body.="</select>";
			}
		else{
			$this->body.="<input name=param$f[id] id=param$f[id] >";
			
			}
		$this->body.="</td></tr>";
			
		}				
$this->body.="
<tr><td colspan=1><b>Результат:</b></td><td><div id=res style='color:red'>нет значения</div></td></tr></table>
<button value=\"Посчитать\" onclick='doit()'>Посчитать</button>
";
?>




