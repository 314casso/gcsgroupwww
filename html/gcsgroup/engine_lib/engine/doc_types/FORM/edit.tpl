<script>
function hs_reg_param(){
									var i=0;
									if (document.all.send_reg.checked){

										document.all.send_URL.checked=false;
										document.all.namehdr.style.display='none';
										document.all.actcap.style.display='none';
										document.all.act.style.display='none';
										for (i=0;i<=count;i++){
											td=eval('document.all.name'+i);
											td.parentNode.style.display='none';
											}
										document.all.urltr.style.display='none';
										}
									else{
										document.all.urltr.style.display='';
										}

	}

function hs_URL_param(){
									var i=0;
									if (document.all.send_URL.checked){
										document.all.actcap.style.display='';
										document.all.act.style.display='';
										document.all.namehdr.style.display='';
										for (i=0;i<=count;i++){
											td=eval('document.all.name'+i);
											td.parentNode.style.display='';
											}
										document.all.send_bd.checked=false;
										document.all.send_email.checked=false;

										document.all.emailcap.style.display='none';
										document.all.email.style.display='none';
										document.all.bdfhdr.style.display='none';
										document.all.bdcap.style.display='none';
										document.all.bd.style.display='none';
										document.all.bdfhdr.style.display='none';
										document.all.bdcap.style.display='none';
										for (i=0;i<=count;i++){
											td=eval('document.all.bdfield'+i);
											td.parentNode.style.display='none';
											}
										}
									else {
										document.all.namehdr.style.display='none';
										document.all.actcap.style.display='none';
										document.all.act.style.display='none';
										for (i=0;i<=count;i++){
											td=eval('document.all.name'+i);
											td.parentNode.style.display='none';
											}

										}
			}
function hs_bd_param(){
									var i=0;
									if (document.all.send_bd.checked){
										document.all.bdcap.style.display='';
										document.all.bd.style.display='';
										document.all.bdfhdr.style.display='';
										for (i=0;i<=count;i++){
											td=eval('document.all.bdfield'+i);
											td.parentNode.style.display='';
											}

										document.all.send_URL.checked=false;
										document.all.namehdr.style.display='none';
										document.all.actcap.style.display='none';
										document.all.act.style.display='none';
										for (i=0;i<=count;i++){
											td=eval('document.all.name'+i);
											td.parentNode.style.display='none';
											}

										}
									else {
										document.all.bdfhdr.style.display='none';
										document.all.bdcap.style.display='none';
										document.all.bd.style.display='none';
										for (i=0;i<=count;i++){
											td=eval('document.all.bdfield'+i);
											td.parentNode.style.display='none';
											}

										}
			}
</script>

<tr>
  <td><span class="cat"><img src="img/arrow.gif" border="0" vspace="2"> Действие</span></td>
</tr>
<tr>
  <td>
    <table>
      <tr>
        <td>&nbsp;&nbsp;</td>
        <td><input SEND_EMAIL name=send_email id=send_email type=checkbox onclick="{
									if (document.all.send_email.checked){
										document.all.emailcap.style.display='';
										document.all.email.style.display='';

										document.all.send_URL.checked=false;
										document.all.namehdr.style.display='none';
										document.all.actcap.style.display='none';
										document.all.act.style.display='none';
										for (i=0;i<=count;i++){
											td=eval('document.all.name'+i);
											td.parentNode.style.display='none';
											}


										}
									else {
										document.all.emailcap.style.display='none';
										document.all.email.style.display='none';
										}



									}"></td>
        <td><span class="cat"><img src="img/arrow.gif" border="0" vspace="2"> Отправить по почте</span></td>
      </tr>
      <tr>
        <td>&nbsp;&nbsp;</td>
        <td><input SEND_BD name=send_bd  type=checkbox id=send_bd type=checkbox  onclick="hs_bd_param();"></td>
        <td><span class="cat"><img src="img/arrow.gif" border="0" vspace="2"> Записать в базу</span></td>
      </tr>
      <tr id=urltr style='display:SHOWURLtr;'>
        <td>&nbsp;&nbsp;</td>
        <td><input SEND_URL type=checkbox name=send_URL id=send_URL onclick="hs_URL_param();"></td>
        <td><span class="cat"><img src="img/arrow.gif" border="0" vspace="2"> Отправить на URL</span></td>
      </tr>
    </table>
  </td>
</tr>
<tr>
  <td><span class="cat"><img src="img/arrow.gif" border="0" vspace="2"> Форма используется для регистрации пользователей</span></td>
</tr>
<tr>
  <td><input type=checkbox SEND_REG name=send_reg id=send_reg onclick="hs_reg_param();"></td>
</tr>
<tr id=actcap style='display:SHOWACT;'>
  <td><span class="cat"><img src="img/arrow.gif" border="0" vspace="2"> Action</span></td>
</tr>
<tr id=act style='display:SHOWACT;'>
  <td><input name="form_action" class="com_input" value="FORM_ACTION"></td>
</tr>
<tr id=emailcap style='display:SHOWEMAIL;'>
  <td class=top   >
    <table cellpadding="0" cellspacing="0">
      <tr>
        <td><span class="cat"><img src="img/arrow.gif" border="0" vspace="2"> e-mail</span></td>
        <td>&nbsp;&nbsp;&nbsp;</td>
        <td><span class="cat"><img src="img/arrow.gif" border="0" vspace="2"> Кодировка</span></td>
      </tr>
      <tr id=email style='display:SHOWEMAIL;'>
        <td><input name="form_email" class=form2 value="FORM_EMAIL"></td>
        <td>&nbsp;&nbsp;&nbsp;</td>
        <td><select name="form_email_coding" class=form >
		<option value='w' WSEL>win1251</option>
		<option value='k' KSEL>KOI8-R</option>
	   </select>
        </td>
      </tr>
    </table>
  </td>
</tr>
<tr id=bdcap style='display:SHOWBD;'>
  <td><span class="cat"><img src="img/arrow.gif" border="0" vspace="2"> Имя таблицы БД</span></td>
</tr>
<tr id=bd style='display:SHOWBD;'>
  <td><INPUT name="form_bd" value="FORM_BD" class="com_input"></td>
</tr>
<tr>
  <td><span class="cat"><img src="img/arrow.gif" border="0" vspace="2"> Текст, выдающийся после заполнения формы</span></td>
</tr>
<tr>
  <td><textarea name="form_text" style="width: 450px;" rows="2">FORM_MSG</textarea></td>
</tr>
<tr>
  <td><span class="cat"><img src="img/arrow.gif" border="0" vspace="2"> Надпись на кнопке</span></td>
</tr>
<tr>
  <td><input name="form_button" class="com_input" value='FORM_BUTTON' class="com_input" size="40"></td>
</tr>
<tr>
  <td><span class="cat"><img src="img/arrow.gif" border="0" vspace="2"> Описание формы (отображается над формой)</span></td>
</tr>

<tr>
  <td><textarea name="form_desc" style="width: 450px;" rows="2">FORM_DESC</textarea></td>
</tr>

<tr>
  <td><span class="cat"><img src="img/arrow.gif" border="0" vspace="2"> Поля</span>
  <script>
  function fillsel(tdid)
  {  	td=eval("document.all."+tdid);
	sel=td.childNodes[0];
	document.all.selcaps.value="";
	document.all.selvals.value="";
	for(i=0;i<sel.options.length;i++)
	{		document.all.selcaps.value+=sel.options[i].text;
		document.all.selvals.value+=sel.options[i].value;
//		alert (document.all.selvals.value);
		if (i!=sel.options.length-1)
		{
			document.all.selcaps.value+="\n";
			document.all.selvals.value+="\n";
		}
	}
  }
  </script>
  <input type=hidden name=field_count id=field_count>
  <table class=wnd id=seledit style='display:none;border:1 solid #005597' width=270>
    <tr><td>Заголовки</td><td>Значения</td></tr>
							<tr><td><textarea  id=selcaps cols=20 rows=10>sa</textarea></td>
							<td><textarea id=selvals cols=7 rows=10>as</textarea></td></tr>
							<tr><td colspan="2" align=center><input type=button value="- ОК -" class="but2" onclick='{
								var str="",val="";
								var str=document.all.selvals.value;
								var vals=new Array(100);
								var caps=new Array(100);
								opts="<option val=";
								c=0;
								a=0;
								n="\n";
								while (c<str.length){
									if (str.charAt(c)!="\n"){
										val+=str.charAt(c);
										}
									else{
										val=val.substring(0,(val.length-1));
										vals[a]=val;
										val="";
										a++;
										}
									c++;
									}
								vals[a]=val;
								a++;

								a1=0;c=0;val="";
								str=document.all.selcaps.value;
								while (c<str.length){
									if (str.charAt(c)!="\n"){
										val+=str.charAt(c);
										}
									else{
										val=val.substring(0,(val.length-1));
										caps[a1]=val;
										val="";
										a1++;
										}
									c++;
									}
								caps[a1]=val;
								a1++;

								res="";
								sel.options.length=0;
								for (i=0;i < a||i<a1;i++){
									sel.options[i]= new Option(caps[i],vals[i]);
									}
								document.all.seledit.style.display="none";
								}'></td></tr>
						</table>
						<table class=wnd id=add style='display:none;' width=270>
							<tr><td class=header>Добавление элемента формы</td></tr>
							<tr><td align="center"><select  id=addsel>
							<option value=1>Текстовое поле</option>
							<option value=2>Выпадающий список</option>
							<option value=3>Флажок</option>
							<option value=4>Текстовая область</option>
							</select></td></tr>
							<tr><td colspan="1" align=center><input type=button value="- ОК -" class="but2"  onclick='
							{
					count++;
					tr=document.createElement("tr");
					tr.id="tr"+count;
					tr.name=count;
					td=document.createElement("td");

					td.innerHTML="<input class=form2 id=caption"+count+" name=caption"+count+" >"+
					"<input type=hidden id=ord"+count+" name=ord"+count+" value="+count+">";
					tr.insertAdjacentElement("beforeEnd",td);

					td=document.createElement("td");
					if (!(document.all.send_URL.checked)){
						td.style.display="none";
						}


					td.innerHTML="<input class=form2 id=name"+count+" name=name"+count+" onchange={document.all.td"+count+".childNodes[0].name=this.value;}>";
					tr.insertAdjacentElement("beforeEnd",td);

					td=document.createElement("td");
					if (!(document.all.send_bd.checked)){
						td.style.display="none";
						}


					td.innerHTML="<input class=form2  id=bdfield"+count+" name=bdfield"+count+" onchange={document.all.td"+count+".childNodes[0].name=this.value;}>";
					tr.insertAdjacentElement("beforeEnd",td);



					td=document.createElement("td");
					td.id="td"+count;
					if (document.all.addsel.value==1)
						td.innerHTML="<input  type=text >";
					if (document.all.addsel.value==2)
						td.innerHTML="<select ></select>";
					if (document.all.addsel.value==3)
						td.innerHTML="<input  type=checkbox >";
					if (document.all.addsel.value==4)
						td.innerHTML="<textarea ></textarea>";
					tr.insertAdjacentElement("beforeEnd",td);

					td=document.createElement("td");
					td.innerHTML="<input type=hidden name=field"+count+">";
					if (document.all.addsel.value==2)
						td.innerHTML+="<a href=\"#\" onclick={fillsel(td"+count+".id);document.all.seledit.style.display=\"\"};>edit</a>	";
					tr.insertAdjacentElement("beforeEnd",td);

					td=document.createElement("td");
					td.innerHTML=ihup();
					tr.insertAdjacentElement("beforeEnd",td);
					td=document.createElement("td");
					td.innerHTML=ihdown();
					tr.insertAdjacentElement("beforeEnd",td);
					td=document.createElement("td");
					td.innerHTML=ihdel();



					tr.insertAdjacentElement("beforeEnd",td);


					td=document.createElement("td");
					td.innerHTML="<input  type=Checkbox id=required"+count+" name=required"+count+">";
					tr.insertAdjacentElement("beforeEnd",td);



//					var ntr=document.all.form_tbl.childNodes[document.all.form_tbl.childNodes.length-1];
//					ntr.insertAdjacentElement("AfterEnd",  tr );
					var ntr=document.all.form_tbl;
					ntr.insertAdjacentElement("BeforeEnd",  tr );
					udhide();
					document.all.add.style.display="none";
					}

							'></td></tr>
						</table>
						</td>
					</tr>
					<tr>
						<td valign=top>
							FIELDS
						</td>
					</tr>
<tr>
  <td>  <span class="cat"><img src="img/arrow.gif" border="0" vspace="2"> <input type=checkbox style="vertical-align: middle;" SEND_CONTROL name=send_control id=send_control onclick="hs_reg_param();"> Проверка данных </span>
  <br><br>
<span class="cat"><img src="img/arrow.gif" border="0" vspace="2"> Текст при проверке данных</span><br>
 <textarea name="text_control" style="width: 500px; height: 100px;" rows="2">FORM_CONTROL</textarea>

  <br><br>
<span class="cat"><img src="img/arrow.gif" border="0" vspace="2"> Формат вывода формы</span><br>
 <textarea name="form_format" style="width: 500px; height: 100px;" rows="2">FORM_FORMAT</textarea>
</td>
</tr>
