<SCRIPT LANGUAGE="JavaScript">

var proc=window.parent.proc;

//var view=window.parent.view;

var n=-1;





function swtch(num,doc) {

        if (num!=n ) {

                if (num>0)

                        window.parent.view.document.location='view.php?action=<?=$action?>&id='+num;

                }



        window.parent.proc.document.location='proc.php';



        if (n>0){

                document.all['a'+n].style.background='#FFFFFF';

                document.all['a'+n].style.color='#005597';

                }

        if ( num>0) {

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





<table style="

border-bottom:1 solid black;

" cellpadding=0 cellspacing=0 border=0 width="100%"  height=100% >

<tr>

<td height=1>

<table  cellpadding=0 cellspacing=0 border=0 width="100%"  height=1

>

<td height=1 background="img/zakladki/zakladki_polosa.jpg"

align=vbottom><img   src='img/zakladki/zakladki_polosa_2.jpg' ></td>

<td height=1 ><a href="menu.php"><img alt='Дерево документов' src='img/zakladki/zakladka_02_2.jpg ' border=0></a></td>

<td height=1 ><a href="menu.php?action=rubrique"><img alt='Рубрикатор' src='img/zakladki/zakladka_08_2.jpg ' border=0></a></td>

<?if ($logged[role]=='Администратор'){?><td height=1 ><a href="menu.php?action=group"><img alt='Пользователи' src='img/zakladki/zakladka_01_2.jpg ' border=0></a></td><?}?>

<td height=1 ><a href="menu.php?action=tools"><img alt='Инструменты' src='img/zakladki/zakladka_03_2.jpg ' border=0></a></td>

<td height=1 ><a href="menu.php?action=send"><img alt='Рассылки' src='img/zakladki/zakladka_06_2.jpg ' border=0></a></td>

<td height=1 ><a href="menu.php?action=forum"><img alt='Форум' src='img/zakladki/zakladka_09.jpg ' border=0></a></td>

<?if ($logged[role]=='Разработчик'){?>

<td height=1 ><a href="menu.php?action=tpl"><img alt='Шаблоны' src='img/zakladki/zakladka_04_2.jpg ' border=0></a></td>

<td height=1 ><a href="menu.php?action=style"><img alt='Стили' src='img/zakladki/zakladka_05_2.jpg ' border=0></a></td>

<?}?>

<?if ($logged[role]=='Администратор'){?><td height=1 ><a href="menu.php?action=log"><img alt='Логи' src='img/zakladki/zakladka_07_2.jpg ' border=0></a></td><?}?>

<td width=100% background="img/zakladki/zakladki_polosa.jpg" align=right><img  src='img/zakladki/zakladki_polosa_2.jpg' ></td>

</table>

</td>

</tr>

                <tr bgcolor=#C1C1C1          >

                        <td colspan=7 width=100% height="35" align=right style="

border-left:1 solid black;

border-right:1 solid black;"><table width=100% height="100%" style="

border-left:1         solid #FFFFFF;

border-right:1 solid #A0A0A0;"><td align="right"><img  src='img/shariki_grey.jpg' ></td></table></td>

                        </tr>



<tr><td height=50 bgcolor=#C1C1C1 style="

border-left:1 solid black;

border-right:1 solid black;

padding-top:0"

valign=top

><div          style="

border-top:1 solid #A0A0A0;"><TABLE        style="

border-left:1 solid #FFFFFF;

border-top:1 solid #FFFFFF;

border-right:1 solid #A0A0A0;

border-bottom:1 solid #A0A0A0;



 " width="100%" cellspacing="0" cellpadding="2" border="0">

                <tr bgcolor=#C1C1C1  >

                        <td width="1" >

<table cellpadding=0 cellspacing=0 border=0 width="100%"   >

</tr>

<td><img height=40 width=1 src='img/0.gif' style="

border-left:1 solid #FFFFFF;

border-top:1 solid #FFFFFF;

border-right:1 solid #A0A0A0;

border-bottom:1 solid #A0A0A0;

"></td><td><img height=40 width=1 src='img/0.gif' style="

border-left:1 solid #FFFFFF;

border-top:1 solid #FFFFFF;

border-right:1 solid #A0A0A0;

border-bottom:1 solid #A0A0A0;

"></td></table></td>

                        <td  align=left  >

                                <a href='#' class=link onclick='{

                                                proc.document.location="proc.php?action=newforum";

                                        }'><img class=ibutton onMouseOver='mo(this)' onMouseleave='ml(this)' src='img/big_txt.jpg'  border=0 alt='СОЗДАТЬ ШАБЛОН'></a>

                        </td>

                        <td align=left >



                                <a href='#' class=link onclick='{

                                        if (n!=-1)         {

                                                proc.document.location="proc.php?action=delforum&id="+n;

                                                }

                                        }'><img class=ibutton onMouseOver='mo(this)' onMouseleave='ml(this)'  src='img/big_del.jpg' border=0 alt='УДАЛИТЬ ШАБЛОН'></a>

                        </td>



                        <td width=100% align=right> </td>

                </tr>

</table>

</div>

</td></tr>

<tr><td bgcolor="#C1C1C1" style="

border-left:1 solid black;

border-right:1 solid black;

">

<!-- <div style="height:100%;

border-left:1 solid #FFFFFF;

border-top:1 solid #FFFFFF;

border-right:1 solid #A0A0A0;

padding:5;



"> -->

<table cellpadding=0 cellspacing=0 border=0 width=100% height=100%

style = "border-left:1 solid #FFFFFF;

border-top:1 solid #FFFFFF;

border-right:1 solid #A0A0A0;

padding:5;

" ><tr><td>

<div

style = "background-color:#C1C1C1; padding: 10;height:100% ;  width: 100%; overflow-y: scroll ;overflow-x: scroll ;

background-color:#FFFFFF;

border-left:1 solid #000000;

border-top:1 solid #000000;

border-right:1 solid #FFFFFF;

border-bottom:1 solid #FFFFFF;

padding:5;

" >







<table cellpadding=0 cellspacing=0 border=0 width=100% >

        <tr height=25>

        <td height=25 colspan=3><a class=menu id=a-1 href='#'

                                        onclick='{

                                                swtch(-1);

                                                }'><img src="images/menu/folder_root.gif" style="border: none; width: 25px; height: 25px;"></a></td>

        </tr>





<?

$sql="select * from engine_forum order by name";

$r=mysql_query($sql) or die("SQL error ".mysql_error()." in: $sql\n");

$c=mysql_num_rows($r);

while($f=mysql_fetch_array($r)){

        $c--;

        if ($c)$img='images/menu/both_connector.gif';

        else $img='images/menu/bottom_connector.gif';

        echo "

                <tr bgcolor='#FFFFFF'>

                        <td width=25><img border=0 src='$img'></td>

                        <td width=25><img border=0 src='images/menu/item.gif'></td>

                        <td class=top align=center>

                                <a class=menu id=a$f[id] href='#'

                                        onclick='{

                                                swtch(".$f[id].");

                                                }'><!-- <img border=0 id=img$f[id] src='img/send.gif'> -->".$f[name]."</a>

                        </td>

                </tr>

                ";

        }

?>

</table>

</div>

</td></tr></table>

</td></tr>

<tr bgcolor=#C1C1C1 >

<td width=100%

style="

border-left:1 solid black;

border-right:1 solid black;

border-bottom:1 solid #A0A0A0;

"

 align=left height=1>

 <img  style="

        border-left:1 solid white;



 "

  src='img/shariki_grey1.jpg'></td>

                </tr>



</table>