-- 1.6.2

# phpMyAdmin MySQL-Dump
# version 2.5.1
# http://www.phpmyadmin.net/ (download page)
#
# Хост: localhost
# Время создания: Окт 20 2004 г., 14:57
# Версия сервера: 3.23.58
# Версия PHP: 4.3.3
# БД : `dmshop`
# --------------------------------------------------------

#
# Структура таблицы `engine_BINARYDOC`
#
# Creation: Сен 20 2004 г., 16:04
# Last update: Сен 20 2004 г., 16:04
#

CREATE TABLE `engine_BINARYDOC` (
  `doc_id` bigint(20) NOT NULL default '0',
  `ext` varchar(255) default NULL,
  PRIMARY KEY  (`doc_id`)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Структура таблицы `engine_CALC`
#
# Creation: Сен 20 2004 г., 16:04
# Last update: Сен 20 2004 г., 16:04
#

CREATE TABLE `engine_CALC` (
  `id` bigint(20) NOT NULL auto_increment,
  `doc_id` bigint(20) NOT NULL default '0',
  `text` longtext NOT NULL,
  `formula` longtext NOT NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=2 ;
# --------------------------------------------------------

#
# Структура таблицы `engine_CALC_param`
#
# Creation: Сен 20 2004 г., 16:04
# Last update: Сен 20 2004 г., 16:04
#

CREATE TABLE `engine_CALC_param` (
  `id` bigint(20) NOT NULL auto_increment,
  `calc` bigint(20) NOT NULL default '0',
  `name` longtext NOT NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=4 ;
# --------------------------------------------------------

#
# Структура таблицы `engine_CALC_vals`
#
# Creation: Сен 20 2004 г., 16:04
# Last update: Сен 20 2004 г., 16:04
#

CREATE TABLE `engine_CALC_vals` (
  `id` bigint(20) NOT NULL auto_increment,
  `param` bigint(20) NOT NULL default '0',
  `text` longtext NOT NULL,
  `val` double NOT NULL default '0',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=7 ;
# --------------------------------------------------------

#
# Структура таблицы `engine_CATALOG`
#
# Creation: Сен 20 2004 г., 16:04
# Last update: Сен 20 2004 г., 16:04
#

CREATE TABLE `engine_CATALOG` (
  `id` bigint(20) NOT NULL auto_increment,
  `doc_id` bigint(20) NOT NULL default '0',
  `full_format` longtext NOT NULL,
  `short_format` longtext NOT NULL,
  `icount` int(10) NOT NULL default '0',
  `prefix` longtext NOT NULL,
  `postfix` longtext NOT NULL,
  `short_format2` longtext NOT NULL,
  `filter` longtext NOT NULL,
  `email` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=28 ;
# --------------------------------------------------------

#
# Структура таблицы `engine_CATALOGITEM`
#
# Creation: Сен 20 2004 г., 16:04
# Last update: Сен 20 2004 г., 16:04
#

CREATE TABLE `engine_CATALOGITEM` (
  `id` bigint(20) NOT NULL auto_increment,
  `name` longtext NOT NULL,
  `catalog` bigint(20) NOT NULL default '0',
  `doc_id` bigint(20) NOT NULL default '0',
  `price` int(11) NOT NULL default '0',
  `ord` bigint(20) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=42 ;
# --------------------------------------------------------

#
# Структура таблицы `engine_CATALOG_param`
#
# Creation: Сен 20 2004 г., 16:04
# Last update: Сен 20 2004 г., 16:04
#

CREATE TABLE `engine_CATALOG_param` (
  `id` bigint(20) NOT NULL auto_increment,
  `catalog` bigint(20) NOT NULL default '0',
  `name` longtext NOT NULL,
  `select` tinyint(4) NOT NULL default '0',
  `multiselect` tinyint(4) NOT NULL default '0',
  `ms_format` longtext NOT NULL,
  `type` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=370 ;
# --------------------------------------------------------

#
# Структура таблицы `engine_CATALOG_possvals`
#
# Creation: Сен 20 2004 г., 16:04
# Last update: Сен 20 2004 г., 16:04
#

CREATE TABLE `engine_CATALOG_possvals` (
  `id` bigint(20) NOT NULL auto_increment,
  `val` longtext NOT NULL,
  `param` bigint(20) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=201 ;
# --------------------------------------------------------

#
# Структура таблицы `engine_CATALOG_values`
#
# Creation: Сен 20 2004 г., 16:04
# Last update: Сен 20 2004 г., 16:04
#

CREATE TABLE `engine_CATALOG_values` (
  `id` bigint(20) NOT NULL auto_increment,
  `param` bigint(20) NOT NULL default '0',
  `value` longtext NOT NULL,
  `poss_val_id` bigint(20) NOT NULL default '0',
  `item` bigint(20) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=1079 ;
# --------------------------------------------------------

#
# Структура таблицы `engine_CONSULTARY_quests`
#
# Creation: Сен 20 2004 г., 16:04
# Last update: Сен 20 2004 г., 16:04
#

CREATE TABLE `engine_CONSULTARY_quests` (
  `id` bigint(20) NOT NULL auto_increment,
  `doc_id` bigint(20) default NULL,
  `author` longtext,
  `question` longtext,
  `answer` longtext,
  `date` longtext,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Структура таблицы `engine_CONSULTARY`
#
# Creation: Окт 23 2006 г., 16:52
#

CREATE TABLE `engine_CONSULTARY` (
  `id` int(11) NOT NULL auto_increment,
  `doc_id` int(11) NOT NULL default '0',
  `cons_body` text NOT NULL,
  `cons_line` text NOT NULL,
  `cons_answer` varchar(255) NOT NULL default '',
  `cons_question` varchar(255) NOT NULL default '',
  `cons_on_page` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `doc_id` (`doc_id`)
) TYPE=MyISAM;

#
# Структура таблицы `engine_ELECT`
#
# Creation: Сен 20 2004 г., 16:04
# Last update: Сен 20 2004 г., 16:04
#

CREATE TABLE `engine_ELECT` (
  `doc_id` bigint(20) default NULL,
  `quest1` longtext,
  `quest1_n` int(11) NOT NULL default '0',
  `quest2` longtext,
  `quest2_n` int(11) NOT NULL default '0',
  `quest3` longtext,
  `quest3_n` int(11) NOT NULL default '0',
  `quest4` longtext,
  `quest4_n` int(11) NOT NULL default '0',
  `quest5` longtext,
  `quest5_n` int(11) NOT NULL default '0',
  `quest6` longtext,
  `quest6_n` int(11) NOT NULL default '0',
  `quest7` longtext,
  `quest7_n` int(11) NOT NULL default '0',
  `quest8` longtext,
  `quest8_n` int(11) NOT NULL default '0',
  `quest9` longtext,
  `quest9_n` int(11) NOT NULL default '0',
  `quest10` longtext,
  `quest10_n` int(11) NOT NULL default '0',
  `button` longtext NOT NULL,
  `msg` longtext NOT NULL,
  `question` longtext NOT NULL
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Структура таблицы `engine_FEEDBACK`
#
# Creation: Сен 20 2004 г., 16:04
# Last update: Сен 21 2004 г., 11:36
#

CREATE TABLE `engine_FEEDBACK` (
  `doc_id` bigint(20) default NULL,
  `text1` longtext,
  `text2` longtext,
  `btntext` longtext,
  `id` bigint(20) NOT NULL auto_increment,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=7 ;
# --------------------------------------------------------

#
# Структура таблицы `engine_FEEDBACK_questions`
#
# Creation: Сен 20 2004 г., 16:04
# Last update: Сен 20 2004 г., 16:04
#

CREATE TABLE `engine_FEEDBACK_questions` (
  `doc_id` bigint(20) default NULL,
  `author` longtext,
  `question` longtext,
  `answer` longtext,
  `date` longtext,
  `id` bigint(20) NOT NULL auto_increment,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;
# --------------------------------------------------------

#
# Структура таблицы `engine_FOLDER`
#
# Creation: Сен 20 2004 г., 16:04
# Last update: Окт 07 2004 г., 12:10
#

CREATE TABLE `engine_FOLDER` (
  `doc_id` bigint(20) NOT NULL default '0',
  `doctoshow` bigint(20) default NULL,
  `format` longtext,
  `notinpath` smallint(6) NOT NULL default '0',
  PRIMARY KEY  (`doc_id`)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Структура таблицы `engine_FORM`
#
# Creation: Сен 20 2004 г., 16:04
# Last update: Сен 30 2004 г., 11:45
#

CREATE TABLE `engine_FORM` (
  `doc_id` bigint(20) default NULL,
  `action` varchar(255) default NULL,
  `text` longblob,
  `email` varchar(255) default NULL,
  `button` varchar(255) default '   ОК',
  `send_email` tinyint(4) NOT NULL default '1',
  `send_URL` tinyint(4) NOT NULL default '0',
  `send_bd` tinyint(4) NOT NULL default '0',
  `bd` text NOT NULL,
  `send_reg` tinyint(4) NOT NULL default '0',
  `desc` text NOT NULL,
  `coding` char(2) NOT NULL default 'w',
  FULLTEXT KEY `bd` (`bd`)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Структура таблицы `engine_FORM_fields`
#
# Creation: Сен 20 2004 г., 16:04
# Last update: Сен 30 2004 г., 17:11
#

CREATE TABLE `engine_FORM_fields` (
  `id` bigint(20) NOT NULL auto_increment,
  `doc_id` bigint(20) default NULL,
  `field_name` longtext,
  `field_text` longtext,
  `field_caption` mediumtext,
  `field_ord` int(11) NOT NULL default '0',
  `option_list` tinytext,
  `field_bd_name` text NOT NULL,
  `required` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=1495 ;
# --------------------------------------------------------

#
# Структура таблицы `engine_HTMLDOC`
#
# Creation: Сен 20 2004 г., 16:04
# Last update: Сен 20 2004 г., 16:04
#

CREATE TABLE `engine_HTMLDOC` (
  `id` bigint(20) NOT NULL auto_increment,
  `html` longblob NOT NULL,
  `doc_id` bigint(20) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=7 ;
# --------------------------------------------------------

#
# Структура таблицы `engine_LINK`
#
# Creation: Сен 20 2004 г., 16:04
# Last update: Сен 20 2004 г., 16:04
#

CREATE TABLE `engine_LINK` (
  `doc_id` bigint(20) NOT NULL default '0',
  `linkid` bigint(20) NOT NULL default '0',
  `link_external` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`doc_id`)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Структура таблицы `engine_NEW`
#
# Creation: Сен 20 2004 г., 16:04
# Last update: Сен 20 2004 г., 16:04
#

CREATE TABLE `engine_NEW` (
  `id` bigint(20) NOT NULL auto_increment,
  `header` longtext,
  `text` longtext,
  `doc_id` bigint(20) default '0',
  `html` longtext,
  `new_date` datetime default NULL,
  `new_date_start` datetime default NULL,
  `new_date_end` datetime default NULL,
  `new_stick` tinyint(4) NOT NULL default '0', 
  `grpassign` bigint(20) NOT NULL default '-1',
  `usrassign` bigint(20) NOT NULL default '-1',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=40 ;
# --------------------------------------------------------

#
# Структура таблицы `engine_NEWSGROUP`
#
# Creation: Сен 20 2004 г., 16:04
# Last update: Сен 20 2004 г., 16:04
#

CREATE TABLE `engine_NEWSGROUP` (
  `id` bigint(20) NOT NULL auto_increment,
  `doc_id` bigint(20) default '0',
  `ncount` int(11) default '5',
  `format` text NOT NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=5 ;
# --------------------------------------------------------

#
# Структура таблицы `engine_PHOTOGALARY`
#
# Creation: Сен 20 2004 г., 16:04
# Last update: Сен 21 2004 г., 17:52
#

CREATE TABLE `engine_PHOTOGALARY` (
  `doc_id` bigint(20) NOT NULL default '0',
  `rows` int(11) NOT NULL default '50',
  `format` longtext NOT NULL,
  `cols` int(11) NOT NULL default '5',
  `nwnd` smallint(6) NOT NULL default '0'
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Структура таблицы `engine_PHOTOGALARY_cells`
#
# Creation: Сен 20 2004 г., 16:04
# Last update: Сен 21 2004 г., 17:59
#

CREATE TABLE `engine_PHOTOGALARY_cells` (
  `id` bigint(20) NOT NULL auto_increment,
  `text1` text NOT NULL,
  `text2` text NOT NULL,
  `text3` text NOT NULL,
  `gal_id` bigint(20) NOT NULL default '0',
  `ord` bigint(20) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=56 ;
# --------------------------------------------------------

#
# Структура таблицы `engine_TABLE`
#
# Creation: Сен 20 2004 г., 16:04
# Last update: Сен 20 2004 г., 16:04
#

CREATE TABLE `engine_TABLE` (
  `id` bigint(20) NOT NULL auto_increment,
  `doc_id` bigint(20) NOT NULL default '0',
  `tblname` varchar(255) NOT NULL default '',
  `begin` text NOT NULL,
  `format` text NOT NULL,
  `end` text NOT NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=4 ;
# --------------------------------------------------------

#
# Структура таблицы `engine_TABLEDOC`
#
# Creation: Сен 20 2004 г., 16:04
# Last update: Сен 20 2004 г., 16:04
#

CREATE TABLE `engine_TABLEDOC` (
  `doc_id` bigint(20) NOT NULL default '0',
  `rowsperpage` int(11) NOT NULL default '50'
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Структура таблицы `engine_TABLEDOC_cells`
#
# Creation: Сен 20 2004 г., 16:04
# Last update: Сен 20 2004 г., 16:04
#

CREATE TABLE `engine_TABLEDOC_cells` (
  `doc_id` bigint(20) NOT NULL default '0',
  `x` int(11) NOT NULL default '0',
  `y` int(11) NOT NULL default '0',
  `type` enum('Текст','Изображение') NOT NULL default 'Текст',
  `colspan` int(11) NOT NULL default '0',
  `rowspan` int(11) NOT NULL default '0',
  `value` longtext NOT NULL,
  `id` bigint(20) NOT NULL auto_increment,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=175 ;
# --------------------------------------------------------

#
# Структура таблицы `engine_TEXTDOC`
#
# Creation: Сен 20 2004 г., 16:04
# Last update: Окт 19 2004 г., 11:58
#

CREATE TABLE `engine_TEXTDOC` (
  `id` bigint(20) NOT NULL auto_increment,
  `html` longblob NOT NULL,
  `doc_id` bigint(20) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=1323 ;
# --------------------------------------------------------

#
# Структура таблицы `engine_conf`
#
# Creation: Сен 20 2004 г., 16:04
# Last update: Окт 20 2004 г., 14:20
#

CREATE TABLE `engine_conf` (
  `id` bigint(20) NOT NULL auto_increment,
  `varname` varchar(255) NOT NULL default '',
  `varvalue` longtext NOT NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=19 ;
# --------------------------------------------------------

#
# Структура таблицы `engine_docsinrubriques`
#
# Creation: Сен 20 2004 г., 16:04
# Last update: Окт 13 2004 г., 18:16
#


CREATE TABLE `engine_docsinrubriques` (
  `doc` bigint(20) NOT NULL default '0',
  `rub` bigint(20) NOT NULL default '0',
  `in` smallint(6) NOT NULL default '0',
  PRIMARY KEY  (`doc`,`rub`)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Структура таблицы `engine_documents`
#
# Creation: Сен 20 2004 г., 16:04
# Last update: Окт 20 2004 г., 13:59
#

CREATE TABLE `engine_documents` (
  `id` bigint(20) NOT NULL auto_increment,
  `name` longtext NOT NULL,
  `pid` bigint(20) NOT NULL default '-1',
  `caption_long` text NOT NULL,
  `caption_medium` text NOT NULL,
  `caption_short` text NOT NULL,
  `code` varchar(255) NOT NULL default '',
  `style` bigint(20) NOT NULL default '-1',
  `creation_date` datetime default NULL,
  `user` bigint(20) NOT NULL default '-1',
  `tpl` bigint(20) NOT NULL default '-1',
  `type` varchar(255) NOT NULL default 'TEXTDOC',
  `visible` tinyint(11) default '1',
  `ord` bigint(20) NOT NULL default '0',
  `private` tinyint(4) NOT NULL default '0',
  `undeletable` int(11) NOT NULL default '0',
  `META` text NOT NULL,
  `COUNTER1` text NOT NULL,
  `COUNTER2` text NOT NULL,
  `COUNTER3` text NOT NULL,
  `TITLE` text NOT NULL,
  `send` tinyint(4) NOT NULL default '0',
  `opener` bigint(20) NOT NULL default '0',
  `lastopen` datetime NOT NULL default '0000-00-00 00:00:00',
  `lastchange` datetime NOT NULL default '0000-00-00 00:00:00',
  `opened` smallint(6) NOT NULL default '0',
  `resume` longtext NOT NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Структура таблицы `engine_forum`
#
# Creation: Сен 20 2004 г., 16:04
# Last update: Сен 30 2004 г., 11:21
#

CREATE TABLE `engine_forum` (
  `id` bigint(20) NOT NULL auto_increment,
  `moderator_gr` bigint(20) NOT NULL default '0',
  `descr` longtext NOT NULL,
  `answer_frmt1` longtext NOT NULL,
  `answer_frmt2` longtext NOT NULL,
  `topic_frmt` longtext NOT NULL,
  `name` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=7 ;
# --------------------------------------------------------

#
# Структура таблицы `engine_forum_msg`
#
# Creation: Сен 20 2004 г., 16:04
# Last update: Сен 30 2004 г., 12:51
#

CREATE TABLE `engine_forum_msg` (
  `id` bigint(20) NOT NULL auto_increment,
  `author` varchar(255) default NULL,
  `user` bigint(20) default '-1',
  `date` datetime NOT NULL default '0000-00-00 00:00:00',
  `pid` bigint(20) default '-1',
  `forum` tinyint(4) NOT NULL default '0',
  `text` longtext,
  `topic` text,
  `email` varchar(255) NOT NULL default '',
  `rub` bigint(20) NOT NULL default '0',
  `doc` bigint(20) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM PACK_KEYS=0 AUTO_INCREMENT=195 ;
# --------------------------------------------------------

#
# Структура таблицы `engine_group_rights`
#
# Creation: Сен 27 2004 г., 17:09
# Last update: Сен 27 2004 г., 17:09
#

CREATE TABLE `engine_group_rights` (
  `ugroup` bigint(20) NOT NULL default '0',
  `granted` bigint(20) NOT NULL default '0',
  `document` bigint(20) NOT NULL default '0',
  `edit` tinyint(4) NOT NULL default '0',
  `publicate` tinyint(4) NOT NULL default '0'
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Структура таблицы `engine_groups`
#
# Creation: Сен 20 2004 г., 16:04
# Last update: Сен 20 2004 г., 16:04
#

CREATE TABLE `engine_groups` (
  `id` bigint(20) NOT NULL auto_increment,
  `name` text NOT NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Структура таблицы `engine_log`
#
# Creation: Сен 20 2004 г., 16:04
# Last update: Окт 19 2004 г., 11:58
#

CREATE TABLE `engine_log` (
  `id` bigint(20) NOT NULL auto_increment,
  `log_date` datetime default NULL,
  `user` bigint(20) NOT NULL default '0',
  `text` longtext NOT NULL,
  `document` bigint(20) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=2460 ;
# --------------------------------------------------------

#
# Структура таблицы `engine_objects`
#
# Creation: Сен 20 2004 г., 16:04
# Last update: Сен 20 2004 г., 16:04
#

CREATE TABLE `engine_objects` (
  `id` bigint(20) NOT NULL auto_increment,
  `doc` bigint(20) NOT NULL default '-1',
  `type` varchar(255) NOT NULL default '',
  `name` varchar(255) NOT NULL default '',
  `par1` longtext NOT NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;
# --------------------------------------------------------

#
# Структура таблицы `engine_rubric`
#
# Creation: Сен 20 2004 г., 16:04
# Last update: Сен 20 2004 г., 16:04
#

CREATE TABLE `engine_rubric` (
  `id` bigint(20) NOT NULL auto_increment,
  `name` text NOT NULL,
  `pid` bigint(20) NOT NULL default '-1',
  `tplrub` bigint(20) NOT NULL default '-1',
  `tpldoc` bigint(20) NOT NULL default '-1',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;
# --------------------------------------------------------

#
# Структура таблицы `engine_rubrique`
#
# Creation: Сен 20 2004 г., 16:04
# Last update: Сен 27 2004 г., 13:44
#

CREATE TABLE `engine_rubrique` (
  `id` bigint(20) NOT NULL auto_increment,
  `pid` bigint(20) NOT NULL default '0',
  `name` longtext NOT NULL,
  `ic` char(1) NOT NULL default 'N',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=51 ;
# --------------------------------------------------------

#
# Структура таблицы `engine_send`
#
# Creation: Сен 20 2004 г., 16:04
# Last update: Сен 20 2004 г., 16:04
#

CREATE TABLE `engine_send` (
  `id` bigint(20) NOT NULL auto_increment,
  `name` longtext NOT NULL,
  `doc_id` bigint(20) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=6 ;
# --------------------------------------------------------

#
# Структура таблицы `engine_send_emails`
#
# Creation: Сен 20 2004 г., 16:04
# Last update: Сен 20 2004 г., 16:04
#

CREATE TABLE `engine_send_emails` (
  `id` bigint(20) NOT NULL auto_increment,
  `email` text NOT NULL,
  `send_id` bigint(20) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=25 ;
# --------------------------------------------------------

--
-- Table structure for table `engine_stat_hit`
--

CREATE TABLE `engine_stat_hit` (
  `id` int(11) NOT NULL auto_increment,
  `prev_id` int(11) default NULL,
  `dt` timestamp(14) NOT NULL,
  `sess_id` varchar(32) default NULL,
  `user_id` int(11) default NULL,
  `doc_id` int(11) default NULL,
  `prod_id` int(11) default NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;

--
-- Table structure for table `engine_stat_referer`
--

CREATE TABLE `engine_stat_referer` (
  `sess_id` varchar(32) NOT NULL default '',
  `ic_sess_id` varchar(32) default NULL,
  `dt` timestamp(14) NOT NULL,
  `referer` text,
  PRIMARY KEY  (`sess_id`)
) TYPE=MyISAM;

--
-- Table structure for table `engine_stat_search`
--

CREATE TABLE `engine_stat_search` (
  `id` int(11) NOT NULL auto_increment,
  `dt` timestamp(14) NOT NULL,
  `stype` char(1) default NULL,
  `query` varchar(255) default NULL,
  `found` int(11) default NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;

#
# Структура таблицы `engine_styles`
#
# Creation: Сен 20 2004 г., 16:04
# Last update: Сен 20 2004 г., 16:04
#

CREATE TABLE `engine_styles` (
  `id` bigint(20) NOT NULL auto_increment,
  `name` text NOT NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Структура таблицы `engine_tpl`
#
# Creation: Сен 20 2004 г., 16:04
# Last update: Окт 20 2004 г., 14:13
#

CREATE TABLE `engine_tpl` (
  `id` bigint(20) NOT NULL auto_increment,
  `name` longtext NOT NULL,
  `body` longtext NOT NULL,
  `type` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Структура таблицы `engine_user_rights`
#
# Creation: Сен 20 2004 г., 16:04
# Last update: Сен 20 2004 г., 16:04
#

CREATE TABLE `engine_user_rights` (
  `id` bigint(20) NOT NULL auto_increment,
  `user` bigint(20) NOT NULL default '0',
  `granted` bigint(20) NOT NULL default '0',
  `document` bigint(20) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;
# --------------------------------------------------------

#
# Структура таблицы `engine_users`
#
# Creation: Сен 27 2004 г., 17:09
# Last update: Окт 07 2004 г., 00:20
# Last check: Сен 27 2004 г., 17:09
#

CREATE TABLE `engine_users` (
  `id` bigint(20) NOT NULL auto_increment,
  `login` varchar(16) NOT NULL default '',
  `pass` varchar(20) NOT NULL default '',
  `acl` text,
  `mod_time` timestamp(14) NOT NULL,
  `s_nickname` text,
  `company` varchar(30) default NULL,
  `fname` varchar(30) default NULL,
  `lname` varchar(30) default NULL,
  `address1` varchar(64) default NULL,
  `address2` varchar(64) default NULL,
  `address3` varchar(64) default NULL,
  `city` varchar(30) default NULL,
  `state` varchar(10) default NULL,
  `zip` varchar(10) default NULL,
  `country` varchar(10) default NULL,
  `phone_day` varchar(20) default NULL,
  `mv_shipmode` varchar(255) default NULL,
  `b_nickname` text,
  `b_fname` varchar(30) default NULL,
  `b_lname` varchar(30) default NULL,
  `b_address1` varchar(64) default NULL,
  `b_address2` varchar(64) default NULL,
  `b_address3` varchar(64) default NULL,
  `b_city` varchar(30) default NULL,
  `b_state` varchar(10) default NULL,
  `b_zip` varchar(10) default NULL,
  `b_country` varchar(10) default NULL,
  `b_phone` varchar(20) default NULL,
  `mv_credit_card_type` varchar(16) default NULL,
  `mv_credit_card_exp_month` char(2) default NULL,
  `mv_credit_card_exp_year` varchar(4) default NULL,
  `p_nickname` text,
  `email` varchar(128) default NULL,
  `fax` varchar(20) default NULL,
  `phone_night` varchar(20) default NULL,
  `fax_order` char(2) default NULL,
  `address_book` blob,
  `accounts` blob,
  `preferences` blob,
  `carts` blob,
  `owner` varchar(20) default NULL,
  `file_acl` blob,
  `db_acl` blob,
  `order_numbers` text,
  `email_copy` char(1) default NULL,
  `mail_list` varchar(64) default NULL,
  `project_id` varchar(20) default NULL,
  `account_id` varchar(20) default NULL,
  `order_dest` varchar(32) default NULL,
  `credit_limit` varchar(255) default NULL,
  `inactive` varchar(255) default NULL,
  `dealer` varchar(32) default NULL,
  `b_company` varchar(255) default NULL,
  `price_level` varchar(255) default NULL,
  `credit_balance` decimal(12,2) default NULL,
  `info` longtext,
  `name` longtext,
  `ugroup` bigint(20) NOT NULL default '0',
  `mname` text NOT NULL,
  `firm` text NOT NULL,
  `phone` text NOT NULL,
  `role` enum('Гость','Автор','Редактор','Разработчик','Администратор') NOT NULL default 'Гость',
  `active` smallint(6) NOT NULL default '1',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `login` (`login`)
) TYPE=MyISAM;


#------------------------------------#
#         Настройки по умолчанию     #
#------------------------------------#
INSERT INTO `engine_conf` (`id`, `varname`, `varvalue`) VALUES (1, 'defdoc', '-1');
INSERT INTO `engine_conf` (`id`, `varname`, `varvalue`) VALUES (2, 'deftpl', '-1');
INSERT INTO `engine_conf` (`id`, `varname`, `varvalue`) VALUES (3, 'def_counter1', '');
INSERT INTO `engine_conf` (`id`, `varname`, `varvalue`) VALUES (4, 'def_counter2', '');
INSERT INTO `engine_conf` (`id`, `varname`, `varvalue`) VALUES (5, 'def_counter3', '');
INSERT INTO `engine_conf` (`id`, `varname`, `varvalue`) VALUES (6, 'def_title', 'title');
INSERT INTO `engine_conf` (`id`, `varname`, `varvalue`) VALUES (7, 'def_meta', '');
INSERT INTO `engine_conf` (`id`, `varname`, `varvalue`) VALUES (8, 'dflt_menu_format', '<li><a href="ITEM_LINK">ITEM_TEXT</a></li>');
INSERT INTO `engine_conf` (`id`, `varname`, `varvalue`) VALUES (9, 'regform_group', '2');
INSERT INTO `engine_conf` (`id`, `varname`, `varvalue`) VALUES (10, 'regform_prefix', '');
INSERT INTO `engine_conf` (`id`, `varname`, `varvalue`) VALUES (11, 'regform_postfix', '');
INSERT INTO `engine_conf` (`id`, `varname`, `varvalue`) VALUES (12, 'version', '1.6.2.2');

#------------------------------------#
#         Группы и пользователи      #
#------------------------------------#


INSERT INTO `engine_groups` (`name`) VALUES ('belti');
INSERT INTO `engine_groups` (`name`) VALUES ('Зарегистрированные посетители');

INSERT INTO `engine_users` (`login`, `pass`, `name`, `ugroup`, `mname`, `lname`, `firm`, `phone`, `email`, `role`, `active`) VALUES ('serge', 'seBeLtI', 'Сергей', 1, '', '', '', '', '', 'Администратор', 1);
INSERT INTO `engine_users` (`login`, `pass`, `name`, `ugroup`, `mname`, `lname`, `firm`, `phone`, `email`, `role`, `active`) VALUES ('serged', 'seBeLtI', 'Сергей', 1, '', '', '', '', '', 'Разработчик', 1);
INSERT INTO `engine_users` (`login`, `pass`, `name`, `ugroup`, `mname`, `lname`, `firm`, `phone`, `email`, `role`, `active`) VALUES ('shramkova', 'eWy_38', 'Анна', 1, '', '', '', '', '', 'Разработчик', 1);
INSERT INTO `engine_users` (`login`, `pass`, `name`, `ugroup`, `mname`, `lname`, `firm`, `phone`, `email`, `role`, `active`) VALUES ('tuchkova', 'eWy_38', 'Анна', 1, '', '', '', '', '', 'Администратор', 1);
INSERT INTO `engine_users` (`login`, `pass`, `name`, `ugroup`, `mname`, `lname`, `firm`, `phone`, `email`, `role`, `active`) VALUES ('sveta', 'svBeLtI', 'Светлана', 1, '', '', '', '', '', 'Администратор', 1);
INSERT INTO `engine_users` (`login`, `pass`, `name`, `ugroup`, `mname`, `lname`, `firm`, `phone`, `email`, `role`, `active`) VALUES ('sst', 'd2c432262c68fa3a0219', 'Сергей', 1, '', '', '', '', '', 'Разработчик', 1);
INSERT INTO `engine_users` (`login`, `pass`, `name`, `ugroup`, `mname`, `lname`, `firm`, `phone`, `email`, `role`, `active`) VALUES ('kateri', 'KaBeLtI', 'Катя', 1, '', '', '', '', '', 'Редактор', 1);
INSERT INTO `engine_users` (`login`, `pass`, `name`, `ugroup`, `mname`, `lname`, `firm`, `phone`, `email`, `role`, `active`) VALUES ('ereih', 'damnedest', 'Евгений', 1, 'Владимирович', 'Рейх', '', '', 'ereih@belti.ru', 'Разработчик', 1);
INSERT INTO `engine_users` (`login`, `pass`, `name`, `ugroup`, `mname`, `lname`, `firm`, `phone`, `email`, `role`, `active`) VALUES ('ast', '111111', 'Александра', 1, '', '', '', '', 'ast@belti.ru', 'Администратор', 1);
INSERT INTO `engine_users` (`login`, `pass`, `name`, `ugroup`, `mname`, `lname`, `firm`, `phone`, `email`, `role`, `active`) VALUES ('astdev', 'astdev', 'Александра', 1, '', '', '', '', 'ast@belti.ru', 'Разработчик', 1);
INSERT INTO `engine_users` (`login`, `pass`, `name`, `ugroup`, `mname`, `lname`, `firm`, `phone`, `email`, `role`, `active`) VALUES ('mlavrenovdev', 'mlavrenovdev', 'Максим', 1, '', '', '', '', '', 'Разработчик', 1);
INSERT INTO `engine_users` (`login`, `pass`, `name`, `ugroup`, `mname`, `lname`, `firm`, `phone`, `email`, `role`, `active`) VALUES ('vadimbond', 'ab1231', 'Vadim', 1, '', '', '', '', '', 'Разработчик', 1);

#------------------------------------#
#         Индексы                    #
#------------------------------------#

create index engine_idx_documents_pid on engine_documents (pid);
create index engine_idx_documents_name on engine_documents (name(10));
create index engine_idx_documents_creation_date on engine_documents (creation_date);
create index engine_idx_documents_opener on engine_documents (opener);
create index engine_idx_documents_ord on engine_documents (ord);

create index engine_idx_catalog_item_doc_id on engine_CATALOGITEM (doc_id);
create index engine_idx_catalog_item_name on engine_CATALOGITEM (name(10));

create index engine_idx_CATALOG_doc_id on engine_CATALOG (doc_id);

create index engine_idx_NEW_doc_id on engine_NEW (doc_id);
create index engine_idx_NEW_grpassign on engine_NEW (grpassign);
create index engine_idx_NEW_usrassign on engine_NEW (usrassign);

create index engine_idx_group_rights_ugroup on engine_group_rights (ugroup);
create index engine_idx_group_rights_document on engine_group_rights (document);
create index engine_idx_group_rights_granted on engine_group_rights (granted);

create index engine_idx_rubrique_pid on engine_rubrique (pid);

create index engine_idx_log_user on engine_log (user);
create index engine_idx_log_document on engine_log (document);
create index engine_idx_log_log_date on engine_log (log_date);