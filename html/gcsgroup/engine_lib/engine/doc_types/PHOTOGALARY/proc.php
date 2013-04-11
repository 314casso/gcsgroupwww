<?
    if ($nwnd)
    $nwnd=1;else $nwnd=0;

    if (mysql_num_rows(mysql_query("select * from engine_PHOTOGALARY  where doc_id=$id"))){
        $sql="update engine_PHOTOGALARY
            set
                rows='$rows',
                cols='$cols',
                format='$format',
                nwnd='$nwnd'
             where doc_id=$id";
        mysql_query($sql);
        }
    else {
        $sql="insert into engine_PHOTOGALARY(rows,cols,nwnd,format,doc_id)
            values ('$rows','$cols','$nwnd','$format',$id)";
        mysql_query($sql);
        }


if ($picedit)
{
    list($maxord,$minord)=mysql_fetch_array(mysql_query("select max(ord),min(ord) from engine_PHOTOGALARY_cells  where gal_id=$id"));
    if (!$inscell)
    {
        /*
        if ($ord<1) $ord=1;
        if ($ord>$maxord+1) $ord=$maxord;
        $sql="update engine_PHOTOGALARY_cells
                         set ord=ord+1  where gal_id=$id and ord>='$ord'";

        mysql_query($sql);
        */

        $sql='UPDATE engine_PHOTOGALARY_cells
                      SET text1="'.mysql_real_escape_string($txt1).'",
                          text2="'.mysql_real_escape_string($txt2).'",
                          text3="'.mysql_real_escape_string($txt3).'",
                          ord="'.$ord.'"
                      WHERE id='.$cellid;
        mysql_query($sql);
    }
    else
    {
        if (!$ord)
        {
            //$ord=$maxord+1;
            $ord = 0;
        }
                /*
                else
                {
                    $sql="update engine_PHOTOGALARY_cells
                              set ord=ord+1  where gal_id=$id and ord>='$ord'";
            mysql_query($sql);
        }
        */

        $sql = 'INSERT into engine_PHOTOGALARY_cells(text1,text2,text3,ord,gal_id)
                                      values("'.mysql_real_escape_string($txt1).'","'.mysql_real_escape_string($txt2).'","'.mysql_real_escape_string($txt3).'",'.$ord.','.$id.')';
        mysql_query($sql);
        $cellid=mysql_insert_id();
    }

    if ($bpic)
    {
        $fn=explode(".",$bpic_name);
        $ext=strtolower($fn[count($fn)-1]);
        @unlink("$engine_show_root/engine/pics/PHOTOGALARY/bpic".$cellid.".jpg");
        @unlink("$engine_show_root/engine/pics/PHOTOGALARY/bpic".$cellid.".gif");
        copy($bpic,"$engine_show_root/engine/pics/PHOTOGALARY/bpic".$cellid.".$ext");
        chmod("$engine_show_root/engine/pics/PHOTOGALARY/bpic".$cellid.".$ext",0777);

        if ($crrprv){
                          if ($ext=='jpg'){
                              $src_img=@ImageCreateFromJpeg($bpic);
                                $x=@ImageSX($src_img);
                                $y=@ImageSY($src_img);

                                if ($x<=$y){
                                    $new_w=$x*120/$y;
                                    $new_h=120;
                                    }
                                else{
                                    $new_w=120;
                                    $new_h=$y*120/$x;
                                    }
#                                $dst_img=@ImageCreate($new_w,$new_h);
               $dst_img=ImageCreateTrueColor($new_w,$new_h);
                                @ImageCopyResized($dst_img,$src_img,0,0,0,0,$new_w,$new_h,ImageSX($src_img),ImageSY($src_img));
#               @ImageCopyResampled($dst_img,$src_img,0,0,0,0,$new_w,$new_h,ImageSX($src_img),ImageSY($src_img));
                                 @imagejpeg($dst_img,"$engine_show_root/engine/pics/PHOTOGALARY/spic".$cellid.".jpg",100);
                                if (!$dst_img or !$src_img){
                                    echo "<script>alert('Не получилось создать иконку, закачайте, пожалуйста, вручную!');</script>";
                                    }
                                }
                          else
                                    echo "<script>alert('Иконку можно создавать только из JPG файлов, закачайте, пожалуйста, вручную!');</script>";
                          }

                    }
            if ($spic) {
                    $fn=explode(".",$spic_name);
                    $ext=strtolower($fn[count($fn)-1]);
                    @unlink("$engine_show_root/engine/pics/PHOTOGALARY/spic".$cellid.".jpg");
                    @unlink("$engine_show_root/engine/pics/PHOTOGALARY/spic".$cellid.".gif");
                    copy($spic,"$engine_show_root/engine/pics/PHOTOGALARY/spic".$cellid.".$ext");
                    chmod("$engine_show_root/engine/pics/PHOTOGALARY/spic".$cellid.".$ext",0777);
                    }



        }
if ($delcell){
    $sql="select * from engine_PHOTOGALARY_cells where id=$cellid ";
      $cell=mysql_fetch_array(mysql_query($sql));
      $sql="delete from  engine_PHOTOGALARY_cells where id=$cellid ";
      mysql_query($sql);
      $sql="update engine_PHOTOGALARY_cells
              set ord=ord-1  where gal_id=$id and ord>='$cell[ord]'";
      mysql_query($sql);
      @unlink("$engine_show_root/engine/pics/PHOTOGALARY/spic".$cellid.".jpg");
      @unlink("$engine_show_root/engine/pics/PHOTOGALARY/spic".$cellid.".gif");
      @unlink("$engine_show_root/engine/pics/PHOTOGALARY/bpic".$cellid.".jpg");
      @unlink("$engine_show_root/engine/pics/PHOTOGALARY/bpic".$cellid.".gif");
    }
  ?>

