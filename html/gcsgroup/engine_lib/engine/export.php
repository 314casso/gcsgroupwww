<?php

/*
 *  $Id: export.php,v 1.2 2005/02/01 22:07:56 dave Exp $
 *
 */

include 'config.inc';

global $type, $id;

//if (getrights($pid) == 1) {
    if ($type != 'catalog') {
        echo "Этот тип документа не может быть экспортирован.";
    } else {
        switch ($type) {
            case 'catalog':
            $query = "select cv.item, cp.id, cp.name, cv.value,cp.select from engine_CATALOG_param cp, engine_CATALOG_values cv where cv.param = cp.id and cp.catalog=$id order by cv.item, cp.id";
            $rs = db_select($query);
            unset ($param);
            $param_names = array();
            $ids = array();
            while ($r = db_get_array($rs)) {
                //echo $r['id'].' -- '.$r['item'].' -- '.$r['name'].' -- '.$r['value']."<br>";
		  if ($r[select]){
			//тип селект
			$sql = "select 
					ecpo.val
				from 
					engine_documents d,
					engine_CATALOGITEM ci,
					engine_CATALOG_param as ecp,
					engine_CATALOG_values ecv,
					engine_CATALOG_possvals as ecpo
				where 
					d.visible=1 and 
					ci.doc_id=d.id and 
					ecp.catalog = d.pid and
					ecp.id = '".$r['id']."' and
					d.pid=".$id." and 
					ecv.item = d.id and
					ecv.param=ecp.id and
					ecpo.id = ecv.poss_val_id 
				";
			$rs1 = db_select($sql);
            		while ($r1 = db_get_array($rs1)) {
				$r['value'] = $r1[val];
			}

		  }
		  $r['value'] = str_replace(array("\n","\t", "\r"),'', $r['value']);
                $param[$r['item']][$r['id']] = $r['value'];
                if (!in_array($r['name'], $param_names))
                    array_push ($param_names, $r['name']);
                if (!in_array($r['id'], $ids))
                    array_push ($ids, $r['id']);
            }
            $query = "select ci.doc_id, ci.name, ci.price from engine_documents d, engine_CATALOGITEM ci where ci.doc_id=d.id and d.pid=$id";
            $fields = array(
                'name' => 'Name',
                'price' => 'Price'
            );
            $rs = db_select($query);
            $exp = '';
            $record = array();
            foreach ($fields as $fname=>$cname) {
                array_push($record, $cname);
            }
            foreach ($param_names as $cname) {
                array_push($record, $cname);
            }
            $exp = join("\t", $record)."\n";
            while ($r = db_get_array($rs)) {
                $record = array();
                foreach ($fields as $fname=>$cname) {
                    array_push($record, $r[$fname]);
                }
                foreach ($ids as $id_) {
                    array_push($record, $param[$r['doc_id']][$id_]);
                }
                $exp .= join("\t", $record)."\n";
            }
        }
        //echo "Экспорт выполнен";
        //echo htmlspecialchars($exp);
        header('Content-type: application/octet-stream');
        header('Content-Disposition: attachment; filename="export_'.$type.'_'.$id.'.txt"');
        //echo "<pre>";
        echo $exp;
    }
//} else {
//    echo "У вас нет прав не экспорт";
//}

?>