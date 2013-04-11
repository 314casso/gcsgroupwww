<?php

/*
 *  $Id: document.php,v 1.28 2007/06/18 10:28:50 vadimbond Exp $
 *
 *  $Revision: 1.28 $
 *
 *  $Log: document.php,v $
 *  Revision 1.28  2007/06/18 10:28:50  vadimbond
 *  для редактора возможность привязывать стили - шаблоны
 *
 *  Revision 1.24  2006/10/27 13:59:44  ereih
 *  *** empty log message ***
 *
 *  Revision 1.23  2006/10/27 13:38:47  ereih
 *  Обновление функционала рубрикатора
 *
 *  Revision 1.20  2006/06/15 10:02:28  ereih
 *  Редизайн и улучшение функционала
 *
 *  Revision 1.16  2005/05/21 13:06:39  aavakyan
 *  Исправлен вывод шаблона в заголовок страницы (выводится актуальный наследованный шаблон)
 *
 *  Revision 1.15  2005/05/20 15:26:17  aavakyan
 *  Добавлен вывод кода и шаблона документа (вверху, в постоянном заголовке)
 *
 *  Revision 1.14  2004/12/26 11:47:27  dave
 *  Переформатирование кода
 *
 *  Revision 1.13  2004/12/18 10:56:05  dave
 *  Исправлен баг с невозможностью смены шаблона документа
 *
 *  Revision 1.12  2004/12/16 22:14:55  dave
 *  Оптимизация запросов к БД, избавление от ненужных OUTER JOIN'ов
 *
 *  Revision 1.11  2004/12/15 17:36:17  dave
 *  Лог CVS внесен в комментарий
 *
 *  Revision 1.10  2004/12/14 20:02:44  dave
 *  Исправлено перевыставление кода при его обнулении
 *
 */

$name_ = str_replace("\\\"", "\"", $name_);
/*$tpldoc=str_replace("'","\'",$tpldoc);
$caption_short=str_replace("'","\'",$caption_short);
$caption_medium=str_replace("'","\'",$caption_medium);
$caption_long=str_replace("'","\'",$caption_long);
$code=str_replace("'","\'",$code);
*/

//print_r($_REQUEST);
//exit;


if (!$do or $prfnd) {
        if ($id)
        {        	$rts = getrights($id);
                switch ($logged[role]) {
                        case 'Автор':
                                $t = '_author';
                                if ($rts == 2)
                                        $t = '_forbidden';
                                break;
                        case 'Разработчик':
                                $t = '_developer';
                                break;
                        case 'Редактор':
                                $t = '_editor';
                                if ($rts == 3)
                                        $t = '_readonly';
                                if ($rts == 2)
                                        $t = '_forbidden';
                                break;
                        case 'Администратор':
                                $t = '_admin';
                                break;
                        default:
                                $t = '_author';
                                if ($rts == 2)
                                        $t = '_forbidden';
                                break;
                }
                $tpl->define(
                        array(
                                main => "tpl/document{$t}.tpl"

                                )
                        );
                $tpl->define_dynamic ("doc_tpl", "main");
                $tpl->define_dynamic ("doc_style", "main");

                $sql = "select * from engine_documents where id=$id";
                $sql = "select resume,send,title,meta,counter1,counter2,counter3,code,id,name,private,visible,pid,undeletable,caption_long,caption_short,caption_medium,date_format(creation_date,'%Y-%m-%d %H:%i:%s') creation_date,user,type,tpl,style from engine_documents where id=$id";
                $parent_doc = mysql_fetch_array(mysql_query($sql));

		//так как у многих сайтов в бд нет полей title_old,text_change то попытаемся обойти эту проблему
              $sql = "select title_old,text_change from engine_documents where id=$id";
		if (!$news_r = mysql_query($sql)){
			$err_title = 1;
		}
		else{
			$parent_doc_add = mysql_fetch_array(mysql_query($sql));
		}

                //**************Определение текущего актуального шаблона ($actual_tpl)*******************************************************
                $pdoc = $parent_doc;
                $sql_tpl= "select * from engine_tpl where id=$pdoc[tpl]";

                if ($pdoc[tpl]!='-1')
                        $actual_tpl=mysql_result(mysql_query($sql_tpl),0,"name");
                else
                {
                    //Если шаблон не определен, поднимаемся наверх по дереву папок пока не дойдем до папки, с установленным шаблоном
                    while ($pdoc[pid]!=-1):

                        $sql_pid= "select id,pid,tpl from engine_documents where id=$pdoc[pid]";
                        $pdoc= @mysql_fetch_array(@mysql_query($sql_pid));
                        if ($pdoc[tpl]!=-1) break;

                    endwhile;

                    //Если шаблона не обнаружили, берём шаблон по умолчанию
                    if ($pdoc[tpl]=='-1') $tplid=$deftpl; else $tplid=$pdoc[tpl];

                            $sql_tpl= "select * from engine_tpl where id=$tplid";
                            $actual_tpl= @mysql_result(@mysql_query($sql_tpl),0,"name");

               }


                //********Определяем код текущего документа ($cur_code)

                if (!$parent_doc[code])
                        $cur_code="Не определен";
                else
                        $cur_code=$parent_doc[code];

                //****************Вывод даты, id, типа, шаблона и кода документа

                /*
                echo "
                        <script>
                                window.parent.topp.document.all.doc_date.innerHTML='$parent_doc[creation_date]';
                                window.parent.topp.document.all.doc_id.innerHTML='$parent_doc[id]';
                                window.parent.topp.document.all.doc_templ.innerHTML='$actual_tpl';
                                window.parent.topp.document.all.doc_type.innerHTML='$parent_doc[type]';
                                window.parent.topp.document.all.cur_code.innerHTML='$cur_code';
                                //" . str_replace(" ", '&nbsp;', $parent_doc[type]) . "
                        </script>
                        ";
                */
                /**
                 * ************************************Запоняем список стилей****************************************
                 */
                $tpl->assign(
                        array(
                                STL_ID => -1,
                                STYLE_SELECTED => "",
                                STYLE_NAME => "-------------------"
                                )
                        );
                $tpl->parse(STYLES , ".doc_style");

                $sql = "select distinct * from engine_styles";
                $r = mysql_query($sql) or die("SQL error " . mysql_error() . " in: $sql\n");
                while ($f = mysql_fetch_array($r)) {
                        if ($parent_doc[style] == $f[id]) $sel = "selected";
                        else $sel = "";
                        $tpl->assign(
                                array(
                                        STYLE_SELECTED => $sel,
                                        STL_ID => $f[id],
                                        STYLE_NAME => $f[name]
                                        )
                                );
                        $tpl->parse(STYLES , ".doc_style");
                }

                /**
                 * ************************************Запоняем список шаблонов****************************************
                 */

                $tpl->assign(
                        array(
                                TPL_ID => -1,
                                TEXT => "-------------------",
                                TPL_SELECTED => ""
                                )
                        );
                $tpl->parse(DOC_TPL, ".doc_tpl");

                $sql = "select distinct * from engine_tpl";
                $r = mysql_query($sql) or die("SQL error " . mysql_error() . " in: $sql\n");
                while ($f = mysql_fetch_array($r)) {
                        if ($parent_doc[tpl] == $f[id]) $sel = "selected";
                        else $sel = "";
                        $tpl->assign(
                                array(
                                        TPL_SELECTED => $sel,
                                        TPL_ID => $f[id],
                                        TEXT => $f[name]
                                        )
                                );
                        $tpl->parse(DOC_TPL, ".doc_tpl");
                }

                $filename = "doc_types/{$parent_doc[type]}/name.txt";

                if (file_exists($filename)) {
                        $ff = file($filename);
                        $type = $ff[0];
                } else $type = $parent_doc[type];

                if (file_exists("$engine_show_root/engine/doc_icons/actimg" . $parent_doc[id] . ".gif"))
                        $aimg = "$engine_show_htroot/engine/doc_icons/actimg" . $parent_doc[id] . ".gif";
                elseif (file_exists("$engine_show_root/engine/doc_icons/actimg" . $parent_doc[id] . ".jpg"))
                        $aimg = "$engine_show_htroot/engine/doc_icons/actimg" . $parent_doc[id] . ".jpg";
                elseif ($parent_doc[type] == 'FOLDER')
                        $aimg = "$engine_show_htroot/engine/doc_icons/default/actfld.gif";
                else
                        $aimg = "$engine_show_htroot/engine/doc_icons/default/actdoc.gif";

                if (file_exists("$engine_show_root/engine/doc_icons/unactimg" . $parent_doc[id] . ".gif"))
                        $uaimg = "$engine_show_htroot/engine/doc_icons/unactimg" . $parent_doc[id] . ".gif";
                elseif (file_exists("$engine_show_root/engine/doc_icons/unactimg" . $parent_doc[id] . ".jpg"))
                        $uaimg = "$engine_show_htroot/engine/doc_icons/unactimg" . $parent_doc[id] . ".jpg";
                elseif ($parent_doc[type] == 'FOLDER')
                        $uaimg = "$engine_show_htroot/engine/doc_icons/default/uactfld.gif";
                else
                        $uaimg = "$engine_show_htroot/engine/doc_icons/default/uactdoc.gif";

                if (file_exists("doc_types/" . $parent_doc[type] . "/onsubmit.js")) {
                        $fr = fopen ("doc_types/" . $parent_doc[type] . "/onsubmit.js", "r");
                        $submit = fread($fr, filesize("doc_types/" . $parent_doc[type] . "/onsubmit.js"));
                        fclose($fr);
                }

                /*---------------------------------------------------------------------------------------------------------*/
                // Подгружаем ввод спецыфичных для типа документа параметров, если есть таблица с его именем, файл
                // темплэйта и  файл обработки вывода тэмплэйта
                if (testdoc_type($parent_doc[type])) {
                        $tpl->define(
                                array(
                                        spec => "doc_types/" . $parent_doc[type] . "/edit.tpl"

                                        )
                                );

                        $sql = "select * from engine_" . $parent_doc[type] . " where doc_id=$id";
                        $parent_doc_spec = @mysql_fetch_array(mysql_query($sql));
                        if (!mysql_error()) {
                                include ("$engine_root/engine/doc_types/{$parent_doc[type]}/edit.php");
                                $tpl->parse('{DOC_SPEC}', "spec");
                                //$tpl->parse(SPEC, "spec");
                        } else {
                                $tpl->assign(SPEC, "BD Error:<br>" . mysql_error());
                        }
                } else {
                        $tpl->assign(SPEC, "");
                }

                /*------------------ Ресуем редактор прав -----------------------------------------------------------------*/
                $sql = "select * from engine_groups where id=$logged[ugroup]";
                $r = mysql_query($sql) or die("SQL error " . mysql_error() . " in: $sql\n");
                $grp = mysql_fetch_array($r);
                $sql = "select * from engine_groups where name='belti'";
                $r = mysql_query($sql) or die("SQL error " . mysql_error() . " in: $sql\n");
                $bgr = mysql_fetch_array($r);
                if ($grp[name] == 'belti')
                        $sql = "select * from engine_groups g, engine_group_rights r where r.ugroup=g.id and r.document=$id";
                else
                        $sql = "select * from engine_groups g, engine_group_rights r where r.ugroup=g.id and r.document=$id and g.id!=$bgr[id]";

                $r = mysql_query("$sql") or die (mysql_error());
                $rights = '
                                <TABLE width=90% align="center" cellspacing="1" cellpadding="1" border="0" >';
                while ($f = mysql_fetch_array($r)) {
                        $rights .= "
                                        <TR>
                                <TD class=top valign=bottom>
                                $f[name]
                                </TD>
                                <TD class=top valign=bottom>
                                ";
                        if (!$f[granted])$rights .= "
                                        <SELECT name=rightto$f[id]>
                                                <option selected value=0>неопределено</Option>
                                                <option value=1>есть</Option>
                                                <option value=2>нет</Option>
                                                <option value=3>только чтение</Option>
                                        </SELECT>
                                        ";
                        if ($f[granted] == 1) $rights .= "
                                        <SELECT name=rightto$f[id]>
                                                <option value=0>неопределено</Option>
                                                <option selected value=1>есть</Option>
                                                <option value=2>нет</Option>
                                                <option value=3>только чтение</Option>
                                        </SELECT>
                                        ";
                        if ($f[granted] == 2) $rights .= "
                                        <SELECT name=rightto$f[id]>
                                                <option value=0>неопределено</Option>
                                                <option value=1>есть</Option>
                                                <option selected value=2>нет</Option>
                                                <option value=3>только чтение</Option>
                                        </SELECT>
                                        ";
                        if ($f[granted] == 3) $rights .= "
                                        <SELECT name=rightto$f[id]>
                                                <option value=0>неопределено</Option>
                                                <option value=1>есть</Option>
                                                <option value=2>нет</Option>
                                                <option selected value=3>только чтение</Option>
                                        </SELECT>
                                        ";
                        $rights .= "</TD></TR>";
                }
                $rights .= '</TABLE>';
                /*---------------------------------------------------------------------------------------------------------*/
                if ($parent_doc[visible]) $vis = checked;
                else $vis = "";
                if ($parent_doc[private]) $priv = checked;
                else $priv = "";
                if ($parent_doc[undeletable]) $undlbl = checked;
                else $undlbl = "";

                $sql = "select count(*) cnt from engine_send where doc_id=$id or doc_id=$parent_doc[pid]";
                $r = mysql_query("$sql") or die (mysql_error());
                $f = mysql_fetch_array($r);
                if ($f[cnt]) {
                        if ($parent_doc[send] and $parent_doc[type] != 'NEW'and $parent_doc[type] != 'NEWSGROUP'and $parent_doc[type] != 'FOLDER')
                                $send = "Добавить&nbsp;в&nbsp;рассылку&nbsp;<input type=checkbox checked name=send>";
                        else
                                $send = "Добавить&nbsp;в&nbsp;рассылку&nbsp;<input type=checkbox name=send>";
                }
                /*---------------------------------------------------------------------------------------------------------*/
                // Рубрики
		$sql = 'SELECT *
		        FROM engine_docsinrubriques dr, engine_rubrique r
		        WHERE dr.rub = r.id and dr.doc = '.$id;

                if (!$result = @mysql_query($sql))
                {                	die($sql);
                }

                // запоминаем рубрики в которых находится документ
                while ($row = @mysql_fetch_array($result, MYSQL_ASSOC))
                {                	$doc_in[$row['id']] = $row['in'];
                }

		$sql = 'SELECT *
		        FROM engine_rubrique';

		if (!$result = @mysql_query($sql))
		{			die($sql);
		}

		$rub_pid = array();
		while ($row = @mysql_fetch_array($result, MYSQL_ASSOC))
		{			$rub_pid[(int) $row['pid']][] = $row;
		}

		if (!empty($rub_pid))
		{			$res = '';

			function DrawRub($rub_id)
			{				global $rub_pid, $res, $doc_in;
				$res .=  "\n".'<ul class="rub_ul">'."\n";
				foreach($rub_pid[$rub_id] as $temp_id => $rub)
				{					$res .=  '<li class="rub_li">';
					$status = ($doc_in[$rub['id']] == 1) ? 'checked="checked"' : '';
					$res .=  '<input type="checkbox" name="ch[]" id="ch'.$rub['id'].'" '.$status.' value="'.$rub['id'].'" /><label for="ch'.$rub['id'].'">'.$rub['name'].'</label>';

					if ((is_array($rub_pid[$rub['id']]))&&($rub['id'] > 0))
					{						$res .= DrawRub($rub['id']);
					}

					$res .=  '</li>'."\n";
				}
				$res .=  '</ul>'."\n";
			}

			DrawRub(-1);
		}

                /*---------------------------------------------------------------------------------------------------------*/
                // Привязка товаров к документам
                $flag = 1;
                if (!mysql_query("select count(id) from link_product_doc"))$flag = 0;
                if (!mysql_query("select count(sku) from products"))$flag = 0;
                if ($flag) {
                        $prodlist = "";
                        $sql = "select link_product_doc.product_id sku,products.title title, products.articul from link_product_doc
                              left join products on products.sku=link_product_doc.product_id
                                     where link_product_doc.doc_id=$parent_doc[id] order by title";
                        $r = mysql_query($sql);
                        while ($f = mysql_fetch_array($r)) {
                                $prodlist .= "<tr><td>$f[title]</td><td>$f[articul]</td><td><input type=checkbox name=prod[$f[sku]]></td></tr>";
                        }
                        $prodlist = "<table class=wnd width=100%>
                                              <tr>
                                               <td class=header>Наименование</td>
                                               <td class=header>Артикул</td>
                                               <td class=header>удалить</td>
                                              </tr>
                                    $prodlist</table>";
                        if (trim($prd_find) or trim($prd_find_art)) {
                                $sql = "select sku,title,articul from products where ";
                                if (trim($prd_find)) $sql .= "title like '%$prd_find%'";
                                if (trim($prd_find) and trim($prd_find_art))$sql .= "  or ";
                                if (trim($prd_find_art))$sql .= " articul like '%$prd_find_art%'";
                                $sql .= " order by title limit 20 ";
                                $r = mysql_query($sql);
                                while ($f = mysql_fetch_array($r)) {
                                        $fndprodlist .= "<tr><td>$f[title]</td><td>$f[articul]</td><td><input type=checkbox name=fndprod[$f[sku]]></td></tr>";
                                }
                                $fndprodlist = "<tr><td colspan=3>Результаты поиска</td></tr>
                                              <tr>
                                               <td class=header>Наименование</td>
                                               <td class=header>Артикул</td>
                                               <td class=header>Добавить</td>
                                              </tr>
                                               $fndprodlist";
                        }
                        $prodlist = "
                                    <HR color=#005597 size=1 width=100%>
                                    <a name=prodlist />
                                    <b>Связанные товары</b><br><br>
                                    $prodlist<br>
                                    Добавить товары(ID через запятую):<br><input size=100 name=prd_arts><br><br>
                                    <table class=wnd width=100%>
                                           <tr>
                                               <td colspan=3 class=header>Поиск</td>
                                           </tr>
                                           <tr>
                                             <td>название:</td><td colspan=2><input name=prd_find></td>
                                           </tr>
                                           <tr>
                                             <td>артикул:</td><td colspan=2><input name=prd_find_art></td>
                                           </tr>
                                           <tr>
                                             <td colspan=3 style='text-align:center'>
                                                <input type=submit value='Найти'  name=prfnd>
                                             </td>
                                           </tr>
                                           $fndprodlist
                                    </table>
                                   ";
                        $prodlink = "<a href=#prodlist>связать с товарами</a>";
                }

                $sql = 'SELECT l.*, u.login
                        FROM (engine_log AS l
                              LEFT JOIN engine_users AS u ON l.user = u.id
                              )
                        WHERE l.document = '.$parent_doc['id'].'
                        ORDER BY l.log_date DESC
                        LIMIT 0,1';

                $result = mysql_query($sql);
                if ($row = @mysql_fetch_array($result, MYSQL_ASSOC))
                {
                	$row['text'] = substr($row['text'], 0, strpos($row['text'], "'"));
                	$doc_last_action = '['.$row['log_date'].'] '.trim($row['text']).' ['.(empty($row['login']) ? 'пользователь удален' : $row['login']).']';
                }
                else
                {
                	$doc_last_action = 'Нет данных по последнему изменению докумнета';
                }

		  if ($err_title != 1){
			$parent_doc['title_old'] = $parent_doc_add['title_old'];
		 	if ($parent_doc_add['text_change'] != 1) {
				$parent_doc['title_old'] = $parent_doc['title'];
				$parent_doc['title'] = '';
		  	}
		  }
                $tpl->assign(
                        array(
                                '{DOC_TYPE}'          => trim($type),
                                '{DOC_RUBRIQUE}'      => $res,
                                '{DOC_COUNTER1}'      => htmlspecialchars($parent_doc['counter1']),
                                '{DOC_COUNTER2}'      => htmlspecialchars($parent_doc['counter2']),
                                '{DOC_COUNTER3}'      => htmlspecialchars($parent_doc['counter3']),
                                '{DOC_TITLE}'         => htmlspecialchars($parent_doc['title']),
                                '{DOC_TITLE_OLD}'     => htmlspecialchars($parent_doc['title_old']),
                                '{DOC_META}'          => htmlspecialchars($parent_doc['meta']),
                                '{DOC_CODE}'          => htmlspecialchars($parent_doc['code']),
                                '{DOC_NAME}'          => htmlspecialchars($parent_doc['name']),
                                '{DOC_CAPT_S}'        => str_replace("&amp;","&",htmlspecialchars($parent_doc['caption_short'])),
                                '{DOC_CAPT_M}'        => str_replace("&amp;","&",htmlspecialchars($parent_doc['caption_medium'])),
                                '{DOC_CAPT_L}'        => str_replace("&amp;","&",htmlspecialchars($parent_doc['caption_long'])),
                                '{DOC_RESUME}'        => str_replace("&amp;","&",htmlspecialchars($parent_doc['resume'])),
                                '{DOC_ID}'            => $parent_doc['id'],
                                '{DOC_VISIBLE}'       => $vis,
                                '{DOC_UNACTIMG}'      => $uaimg,
                                '{DOC_ACTIMG}'        => $aimg,
                                '{DOC_UNDELETABLE}'   => $undlbl,
                                '{DOC_CREATION_DATE}' => $parent_doc['creation_date'],
                                '{DOC_TEMPLATE}'      => $actual_tpl,
                                '{DOC_LAST_ACTION}'   => $doc_last_action,
                                '{DOC_RIGHTS}'        => $rights,
                                '{DOC_PRIVATE}'       => $priv,

                                '{PAGE}'              => $page,

                                SEND => $send,
                                CAPT_S => $parent_doc[caption_short],
                                CAPT_M => $parent_doc[caption_medium],
                                CAPT_L => $parent_doc[caption_long],
                                CODE => $parent_doc[code],
                                //ID => $parent_doc[id],
                                VISIBLE => $vis,
                                //TYPE => $type,
                                UNACTIMG => $uaimg,
                                ACTIMG => $aimg,
                                //TYPE => $type,
                                NAME => $parent_doc[name],
                                SUBMIT => $submit,

                                PAGE => $page,
                                UNDELETABLE => $undlbl,
                                TITLE => $parent_doc[title],
                                //META => $parent_doc[meta],
                                COUNTER1 => $parent_doc[counter1],
                                COUNTER2 => $parent_doc[counter2],
                                COUNTER3 => $parent_doc[counter3],
                                //RESUME => $parent_doc[resume],
                                RUBRIQUE => $res,
                                DOC_PROD => $prodlist,
                                PRODLINK => $prodlink
                                )
                        );
                $tpl->parse(MAIN, array("main"));
                $tpl->FastPrint();
        }
        if ($prfnd) {
                echo "<script>
                                document.all.rubtbl.style.display='';
                                document.all.comtbl.style.display='none';
                                document.all.spec__tbl.style.display='none';
                                document.all.rightstbl.style.display='none';
                                document.all.rubtbl_tdr.src='img/zakladki_pole/ugol_02.gif';
                                document.all.rubtbl_tdl.src='img/zakladki_pole/ugol_02_l.gif';
                                document.all.rubtbl_td.background='img/zakladki_pole/polosa_02.gif';

                                document.all.comtbl_tdr.src='img/zakladki_pole/ugol_01.gif';
                                document.all.comtbl_tdl.src='img/zakladki_pole/ugol_01_l.gif';
                                document.all.comtbl_td.background='img/zakladki_pole/polosa_01.gif';
                                document.all.spec__tbl_tdr.src='img/zakladki_pole/ugol_01.gif';
                                document.all.spec__tbl_tdl.src='img/zakladki_pole/ugol_01_l.gif';
                                document.all.spec__tbl_td.background='img/zakladki_pole/polosa_01.gif';
                                document.all.rightstbl_td_r.src='img/zakladki_pole/ugol_01.gif';
                                document.all.rightstbl_tdl.src='img/zakladki_pole/ugol_01_l.gif';
                                document.all.rightstbl_td.background='img/zakladki_pole/polosa_01.gif';
                        </script>";
        }
} elseif ($do == 1) {
        $rts = getrights($id);
        if (($logged[role] == 'Автор' or $logged[role] == 'Редактор') and ($rts == 3 or $rts == 2)) {

?>
<!DOCTYPE html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
  <link href="main.css" rel="stylesheet" type="text/css">
  <title>Ошибка доступа к документу</title>
</head>
<body>
<table cellspacing="0" cellpadding="0" width="100%" height="70%" align="center" border="0">
  <tr>
    <td width="100%" valign="middle" align=center >
      <table width="350" cellspacing="1" cellpadding="3" class="line">
        <tr><th class="error">Ошибка доступа</th></tr>
        <tr><td align="center" style="height: 60px;">У вас нет прав на редактирование этого документа.</td></tr>
      </table>
    </td>
  </tr>
</table>
</body>
</html>
<?php
                exit;
        }

        if ($send) {
                $send = 'send=1,';
        } else $send = 'send=0,';

	if ($logged[role] == 'Редактор' || $logged[role] == 'Администратор' || $logged[role] == 'Разработчик')
	{
		if ($visible)
		{			$vis = 'visible=1,';
                }
                else
                {                	$vis = 'visible=0,';
                }
        }

	if ($logged[role] == 'Редактор' || $logged[role] == 'Администратор' || $logged[role] == 'Разработчик')
	{
                if ($private)
                {                	$priv = 'private=1,';
                }
                else
                {                	$priv = 'private=0,';
                }
        }

        $code_sql = '';
        if (empty($name_))
        {        	$alert = "Вы не можете создавать документ с пустым полем Имя!";
        	$sql_name = '';
        }
        else
        {        	$sql_name = "name='$name_',";

        	if (!empty($code))
	        {
	        	$sql = "select count(*) from engine_documents where code='$code' and id!=$id";
	                list($count) = mysql_fetch_array(mysql_query("$sql"));

	                if ($count)
	                {
	                	$alert = "У вас уже есть документ с таким кодом! ";
	                }
	                else
			{
				$code_sql = "code='$code',";
			}
		}
		else
		{
			$code_sql = "code='" . engine_get_preferred_document_code($name_) . "',";
	        }
        }

	if ($logged[role] == 'Редактор' || $logged[role] == 'Разработчик')
	{		if ($undeletable)
		{			$undlbl = 'undeletable=1,';
		}
		else
		{			$undlbl = 'undeletable=0,';
		}
                /*
                                                                $devhtml="
                                title='$title',
                                meta='$meta',
                                counter1='".str_replace("'","\\'",$counter1)."',
                                counter2='".str_replace("'","\\'",$counter2)."',
                                counter3='".str_replace("'","\\'",$counter3)."',
                                ";
*/
        /*        $devhtml = "
                                title='$title',
                                meta='$meta',
                                counter1='$counter1',
                                counter2='$counter2',
                                counter3='$counter3',
                                ";*/
		//задача: в админке в поле title по умолчанию документа  - только в этом случае вносить новый title. Это делается для того, чтобы в названии <title></title> в случае если title  не менялся выводилось "Название документа. Title по-умолчанию", а если поменяли title, то выводился бы только title, а Название документа - не выводилось. 
		//так как у многих сайтов в бд нет полей title_old,text_change то попытаемся обойти эту проблему
              $sql = "select title, title_old,text_change from engine_documents where id=$id";
		if (!$news_r = mysql_query($sql)){
			$err_title = 1;
			$devhtml_add = " title='$title', ";
		}
		else{
			if (!empty($title) && !empty($title_old)){
				$devhtml_add = " title='$title', text_change='1', title_old = '$title_old', ";
			}
			else{
				if (!empty($title_old)){
					$devhtml_add = " title='$title_old', text_change='0', title_old = '$title_old', ";
				}
				else{
					if ($news_r[text_change] == 0 && empty($news_r[title]))  $devhtml_add = " title='$title', text_change='0', title_old = '', ";
				}
			}
		}		
                $devhtml = $devhtml_add."
                                
                                meta='$meta',
                                counter1='$counter1',
                                counter2='$counter2',
                                counter3='$counter3',
                                ";
        }
        if ($logged[role] == 'Разработчик')
                $style_tpl = "
                                tpl='$tpldoc',
                                style='$doc_style',
                                ";
        if ($logged[role] == 'Редактор')
                $style_tpl = "
                                tpl='$tpldoc',
                                style='$doc_style',
                                ";

        $sql = "update engine_documents set
                        $devhtml
                        caption_short='" . rtrim($caption_short) . "',
                        caption_medium='" . rtrim($caption_medium) . "',
                        caption_long='" . rtrim($caption_long) . "',
                        $code_sql
                        $send
                        $vis
                        $undlbl
                        $priv
                        $style_tpl
                        $sql_name
                        resume='$resume'
                        where id=$id";

        if ($actimg) {
                $fn = explode(".", $actimg_name);
                $ext = $fn[count($fn)-1];
                if ($ext == 'gif' || $ext == 'jpg') {
                        @unlink("$engine_show_root/engine/doc_icons/actimg" . $id . ".gif");
                        @unlink("$engine_show_root/engine/doc_icons/actimg" . $id . ".jpg");
                        copy($actimg, "$engine_show_root/engine/doc_icons/actimg" . $id . ".$ext");
                        chmod("$engine_show_root/engine/doc_icons/actimg" . $id . ".$ext", 0777);
                }
        }
        if ($unactimg) {
                $fn = explode(".", $unactimg_name);
                $ext = strtolower($fn[count($fn)-1]);
                if ($ext == 'gif' || $ext == 'jpg') {
                        @unlink("$engine_show_root/engine/doc_icons/unactimg" . $id . ".gif");
                        @unlink("$engine_show_root/engine/doc_icons/unactimg" . $id . ".jpg");
                        copy($unactimg, "$engine_show_root/engine/doc_icons/unactimg" . $id . ".$ext");
                        chmod("$engine_show_root/engine/doc_icons/unactimg" . $id . ".$ext", 0777);
                }
        }

	mysql_query($sql) or die("SQL error " . mysql_error() . " in: $sql\n");

	if (!mysql_error())
	{		$sql = 'SELECT *
		          FROM engine_documents
		         WHERE id='.$id;
	}

	$doc = mysql_fetch_array(mysql_query($sql), MYSQL_ASSOC);
	$sql = 'SELECT *
	          FROM engine_'.$doc['type'].'
	         WHERE doc_id='.$id;

	$parent_doc_spec = @mysql_fetch_array(mysql_query($sql), MYSQL_ASSOC);

	if (testdoc_type($doc['type']))
	{		include 'doc_types/'.$doc['type'].'/proc.php';
	}

	if (isset($doc['lastchange']))
	{
		$sql = 'UPDATE engine_documents
		           SET lastchange = NOW()
		         WHERE id='.$doc['id'];

		if (!$result = mysql_query($sql))
		{
			die($sql);
		}
	}

	$sql = 'INSERT INTO engine_log (log_date, user, text, document)
                                 VALUES (NOW(), "'.$logged['id'].'", "Изменение документа \''.mysql_real_escape_string($name_).'\'", "'.$id.'")';

	mysql_query("$sql") or die (mysql_error() . $sql);
        // Если прологинился администратор, то выставляем права
        if ($logged[role] == 'Администратор') {
                $sql = "select * from engine_groups ";
                $r = mysql_query("$sql") or die (mysql_error());
                mysql_query("delete from engine_group_rights  where document=$id") or die (mysql_error());
                $sql1 = "update engine_group_rights set granted=1 where `ugroup` in ";
                $sql2 = "update engine_group_rights set granted=0 where `ugroup` in ";
                $lst1 = "(";
                $lst2 = "(";
                while ($f = mysql_fetch_array($r)) {
                        mysql_query("insert into engine_group_rights(document,`ugroup`,granted) values($id,$f[id],'" . ${"rightto$f[id]"} . "')") or die (mysql_error());
                }
        }

        //Сохранение параметров рубрикатора
        $sql = 'SELECT *
	        FROM engine_docsinrubriques dr, engine_rubrique r
	        WHERE dr.rub = r.id and dr.doc = '.$id;

	if (!$result = @mysql_query($sql))
	{
		die($sql);
	}

	// запоминаем рубрики в которых находится документ
	while ($row = @mysql_fetch_array($result, MYSQL_ASSOC))
	{
		$doc_in[$row['id']] = $row['in'];
	}

	if (is_array($_POST['ch']))
	{		foreach($_POST['ch'] as $temp_id => $rub_id)
		{			if ($doc_in[$rub_id])
			{				$sql = 'UPDATE engine_docsinrubriques dr
				           SET dr.`in` = 1
				        WHERE doc = "'.intval($_POST['id']).'" AND rub="'.intval($rub_id).'";';
			}
			else
			{				$sql = 'INSERT INTO engine_docsinrubriques (`doc`, `rub`, `in`)
				                                    VALUES ("'.intval($_POST['id']).'", "'.intval($rub_id).'", 1);';
			}

			if (!$result = mysql_query($sql))
			{				die($sql);
			}

			unset($doc_in[$rub_id]);
		}
	}

	if (!empty($doc_in))
	{		foreach($doc_in as $rub_id => $rub_in)
		{			$sql = 'DELETE FROM engine_docsinrubriques
			        WHERE doc = "'.intval($_POST['id']).'" AND rub = "'.intval($rub_id).'";';

			if (!$result = mysql_query($sql))
			{
				die($sql);
			}
		}
	}

        // Привязка продуктов
        if (mysql_query("select count(id) from link_product_doc") and mysql_query("select count(sku) from products")) {
                if ($prod)
                        foreach($prod as $p => $v) {
                        if ($v) {
                                mysql_query("delete from link_product_doc where doc_id=$id and product_id='$p'");
                        }
                }
                if ($fndprod)
                        foreach($fndprod as $p => $v) {
                        if ($v)
                                mysql_query("insert into link_product_doc(doc_id,product_id) values($id,'$p')");
                }
                if ($prd_arts) {
                        $prodarts = explode(',', $prd_arts);
                        foreach($prodarts as $art) {
                                $art = trim($art);
                                if (list($sku) = mysql_fetch_array(mysql_query("select sku from products where sku='$art'")))
                                        if (!mysql_fetch_array(mysql_query("select id from link_product_doc where product_id=$sku and doc_id=$id")))
                                                mysql_query("insert into link_product_doc(doc_id,product_id) values($id,'$sku')");
                                }
                        }
                }

                if ($alert)
                        $alert = "alert('$alert');";

                echo "<body>
                                <SCRIPT LANGUAGE='JavaScript'>
                                <!--
                                $alert
                                //menu.document.location='menu.php';";
                if ($doc['type'] != 'NEW' and $doc['type'] != 'CATALOGITEM')
                        if ($name_)
                        echo "
                                        doc = parent.frames.menu.document.getElementById('doc_$id');
                                        if (doc)
                                        {
                                        	doc.innerHTML='".addslashes($name_)."';
                                        }
                                        //menu.all.doc_$id.innerHTML='$name_';";

                echo "
                        //document.location='view.php?action=showdoc&id=$id&page=$page';
                        //-->
                        </SCRIPT>
                        ";

		$link = "view.php?action=showdoc&id=$id&page=$page";
		echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0; URL=".$link."\">";
		//header("Location: ".$link."");
        }

?>
