<?
/*
https://bt.belti.ru/tasks/bug_view_page.php?bug_id=0007949
сейчас ссылка на документ в визивиге вставляется в каноническом виде (site.ru/cntnt/folders/code.html)
Раньше ссылки вставлялись в виде site.ru/show.php?doc=id
нужно написать код, который преобразовывает все сылки второго вида в первый вид. Из неочевидных проблем -- нужно не забыть якоря
*/
$text_ = str_replace(array("\n","\t"),"",$parent_doc_spec['html']);
preg_match_all("/show.php\?doc=*(.*?)[\"|\#|\&]/i", $text_, $id_url_old_arr);

if (is_array($id_url_old_arr[1])){
	for ($i = 0; $i < count($id_url_old_arr[1]); $i++){
        	$sql_link = "select ed.* from engine_documents ed  where  ed.id='{$id_url_old_arr[1][$i]}'";
		$r_link = mysql_query($sql_link) ;
      		if (mysql_num_rows($r_link)) {
 			$f_link = mysql_fetch_array($r_link);
			if ($f_link[code])
                        	$doc = $f_link[code];
                	else
                       	$doc = $f_link[id];

                	$pid = $f_link[pid];
                	$path[0] = "$doc.html";
			$k = 0;

              	while ($path[$k] && $k_ < 50) {	
                        $k++;
			    $k_++;
                        $sql_ = "select * from engine_documents where id=$pid";
                        $r1 = mysql_query("$sql_") or die (mysql_error());
                        $f1 = mysql_fetch_array($r1);
                        $path[$k] = $f1[code];
                        if ($pid != $f1[pid]) $pid = $f1[pid];
			   else $k_ = 50;
                	}
		}
                $pth = "";
                for ($m = $k-1;$m >= 0;$m--) {
                        if ($m != $k-1) $pth .= '/';
                        $pth .= $path[$m];

                }
   		/*echo "<pre>";
   		print_r($path);	   
   		echo "</pre>";*/
        	  ($msrch)?$cntnt = "/srch_cntnt/":$cntnt = "/".ENGINE_CONTENT_PREFIX.(ENGINE_CONTENT_PREFIX != '' ? '/' : '');
       	  if ($pth)
                	$pth = $cntnt . $pth;
       	  else
                	$pth = $cntnt;
		 $url_old_ = str_replace(array("\"","#","&"),"",$id_url_old_arr[0][$i]);
 		 $add = "";
		 if (strstr($url_old_,"&")) $add = "?";
		 if (strstr($url_old_,"#")) $add = "#";
		 if ($url_old_ != '' && $pth != '')
			 $td_old_link_ .= "<tr><td><input name=\"url_old[]\" type=\"hidden\" value=\"".$url_old_."\">".$url_old_."</td>\n<td><input name=\"url_new[]\" type=\"hidden\" value=\"".$pth."\">".$pth."".$add."</td>\n</tr>\n";
	}
	if ($td_old_link_){
		$td_old_link_ = "<table cellspacing=\"1\" cellpadding=\"3\" border=\"0\" width=\"100%\" class=\"line\"><tr><td colspan=2 align=center><b>Список старых ссылок в теле документа</b> - заменить? <input name=\"old_url_change\" type=\"checkbox\" value=\"1\"></td></tr>
<tr><td class=\"row2\">Старая ссылка</td><td class=\"row2\">Новая ссылка</td></tr>".$td_old_link_."</table><br>";
	}
}


include $engine_root.'/engine/spaw/spaw_control.class.php';


$sw = new SPAW_Wysiwyg('html' /*name*/,$parent_doc_spec['html'] /*value*/);
$html = $sw->getHtml();
$tpl->assign(
	array(
		'{TDATE}' => $parent_doc['creation_date'],
		'{divHTML}' => $html,
		'{table_old_link}' => $td_old_link_
	)
);

?>
