<?


				$sd=mysql_query("select * from engine_documents where pid=$id");
				while($sd_f=mysql_fetch_array($sd)) {
					$SUBDOC.="<option value=$sd_f[id]>$sd_f[name]</option>";												
					}
				$tpl->assign(
						array(
							SUBDOC	=>  $SUBDOC,
							divHTML	=>	$parent_doc_spec[html]
						)
					);	
					


?>