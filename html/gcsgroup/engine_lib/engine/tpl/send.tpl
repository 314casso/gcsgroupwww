<link rel=stylesheet href="style.css" type="text/css" title="CSS style">
<script src="menu.js"></script>
<SCRIPT LANGUAGE="JavaScript">
var proc=window.parent.proc;
var move_to=window.parent.move_to;
var n=-1;
var d=-1;


function swtch1(num,name) {
	document.all.doc_id.value=num;
	document.all.docname.innerHTML=name;
	document.all['a'+n].style.background='#FFFFFF';
	document.all['a'+n].style.color='#005597'; 
	if ( num!=n) {
		document.all['a'+num].style.background='#006699';
		document.all['a'+num].style.color='#FFFFFF'; 
		}
	n=num;
	}
 document.execCommand("2D-Position", true, true);
    document.execCommand("MultipleSelection", true, true);
	
function mo(obj){
		obj.style.borderLeft="1 solid #FFFFFF";
		obj.style.borderTop="1 solid #FFFFFF";
		obj.style.borderRight="1 solid #A0A0A0";
		obj.style.borderBottom="1 solid #A0A0A0";
	}	
function ml(obj){
		obj.style.borderLeft="1 solid #C1C1C1";
		obj.style.borderTop="1 solid #C1C1C1";
		obj.style.borderRight="1 solid #C1C1C1";
		obj.style.borderBottom="1 solid #C1C1C1";
	}	
</SCRIPT>
				<form method=post action='?action=send'>
				<INPUT TYPE="hidden" name=do value=1>
				<INPUT TYPE="hidden" name=id value=ID>
				<TABLE border=0 width=100% >
					<TR>
						<TD  class=top width=320 height=300>
							<table cellpadding=0 width=100% cellspacing=0 >
								<TR>
									<TD width=1><img src='img/zakladki_pole/ugol_01_l.gif'></TD>
									<TD width=100%  background="img/zakladki_pole/polosa_01.gif " align=center>
									Рассылка
									</TD>
									<TD width=1><img src='img/zakladki_pole/ugol_01.gif'></TD>					
								</TR>
							<table cellpadding=0 width=100% cellspacing=5 style="border-left:1 solid;border-right:1 solid;border-bottom:1 solid"  bgcolor=#f6f6f6>
								<TR>
									<TD class=top >
									- Название(ID)
									</TD>
								</TR>
								<TR>
									<TD>
									<INPUT TYPE="text" name="name" size=40 value='NAME'>
									</TD>
								</TR>
								<TR>
									<TD class=top>
									- Документ
									</TD>
								</TR>
								<TR>
									<TD>
									<img style='cursor: hand;' onClick='javascript:{
										if (document.all.doclst.style.display==""){
											document.all.doclst.style.display="none";
											this.src="img/plus.jpg";
											}	
										else{
											document.all.doclst.style.display="";
											this.src="img/minus.jpg";
											}
									}' src='img/plus.jpg'> <span id=docname style="color:green;font-weight:bold">DOCNAME</span>
									<input type=hidden name="doc_id" id="doc_id" value='DOC_ID'>
									
									DOCLIST
									</TD>
									<td></td>
								</TR>
								<TR>
									<TD colspan=2 align=center><br>
									<INPUT TYPE="submit" class=but2 value='   OK   '>
									</TD>
								</TR>
							
							</table>
						</TD>
						<TD class=top style="text-align:right"	 >
							<table class=wnd cellpadding=3 cellspacing=0 width=300>
								<TR>
									<TD class=header>
									e-mail
									</TD>
									<TD class=header>&nbsp;</TD>
								</TR>
								<TR>
									<TD class=top>
									<input name=new_email size="40">
									</TD>
									<TD class=top>
									<a href='javascript:{document.all.neweml.value=1;document.forms[0].submit();}'><img border=0 src='img/icons/add.gif'></a>
									</TD>
								</TR>
									EMAILS
							
							</table>
						</TD>
					</TR>
				</TABLE>			
				<input type=hidden name=deleml id=deleml>
				<input type=hidden name=neweml id=neweml>
