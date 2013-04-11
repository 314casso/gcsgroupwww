<?

/*
 *  $Id: MENU.php,v 1.8 2004/12/19 22:51:53 dave Exp $
 *
 *  $Log: MENU.php,v $
 *  Revision 1.8  2004/12/19 22:51:53  dave
 *  Оптимизация запросов к БД -- избавление от лишних OUTER JOIN
 *
 *
 */

global $logged,$id;



if (!$folder){

        $d=$doc;

        }

else {

        $d=new Document($folder);



        }



if ($d->id!=-1){

        while($d->type!='FOLDER'){

                $d=new Document($d->pid);

                }

        }

$path=str_replace(".html","",($d->geturl())) ;

$folder=$d->id;

if ($logged)

        $sql="select * from engine_documents where pid='{$folder}' and visible=1 order by ord,name ";

else {

        $sql="select * from engine_documents where pid='{$folder}' and visible=1 order by ord,name ";

        }

$r=mysql_query($sql) or die("SQL error ".mysql_error()." in: $sql\n");

if (!$format){

        ?><table cellpadding=1 cellspacing=0 border=0 width=100%>

        <?

        if ($view!='horizontal')

                        echo "

                        <tr bgcolor='#EFEFEF'>

                                <td colspan=3 class=top align=center>

                                        <a class=menu  href='".$path.".html'>

                                                <img border=0 src='img/up.gif'>..

                                        </a>

                                </td>

                        </tr>

                        ";

        else

                        echo "

                        <tr bgcolor='#EFEFEF'>

                        ";

        }

while ($f=mysql_fetch_array($r)){

        if ($n!=-1)        {

                $img="document.gif";

                $fld=0;

                $a=($f[code]);

                if (!$a)$a=$f[id];

                if ($f[type]=='FOLDER'){

                        $img="fopened.gif";

                        $fld=1;

                        }

                $a =strtolower($a);

                if ($f[id]==$doc->id || ($f[type]=='FOLDER' && $f[id]==$doc->pid)) {

                        if (file_exists("engine/doc_icons/actimg".$f[id].".gif"))

                                                        $img="/engine/doc_icons/actimg".$f[id].".gif";

                                                elseif (file_exists("engine/doc_icons/actimg".$f[id].".jpg"))

                                                        $img="/engine/doc_icons/actimg".$f[id].".jpg";

                                                elseif ($f[type]=='FOLDER')

                                                        $img="/engine/doc_icons/default/actfld.gif";

                                                else

                                                        $img="/engine/doc_icons/default/actdoc.gif";

                        }

                else {

                        if (file_exists("engine/doc_icons/unactimg".$f[id].".gif"))

                                $img="/engine/doc_icons/unactimg".$f[id].".gif";

                        elseif (file_exists("engine/doc_icons/unactimg".$f[id].".jpg"))

                                $img="/engine/doc_icons/unactimg".$f[id].".jpg";

                        elseif ($f[type]=='FOLDER')

                                $img="/engine/doc_icons/default/uactfld.gif";

                        else

                                $img="/engine/doc_icons/default/uactdoc.gif";



                        }



                $show=true;

                if ($type=="documents" && $f[type]=="FOLDER")

                        $show=false;

                if ($type=="folders" && $f[type]!="FOLDER")

                        $show=false;



                    global $hide_private_docs;

                    if ($hide_private_docs){

                           if ($f['private']){

                              if ($sitelogged){



                                 if (mysql_num_rows(

                                     mysql_query("select * from engine_users u, engine_group_rights r where u.ugroup=r.ugroup and r.document=$f[id] and granted=1 and u.id=$sitelogged[id]")

                                     )

                                   )

                                  $show=false;

                                  }

                              else

                                  $show=false;

                              }

                           }





                if ($show){

                        $name=$f[name];

                        if ($f[type]=='NEW') {

                                $new=new Document($f[id]);

                                $name=$new->spec[header];

                                }

                        if ($text_to_show=='caption_short')

                                $name=$f[caption_short];

                        if ($text_to_show=='caption_medium')

                                $name=$f[caption_medium];

                        if ($text_to_show=='caption_long')

                                $name=$f[caption_long];



                        if (!$format){

                                if ($view!='horizontal') echo "

                                <tr bgcolor='#EFEFEF'>

                                        ";

                                echo "

                                        <td colspan=3 class=top align=center>

                                                <a class=menu  href='".$path."/".$a.".html'>

                                                        <img border=0 src='$img'>".$name." {$f[id]} {$doc->pid}

                                                </a>

                                        </td>

                                        ";

                                if ($view!='horizontal') echo "

                                </tr>

                                ";

                                }

                        else {

                                $out=str_replace("ITEM_IMG",$img,$format);

                                $out=str_replace("ITEM_TEXT",$name,$out);

                                $out=str_replace("ITEM_CAPTION_LONG", $f['caption_long'], $out);
                                $out=str_replace("ITEM_CAPTION_MEDIUM", $f['caption_medium'], $out);
                                $out=str_replace("ITEM_CAPTION_SHORT", $f['caption_short'], $out);
                                $out=str_replace("ITEM_CODE", $f['code'], $out);
                                $out=str_replace("ITEM_CREATION_DATE", $f['creation_date'], $out);
                                $out=str_replace("ITEM_USER", $f['user'], $out);
                                $out=str_replace("ITEM_RESUME", $f['resume'], $out);

                                if ($f[type]!='BINARYDOC') {

                                        $out=str_replace("ITEM_LINK","".$path."/".$a.".html",$out);

                                        }

                                else {

                                        $sql="select ext from engine_BINARYDOC where doc_id=$f[id]";

                                        list($ext)=mysql_fetch_array(mysql_query($sql));

                                        $out=str_replace("ITEM_LINK","/engine/documents/document{$f[id]}.{$ext}",$out);

                                        if (!file_exists("engine/documents/document{$f[id]}.{$ext}"))

                                                $out="";



                                        }

                                $out=str_replace("ITEM_ID",$f[id],$out);



                                echo $out;

                                }

                        }

                }

        }

if (!$format)

        if ($view=='horizontal')echo "

                </tr>

</table >                ";

?>
   