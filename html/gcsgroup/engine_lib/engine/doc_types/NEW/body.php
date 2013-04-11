<?

if ($logged[id]){

        $r=mysql_query("select `ugroup` from engine_users where id=$logged[id]") or die (mysql_error());

        list($loggedgrp)=mysql_fetch_array($r);

        }

if (($logged[id]==$this->spec[usrassign] or $this->spec[usrassign]==-1)and ($grplogged==$this->spec[grpassign] or $this->spec[grpassign]==-1))
{

    $out =  $this->spec[html];
/*    $pic1 = '';
    $pic2 = '';

    $sql = <<<SQL
    SELECT  d.id AS doc_id,n.*
        FROM engine_documents d, engine_NEW n
        WHERE d.visible=1 AND
              n.doc_id=d.id AND
              d.pid='$id' 
    SQL;  */

//   $r = mysql_query($sql) or die (mysql_error()." in $sql");
//   $f= mysql_fetch_array($r);


//  $id = $f['doc_id'];

    $pic_style = (isset($style)) ? $style : "pic_class";

    if (file_exists('engine/pics/news/pic1_'.$id.'.jpg'))
    {
            $pic1="<a href # onclick='{window.open(".'"'."http://www.gcs-group.ru/engine/pics/news/pic1_".$id.".jpg".'"'.");return true;}'><img border=0 src='http://www.gcs-group.ru/engine/pics/news/pic1_".$id.".jpg' border=0 width=180 align=left></a>";
    }
        elseif (file_exists('engine/pics/news/pic1_'.$id.'.gif'))
        {
            $pic1="<a href # onclick='{window.open(".'"'."engine/pics/news/pic1_".$id.".gif".'"'.");return true;}'><img border=0 src='engine/pics/news/pic1_".$id.".gif' border=0 width=180 align=left></a>";
        }

    if (file_exists('engine/pics/news/pic2_'.$id.'.jpg'))
    {
        $pic2="<a href # onclick='{window.open(".'"'."http://www.gcs-group.ru/engine/pics/news/pic2_".$id.".jpg".'"'.");return true;}'><img border=0 src='http://www.gcs-group.ru/engine/pics/news/pic2_".$id.".jpg' border=0 width=180 align=left></a>";
    }
        elseif (file_exists('engine/pics/news/pic2_'.$id.'.gif'))
        {
            $pic2="<a href # onclick='{window.open(".'"'."http://www.gcs-group.ru/engine/pics/news/pic2_".$id.".gif".'"'.");return true;}'><img border=0 src='http://www.gcs-group.ru/engine/pics/news/pic2_".$id.".gif' border=0 width=180 align=left></a>";
        }

    if (!$pic1)
    {
  
        $out=str_replace("NEW_PIC1","Not Found pic1",$out);
//        $out=preg_replace("|\[NEW_PIC1\].*\[/NEW_PIC1\]|Usi","",$out);
    }

    if (!$pic2)
    {
        $out=str_replace("NEW_PIC2","Not Found pic2",$out);
//        $out=preg_replace("|\[NEW_PIC2\].*\[/NEW_PIC2\]|Usi","",$out);
    }

    $out=str_replace("NEW_PIC1",$pic1,$out);
    $out=str_replace("NEW_PIC2",$pic2.'<br><br><br><br><br><br><br><br>',$out);

	$this->body=$out;
}
else
{
	$this->body="У Вас нет доступа к этой информации!";
}

?>
