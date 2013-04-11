<SCRIPT LANGUAGE="JavaScript">

var proc=window.parent.proc;

var move_to=window.parent.move_to;

var n=-1;

var d=-1;


function swtch(num) {

        if (window.parent.view.document.location!='view.php?action=rubrique&id='+num)

                window.parent.view.document.location='view.php?action=rubrique&id='+num;

        window.parent.proc.document.location='proc.php';

        window.parent.move_to.document.location='moveto.php';

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

<script src="menu.js"></script>



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

<td height=1 ><a href="menu.php?action=rubrique"><img alt='Рубрикатор' src='img/zakladki/zakladka_08.jpg ' border=0></a></td>

<?if ($logged[role]=='Администратор'){?><td height=1 ><a href="menu.php?action=group"><img alt='Пользователи' src='img/zakladki/zakladka_01_2.jpg ' border=0></a></td><?}?>

<td height=1 ><a href="menu.php?action=tools"><img alt='Инструменты' src='img/zakladki/zakladka_03_2.jpg ' border=0></a></td>

<td height=1 ><a href="menu.php?action=send"><img alt='Рассылки' src='img/zakladki/zakladka_06_2.jpg ' border=0></a></td>

<td height=1 ><a href="menu.php?action=forum"><img alt='Форум' src='img/zakladki/zakladka_09_2.jpg ' border=0></a></td>

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

border-right:1 solid #A0A0A0;"><td style="color:green">Список разделов и документов сайта</td><td align="right"><img  src='img/shariki_grey.jpg' ></td></table></td>

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

                                                proc.document.location="proc.php?action=newrub&pid="+n;

                                        }'><img class=ibutton onMouseOver='mo(this)' onMouseleave='ml(this)' src='img/big_txt.jpg'  border=0 alt='СОЗДАТЬ ДОКУМЕНТ'></a>

                        </td>

                        <td align=left >



                                <a href='#' class=link onclick='{

                                        if (n!=-1)         {

                                                proc.document.location="proc.php?action=delrub&id="+n;

                                                }

                                        }'><img class=ibutton onMouseOver='mo(this)' onMouseleave='ml(this)'  src='img/big_del.jpg' border=0 alt='УДАЛИТЬ'></a>

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

padding-left:5;

padding-right:5;

padding-bottom:5;

padding-top:0;



" >

<table cellpadding=0 cellspacing=0 border=0 width=100% height=100%

>        <tr>

        <td height=25>

                <table cellpadding=0 cellspacing=0 border=0  >

                        <tr bgcolor='#FFFFFF' height=25>

                                <td class=top align=center  ><a class=link id=a-1 href='#'

                                                onclick='{

                                                        swtch(-1,-1);

                                                        }'><img src="images/menu/folder_root.gif" style="border: none; width: 25px; height: 25px;"></a></td>

                        </tr>

                </table>

                </td>

        </tr>



        <?

$sql="select * from engine_rubrique order by pid,name";

$r=mysql_query($sql) or die("SQL error ".mysql_error()." in: $sql\n");



$i=0;

while($f=mysql_fetch_array($r)){

        $ids[$i]=$f[id];

        $pids[$i]=$f[pid];

        $names[$i]=$f[name];

        $i++;

        }



for ($k=0;$k<$i;$k++){

          $types[array_search($pids[$k],$ids)]='FOLDER';

          }

$open="";

function tree($id,$n,$level,$l='',$count='') {

        global $i,$ids,$pids,$names,$types,$doc,$open;

//        if ($count=='2.') exit;

        if ($n!=-1)        {

                $img="img/1x1.gif";

                $fld=0;

                $c=0;

                for ($k=0;$k<$i;$k++){

                        if ($pids[$k]==$id) {

                                $c++;

                                }

                        }

                for ($k=0;$k<$i;$k++){

                        if ($pids[$k]==$pids[$n]) {

                                if ($types[$k]=='FOLDER' )

                                        $last=$k;

                                }

                        }

                for ($k=0;$k<$i;$k++){

                        if ($pids[$k]==$pids[$n]) {

                                if ($types[$k]!='FOLDER' )

                                        $last=$k;

                                }

                        }

                if ($last==$n)$last=true;

                else $last=false;



                if (strstr($count,'.'))$vis='style="display: none;"';

                else $vis='';

                echo "

                                <tr bgcolor=#FFFFFF  id='navigation_menu:$count' $vis>

                        <td><table cellpadding=0 cellspacing=0 border=0>



                <tr >

                $l";

                if ($types[$n]=='FOLDER'){

                        $img="images/menu/rubrikaor_tree.gif";

                        $fld=1;

                        if ($last)$l1=$l."\n<td width=25></td>";

                        else $l1=$l."\n".'<td width=25 background="images/menu/vertical_connector.gif"><img src="images/menu/vertical_connector.gif" style="border: none; width: 25px; height: 25px;"></td>';

                        }







                if ($types[$n]!='FOLDER'){

                        global $engine_root,$engine_htroot;

                        $itm="images/menu/rubrikaor_tree.gif";

                        if (file_exists("$engine_root/engine/doc_types/{$types[$n]}/icon.gif")){

                                $itm="$engine_htroot/engine/doc_types/{$types[$n]}/icon.gif";

                                }

                        if ($last) echo "\n".'<td width=25   valign=top><img src="images/menu/bottom_connector.gif" style="border: none; width: 25px; height: 25px;"></td>';

                        else echo "\n".'<td width=25  background="images/menu/vertical_connector.gif" valign=top ><img src="images/menu/both_connector.gif" style="border: none; width: 25px; height: 25px;"></td>';

                        echo "\n".'<td width=25 valign=top>

                                        <a class=menu  href=\'javascript:{

                                                swtch('.$ids[$n].',-1);

                                                }\'><img src="'.$itm.'" style="border: none; width: 25px; height: 25px;"></a></td>';

                        }

                else

                        {

                        if ($c>=1){

                                if ($last) echo " \n<td width=25   valign=top ><a href=\"javascript:hierarchicalMenu_branchManager.act('navigation_menu:$count')\" style=\"text-decoration: none; color: black;\"><img src=\"images/menu/collapsed_marker_bottom.gif\" name=\"navigation_menu:$count\" style=\"border: none; width: 25px; height: 25px;\"></a></td>";

                                else echo " \n<td width=25 background=\"images/menu/vertical_connector.gif\" valign=top><a href=\"javascript:hierarchicalMenu_branchManager.act('navigation_menu:$count')\" style=\"text-decoration: none;  color: black;\"><img src=\"images/menu/collapsed_marker.gif\" name=\"navigation_menu:$count\" style=\"border: none; width: 25px; height: 25px;\"></a></td>";

                                }

                        else {

                                if ($last) echo "\n".'<td width=25   valign=top><img src="images/menu/bottom_connector.gif" style="border: none; width: 25px; height: 25px;"></td>';

                                else echo "\n".'<td width=25  background="images/menu/vertical_connector.gif" valign=top ><img src="images/menu/both_connector.gif" style="border: none; width: 25px; height: 25px;"></td>';

                                }

                        }



                echo"

                        <td class=top name=td_navigation_menu:$count id=td_navigation_menu:$count align=center  >

                        <a class=menu   href='javascript:{

                                                swtch(".$ids[$n].",-1);

                                                }'>

                                <img border=0  id=img".$ids[$n]." src='$img'></a></td><td style='padding:2px' class=top align=left >

                                <a style='font-weight: normal;'

                                class=menu id=a".$ids[$n]." href='javascript:{

                                                swtch(".$ids[$n].",-1);

                                                }'>&nbsp".$names[$n]."</a>

                                                <input type=hidden id=fld".$ids[$n]." value=$fld>

                        </td>

                </tr>

        </table></td></tr>

                ";

                if ($doc==$ids[$n]){

                        $open="hierarchicalMenu_branchManager.act(\"navigation_menu:$count\");

                                swtch(".$ids[$n].",-1);

                        ";

                        }



                }

        if ($types[$n]=='FOLDER' || $n==-1) {

                $cnt=1;

                if (!$count)$dot='';else $dot='.';

                for ($k=0;$k<$i;$k++){

                        if ($pids[$k]==$id) {

                                if ($types[$k]=='FOLDER' )

                                        tree($ids[$k],$k,$level+1,$l1,$count.$dot.($cnt++));

                                }

                        }

                for ($k=0;$k<$i;$k++){

                        if ($pids[$k]==$id) {

                                if ($types[$k]!='FOLDER' )

                                        tree($ids[$k],$k,$level+1,$l1,$count.$dot.($cnt++));

                                }

                        }

                }

        }



        tree(-1,-1,-1);

?>

<tr bgcolor=#FFFFFF >

                        <td class=top colspan=3 align=center height=100%>

                        </td>

                </tr>

<script>

        hierarchicalMenu_branchManager.createBranch('navigation_menu', true);

<?=$open?>

        </script>

</TABLE>

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