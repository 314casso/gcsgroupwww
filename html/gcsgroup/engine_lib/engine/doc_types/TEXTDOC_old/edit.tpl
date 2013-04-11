<tr><td colspan=2>
<SCRIPT language=JavaScript src="hedit/brouser.js"></SCRIPT>

<SCRIPT language=JavaScript src="hedit/editor.js"></SCRIPT>

<SCRIPT language=JavaScript src="hedit/reset.js"></SCRIPT>
<TABLE width="100%" border=0>
  <TBODY>
        <TR>
        <TD>
        Дата создания: <input type="text" name="tdate" class=form2 size=40 value='{TDATE}'>
        </TD>
        </TR>
        <TR>
    <TD vAlign=top bgcolor="#76C5F0" style="border-color: #000000; border-style:solid;border-width:1px;">
<textarea
        style=""
        name=html rows=7 cols=100>
{divHTML}
</textarea>
      <SCRIPT language=JavaScript>
    if (isMSIE5 || isOpera7)
    {
     document.write('<table border=0 width=100% height="300"><td>');
     CreateEditor('editor','html','html','hedit',300);
     document.write('</td></table>');

    }
</SCRIPT>
       </TD></TR>
  <TR>
    <TD><!-- border:1px solid #D6D3CE;width:20px;height:20px-->
 <INPUT type=hidden value=ID name=doc>
</TD></TR></TBODY>
</table>
</td></tr>