<link rel=stylesheet href="style.css" type="text/css" title="CSS style">
<LINK href="{engine_htroot}/engine/main.css" rel="stylesheet" type="text/css">
<script>
var n=-1;
var d=-1;
function swtch1(num,dcode) {
        if (!dcode)
                document.all.doccode.value=num;
        else
                document.all.doccode.value=dcode;
//        document.all.docname.innerHTML=name;
        document.all['a'+n].style.background='#FFFFFF';
        document.all['a'+n].style.color='#005597';
        if ( num!=n) {
                document.all['a'+num].style.background='#006699';
                document.all['a'+num].style.color='#FFFFFF';
                }
        n=num;
        }

var selected_doc = -1;

function SetCode(doc_id)
{
        doc = GetDocInfo(doc_id);
        inp = document.getElementById('doccode');
        if (inp)
        {
                inp.value = doc[5];
        }

        if (doc_id != selected_doc)
        {
        	link = document.getElementById('doc_'+doc_id);
        	link.className = 'tree_selected';
        	link = document.getElementById('doc_'+selected_doc);
        	link.className = 'tree';
        	selected_doc = doc_id;
        }
}


SCRIPTPART
</script>



<script src="/engine_lib/engine/menu.js"></script>

                                <form method=post action='?action=rubrique'>
                                <INPUT TYPE="hidden" name=do value=1>
                                <INPUT TYPE="hidden" name=id value=ID>
                                <TABLE cellspacing=0 cellpadding=0  align=center width=500 >
     <tr>
           <TD width=1><img id=comtbl_tdl  src='img/zakladki_pole/ugol_01_l.gif'></TD>
          <TD width=100% id=comtbl_td   background="img/zakladki_pole/polosa_01.gif " align=center><b>Рубрика 'NAME' </b></TD>
          <TD width=1><img id=comtbl_tdr  src='img/zakladki_pole/ugol_01.gif'></TD>
     </tr>
     <tr><td colspan=3>
     <table cellspacing=0 cellpadding=5 style="border:solid 1"
                                        <TR  bgcolor=F6F6F6 >
                                                <TD class=top>
                                                Название
                                                </TD>
                                                <TD>
                                                <INPUT size=60 TYPE="text" name="name" value='NAME'>
                                                </TD>
                                        </TR>
<tr>
<td valign="top">Код документа</td>
<td>
<input type="text" name="code" id=doccode value="" size="42">
<div id=docname style="color:green;font-weight:bold">
<br>
TREE</div>
</td>
<input type="hidden" size="15" name="targetWindow" value="">
</tr>                                        <TR  bgcolor=F6F6F6 >
                                                <TD class=top colspan=2>
                                                Документы относящиеся к  этой рубрике
                        (<i style='font-weight: normal;' >Документы относящиеся к ее подрубрикам, также считаются относящимися к ней. </i>)
                        <br><br>
                        RUBDOCS
                                                </TD>
                                        </TR>
                                        <TR  bgcolor=F6F6F6>
                                                <TD colspan=2 align=center><br>
                                                <INPUT TYPE="submit" value='   OK   '>
                                                </TD>
                                        </TR>
                                </TABLE>
        </TD>
        </TR>
</TABLE>