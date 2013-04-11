<script>
					function ihdel(){
						return "	<a href='#fldeditor' onclick='{"+
'									var tr=document.all.tr'+count+';'+
'									tr.removeNode(true);'+
'									udhide();'+
"									}'><img border=0 src=doc_types/FORM/img/del.gif></a>";
						}
 					function ihdown(){
						return ""+
"							<div id=td_down"+count+" $l style='display:none;' >"+
"								<a href='#fldeditor' id=down"+count+" onclick='"+
'								var l=document.all.form_tbl.childNodes.length;												'+
'								var tr=document.all.tr'+count+';												'+
'								var i=0;												'+
'								while (document.all.form_tbl.childNodes[i]!=tr){												'+
'									i++;												'+
'									}												'+
'								if (i<l-1){												'+
'									var ntr=document.all.form_tbl.childNodes[i+1];												'+
'									ntr.insertAdjacentElement("afterEnd",  tr );												'+
'									var ord1=eval("document.all.ord"+tr.name);												'+
'									var ord2=eval("document.all.ord"+ntr.name);												'+
'									var buf_ord=ord1.value;												'+
'									ord1.value=ord2.value;												'+
'									ord2.value=buf_ord;												'+
'									var down=eval("document.all.td_down"+tr.name);												'+
'									var up=eval("document.all.td_down"+(ntr.name));												'+
'									if (i==l-2){												'+
'										down.style.display="none";												'+
'										up.style.display="";												'+
'										}												'+
'									var up=eval("document.all.td_up"+ntr.name);												'+
'									var down=eval("document.all.td_up"+tr.name);												'+
'									if (i==0){												'+
'										up.style.display="none";												'+
'										down.style.display="";												'+
'										}												'+
'									}												'+
"								'><img border=0 src=doc_types/FORM/img/down.gif></a>												"+
"								</div>"

					}
 					function ihup(){
					return ""+
"						<div id=td_up"+count+" >"+
"								<a href='#fldeditor'  onclick='"+
'									var l=document.all.form_tbl.childNodes.length;																'+
'									var tr=document.all.tr'+count+';									'+
'									var i=0;																'+
'									while (document.all.form_tbl.childNodes[i]!=tr){																'+
'										i++;																'+
'										}																'+
'									if (i>0){																'+
'										var ntr=document.all.form_tbl.childNodes[i-1];																'+
'										ntr.insertAdjacentElement("beforeBegin",  tr );																'+
'										var ord1=eval("document.all.ord"+tr.name);																'+
'										var ord2=eval("document.all.ord"+ntr.name);																'+
'										var buf_ord=ord1.value;																'+
'										ord1.value=ord2.value;																'+
'										ord2.value=buf_ord;																'+
'										var up=eval("document.all.td_up"+tr.name);																'+
'										var down=eval("document.all.td_up"+(ntr.name));																'+
'										if (i==1){																'+
'											up.style.display="none";																'+
'											down.style.display="";																'+
'											}																'+
'									var down=eval("document.all.td_down"+ntr.name);																'+
'										var up=eval("document.all.td_down"+(tr.name));																'+
'									if (i==l-1){																'+
'										down.style.display="none";																'+
'										up.style.display="";																'+
'										}																'+
'									}																'+
'								'+"'><img border=0 src=doc_types/FORM/img/up.gif></a>"+
"								</div>";
						}
</script>
<?
				$f_sql="select * from engine_FORM_fields where doc_id=$id order by field_ord";
				$f_r=mysql_query($f_sql);
				$l=mysql_num_rows($f_r)-1;
				$str="
				<script>
					var count=$l;
					</script>
 				<a href='#fldeditor' onclick='document.all.add.style.display=\"\";document.all.seledit.style.display=\"none\";'><img border=0 src=doc_types/FORM/img/add.gif></a> ";

				$str.="
				<script>
						function udhide(){
							var l=-1;
							var i=-1,k=0;
							while (k<document.all.form_tbl.childNodes.length){
								if  (document.all.form_tbl.childNodes[k].tagName==\"TR\"){
									l=k;
									if (i==-1)i=k;
									}
								k++;
								}
							if (l!=-1){
								up=eval(\"document.all.td_up\"+document.all.form_tbl.childNodes[i].name);
								up.style.display=\"none\";
								var down=eval(\"document.all.td_down\"+document.all.form_tbl.childNodes[l].name);

								down.style.display=\"none\";

								if (l>0){
									up=eval(\"document.all.td_up\"+document.all.form_tbl.childNodes[i+1].name);
									up.style.display=\"\";
									var down=eval(\"document.all.td_down\"+document.all.form_tbl.childNodes[l-1].name);
									down.style.display=\"\";
									}
								}
							}
						</script>
<table width=100% class=line cellpadding=3 cellspacing=1>
<tr>
  <th>Вопрос</th>
  <th ";
  if (!$parent_doc_spec[send_URL])
  {
  	$str.="style='display:none'";
  }

  $str.=" id=namehdr>name</th>
  <th class=header ";

  if (!$parent_doc_spec[send_bd])
  {
  	$str.="style='display:none'";
  }

  $str.=" id=bdfhdr>bd field</th>
  <th>отображение</th>
  <th colspan=4>Редактирование</th>
  <th>Обязателное поле</th>
</tr>
					<tbody id=form_tbl>";
				$i=0;
				while($f_f=mysql_fetch_array($f_r)){
					$add_ = '';
					if ($f_f[id]) $add_ = "(fld".$f_f[id].")";
					$str.="
						<tr id=tr$i name=$i>
							<td >
							<input class=com_input id=caption$i name=caption$i value='$f_f[field_caption]'> $add_
							<input type=hidden id=ord$i name=ord$i value=$i>
							<input type=hidden id=id_field$i name=id_field$i value=$f_f[id]>
							</td>
							<td ";
					if (!$parent_doc_spec[send_URL])
						$str.="style='display:none'";
					$str.="	 >
							<input class=com_input id=name$i name=name$i value='$f_f[field_name]'>
							</td>
							<td ";
					if (!$parent_doc_spec[send_bd])
						$str.="style='display:none'";
					$str.="	 >
							<input class=com_input id=bdfield$i name=bdfield$i value='$f_f[field_bd_name]'>
							</td>
							<td id=td$i>
							$f_f[field_text]";
						if(stristr($f_f[field_text],"<select"))
							$str.= "<td><input type=hidden name=field$i><a href=\"#fldeditor\" onclick={fillsel('td$i');document.all.seledit.style.display=\"\";document.all.add.style.display=\"none\"};><img border=0 src=doc_types/FORM/img/edit.gif></a></td>";
						else $str.= "<td><input type=hidden name=field$i></td>";
					$str.="
							</td>
							<td ><div id=td_up$i ";if ($i==0) {$str.= "style='display:none;'";}$str.=">
								<a href='#fldeditor'  onclick='
									var l=document.all.form_tbl.childNodes.length;
									var tr=document.all.tr$i;
									var i=0;
									while (document.all.form_tbl.childNodes[i]!=tr){
										i++;
										}
									if (i>0){
										var ntr=document.all.form_tbl.childNodes[i-1];
										ntr.insertAdjacentElement(\"beforeBegin\",  tr );
										var ord1=eval(\"document.all.ord\"+tr.name);
										var ord2=eval(\"document.all.ord\"+ntr.name);
										var buf_ord=ord1.value;
										ord1.value=ord2.value;
										ord2.value=buf_ord;

										var up=eval(\"document.all.td_up\"+tr.name);
										var down=eval(\"document.all.td_up\"+(ntr.name));
										if (i==1){
											up.style.display=\"none\";
											down.style.display=\"\";
											}
										var down=eval(\"document.all.td_down\"+ntr.name);
										var up=eval(\"document.all.td_down\"+(tr.name));
										if (i==l-1){
											down.style.display=\"none\";
											up.style.display=\"\";
											}
										}
									'><img border=0 src=doc_types/FORM/img/up.gif></a>
									</div>
							</td>
							<td ><div id=td_down$i $l ";if ($i==$l) {$str.= "style='display:none;'";}$str.=" >
								<a href='#fldeditor' id=down$i onclick='
									var l=document.all.form_tbl.childNodes.length;
									var tr=document.all.tr$i;
									var i=0;
									while (document.all.form_tbl.childNodes[i]!=tr){
										i++;
										}
									if (i<l-1){
										var ntr=document.all.form_tbl.childNodes[i+1];
										ntr.insertAdjacentElement(\"afterEnd\",  tr );
										var ord1=eval(\"document.all.ord\"+tr.name);
										var ord2=eval(\"document.all.ord\"+ntr.name);
										var buf_ord=ord1.value;
										ord1.value=ord2.value;
										ord2.value=buf_ord;

										var down=eval(\"document.all.td_down\"+tr.name);
										var up=eval(\"document.all.td_down\"+(ntr.name));
										if (i==l-2){
											down.style.display=\"none\";
											up.style.display=\"\";
											}
										var up=eval(\"document.all.td_up\"+ntr.name);
										var down=eval(\"document.all.td_up\"+tr.name);
										if (i==0){
											up.style.display=\"none\";
											down.style.display=\"\";
											}
										}
									'><img border=0 src=doc_types/FORM/img/down.gif></a>
									</div>
							</td>
							<td>
								<a href='#fldeditor' onclick='{
									var tr=document.all.tr$i;
									tr.removeNode(true);
									udhide();
									}'><img border=0 src=doc_types/FORM/img/del.gif></a>
							</td>
							<td>
								<input type=checkbox name='required$i' ";
								if ($f_f[required]) $str.="checked";
								$str.=">
							</td>
						</tr>
						";
					$i++;
					}
				$str.="
						</tbody>
					</table>
					<script>

					</script>
					";
//echo "!!$str";


				if ($parent_doc_spec[send_email]){
					$parent_doc_spec[send_email]='checked';
					$showemail='';
					}
				else {
					$parent_doc_spec[send_email]='';
					$showemail='none';
					}
				if ($parent_doc_spec[send_bd]){
					$parent_doc_spec[send_bd]='checked';
					$showbd='';
					}
				else {
					$parent_doc_spec[send_bd]='';
					$showbd='none';
					}
				if ($parent_doc_spec[send_URL]){
					$parent_doc_spec[send_URL]='checked';
					$showact='';
					}
				else {
					$parent_doc_spec[send_URL]='';
					$showact='none';
					}
				if ($parent_doc_spec[send_reg]){
					$parent_doc_spec[send_reg]='checked';
					$showact='none';
					$showurltr='none';
					}
				else {
					$parent_doc_spec[send_reg]='';

					}
				if ($parent_doc_spec[send_control]){
					$parent_doc_spec[send_control]='checked';
				}


				if ($parent_doc_spec[coding]=='k'){
					$ksel='selected';
					$wsel='';
					}
				else {
					$ksel='';
					$wsel='selected';
					}

				$tpl->assign(
						array(
							WSEL		=> $wsel,
							KSEL		=> $ksel,
							SHOWBD		=> $showbd,
							SHOWEMAIL	=> $showemail,
							SHOWACT		=> $showact,
							SHOWURLTR	=> $showurltr,
							SEND_REG	=> $parent_doc_spec[send_reg],
							SEND_CONTROL	=> $parent_doc_spec[send_control],
							FORM_CONTROL	=> $parent_doc_spec[text_control],
							FORM_FORMAT	=> $parent_doc_spec[form_format],


							SEND_EMAIL	=> $parent_doc_spec[send_email],
							SEND_BD		=> $parent_doc_spec[send_bd],
							SEND_URL	=> $parent_doc_spec[send_URL],
							FIELDS		=> $str,
							FORM_ACTION => $parent_doc_spec[action],
							FORM_BD		=> $parent_doc_spec[bd],
							FORM_EMAIL	=> $parent_doc_spec[email],
							FORM_MSG	=> $parent_doc_spec[text],
							FORM_DESC	=> $parent_doc_spec[desc],
							FORM_BUTTON	=> $parent_doc_spec[button]
						)
					);

?>
