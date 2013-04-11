<?

$sql = 'SELECT *
        FROM engine_documents
        WHERE pid="'.$id.'"
        ORDER BY name';

$dts_r = mysql_query($sql) or die (mysql_error()." in $sql");
$dts = '';

while ($dts_f = mysql_fetch_array($dts_r))
{
	if ($parent_doc_spec[doctoshow]!=$dts_f[id])
	{
		$dts.="<option value=$dts_f[id]>$dts_f[name]</option>";
	}
	else
	{
		$dts.="<option value=$dts_f[id] selected>$dts_f[name]</option>";
	}
}

$sql = 'SELECT *
        FROM engine_documents
        WHERE pid="'.$id.'"
        ORDER BY ord,name';

$dor_r= mysql_query($sql) or die (mysql_error()." in $sql");
$n_rows=mysql_num_rows($dor_r);

$i = 0;
$dor = '';

while ($dor_f = mysql_fetch_array($dor_r))
{
	$i++;
	$dor.='
<tr id="tr'.$i.'">
  <td>';
	if ($i != 1)
	{
		$dor .= '<a id="uptr'.$i.'" href="#" onclick="javascript:doup('.$i.');"><img border="0" src="img/up.gif" alt="¬верх" /></a>';
	}
	else
	{
		$dor .= '<a id="uptr'.$i.'" href="#" onclick="javascript:doup('.$i.');" style="display: none;"><img border="0" src="img/up.gif" alt="¬верх" /></a>';
	}

	$dor .= '</td><td>';
	if ($i != $n_rows)
	{
		$dor .= '<a id="downtr'.$i.'" href="#" onclick="javascript:dodown('.$i.');"><img border="0" src="img/down.gif" alt="¬низ" /></a>';
	}
	else
	{
		$dor .= '<a id="downtr'.$i.'" href="#" onclick="javascript:dodown('.$i.');" style="display: none;"><img border="0" src="img/down.gif" alt="¬низ" /></a>';
	}
	$dor .= '</td>';

	$dor .= '<td width="100%" class="top" style="padding-left: 8px;">'.$dor_f['name'].'</td>
  <td align="right"><input type="hidden" name="ord'.$dor_f['id'].'" id="ordtr'.$i.'" value="'.$i.'">';

	$dor .= '</tr>';
}

$dor = '<table width="100%" cellspacing="0" cellpadding="0"><tbody id="doc_ord">'.$dor.'</tbody></table>';

//$frmt=$parent_doc_spec[format];
$frmt=preg_replace("|format='(.*)'|Usi","\\1",$parent_doc_spec[format]);

if ($parent_doc_spec['notinpath'])
$notinpath='checked';

$tpl->assign(
	array(
		DOCSTOSHOW	=>	$dts,
		DOCSORDER	=>	$dor,
		FORMAT	=> 	$frmt,
		NOTINPATH	=> 	$notinpath
	)
);

?>
<script>
function shupdown(){
	for (i=0;i<document.all.doc_ord.childNodes.length;i++){
		var tr=document.all.doc_ord.childNodes[i];
		var up=eval("document.all.up"+tr.id);
		var down=eval("document.all.down"+tr.id);
		if (i==0){
			up.style.display='none';
			down.style.display='';
			}
		else{
			if(i== (document.all.doc_ord.childNodes.length-1)){
				up.style.display='';
				down.style.display='none';
				}
			else {
				up.style.display='';
				down.style.display='';
				}
			}
		}
	}

function doup(n){
	var tr=eval("document.all.tr"+n),i=0;
	while(document.all.doc_ord.childNodes[i]!=tr){
		i++;
		}
	if (i>0) {
		var ntr=document.all.doc_ord.childNodes[i-1];
		ntr.insertAdjacentElement("beforeBegin",  tr );
		var ord1=eval("document.all.ord"+tr.id);
		var ord2=eval("document.all.ord"+ntr.id);
		var buf_ord=ord1.value;
		ord1.value=ord2.value;
		ord2.value=buf_ord;
		}
	shupdown();
	}
function dodown(n){
	var tr=eval("document.all.tr"+n),i=0;
	while(document.all.doc_ord.childNodes[i]!=tr){
		i++;
		}
	if (i<document.all.doc_ord.childNodes.length-1) {
		var ntr=document.all.doc_ord.childNodes[i+1];
		ntr.insertAdjacentElement("afterEnd",  tr );
		var ord1=eval("document.all.ord"+tr.id);
		var ord2=eval("document.all.ord"+ntr.id);
		var buf_ord=ord1.value;
		ord1.value=ord2.value;
		ord2.value=buf_ord;
		}
	shupdown();

	}


</script>