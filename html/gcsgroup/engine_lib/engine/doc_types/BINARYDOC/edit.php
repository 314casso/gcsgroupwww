<?
$image_arr = array('jpg', 'jpeg', 'bmp', 'gif', 'png');

$file_path = $engine_show_root.'/engine/documents/document'.$parent_doc_spec['doc_id'].'.'.$parent_doc_spec['ext'];

if (file_exists($file_path))
{
        $bin_display = '';
        $file_size = filesize($file_path);

        $count_id = 0;
        $format = array("á","Êá","Ìá","Ãá","Òá");
        while(($file_size/1024)>1 && $count_id<5)
        {
                $file_size=$file_size/1024;
                $count_id++;
        }
        $file_size = number_format($file_size,0,'','.')." ".$format[$count_id];

        $file_date = filemtime($file_path);
}
else
{
        $bin_display = 'none';
        $file_size = '';
}

if (in_array($parent_doc_spec['ext'], $image_arr))
{
        $bin_display_image = '';
        $bin_image = '<img src="/engine/documents/document'.$parent_doc_spec['doc_id'].'.'.$parent_doc_spec['ext'].'">';
}
else
{
        $bin_display_image = 'none';
        $bin_image = '&nbsp;';
}

$tpl->assign(
              array('{BIN_DISPLAY}' => $bin_display,
                    '{BIN_DISPLAY_IMAGE}' => $bin_display_image,
                    '{BIN_IMAGE}'  => $bin_image,
                    '{FILE_SIZE}' => $file_size,
                    '{FILE_DATE}' => date('d.m.Y H:i:s', $file_date),
                    '{BIN_ID}' => $parent_doc_spec['doc_id'],
                    '{BIN_EXT}' => $parent_doc_spec['ext'],
                    )
            );
?>
