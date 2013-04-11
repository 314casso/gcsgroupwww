<?php

/*
 *  $Id: $
 *
 */

?>
<BODY bgproperties="fixed" background="img/fon.jpg" style="background-repeat: repeat-x;" contentEditable=false unselectable >
<LINK href="style.css" rel="stylesheet" type="text/css">
<?php
include 'config.inc';

global $type, $id, $wizard, $filename, $overwrite;

if (getrights($pid) == 1) {
    if ($type != 'catalog') {
        echo "Этот тип документа не может быть импортирован.";
    } else {
        switch ($wizard) {
            case 1:
                // Вывод колонок
                $filename = trim($filename);
                if ($filename == '')
                    import_error('Файл не задан');
                //echo "file:".$_FILES['filename']['tmp_name'].'<br>';
                $fa = file($_FILES['filename']['tmp_name']);
                //print_r($fc);exit;
                //$_SESSION['import_file'] = join('', $fc);
                //echo $_SESSION['import_file'];
                //$import_file = join('', $fc);
                unset ($header);
                unset ($_SESSION['import']);
                $i = 0;
                foreach ($fa as $str) {
                    if (isset($header)) {
                        $_SESSION['import'][$i++] = $str;
                    } else {
                        $header = split("\t", $str);
                    }
                }
                if (!is_array($header))
                    import_error('Неверный формат файла');
                $query = "select cv.item, cp.id, cp.name, cv.value from engine_CATALOG_param cp, engine_CATALOG_values cv where cv.param = cp.id and cp.catalog=$id order by cv.item, cp.id";
                $rs = db_select($query);
                unset ($param);
                $param_names = array('Название', 'Цена');
                while ($r = db_get_array($rs)) {
                    if (!in_array($r['name'], $param_names))
                        array_push ($param_names, $r['name']);
                }
?>
<b>Файл загружен</b><br><br>
Соответствие колонок файла и полей каталога:
<br><br>
<table>
<tr><td>Поле документа</td><td>Колонка в файле</td></tr>
<?
                $i = 0;
                foreach ($header as $cn) {
                    echo "<tr><td>".$param_names[$i++]."</td><td>$cn</td></tr>";
                }
?>
</table><br>
<form method=post><input type=hidden name=wizard value=2>
<input type=checkbox name=overwrite> Очистить каталог перед импортом<br><br>
<input type=hidden name=id value=<?=$id?>><input type=submit value='Продолжить'></form>
<form method=post><input type=hidden name=wizard value=0><input type=hidden name=id value=<?=$id?>><input type=submit value='Назад'></form>
<?

                break;
            case 2:
                // Выполнение импорта
                
                // Очтистка
                if ($overwrite == 'on') {
                	$rs = db_select("select id from engine_documents where pid=$id");
                	while ($r = db_get_array($rs)) {
                		db_exec("delete from engine_CATALOG_values where item=".$r['id']);
                		db_exec("delete from engine_CATALOGITEM where doc_id=".$r['id']);
                	}
            		db_exec("delete from engine_documents where pid=$id");
                }
                
                // Импорт
                $query = "select id, name from engine_CATALOG_param where catalog=$id order by id";
                //echo $query;
                $rs = db_select($query);
                unset($param_ids);
                $i = 2;
                while ($r = db_get_array($rs)) {
                    //if (!in_array($r['id'], $param_ids))
                    //    array_push ($param_ids, $r['id']);
                    //echo $i." -- ".$r['id']."<br>";
                    $param_ids[$i++] = $r['id'];
                }
                //print_r($param_ids); exit;
                //echo "session: <pre>"; print_r($_SESSION['import']); echo "</pre><br>";
                foreach ($_SESSION['import'] as $str) {
                	$cols = split("\t", $str);
                	//echo("insert into engine_documents (type, pid) values ('CATALOGITEM', $id)<br>");
                	$did = db_insert("insert into engine_documents (type, pid) values ('CATALOGITEM', $id)");
                	//echo "did: $did<br>";
                	//echo("insert into engine_CATALOGITEM (name, price, doc_id) values ('".$cols[0]."', '".$cols[1]."', $did)<br>");
                	$iid = db_insert("insert into engine_CATALOGITEM (name, price, doc_id) values ('".db_quote($cols[0])."', '".db_quote($cols[1])."', $did)");
                	//echo "iid: $iid<br>";
                	foreach ($param_ids as $col=>$id_) {
                		db_insert("insert into engine_CATALOG_values (param, value, item) values (".$id_.", '".db_quote($cols[$col])."', $did)");
                	}
                	
                }
?>
<b>Каталог импортирован</b><br><br>
<?
                break;
            default:
                // Выбор файла
                unset($_SESSION['import_file']);
?>
<form method=post enctype="multipart/form-data">
<b>Импорт</b><br><br>
Выберете файл для импорта: &nbsp; <input type=file name=filename> &nbsp;
<input type=hidden name=MAX_FILE_SIZE value=30000>
<input type=submit value='Загрузить'><input type=hidden name=wizard value=1><input type=hidden name=id value=<?=$id?>></form>
<?php
        }
        switch ($type) {
            case 'catalog':
        }
        //echo "Экспорт выполнен";
        echo $exp;
    }
} else {
    echo "У вас нет прав не экспорт";
}
import_footer();

function import_footer () {
?>
</body></html>
<?
    exit;
}

function import_error ($msg) {
    echo $msg;
    import_footer();
}
?>
