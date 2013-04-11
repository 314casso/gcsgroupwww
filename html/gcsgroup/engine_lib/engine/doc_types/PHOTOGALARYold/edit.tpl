<tr>
<td><table align="center" cellspacing="1" cellpadding="1" border="0">
<tr>
<td>
<table border=0>
	<tr>
    	<td class="top"  valign="bottom" >
			- Количество строк на страницу
		</td>
	</tr>
	<tr>
    	<td class="top"  valign="bottom" >
			<input name=rowsperpage value=ROWSPERPAGE>
		</td>
	</tr>
	<tr>
    	<td class="top"  valign="bottom" >
			- Формат вывода
		</td>
	</tr>
	<tr>
    	<td class="top"  valign="bottom" >
			<textarea name=format class=header2>FORMAT</textarea>
		</td>
	</tr>
	<tr>
		<td>

			<TABLE class=wnd>
				<TR>
					<TD  class=header colspan=3>Ячейка</TD>
				</TR>
				<tr>
					<td>Текст</td>
					<td>
						<input name=page_ id=page_ value='PAGE' type=hidden>
						<input name=cell_x id=cell_x type=hidden>
						<input name=cell_y id=cell_y type=hidden>
						<input name=del_row id=del_row type=hidden>
						<input name=del_col id=del_col type=hidden>
						<textarea name=cell_value id=cell_value onkeyup="if (fcell) {
						fcell.v=this.value;
						fcellinput.value=this.value;
						}"></textarea></td>
					<TD  style="border:1 solid" rowspan=4><img id=cellimg src='img/0.gif'></TD>
				</tr>
				<tr>
					<td>Изображение</td>
					<td><input type=file  style="width:140px" name=cellimg></td>
				</tr>
				<tr>
					<td>Увеличенное изображение</td>
					<td><input type=file  style="width:140px" name=cellimgbig></td>
				</tr>
				<tr>
					<td>colspan</td>
					<td><input id=cell_colspan name=cell_colspan></td>
				</tr>
				<tr>
					<td>rowspan</td>
					<td><input id=cell_rowspan name=cell_rowspan></td>
					<TD  style="border:1 solid" rowspan=2><img id=cellimgbig src='img/0.gif'></TD>
				</tr>
				<tr>
					<TD colspan=4 align=center><INPUT  name=celledit type="submit" value="- ОК -" class="but2"></TD>
				</tr>
			</TABLE>
		</td>
	</tr>
	<tr>
    	<td class="top"  valign="bottom">
		<table>
			<tr>
		    	<td class="top"  valign="bottom"><INPUT  name=addcol type="submit" value="Добавить столбец" ></td><td align=left><INPUT  name=addcol_after type="submit" value="Добавить столбец после" ></td>
			</tr>
			<tr>
		    	<td class="top"  valign="bottom"><INPUT  name=addrow type="submit" value="Добавить строку" ></td><td align=left><INPUT  name=addrow_after type="submit" value="Добавить строку после" ></td>
			</tr>

		</table>
		</td>
	</tr>
	<tr>
    	<td class="top"  valign="bottom" >
			PAGES <BR><BR>
			PHOTOGALARY
		</td>
	</tr>
</table>
</td>
</tr>
</table>
</td>
</tr>