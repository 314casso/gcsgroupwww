<SCRIPT LANGUAGE="JavaScript">
var proc=window.parent.proc;
</SCRIPT>

<tr>
  <td>
    <table width="100%" border="0">
      <tr>
        <td><span class="cat"><img src="img/arrow.gif" border="0" vspace="2"> ������� </span><br>
            <a href="#" onclick="{
                                   proc.document.location='proc.php?action=newdoc&do=proc&pid={NEW_PID}&type=NEW';
                                 }"><img border=0 src="doc_types/FORM/img/add.gif"></a>
        </td>
        <td class=top width=80% style="text-align:right">{NEW_FRM}</td>
      </tr>
    </table>
  </td>
</tr>
<tr>
  <td align="center">{NEWS}</td>
</tr>
<tr>
  <td>
    <table width="100%" border="0">
      <tr>
        <td valign="top">
          <table>
            <tr>
              <td><span class="cat"><img src="img/arrow.gif" border="0" vspace="2"> ����������� 1: </span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="font-weight: normal;">�������</span> <input type="checkbox" name="delpic1"></td>
            </tr>
            <tr><td>{NEW_PIC1}</td></tr>
            <tr><td>������� ��������: {NEW_HTTP_PIC1}</td></tr>
            <tr>
              <td><INPUT style="width: 300px" type="file" name="pic1" class="com_input"></td>
            </tr>
            <tr>
              <td><span class="cat"><img src="img/arrow.gif" border="0" vspace="2"> ����������� 2: </span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="font-weight: normal;">�������</span> <input type=checkbox name=delpic2></td>
            <tr>
            <tr><td>{NEW_PIC2}</td></tr>
            <tr><td>������� ��������: {NEW_HTTP_PIC2}</td></tr>
            <tr>
              <td><INPUT style="width: 300px" type="file" name="pic2" class="com_input"></td>
            </tr>
          </table>
        </td>
        <td width="100%" valign="top">
          <table>
            <tr>
            	<td><span class="cat"><img src="img/arrow.gif" border="0" vspace="2"> ����</span><br/>
            		<input type="text" name="ndate" class="com_input" size="20" value="{NEW_DATE}">
            	</td>
            	<td><span class="cat"><img src="img/arrow.gif" border="0" vspace="2"> ���� ������</span><br/>
            		<input type="text" name="new_date_start" class="com_input" size="20" value="{NEW_DATE_START}">
            	</td>
            	<td><span class="cat"><img src="img/arrow.gif" border="0" vspace="2"> ���� ���������</span><br/>
            		<input type="text" name="new_date_end" class="com_input" size="20" value="{NEW_DATE_END}">
            	</td>
            </tr>
          </table>
          <table>
            <tr><td><span class="cat"><img src="img/arrow.gif" border="0" vspace="2"> ���������</span></td></tr>
            <tr><td><input type="text" name="header" class="com_input" style="width: 300px;" value="{NEW_HEADER}"></td></tr>
            <tr><td><span class="cat"><img src="img/arrow.gif" border="0" vspace="2"> �����</span></td></tr>
            <tr><td><textarea name="text" style="width: 300px;" rows="5">{NEW_TEXT}</textarea></td></tr>
          </table>
        </td>
      </tr>
    </table>
  </td>
</tr>
<tr>
  <td>
    <script>
    function showadd()
    {
            if (document.all.additional.style.display=="")
            {
                    document.all.additional.style.display="none";
            }
            else
            {
                    document.all.additional.style.display="";
            }
    }
    </script>
    <span class="cat"><img src="img/arrow.gif" border="0" vspace="2"> <a href="javascript:showadd();" class="cat">�������������</a></span>
  </td>
</tr>
<tr>
  <td>
    <table id=additional style="display:none;">
      <tr>
        <td colspan="2"><span class="cat"><img src="img/arrow.gif" border="0" vspace="2"> ����������: </span></td>
      </tr>
      <tr>
        <td><span class="cat"><img src="img/arrow.gif" border="0" vspace="2"> ������: </span></td>
        <td><select id=grpsel name=grpassign onChange='{
                                                        if (this.selectedIndex != 0) document.all.usrsel.selectedIndex = 0;
                                                       }'>
            <option value=-1>-----------------</option>
            {NEW_GRPSEL}
            </select>
        </td>
      </tr>
      <tr>
        <td><span class="cat"><img src="img/arrow.gif" border="0" vspace="2"> ������������: </span></td>
        <td><select id=usrsel name=usrassign onChange='{
                                                        if (this.selectedIndex != 0) document.all.grpsel.selectedIndex = 0;
                                                       }'>
            <option value=-1>-----------------</option>
            {NEW_USRSEL}
            </select>
        </td>
      </tr>
    </table>
  </td>
</tr>
<tr>
  <td><span class="cat"><img src="img/arrow.gif" border="0" vspace="2"> �����: </span></td>
</tr>
<tr>
  <td>
    <script language=JavaScript src="hedit/brouser.js"></SCRIPT>
    <script language=JavaScript src="hedit/editor.js"></SCRIPT>
    <script language=JavaScript src="hedit/reset.js"></SCRIPT>

    <table>
      <tr>
        <td valign="top">
{NEW_HTML}
        </td>
      </tr>
    </table>
  </td>
</tr>