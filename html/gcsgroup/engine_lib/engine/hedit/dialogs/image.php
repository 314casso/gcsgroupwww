<?
@session_start();
@session_register("logged");
@session_register("engine_htroot");
@session_register("engine_root");
@session_register("engine_show_htroot");
@session_register("engine_show_root");
@session_register("db_host");
@session_register("db_user");
@session_register("db_pass");
@session_register("db_name");

include("$engine_show_root/engine/config.inc");
//echo 'Ошибка загрузки файла. Путь: '.$engine_show_root.'/engine/config.inc';
include "../../config.inc";

if (isset($_POST['order_type']))
{
        $_SESSION['order_type'] = intval($_POST['order_type']);
}

if (empty($_SESSION['order_type']))
{
        $_SESSION['order_type'] = 0;
}
$order_type = $_SESSION['order_type'];

$error = '';
$message = '';

if (isset($_POST['delete']))
{
        $del_img = $_POST['images_list'];
        $del_img = $engine_show_root.$del_img;

        if (file_exists($del_img))
        {
                if (is_file($del_img))
                {
                        if (!@unlink($del_img))
                        {
                                $error = 'Произошла ошибка во время удаления файла.<br> Файл: '.$del_img;
                        }
                        else
                        {
                                $message = 'Файл "'.$_POST['images_list'].'" был успешно удален';
                        }
                }
                else
                {
                        $error = 'Вы не можете удалить данный объект.<br> Файл: '.$del_img;
                }
        }
        else
        {
                $error = 'Указанного вами файла не существует.<br> Файл: '.$del_img;
        }
}

function check_image_type(&$type)
{

        switch( $type )
        {
                case 'jpeg':
                case 'pjpeg':
                case 'jpg':
                        return '.jpg';
                        break;
                case 'gif':
                        return '.gif';
                        break;
                case 'png':
                        return '.png';
                        break;
        }

        return false;
}

function UploadFile(&$error, &$message)
{
        global $_FILES, $engine_show_root;

        $img_filename = ($_FILES['img_file']['tmp_name'] != "none") ? $_FILES['img_file']['tmp_name'] : '';
        $img_real_name = ( !empty($_FILES['img_file']['name']) ) ? $_FILES['img_file']['name'] : '';
        $img_size = ( !empty($_FILES['img_file']['size']) ) ? $_FILES['img_file']['size'] : 0;
        $img_filetype = ( !empty($_FILES['img_file']['type']) ) ? $_FILES['img_file']['type'] : '';

        if (!isset($_FILES['img_file']))
        {
                $error = 'Не указан файл для закачки';
                return false;
        }

        if ( ( file_exists($img_filename) ) && preg_match('/\.(jpg|jpeg|gif|png)$/i', $img_real_name) )
        {
                if ( $img_size > 0 )
                {
                        preg_match('#image\/[x\-]*([a-z]+)#', $img_filetype, $img_filetype);
                        $img_filetype = $img_filetype[1];
                }
                else
                {
                        $error = 'Загружаемый вами файл имеет некорректный размер.';
                        return false;
                }

                list($width, $height, $type) = @getimagesize($img_filename);
        }

        if ( !($imgtype = check_image_type($img_filetype)) )
        {
                $error = 'Закачка изображений данного типа запрещена.';
                return false;
        }

        switch ($type)
        {
                // GIF
                case 1:
                        if ($imgtype != '.gif')
                        {
                                @unlink($tmp_filename);
                                $error = 'Вы не можете закачать данный файл, т.к. он несовместим с расширением';
                                return false;
                        }
                        break;
                // JPG, JPC, JP2, JPX, JB2
                case 2:
                case 9:
                case 10:
                case 11:
                case 12:
                        if ($imgtype != '.jpg' && $imgtype != '.jpeg')
                        {
                                @unlink($tmp_filename);
                                $error = 'Вы не можете закачать данный файл, т.к. он несовместим с расширением';
                                return false;
                        }
                        break;
                // PNG
                case 3:
                        if ($imgtype != '.png')
                        {
                                @unlink($tmp_filename);
                                $error = 'Вы не можете закачать данный файл, т.к. он несовместим с расширением';
                                return false;
                        }
                        break;
                default:
                        @unlink($tmp_filename);
                        $error = 'Вы не можете закачать данный файл, т.к. он несовместим с расширением';
                        return false;
                        break;
        }

        if ( $width > 0 && $height > 0 )
        {
                //$new_filename = uniqid(rand()) . $imgtype;
                $new_filename = $img_real_name;

                $ini_val = ( phpversion() >= '4.0.0' ) ? 'ini_get' : 'get_cfg_var';

                if ( @$ini_val('open_basedir') != '' )
                {
                        if ( @phpversion() < '4.0.3' )
                        {
                                die('open_basedir is set and your PHP version does not allow move_uploaded_file');
                        }

                        $move_file = 'move_uploaded_file';
                }
                else
                {
                        $move_file = 'copy';
                }

                if (!is_uploaded_file($img_filename))
                {
                        $error = 'Не удается загрузить файл';
                }
                $move_file($img_filename, $engine_show_root.'/engine/doc_images/'.$new_filename);
                @chmod($engine_show_root.'/engine/doc_images/'.$new_filename, 0777);

                $message  = 'Файл был успешно загружен на сервер.';
                return true;
        }
        else
        {
                $error = 'Файл имеет некорректные размеры ширины и высоты.';
                return false;
        }

}

if (isset($_POST['upload']))
{
        UploadFile($error, $message);
}
?>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
    <title>Вставка изображения</title>
    <link title="CSS style" href="/engine_lib/engine/main.css" type="text/css" rel="stylesheet">
    <script language="JavaScript">
    var pt = false;
    function retImage(cId)
    {
            img_list = document.getElementById("images_list");
            img_ulr = document.getElementById("image_url");

            if (img_ulr.value != "http://")
            {
                    result_image = img_ulr.value;
            }
            else
            {
                    result_image = img_list.value;
            }

            if ((result_image != "http://")&&(result_image != ""))
            {
                    window.opener.insImage(cId, result_image);
                    window.close();
            }
            else
            {
                    alert('Неверно выбрана картинка');
            }
    }

    function UpdateImage(reset_index)
    {
            img_list = document.getElementById("images_list");
            if (reset_index == true)
            {
                    img_list.selectedIndex = 0;
            }

            sel_index = img_list.selectedIndex;

            add_btn = document.getElementById("add_button");

            if (sel_index > 0)
            {
                    img_cache = document.getElementById("image_cache");
                    img_cache.src = img_list.value;

                    img_delete = document.getElementById("image_delete");
                    img_delete.disabled = false;

                    img_preview = document.getElementById("image_preview");
                    img_preview.src = img_list.value;
                    img_preview.style.display = '';
                    add_btn.disabled = false;

                    img_size = img_cache.fileSize / 1024;
                    img_size_type = 'Кб';
                    if (img_size > 1024)
                    {
                            img_size = img_size / 1024;
                            img_size_type = 'Мб';
                    }

                    if ((Math.round(img_size*100)/100) <= 0)
                    {
                            img_size_text = 'нет данных';
                    }
                    else
                    {
                            img_size_text = (Math.round(img_size*100)/100) + ' ' + img_size_type;
                    }

                    img_size_x = img_cache.width;
                    img_size_y = img_cache.height;

                    img_resized = false;
                    if (img_size_x>150)
                    {
                            img_preview.height=img_size_y/(img_size_x/150);
                            img_preview.width=150;
                            img_resized = true;
                    }

                    if ((img_size_y>200)&&(img_resized == false))
                    {
                            img_preview.widtht=img_size_x/(img_size_y/200);
                            img_preview.height=200;
                    }

                    prev_x    = document.getElementById("preview_x");
                    prev_y    = document.getElementById("preview_y");
                    prev_size = document.getElementById("preview_size");

                    if (img_size_x > 0)
                    {
                            prev_x.innerHTML = img_size_x;
                    }
                    else
                    {
                            prev_x.innerHTML = 'нет данных';
                    }

                    if (img_size_y > 0)
                    {
                            prev_y.innerHTML = img_size_y;
                    }
                    else
                    {
                            prev_y.innerHTML = 'нет данных';
                    }

                    prev_size.innerHTML = img_size_text;
            }
            else
            {
                    img_preview = document.getElementById("image_preview");
                    img_preview.style.display = 'none';

                    img_delete = document.getElementById("image_delete");
                    img_delete.disabled = true;

                    prev_x    = document.getElementById("preview_x");
                    prev_y    = document.getElementById("preview_y");
                    prev_size = document.getElementById("preview_size");

                    prev_x.innerHTML = 'нет данных';
                    prev_y.innerHTML = 'нет данных';
                    prev_size.innerHTML = 'нет данных';

                    img_ulr = document.getElementById("image_url");
                    if (img_ulr.value != 'http://')
                    {
                            add_btn.disabled = false;
                    }
                    else
                    {
                            add_btn.disabled = true;
                    }
            }
    }
    </script>
  </head>

<body onload="UpdateImage(false)">
  <?
  if ($error)
  {
  ?>
  <table border="0" cellSpacing="0" cellPadding="5" class="line" style="margin-bottom: 5px;" width="433">
    <tr><th class="error">Ошибка</th></tr>
    <tr><td><?=$error;?></td></tr>
  </table>
  <?
  }
  if ($message)
  {
  ?>
  <table border="0" cellSpacing="0" cellPadding="5" class="line" style="margin-bottom: 5px;" width="433">
    <tr><th>Информация</th></tr>
    <tr><td><?=$message;?></td></tr>
  </table>
  <?
  }
  ?>
  <table border="0" cellSpacing="0" cellPadding="5" class="line" width="433">
    <tr><th>Вставка изображения</th></tr>
    <tr>
      <form method="post" action="image.php" enctype="multipart/form-data">
      <td>
        <input type="hidden" name="obj_id" value="<?=$_REQUEST['obj_id']?>">
        <input type="hidden" name="ctrlId" value="<?=$_REQUEST['ctrlId']?>">
        <span class="cat"><img src="/engine_lib/engine/img/arrow.gif" brder="0" vspace="2"> Загрузка изображения с вашего компьютера:</span>
        <table border="0" cellSpacing="2" cellPadding="0">
          <tr>
            <td><input type="file" name="img_file" class="com_input"></td>
            <td><input type="submit" name="upload" value="Загрузить" class="com_button" style="height: 20;"></td>
          </tr>
        </table>
      </td>
      </form>
    </tr>
    <tr>
      <form method="POST" action="image.php">
      <td>
        <input type="hidden" name="obj_id" value="<?=$_REQUEST['obj_id']?>">
        <input type="hidden" name="ctrlId" value="<?=$_REQUEST['ctrlId']?>">
        <span class="cat"><img src="/engine_lib/engine/img/arrow.gif" brder="0" vspace="2"> Выбрать метод сортировки изображений:</span><br>
        <table border="0" cellSpacing="0" cellPadding="0" style="margin-top: 3px;" width="100%">
          <tr><td>
            <select name="order_type" class="com_select">
              <option value="0" <?echo (($order_type == 0) ? "SELECTED" : "");?>>по имени файла</option>
              <option value="1" <?echo (($order_type == 1) ? "SELECTED" : "");?>>по дате изменения файла</option>
              <option value="2" <?echo (($order_type == 2) ? "SELECTED" : "");?>>по дате изменения файла (по убыванию)</option>
              <option value="3" <?echo (($order_type == 3) ? "SELECTED" : "");?>>без сортировки</option>
            </select>
          </td></tr>
        </table>
        <table border="0" cellSpacing="0" cellPadding="0" style="margin-top: 3px;" width="100%">
          <tr><td width="100%" align="right"><input type="submit" value="Запомнить настройки" class="com_button"></td></tr>
        </table>
      </td>
      </form>
    </tr>
    <form method="POST" action="image.php">
    <tr>
      <td valign="top">
        <input type="hidden" name="obj_id" value="<?=$_REQUEST['obj_id']?>">
        <input type="hidden" name="ctrlId" value="<?=$_REQUEST['ctrlId']?>">
        <span class="cat"><img src="/engine_lib/engine/img/arrow.gif" brder="0" vspace="2"> Выбрать изображение из списка уже загруженных:</span>
        <table border="0" cellSpacing="0" cellPadding="2" style="margin-top: 3px;" width="100%">
          <tr><td valign="top">
            <select onChange="UpdateImage(false);" name="images_list" id="images_list" class="com_input" size="14" style="width: 200px;">
              <option value="" SELECTED>Ввести адрес вручную:</option>
              <?
              $dir = "$engine_show_root/engine/doc_images/";
              // Открыть заведомо существующий каталог и начать считывать его содержимое
              $files_array = array();
              $files_times  = array();
              if (is_dir($dir))
              {
                      if ($dh = opendir($dir))
                      {
                              while (($file = readdir($dh)) !== false)
                              {
                                      if (is_file($dir.$file))
                                      {
                                              //print "Файл: $file : тип: " . filetype($dir . $file) . "\n";
                                              $files_array[] = $file;
                                              $files_times[] = filemtime($dir.$file);
                                      }
                              }
                              closedir($dh);
                      }

                      natsort($files_array);
                      if ($order_type == 1)
                      {
                              asort($files_times, SORT_NUMERIC);
                      }
                      else
                      {
                              arsort($files_times, SORT_NUMERIC);
                      }
              }

              if (($order_type == 1)||($order_type == 2))
              {
                      $each_array = $files_times;
              }
              else
              {
                      $each_array = $files_array;
              }

              foreach($each_array as $file_id => $file_param)
              {
                      echo '<option value="'.$engine_show_htroot."/engine/doc_images/".$files_array[$file_id].'">'.$files_array[$file_id].'</option>'."\n";//
              }
              ?>
            </select>
            <table border="0" cellSpacing="0" cellPadding="0" style="margin-top: 3px;">
              <tr><td><input type="submit" name="delete" id="image_delete" value="Удалить изображение" class="com_button" title="Удалить выбранный файл"></td></tr>
            </table>
          </td><td width="100%" align="center" valign="top">
            <table border="0" cellSpacing="0" cellPadding="2" style="margin-top: 3px;" width="100%">
              <tr><td align="center" colspan="2"><span class="cat">Предварительный просмотр</span></td></tr>
              <tr><td>Ширина:&nbsp;</td><td width="100%"><span id="preview_x">нет данных</span></td></tr>
              <tr><td>Высота:&nbsp;</td><td><span id="preview_y">нет данных</span></td></tr>
              <tr><td>Размер:&nbsp;</td><td><span id="preview_size">нет данных</span></td></tr>
              <tr>
                <td colspan="2" align="center">
                  <img src="" id="image_preview" style="display: none;" border="0">
                  <img src="" id="image_cache" style="position: absolute; z-index: -100; top: -5000px; left: -5000px; visibility: hidden">
                </td>
              </tr>
            </table>
          </td></tr>
        </table>
      </td>
    </tr>
    <tr>
      <td>
        <span class="cat"><img src="/engine_lib/engine/img/arrow.gif" brder="0" vspace="2"> Введите адрес рисунка:</span><br>
        <table border="0" cellSpacing="0" cellPadding="0" style="margin-top: 3px;" width="100%">
          <tr><td>
          <input type="text" id="image_url" onkeyup="UpdateImage(true)" name="imgurl" value="http://" size="40" class="com_input" style="width: 337px;">
          </td></tr>
        </table>
        <table border="0" cellSpacing="0" cellPadding="0" style="margin-top: 3px;" width="100%">
          <tr><td width="100%" align="right"><input type="button" value="Вставить" class="com_button" id="add_button" disabled onClick="retImage(<?=intval($_REQUEST['ctrlId'])?>);"> <input type="button" value="Отмена" onclick="window.close()" class="com_button"></td></tr>
        </table>
      </td>
    </tr>
    </form>
  </table>
</body>
</html>