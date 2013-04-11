<?php

/*
 * @Descr Выбор диапазона дат
 *  $Id: _nav_date.inc,v 1.2 2004/12/28 16:29:37 dave Exp $
 *
 *  $Log: _nav_date.inc,v $
 *  Revision 1.2  2004/12/28 16:29:37  dave
 *  Реализована возможность раздельного подсчета и вывода
 *
 *  Revision 1.1  2004/12/28 00:06:52  dave
 *  Создан
 *
 */

if ($from_day == '' && $from_month == '' && $from_year == '') {
    $from_day = date ("d");
    $from_month = date ("m");
    $from_year = date ("Y");
}
if ($to_day == '' && $to_month == '' && $to_year == '') {
    $to_day = date ("d");
    $to_month = date ("m");
    $to_year = date ("Y");
}

$from_ts = db_create_timestamp(0 + mktime(0, 0, 0, $from_month, $from_day, $from_year));
$to_ts = db_create_timestamp(mktime(0, 0, 0, $to_month, $to_day, $to_year) + 3600 * 24);

if ($from_ts != '')
    $where .= ($where == '' ? 'where' : ' and')." dt >= '$from_ts'";
if ($to_ts != '')
    $where .= ($where == '' ? 'where' : ' and')." dt <= '$to_ts'";

$href .= "from_day=$from_day&from_month=$from_month&from_year=$from_year&to_day=$to_day&to_month=$to_month&to_year=$to_year";
$_nav_date = "
    Дата начала: <input name=from_day size=2 maxlength=2 value=".$from_day.">
    <input name=from_month size=2 maxlength=2 value=".$from_month.">
    <input name=from_year size=4 maxlength=4 value=".$from_year.">

    Дата окончания: <input name=to_day size=2 maxlength=2 value=".$to_day.">
    <input name=to_month size=2 maxlength=2 value=".$to_month.">
    <input name=to_year size=4 maxlength=4 value=".$to_year.">
";