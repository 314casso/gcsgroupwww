<?php

/*
 * @Descr Вывод постраничного навигатора
 *  $Id: _nav_page.inc,v 1.3 2005/01/25 22:44:30 dave Exp $
 *
 *  $Log: _nav_page.inc,v $
 *  Revision 1.3  2005/01/25 22:44:30  dave
 *  Размер страницы по умолчанию установлен в 20 строк
 *
 *  Revision 1.2  2004/12/28 16:29:37  dave
 *  Реализована возможность раздельного подсчета и вывода
 *
 *  Revision 1.1  2004/12/28 00:06:52  dave
 *  Создан
 *
 */

// Определение размера страницы по умолчанию
if (!defined ('ENGINE_LIST_PAGESIZE'))
	define ('ENGINE_LIST_PAGESIZE', 20);

if (!defined ('ENGINE_LIST_PAGENUM_MIDDLE'))
	define ('ENGINE_LIST_PAGENUM_MIDDLE', 10);

$page_num = intval (($cnt + ENGINE_LIST_PAGESIZE - 1) / ENGINE_LIST_PAGESIZE);
@logd("page_num: $page_num");

if ($page_num >= 1) {
	// Выводить листалку только если число страниц >= 1
	if ($cnt > $page + ENGINE_LIST_PAGESIZE)
		$pgsF = "<strong><a href='$href&page=".($page + ENGINE_LIST_PAGESIZE)."'>Вперед</a></strong>";
	if ($page > 0 && $cnt > ENGINE_LIST_PAGESIZE)
		$pgsB = "<strong><a href='$href&page=".($page - ENGINE_LIST_PAGESIZE)."'>Назад</a></strong>";
	if ($page_num >= 2) {
		// Выводить постраничный навигатор если число страниц >= 2
		$pgsM = '';
		for ($i = 0; $i < $page_num; $i++) {
			for ($i = 0; $i < $page_num; $i++) {
				if ($i == intval (($page + ENGINE_LIST_PAGESIZE - 1) / ENGINE_LIST_PAGESIZE)) {
					$pgsM .= ' <strong>'.($i + 1).'</strong> ';
				} else {
					$pgsM .= " <strong><a href=$href&page=".$i * ENGINE_LIST_PAGESIZE."'>".($i + 1)."</a></strong> ";
				}
				$i_new = 0;
				if ($i == 2) {
					$i_new = ($page_num > ENGINE_LIST_PAGENUM_MIDDLE) ? (intval ($page_num / 2) - 3 < 0 ? $i : intval ($page_num / 2) - 3) : ($page_num - 4 < $i ? 0 : $page_num - 4);
				} elseif ($page_num > ENGINE_LIST_PAGENUM_MIDDLE && $i == intval ($page_num / 2)) {
					$i_new = $page_num - 4 < 0 ? $i : $page_num - 4;
				}
				if ($i_new > $i) {
					$i = $i_new;
					$pgsM .= ' ... ';
				}
			}
		}
	}
	$_nav_page = $pgsB.($pgsB != '' && ($pgsM != '' || $pgsF != '') ? ' | ' : '').$pgsM.($pgsF != '' && ($pgsM != '' || $pgsB != '') ? ' | ' : '').$pgsF;
    $limit = ' limit '.intval($page).','.intval(ENGINE_LIST_PAGESIZE);
}

?>