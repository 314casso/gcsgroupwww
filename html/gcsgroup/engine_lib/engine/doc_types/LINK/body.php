<?
if ($this->spec[linkid])
{
        $ldoc = new document($this->spec[linkid]);
        $this->caption_long   = $ldoc->caption_long;
        $this->caption_medium = $ldoc->caption_medium;
        $this->caption_short  = $ldoc->caption_short;
        $this->type = $ldoc->type;
        $this->body = $ldoc->body;

	 if (!$this->body && !$_GET[action] ){
		$redirect_ = 1;
	 }

	 $exist_redirect = $this->spec[status]; 
	 if ($exist_redirect == 1 && !$_GET[action]){
		$redirect_ = 1;
	 }

	 if ($redirect_ == 1){

		//перекидываем на страницу где есть ссылка
        	$sql_link = "select ed.* from engine_LINK el, engine_documents ed  where ed.id=el.linkid and el.doc_id='{$this->id}'";
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
        	  ($msrch)?$cntnt = "/srch_cntnt/":$cntnt = "/".ENGINE_CONTENT_PREFIX.(ENGINE_CONTENT_PREFIX != '' ? '/' : '');
       	  if ($pth)
                	$pth = $cntnt . $pth;
       	  else
                	$pth = $cntnt;

		  header('Location: '.$pth);
	 }

}
elseif ((!empty($this->spec['link_external']))&&(!isset($_GET['action'])))
{
        $link_ex = $this->spec['link_external'];
        if (strpos($link_ex, '/') === false)
        {
                header('Location: /cntnt/'.$link_ex.'.html');
        }
        else
        {
                header('Location: '.$link_ex);
        }
}
?>
