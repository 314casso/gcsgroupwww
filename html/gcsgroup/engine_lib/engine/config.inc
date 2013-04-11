<?php

/*
 * @Descr Конфигурирование
 *  $Id: config.inc,v 1.12 2006/06/15 10:02:28 ereih Exp $
 *
 *  $Log: config.inc,v $
 *  Revision 1.12  2006/06/15 10:02:28  ereih
 *  Редизайн и улучшение функционала
 *
 *  Revision 1.10  2004/12/26 11:47:27  dave
 *  Переформатирование кода
 *
 *  Revision 1.9  2004/12/25 15:31:05  dave
 *  Добавлена константа вывода середины листалки в консультарии
 *
 *  Revision 1.8  2004/12/25 15:09:31  dave
 *  Добавлена константа числа записей в консультарии на страницу.
 *
 *  Revision 1.7  2004/12/14 21:17:39  dave
 *  Запрет вывода номера версии, если ENGINE_VERSION не определено (нет version.inc)
 *
 *  Revision 1.6  2004/12/14 20:46:36  dave
 *  Поддержка вывода номера версии
 *
 */

if (!preg_match("|yandex|Usi", $_SERVER["HTTP_USER_AGENT"])) {
	 ini_set('session.cache_expire','480');
        @session_start();
        @session_register("engine_htroot");
        @session_register("engine_root");
        @session_register("engine_show_htroot");
        @session_register("engine_show_root");

        @session_register("db_host");
        @session_register("db_user");
        @session_register("db_pass");
        @session_register("db_name");
}

@include_once ('version.inc');

if (!defined ('ENGINE_CONSULTARY_PAGESIZE'))
        define ('ENGINE_CONSULTARY_PAGESIZE', 5);

if (!defined ('ENGINE_CONSULTARY_PAGENUM_MIDDLE'))
        define ('ENGINE_CONSULTARY_PAGENUM_MIDDLE', 10);

$db = mysql_connect($db_host, $db_user, $db_pass)
or die("Unable to connect to sql server\n");
mysql_select_db($db_name, $db) or die("<script>alert('Unable to select database')</script> <script>window.parent.parent.document.location=\"/engine/engine.php?logout=1%26err=2\";</script>");



$sql = "select * from engine_conf ";
$r = mysql_query($sql);

while ($f = mysql_fetch_array($r)) {
        $$f[varname] = $f[varvalue];
}

@include("$engine_show_root/engine/localconf.inc");

if (!defined ('ENGINE_PHOTOGALARY_W'))
        define ('ENGINE_PHOTOGALARY_W', 120);

if (!defined ('ENGINE_PHOTOGALARY_H'))
        define ('ENGINE_PHOTOGALARY_H', 120);

include_once 'document.inc';
// проверка наличия таблицы и всех файлов типа документа
function testdoc_type($doctype)
{
        global $engine_root;
        $sql = "select * from engine_" . $doctype . " limit 1 ";
        $parent_doc_spec = @mysql_fetch_array(mysql_query($sql));
        if ((!mysql_error() || $doctype != "table") &&
                        file_exists("$engine_root/engine/doc_types/" . $doctype . "/edit.tpl") &&
                        file_exists("$engine_root/engine/doc_types/{$doctype}/edit.php") &&
                        file_exists("$engine_root/engine/doc_types/{$doctype}/proc.php") &&
                        file_exists("$engine_root/engine/doc_types/{$doctype}/body.php")
                        ) {
                return true;
        } else
                return false;
        echo $doctype . "";
}
// определение прав пользователя на докмент
function getrights($doc)
{
        global $logged;
        $sql = "select * from engine_group_rights where `ugroup`=$logged[ugroup] and document=$doc";

        $f = @mysql_fetch_array(mysql_query("$sql"));
        while (!$f[granted] and $doc != -1) {
                $d = new Document($doc);
                $doc = $d->pid;
                $sql = "select * from engine_group_rights where `ugroup`=$logged[ugroup] and document=$doc";
                $f = mysql_fetch_array(mysql_query("$sql"));
        }

        if ($doc != -1)
                return $f[granted];
        else
                return 1;
}

$admin = 1;

?>