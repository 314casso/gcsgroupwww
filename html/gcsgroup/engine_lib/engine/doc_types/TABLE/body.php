<?php

/*
 *  $Id: body.php,v 1.5 2005/01/12 18:39:44 dave Exp $
 *
 *  $Log: body.php,v $
 *  Revision 1.5  2005/01/12 18:39:44  dave
 *  Убран глюк в комментариях
 *
 *
 */

global $db_name;
if ($this->spec['tblname'] != '') {
    $sql = "select * from ".$this->spec['tblname'];
    $r = @mysql_query($sql);

    $this->body = $this->spec[begin];
    $result = @mysql_list_fields($db_name, $this->spec[tblname]);
    $Nr = @mysql_num_fields($result);

    while ($f = @mysql_fetch_array($r)) {
    	$out = $this->spec[format];
    	for ($count = 0; $count < $Nr; $count++) {
    		$fld = @mysql_field_name($result, $count);
    		$out = str_replace($fld, $f[$fld], $out);
    		$out = str_replace("field".(1 + $count), $f[$fld], $out);
    	}
    	$this->body .= $out;
    }
    $this->body .= $this->spec[end];
}

?>