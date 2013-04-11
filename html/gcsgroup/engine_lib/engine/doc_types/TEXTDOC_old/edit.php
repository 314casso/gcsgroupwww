<?


                                $sd=mysql_query("select * from engine_documents where pid=$id");

                                while($sd_f=mysql_fetch_array($sd)) {
                                        $SUBDOC.="<option value=$sd_f[id]>$sd_f[name]</option>";
                                        }

                                $html=$parent_doc_spec[html];
                                $html=str_replace("[SHOWHTROOT]",$engine_show_htroot,$html);


                                $tpl->assign(
                                                array(
                                                        '{TDATE}'        =>  $parent_doc[creation_date],
                                                        SUBDOC        =>  $SUBDOC,
                                                        '{divHTML}'        =>        preg_replace ("|<table(.*)>|Usi","<table\\1 border=1>",$html)
                                                )
                                        );



?>
