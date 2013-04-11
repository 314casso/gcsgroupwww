<?php
/*
 *  $Id: document.inc,v 1.10 2005/01/11 18:51:59 dave Exp $
 *
 *  $Log: document.inc,v $
 *  Revision 1.10  2005/01/11 18:51:59  dave
 *  Убран модификатор 'u' в регулярных выражениях
 *
 *  Revision 1.9  2005/01/11 18:09:55  dave
 *  Настраиваемый префикс контента в URL
 *
 *  Revision 1.8  2004/12/26 11:47:27  dave
 *  Переформатирование кода
 *
 *  Revision 1.7  2004/12/16 22:14:55  dave
 *  Оптимизация запросов к БД, избавление от ненужных OUTER JOIN'ов
 */

include_once "functions.php";
class Document {
        var $id;
        var $name;
        var $visible;
        var $pid ;
        var $caption_long;
        var $caption_medium ;
        var $caption_short ;
        var $code;
        var $style;
        var $creation_date ;
        var $user;
        var $tpl;
        var $type;
        var $body;

        function Document($id, $Body_needed=1,$ptitle = "")
        {
                global $engine_caption;
                global $def_title;
                global $def_meta;
                global $def_counter1;
                global $def_counter2;
                global $def_counter3;
                global $buy_form;
                $code = $id;

              $id = (int)$id;

		if (!$id){
			$sql = "select id from engine_documents where code='$code'";
			list($id) = mysql_fetch_array(mysql_query($sql));
			$id = intval($id);
		}

                //print ("<!--Body_needed=".$Body_needed."--------doc_id=".$id."--------------------------------------------------------->");

		if ($id > 0)
		{			$sql = 'SELECT *
			        FROM engine_documents
			        WHERE id='.$id;

                        //$sql = "select code,resume,title,meta,counter1,counter2,counter3,id,name,private,visible,pid,undeletable,caption_long,caption_short,caption_medium,date_format(creation_date,'%d.%m.%Y') creation_date,user,type,tpl,style from engine_documents where id=$id";
			$result = mysql_query($sql);
			$document = mysql_fetch_array($result, MYSQL_ASSOC);

			if (is_array($document))
			{
				foreach($document as $key_name => $key_value)
				{
					unset($document[$key_name]);
					$document[strtolower($key_name)] = $key_value;
				}
			}
			$document[creation_date] = strtotime($document[creation_date]);
			$document[creation_date] = date('d.m.Y', $document[creation_date]);

			$this->id = $id;
			$this->name = $document[name];
			$this->visible = $document[visible];
			$this->pid = $document[pid];
			$this->caption_long = $document[caption_long];
			$this->caption_medium = $document[caption_medium];
			$this->caption_short = $document[caption_short];
			$this->code = $document[code];
			$this->style = $document[style];
			$this->creation_date = $document[creation_date];
			$this->user = $document[user];
			$this->tpl = $document[tpl];
			$this->undeletable = $document[undeletable];
			$this->lastchange = $document['lastchange'];

			if ($document['meta'])
			{				$this->meta = $document['meta'];
			}
			else
			{				$this->meta = $def_meta;
			}
			if (!empty($document['title']))
			{
				$this->title = $document['title'];
			}
			else
			{
                       	 $sql_ = "select varvalue from engine_conf where varname='def_title' ";
				$result2 = mysql_query($sql_);
				$document2 = mysql_fetch_array($result2);
				$this->title = $document['name'].". ".$document2[0];
			}

			//добавил возможность вывода в title - "Название документа. Title по-умолчанию"

			/*if (!empty($document['title'])){
				if ($document['text_change'] == 1){
					$this->title = $document['title'];
				}
				elseif ($document['text_change'] == ''){
					$this->title = $document['title'];
				}
				else{
					$this->title = $document['name'].". ".$document['title'];
				}
			}
			else{
				$this->title = $document['name'];			
			}*/
 
                        if ($document['counter1'])
                                $this->counter1 = $document['counter1'];
                        else
                                $this->counter1 = $def_counter1;
                        if ($document['counter2'])
                                $this->counter2 = $document['counter2'];
                        else
                                $this->counter2 = $def_counter2;
                        if ($document['counter3'])
                                $this->counter3 = $document['counter3'];
                        else
                                $this->counter3 = $def_counter3;
                        $this->resume = $document[resume];

                        $this->type = $document[type];
                        $filename = "doc_types/{$this->type}/name.txt";
                        if (file_exists($filename)) {
                                $ff = file($filename);
                                $this->typename = $ff[0];
                        } else
                                $this->typename = $this->type;
                       $this->private = $document[private];
                        if ($document[type] == 'FOLDER') {
                                $this->folder = $this->name;
                                $this->folderid = $this->id;
                        } else {

                                if ($this->pid != -1 and $this->pid) {
                                        $sql = "select name,id from engine_documents where id=" . $this->pid;
                                        $r = mysql_query("$sql") or die (mysql_error() . $sql);
                                        list($this->folder, $this->folderid) = mysql_fetch_array($r);
                                }
                        }


                        // Iieo?aai oaaeii ii eioi?iio auaiaeou aieoiaio
                        $where = "id=" . ($this->pid);
                        $f[pid] = $document[pid];
                        $f[tpl] = $document[tpl];
                        $f[style] = $document[style];
			
                     while ($f[pid] != -1 && ($f[tpl] == -1 || $f[style] == -1) && $i_ < 100) {
                                $sql = "select id,tpl,pid,style from engine_documents where $where";
				//echo $sql;
                                $f = mysql_fetch_array(mysql_query($sql));
                                if ("id=$f[pid]" == $where) {
						$f[pid] = 0;
				     }
				     $where = "id=$f[pid]";
                                if ($f[tpl] != -1 && $this->tpl == -1)
                                        $this->tpl = $f[tpl];
                                if ($f[style] != -1 && $this->style == -1)
                                        $this->style = $f[style];
				$i_++;
                        }

                        global $deftpl, $msrch;
                        if ($this->tpl == -1 and
                                mysql_num_rows(mysql_query("select * from engine_tpl where id='$deftpl' "))) {
                                $this->tpl = $deftpl;
                        }


                        if (testdoc_type($document[type])) {
                                global $sitelogged, $engine_root;
                                if (!$document[private] or $sitelogged) {
                                        if ($sitelogged) {
                                                $r = mysql_query("select * from engine_users u, engine_group_rights r where u.ugroup=r.ugroup and r.document=$id and granted=1 and u.id=$sitelogged[id]") or die (mysql_error());
                                                $hasrights = mysql_num_rows($r);
                                        }
                                        if ($hasrights or !$document[private]) {
                                                $sql = "select * from engine_" . $document[type] . " where doc_id=$id";

                                                $this->spec = @mysql_fetch_array(mysql_query($sql));

                                               if ($Body_needed==1) {
								include "$engine_root/engine/doc_types/{$document[type]}/body.php";
							}

                                        } else {
                                                $this->body = "Вы не имеете доступа к этой информации!";
                                                $this->tpl = $deftpl;
                                        }
                                } else {
                                        $this->body = "У Вас нет доступа к этому документу т.к. вы не авторизованы.";
                                       
                                        $this->tpl = $deftpl;
						//echo $this->body."<hr>";
                                }
                        } else $this->body = "";


                } elseif ($id != -2 and $id != -3 and $id != -4 and $id != -5) {
                        global $defdoc;
                        global $deftpl, $engine_root;
                        $this->id = -1;
                        $this->pid = -1;
                        $this->name = $engine_caption;
                        $this->caption_long = $engine_caption;
                        $this->caption_medium = $engine_caption;
                        $this->caption_short = $engine_caption;
                        $this->code = "";
                        $this->style = -1;
                        $this->creation_date = "";
                        $this->user = -1;
                        $this->tpl = -1;
                        $this->type = 'FOLDER';
                        $this->visible = 1;
                        $this->doctoshow = $defdoc;
                        $this->tpl = $deftpl;
                        if ($Body_needed==1) include "$engine_root/engine/doc_types/FOLDER/body.php";
                } elseif ($id == -2) {
                        global $defdoc;
                        global $deftpl, $engine_root, $searchtpl, $engine_show_htroot;
                        $this->id = -1;
                        $this->pid = -1;
                        $this->name = $engine_caption;
                        $this->caption_long = $engine_caption;
                        $this->caption_medium = $engine_caption;
                        $this->caption_short = $engine_caption;
                        $this->code = "";
                        $this->style = -1;
                        $this->creation_date = "";
                        $this->user = -1;
                        $this->tpl = -1;
                        $this->type = 'FOLDER';
                        $this->visible = 1;
                        $this->doctoshow = $defdoc;
                        if (!$searchtpl)
                                $this->tpl = $deftpl;
                        else
                                $this->tpl = $searchtpl;

                        if ($Body_needed==1)
                        {

//                        $udm = udm_alloc_agent('mysql://mns_user:mns_pass@localhost/mnogosearch/', 'single');
                        $udm = udm_alloc_agent('mysql://$db_user:$db_pass@$db_host/$db_name/', 'single');
                        if ((! Udm_Load_Ispell_Data($udm, UDM_ISPELL_TYPE_AFFIX, 'en', '/usr/lib/ispell/russian.aff', 0)) ||
                                        (! Udm_Load_Ispell_Data($udm, UDM_ISPELL_TYPE_SPELL, 'ru', '/usr/dict/russian.dict', 1))) {
                                exit;
                        }

                        global $search;
                        $query = $search;
                        // $query="компании";
                        global $page, $SERVER_NAME, $engine_show_htroot;
                        Udm_Set_Agent_Param($udm, UDM_PARAM_QUERY, $query);
                        Udm_Set_Agent_Param($udm, UDM_PARAM_PAGE_NUM, (int)$page);
                        Udm_Set_Agent_Param($udm, UDM_PARAM_PAGE_SIZE, 20);
                        udm_add_search_limit ($udm, UDM_LIMIT_URL, "http://" . $SERVER_NAME . $engine_show_htroot);
                        $l = Udm_Find($udm, "");
                        $count = udm_get_res_param($l, UDM_PARAM_NUM_ROWS);
                        // $doc=new Document(-1);
                        $total = udm_get_res_param($l, UDM_PARAM_FOUND);
                        $pages = ($total - $total % 20) / 20;
                        if ($total % 20)$pages++;
                        $this->body .= "<b>Страницы:</b>";

                        for($i = 0;$i < $pages;$i++) {
                                if ($i != $page) {
                                        $this->body .= "<a href=?page=$i&search=$search>" . ($i + 1) . "</a>&nbsp;";
                                } else
                                        $this->body .= "<b>" . ($i + 1) . "</b>&nbsp;";
                        }
                        for ($i = 0;$i < $count;$i++) {
                                preg_match("|.*/(.*)\.html[^/]*|si", udm_get_res_field ($l, $i, UDM_FIELD_URL), $res);
                                if ($res[1]) {

                                        $sd = new Document($res[1]);
                                        if ($sd->type == "NEW") {
                                                $cpt = $sd->spec[header];
                                        } else if ($sd->type == "NEW") {
                                                $cpt = $sd->spec[name];
                                        } else
                                                $cpt = $sd->name;
                                        if ($cpt)
                                                $nn = $cpt;
                                        else
                                                $nn = "Без названия";
                                        $this->body .= "<li><a href=" . $sd->geturl() . ">" . $nn . "</a></li>";
                                } else {
                                        global $def_title;
                                        $this->body .= "<li><a href=''>" . udm_get_res_field ($l, $i, UDM_FIELD_TITLE) . "</a></li>";
                                }
                                $res = "";
                        }
                        udm_free_res($l);
                        udm_free_ispell_data($udm);
                        udm_free_agent($udm);

                        }

                } elseif ($id == -3) {
                        global $defdoc, $buscet, $buyform, $sitelogged;
                        global $deftpl, $engine_root, $do;
                        $this->id = -1;
                        $this->pid = -1;
                        $this->name = $engine_caption;
                        $this->caption_long = $engine_caption;
                        $this->caption_medium = $engine_caption;
                        $this->caption_short = $engine_caption;
                        $this->code = "";
                        $this->style = -1;
                        $this->creation_date = "";
                        $this->user = -1;
                        $this->tpl = -1;
                        $this->type = 'FOLDER';
                        $this->visible = 1;
                        $this->doctoshow = $defdoc;
                        $this->tpl = $deftpl;
                        if ($do != 'Отправить') {
                                $this->body = "<form name=buyform method=post>
                                        <table>";
                                if ($do == '   Пересчитать   ' or !$do)
                                        $this->body .= "<tr>
                                            <td>Товар</td>
                                            <td>кол-во</td>
                                            <td>стоимость</td>
                                            <td>удалить</td>
                                            </tr>";
                                while (list ($item, $amount) = @each ($buscet)) {
                                        $d = new Document($item);
                                        global ${"del".$d->id}, ${"amount".$d->id};
                                        if (${"amount".$d->id}) {
                                                $buscet[$item] = ${"amount".$d->id};
                                                $amount = $buscet[$item];
                                        }
                                        if (${"del".$d->id})
                                                $buscet[$item] = 0;
                                        else {
                                                if ($buscet[$item]) {
                                                        list($price) = mysql_fetch_array(mysql_query("select price from engine_CATALOGITEM where doc_id='$item'"));

                                                        if ($do == '   Пересчитать   ' or !$do)
                                                                $this->body .= "<tr>
                                                                        <td>" . $d->spec[name] . "</td>
                                                                        <td><input name=amount{$d->id} value='" . $amount . "'></td>
                                                                        <td>" . ($amount * $price) . "</td>
                                                                        <td><input type=Checkbox name=del" . $d->id . "></td>
                                                                        </tr>";
                                                        $ttl += $amount * $price;
                                                }
                                        }
                                }
                                if ($do == '   Пересчитать   ' or !$do)
                                        $this->body .= "<tr>
                                                                        <td></td>
                                                                        <td></td>
                                                                        <td>$ttl</td>
                                                                        <td></td>
                                                                        </tr>";

                                if ($do == '   Оформить заказ   ') {
                                        $this->body .= $buy_form;
                                        $this->body .= "
                                        <script>
                                                document.forms.buyform.userlname.value='$sitelogged[lname]';
                                                document.forms.buyform.username. value='$sitelogged[name]';
                                                document.forms.buyform.usermname.value='$sitelogged[mname]';
                                                document.forms.buyform.useremail.value='$sitelogged[email]';
                                                document.forms.buyform.userphone.value='$sitelogged[phone]';
                                        </script>
                                        ";
                                }
                                $this->body .= "<tr><td colspan=4><table width=100% style ='border:0'><tr><td style ='border:0'>";
                                if ($do == '   Пересчитать   ' or !$do)
                                        $this->body .= "<input type=submit value='   Пересчитать   ' name=do>";
                                if ($do == '   Пересчитать   ' or !$do)
                                        $this->body .= "</td><td style ='border:0' align=right><input type=submit value='   Оформить заказ   ' name=do></td>";
                                else {
                                        $this->body .= "<td style ='border:0' align=center><input type=submit value='Отправить' name=do></td>";
                                }

                                $this->body .= "</TR></table></td></TR></table>";
                                $this->body .= "</form>";
                        } else {
                                global $userlname, $username, $usermname, $useremail, $userphone , $shop_email;
                                $msg = "
Информация о заказчике:
ФИО                $userlname $username $usermname
email                $useremail
Тел                $userphone

Заказано:
";
                                while (list ($item, $amount) = @each ($buscet)) {
                                        $d = new Document($item);
                                        if ($amount)
                                                $msg .= (++$i) . ($d->spec[name]) . "                        $amount        шт.\n";
                                }

                                mail($shop_email, "Заказ", $msg);
                                $this->body .= "Заказ отправлен!!!";
                        }
                } else if ($id == -4) {
                        global $defdoc;
                        global $deftpl, $engine_root, $table, $dbviewtpl, $sku, $dbviewid;
                        $this->id = -1;
                        $this->pid = -1;
                        $this->name = $engine_caption;
                        $this->caption_long = $engine_caption;
                        $this->caption_medium = $engine_caption;
                        $this->caption_short = $engine_caption;
                        $this->code = "";
                        $this->style = -1;
                        $this->creation_date = "";
                        $this->user = -1;
                        $this->tpl = -1;
                        $this->type = 'DB';
                        $this->visible = 1;
                        $this->tpl = $deftpl;
                        $this->body = $dbviewtpl[$table];

                        $sql = "select * from $table where {$dbviewid[$table]}=$sku";
                        $flds = mysql_fetch_array(mysql_query($sql));
                        foreach($flds as $var => $val) {
                                // echo         "$var=>$val<BR>";
                                $this->body = preg_replace("|{-$var-}|Usi", $val, $this->body);
                        }
                } else if ($id == -5) {
                        global $defdoc;
                        global $deftpl, $engine_root, $table, $dbviewtpl, $sku, $dbviewid, $cmscarddoccode, $_SERVER, $icsession;
                        global $iccat, $ichost, $iccard;
                        $this->id = -1;
                        $this->pid = -1;
                        $this->name = $engine_caption;
                        $this->caption_long = $engine_caption;
                        $this->caption_medium = $engine_caption;
                        $this->caption_short = $engine_caption;
                        $this->code = "";
                        $this->style = -1;
                        $this->creation_date = "";
                        $this->user = -1;
                        $this->tpl = -1;
                        $this->type = 'ICCARD';
                        $this->visible = 1;
                        $this->tpl = $deftpl;
                        $this->body = $dbviewtpl[$table];
                        $this->body = geticpage("http://$ichost/cgi-bin/$iccat.cgi/$iccard.html?id=$icsession", 0);
                        $curl = "http://".$_SERVER['HTTP_HOST']."/".ENGINE_CONTENT_PREFIX.(ENGINE_CONTENT_PREFIX != '' ? '/' : '').$cmscarddoccode.".html?";
                        // Подмена ссылок
                        $this->body = preg_replace ("@(action|href)\s*=\s*(['\"])\s*(http:\/\/$ichost/cgi-bin/$iccat.cgi(.*))(['\"].*>)@Usie", "str_replace(\"\\\\'\",\"'\",\"\\1=\\2\".\"$curl\".\"icurl=\".urlencode(\"\\3\").\"\\5\")", $this->body);
                }

        }

        //------------------------------------------------

        function geturl()
        {
                global $msrch;
                ($msrch)?$cntnt = "/srch_cntnt/":$cntnt = "/".ENGINE_CONTENT_PREFIX.(ENGINE_CONTENT_PREFIX != '' ? '/' : '');
                $sql = "select * from engine_documents where id={$this->id}";
                $r = mysql_query("$sql") ;
                if (mysql_num_rows($r)) {
                        $path = "";
                        $f = mysql_fetch_array($r);
                        if ($f[code])
                                $doc = $f[code];
                        else
                                $doc = $f[id];

                        $pid = $f[pid];
                        $path[0] = "$doc.html";
                        $k = 0;
                        while ($path[$k] && $k_ < 50) {
                                $k++;
				     $k_++;
                                $sql = "select * from engine_documents where id=$pid";
                                $r1 = mysql_query("$sql") or die (mysql_error());
                                $f1 = mysql_fetch_array($r1);
                                $path[$k] = $f1[code];
                                if ($pid != $f1[pid]) $pid = $f1[pid];
			    	    else $k_ = 50;
                        }
                        $pth = "";
                        for ($m = $k-1;$m >= 0;$m--) {
                                if ($m != $k-1) $pth .= '/';
                                $pth .= $path[$m];
                        }
                }
                if ($pth)
                        $pth = $cntnt . $pth;
                else
                        $pth = $cntnt; //"/cntnt";
		  
                $arus = array('/"/', '/\'/', '/ /', '/а/', '/б/', '/в/', '/г/', '/д/', '/е/', '/ё/', '/ж/', '/з/', '/и/', '/к/', '/л/', '/м/', '/н/', '/о/', '/п/', '/р/', '/с/', '/т/', '/у/', '/ф/', '/х/', '/ч/', '/ц/', '/щ/', '/ш/', '/й/', '/ы/', '/ъ/', '/ь/', '/э/', '/ю/', '/я/', '/А/', '/Б/', '/В/', '/Г/', '/Д/', '/Е/', '/Ё/', '/Ж/', '/З/', '/И/', '/К/', '/Л/', '/М/', '/Н/', '/О/', '/П/', '/Р/', '/С/', '/Т/', '/У/', '/Ф/', '/Х/', '/Ч/', '/Ц/', '/Щ/', '/Ш/', '/Й/', '/Ы/', '/Ъ/', '/Ь/', '/Э/', '/Ю/', '/Я/');
                $atrans = array('', '', '_', 'a', 'b', 'v', 'g', 'd', 'e', 'yo', 'j', 'z', 'i', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f', 'h', 'ch', 'ch', 'sh', 'sh', 'y', 'i', '', '', 'e', 'u', 'ya', 'A', 'B', 'V', 'G', 'D', 'E', 'YO', 'J', 'Z', 'I', 'K', 'L', 'M', 'N', 'O', 'P', 'R', 'S', 'T', 'U', 'F', 'H', 'Ch', 'Ch', 'Sh', 'Sh', 'Y', 'I', '', '', 'E', 'U', 'Ya');
                $pth = preg_replace($arus, $atrans, $pth);
                global $SERVER_NAME, $engine_show_htroot;
                // echo $this->id;
                if ($this->id == 2101) {
                        echo $engine_show_htroot . $pth;
                        exit;
                }
                return strtolower($engine_show_htroot . $pth);
        }
}

function geturl($id)
{
        global $msrch;
        ($msrch)?$cntnt = "/srch_cntnt/":$cntnt = "/".ENGINE_CONTENT_PREFIX.(ENGINE_CONTENT_PREFIX != '' ? '/' : '');
        $code = $id;
        $id = (int)$id;
        if (!$id) {
                $sql = "select id from engine_documents where code='$code'";
                list($id) = mysql_fetch_array(mysql_query($sql));

        }


        $sql = "select * from engine_documents where id='{$id}'";

        $r = mysql_query("$sql") ;

       if (mysql_num_rows($r)) {

                $path = "";
                $f = mysql_fetch_array($r);

                if ($f[code])
                        $doc = $f[code];
                else
                        $doc = $f[id];

                $pid = $f[pid];
                $path[0] = "$doc.html";
                $k = 0;
		 /* if ($f[type] == "LINK"){
			//работаем с ссылкой
        		$sql_link = "select ed.* from engine_LINK el, engine_documents ed  where ed.id=el.linkid and el.doc_id='{$id}'";
			$r_link = mysql_query($sql_link) ;
      			if (mysql_num_rows($r_link)) {
 				$f_link = mysql_fetch_array($r_link);
			       if ($f_link[code])
                        		$doc = $f_link[code];
                		else
                       		$doc = $f_link[id];

                		$pid = $f_link[pid];
                		$path[0] = "$doc.html";
			}
		  }*/

                while ($path[$k] && $k_ < 50) {	

                        $k++;
			    $k_++;
                        $sql = "select * from engine_documents where id=$pid";
                        $r1 = mysql_query("$sql") or die (mysql_error());
                        $f1 = mysql_fetch_array($r1);
                        $path[$k] = $f1[code];
                        if ($pid != $f1[pid]) $pid = $f1[pid];
			    else $k_ = 50;
                }

                $pth = "";
                		$path[0] = "$doc.html";
                for ($m = $k-1;$m >= 0;$m--) {
                        if ($m != $k-1) $pth .= '/';
                        $pth .= $path[$m];
                }
        }
        if ($pth)
                $pth = $cntnt . $pth;
        else
                $pth = $cntnt; //"/cntnt";

        $arus = array('/"/', '/\'/', '/ /', '/а/', '/б/', '/в/', '/г/', '/д/', '/е/', '/ё/', '/ж/', '/з/', '/и/', '/к/', '/л/', '/м/', '/н/', '/о/', '/п/', '/р/', '/с/', '/т/', '/у/', '/ф/', '/х/', '/ч/', '/ц/', '/щ/', '/ш/', '/й/', '/ы/', '/ъ/', '/ь/', '/э/', '/ю/', '/я/', '/А/', '/Б/', '/В/', '/Г/', '/Д/', '/Е/', '/Ё/', '/Ж/', '/З/', '/И/', '/К/', '/Л/', '/М/', '/Н/', '/О/', '/П/', '/Р/', '/С/', '/Т/', '/У/', '/Ф/', '/Х/', '/Ч/', '/Ц/', '/Щ/', '/Ш/', '/Й/', '/Ы/', '/Ъ/', '/Ь/', '/Э/', '/Ю/', '/Я/');
        $atrans = array('', '', '_', 'a', 'b', 'v', 'g', 'd', 'e', 'yo', 'j', 'z', 'i', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f', 'h', 'ch', 'ch', 'sh', 'sh', 'y', 'i', '', '', 'e', 'u', 'ya', 'A', 'B', 'V', 'G', 'D', 'E', 'YO', 'J', 'Z', 'I', 'K', 'L', 'M', 'N', 'O', 'P', 'R', 'S', 'T', 'U', 'F', 'H', 'Ch', 'Ch', 'Sh', 'Sh', 'Y', 'I', '', '', 'E', 'U', 'Ya');
        $pth = preg_replace($arus, $atrans, $pth);

        global $SERVER_NAME, $engine_show_htroot;

        return strtolower ($engine_show_htroot . $pth);
}

?>
