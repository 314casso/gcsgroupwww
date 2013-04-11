<link rel=stylesheet href="style.css" type="text/css" title="CSS style">

				<form method=post action='?action=style' enctype="multipart/form-data" >
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
						Файл стиля
						</TD>
						<TD>
						<INPUT class=dlg TYPE="file" name="filename">
						</TD>
					</TR>
					<TR>
						<TD colspan=2 align=center><br>
						<INPUT TYPE="submit" value='   OK   '>
						</TD>
					</TR>
				</TABLE>				
