<link rel=stylesheet href="style.css" type="text/css" title="CSS style">

				<form method=post action='?action=showrub'>
				<INPUT TYPE="hidden" name=do value=1>
				<INPUT TYPE="hidden" name=id value=ID>
				<TABLE>
					<TR>
						<TD class=top>
						Название
						</TD>
						<TD>
						<INPUT TYPE="text" name="name" value='NAME'>
						</TD>
					</TR>

					<TR>
						<TD class=top>
						Тэмплэйт
						</TD>
						<TD>
						<select name="tplrub">
						<!-- BEGIN DYNAMIC BLOCK: rub_tpl -->
							<option value=TPL_ID SELECTED>TEXT</option>
						<!-- END DYNAMIC BLOCK: rub_tpl -->
						</select>
						</TD>
					</TR>
					<TR>
						<TD class=top>
						Тэмплэйт документа
						</TD>
						<TD>
						<select name="tpldoc">
						<!-- BEGIN DYNAMIC BLOCK: doc_tpl -->
							<option value=TPL_ID SELECTED>TEXT</option>
						<!-- END DYNAMIC BLOCK: doc_tpl -->
						</select>
						</TD>
					</TR>

					<TR>
						<TD colspan=2>
						<INPUT TYPE="submit" value='   OK   '>
						</TD>
					</TR>
				</TABLE>				
