-- MySQL dump 9.11
--
-- Host: localhost    Database: db_gcs_group
-- ------------------------------------------------------
-- Server version	4.0.27

--
-- Table structure for table `engine_BINARYDOC`
--

DROP TABLE IF EXISTS `engine_BINARYDOC`;
CREATE TABLE `engine_BINARYDOC` (
  `doc_id` bigint(20) NOT NULL default '0',
  `ext` varchar(255) default NULL,
  PRIMARY KEY  (`doc_id`)
) TYPE=MyISAM;

--
-- Dumping data for table `engine_BINARYDOC`
--


--
-- Table structure for table `engine_CALC`
--

DROP TABLE IF EXISTS `engine_CALC`;
CREATE TABLE `engine_CALC` (
  `id` bigint(20) NOT NULL auto_increment,
  `doc_id` bigint(20) NOT NULL default '0',
  `text` longtext NOT NULL,
  `formula` longtext NOT NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;

--
-- Dumping data for table `engine_CALC`
--


--
-- Table structure for table `engine_CALC_param`
--

DROP TABLE IF EXISTS `engine_CALC_param`;
CREATE TABLE `engine_CALC_param` (
  `id` bigint(20) NOT NULL auto_increment,
  `calc` bigint(20) NOT NULL default '0',
  `name` longtext NOT NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;

--
-- Dumping data for table `engine_CALC_param`
--


--
-- Table structure for table `engine_CALC_vals`
--

DROP TABLE IF EXISTS `engine_CALC_vals`;
CREATE TABLE `engine_CALC_vals` (
  `id` bigint(20) NOT NULL auto_increment,
  `param` bigint(20) NOT NULL default '0',
  `text` longtext NOT NULL,
  `val` double NOT NULL default '0',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;

--
-- Dumping data for table `engine_CALC_vals`
--


--
-- Table structure for table `engine_CATALOG`
--

DROP TABLE IF EXISTS `engine_CATALOG`;
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
  PRIMARY KEY  (`id`),
  KEY `engine_idx_CATALOG_doc_id` (`doc_id`)
) TYPE=MyISAM;

--
-- Dumping data for table `engine_CATALOG`
--


--
-- Table structure for table `engine_CATALOGITEM`
--

DROP TABLE IF EXISTS `engine_CATALOGITEM`;
CREATE TABLE `engine_CATALOGITEM` (
  `id` bigint(20) NOT NULL auto_increment,
  `name` longtext NOT NULL,
  `catalog` bigint(20) NOT NULL default '0',
  `doc_id` bigint(20) NOT NULL default '0',
  `price` int(11) NOT NULL default '0',
  `ord` bigint(20) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `engine_idx_catalog_item_doc_id` (`doc_id`),
  KEY `engine_idx_catalog_item_name` (`name`(10))
) TYPE=MyISAM;

--
-- Dumping data for table `engine_CATALOGITEM`
--


--
-- Table structure for table `engine_CATALOG_param`
--

DROP TABLE IF EXISTS `engine_CATALOG_param`;
CREATE TABLE `engine_CATALOG_param` (
  `id` bigint(20) NOT NULL auto_increment,
  `catalog` bigint(20) NOT NULL default '0',
  `name` longtext NOT NULL,
  `select` tinyint(4) NOT NULL default '0',
  `multiselect` tinyint(4) NOT NULL default '0',
  `ms_format` longtext NOT NULL,
  `type` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;

--
-- Dumping data for table `engine_CATALOG_param`
--


--
-- Table structure for table `engine_CATALOG_possvals`
--

DROP TABLE IF EXISTS `engine_CATALOG_possvals`;
CREATE TABLE `engine_CATALOG_possvals` (
  `id` bigint(20) NOT NULL auto_increment,
  `val` longtext NOT NULL,
  `param` bigint(20) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;

--
-- Dumping data for table `engine_CATALOG_possvals`
--


--
-- Table structure for table `engine_CATALOG_values`
--

DROP TABLE IF EXISTS `engine_CATALOG_values`;
CREATE TABLE `engine_CATALOG_values` (
  `id` bigint(20) NOT NULL auto_increment,
  `param` bigint(20) NOT NULL default '0',
  `value` longtext NOT NULL,
  `poss_val_id` bigint(20) NOT NULL default '0',
  `item` bigint(20) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;

--
-- Dumping data for table `engine_CATALOG_values`
--


--
-- Table structure for table `engine_CONSULTARY`
--

DROP TABLE IF EXISTS `engine_CONSULTARY`;
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

--
-- Dumping data for table `engine_CONSULTARY`
--


--
-- Table structure for table `engine_CONSULTARY_quests`
--

DROP TABLE IF EXISTS `engine_CONSULTARY_quests`;
CREATE TABLE `engine_CONSULTARY_quests` (
  `id` bigint(20) NOT NULL auto_increment,
  `doc_id` bigint(20) default NULL,
  `author` longtext,
  `question` longtext,
  `answer` longtext,
  `date` longtext,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;

--
-- Dumping data for table `engine_CONSULTARY_quests`
--


--
-- Table structure for table `engine_ELECT`
--

DROP TABLE IF EXISTS `engine_ELECT`;
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

--
-- Dumping data for table `engine_ELECT`
--


--
-- Table structure for table `engine_FEEDBACK`
--

DROP TABLE IF EXISTS `engine_FEEDBACK`;
CREATE TABLE `engine_FEEDBACK` (
  `doc_id` bigint(20) default NULL,
  `text1` longtext,
  `text2` longtext,
  `btntext` longtext,
  `id` bigint(20) NOT NULL auto_increment,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;

--
-- Dumping data for table `engine_FEEDBACK`
--


--
-- Table structure for table `engine_FEEDBACK_questions`
--

DROP TABLE IF EXISTS `engine_FEEDBACK_questions`;
CREATE TABLE `engine_FEEDBACK_questions` (
  `doc_id` bigint(20) default NULL,
  `author` longtext,
  `question` longtext,
  `answer` longtext,
  `date` longtext,
  `id` bigint(20) NOT NULL auto_increment,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;

--
-- Dumping data for table `engine_FEEDBACK_questions`
--


--
-- Table structure for table `engine_FOLDER`
--

DROP TABLE IF EXISTS `engine_FOLDER`;
CREATE TABLE `engine_FOLDER` (
  `doc_id` bigint(20) NOT NULL default '0',
  `doctoshow` bigint(20) default NULL,
  `format` longtext,
  `notinpath` smallint(6) NOT NULL default '0',
  PRIMARY KEY  (`doc_id`)
) TYPE=MyISAM;

--
-- Dumping data for table `engine_FOLDER`
--

INSERT INTO `engine_FOLDER` VALUES (1,32,'format=\'<li><a href=\"ITEM_LINK\">ITEM_TEXT</a></li>\'',0);
INSERT INTO `engine_FOLDER` VALUES (3,39,'format=\'<li><a href=\"ITEM_LINK\">ITEM_TEXT</a></li>\'',0);
INSERT INTO `engine_FOLDER` VALUES (5,6,'format=\'<li><a href=\"ITEM_LINK\">ITEM_TEXT</a></li>\'',0);
INSERT INTO `engine_FOLDER` VALUES (7,8,'format=\'<li><a href=\"ITEM_LINK\">ITEM_TEXT</a></li>\'',0);
INSERT INTO `engine_FOLDER` VALUES (9,10,'format=\'<li><a href=\"ITEM_LINK\">ITEM_TEXT</a></li>\'',0);
INSERT INTO `engine_FOLDER` VALUES (11,12,'format=\'<li><a href=\"ITEM_LINK\">ITEM_TEXT</a></li>\'',0);
INSERT INTO `engine_FOLDER` VALUES (19,-1,'format=\'<li><a href=\"ITEM_LINK\">ITEM_TEXT</a></li>\'',0);
INSERT INTO `engine_FOLDER` VALUES (13,14,'format=\'<li><a href=\"ITEM_LINK\">ITEM_TEXT</a></li>\'',0);
INSERT INTO `engine_FOLDER` VALUES (24,71,'format=\'<li><a href=\"ITEM_LINK\">ITEM_TEXT</a></li>\'',0);
INSERT INTO `engine_FOLDER` VALUES (23,69,'format=\'<li><a href=\"ITEM_LINK\">ITEM_TEXT</a></li>\'',0);
INSERT INTO `engine_FOLDER` VALUES (26,27,'format=\'<li><a href=\"ITEM_LINK\">ITEM_TEXT</a></li>\'',0);
INSERT INTO `engine_FOLDER` VALUES (25,73,'format=\'<li><a href=\"ITEM_LINK\">ITEM_TEXT</a></li>\'',0);
INSERT INTO `engine_FOLDER` VALUES (30,-1,'format=\'<li><a href=\"ITEM_LINK\">ITEM_TEXT</a></li>\'',0);
INSERT INTO `engine_FOLDER` VALUES (45,46,'format=\'<li><a href=\"ITEM_LINK\">ITEM_TEXT</a></li>\'',0);
INSERT INTO `engine_FOLDER` VALUES (52,53,'format=\'<li><a href=\"ITEM_LINK\">ITEM_TEXT</a></li>\'',0);
INSERT INTO `engine_FOLDER` VALUES (58,59,'format=\'<li><a href=\"ITEM_LINK\">ITEM_TEXT</a></li>\'',0);
INSERT INTO `engine_FOLDER` VALUES (63,-1,'format=\'<li><a href=\"ITEM_LINK\">ITEM_TEXT</a></li>\'',0);
INSERT INTO `engine_FOLDER` VALUES (66,17,'format=\'<li><a href=\"ITEM_LINK\">ITEM_TEXT</a></li>\'',1);
INSERT INTO `engine_FOLDER` VALUES (67,43,'format=\'<li><a href=\"ITEM_LINK\">ITEM_TEXT</a></li>\'',1);
INSERT INTO `engine_FOLDER` VALUES (69,44,'format=\'<li><a href=\"ITEM_LINK\">ITEM_TEXT</a></li>\'',0);
INSERT INTO `engine_FOLDER` VALUES (70,64,'format=\'<li><a href=\"ITEM_LINK\">ITEM_TEXT</a></li>\'',0);

--
-- Table structure for table `engine_FORM`
--

DROP TABLE IF EXISTS `engine_FORM`;
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

--
-- Dumping data for table `engine_FORM`
--


--
-- Table structure for table `engine_FORM_fields`
--

DROP TABLE IF EXISTS `engine_FORM_fields`;
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
) TYPE=MyISAM;

--
-- Dumping data for table `engine_FORM_fields`
--


--
-- Table structure for table `engine_HTMLDOC`
--

DROP TABLE IF EXISTS `engine_HTMLDOC`;
CREATE TABLE `engine_HTMLDOC` (
  `id` bigint(20) NOT NULL auto_increment,
  `html` longblob NOT NULL,
  `doc_id` bigint(20) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;

--
-- Dumping data for table `engine_HTMLDOC`
--

INSERT INTO `engine_HTMLDOC` VALUES (7,'<body lang=RU style=\'tab-interval:35.4pt\'>\r\n\r\n<div class=Section1>\r\n\r\n<p class=MsoNormal style=\'text-align:justify;text-justify:inter-ideograph\'><span\r\nstyle=\'font-size:10.0pt;font-family:\"Courier New CYR\";mso-fareast-language:\r\nZH-CN\'><o:p>&nbsp;</o:p></span></p>\r\n\r\n<p class=MsoNormal style=\'text-align:justify;text-justify:inter-ideograph\'><u><span\r\nlang=ZH-CN style=\'font-size:10.0pt;font-family:SimSun;mso-ascii-font-family:\r\n\"Courier New CYR\";mso-hansi-font-family:\"Courier New CYR\";mso-bidi-font-family:\r\n\"Courier New CYR\";color:blue;mso-fareast-language:ZH-CN\'>&#25105;&#20204;&#20844;&#21496;</span></u><u><span\r\nstyle=\'font-size:10.0pt;font-family:\"Courier New CYR\";color:blue;mso-fareast-language:\r\nZH-CN\'><o:p></o:p></span></u></p>\r\n\r\n<p class=MsoNormal style=\'text-align:justify;text-justify:inter-ideograph\'><span\r\nlang=ZH-CN style=\'font-size:10.0pt;font-family:SimSun;mso-ascii-font-family:\r\n\"Courier New CYR\";mso-hansi-font-family:\"Courier New CYR\";mso-bidi-font-family:\r\n\"Courier New CYR\";color:blue;mso-fareast-language:ZH-CN\'>&#24744;&#36890;&#21521;&#20420;&#32599;&#26031;&#30340;&#28023;&#19978;&#20043;&#36335;</span><u><span\r\nstyle=\'font-size:11.0pt;font-family:Arial;color:blue;mso-fareast-language:ZH-CN\'><o:p></o:p></span></u></p>\r\n\r\n<p class=MsoNormal style=\'text-align:justify;text-justify:inter-ideograph\'><u><span\r\nstyle=\'font-size:11.0pt;font-family:Arial;mso-fareast-language:ZH-CN\'><o:p><span\r\n style=\'text-decoration:none\'>&nbsp;</span></o:p></span></u></p>\r\n\r\n<p class=MsoNormal style=\'text-align:justify;text-justify:inter-ideograph\'><span\r\nstyle=\'font-size:11.0pt;font-family:Arial;mso-fareast-language:ZH-CN\'><o:p>&nbsp;</o:p></span></p>\r\n\r\n<p class=MsoNormal style=\'text-align:justify;text-justify:inter-ideograph\'><span\r\nlang=ZH-CN style=\'font-size:11.0pt;font-family:SimSun;mso-ascii-font-family:\r\nArial;mso-hansi-font-family:Arial;mso-bidi-font-family:Arial;color:blue;\r\nmso-fareast-language:ZH-CN\'>&#20840;&#29699;&#38598;&#35013;&#31665;&#26381;&#21153;&#20844;&#21496;&#38598;&#22242;&#65288;</span><span\r\nstyle=\'font-size:11.0pt;font-family:Arial;color:blue;mso-fareast-language:ZH-CN\'>GKS</span><span\r\nlang=ZH-CN style=\'font-size:11.0pt;font-family:SimSun;mso-ascii-font-family:\r\nArial;mso-hansi-font-family:Arial;mso-bidi-font-family:Arial;color:blue;\r\nmso-fareast-language:ZH-CN\'>&#65289;&#20174;</span><span style=\'font-size:11.0pt;\r\nfont-family:Arial;color:blue;mso-fareast-language:ZH-CN\'>1995</span><span\r\nlang=ZH-CN style=\'font-size:11.0pt;font-family:SimSun;mso-ascii-font-family:\r\nArial;mso-hansi-font-family:Arial;mso-bidi-font-family:Arial;color:blue;\r\nmso-fareast-language:ZH-CN\'>&#24180;&#24320;&#22987;&#22312;&#20420;&#32599;&#26031;&#38598;&#35013;&#31665;&#24066;&#22330;&#19978;&#25104;&#21151;&#32463;&#33829;&#12290;&#20174;&#31532;&#19968;&#20010;&#22312;&#20420;&#32599;&#26031;&#21335;&#37096;&#24314;&#31435;&#38598;&#35013;&#31665;&#33322;&#32447;&#21644;&#32447;&#36335;&#20195;&#29702;</span><span\r\nstyle=\'font-size:11.0pt;font-family:Arial;color:blue;mso-fareast-language:ZH-CN\'>FORCON</span><span\r\nlang=ZH-CN style=\'font-size:11.0pt;font-family:SimSun;mso-ascii-font-family:\r\nArial;mso-hansi-font-family:Arial;mso-bidi-font-family:Arial;color:blue;\r\nmso-fareast-language:ZH-CN\'>&#24320;&#22987;&#65292;&#20170;&#22825;&#65292;&#25105;&#20204;&#24050;&#32463;&#36827;&#20837;&#20102;&#34892;&#19994;&#21069;</span><span\r\nstyle=\'font-size:11.0pt;font-family:Arial;color:blue;mso-fareast-language:ZH-CN\'>10</span><span\r\nlang=ZH-CN style=\'font-size:11.0pt;font-family:SimSun;mso-ascii-font-family:\r\nArial;mso-hansi-font-family:Arial;mso-bidi-font-family:Arial;color:blue;\r\nmso-fareast-language:ZH-CN\'>&#21517;&#65292;&#24180;&#36816;&#36755;&#37327;&#36798;</span><span\r\nstyle=\'font-size:11.0pt;font-family:Arial;color:blue;mso-fareast-language:ZH-CN\'>120000</span><span\r\nlang=ZH-CN style=\'font-size:11.0pt;font-family:SimSun;mso-ascii-font-family:\r\nArial;mso-hansi-font-family:Arial;mso-bidi-font-family:Arial;color:blue;\r\nmso-fareast-language:ZH-CN\'>&#20010;</span><span style=\'font-size:11.0pt;\r\nfont-family:Arial;color:blue;mso-fareast-language:ZH-CN\'>TEU</span><span\r\nlang=ZH-CN style=\'font-size:11.0pt;font-family:SimSun;mso-ascii-font-family:\r\nArial;mso-hansi-font-family:Arial;mso-bidi-font-family:Arial;color:blue;\r\nmso-fareast-language:ZH-CN\'>&#12290;</span><span style=\'font-size:11.0pt;\r\nfont-family:Arial;color:blue;mso-fareast-language:ZH-CN\'><o:p></o:p></span></p>\r\n\r\n<p class=MsoNormal style=\'text-align:justify;text-justify:inter-ideograph\'><span\r\nstyle=\'font-size:11.0pt;font-family:Arial;mso-fareast-language:ZH-CN\'><o:p>&nbsp;</o:p></span></p>\r\n\r\n<p class=MsoNormal style=\'text-align:justify;text-justify:inter-ideograph\'><span\r\nstyle=\'font-size:11.0pt;font-family:Arial;mso-fareast-language:ZH-CN\'><o:p>&nbsp;</o:p></span></p>\r\n\r\n<p class=MsoNormal style=\'text-align:justify;text-justify:inter-ideograph\'><span\r\nstyle=\'font-size:11.0pt;font-family:Arial;color:blue;mso-fareast-language:ZH-CN\'>GKS</span><span\r\nlang=ZH-CN style=\'font-size:11.0pt;font-family:SimSun;mso-ascii-font-family:\r\nArial;mso-hansi-font-family:Arial;mso-bidi-font-family:Arial;color:blue;\r\nmso-fareast-language:ZH-CN\'>&#26159;&#20420;&#32599;&#26031;&#26368;&#22823;&#65292;&#21457;&#23637;&#21183;&#22836;&#26368;&#36805;&#29467;&#30340;&#36816;&#36755;&#25511;&#32929;&#20844;&#21496;&#20043;&#19968;—&#12298;</span><span\r\nstyle=\'font-size:11.0pt;font-family:Arial;color:blue;mso-fareast-language:ZH-CN\'>DELO</span><span\r\nlang=ZH-CN style=\'font-size:11.0pt;font-family:SimSun;mso-ascii-font-family:\r\nArial;mso-hansi-font-family:Arial;mso-bidi-font-family:Arial;color:blue;\r\nmso-fareast-language:ZH-CN\'>&#12299;&#30340;&#25104;&#21592;&#65292;&#24182;&#20174;</span><span\r\nstyle=\'font-size:11.0pt;font-family:Arial;color:blue;mso-fareast-language:ZH-CN\'>2006</span><span\r\nlang=ZH-CN style=\'font-size:11.0pt;font-family:SimSun;mso-ascii-font-family:\r\nArial;mso-hansi-font-family:Arial;mso-bidi-font-family:Arial;color:blue;\r\nmso-fareast-language:ZH-CN\'>&#24180;&#36215;&#31649;&#29702;&#20854;&#38598;&#35013;&#31665;&#36164;&#20135;&#12290;</span><span\r\nlang=EN-US style=\'font-size:11.0pt;font-family:Arial;color:blue;mso-ansi-language:\r\nEN-US;mso-fareast-language:ZH-CN\'>GKS</span><span lang=ZH-CN style=\'font-size:\r\n11.0pt;font-family:SimSun;mso-ascii-font-family:Arial;mso-hansi-font-family:\r\nArial;mso-bidi-font-family:Arial;color:blue;mso-fareast-language:ZH-CN\'>&#26071;&#19979;&#21253;&#25324;</span><span\r\nlang=EN-US style=\'font-size:11.0pt;font-family:Arial;color:blue;mso-ansi-language:\r\nEN-US;mso-fareast-language:ZH-CN\'>7</span><span lang=ZH-CN style=\'font-size:\r\n11.0pt;font-family:SimSun;mso-ascii-font-family:Arial;mso-hansi-font-family:\r\nArial;mso-bidi-font-family:Arial;color:blue;mso-ansi-language:EN-US;mso-fareast-language:\r\nZH-CN\'>&#20010;&#20195;&#29702;&#21644;&#29289;&#27969;&#36816;&#36755;&#20844;&#21496;&#65292;&#22312;&#20420;&#32599;&#26031;&#25152;&#26377;&#22823;&#30340;&#28207;&#21475;&#21644;&#22320;&#21306;&#65292;&#20197;&#21450;&#29420;&#32852;&#20307;&#21644;&#20854;&#20182;&#22320;&#21306;&#37117;&#26377;&#19994;&#21153;&#12290;</span><span\r\nlang=EN-US style=\'font-size:11.0pt;font-family:Arial;color:blue;mso-ansi-language:\r\nEN-US;mso-fareast-language:ZH-CN\'><o:p></o:p></span></p>\r\n\r\n<p class=MsoNormal style=\'text-align:justify;text-justify:inter-ideograph\'><span\r\nlang=EN-US style=\'font-size:11.0pt;font-family:Arial;mso-ansi-language:EN-US;\r\nmso-fareast-language:ZH-CN\'><o:p>&nbsp;</o:p></span></p>\r\n\r\n<p class=MsoNormal style=\'text-align:justify;text-justify:inter-ideograph\'><span\r\nlang=EN-US style=\'font-size:11.0pt;font-family:Arial;color:blue;mso-ansi-language:\r\nEN-US;mso-fareast-language:ZH-CN\'>GKS</span><span lang=ZH-CN style=\'font-size:\r\n11.0pt;font-family:SimSun;mso-ascii-font-family:Arial;mso-hansi-font-family:\r\nArial;mso-bidi-font-family:Arial;color:blue;mso-fareast-language:ZH-CN\'>&#30340;&#36164;&#20135;&#24635;&#37327;&#36229;&#36807;</span><span\r\nlang=EN-US style=\'font-size:11.0pt;font-family:Arial;color:blue;mso-ansi-language:\r\nEN-US;mso-fareast-language:ZH-CN\'>5000</span><span lang=ZH-CN style=\'font-size:\r\n11.0pt;font-family:SimSun;mso-ascii-font-family:Arial;mso-hansi-font-family:\r\nArial;mso-bidi-font-family:Arial;color:blue;mso-fareast-language:ZH-CN\'>&#19975;&#32654;&#22278;</span><span\r\nlang=ZH-CN style=\'font-size:11.0pt;font-family:SimSun;mso-ascii-font-family:\r\nArial;mso-hansi-font-family:Arial;mso-bidi-font-family:Arial;color:blue;\r\nmso-ansi-language:EN-US;mso-fareast-language:ZH-CN\'>&#65292;</span><span\r\nlang=ZH-CN style=\'font-size:11.0pt;font-family:SimSun;mso-ascii-font-family:\r\nArial;mso-hansi-font-family:Arial;mso-bidi-font-family:Arial;color:blue;\r\nmso-fareast-language:ZH-CN\'>&#33829;&#19994;&#39069;&#36229;&#36807;</span><span\r\nlang=EN-US style=\'font-size:11.0pt;font-family:Arial;color:blue;mso-ansi-language:\r\nEN-US;mso-fareast-language:ZH-CN\'>6000</span><span lang=ZH-CN style=\'font-size:\r\n11.0pt;font-family:SimSun;mso-ascii-font-family:Arial;mso-hansi-font-family:\r\nArial;mso-bidi-font-family:Arial;color:blue;mso-fareast-language:ZH-CN\'>&#19975;&#32654;&#22278;&#12290;</span><span\r\nstyle=\'font-size:11.0pt;font-family:Arial;color:blue;mso-fareast-language:ZH-CN\'>GKS</span><span\r\nlang=ZH-CN style=\'font-size:11.0pt;font-family:SimSun;mso-ascii-font-family:\r\nArial;mso-hansi-font-family:Arial;mso-bidi-font-family:Arial;color:blue;\r\nmso-fareast-language:ZH-CN\'>&#30340;&#36817;&#26399;&#35745;&#21010;&#26159;—&#32487;&#32493;&#25193;&#24352;&#65292;&#26080;&#35770;&#26159;&#20844;&#21496;&#25968;&#37327;&#21644;&#36816;&#21147;&#26041;&#38754;&#65292;&#36824;&#26159;&#22312;&#20420;&#32599;&#26031;&#21644;&#20854;&#20182;&#22269;&#23478;&#25552;&#20379;&#30340;&#36816;&#36755;&#26381;&#21153;&#37327;&#26041;&#38754;&#12290;</span><span\r\nstyle=\'font-size:11.0pt;font-family:Arial;color:blue;mso-fareast-language:ZH-CN\'><o:p></o:p></span></p>\r\n\r\n<p class=MsoNormal style=\'text-align:justify;text-justify:inter-ideograph\'><span\r\nstyle=\'font-size:11.0pt;font-family:Arial;mso-fareast-language:ZH-CN\'><o:p>&nbsp;</o:p></span></p>\r\n\r\n<p class=MsoNormal style=\'text-align:justify;text-justify:inter-ideograph\'><span\r\nstyle=\'font-size:11.0pt;font-family:Arial;color:blue;mso-fareast-language:ZH-CN\'><o:p>&nbsp;</o:p></span></p>\r\n\r\n<p class=MsoNormal style=\'text-align:justify;text-justify:inter-ideograph\'><span\r\nstyle=\'font-size:11.0pt;font-family:Arial;color:blue;mso-fareast-language:ZH-CN\'><o:p>&nbsp;</o:p></span></p>\r\n\r\n<p class=MsoNormal style=\'text-align:justify;text-justify:inter-ideograph\'><span\r\nstyle=\'font-size:11.0pt;font-family:Arial;color:blue;mso-fareast-language:ZH-CN\'>GKS</span><span\r\nlang=ZH-CN style=\'font-size:11.0pt;font-family:SimSun;mso-ascii-font-family:\r\nArial;mso-hansi-font-family:Arial;mso-bidi-font-family:Arial;color:blue;\r\nmso-fareast-language:ZH-CN\'>&#30340;&#20027;&#35201;&#32463;&#33829;&#26041;&#21521;&#21253;&#25324;&#20102;&#20844;&#21496;&#31649;&#29702;&#65292;&#25112;&#30053;&#35745;&#21010;&#21644;&#38598;&#22242;&#20869;&#20225;&#19994;&#21644;&#36164;&#20135;&#30340;&#21457;&#23637;&#12290;&#25105;&#20204;&#24037;&#20316;&#26368;&#37325;&#35201;&#30340;&#20248;&#20808;&#26041;&#21521;&#26159;&#22312;&#20420;&#32599;&#26031;&#24066;&#22330;&#19978;&#37319;&#29992;&#26368;&#20808;&#36827;&#30340;&#38598;&#35013;&#31665;&#36816;&#36755;&#25216;&#26415;&#65292;&#32500;&#25252;&#23458;&#25143;&#65292;&#20249;&#20276;&#21644;&#32929;&#19996;&#21033;&#30410;&#65292;&#19981;&#26029;&#23436;&#21892;&#25152;&#25552;&#20379;&#30340;&#26381;&#21153;&#12290;</span><span\r\nstyle=\'font-size:11.0pt;font-family:Arial;color:blue;mso-fareast-language:ZH-CN\'><o:p></o:p></span></p>\r\n\r\n<p class=MsoNormal style=\'text-align:justify;text-justify:inter-ideograph\'><span\r\nstyle=\'font-size:11.0pt;font-family:Arial;color:blue;mso-fareast-language:ZH-CN\'><o:p>&nbsp;</o:p></span></p>\r\n\r\n<p class=MsoNormal style=\'text-align:justify;text-justify:inter-ideograph\'><span\r\nstyle=\'font-size:11.0pt;font-family:Arial;color:blue;mso-fareast-language:ZH-CN\'><o:p>&nbsp;</o:p></span></p>\r\n\r\n<p class=MsoNormal style=\'text-align:justify;text-justify:inter-ideograph\'><span\r\nstyle=\'font-size:11.0pt;font-family:Arial;color:blue;mso-fareast-language:ZH-CN\'>GKS</span><span\r\nlang=ZH-CN style=\'font-size:11.0pt;font-family:SimSun;mso-ascii-font-family:\r\nArial;mso-hansi-font-family:Arial;mso-bidi-font-family:Arial;color:blue;\r\nmso-fareast-language:ZH-CN\'>&#30340;&#25112;&#30053;&#38382;&#39064;&#26159;&#36890;&#36807;&#24314;&#31435;&#35206;&#30422;&#20420;&#32599;&#26031;&#21644;&#19990;&#30028;&#20219;&#20309;&#19968;&#20010;&#28857;&#30340;&#19981;&#38388;&#26029;&#38598;&#35013;&#31665;&#36816;&#36755;&#22402;&#30452;&#19968;&#20307;&#21270;&#31995;&#32479;&#65292;&#22312;&#26410;&#26469;</span><span\r\nstyle=\'font-size:11.0pt;font-family:Arial;color:blue;mso-fareast-language:ZH-CN\'>5</span><span\r\nlang=ZH-CN style=\'font-size:11.0pt;font-family:SimSun;mso-ascii-font-family:\r\nArial;mso-hansi-font-family:Arial;mso-bidi-font-family:Arial;color:blue;\r\nmso-fareast-language:ZH-CN\'>&#24180;&#20869;&#23558;&#33829;&#19994;&#39069;&#25552;&#39640;</span><span\r\nstyle=\'font-size:11.0pt;font-family:Arial;color:blue;mso-fareast-language:ZH-CN\'>2</span><span\r\nlang=ZH-CN style=\'font-size:11.0pt;font-family:SimSun;mso-ascii-font-family:\r\nArial;mso-hansi-font-family:Arial;mso-bidi-font-family:Arial;color:blue;\r\nmso-fareast-language:ZH-CN\'>&#20493;&#65292;&#23558;&#36816;&#36755;&#37327;&#25552;&#39640;</span><span\r\nstyle=\'font-size:11.0pt;font-family:Arial;color:blue;mso-fareast-language:ZH-CN\'>1</span><span\r\nlang=ZH-CN style=\'font-size:11.0pt;font-family:SimSun;mso-ascii-font-family:\r\nArial;mso-hansi-font-family:Arial;mso-bidi-font-family:Arial;color:blue;\r\nmso-fareast-language:ZH-CN\'>&#20493;&#12290;&#35299;&#20915;&#36825;&#19968;&#38382;&#39064;&#65292;&#25105;&#20204;&#20381;&#38752;&#30340;&#26159;&#36817;</span><span\r\nstyle=\'font-size:11.0pt;font-family:Arial;color:blue;mso-fareast-language:ZH-CN\'>400</span><span\r\nlang=ZH-CN style=\'font-size:11.0pt;font-family:SimSun;mso-ascii-font-family:\r\nArial;mso-hansi-font-family:Arial;mso-bidi-font-family:Arial;color:blue;\r\nmso-fareast-language:ZH-CN\'>&#20010;&#33258;&#26377;&#21592;&#24037;&#30340;&#39640;&#24230;&#19987;&#19994;&#27700;&#20934;&#65292;&#20197;&#21450;&#19982;&#20420;&#32599;&#26031;&#21644;&#22269;&#38469;&#20027;&#35201;&#36816;&#36755;&#20844;&#21496;&#30340;&#32039;&#23494;&#30340;&#20249;&#20276;&#20851;&#31995;&#12290;</span><span\r\nstyle=\'font-size:11.0pt;font-family:Arial;color:blue;mso-fareast-language:ZH-CN\'><o:p></o:p></span></p>\r\n\r\n<p class=MsoNormal><span style=\'font-size:11.0pt;font-family:Arial;color:blue;\r\nmso-fareast-language:ZH-CN\'><o:p>&nbsp;</o:p></span></p>\r\n\r\n<p class=MsoNormal><span lang=ZH-CN style=\'font-size:11.0pt;font-family:SimSun;\r\nmso-ascii-font-family:Arial;mso-hansi-font-family:Arial;mso-bidi-font-family:\r\nArial;color:blue;mso-fareast-language:ZH-CN\'>&#22312;&#20420;&#32599;&#26031;&#36816;&#36755;&#24066;&#22330;&#19978;&#32463;&#33829;&#20102;</span><span\r\nstyle=\'font-size:11.0pt;font-family:Arial;color:blue;mso-fareast-language:ZH-CN\'>12</span><span\r\nlang=ZH-CN style=\'font-size:11.0pt;font-family:SimSun;mso-ascii-font-family:\r\nArial;mso-hansi-font-family:Arial;mso-bidi-font-family:Arial;color:blue;\r\nmso-fareast-language:ZH-CN\'>&#24180;&#22810;&#65292;&#25105;&#20204;&#33268;&#21147;&#20110;&#19981;&#26029;&#24320;&#36767;&#22269;&#38469;&#36152;&#26131;&#30340;&#26032;&#39046;&#22495;&#65292;&#22312;&#20154;&#20204;&#65292;&#20844;&#21496;&#21644;&#21508;&#22269;&#20043;&#38388;&#24314;&#31435;&#21512;&#20316;&#21644;&#20114;&#24800;&#29983;&#24847;&#30340;&#26725;&#26753;&#12290;</span><span\r\nstyle=\'color:blue;mso-fareast-language:ZH-CN\'><o:p></o:p></span></p>\r\n\r\n</div>\r\n\r\n</body>\r\n\r\n</html>\r\n',22);
INSERT INTO `engine_HTMLDOC` VALUES (18,'<p>&#20840;&#29699;&#38598;&#35013;&#31665;&#26381;&#21153;&#20844;&#21496;&#38598;&#22242;&#65288;GKS&#65289;&#20174;1995&#24180;&#24320;&#22987;&#22312;&#20420;&#32599;&#26031;&#38598;&#35013;&#31665;&#24066;&#22330;&#19978;&#25104;&#21151;&#32463;&#33829;&#12290;&#20174;&#31532;&#19968;&#20010;&#22312;&#20420;&#32599;&#26031;&#21335;&#37096;&#24314;&#31435;&#38598;&#35013;&#31665;&#33322;&#32447;&#21644;&#32447;&#36335;&#20195;&#29702;FORCON&#24320;&#22987;&#65292;&#20170;&#22825;&#65292;&#25105;&#20204;&#24050;&#32463;&#36827;&#20837;&#20102;&#34892;&#19994;&#21069;10&#21517;&#65292;&#24180;&#36816;&#36755;&#37327;&#36798;120000&#20010;TEU&#12290;\r\n\r\n<p>GKS&#26159;&#20420;&#32599;&#26031;&#26368;&#22823;&#65292;&#21457;&#23637;&#21183;&#22836;&#26368;&#36805;&#29467;&#30340;&#36816;&#36755;&#25511;&#32929;&#20844;&#21496;&#20043;&#19968;—&#12298;DELO&#12299;&#30340;&#25104;&#21592;&#65292;&#24182;&#20174;2006&#24180;&#36215;&#31649;&#29702;&#20854;&#38598;&#35013;&#31665;&#36164;&#20135;&#12290;GKS&#26071;&#19979;&#21253;&#25324;7&#20010;&#20195;&#29702;&#21644;&#29289;&#27969;&#36816;&#36755;&#20844;&#21496;&#65292;&#22312;&#20420;&#32599;&#26031;&#25152;&#26377;&#22823;&#30340;&#28207;&#21475;&#21644;&#22320;&#21306;&#65292;&#20197;&#21450;&#29420;&#32852;&#20307;&#21644;&#20854;&#20182;&#22320;&#21306;&#37117;&#26377;&#19994;&#21153;&#12290;\r\n\r\n<p>GKS&#30340;&#36164;&#20135;&#24635;&#37327;&#36229;&#36807;5000&#19975;&#32654;&#22278;&#65292;&#33829;&#19994;&#39069;&#36229;&#36807;6000&#19975;&#32654;&#22278;&#12290;GKS&#30340;&#36817;&#26399;&#35745;&#21010;&#26159;—&#32487;&#32493;&#25193;&#24352;&#65292;&#26080;&#35770;&#26159;&#20844;&#21496;&#25968;&#37327;&#21644;&#36816;&#21147;&#26041;&#38754;&#65292;&#36824;&#26159;&#22312;&#20420;&#32599;&#26031;&#21644;&#20854;&#20182;&#22269;&#23478;&#25552;&#20379;&#30340;&#36816;&#36755;&#26381;&#21153;&#37327;&#26041;&#38754;&#12290;\r\n\r\n<p>GKS&#30340;&#20027;&#35201;&#32463;&#33829;&#26041;&#21521;&#21253;&#25324;&#20102;&#20844;&#21496;&#31649;&#29702;&#65292;&#25112;&#30053;&#35745;&#21010;&#21644;&#38598;&#22242;&#20869;&#20225;&#19994;&#21644;&#36164;&#20135;&#30340;&#21457;&#23637;&#12290;&#25105;&#20204;&#24037;&#20316;&#26368;&#37325;&#35201;&#30340;&#20248;&#20808;&#26041;&#21521;&#26159;&#22312;&#20420;&#32599;&#26031;&#24066;&#22330;&#19978;&#37319;&#29992;&#26368;&#20808;&#36827;&#30340;&#38598;&#35013;&#31665;&#36816;&#36755;&#25216;&#26415;&#65292;&#32500;&#25252;&#23458;&#25143;&#65292;&#20249;&#20276;&#21644;&#32929;&#19996;&#21033;&#30410;&#65292;&#19981;&#26029;&#23436;&#21892;&#25152;&#25552;&#20379;&#30340;&#26381;&#21153;&#12290;\r\n\r\n<p>GKS&#30340;&#25112;&#30053;&#38382;&#39064;&#26159;&#36890;&#36807;&#24314;&#31435;&#35206;&#30422;&#20420;&#32599;&#26031;&#21644;&#19990;&#30028;&#20219;&#20309;&#19968;&#20010;&#28857;&#30340;&#19981;&#38388;&#26029;&#38598;&#35013;&#31665;&#36816;&#36755;&#22402;&#30452;&#19968;&#20307;&#21270;&#31995;&#32479;&#65292;&#22312;&#26410;&#26469;5&#24180;&#20869;&#23558;&#33829;&#19994;&#39069;&#25552;&#39640;2&#20493;&#65292;&#23558;&#36816;&#36755;&#37327;&#25552;&#39640;1&#20493;&#12290;&#35299;&#20915;&#36825;&#19968;&#38382;&#39064;&#65292;&#25105;&#20204;&#20381;&#38752;&#30340;&#26159;&#36817;400&#20010;&#33258;&#26377;&#21592;&#24037;&#30340;&#39640;&#24230;&#19987;&#19994;&#27700;&#20934;&#65292;&#20197;&#21450;&#19982;&#20420;&#32599;&#26031;&#21644;&#22269;&#38469;&#20027;&#35201;&#36816;&#36755;&#20844;&#21496;&#30340;&#32039;&#23494;&#30340;&#20249;&#20276;&#20851;&#31995;&#12290;\r\n\r\n<p>&#22312;&#20420;&#32599;&#26031;&#36816;&#36755;&#24066;&#22330;&#19978;&#32463;&#33829;&#20102;12&#24180;&#22810;&#65292;&#25105;&#20204;&#33268;&#21147;&#20110;&#19981;&#26029;&#24320;&#36767;&#22269;&#38469;&#36152;&#26131;&#30340;&#26032;&#39046;&#22495;&#65292;&#22312;&#20154;&#20204;&#65292;&#20844;&#21496;&#21644;&#21508;&#22269;&#20043;&#38388;&#24314;&#31435;&#21512;&#20316;&#21644;&#20114;&#24800;&#29983;&#24847;&#30340;&#26725;&#26753;&#12290;\r\n',71);

--
-- Table structure for table `engine_LINK`
--

DROP TABLE IF EXISTS `engine_LINK`;
CREATE TABLE `engine_LINK` (
  `doc_id` bigint(20) NOT NULL default '0',
  `linkid` bigint(20) NOT NULL default '0',
  `link_external` varchar(255) NOT NULL default '',
  `status` int(4) NOT NULL default '100',
  PRIMARY KEY  (`doc_id`)
) TYPE=MyISAM;

--
-- Dumping data for table `engine_LINK`
--

INSERT INTO `engine_LINK` VALUES (73,17,'',100);

--
-- Table structure for table `engine_NEW`
--

DROP TABLE IF EXISTS `engine_NEW`;
CREATE TABLE `engine_NEW` (
  `id` bigint(20) NOT NULL auto_increment,
  `header` longtext,
  `text` longtext,
  `doc_id` bigint(20) default '0',
  `html` longtext,
  `new_date` datetime default NULL,
  `new_date_start` datetime default NULL,
  `new_date_end` datetime default NULL,
  `grpassign` bigint(20) NOT NULL default '-1',
  `usrassign` bigint(20) NOT NULL default '-1',
  `new_stick` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `engine_idx_NEW_doc_id` (`doc_id`),
  KEY `engine_idx_NEW_grpassign` (`grpassign`),
  KEY `engine_idx_NEW_usrassign` (`usrassign`)
) TYPE=MyISAM;

--
-- Dumping data for table `engine_NEW`
--

INSERT INTO `engine_NEW` VALUES (40,'Расширение автопарка \"Рускон\" ','Началось поступление новых автомашин-контейнеровозов MAN. ',18,'31.08.2007 \"Рускон\" начал приём и запуск в эксплуатацию новых тягачей MAN. <p  class=\"new\">Программа расширения автоколнны компании предполагает покупку более 100 машин до конца 2007 года. К моменту окончания программы общий парк контейнеровозов \"Рускон\" составит более 150 единиц. </p><p  class=\"new\">Новую технику планируется задействовать на перевозках контейнеров по России в режиме таможенного перевозчика из портов Санкт-Петербурга, Новороссийска и Финляндии.</p>','2007-08-20 18:08:02',NULL,NULL,-1,-1,0);
INSERT INTO `engine_NEW` VALUES (41,'Новые маршруты для перевозок','Открыты новые возможности для перевозок из Кореи и Китая',65,'Новые маршруты открыты!','2007-09-12 16:26:59',NULL,NULL,-1,-1,0);
INSERT INTO `engine_NEW` VALUES (42,'ffffff','ggggggggg',74,'gggggggggggg','2007-09-18 12:18:46',NULL,NULL,-1,-1,0);
INSERT INTO `engine_NEW` VALUES (43,'gggggggg','ffffff',75,'ggggggggggggggggg','2007-09-18 12:24:57',NULL,NULL,-1,-1,0);
INSERT INTO `engine_NEW` VALUES (44,'ddddddd','fffffffff',76,'ggggggggggggggggggggg','2007-09-28 12:25:22',NULL,NULL,-1,-1,0);

--
-- Table structure for table `engine_NEWSGROUP`
--

DROP TABLE IF EXISTS `engine_NEWSGROUP`;
CREATE TABLE `engine_NEWSGROUP` (
  `id` bigint(20) NOT NULL auto_increment,
  `doc_id` bigint(20) default '0',
  `ncount` int(11) default '5',
  `format` text NOT NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;

--
-- Dumping data for table `engine_NEWSGROUP`
--

INSERT INTO `engine_NEWSGROUP` VALUES (5,17,5,'<a class=\"news\" href=\"NEW_HREF\"><span>NEW_DATE</span><br>NEW_HEADER</a>');
INSERT INTO `engine_NEWSGROUP` VALUES (6,44,5,'<p>NEW_DATE</p>\r\n<p>NEW_HEADER</p>\r\n<p>NEW_TEXT</p>\r\n<p><a href=\"NEW_HREF\">Подробнее</a></p>\r\n');

--
-- Table structure for table `engine_PHOTOGALARY`
--

DROP TABLE IF EXISTS `engine_PHOTOGALARY`;
CREATE TABLE `engine_PHOTOGALARY` (
  `doc_id` bigint(20) NOT NULL default '0',
  `rows` int(11) NOT NULL default '50',
  `format` longtext NOT NULL,
  `cols` int(11) NOT NULL default '5',
  `nwnd` smallint(6) NOT NULL default '0'
) TYPE=MyISAM;

--
-- Dumping data for table `engine_PHOTOGALARY`
--


--
-- Table structure for table `engine_PHOTOGALARY_cells`
--

DROP TABLE IF EXISTS `engine_PHOTOGALARY_cells`;
CREATE TABLE `engine_PHOTOGALARY_cells` (
  `id` bigint(20) NOT NULL auto_increment,
  `text1` text NOT NULL,
  `text2` text NOT NULL,
  `text3` text NOT NULL,
  `gal_id` bigint(20) NOT NULL default '0',
  `ord` bigint(20) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;

--
-- Dumping data for table `engine_PHOTOGALARY_cells`
--


--
-- Table structure for table `engine_TABLE`
--

DROP TABLE IF EXISTS `engine_TABLE`;
CREATE TABLE `engine_TABLE` (
  `id` bigint(20) NOT NULL auto_increment,
  `doc_id` bigint(20) NOT NULL default '0',
  `tblname` varchar(255) NOT NULL default '',
  `begin` text NOT NULL,
  `format` text NOT NULL,
  `end` text NOT NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;

--
-- Dumping data for table `engine_TABLE`
--


--
-- Table structure for table `engine_TABLEDOC`
--

DROP TABLE IF EXISTS `engine_TABLEDOC`;
CREATE TABLE `engine_TABLEDOC` (
  `doc_id` bigint(20) NOT NULL default '0',
  `rowsperpage` int(11) NOT NULL default '50'
) TYPE=MyISAM;

--
-- Dumping data for table `engine_TABLEDOC`
--


--
-- Table structure for table `engine_TABLEDOC_cells`
--

DROP TABLE IF EXISTS `engine_TABLEDOC_cells`;
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
) TYPE=MyISAM;

--
-- Dumping data for table `engine_TABLEDOC_cells`
--


--
-- Table structure for table `engine_TEXTDOC`
--

DROP TABLE IF EXISTS `engine_TEXTDOC`;
CREATE TABLE `engine_TEXTDOC` (
  `id` bigint(20) NOT NULL auto_increment,
  `html` longblob NOT NULL,
  `doc_id` bigint(20) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;

--
-- Dumping data for table `engine_TEXTDOC`
--

INSERT INTO `engine_TEXTDOC` VALUES (1357,'<p class=textdoc >Группа компаний «Глобальный Контейнерный Сервис» (ГКС) успешно работает на российском контейнерном рынке с 1995 года. Начав свой путь с создания первой на юге России контейнерной линии и линейного агентства Forcon, сегодня мы входим в десятку лидеров отрасли с объемом перевозок до 120 тыс. TEU в год.</p><p class=textdoc  /><p class=textdoc  /><p class=textdoc >ГКС входит в один из крупнейших и динамично растущих транспортных холдингов России – «Дело», и с 2006 года управляет его контейнерными активами. В составе ГКС 7 агентских, логистических и транспортных компаний &nbsp;представленных во всех крупнейших российских портах и регионах, а также странах ближнего и дальнего зарубежья. </p><p class=textdoc  /><p class=textdoc  /><p class=textdoc >Выручка компаний ГКС превышает US$60 миллионов при объеме капитализации более US$50 миллионов. В ближайших планах ГКС – дальнейшее расширение, как числа компаний и транспортных мощностей, так и объемов транспортных услуг, оказываемых в России и за ее пределами.</p><p class=textdoc  /><p class=textdoc  /><p class=textdoc  /><p class=textdoc >Основные направления деятельности ГКС охватывают корпоративное управление, стратегическое планирование и развитие предприятий и активов, входящих в группу. Важнейшим приоритетом нашей работы является внедрение наиболее передовых технологий контейнерных перевозок на российском рынке, постоянное совершенствование оказываемых услуг в интересах клиентов, партнеров и акционеров.</p><p class=textdoc  /><p class=textdoc  /><p class=textdoc  /><p class=textdoc >Стратегической задачей ГКС является утроение выручки и удвоение объемов перевозок в течение ближайших 5 лет путём создания вертикально-интегрированной системы бесперебойной доставки контейнеров в любую точку России и мира. В решении этой задачи мы опираемся на высокий профессионализм около 400 собственных сотрудников, а также тесные партнерские отношения с ведущими российскими и международными транспортными компаниями. </p><p class=textdoc  /><p class=textdoc  /><p class=textdoc  /><p class=textdoc >Работая уже более 12 лет на российском транспортном рынке, мы стремимся постоянно открывать новые горизонты международной торговли, наводя мосты сотрудничества и взаимовыгодного бизнеса между людьми, компаниями и странами. &nbsp;</p>',2);
INSERT INTO `engine_TEXTDOC` VALUES (1360,'<p class=textdoc ><strong class=textdoc >ПРОФЕССИОНАЛИЗМ<p class=textdoc  /></strong></p><p class=textdoc  /><p class=textdoc  /><p class=textdoc >Высокий профессионализм и безупречная деловая репутация ГКС – залог успеха наших клиентов. Мы предлагаем только отработанные и многократно проверенные нами транспортные схемы, способные гарантировать 100% качество и надежность перевозок.</p><p class=textdoc  /><p class=textdoc  /><p class=textdoc  /><p class=textdoc ><strong class=textdoc >ОТКРЫТОСТЬ <p class=textdoc  /></strong></p><p class=textdoc  /><p class=textdoc  /><p class=textdoc >В работе с клиентами мы стремимся к максимальной открытости и взаимному доверию. Нашим ориентиром является долгосрочное сотрудничество, которое достигается максимальной прозрачностью и строгим следованием нормам деловой этики. Мы открыты к постоянному диалогу с клиентами и партнёрами, видя в них главную опору нашего бизнеса.</p><p class=textdoc  /><p class=textdoc  /><p class=textdoc  /><p class=textdoc ><strong class=textdoc >ИННОВАЦИИ<p class=textdoc  /></strong></p><p class=textdoc  /><p class=textdoc  /><p class=textdoc >Мы стремимся к постоянному совершенствованию услуг и использованию передовых транспортных технологий. ГКС является одним из лидеров российской контейнерной отрасли по объемам инвестиций в современную инфраструктуру, транспортные средства, информационные и управленческие системы. Ежегодно внедряемые нами инновации в вариантах перевалки и доставки контейнерных грузов помогают нашим клиентам открывать и реализовывать новые внешнеторговые возможности в России и за рубежом.</p><p class=textdoc  /><p class=textdoc  /><p class=textdoc  /><p class=textdoc ><strong class=textdoc >ЛЮДИ<p class=textdoc  /></strong></p><p class=textdoc  /><p class=textdoc  /><p class=textdoc >Люди – наш главная ценность и важнейший актив. ГКС приветствует среди своих сотрудников инициативу и постоянное стремление к совершенствованию, предлагая им широкие возможности для профессионального роста, обучения и самореализации в рамках компании. Заботясь о благополучии наших работников, мы развиваем их чуткий подход к нуждам и запросам клиентов. </p><p class=textdoc  />',4);
INSERT INTO `engine_TEXTDOC` VALUES (1387,'<p  class=\"textdoc\"><u  class=\"textdoc\">РУКОВОДСТВО КОМПАНИИ:<p  class=\"textdoc\" /></u></p><p  class=\"textdoc\" /><p  class=\"textdoc\" /><ul  class=\"textdoc\"><li  class=\"textdoc\">Василий Николаевич Козлобаев</li><li  class=\"textdoc\">Сергей Николаевич Берёзкин</li><li  class=\"textdoc\">Андрей Владимирович Чернышев</li><li  class=\"textdoc\">Андрей Анатольевич Нараевский</li><li  class=\"textdoc\">Сергей Юрьевич Серебренников </li></li /><p  class=\"textdoc\"></li /></p><p  class=\"textdoc\"></li /></p></ul>',20);
INSERT INTO `engine_TEXTDOC` VALUES (1382,'<p class=textdoc ><body class=textdoc  lang=RU style=\'tab-interval:35.4pt\'></p><p class=textdoc ><div  class=Section1></p><p class=textdoc ><p  class=MsoNormal style=\'text-align:justify;text-justify:inter-ideograph\'><span<br class=textdoc  />style=\'font-size:10.0pt;font-family:\"Courier New CYR\";mso-fareast-language:<br class=textdoc  />ZH-CN\'><o:p>&nbsp;</o:p></span></p></p><p class=textdoc ><p  class=MsoNormal style=\'text-align:justify;text-justify:inter-ideograph\'><u class=textdoc ><span<br class=textdoc  />lang=ZH-CN style=\'font-size:10.0pt;font-family:SimSun;mso-ascii-font-family:<br class=textdoc  />\"Courier New CYR\";mso-hansi-font-family:\"Courier New CYR\";mso-bidi-font-family:<br class=textdoc  />\"Courier New CYR\";color:blue;mso-fareast-language:ZH-CN\'>&#25105;&#20204;&#20844;&#21496;</span></u><u class=textdoc ><span<br class=textdoc  />style=\'font-size:10.0pt;font-family:\"Courier New CYR\";color:blue;mso-fareast-language:<br class=textdoc  />ZH-CN\'><o:p></o:p></span></u></p></p><p class=textdoc ><p  class=MsoNormal style=\'text-align:justify;text-justify:inter-ideograph\'><span<br class=textdoc  />lang=ZH-CN style=\'font-size:10.0pt;font-family:SimSun;mso-ascii-font-family:<br class=textdoc  />\"Courier New CYR\";mso-hansi-font-family:\"Courier New CYR\";mso-bidi-font-family:<br class=textdoc  />\"Courier New CYR\";color:blue;mso-fareast-language:ZH-CN\'>&#24744;&#36890;&#21521;&#20420;&#32599;&#26031;&#30340;&#28023;&#19978;&#20043;&#36335;</span><u class=textdoc ><span<br class=textdoc  />style=\'font-size:11.0pt;font-family:Arial;color:blue;mso-fareast-language:ZH-CN\'><o:p></o:p></span></u></p></p><p class=textdoc ><p  class=MsoNormal style=\'text-align:justify;text-justify:inter-ideograph\'><u class=textdoc ><span<br class=textdoc  />style=\'font-size:11.0pt;font-family:Arial;mso-fareast-language:ZH-CN\'><o:p><span<br class=textdoc  />&nbsp;style=\'text-decoration:none\'>&nbsp;</span></o:p></span></u></p></p><p class=textdoc ><p  class=MsoNormal style=\'text-align:justify;text-justify:inter-ideograph\'><span<br class=textdoc  />style=\'font-size:11.0pt;font-family:Arial;mso-fareast-language:ZH-CN\'><o:p>&nbsp;</o:p></span></p></p><p class=textdoc ><p  class=MsoNormal style=\'text-align:justify;text-justify:inter-ideograph\'><span<br class=textdoc  />lang=ZH-CN style=\'font-size:11.0pt;font-family:SimSun;mso-ascii-font-family:<br class=textdoc  />Arial;mso-hansi-font-family:Arial;mso-bidi-font-family:Arial;color:blue;<br class=textdoc  />mso-fareast-language:ZH-CN\'>&#20840;&#29699;&#38598;&#35013;&#31665;&#26381;&#21153;&#20844;&#21496;&#38598;&#22242;&#65288;</span><span<br class=textdoc  />style=\'font-size:11.0pt;font-family:Arial;color:blue;mso-fareast-language:ZH-CN\'>GKS</span><span<br class=textdoc  />lang=ZH-CN style=\'font-size:11.0pt;font-family:SimSun;mso-ascii-font-family:<br class=textdoc  />Arial;mso-hansi-font-family:Arial;mso-bidi-font-family:Arial;color:blue;<br class=textdoc  />mso-fareast-language:ZH-CN\'>&#65289;&#20174;</span><span  style=\'font-size:11.0pt;<br class=textdoc  />font-family:Arial;color:blue;mso-fareast-language:ZH-CN\'>1995</span><span<br class=textdoc  />lang=ZH-CN style=\'font-size:11.0pt;font-family:SimSun;mso-ascii-font-family:<br class=textdoc  />Arial;mso-hansi-font-family:Arial;mso-bidi-font-family:Arial;color:blue;<br class=textdoc  />mso-fareast-language:ZH-CN\'>&#24180;&#24320;&#22987;&#22312;&#20420;&#32599;&#26031;&#38598;&#35013;&#31665;&#24066;&#22330;&#19978;&#25104;&#21151;&#32463;&#33829;&#12290;&#20174;&#31532;&#19968;&#20010;&#22312;&#20420;&#32599;&#26031;&#21335;&#37096;&#24314;&#31435;&#38598;&#35013;&#31665;&#33322;&#32447;&#21644;&#32447;&#36335;&#20195;&#29702;</span><span<br class=textdoc  />style=\'font-size:11.0pt;font-family:Arial;color:blue;mso-fareast-language:ZH-CN\'>FORCON</span><span<br class=textdoc  />lang=ZH-CN style=\'font-size:11.0pt;font-family:SimSun;mso-ascii-font-family:<br class=textdoc  />Arial;mso-hansi-font-family:Arial;mso-bidi-font-family:Arial;color:blue;<br class=textdoc  />mso-fareast-language:ZH-CN\'>&#24320;&#22987;&#65292;&#20170;&#22825;&#65292;&#25105;&#20204;&#24050;&#32463;&#36827;&#20837;&#20102;&#34892;&#19994;&#21069;</span><span<br class=textdoc  />style=\'font-size:11.0pt;font-family:Arial;color:blue;mso-fareast-language:ZH-CN\'>10</span><span<br class=textdoc  />lang=ZH-CN style=\'font-size:11.0pt;font-family:SimSun;mso-ascii-font-family:<br class=textdoc  />Arial;mso-hansi-font-family:Arial;mso-bidi-font-family:Arial;color:blue;<br class=textdoc  />mso-fareast-language:ZH-CN\'>&#21517;&#65292;&#24180;&#36816;&#36755;&#37327;&#36798;</span><span<br class=textdoc  />style=\'font-size:11.0pt;font-family:Arial;color:blue;mso-fareast-language:ZH-CN\'>120000</span><span<br class=textdoc  />lang=ZH-CN style=\'font-size:11.0pt;font-family:SimSun;mso-ascii-font-family:<br class=textdoc  />Arial;mso-hansi-font-family:Arial;mso-bidi-font-family:Arial;color:blue;<br class=textdoc  />mso-fareast-language:ZH-CN\'>&#20010;</span><span  style=\'font-size:11.0pt;<br class=textdoc  />font-family:Arial;color:blue;mso-fareast-language:ZH-CN\'>TEU</span><span<br class=textdoc  />lang=ZH-CN style=\'font-size:11.0pt;font-family:SimSun;mso-ascii-font-family:<br class=textdoc  />Arial;mso-hansi-font-family:Arial;mso-bidi-font-family:Arial;color:blue;<br class=textdoc  />mso-fareast-language:ZH-CN\'>&#12290;</span><span  style=\'font-size:11.0pt;<br class=textdoc  />font-family:Arial;color:blue;mso-fareast-language:ZH-CN\'><o:p></o:p></span></p></p><p class=textdoc ><p  class=MsoNormal style=\'text-align:justify;text-justify:inter-ideograph\'><span<br class=textdoc  />style=\'font-size:11.0pt;font-family:Arial;mso-fareast-language:ZH-CN\'><o:p>&nbsp;</o:p></span></p></p><p class=textdoc ><p  class=MsoNormal style=\'text-align:justify;text-justify:inter-ideograph\'><span<br class=textdoc  />style=\'font-size:11.0pt;font-family:Arial;mso-fareast-language:ZH-CN\'><o:p>&nbsp;</o:p></span></p></p><p class=textdoc ><p  class=MsoNormal style=\'text-align:justify;text-justify:inter-ideograph\'><span<br class=textdoc  />style=\'font-size:11.0pt;font-family:Arial;color:blue;mso-fareast-language:ZH-CN\'>GKS</span><span<br class=textdoc  />lang=ZH-CN style=\'font-size:11.0pt;font-family:SimSun;mso-ascii-font-family:<br class=textdoc  />Arial;mso-hansi-font-family:Arial;mso-bidi-font-family:Arial;color:blue;<br class=textdoc  />mso-fareast-language:ZH-CN\'>&#26159;&#20420;&#32599;&#26031;&#26368;&#22823;&#65292;&#21457;&#23637;&#21183;&#22836;&#26368;&#36805;&#29467;&#30340;&#36816;&#36755;&#25511;&#32929;&#20844;&#21496;&#20043;&#19968;—&#12298;</span><span<br class=textdoc  />style=\'font-size:11.0pt;font-family:Arial;color:blue;mso-fareast-language:ZH-CN\'>DELO</span><span<br class=textdoc  />lang=ZH-CN style=\'font-size:11.0pt;font-family:SimSun;mso-ascii-font-family:<br class=textdoc  />Arial;mso-hansi-font-family:Arial;mso-bidi-font-family:Arial;color:blue;<br class=textdoc  />mso-fareast-language:ZH-CN\'>&#12299;&#30340;&#25104;&#21592;&#65292;&#24182;&#20174;</span><span<br class=textdoc  />style=\'font-size:11.0pt;font-family:Arial;color:blue;mso-fareast-language:ZH-CN\'>2006</span><span<br class=textdoc  />lang=ZH-CN style=\'font-size:11.0pt;font-family:SimSun;mso-ascii-font-family:<br class=textdoc  />Arial;mso-hansi-font-family:Arial;mso-bidi-font-family:Arial;color:blue;<br class=textdoc  />mso-fareast-language:ZH-CN\'>&#24180;&#36215;&#31649;&#29702;&#20854;&#38598;&#35013;&#31665;&#36164;&#20135;&#12290;</span><span<br class=textdoc  />lang=EN-US style=\'font-size:11.0pt;font-family:Arial;color:blue;mso-ansi-language:<br class=textdoc  />EN-US;mso-fareast-language:ZH-CN\'>GKS</span><span  lang=ZH-CN style=\'font-size:<br class=textdoc  />11.0pt;font-family:SimSun;mso-ascii-font-family:Arial;mso-hansi-font-family:<br class=textdoc  />Arial;mso-bidi-font-family:Arial;color:blue;mso-fareast-language:ZH-CN\'>&#26071;&#19979;&#21253;&#25324;</span><span<br class=textdoc  />lang=EN-US style=\'font-size:11.0pt;font-family:Arial;color:blue;mso-ansi-language:<br class=textdoc  />EN-US;mso-fareast-language:ZH-CN\'>7</span><span  lang=ZH-CN style=\'font-size:<br class=textdoc  />11.0pt;font-family:SimSun;mso-ascii-font-family:Arial;mso-hansi-font-family:<br class=textdoc  />Arial;mso-bidi-font-family:Arial;color:blue;mso-ansi-language:EN-US;mso-fareast-language:<br class=textdoc  />ZH-CN\'>&#20010;&#20195;&#29702;&#21644;&#29289;&#27969;&#36816;&#36755;&#20844;&#21496;&#65292;&#22312;&#20420;&#32599;&#26031;&#25152;&#26377;&#22823;&#30340;&#28207;&#21475;&#21644;&#22320;&#21306;&#65292;&#20197;&#21450;&#29420;&#32852;&#20307;&#21644;&#20854;&#20182;&#22320;&#21306;&#37117;&#26377;&#19994;&#21153;&#12290;</span><span<br class=textdoc  />lang=EN-US style=\'font-size:11.0pt;font-family:Arial;color:blue;mso-ansi-language:<br class=textdoc  />EN-US;mso-fareast-language:ZH-CN\'><o:p></o:p></span></p></p><p class=textdoc ><p  class=MsoNormal style=\'text-align:justify;text-justify:inter-ideograph\'><span<br class=textdoc  />lang=EN-US style=\'font-size:11.0pt;font-family:Arial;mso-ansi-language:EN-US;<br class=textdoc  />mso-fareast-language:ZH-CN\'><o:p>&nbsp;</o:p></span></p></p><p class=textdoc ><p  class=MsoNormal style=\'text-align:justify;text-justify:inter-ideograph\'><span<br class=textdoc  />lang=EN-US style=\'font-size:11.0pt;font-family:Arial;color:blue;mso-ansi-language:<br class=textdoc  />EN-US;mso-fareast-language:ZH-CN\'>GKS</span><span  lang=ZH-CN style=\'font-size:<br class=textdoc  />11.0pt;font-family:SimSun;mso-ascii-font-family:Arial;mso-hansi-font-family:<br class=textdoc  />Arial;mso-bidi-font-family:Arial;color:blue;mso-fareast-language:ZH-CN\'>&#30340;&#36164;&#20135;&#24635;&#37327;&#36229;&#36807;</span><span<br class=textdoc  />lang=EN-US style=\'font-size:11.0pt;font-family:Arial;color:blue;mso-ansi-language:<br class=textdoc  />EN-US;mso-fareast-language:ZH-CN\'>5000</span><span  lang=ZH-CN style=\'font-size:<br class=textdoc  />11.0pt;font-family:SimSun;mso-ascii-font-family:Arial;mso-hansi-font-family:<br class=textdoc  />Arial;mso-bidi-font-family:Arial;color:blue;mso-fareast-language:ZH-CN\'>&#19975;&#32654;&#22278;</span><span<br class=textdoc  />lang=ZH-CN style=\'font-size:11.0pt;font-family:SimSun;mso-ascii-font-family:<br class=textdoc  />Arial;mso-hansi-font-family:Arial;mso-bidi-font-family:Arial;color:blue;<br class=textdoc  />mso-ansi-language:EN-US;mso-fareast-language:ZH-CN\'>&#65292;</span><span<br class=textdoc  />lang=ZH-CN style=\'font-size:11.0pt;font-family:SimSun;mso-ascii-font-family:<br class=textdoc  />Arial;mso-hansi-font-family:Arial;mso-bidi-font-family:Arial;color:blue;<br class=textdoc  />mso-fareast-language:ZH-CN\'>&#33829;&#19994;&#39069;&#36229;&#36807;</span><span<br class=textdoc  />lang=EN-US style=\'font-size:11.0pt;font-family:Arial;color:blue;mso-ansi-language:<br class=textdoc  />EN-US;mso-fareast-language:ZH-CN\'>6000</span><span  lang=ZH-CN style=\'font-size:<br class=textdoc  />11.0pt;font-family:SimSun;mso-ascii-font-family:Arial;mso-hansi-font-family:<br class=textdoc  />Arial;mso-bidi-font-family:Arial;color:blue;mso-fareast-language:ZH-CN\'>&#19975;&#32654;&#22278;&#12290;</span><span<br class=textdoc  />style=\'font-size:11.0pt;font-family:Arial;color:blue;mso-fareast-language:ZH-CN\'>GKS</span><span<br class=textdoc  />lang=ZH-CN style=\'font-size:11.0pt;font-family:SimSun;mso-ascii-font-family:<br class=textdoc  />Arial;mso-hansi-font-family:Arial;mso-bidi-font-family:Arial;color:blue;<br class=textdoc  />mso-fareast-language:ZH-CN\'>&#30340;&#36817;&#26399;&#35745;&#21010;&#26159;—&#32487;&#32493;&#25193;&#24352;&#65292;&#26080;&#35770;&#26159;&#20844;&#21496;&#25968;&#37327;&#21644;&#36816;&#21147;&#26041;&#38754;&#65292;&#36824;&#26159;&#22312;&#20420;&#32599;&#26031;&#21644;&#20854;&#20182;&#22269;&#23478;&#25552;&#20379;&#30340;&#36816;&#36755;&#26381;&#21153;&#37327;&#26041;&#38754;&#12290;</span><span<br class=textdoc  />style=\'font-size:11.0pt;font-family:Arial;color:blue;mso-fareast-language:ZH-CN\'><o:p></o:p></span></p></p><p class=textdoc ><p  class=MsoNormal style=\'text-align:justify;text-justify:inter-ideograph\'><span<br class=textdoc  />style=\'font-size:11.0pt;font-family:Arial;mso-fareast-language:ZH-CN\'><o:p>&nbsp;</o:p></span></p></p><p class=textdoc ><p  class=MsoNormal style=\'text-align:justify;text-justify:inter-ideograph\'><span<br class=textdoc  />style=\'font-size:11.0pt;font-family:Arial;color:blue;mso-fareast-language:ZH-CN\'><o:p>&nbsp;</o:p></span></p></p><p class=textdoc ><p  class=MsoNormal style=\'text-align:justify;text-justify:inter-ideograph\'><span<br class=textdoc  />style=\'font-size:11.0pt;font-family:Arial;color:blue;mso-fareast-language:ZH-CN\'><o:p>&nbsp;</o:p></span></p></p><p class=textdoc ><p  class=MsoNormal style=\'text-align:justify;text-justify:inter-ideograph\'><span<br class=textdoc  />style=\'font-size:11.0pt;font-family:Arial;color:blue;mso-fareast-language:ZH-CN\'>GKS</span><span<br class=textdoc  />lang=ZH-CN style=\'font-size:11.0pt;font-family:SimSun;mso-ascii-font-family:<br class=textdoc  />Arial;mso-hansi-font-family:Arial;mso-bidi-font-family:Arial;color:blue;<br class=textdoc  />mso-fareast-language:ZH-CN\'>&#30340;&#20027;&#35201;&#32463;&#33829;&#26041;&#21521;&#21253;&#25324;&#20102;&#20844;&#21496;&#31649;&#29702;&#65292;&#25112;&#30053;&#35745;&#21010;&#21644;&#38598;&#22242;&#20869;&#20225;&#19994;&#21644;&#36164;&#20135;&#30340;&#21457;&#23637;&#12290;&#25105;&#20204;&#24037;&#20316;&#26368;&#37325;&#35201;&#30340;&#20248;&#20808;&#26041;&#21521;&#26159;&#22312;&#20420;&#32599;&#26031;&#24066;&#22330;&#19978;&#37319;&#29992;&#26368;&#20808;&#36827;&#30340;&#38598;&#35013;&#31665;&#36816;&#36755;&#25216;&#26415;&#65292;&#32500;&#25252;&#23458;&#25143;&#65292;&#20249;&#20276;&#21644;&#32929;&#19996;&#21033;&#30410;&#65292;&#19981;&#26029;&#23436;&#21892;&#25152;&#25552;&#20379;&#30340;&#26381;&#21153;&#12290;</span><span<br class=textdoc  />style=\'font-size:11.0pt;font-family:Arial;color:blue;mso-fareast-language:ZH-CN\'><o:p></o:p></span></p></p><p class=textdoc ><p  class=MsoNormal style=\'text-align:justify;text-justify:inter-ideograph\'><span<br class=textdoc  />style=\'font-size:11.0pt;font-family:Arial;color:blue;mso-fareast-language:ZH-CN\'><o:p>&nbsp;</o:p></span></p></p><p class=textdoc ><p  class=MsoNormal style=\'text-align:justify;text-justify:inter-ideograph\'><span<br class=textdoc  />style=\'font-size:11.0pt;font-family:Arial;color:blue;mso-fareast-language:ZH-CN\'><o:p>&nbsp;</o:p></span></p></p><p class=textdoc ><p  class=MsoNormal style=\'text-align:justify;text-justify:inter-ideograph\'><span<br class=textdoc  />style=\'font-size:11.0pt;font-family:Arial;color:blue;mso-fareast-language:ZH-CN\'>GKS</span><span<br class=textdoc  />lang=ZH-CN style=\'font-size:11.0pt;font-family:SimSun;mso-ascii-font-family:<br class=textdoc  />Arial;mso-hansi-font-family:Arial;mso-bidi-font-family:Arial;color:blue;<br class=textdoc  />mso-fareast-language:ZH-CN\'>&#30340;&#25112;&#30053;&#38382;&#39064;&#26159;&#36890;&#36807;&#24314;&#31435;&#35206;&#30422;&#20420;&#32599;&#26031;&#21644;&#19990;&#30028;&#20219;&#20309;&#19968;&#20010;&#28857;&#30340;&#19981;&#38388;&#26029;&#38598;&#35013;&#31665;&#36816;&#36755;&#22402;&#30452;&#19968;&#20307;&#21270;&#31995;&#32479;&#65292;&#22312;&#26410;&#26469;</span><span<br class=textdoc  />style=\'font-size:11.0pt;font-family:Arial;color:blue;mso-fareast-language:ZH-CN\'>5</span><span<br class=textdoc  />lang=ZH-CN style=\'font-size:11.0pt;font-family:SimSun;mso-ascii-font-family:<br class=textdoc  />Arial;mso-hansi-font-family:Arial;mso-bidi-font-family:Arial;color:blue;<br class=textdoc  />mso-fareast-language:ZH-CN\'>&#24180;&#20869;&#23558;&#33829;&#19994;&#39069;&#25552;&#39640;</span><span<br class=textdoc  />style=\'font-size:11.0pt;font-family:Arial;color:blue;mso-fareast-language:ZH-CN\'>2</span><span<br class=textdoc  />lang=ZH-CN style=\'font-size:11.0pt;font-family:SimSun;mso-ascii-font-family:<br class=textdoc  />Arial;mso-hansi-font-family:Arial;mso-bidi-font-family:Arial;color:blue;<br class=textdoc  />mso-fareast-language:ZH-CN\'>&#20493;&#65292;&#23558;&#36816;&#36755;&#37327;&#25552;&#39640;</span><span<br class=textdoc  />style=\'font-size:11.0pt;font-family:Arial;color:blue;mso-fareast-language:ZH-CN\'>1</span><span<br class=textdoc  />lang=ZH-CN style=\'font-size:11.0pt;font-family:SimSun;mso-ascii-font-family:<br class=textdoc  />Arial;mso-hansi-font-family:Arial;mso-bidi-font-family:Arial;color:blue;<br class=textdoc  />mso-fareast-language:ZH-CN\'>&#20493;&#12290;&#35299;&#20915;&#36825;&#19968;&#38382;&#39064;&#65292;&#25105;&#20204;&#20381;&#38752;&#30340;&#26159;&#36817;</span><span<br class=textdoc  />style=\'font-size:11.0pt;font-family:Arial;color:blue;mso-fareast-language:ZH-CN\'>400</span><span<br class=textdoc  />lang=ZH-CN style=\'font-size:11.0pt;font-family:SimSun;mso-ascii-font-family:<br class=textdoc  />Arial;mso-hansi-font-family:Arial;mso-bidi-font-family:Arial;color:blue;<br class=textdoc  />mso-fareast-language:ZH-CN\'>&#20010;&#33258;&#26377;&#21592;&#24037;&#30340;&#39640;&#24230;&#19987;&#19994;&#27700;&#20934;&#65292;&#20197;&#21450;&#19982;&#20420;&#32599;&#26031;&#21644;&#22269;&#38469;&#20027;&#35201;&#36816;&#36755;&#20844;&#21496;&#30340;&#32039;&#23494;&#30340;&#20249;&#20276;&#20851;&#31995;&#12290;</span><span<br class=textdoc  />style=\'font-size:11.0pt;font-family:Arial;color:blue;mso-fareast-language:ZH-CN\'><o:p></o:p></span></p></p><p class=textdoc ><p  class=MsoNormal><span  style=\'font-size:11.0pt;font-family:Arial;color:blue;<br class=textdoc  />mso-fareast-language:ZH-CN\'><o:p>&nbsp;</o:p></span></p></p><p class=textdoc ><p  class=MsoNormal><span  lang=ZH-CN style=\'font-size:11.0pt;font-family:SimSun;<br class=textdoc  />mso-ascii-font-family:Arial;mso-hansi-font-family:Arial;mso-bidi-font-family:<br class=textdoc  />Arial;color:blue;mso-fareast-language:ZH-CN\'>&#22312;&#20420;&#32599;&#26031;&#36816;&#36755;&#24066;&#22330;&#19978;&#32463;&#33829;&#20102;</span><span<br class=textdoc  />style=\'font-size:11.0pt;font-family:Arial;color:blue;mso-fareast-language:ZH-CN\'>12</span><span<br class=textdoc  />lang=ZH-CN style=\'font-size:11.0pt;font-family:SimSun;mso-ascii-font-family:<br class=textdoc  />Arial;mso-hansi-font-family:Arial;mso-bidi-font-family:Arial;color:blue;<br class=textdoc  />mso-fareast-language:ZH-CN\'>&#24180;&#22810;&#65292;&#25105;&#20204;&#33268;&#21147;&#20110;&#19981;&#26029;&#24320;&#36767;&#22269;&#38469;&#36152;&#26131;&#30340;&#26032;&#39046;&#22495;&#65292;&#22312;&#20154;&#20204;&#65292;&#20844;&#21496;&#21644;&#21508;&#22269;&#20043;&#38388;&#24314;&#31435;&#21512;&#20316;&#21644;&#20114;&#24800;&#29983;&#24847;&#30340;&#26725;&#26753;&#12290;</span><span<br class=textdoc  />style=\'color:blue;mso-fareast-language:ZH-CN\'><o:p></o:p></span></p></p><p class=textdoc ></div></p><p class=textdoc ></body></p><p class=textdoc ></html><br class=textdoc  /></p>',21);
INSERT INTO `engine_TEXTDOC` VALUES (1385,'',8);
INSERT INTO `engine_TEXTDOC` VALUES (1367,'<p  class=\"textdoc\">Компании, входящие в ГКС являются активными участниками ряда транспортных ассоциаций и организаций.</p><p  class=\"textdoc\" /><p  class=\"textdoc\"><table  border=\"0\" class=\"textdoc\"><tbody  class=\"textdoc\"><tr class=textdoc_tr1  class=\"textdoc_tr1\"><td  class=\"textdoc\"><p  class=\"textdoc\"><shapetype  id=\"_x0000_t75\" stroked=\"f\" filled=\"f\" path=\"m@4@5l@4@11@9@11@9@5xe\" o:preferrelative=\"t\" o:spt=\"75\" coordsize=\"21600,21600\" class=\"textdoc\" /><stroke  joinstyle=\"miter\" class=\"textdoc\" /><formulas  class=\"textdoc\" /><f  eqn=\"if lineDrawn pixelLineWidth 0\" class=\"textdoc\" /><f  eqn=\"sum @0 1 0\" class=\"textdoc\" /><f  eqn=\"sum 0 0 @1\" class=\"textdoc\" /><f  eqn=\"prod @2 1 2\" class=\"textdoc\" /><f  eqn=\"prod @3 21600 pixelWidth\" class=\"textdoc\" /><f  eqn=\"prod @3 21600 pixelHeight\" class=\"textdoc\" /><f  eqn=\"sum @0 0 1\" class=\"textdoc\" /><f  eqn=\"prod @6 1 2\" class=\"textdoc\" /><f  eqn=\"prod @7 21600 pixelWidth\" class=\"textdoc\" /><f  eqn=\"sum @8 21600 0\" class=\"textdoc\" /><f  eqn=\"prod @7 21600 pixelHeight\" class=\"textdoc\" /><f  eqn=\"sum @10 21600 0\" class=\"textdoc\" /></formulas /><path  o:connecttype=\"rect\" gradientshapeok=\"t\" o:extrusionok=\"f\" class=\"textdoc\" /><lock  aspectratio=\"t\" v:ext=\"edit\" class=\"textdoc\" /></shapetype /><shape  id=\"_x0000_s1026\" type=\"#_x0000_t75\" o:button=\"t\" wrapcoords=\"-318 0 -318 21257 21600 21257 21600 0 -318 0\" href=\"http://www.urama.ru/\" alt=\"\" class=\"textdoc\" /><fill  o:detectmouseclick=\"t\" class=\"textdoc\" /><imagedata  o:title=\"urama_logo\" src=\"file:///C:/DOCUME~1/OKAZAK~1/LOCALS~1/Temp/msoclip1/01/clip_image001.png\" class=\"textdoc\" /><wrap  type=\"tight\" class=\"textdoc\" /></shape />Южно-Российская Ассоциация Морских Агентств </p></td><td  class=\"textdoc\"><img  src=\"/engine/doc_images/image036.gif\" class=\"textdoc\" /></td></tr><tr class=textdoc_tr2  class=\"textdoc_tr2\"><td  class=\"textdoc\">Ассоциация Экспедиторов Российской Федерации</td><td  class=\"textdoc\"><img  src=\"/engine/doc_images/image038.gif\" class=\"textdoc\" /></td></tr><tr class=textdoc_tr1  class=\"textdoc_tr1\"><td  class=\"textdoc\">Международная федерация экспедиторских ассоциаций ФИАТА</td><td  class=\"textdoc\"><img  src=\"/engine/doc_images/image040.jpg\" class=\"textdoc\" /></td></tr><tr class=textdoc_tr2  class=\"textdoc_tr2\"><td  class=\"textdoc\">Транспортный клуб взаимного страхования&nbsp; </td><td  class=\"textdoc\"><img  src=\"/engine/doc_images/image042.gif\" class=\"textdoc\" /></td></tr></tbody></table></p>',12);
INSERT INTO `engine_TEXTDOC` VALUES (1457,'<p  align=\"justify\" class=\"textdoc\">Компания Рускон является одним из крупнейших транспортных экспедиторов и операторов контейнерных перевозок на территории РФ. Профессиональная команда Рускон, насчитывающая сегодня более 300 высококвалифицированных специалистов в 9 региональных офисах, &nbsp;ежегодно обслуживает до 150&nbsp;000 TEU.</p><p  align=\"justify\" class=\"textdoc\" /><p  align=\"justify\" class=\"textdoc\">Опираясь на собственные транспортные активы ГКС, а также партнёрские связи с ведущими транспортными организациями в России и за рубежом, Рускон оказывает широкий спектр профессиональных услуг по доставке и перевалке контейнеров. В том числе компания осуществляет организацию морского фрахта, перевозку контейнеров автотранспортом и контейнерными поездами, экспедирование и перевалку на портовых и припортовых терминалах.</p><p  align=\"justify\" class=\"textdoc\" /><p  align=\"justify\" class=\"textdoc\">Рускон гарантирует индивидуальный подход к каждому клиенту, предоставляя персональных менеджеров, курирующих перевозки клиента от А до Я и круглосуточно доступных для решениях всех оперативных вопросов. Предлагая надежную доставку по оптимальным ценам мы стремимся предлагать транспортные решения максимально отвечающие специфике именно Вашего бизнеса. </p><p  align=\"justify\" class=\"textdoc\" /><p  align=\"justify\" class=\"textdoc\">Передовая информационная система Рускон не только позволяет клиентам отслеживать движение их контейнеров, но и обеспечивает достоверную оценку и планирование сроков и дальнейшего маршрута доставки. Наша компания выгодно отличаемся тем, что не только всегда знает местонахождение и состояние груза, но и эффективно предотвращает возможные простои и риски непредвиденных издержек. </p><p  align=\"justify\" class=\"textdoc\" /><p  align=\"justify\" class=\"textdoc\">Мы с уверенностью смотрим на перспективы контейнерных перевозок в России. Ориентируясь на возможно полное удовлетворение растущих запросов клиентов, Рускон постоянно совершенствует уровень оказываемых услуг, внедряя наиболее современные технологии и стандарты перевозки и перевалки грузов в контейнерах. Успех наших клиентов в сфере международных перевозок прочно основывается на творческом подходе к работе, высоких профессиональных и этических качествах специалистов Рускона.</p>',15);
INSERT INTO `engine_TEXTDOC` VALUES (1366,'<p  class=\"textdoc\">Компании ГКС обслуживают контейнерные перевозки крупнейших российских и международных компаний.</p><p  class=\"textdoc\"><img  src=\"/engine/doc_images/image010.gif\" class=\"textdoc\" /></p><p  class=\"textdoc\"><a  href=\"http://www.lukoil.ru/\" target=\"_blank\" class=\"textdoc\"><img  height=\"53\" src=\"/engine/doc_images/image012.gif\" width=\"187\" border=\"0\" class=\"textdoc\" /></a>&nbsp;<a  href=\"http://www.rusal.ru/index.php?lang=rus\" target=\"_blank\" class=\"textdoc\"><img  height=\"54\" src=\"/engine/doc_images/image013.gif\" width=\"119\" border=\"0\" class=\"textdoc\" /></a>&nbsp; <a  href=\"http://ru.lge.com/index.do\" target=\"_blank\" class=\"textdoc\"><img  height=\"76\" src=\"/engine/doc_images/image014.gif\" width=\"140\" border=\"0\" class=\"textdoc\" /></a></p><p  class=\"textdoc\">Нашими основными партнёрами по организации морских перевозок являются международные контейнерные линии:</p><p  class=\"textdoc\"><img  src=\"/engine/doc_images/image020.gif\" class=\"textdoc\" /></p><p  class=\"textdoc\"><a  href=\"http://hapag-lloyd.ru/\" target=\"_blank\" class=\"textdoc\"><img  height=\"26\" src=\"/engine/doc_images/image023.jpg\" width=\"168\" border=\"0\" class=\"textdoc\" /></a>&nbsp;&nbsp; <img  src=\"/engine/doc_images/image025.gif\" class=\"textdoc\" />&nbsp; <img  src=\"/engine/doc_images/image027.gif\" class=\"textdoc\" />&nbsp; <img  src=\"/engine/doc_images/image029.gif\" class=\"textdoc\" /></p><p  class=\"textdoc\">ГКС поддерживает давние деловые и партнёрские отношения с основными портовыми контейнерными терминалами РФ:</p><p  class=\"textdoc\"><img  src=\"/engine/doc_images/image031.gif\" class=\"textdoc\" />&nbsp;&nbsp; <img  src=\"/engine/doc_images/image033.gif\" class=\"textdoc\" />&nbsp;&nbsp;&nbsp;&nbsp;<img  src=\"/engine/doc_images/plp.jpg\" class=\"textdoc\" /></p><p  class=\"textdoc\" />',10);
INSERT INTO `engine_TEXTDOC` VALUES (1449,'Praesent ut neque. Maecenas neque risus, fermentum sit amet, volutpat dictum, pellentesque nec, orci. Suspendisse potenti. Phasellus a urna. Mauris a nibh. Morbi dignissim neque sed metus. Suspendisse ac lacus. Nulla ligula enim, tempus sit amet, porttitor vitae, dictum non, libero. Nunc ut mi ac orci aliquam scelerisque. Nam nec elit a tortor nonummy dictum. Nam mollis. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Donec leo. Vestibulum feugiat risus sed risus. <br  class=\"textdoc\" /><br  class=\"textdoc\" />Fusce porta, orci vel feugiat pharetra, est nunc fringilla mauris, ac suscipit quam quam et arcu. Donec iaculis pede ac velit. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos hymenaeos. Sed pellentesque. Ut quis velit. Quisque blandit dolor non magna. Nunc dapibus varius diam. Aliquam nisi metus, interdum a, varius at, hendrerit vitae, mi. Suspendisse eleifend nulla id velit eleifend fringilla. Ut blandit adipiscing diam. <br  class=\"textdoc\" /><br  class=\"textdoc\" />Ut tempor lectus nec magna. Proin eu mauris nec ipsum ultrices ultricies. Aliquam porta. Vivamus magna. In sit amet urna. Cras ac odio. Integer sollicitudin dui vitae velit. Pellentesque eu elit et nibh gravida auctor. Morbi nec mi sit amet neque malesuada auctor. Etiam est dolor, ultrices id, vestibulum rutrum, molestie vel, est. Nam pharetra sem accumsan nisl. Cras sit amet mi. Sed facilisis. Morbi sagittis vestibulum purus. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos hymenaeos. Vivamus blandit. Pellentesque commodo arcu sit amet dui. <br  class=\"textdoc\" /><br  class=\"textdoc\" />Etiam lacinia mattis nisi. In pharetra tincidunt lacus. Praesent vel nisi id mi tincidunt varius. Proin iaculis. Cras metus. Phasellus tristique pellentesque urna. Fusce ultricies gravida nulla. Nulla facilisis quam sed felis. Vivamus porta sollicitudin metus. In et pede. Integer dictum vulputate ipsum. Nulla lorem. Praesent cursus, dolor id sagittis ornare, lectus ante faucibus leo, ac vestibulum mi mauris ut neque. Cras leo purus, blandit convallis, lacinia nec, varius ac, dolor. Mauris faucibus tincidunt dui. Maecenas venenatis felis sit amet libero. Etiam quis elit in nunc sodales tempus. Proin scelerisque ligula id orci. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos hymenaeos. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean aliquam blandit risus. Quisque interdum dictum nisl. Ut mollis, risus ac aliquam fermentum, sem pede consectetuer quam, iaculis sollicitudin elit nunc eu ipsum. Pellentesque a diam. Maecenas lectus sapien, iaculis ac, fermentum sed, rhoncus et, eros. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Maecenas sed lorem a mi posuere posuere. Nullam ipsum. Phasellus massa leo, tristique in, facilisis a, pharetra nec, nisi. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos hymenaeos. Maecenas auctor sapien in velit. Nam in arcu at magna viverra ultrices. Sed dignissim vehicula sapien. ',16);
INSERT INTO `engine_TEXTDOC` VALUES (1386,'',27);
INSERT INTO `engine_TEXTDOC` VALUES (1454,'<p  align=\"justify\" class=\"textdoc\">Компании ГКС обслуживают контейнерные перевозки крупнейших российских и международных компаний.</p><p  align=\"justify\" class=\"textdoc\"><img  src=\"/engine/doc_images/image010.gif\" class=\"textdoc\" /></p><p  align=\"justify\" class=\"textdoc\"><a  href=\"http:/www.lukoil.ru/\" target=\"_blank\" class=\"textdoc\"><img  height=\"53\" src=\"/engine/doc_images/image012.gif\" width=\"187\" border=\"0\" class=\"textdoc\" /></a>&nbsp;<a  href=\"http:/www.rusal.ru/index.php?lang=rus\" target=\"_blank\" class=\"textdoc\"><img  height=\"54\" src=\"/engine/doc_images/image013.gif\" width=\"119\" border=\"0\" class=\"textdoc\" /></a>&nbsp; <a  href=\"http:/ru.lge.com/index.do\" target=\"_blank\" class=\"textdoc\"><img  height=\"76\" src=\"/engine/doc_images/image014.gif\" width=\"140\" border=\"0\" class=\"textdoc\" /></a></p><p  align=\"justify\" class=\"textdoc\">Нашими основными партнёрами по организации морских перевозок являются международные контейнерные линии:</p><p  align=\"justify\" class=\"textdoc\"><img  src=\"/engine/doc_images/image020.gif\" class=\"textdoc\" /></p><p  align=\"justify\" class=\"textdoc\"><a  href=\"http:/hapag-lloyd.ru/\" target=\"_blank\" class=\"textdoc\"><img  height=\"26\" src=\"/engine/doc_images/image023.jpg\" width=\"168\" border=\"0\" class=\"textdoc\" /></a>&nbsp;&nbsp; <img  src=\"/engine/doc_images/image025.gif\" class=\"textdoc\" />&nbsp; <img  src=\"/engine/doc_images/image027.gif\" class=\"textdoc\" />&nbsp; <img  src=\"/engine/doc_images/image029.gif\" class=\"textdoc\" /></p><p  align=\"justify\" class=\"textdoc\">ГКС поддерживает давние деловые и партнёрские отношения с основными портовыми контейнерными терминалами РФ:</p><p  align=\"justify\" class=\"textdoc\"><img  src=\"/engine/doc_images/image031.gif\" class=\"textdoc\" />&nbsp;&nbsp; <img  src=\"/engine/doc_images/image033.gif\" class=\"textdoc\" />&nbsp;&nbsp;&nbsp;&nbsp;<img  src=\"/engine/doc_images/plp.jpg\" class=\"textdoc\" /></p>',34);
INSERT INTO `engine_TEXTDOC` VALUES (1455,'<p  align=\"justify\" class=\"textdoc\">Компании, входящие в ГКС являются активными участниками ряда транспортных ассоциаций и организаций.</p><p  align=\"justify\" class=\"textdoc\" /><p  align=\"justify\" class=\"textdoc\"><table  border=\"0\" class=\"textdoc\"><tbody  class=\"textdoc\"><tr class=textdoc_tr1  class=\"textdoc_tr1\"><td  class=\"textdoc\"><p  class=\"textdoc\"><shapetype  id=\"_x0000_t75\" stroked=\"f\" filled=\"f\" path=\"m@4@5l@4@11@9@11@9@5xe\" o:preferrelative=\"t\" o:spt=\"75\" coordsize=\"21600,21600\" class=\"textdoc\" /><stroke  joinstyle=\"miter\" class=\"textdoc\" /><formulas  class=\"textdoc\" /><f  eqn=\"if lineDrawn pixelLineWidth 0\" class=\"textdoc\" /><f  eqn=\"sum @0 1 0\" class=\"textdoc\" /><f  eqn=\"sum 0 0 @1\" class=\"textdoc\" /><f  eqn=\"prod @2 1 2\" class=\"textdoc\" /><f  eqn=\"prod @3 21600 pixelWidth\" class=\"textdoc\" /><f  eqn=\"prod @3 21600 pixelHeight\" class=\"textdoc\" /><f  eqn=\"sum @0 0 1\" class=\"textdoc\" /><f  eqn=\"prod @6 1 2\" class=\"textdoc\" /><f  eqn=\"prod @7 21600 pixelWidth\" class=\"textdoc\" /><f  eqn=\"sum @8 21600 0\" class=\"textdoc\" /><f  eqn=\"prod @7 21600 pixelHeight\" class=\"textdoc\" /><f  eqn=\"sum @10 21600 0\" class=\"textdoc\" /></formulas /><path  o:connecttype=\"rect\" gradientshapeok=\"t\" o:extrusionok=\"f\" class=\"textdoc\" /><lock  aspectratio=\"t\" v:ext=\"edit\" class=\"textdoc\" /></shapetype /><shape  id=\"_x0000_s1026\" type=\"#_x0000_t75\" o:button=\"t\" wrapcoords=\"-318 0 -318 21257 21600 21257 21600 0 -318 0\" href=\"http:/www.urama.ru/\" alt=\"\" class=\"textdoc\" /><fill  o:detectmouseclick=\"t\" class=\"textdoc\" /><imagedata  o:title=\"urama_logo\" src=\"file://C:/DOCUME~1/OKAZAK~1/LOCALS~1/Temp/msoclip1/01/clip_image001.png\" class=\"textdoc\" /><wrap  type=\"tight\" class=\"textdoc\" /></shape />Южно-Российская Ассоциация Морских Агентств </p></td><td  class=\"textdoc\"><img  src=\"/engine/doc_images/image036.gif\" class=\"textdoc\" /></td></tr><tr class=textdoc_tr2  class=\"textdoc_tr2\"><td  class=\"textdoc\">Ассоциация Экспедиторов Российской Федерации</td><td  class=\"textdoc\"><img  src=\"/engine/doc_images/image038.gif\" class=\"textdoc\" /></td></tr><tr class=textdoc_tr1  class=\"textdoc_tr1\"><td  class=\"textdoc\">Международная федерация экспедиторских ассоциаций ФИАТА</td><td  class=\"textdoc\"><img  src=\"/engine/doc_images/image040.jpg\" class=\"textdoc\" /></td></tr><tr class=textdoc_tr2  class=\"textdoc_tr2\"><td  class=\"textdoc\">Транспортный клуб взаимного страхования&nbsp; </td><td  class=\"textdoc\"><img  src=\"/engine/doc_images/image042.gif\" class=\"textdoc\" /></td></tr></tbody></table></p>',35);
INSERT INTO `engine_TEXTDOC` VALUES (1453,'<p  align=\"justify\" class=\"textdoc\"><strong  class=\"textdoc\">ПРОФЕССИОНАЛИЗМ <p  align=\"justify\" class=\"textdoc\" /></strong></p><p  align=\"justify\" class=\"textdoc\" /><p  align=\"justify\" class=\"textdoc\" /><p  align=\"justify\" class=\"textdoc\">Высокий профессионализм и безупречная деловая репутация ГКС – залог успеха наших клиентов. Мы предлагаем только отработанные и многократно проверенные нами транспортные схемы, способные гарантировать 100% качество и надежность перевозок.</p><p  align=\"justify\" class=\"textdoc\" /><p  align=\"justify\" class=\"textdoc\" /><p  align=\"justify\" class=\"textdoc\" /><p  align=\"justify\" class=\"textdoc\"><strong  class=\"textdoc\">ОТКРЫТОСТЬ <p  align=\"justify\" class=\"textdoc\" /></strong></p><p  align=\"justify\" class=\"textdoc\" /><p  align=\"justify\" class=\"textdoc\" /><p  align=\"justify\" class=\"textdoc\">В работе с клиентами мы стремимся к максимальной открытости и взаимному доверию. Нашим ориентиром является долгосрочное сотрудничество, которое достигается максимальной прозрачностью и строгим следованием нормам деловой этики. Мы открыты к постоянному диалогу с клиентами и партнёрами, видя в них главную опору нашего бизнеса.</p><p  align=\"justify\" class=\"textdoc\" /><p  align=\"justify\" class=\"textdoc\" /><p  align=\"justify\" class=\"textdoc\" /><p  align=\"justify\" class=\"textdoc\"><strong  class=\"textdoc\">ИННОВАЦИИ <p  align=\"justify\" class=\"textdoc\" /></strong></p><p  align=\"justify\" class=\"textdoc\" /><p  align=\"justify\" class=\"textdoc\" /><p  align=\"justify\" class=\"textdoc\">Мы стремимся к постоянному совершенствованию услуг и использованию передовых транспортных технологий. ГКС является одним из лидеров российской контейнерной отрасли по объемам инвестиций в современную инфраструктуру, транспортные средства, информационные и управленческие системы. Ежегодно внедряемые нами инновации в вариантах перевалки и доставки контейнерных грузов помогают нашим клиентам открывать и реализовывать новые внешнеторговые возможности в России и за рубежом.</p><p  align=\"justify\" class=\"textdoc\" /><p  align=\"justify\" class=\"textdoc\" /><p  align=\"justify\" class=\"textdoc\" /><p  align=\"justify\" class=\"textdoc\"><strong  class=\"textdoc\">ЛЮДИ <p  align=\"justify\" class=\"textdoc\" /></strong></p><p  align=\"justify\" class=\"textdoc\" /><p  align=\"justify\" class=\"textdoc\" /><p  align=\"justify\" class=\"textdoc\">Люди – наш главная ценность и важнейший актив. ГКС приветствует среди своих сотрудников инициативу и постоянное стремление к совершенствованию, предлагая им широкие возможности для профессионального роста, обучения и самореализации в рамках компании. Заботясь о благополучии наших работников, мы развиваем их чуткий подход к нуждам и запросам клиентов. </p>',31);
INSERT INTO `engine_TEXTDOC` VALUES (1456,'<p  align=\"justify\" class=\"textdoc\">ГКС являются совладельцем ряда агентских компаний, представляющих на территории РФ интересы ведущих международных контейнерных линий.</p><p  align=\"justify\" class=\"textdoc\" /><p  align=\"justify\" class=\"textdoc\">Мы располагаем обширным опытом работы в данной сфере морских перевозок с 1995 года. Сегодня агентские офисы компаний ГКС работают в крупнейших контейнерных портах России, обслуживая контейнеропоток&nbsp;в объеме более 100&nbsp;000 TEU в год.</p><p  align=\"justify\" class=\"textdoc\" /><p  align=\"justify\" class=\"textdoc\">Неоспоримым преимуществом ГКС является солидная репутация надежного линейного агента, высокая деловая этика, а также передовые стандарты качества, полностью отвечающие, как высоким запросам наших партнёров, так и местным условиям транспортного бизнеса.</p><p  align=\"justify\" class=\"textdoc\" /><p  align=\"justify\" class=\"textdoc\">ГКС обеспечивает линиям-принципалам наиболее широкий и надёжный доступ к транспортной инфраструктуре в российских портах и внутри страны, благодаря собственным транспортным активам группы, а также обширной сети представительств на территории России и СНГ.</p><p  align=\"justify\" class=\"textdoc\" /><p  align=\"justify\" class=\"textdoc\">Опираясь на свой обширный опыт и давние деловые связи с ведущими участниками внешней торговли, линейные агентства ГКС открывают своим принципалам возможности прямого взаимовыгодного диалога с крупнейшими российскими грузовладельцами.</p><p  class=\"textdoc\" />',14);
INSERT INTO `engine_TEXTDOC` VALUES (1393,'',47);
INSERT INTO `engine_TEXTDOC` VALUES (1458,'<p  align=\"justify\" class=\"textdoc\">Холдинг ГКС выступает крупнейшим партнёром и совладельцем ряда ведущих российских портовых операторов. Опираясь на обширный опыт тесной работы и сотрудничества с портовиками, компании, входящие в ГКС, гарантируют своим клиентам высокий уровень сервиса и предлагают самые широкие возможности по обработке контейнеров в портах Санкт-Петербурга, Новороссийска, Калининграда и Восточного.</p><p  align=\"justify\" class=\"textdoc\" /><p  align=\"justify\" class=\"textdoc\">В состав ГКС входят специализированные припортовые терминалы в Новороссийске и Санкт-Петербурге, осуществляющие полный комплекс работ и услуг по перевалке и хранению контейнеров. Суммарная пропускная способность терминалов – более 130&nbsp;000 TEU в год. Одновременно нами осуществляется развитие терминала в ближнем Подмосковье. </p><p  align=\"justify\" class=\"textdoc\">ГКС является одним из крупнейших игроков на российском рынке терминальных услуг. </p>',36);
INSERT INTO `engine_TEXTDOC` VALUES (1459,'<p  align=\"justify\" class=\"textdoc\">ГКС уделяет максимальное внимание инвестициям в развитие комплекса логистических мощностей и услуг. &nbsp;</p><p  align=\"justify\" class=\"textdoc\" /><p  align=\"justify\" class=\"textdoc\">Компании, входящие в нашу группу, оказывают полный спектр услуг по хранению и дистрибуции внешнеторговых грузов, следующих через порты Новороссийска и Санкт-Петербурга. Благодаря высокому профессионализму нашей команды и применению передовых транспортных и информационных технологий, мы гарантируем нашим клиентам сохранную доставку товаров точно в срок на склад конечного получателя. Помимо транспортировки, складские подразделения нашего холдинга предлагают качественный сервис по сортировке, перевеске, переупаковке и маркировке грузовых мест. </p><p  align=\"justify\" class=\"textdoc\">Мы активно работаем над дальнейшим расширением логистических возможностей для наших клиентов. В ближайшей перспективе ГКС рассматривает создание многофункциональных логистических складов на базе собственных терминалов в Новороссийске и Санкт-Петербурге.</p>',37);
INSERT INTO `engine_TEXTDOC` VALUES (1460,'<p  align=\"justify\" style=\"MARGIN: 0cm 0cm 0pt; TEXT-ALIGN: justify\" class=\"MsoNormal\">Группа ГКС успешно развивает таможенный проект с 2005 года. Наше таможенное подразделение располагает лицензиями брокера, перевозчика и склада временного хранения. </p><p  align=\"justify\" class=\"MsoNormal\" /><p  align=\"justify\" style=\"MARGIN: 0cm 0cm 0pt; TEXT-ALIGN: justify\" class=\"MsoNormal\">Мы успешно работаем со всей номенклатурой импортных товаров, доставляемых в Россию в контейнерах, оптимизируя затраты грузополучателей, связанные с доставкой и таможенным оформлением грузов, сокращением времени нахождения грузов на территории портовых и таможенных терминалов, что достигается детальной предварительной проработкой документов.</p>',38);
INSERT INTO `engine_TEXTDOC` VALUES (1447,'',64);
INSERT INTO `engine_TEXTDOC` VALUES (1450,'<br  class=\"textdoc\" />',28);
INSERT INTO `engine_TEXTDOC` VALUES (1409,'',46);
INSERT INTO `engine_TEXTDOC` VALUES (1461,'<p  align=\"justify\" style=\"MARGIN: 0cm 0cm 0pt; TEXT-ALIGN: justify\" class=\"MsoNormal\">ГКС владеет современным парком автомашин-контейнеровозов.</p><p  align=\"justify\" style=\"MARGIN: 0cm 0cm 0pt; TEXT-ALIGN: justify\" class=\"MsoNormal\">В составе нашей автоколонны работают тягачи MAZ, <span  lang=\"EN-US\" style=\"FONT-SIZE: 11pt; FONT-FAMILY: Arial; mso-ansi-language: EN-US\" class=\"textdoc\">MAZ</span>-MAN <span  style=\"FONT-SIZE: 11pt; FONT-FAMILY: Arial\" class=\"textdoc\">и </span>MAN. </p><p  align=\"justify\" class=\"textdoc\" /><p  align=\"justify\" style=\"MARGIN: 0cm 0cm 0pt; TEXT-ALIGN: justify\" class=\"MsoNormal\">Общее количество машин в собственности ГКС составляет 40 единиц. </p><p  align=\"justify\" style=\"MARGIN: 0cm 0cm 0pt; TEXT-ALIGN: justify\" class=\"MsoNormal\">Все автотягачи ГКС соответствуют стандартам EURO&nbsp;II и III<span  style=\"FONT-SIZE: 11pt; FONT-FAMILY: Arial\" class=\"textdoc\">. </span></p><p  align=\"justify\" class=\"MsoNormal\">К началу 2008 году автопарк ГКС должен вырасти до 150 машин.</p>',39);
INSERT INTO `engine_TEXTDOC` VALUES (1462,'<p  align=\"justify\" style=\"MARGIN: 0cm 0cm 0pt; TEXT-ALIGN: justify\" class=\"MsoNormal\">C 2006 года ГКС развивает собственный парк железнодорожных фиттинговых платформ.</p><p  align=\"justify\" style=\"MARGIN: 0cm 0cm 0pt; TEXT-ALIGN: justify\" class=\"MsoNormal\">Сегодня он включает 228 единиц, работающих в составе маршрутных контейнерных поездов на направлениях из/в&nbsp; порты Новороссийск и Санкт-Петербург. </p><p  align=\"justify\" class=\"MsoNormal\" /><p class=textdoc  align=\"justify\">В наших ближайших планах стоит увеличение парка платформ до более 500 единиц.</p>',40);
INSERT INTO `engine_TEXTDOC` VALUES (1463,'<p  align=\"justify\" class=\"textdoc\">Группа ГКС оперирует собственными припортовыми терминалами в Новороссийске и Санкт-Петербурге.</p><p  align=\"justify\" class=\"textdoc\">Терминал «Рускон» в Новороссийске расположен в 7 километрах от порта. Ёмкость терминала превышает 3500 TEU, а пропускная способность – около 50&nbsp;000 TEU в год.</p><p  align=\"justify\" class=\"textdoc\">На терминале располагаются специализированные комплексы по перевалке зерновых, тяжеловесных и наливных грузов в контейнерах.</p><p  align=\"justify\" class=\"textdoc\">Терминал «Рускон» в Санкт-Петербурге предполагается запустить в эксплуатацию в конце 2008 года. Расстояние от терминала до порта – 25 километров. Ёмкость – более 4000 TEU. Проектная мощность терминала – около 90&nbsp;000 TEU в год. </p><p  align=\"justify\" class=\"textdoc\">Терминал располагает развитым путевым хозяйством. Помимо открытых контейнерных площадок на терминале будут расположены склады комплектации. </p>',41);
INSERT INTO `engine_TEXTDOC` VALUES (1464,'<p  align=\"justify\" class=\"textdoc\">Компании, входящие в ГКС, эксплуатируют только современное специализированное оборудование для перевалки контейнерных грузов.</p><p  align=\"justify\" class=\"textdoc\">Сегодня парк оборудования ГКС включает:</p><ul  class=\"textdoc\"><li  class=\"textdoc\"><div class=textdoc  align=\"justify\">2 козловых крана на рельсовом ходу г/п 35 тонн, </div></li><li  class=\"textdoc\"><div class=textdoc  align=\"justify\">3 ричстакера г/п 45 тонн,</div></li><li  class=\"textdoc\"><div class=textdoc  align=\"justify\">7 вилочных погрузчиков г/п 2-5 тонн,</div></li><li  class=\"textdoc\"><div class=textdoc  align=\"justify\">1 тягач для ролл-трейлеров, </div></li><li  class=\"textdoc\"><div class=textdoc  align=\"justify\">1 пневмопогрузчик, </div></li><li  class=\"textdoc\"><div class=textdoc  align=\"justify\">мини-элеватор ёмкостью 10&nbsp;000 тонн,</div></li><li  class=\"textdoc\"><div class=textdoc  align=\"justify\">резервуарный парк для наливных грузов ёмкостью 2 000 тонн.&nbsp; </div></li></ul>',42);
INSERT INTO `engine_TEXTDOC` VALUES (1442,'<p  class=\"textdoc\">В состав ГКС входят компании:</p><p  class=\"textdoc\"><table  border=\"0\" class=\"textdoc\"><tbody  class=\"textdoc\"><tr class=textdoc_tr1  class=\"textdoc_tr1\"><td  class=\"textdoc\"><img  src=\"/engine/doc_images/part1.jpg\" class=\"textdoc\" /></td><td  valign=\"bottom\" class=\"textdoc\"><p  class=\"textdoc\">&nbsp;</p><p  class=\"textdoc\"><a  href=\"/www.ruscon.delo-group.ru/\" class=\"textdoc\">www<span  lang=\"RU\" style=\"mso-ansi-language: RU\" class=\"textdoc\">.</span>ruscon<span  lang=\"RU\" style=\"mso-ansi-language: RU\" class=\"textdoc\">.</span>delo<span  lang=\"RU\" style=\"mso-ansi-language: RU\" class=\"textdoc\">-</span>group<span  lang=\"RU\" style=\"mso-ansi-language: RU\" class=\"textdoc\">.</span>ru</a></span /> </p></td></tr><tr class=textdoc_tr2  class=\"textdoc_tr2\"><td  class=\"textdoc\"><img  src=\"/engine/doc_images/part2.jpg\" class=\"textdoc\" /></td><td  class=\"textdoc\" /></tr><tr class=textdoc_tr1  class=\"textdoc_tr1\"><td  class=\"textdoc\"><img  src=\"/engine/doc_images/part3.jpg\" class=\"textdoc\" /></td><td  class=\"textdoc\" /></tr><tr class=textdoc_tr2  class=\"textdoc_tr2\"><td  class=\"textdoc\"><img  src=\"/engine/doc_images/part4.jpg\" class=\"textdoc\" /></td><td  class=\"textdoc\" /></tr><tr class=textdoc_tr1  class=\"textdoc_tr1\"><td  class=\"textdoc\"><img  src=\"/engine/doc_images/part5.jpg\" class=\"textdoc\" /></td><td  class=\"textdoc\" /></tr><tr class=textdoc_tr2  class=\"textdoc_tr2\"><td  class=\"textdoc\"><img  src=\"/engine/doc_images/part6.jpg\" class=\"textdoc\" /></td><td  class=\"textdoc\" /></tr></tbody></table></p>',6);
INSERT INTO `engine_TEXTDOC` VALUES (1465,'<p  align=\"justify\" style=\"MARGIN: 0cm 0cm 0pt; TEXT-ALIGN: justify\" class=\"MsoNormal\"><u  class=\"textdoc\"><strong  class=\"textdoc\">Головной офис:</strong></u> </p><p  align=\"justify\" class=\"MsoNormal\" /><p  align=\"justify\" style=\"MARGIN: 0cm 0cm 0pt; TEXT-ALIGN: justify\" class=\"MsoNormal\">353900, Новороссийск,</p><p  align=\"justify\" style=\"MARGIN: 0cm 0cm 0pt; TEXT-ALIGN: justify\" class=\"MsoNormal\">ул. Нов. Республики 14а, 4й этаж</p><p  align=\"justify\" style=\"MARGIN: 0cm 0cm 0pt; TEXT-ALIGN: justify\" class=\"MsoNormal\">Тел. +7 8617 676&nbsp;037, 676&nbsp;038</p><p  align=\"justify\" style=\"MARGIN: 0cm 0cm 0pt; TEXT-ALIGN: justify\" class=\"MsoNormal\">Факс.+7 8617 678&nbsp;066</p><p  align=\"justify\" style=\"MARGIN: 0cm 0cm 0pt; TEXT-ALIGN: justify\" class=\"MsoNormal\"><a  href=\"mailto:mail@gcs-group.ru\" class=\"textdoc\">mail@gcs-group.ru</a></p><p  align=\"justify\" class=\"MsoNormal\" /><p  align=\"justify\" style=\"MARGIN: 0cm 0cm 0pt; TEXT-ALIGN: justify\" class=\"MsoNormal\"><span  class=\"textdoc\"><p  align=\"justify\" style=\"MARGIN: 0cm 0cm 0pt; TEXT-ALIGN: justify\" class=\"MsoNormal\"><u  class=\"textdoc\"><strong  class=\"textdoc\">Филиал в Москве:</strong></u></p><p  align=\"justify\" class=\"MsoNormal\" /><p  align=\"justify\" style=\"MARGIN: 0cm 0cm 0pt; TEXT-ALIGN: justify\" class=\"MsoNormal\">105064, Москва</p><p  align=\"justify\" style=\"MARGIN: 0cm 0cm 0pt; TEXT-ALIGN: justify\" class=\"MsoNormal\">ул. Воронцово поле, 12/1, стр.3</p><p  align=\"justify\" style=\"MARGIN: 0cm 0cm 0pt; TEXT-ALIGN: justify\" class=\"MsoNormal\">Тел. +7&nbsp;495&nbsp;931 96 89, 916 04 99</p><p  align=\"justify\" style=\"MARGIN: 0cm 0cm 0pt; TEXT-ALIGN: justify\" class=\"MsoNormal\">Факс. +7&nbsp;495&nbsp;916 05 84</p><p  align=\"justify\" class=\"MsoNormal\" /><p  align=\"justify\" style=\"MARGIN: 0cm 0cm 0pt; TEXT-ALIGN: justify\" class=\"MsoNormal\"><u  class=\"textdoc\"><strong  class=\"textdoc\">Филиал в Санкт-Петербурге:</strong></u></p><p  align=\"justify\" class=\"MsoNormal\" /><p  align=\"justify\" style=\"MARGIN: 0cm 0cm 0pt; TEXT-ALIGN: justify\" class=\"MsoNormal\">190005, Санкт-Петербург</p><p  align=\"justify\" style=\"MARGIN: 0cm 0cm 0pt; TEXT-ALIGN: justify\" class=\"MsoNormal\">ул. Бумажная, 18, оф.313</p><p  align=\"justify\" style=\"MARGIN: 0cm 0cm 0pt; TEXT-ALIGN: justify\" class=\"MsoNormal\">Тел. +7&nbsp;812&nbsp;335 00 20</p><p  align=\"justify\" style=\"MARGIN: 0cm 0cm 0pt; TEXT-ALIGN: justify\" class=\"MsoNormal\">Факс.+7&nbsp;812&nbsp;335 00 21</p></span></p><p class=textdoc  /><p  class=\"textdoc\" /><p  class=\"textdoc\" /><p  class=\"textdoc\" /><p  class=\"textdoc\" />',43);
INSERT INTO `engine_TEXTDOC` VALUES (1448,'',29);
INSERT INTO `engine_TEXTDOC` VALUES (1452,'<p  align=\"justify\" class=\"textdoc\">Группа компаний «Глобальный Контейнерный Сервис» (ГКС) успешно работает на российском контейнерном рынке с 1995 года. Начав свой путь с создания первой на юге России контейнерной линии и линейного агентства Forcon, сегодня мы входим в десятку лидеров отрасли с объемом перевозок до 120 тыс. TEU в год.</p><p  align=\"justify\" class=\"textdoc\" /><p  align=\"justify\" class=\"textdoc\" /><p  align=\"justify\" class=\"textdoc\">ГКС входит в один из крупнейших и динамично растущих транспортных холдингов России – «Дело», и с 2006 года управляет его контейнерными активами. В составе ГКС 7 агентских, логистических и транспортных компаний &nbsp;представленных во всех крупнейших российских портах и регионах, а также странах ближнего и дальнего зарубежья. </p><p  align=\"justify\" class=\"textdoc\" /><p  align=\"justify\" class=\"textdoc\" /><p  align=\"justify\" class=\"textdoc\">Выручка компаний ГКС превышает US$60 миллионов при объеме капитализации более US$50 миллионов. В ближайших планах ГКС – дальнейшее расширение, как числа компаний и транспортных мощностей, так и объемов транспортных услуг, оказываемых в России и за ее пределами.</p><p  align=\"justify\" class=\"textdoc\" /><p  align=\"justify\" class=\"textdoc\" /><p  align=\"justify\" class=\"textdoc\" /><p  align=\"justify\" class=\"textdoc\">Основные направления деятельности ГКС охватывают корпоративное управление, стратегическое планирование и развитие предприятий и активов, входящих в группу. Важнейшим приоритетом нашей работы является внедрение наиболее передовых технологий контейнерных перевозок на российском рынке, постоянное совершенствование оказываемых услуг в интересах клиентов, партнеров и акционеров.</p><p  align=\"justify\" class=\"textdoc\" /><p  align=\"justify\" class=\"textdoc\" /><p  align=\"justify\" class=\"textdoc\" /><p  align=\"justify\" class=\"textdoc\">Стратегической задачей ГКС является утроение выручки и удвоение объемов перевозок в течение ближайших 5 лет путём создания вертикально-интегрированной системы бесперебойной доставки контейнеров в любую точку России и мира. В решении этой задачи мы опираемся на высокий профессионализм около 400 собственных сотрудников, а также тесные партнерские отношения с ведущими российскими и международными транспортными компаниями. </p><p  align=\"justify\" class=\"textdoc\" /><p  align=\"justify\" class=\"textdoc\" /><p  align=\"justify\" class=\"textdoc\" /><p  align=\"justify\" class=\"textdoc\">Работая уже более 12 лет на российском транспортном рынке, мы стремимся постоянно открывать новые горизонты международной торговли, наводя мосты сотрудничества и взаимовыгодного бизнеса между людьми, компаниями и странами. &nbsp;</p>',32);
INSERT INTO `engine_TEXTDOC` VALUES (1467,'<p  align=\"center\" class=\"textdoc\" />',33);

--
-- Table structure for table `engine_conf`
--

DROP TABLE IF EXISTS `engine_conf`;
CREATE TABLE `engine_conf` (
  `id` bigint(20) NOT NULL auto_increment,
  `varname` varchar(255) NOT NULL default '',
  `varvalue` longtext NOT NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;

--
-- Dumping data for table `engine_conf`
--

INSERT INTO `engine_conf` VALUES (1,'defdoc','73');
INSERT INTO `engine_conf` VALUES (2,'deftpl','1');
INSERT INTO `engine_conf` VALUES (3,'def_counter1','');
INSERT INTO `engine_conf` VALUES (4,'def_counter2','');
INSERT INTO `engine_conf` VALUES (5,'def_counter3','');
INSERT INTO `engine_conf` VALUES (6,'def_title','title');
INSERT INTO `engine_conf` VALUES (7,'def_meta','');
INSERT INTO `engine_conf` VALUES (8,'dflt_menu_format','<li><a href=\"ITEM_LINK\">ITEM_TEXT</a></li>');
INSERT INTO `engine_conf` VALUES (9,'regform_group','2');
INSERT INTO `engine_conf` VALUES (10,'regform_prefix','');
INSERT INTO `engine_conf` VALUES (11,'regform_postfix','');
INSERT INTO `engine_conf` VALUES (12,'version','1.6.2.2');
INSERT INTO `engine_conf` VALUES (19,'doc404','-1');
INSERT INTO `engine_conf` VALUES (20,'searchtpl','-1');
INSERT INTO `engine_conf` VALUES (21,'top_add','');
INSERT INTO `engine_conf` VALUES (22,'hide_private_docs','0');
INSERT INTO `engine_conf` VALUES (23,'buy_form','');
INSERT INTO `engine_conf` VALUES (24,'shop_email','');
INSERT INTO `engine_conf` VALUES (25,'login_html','');
INSERT INTO `engine_conf` VALUES (26,'logged_info','');

--
-- Table structure for table `engine_docsinrubriques`
--

DROP TABLE IF EXISTS `engine_docsinrubriques`;
CREATE TABLE `engine_docsinrubriques` (
  `doc` bigint(20) NOT NULL default '0',
  `rub` bigint(20) NOT NULL default '0',
  `in` smallint(6) NOT NULL default '0',
  PRIMARY KEY  (`doc`,`rub`)
) TYPE=MyISAM;

--
-- Dumping data for table `engine_docsinrubriques`
--


--
-- Table structure for table `engine_documents`
--

DROP TABLE IF EXISTS `engine_documents`;
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
  PRIMARY KEY  (`id`),
  KEY `engine_idx_documents_pid` (`pid`),
  KEY `engine_idx_documents_name` (`name`(10)),
  KEY `engine_idx_documents_creation_date` (`creation_date`),
  KEY `engine_idx_documents_opener` (`opener`),
  KEY `engine_idx_documents_ord` (`ord`)
) TYPE=MyISAM;

--
-- Dumping data for table `engine_documents`
--

INSERT INTO `engine_documents` VALUES (1,'О НАС',25,'','','','O_nas',-1,'2007-08-17 14:21:41',-1,1,'FOLDER',1,4,0,0,'','','','','',0,2,'2007-09-18 13:53:16','2007-09-11 12:33:09',0,'');
INSERT INTO `engine_documents` VALUES (36,'Перевалка',13,'','','','Perevalka',-1,'2007-09-10 14:41:01',-1,-1,'TEXTDOC',1,3,0,0,'','','','','',0,13,'2007-09-17 14:54:39','2007-09-17 14:54:39',0,'');
INSERT INTO `engine_documents` VALUES (3,'АКТИВЫ',25,'','','','Aktivy',-1,'2007-08-17 14:23:55',-1,1,'FOLDER',1,6,0,0,'','','','','',0,2,'2007-09-18 13:53:18','2007-09-11 12:34:07',0,'');
INSERT INTO `engine_documents` VALUES (49,'Our network',45,'','','','Our_networ',-1,'2007-09-10 14:56:24',-1,-1,'TEXTDOC',1,4,0,0,'','','','','',0,2,'2007-09-13 01:30:14','0000-00-00 00:00:00',0,'');
INSERT INTO `engine_documents` VALUES (5,'ГРУППА ГКС',25,'','','','NASHA_KOMA',-1,'2007-08-17 14:26:47',-1,1,'FOLDER',1,7,0,0,'','','','','',0,2,'2007-09-18 13:53:19','2007-09-11 12:34:17',0,'');
INSERT INTO `engine_documents` VALUES (6,'Группа ГКС',5,'','','','Gruppa_GKS',-1,'2007-08-17 14:27:02',-1,-1,'TEXTDOC',0,1,0,0,'','','','','',0,13,'2007-09-19 14:53:30','2007-09-13 12:19:48',0,'');
INSERT INTO `engine_documents` VALUES (48,'Our team',45,'','','','Our_team',-1,'2007-09-10 14:55:53',-1,-1,'TEXTDOC',1,3,0,0,'','','','','',0,5,'2007-09-12 16:36:13','0000-00-00 00:00:00',0,'');
INSERT INTO `engine_documents` VALUES (8,'news',30,'','','','news_cn',-1,'2007-08-17 14:30:10',-1,-1,'TEXTDOC',1,1,0,0,'','','','','',0,14,'2007-09-09 16:49:18','2007-09-09 16:49:17',0,'');
INSERT INTO `engine_documents` VALUES (44,'NEWS',69,'','','','News1',-1,'2007-09-10 14:53:38',-1,-1,'NEWSGROUP',0,1,0,0,'','','','','',0,13,'2007-09-17 12:43:18','2007-09-17 11:26:52',0,'');
INSERT INTO `engine_documents` VALUES (45,'ABOUT US',23,'','','','About_us',-1,'2007-09-10 14:54:11',-1,-1,'FOLDER',1,3,0,0,'','','','','',0,13,'2007-09-17 12:40:37','2007-09-17 11:41:33',0,'');
INSERT INTO `engine_documents` VALUES (46,'Our company',45,'','','','Our_compan',-1,'2007-09-10 14:54:53',-1,-1,'TEXTDOC',1,1,0,0,'','','','','',0,13,'2007-09-13 11:13:20','2007-09-13 11:13:20',0,'');
INSERT INTO `engine_documents` VALUES (47,'Our values',45,'','','','our_values',-1,'2007-09-10 14:55:25',-1,-1,'TEXTDOC',1,2,0,0,'','','','','',0,5,'2007-09-12 16:35:49','2007-09-10 14:55:35',0,'');
INSERT INTO `engine_documents` VALUES (13,'УСЛУГИ',25,'','','','Uslugi',-1,'2007-08-17 14:51:04',-1,1,'FOLDER',1,5,0,0,'','','','','',0,2,'2007-09-18 13:53:17','2007-09-11 12:33:56',0,'');
INSERT INTO `engine_documents` VALUES (14,'Агентирование',13,'','','','Agentirova',-1,'2007-08-17 14:51:36',-1,-1,'TEXTDOC',1,1,0,0,'','','','','',0,13,'2007-09-17 14:54:20','2007-09-17 14:54:20',0,'');
INSERT INTO `engine_documents` VALUES (15,'Экспедирование',13,'','','','Ekspedirov',-1,'2007-08-17 14:52:17',-1,-1,'TEXTDOC',1,2,0,0,'','','','','',0,13,'2007-09-17 14:54:30','2007-09-17 14:54:30',0,'');
INSERT INTO `engine_documents` VALUES (31,'Наши ценности',1,'','','','Nashi_cenn',-1,'2007-09-10 14:34:18',-1,-1,'TEXTDOC',1,2,0,0,'','','','','',0,13,'2007-09-17 14:53:38','2007-09-17 14:53:37',0,'');
INSERT INTO `engine_documents` VALUES (20,'Наша команда',1,'','','','Komanda',-1,'2007-08-23 15:15:12',-1,-1,'TEXTDOC',1,3,0,0,'','','','','',0,13,'2007-09-17 14:53:40','2007-09-10 14:35:09',0,'');
INSERT INTO `engine_documents` VALUES (43,'КОНТАКТЫ',67,'','','','Kontakty2',-1,'2007-09-10 14:47:55',-1,1,'TEXTDOC',0,1,0,0,'','','','','',0,13,'2007-09-17 14:56:57','2007-09-17 14:56:57',0,'');
INSERT INTO `engine_documents` VALUES (24,'chinese',-1,'','','','cn',-1,'2007-09-06 12:55:13',-1,4,'FOLDER',0,1,0,0,'','','','','',0,2,'2007-09-18 11:34:11','2007-09-17 12:51:43',0,'');
INSERT INTO `engine_documents` VALUES (16,'ГЛАВНАЯ',25,'','','','main_rus',-1,'2007-08-20 17:50:08',-1,-1,'TEXTDOC',0,2,0,0,'','','','','',0,11,'2007-09-18 12:17:34','2007-09-17 12:10:38',0,'');
INSERT INTO `engine_documents` VALUES (17,'НОВОСТИ',66,'','','Архив новостей:','news_rus',-1,'2007-08-20 18:07:06',-1,-1,'NEWSGROUP',0,1,0,0,'','','','','',0,2,'2007-09-18 13:29:24','2007-09-18 12:18:37',0,'');
INSERT INTO `engine_documents` VALUES (18,'Расширение автопарка \"Рускон\" ',17,'','','','N18',-1,'2007-08-20 18:08:02',-1,-1,'NEW',1,0,0,0,'','','','','title',0,2,'2007-09-18 13:29:27','2007-09-18 12:29:11',0,'');
INSERT INTO `engine_documents` VALUES (29,'main_cn',24,'','','','main_cn',-1,'2007-09-06 16:57:30',-1,-1,'TEXTDOC',0,3,0,0,'','','','','',0,13,'2007-09-17 11:46:08','2007-09-17 11:46:08',0,'');
INSERT INTO `engine_documents` VALUES (23,'eng',-1,'','','','eng',-1,'2007-09-06 12:54:59',-1,1,'FOLDER',0,2,0,0,'','','','','',0,2,'2007-09-18 13:53:37','2007-09-18 13:53:37',0,'');
INSERT INTO `engine_documents` VALUES (25,'rus',-1,'','','','rus',-1,'2007-09-06 16:34:30',-1,4,'FOLDER',1,3,0,0,'','','','','',0,2,'2007-09-18 13:56:05','2007-09-18 13:56:05',1,'');
INSERT INTO `engine_documents` VALUES (26,'About',23,'','','','About',-1,'2007-09-06 16:52:30',-1,-1,'FOLDER',0,8,0,0,'','','','','',0,13,'2007-09-10 15:08:28','2007-09-10 15:08:27',0,'');
INSERT INTO `engine_documents` VALUES (27,'Newses',26,'','','','news_eng',-1,'2007-09-06 16:52:41',-1,-1,'TEXTDOC',1,1,0,0,'','','','','',0,5,'2007-09-15 09:34:55','2007-09-09 17:14:17',0,'');
INSERT INTO `engine_documents` VALUES (28,'MAIN',23,'','','','main_eng',-1,'2007-09-06 16:55:41',-1,-1,'TEXTDOC',0,1,0,0,'','','','','',0,13,'2007-09-17 12:11:38','2007-09-17 12:11:38',0,'');
INSERT INTO `engine_documents` VALUES (30,'Aboud',24,'','','','Aboud',-1,'2007-09-06 16:57:37',-1,1,'FOLDER',0,2,0,0,'','','','','',0,13,'2007-09-17 11:46:00','2007-09-17 11:44:59',0,'');
INSERT INTO `engine_documents` VALUES (32,'Наша компания',1,'','','','Nasha_komp',-1,'2007-09-10 14:34:39',-1,-1,'TEXTDOC',1,1,0,0,'','','','','',0,13,'2007-09-17 14:53:23','2007-09-17 14:53:22',0,'');
INSERT INTO `engine_documents` VALUES (33,'Наши офисы',1,'','','','Nashi_ofis',-1,'2007-09-10 14:35:32',-1,-1,'TEXTDOC',1,4,0,0,'','','','','',0,13,'2007-09-19 14:55:42','2007-09-19 14:55:42',1,'');
INSERT INTO `engine_documents` VALUES (34,'Наши партнеры',1,'','','','Nashi_part2',-1,'2007-09-10 14:35:52',-1,-1,'TEXTDOC',1,5,0,0,'','','','','',0,13,'2007-09-17 14:58:19','2007-09-17 14:53:58',0,'');
INSERT INTO `engine_documents` VALUES (35,'Наши сертификаты',1,'','','','Nashi_sert2',-1,'2007-09-10 14:36:09',-1,-1,'TEXTDOC',1,6,0,0,'','','','','',0,13,'2007-09-17 14:54:10','2007-09-17 14:54:10',0,'');
INSERT INTO `engine_documents` VALUES (37,'Логистика',13,'','','','Logistika',-1,'2007-09-10 14:41:24',-1,-1,'TEXTDOC',1,4,0,0,'','','','','',0,13,'2007-09-17 14:54:48','2007-09-17 14:54:47',0,'');
INSERT INTO `engine_documents` VALUES (38,'Таможенное оформление',13,'','','','Tamozhenno',-1,'2007-09-10 14:41:57',-1,-1,'TEXTDOC',1,5,0,0,'','','','','',0,13,'2007-09-17 14:54:58','2007-09-17 14:54:57',0,'');
INSERT INTO `engine_documents` VALUES (39,'Автотранспорт',3,'','','','Avtotransp',-1,'2007-09-10 14:43:31',-1,-1,'TEXTDOC',1,1,0,0,'','','','','',0,13,'2007-09-17 14:55:09','2007-09-17 14:55:09',0,'');
INSERT INTO `engine_documents` VALUES (40,'Платформы',3,'','','','Platformy',-1,'2007-09-10 14:43:51',-1,-1,'TEXTDOC',1,2,0,0,'','','','','',0,13,'2007-09-17 14:55:17','2007-09-17 14:55:17',0,'');
INSERT INTO `engine_documents` VALUES (41,'Терминалы',3,'','','','Terminaly',-1,'2007-09-10 14:44:06',-1,-1,'TEXTDOC',1,3,0,0,'','','','','',0,13,'2007-09-17 14:55:27','2007-09-17 14:55:27',0,'');
INSERT INTO `engine_documents` VALUES (42,'Оборудование',3,'','','','Oborudovan',-1,'2007-09-10 14:44:25',-1,-1,'TEXTDOC',1,4,0,0,'','','','','',0,13,'2007-09-17 14:55:36','2007-09-17 14:55:35',0,'');
INSERT INTO `engine_documents` VALUES (50,'Our partners',45,'','','','Our_partne',-1,'2007-09-10 14:56:53',-1,-1,'TEXTDOC',1,5,0,0,'','','','','',0,5,'2007-09-12 16:30:05','0000-00-00 00:00:00',0,'');
INSERT INTO `engine_documents` VALUES (51,'Our memberships',45,'','','','Our_member',-1,'2007-09-10 14:57:26',-1,-1,'TEXTDOC',1,6,0,0,'','','','','',0,5,'2007-09-12 16:30:07','0000-00-00 00:00:00',0,'');
INSERT INTO `engine_documents` VALUES (52,'SERVICES',23,'','','','Services',-1,'2007-09-10 14:58:40',-1,-1,'FOLDER',1,4,0,0,'','','','','',0,13,'2007-09-17 11:41:52','2007-09-17 11:41:52',0,'');
INSERT INTO `engine_documents` VALUES (53,'Liner agency',52,'','','','Liner_agen',-1,'2007-09-10 14:59:15',-1,-1,'TEXTDOC',1,1,0,0,'','','','','',0,5,'2007-09-12 16:22:08','0000-00-00 00:00:00',0,'');
INSERT INTO `engine_documents` VALUES (54,'Freight forwarding',52,'','','','Freight_fo',-1,'2007-09-10 15:00:24',-1,-1,'TEXTDOC',1,2,0,0,'','','','','',0,5,'2007-09-12 16:22:10','0000-00-00 00:00:00',0,'');
INSERT INTO `engine_documents` VALUES (55,'Terminal handling',52,'','','','Terminal_h',-1,'2007-09-10 15:01:16',-1,-1,'TEXTDOC',1,3,0,0,'','','','','',0,5,'2007-09-12 16:22:12','0000-00-00 00:00:00',0,'');
INSERT INTO `engine_documents` VALUES (56,'Logistics',52,'','','','Logistics',-1,'2007-09-10 15:02:16',-1,-1,'TEXTDOC',1,4,0,0,'','','','','',0,5,'2007-09-12 16:22:13','0000-00-00 00:00:00',0,'');
INSERT INTO `engine_documents` VALUES (57,'Customs',52,'','','','Customs',-1,'2007-09-10 15:02:43',-1,-1,'TEXTDOC',1,5,0,0,'','','','','',0,5,'2007-09-12 16:22:15','0000-00-00 00:00:00',0,'');
INSERT INTO `engine_documents` VALUES (58,'ASSETS',23,'','','','Assets',-1,'2007-09-10 15:03:22',-1,-1,'FOLDER',1,5,0,0,'','','','','',0,13,'2007-09-17 11:42:59','2007-09-17 11:42:59',0,'');
INSERT INTO `engine_documents` VALUES (59,'Trucking',58,'','','','Trucking',-1,'2007-09-10 15:04:00',-1,-1,'TEXTDOC',1,1,0,0,'','','','','',0,0,'0000-00-00 00:00:00','0000-00-00 00:00:00',0,'');
INSERT INTO `engine_documents` VALUES (60,'Railway wagons',58,'','','','Railway_wa',-1,'2007-09-10 15:04:33',-1,-1,'TEXTDOC',1,2,0,0,'','','','','',0,0,'0000-00-00 00:00:00','0000-00-00 00:00:00',0,'');
INSERT INTO `engine_documents` VALUES (61,'Terminals',58,'','','','Terminals',-1,'2007-09-10 15:04:56',-1,-1,'TEXTDOC',1,3,0,0,'','','','','',0,0,'0000-00-00 00:00:00','0000-00-00 00:00:00',0,'');
INSERT INTO `engine_documents` VALUES (62,'Equipment',58,'','','','Equipment',-1,'2007-09-10 15:05:29',-1,-1,'TEXTDOC',1,4,0,0,'','','','','',0,0,'0000-00-00 00:00:00','0000-00-00 00:00:00',0,'');
INSERT INTO `engine_documents` VALUES (63,'GROUP OF COMPANIES',23,'','','','Group_of_c',-1,'2007-09-10 15:06:38',-1,-1,'FOLDER',1,6,0,0,'','','','','',0,13,'2007-09-17 11:43:31','2007-09-17 11:43:31',0,'');
INSERT INTO `engine_documents` VALUES (64,'CONTACTS',70,'','','','Contacts',-1,'2007-09-10 15:07:10',-1,-1,'TEXTDOC',1,1,0,0,'','','','','',0,13,'2007-09-17 11:41:00','2007-09-17 11:41:00',0,'');
INSERT INTO `engine_documents` VALUES (65,'Новые маршруты для перевозок',44,'','','','N65',-1,'2007-09-12 16:26:59',-1,-1,'NEW',1,0,0,0,'','','','','title',0,13,'2007-09-17 12:19:04','0000-00-00 00:00:00',0,'');
INSERT INTO `engine_documents` VALUES (66,'НОВОСТИ',25,'','','','NOVOSTI',-1,'2007-09-13 14:47:36',-1,1,'FOLDER',1,3,0,0,'','','','','',0,2,'2007-09-18 13:53:15','2007-09-13 14:54:52',0,'');
INSERT INTO `engine_documents` VALUES (67,'КОНТАКТЫ',25,'','','','KONTAKTY3',-1,'2007-09-13 14:47:42',-1,1,'FOLDER',1,8,0,0,'','','','','',0,2,'2007-09-18 13:53:20','2007-09-13 14:54:33',0,'');
INSERT INTO `engine_documents` VALUES (70,'CONTACTS',23,'','','','CONTACTS1',-1,'2007-09-15 09:31:37',-1,-1,'FOLDER',1,7,0,0,'','','','','',0,13,'2007-09-17 11:43:39','2007-09-17 11:40:12',0,'');
INSERT INTO `engine_documents` VALUES (69,'NEWS',23,'','','','NEWS2',-1,'2007-09-15 09:31:29',-1,-1,'FOLDER',1,2,0,0,'','','','','',0,2,'2007-09-18 13:53:40','2007-09-17 11:35:05',0,'');
INSERT INTO `engine_documents` VALUES (73,'Новости',25,'','','','Glavnayano',-1,'2007-09-18 11:01:46',-1,4,'LINK',0,1,0,0,'','','','','',0,2,'2007-09-18 13:29:22','2007-09-18 11:10:12',0,'');
INSERT INTO `engine_documents` VALUES (71,'&#25105;&#20204;&#20844;&#21496;',24,'','','','N2510520204',-1,'2007-09-17 12:22:26',-1,-1,'HTMLDOC',0,1,0,0,'','','','','',0,13,'2007-09-17 12:51:37','2007-09-17 12:51:37',0,'');
INSERT INTO `engine_documents` VALUES (74,'ffffff',17,'','','','N74',-1,'2007-09-18 12:18:46',-1,-1,'NEW',1,0,0,0,'','','','','title',0,11,'2007-09-18 12:18:55','0000-00-00 00:00:00',0,'');
INSERT INTO `engine_documents` VALUES (75,'gggggggg',17,'','','','N75',-1,'2007-09-18 12:24:57',-1,-1,'NEW',1,0,0,0,'','','','','title',0,11,'2007-09-18 12:25:06','2007-09-18 12:25:05',0,'');
INSERT INTO `engine_documents` VALUES (76,'ddddddd',17,'','','','N76',-1,'2007-09-18 12:25:22',-1,-1,'NEW',1,0,0,0,'','','','','title',0,11,'2007-09-18 12:25:33','2007-09-18 12:25:32',0,'');

--
-- Table structure for table `engine_forum`
--

DROP TABLE IF EXISTS `engine_forum`;
CREATE TABLE `engine_forum` (
  `id` bigint(20) NOT NULL auto_increment,
  `moderator_gr` bigint(20) NOT NULL default '0',
  `descr` longtext NOT NULL,
  `answer_frmt1` longtext NOT NULL,
  `answer_frmt2` longtext NOT NULL,
  `topic_frmt` longtext NOT NULL,
  `name` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;

--
-- Dumping data for table `engine_forum`
--


--
-- Table structure for table `engine_forum_msg`
--

DROP TABLE IF EXISTS `engine_forum_msg`;
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
) TYPE=MyISAM PACK_KEYS=0;

--
-- Dumping data for table `engine_forum_msg`
--


--
-- Table structure for table `engine_group_rights`
--

DROP TABLE IF EXISTS `engine_group_rights`;
CREATE TABLE `engine_group_rights` (
  `ugroup` bigint(20) NOT NULL default '0',
  `granted` bigint(20) NOT NULL default '0',
  `document` bigint(20) NOT NULL default '0',
  `edit` tinyint(4) NOT NULL default '0',
  `publicate` tinyint(4) NOT NULL default '0',
  KEY `engine_idx_group_rights_ugroup` (`ugroup`),
  KEY `engine_idx_group_rights_document` (`document`),
  KEY `engine_idx_group_rights_granted` (`granted`)
) TYPE=MyISAM;

--
-- Dumping data for table `engine_group_rights`
--

INSERT INTO `engine_group_rights` VALUES (2,0,28,0,0);
INSERT INTO `engine_group_rights` VALUES (1,0,28,0,0);

--
-- Table structure for table `engine_groups`
--

DROP TABLE IF EXISTS `engine_groups`;
CREATE TABLE `engine_groups` (
  `id` bigint(20) NOT NULL auto_increment,
  `name` text NOT NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;

--
-- Dumping data for table `engine_groups`
--

INSERT INTO `engine_groups` VALUES (1,'belti');
INSERT INTO `engine_groups` VALUES (2,'Зарегистрированные посетители');

--
-- Table structure for table `engine_log`
--

DROP TABLE IF EXISTS `engine_log`;
CREATE TABLE `engine_log` (
  `id` bigint(20) NOT NULL auto_increment,
  `log_date` datetime default NULL,
  `user` bigint(20) NOT NULL default '0',
  `text` longtext NOT NULL,
  `document` bigint(20) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `engine_idx_log_user` (`user`),
  KEY `engine_idx_log_document` (`document`),
  KEY `engine_idx_log_log_date` (`log_date`)
) TYPE=MyISAM;

--
-- Dumping data for table `engine_log`
--

INSERT INTO `engine_log` VALUES (2460,'2007-08-17 14:21:41',13,'Создание папки \'Наша компания\'',1);
INSERT INTO `engine_log` VALUES (2461,'2007-08-17 14:22:23',13,'Создание документа \'Наша компания\'',2);
INSERT INTO `engine_log` VALUES (2462,'2007-08-17 14:23:03',13,'Изменение документа \'Наша компания\'',2);
INSERT INTO `engine_log` VALUES (2463,'2007-08-17 14:23:14',13,'Изменение документа \'Наша компания\'',2);
INSERT INTO `engine_log` VALUES (2464,'2007-08-17 14:23:35',13,'Изменение документа \'Наша компания\'',1);
INSERT INTO `engine_log` VALUES (2465,'2007-08-17 14:23:55',13,'Создание папки \'НАШИ ЦЕННОСТИ\'',3);
INSERT INTO `engine_log` VALUES (2466,'2007-08-17 14:24:16',13,'Изменение документа \'Наши ценности\'',3);
INSERT INTO `engine_log` VALUES (2467,'2007-08-17 14:24:30',13,'Создание документа \'Наши ценности\'',4);
INSERT INTO `engine_log` VALUES (2468,'2007-08-17 14:25:20',13,'Изменение документа \'Наши ценности\'',4);
INSERT INTO `engine_log` VALUES (2469,'2007-08-17 14:25:53',13,'Изменение документа \'Наши ценности\'',4);
INSERT INTO `engine_log` VALUES (2470,'2007-08-17 14:25:59',13,'Изменение документа \'Наши ценности\'',4);
INSERT INTO `engine_log` VALUES (2471,'2007-08-17 14:26:13',13,'Изменение документа \'Наши ценности\'',3);
INSERT INTO `engine_log` VALUES (2472,'2007-08-17 14:26:47',13,'Создание папки \'НАША КОМАНДА\'',5);
INSERT INTO `engine_log` VALUES (2473,'2007-08-17 14:27:02',13,'Создание документа \'Наша команда\'',6);
INSERT INTO `engine_log` VALUES (2474,'2007-08-17 14:27:09',13,'Изменение документа \'Наша команда\'',6);
INSERT INTO `engine_log` VALUES (2475,'2007-08-17 14:27:14',13,'Изменение документа \'НАША КОМАНДА\'',5);
INSERT INTO `engine_log` VALUES (2476,'2007-08-17 14:28:18',13,'Изменение документа \'Наша команда\'',6);
INSERT INTO `engine_log` VALUES (2477,'2007-08-17 14:28:31',13,'Изменение документа \'Наша команда\'',6);
INSERT INTO `engine_log` VALUES (2478,'2007-08-17 14:28:38',13,'Изменение документа \'Наша команда\'',6);
INSERT INTO `engine_log` VALUES (2479,'2007-08-17 14:29:11',13,'Изменение документа \'Наша команда\'',5);
INSERT INTO `engine_log` VALUES (2480,'2007-08-17 14:29:15',13,'Изменение документа \'Наша команда\'',5);
INSERT INTO `engine_log` VALUES (2481,'2007-08-17 14:29:56',13,'Создание папки \'Наши офисы\'',7);
INSERT INTO `engine_log` VALUES (2482,'2007-08-17 14:30:10',13,'Создание документа \'Наши офисы\'',8);
INSERT INTO `engine_log` VALUES (2483,'2007-08-17 14:30:16',13,'Изменение документа \'Наши офисы\'',8);
INSERT INTO `engine_log` VALUES (2484,'2007-08-17 14:30:22',13,'Изменение документа \'Наши офисы\'',7);
INSERT INTO `engine_log` VALUES (2485,'2007-08-17 14:31:13',13,'Создание папки \'Наши партнеры\'',9);
INSERT INTO `engine_log` VALUES (2486,'2007-08-17 14:31:41',13,'Создание документа \'Наши партнеры\'',10);
INSERT INTO `engine_log` VALUES (2487,'2007-08-17 14:31:49',13,'Изменение документа \'Наши партнеры\'',10);
INSERT INTO `engine_log` VALUES (2488,'2007-08-17 14:31:56',13,'Изменение документа \'Наши партнеры\'',9);
INSERT INTO `engine_log` VALUES (2489,'2007-08-17 14:36:10',13,'Изменение документа \'Наши партнеры\'',10);
INSERT INTO `engine_log` VALUES (2490,'2007-08-17 14:38:59',13,'Изменение документа \'Наши партнеры\'',10);
INSERT INTO `engine_log` VALUES (2491,'2007-08-17 14:42:23',13,'Изменение документа \'Наши партнеры\'',10);
INSERT INTO `engine_log` VALUES (2492,'2007-08-17 14:44:45',13,'Изменение документа \'Наши партнеры\'',10);
INSERT INTO `engine_log` VALUES (2493,'2007-08-17 14:45:14',13,'Создание папки \'Наши сертификаты\'',11);
INSERT INTO `engine_log` VALUES (2494,'2007-08-17 14:45:45',13,'Создание документа \'Наши сертификаты\'',12);
INSERT INTO `engine_log` VALUES (2495,'2007-08-17 14:45:57',13,'Изменение документа \'Наши сертификаты\'',12);
INSERT INTO `engine_log` VALUES (2496,'2007-08-17 14:46:05',13,'Изменение документа \'Наши сертификаты\'',11);
INSERT INTO `engine_log` VALUES (2497,'2007-08-17 14:47:30',13,'Изменение документа \'Наши сертификаты\'',12);
INSERT INTO `engine_log` VALUES (2498,'2007-08-17 14:49:26',13,'Изменение документа \'Наши сертификаты\'',12);
INSERT INTO `engine_log` VALUES (2499,'2007-08-17 14:49:33',13,'Изменение документа \'Наши сертификаты\'',12);
INSERT INTO `engine_log` VALUES (2500,'2007-08-17 14:50:21',13,'Изменение документа \'Наши сертификаты\'',11);
INSERT INTO `engine_log` VALUES (2501,'2007-08-17 14:51:04',13,'Создание папки \'Услуги\'',13);
INSERT INTO `engine_log` VALUES (2502,'2007-08-17 14:51:36',13,'Создание документа \'Агентирование\'',14);
INSERT INTO `engine_log` VALUES (2503,'2007-08-17 14:51:52',13,'Изменение документа \'Агентирование\'',14);
INSERT INTO `engine_log` VALUES (2504,'2007-08-17 14:52:17',13,'Создание документа \'Экспедирование\'',15);
INSERT INTO `engine_log` VALUES (2505,'2007-08-17 14:52:37',13,'Изменение документа \'Экспедирование\'',15);
INSERT INTO `engine_log` VALUES (2506,'2007-08-17 14:52:43',13,'Изменение документа \'Экспедирование\'',15);
INSERT INTO `engine_log` VALUES (2507,'2007-08-17 15:02:14',13,'Изменение документа \'Наши партнеры\'',10);
INSERT INTO `engine_log` VALUES (2508,'2007-08-17 15:12:11',13,'Изменение документа \'Наши партнеры\'',10);
INSERT INTO `engine_log` VALUES (2509,'2007-08-17 15:14:15',13,'Изменение документа \'Наши партнеры\'',10);
INSERT INTO `engine_log` VALUES (2510,'2007-08-17 15:14:24',13,'Изменение документа \'Наши партнеры\'',10);
INSERT INTO `engine_log` VALUES (2511,'2007-08-17 15:14:28',13,'Изменение документа \'Наши партнеры\'',10);
INSERT INTO `engine_log` VALUES (2512,'2007-08-17 15:15:33',13,'Изменение документа \'Наши сертификаты\'',12);
INSERT INTO `engine_log` VALUES (2513,'2007-08-20 17:45:11',14,'Добавление шаблона \'main\'',-1);
INSERT INTO `engine_log` VALUES (2514,'2007-08-20 17:47:49',14,'Изменение шаблона \'main\'',-1);
INSERT INTO `engine_log` VALUES (2515,'2007-08-20 17:48:03',14,'Изменение шаблона \'main\'',-1);
INSERT INTO `engine_log` VALUES (2516,'2007-08-20 17:49:53',14,'Изменение шаблона \'main\'',-1);
INSERT INTO `engine_log` VALUES (2517,'2007-08-20 17:50:08',14,'Создание документа \'Главная\'',16);
INSERT INTO `engine_log` VALUES (2518,'2007-08-20 17:51:10',14,'Изменение документа \'Главная\'',16);
INSERT INTO `engine_log` VALUES (2519,'2007-08-20 17:53:28',14,'Изменение шаблона \'main\'',-1);
INSERT INTO `engine_log` VALUES (2520,'2007-08-20 17:54:22',14,'Изменение шаблона \'main\'',-1);
INSERT INTO `engine_log` VALUES (2521,'2007-08-20 17:57:52',14,'Изменение шаблона \'main\'',-1);
INSERT INTO `engine_log` VALUES (2522,'2007-08-20 17:58:41',14,'Изменение шаблона \'main\'',-1);
INSERT INTO `engine_log` VALUES (2523,'2007-08-20 17:59:30',14,'Изменение шаблона \'main\'',-1);
INSERT INTO `engine_log` VALUES (2524,'2007-08-20 18:00:23',14,'Изменение шаблона \'main\'',-1);
INSERT INTO `engine_log` VALUES (2525,'2007-08-20 18:01:19',14,'Изменение шаблона \'main\'',-1);
INSERT INTO `engine_log` VALUES (2526,'2007-08-20 18:02:24',14,'Изменение шаблона \'main\'',-1);
INSERT INTO `engine_log` VALUES (2527,'2007-08-20 18:03:49',14,'Изменение шаблона \'main\'',-1);
INSERT INTO `engine_log` VALUES (2528,'2007-08-20 18:04:06',14,'Изменение шаблона \'main\'',-1);
INSERT INTO `engine_log` VALUES (2529,'2007-08-20 18:07:06',14,'Создание документа \'Новости\'',5);
INSERT INTO `engine_log` VALUES (2530,'2007-08-20 18:08:00',14,'Изменение документа \'Новости\'',17);
INSERT INTO `engine_log` VALUES (2531,'2007-08-20 18:08:02',14,'Создание документа \'\'',18);
INSERT INTO `engine_log` VALUES (2532,'2007-08-20 18:17:14',14,'Изменение шаблона \'main\'',-1);
INSERT INTO `engine_log` VALUES (2533,'2007-08-20 18:22:01',14,'Изменение шаблона \'main\'',-1);
INSERT INTO `engine_log` VALUES (2534,'2007-08-20 18:22:24',14,'Изменение шаблона \'main\'',-1);
INSERT INTO `engine_log` VALUES (2535,'2007-08-20 18:45:09',14,'Изменение шаблона \'main\'',-1);
INSERT INTO `engine_log` VALUES (2536,'2007-08-20 18:46:40',14,'Изменение шаблона \'main\'',-1);
INSERT INTO `engine_log` VALUES (2537,'2007-08-20 18:47:52',14,'Изменение шаблона \'main\'',-1);
INSERT INTO `engine_log` VALUES (2538,'2007-08-20 18:48:58',14,'Изменение шаблона \'main\'',-1);
INSERT INTO `engine_log` VALUES (2539,'2007-08-20 18:50:04',14,'Изменение шаблона \'main\'',-1);
INSERT INTO `engine_log` VALUES (2540,'2007-08-20 18:52:56',14,'Изменение шаблона \'main\'',-1);
INSERT INTO `engine_log` VALUES (2541,'2007-08-20 18:53:07',14,'Создание папки \'Главная\'',19);
INSERT INTO `engine_log` VALUES (2542,'2007-08-20 18:53:22',14,'Изменение документа \'Главная\'',19);
INSERT INTO `engine_log` VALUES (2543,'2007-08-20 18:54:50',14,'Изменение документа \'Главная\'',19);
INSERT INTO `engine_log` VALUES (2544,'2007-08-20 18:55:02',14,'Изменение документа \'Наша компания\'',1);
INSERT INTO `engine_log` VALUES (2545,'2007-08-20 19:02:24',14,'Изменение шаблона \'main\'',-1);
INSERT INTO `engine_log` VALUES (2546,'2007-08-21 13:47:35',14,'Изменение документа \'Наша компания\'',1);
INSERT INTO `engine_log` VALUES (2547,'2007-08-21 13:48:03',14,'Изменение документа \'Услуги\'',13);
INSERT INTO `engine_log` VALUES (2548,'2007-08-21 13:48:39',14,'Изменение документа \'Наши ценности\'',3);
INSERT INTO `engine_log` VALUES (2549,'2007-08-21 13:55:33',14,'Изменение документа \'Наши партнеры\'',9);
INSERT INTO `engine_log` VALUES (2550,'2007-08-21 13:59:32',14,'Изменение документа \'Наши офисы\'',7);
INSERT INTO `engine_log` VALUES (2551,'2007-08-23 12:14:42',13,'Изменение документа \'О компании\'',1);
INSERT INTO `engine_log` VALUES (2552,'2007-08-23 12:16:39',13,'Изменение документа \'О компании\'',2);
INSERT INTO `engine_log` VALUES (2553,'2007-08-23 12:17:01',13,'Изменение документа \'Активы\'',3);
INSERT INTO `engine_log` VALUES (2554,'2007-08-23 12:17:15',13,'Изменение документа \'Активы\'',4);
INSERT INTO `engine_log` VALUES (2555,'2007-08-23 12:18:18',13,'Изменение документа \'Контакты\'',8);
INSERT INTO `engine_log` VALUES (2556,'2007-08-23 12:18:34',13,'Изменение документа \'Контакты\'',7);
INSERT INTO `engine_log` VALUES (2557,'2007-08-23 12:19:07',13,'Изменение документа \'Группа ГКС\'',6);
INSERT INTO `engine_log` VALUES (2558,'2007-08-23 12:19:21',13,'Изменение документа \'Группа ГКС\'',5);
INSERT INTO `engine_log` VALUES (2559,'2007-08-23 12:26:38',13,'Изменение документа \'Агентирование\'',14);
INSERT INTO `engine_log` VALUES (2560,'2007-08-23 12:36:10',13,'Изменение документа \'Группа ГКС\'',5);
INSERT INTO `engine_log` VALUES (2561,'2007-08-23 12:37:25',13,'Изменение документа \'Группа ГКС\'',5);
INSERT INTO `engine_log` VALUES (2562,'2007-08-23 12:37:39',13,'Изменение документа \'О компании\'',2);
INSERT INTO `engine_log` VALUES (2563,'2007-08-23 12:37:51',13,'Изменение документа \'Агентирование\'',14);
INSERT INTO `engine_log` VALUES (2564,'2007-08-23 12:37:59',13,'Изменение документа \'Экспедирование\'',15);
INSERT INTO `engine_log` VALUES (2565,'2007-08-23 12:38:11',13,'Изменение документа \'Активы\'',4);
INSERT INTO `engine_log` VALUES (2566,'2007-08-23 12:38:44',13,'Изменение документа \'Наши сертификаты\'',12);
INSERT INTO `engine_log` VALUES (2567,'2007-08-23 14:00:27',14,'Изменение шаблона \'main\'',-1);
INSERT INTO `engine_log` VALUES (2568,'2007-08-23 15:15:12',13,'Создание документа \'Команда\'',20);
INSERT INTO `engine_log` VALUES (2569,'2007-08-23 15:15:42',13,'Изменение документа \'Команда\'',20);
INSERT INTO `engine_log` VALUES (2570,'2007-08-23 15:15:53',13,'Изменение документа \'Группа ГКС\'',6);
INSERT INTO `engine_log` VALUES (2571,'2007-08-23 15:16:14',13,'Изменение документа \'О компании\'',1);
INSERT INTO `engine_log` VALUES (2572,'2007-08-23 15:17:00',13,'Изменение документа \'Команда\'',20);
INSERT INTO `engine_log` VALUES (2573,'2007-08-23 15:17:06',13,'Изменение документа \'Команда\'',20);
INSERT INTO `engine_log` VALUES (2574,'2007-08-23 15:18:32',13,'Изменение документа \'Наши сертификаты\'',11);
INSERT INTO `engine_log` VALUES (2575,'2007-08-23 15:19:27',13,'Изменение документа \'Партнеры\'',9);
INSERT INTO `engine_log` VALUES (2576,'2007-08-23 15:19:37',13,'Изменение документа \'Партнеры\'',10);
INSERT INTO `engine_log` VALUES (2577,'2007-08-23 15:19:47',13,'Изменение документа \'Сертификаты\'',11);
INSERT INTO `engine_log` VALUES (2578,'2007-08-23 15:19:55',13,'Изменение документа \'Сертификаты\'',12);
INSERT INTO `engine_log` VALUES (2579,'2007-08-23 15:20:32',13,'Изменение документа \'Команда\'',20);
INSERT INTO `engine_log` VALUES (2580,'2007-08-23 15:20:44',13,'Изменение документа \'Команда\'',20);
INSERT INTO `engine_log` VALUES (2581,'2007-08-23 15:22:26',13,'Изменение документа \'Команда\'',20);
INSERT INTO `engine_log` VALUES (2582,'2007-08-23 15:22:49',13,'Изменение документа \'Команда\'',20);
INSERT INTO `engine_log` VALUES (2583,'2007-08-23 15:24:55',13,'Изменение документа \'Команда\'',20);
INSERT INTO `engine_log` VALUES (2584,'2007-08-23 15:26:23',13,'Изменение документа \'Команда\'',20);
INSERT INTO `engine_log` VALUES (2585,'2007-08-23 15:26:45',13,'Изменение документа \'Команда\'',20);
INSERT INTO `engine_log` VALUES (2586,'2007-08-23 15:26:57',13,'Изменение документа \'Команда\'',20);
INSERT INTO `engine_log` VALUES (2587,'2007-08-23 15:28:07',13,'Изменение документа \'Команда\'',20);
INSERT INTO `engine_log` VALUES (2588,'2007-08-23 15:28:31',13,'Изменение документа \'Команда\'',20);
INSERT INTO `engine_log` VALUES (2589,'2007-08-23 15:28:46',13,'Изменение документа \'Команда\'',20);
INSERT INTO `engine_log` VALUES (2590,'2007-08-23 15:28:50',13,'Изменение документа \'Команда\'',20);
INSERT INTO `engine_log` VALUES (2591,'2007-08-23 15:28:55',13,'Изменение документа \'Команда\'',20);
INSERT INTO `engine_log` VALUES (2592,'2007-08-23 15:32:00',13,'Изменение документа \'Команда\'',20);
INSERT INTO `engine_log` VALUES (2593,'2007-08-23 15:35:26',14,'Изменение документа \'Новости\'',17);
INSERT INTO `engine_log` VALUES (2594,'2007-08-23 16:38:35',14,'Изменение документа \'Новости\'',17);
INSERT INTO `engine_log` VALUES (2595,'2007-08-23 16:40:22',14,'Изменение шаблона \'main\'',-1);
INSERT INTO `engine_log` VALUES (2596,'2007-08-23 16:45:07',14,'Изменение шаблона \'main\'',-1);
INSERT INTO `engine_log` VALUES (2597,'2007-08-23 16:45:55',14,'Изменение шаблона \'main\'',-1);
INSERT INTO `engine_log` VALUES (2598,'2007-08-23 16:49:12',14,'Изменение шаблона \'main\'',-1);
INSERT INTO `engine_log` VALUES (2599,'2007-08-23 16:50:29',14,'Изменение шаблона \'main\'',-1);
INSERT INTO `engine_log` VALUES (2600,'2007-08-23 16:54:58',14,'Изменение шаблона \'main\'',-1);
INSERT INTO `engine_log` VALUES (2601,'2007-08-23 16:55:11',14,'Изменение шаблона \'main\'',-1);
INSERT INTO `engine_log` VALUES (2602,'2007-08-23 16:55:50',14,'Изменение шаблона \'main\'',-1);
INSERT INTO `engine_log` VALUES (2603,'2007-08-23 16:56:01',14,'Изменение шаблона \'main\'',-1);
INSERT INTO `engine_log` VALUES (2604,'2007-08-23 16:58:03',14,'Изменение шаблона \'main\'',-1);
INSERT INTO `engine_log` VALUES (2605,'2007-08-23 17:27:08',14,'Изменение шаблона \'main\'',-1);
INSERT INTO `engine_log` VALUES (2606,'2007-08-23 17:54:11',14,'Изменение шаблона \'main\'',-1);
INSERT INTO `engine_log` VALUES (2607,'2007-08-24 21:44:24',14,'Изменение шаблона \'main\'',-1);
INSERT INTO `engine_log` VALUES (2608,'2007-08-24 21:46:13',14,'Изменение шаблона \'main\'',-1);
INSERT INTO `engine_log` VALUES (2609,'2007-08-24 21:46:32',14,'Изменение шаблона \'main\'',-1);
INSERT INTO `engine_log` VALUES (2610,'2007-08-24 21:53:42',14,'Изменение шаблона \'main\'',-1);
INSERT INTO `engine_log` VALUES (2611,'2007-08-24 21:54:14',14,'Изменение шаблона \'main\'',-1);
INSERT INTO `engine_log` VALUES (2612,'2007-08-24 21:55:41',14,'Изменение шаблона \'main\'',-1);
INSERT INTO `engine_log` VALUES (2613,'2007-08-24 21:56:20',14,'Изменение шаблона \'main\'',-1);
INSERT INTO `engine_log` VALUES (2614,'2007-08-24 21:57:13',14,'Изменение шаблона \'main\'',-1);
INSERT INTO `engine_log` VALUES (2615,'2007-08-24 21:57:25',14,'Изменение шаблона \'main\'',-1);
INSERT INTO `engine_log` VALUES (2616,'2007-08-31 15:16:38',13,'Создание документа \'Китайский\'',21);
INSERT INTO `engine_log` VALUES (2617,'2007-08-31 15:16:56',13,'Изменение документа \'Китайский\'',21);
INSERT INTO `engine_log` VALUES (2618,'2007-08-31 15:17:06',13,'Удаление документа \'Китайский\'',21);
INSERT INTO `engine_log` VALUES (2619,'2007-08-31 15:17:16',13,'Создание документа \'Китайский\'',22);
INSERT INTO `engine_log` VALUES (2620,'2007-08-31 15:17:22',13,'Изменение документа \'Китайский\'',22);
INSERT INTO `engine_log` VALUES (2621,'2007-08-31 15:17:57',13,'Удаление документа \'Китайский\'',22);
INSERT INTO `engine_log` VALUES (2622,'2007-09-05 17:10:28',14,'Изменение шаблона \'main\'',-1);
INSERT INTO `engine_log` VALUES (2623,'2007-09-06 12:54:59',13,'Создание папки \'eng\'',23);
INSERT INTO `engine_log` VALUES (2624,'2007-09-06 12:55:13',13,'Создание папки \'chain\'',24);
INSERT INTO `engine_log` VALUES (2625,'2007-09-06 12:55:19',13,'Изменение документа \'chain\'',24);
INSERT INTO `engine_log` VALUES (2626,'2007-09-06 12:55:26',13,'Изменение документа \'eng\'',23);
INSERT INTO `engine_log` VALUES (2627,'2007-09-06 16:34:30',14,'Создание папки \'rus\'',25);
INSERT INTO `engine_log` VALUES (2628,'2007-09-06 16:34:44',14,'Изменение документа \'chain\'',24);
INSERT INTO `engine_log` VALUES (2629,'2007-09-06 16:42:52',14,'Добавление шаблона \'_header\'',-2);
INSERT INTO `engine_log` VALUES (2630,'2007-09-06 16:43:02',14,'Изменение шаблона \'main\'',-1);
INSERT INTO `engine_log` VALUES (2631,'2007-09-06 16:43:05',14,'Изменение шаблона \'_header\'',-2);
INSERT INTO `engine_log` VALUES (2632,'2007-09-06 16:43:20',14,'Изменение шаблона \'main\'',-1);
INSERT INTO `engine_log` VALUES (2633,'2007-09-06 16:43:27',14,'Добавление шаблона \'_footer\'',-3);
INSERT INTO `engine_log` VALUES (2634,'2007-09-06 16:43:30',14,'Изменение шаблона \'_footer\'',-3);
INSERT INTO `engine_log` VALUES (2635,'2007-09-06 16:43:35',14,'Добавление шаблона \'first\'',-4);
INSERT INTO `engine_log` VALUES (2636,'2007-09-06 16:43:51',14,'Изменение шаблона \'main\'',-1);
INSERT INTO `engine_log` VALUES (2637,'2007-09-06 16:44:10',14,'Изменение шаблона \'first\'',-4);
INSERT INTO `engine_log` VALUES (2638,'2007-09-06 16:44:25',14,'Изменение шаблона \'main\'',-1);
INSERT INTO `engine_log` VALUES (2639,'2007-09-06 16:44:34',14,'Изменение шаблона \'first\'',-4);
INSERT INTO `engine_log` VALUES (2640,'2007-09-06 16:45:45',14,'Изменение шаблона \'main\'',-1);
INSERT INTO `engine_log` VALUES (2641,'2007-09-06 16:46:33',14,'Изменение шаблона \'_header\'',-2);
INSERT INTO `engine_log` VALUES (2642,'2007-09-06 16:47:08',14,'Изменение шаблона \'_header\'',-2);
INSERT INTO `engine_log` VALUES (2643,'2007-09-06 16:52:14',14,'Изменение шаблона \'_header\'',-2);
INSERT INTO `engine_log` VALUES (2644,'2007-09-06 16:52:30',14,'Создание папки \'About\'',26);
INSERT INTO `engine_log` VALUES (2645,'2007-09-06 16:52:41',14,'Создание документа \'111\'',27);
INSERT INTO `engine_log` VALUES (2646,'2007-09-06 16:52:48',14,'Изменение документа \'About\'',26);
INSERT INTO `engine_log` VALUES (2647,'2007-09-06 16:53:18',14,'Изменение документа \'rus\'',25);
INSERT INTO `engine_log` VALUES (2648,'2007-09-06 16:53:26',14,'Изменение документа \'О компании\'',1);
INSERT INTO `engine_log` VALUES (2649,'2007-09-06 16:53:31',14,'Изменение документа \'Услуги\'',13);
INSERT INTO `engine_log` VALUES (2650,'2007-09-06 16:53:44',14,'Изменение документа \'Активы\'',3);
INSERT INTO `engine_log` VALUES (2651,'2007-09-06 16:53:51',14,'Изменение документа \'Группа ГКС\'',5);
INSERT INTO `engine_log` VALUES (2652,'2007-09-06 16:53:56',14,'Изменение документа \'Партнеры\'',9);
INSERT INTO `engine_log` VALUES (2653,'2007-09-06 16:54:01',14,'Изменение документа \'Сертификаты\'',11);
INSERT INTO `engine_log` VALUES (2654,'2007-09-06 16:54:06',14,'Изменение документа \'Контакты\'',7);
INSERT INTO `engine_log` VALUES (2655,'2007-09-06 16:55:41',14,'Создание документа \'main_eng\'',28);
INSERT INTO `engine_log` VALUES (2656,'2007-09-06 16:55:51',14,'Изменение документа \'eng\'',23);
INSERT INTO `engine_log` VALUES (2657,'2007-09-06 16:56:07',14,'Изменение документа \'Главная\'',16);
INSERT INTO `engine_log` VALUES (2658,'2007-09-06 16:56:11',14,'Удаление документа \'Главная\'',19);
INSERT INTO `engine_log` VALUES (2659,'2007-09-06 16:56:28',14,'Изменение документа \'eng\'',23);
INSERT INTO `engine_log` VALUES (2660,'2007-09-06 16:56:49',14,'Изменение шаблона \'first\'',-4);
INSERT INTO `engine_log` VALUES (2661,'2007-09-06 16:57:30',14,'Создание документа \'main_cn\'',29);
INSERT INTO `engine_log` VALUES (2662,'2007-09-06 16:57:37',14,'Создание папки \'Aboud\'',30);
INSERT INTO `engine_log` VALUES (2663,'2007-09-06 16:57:45',14,'Изменение документа \'chain\'',24);
INSERT INTO `engine_log` VALUES (2664,'2007-09-06 16:57:53',14,'Изменение документа \'Aboud\'',30);
INSERT INTO `engine_log` VALUES (2665,'2007-09-06 17:00:25',14,'Изменение шаблона \'first\'',-4);
INSERT INTO `engine_log` VALUES (2666,'2007-09-06 17:01:50',14,'Изменение шаблона \'first\'',-4);
INSERT INTO `engine_log` VALUES (2667,'2007-09-09 14:45:04',14,'Изменение документа \'Новости\'',17);
INSERT INTO `engine_log` VALUES (2668,'2007-09-09 14:49:36',14,'Изменение документа \'Контакты\'',8);
INSERT INTO `engine_log` VALUES (2669,'2007-09-09 16:49:17',14,'Изменение документа \'news\'',8);
INSERT INTO `engine_log` VALUES (2670,'2007-09-09 17:14:17',14,'Изменение документа \'Newses\'',27);
INSERT INTO `engine_log` VALUES (2671,'2007-09-09 17:17:20',14,'Изменение шаблона \'_footer\'',-3);
INSERT INTO `engine_log` VALUES (2672,'2007-09-09 17:17:40',14,'Изменение документа \'Новости\'',17);
INSERT INTO `engine_log` VALUES (2673,'2007-09-10 14:33:48',13,'Изменение документа \'О нас\'',1);
INSERT INTO `engine_log` VALUES (2674,'2007-09-10 14:34:18',13,'Создание документа \'Наши ценности\'',31);
INSERT INTO `engine_log` VALUES (2675,'2007-09-10 14:34:39',13,'Создание документа \'Наш бизнес\'',32);
INSERT INTO `engine_log` VALUES (2676,'2007-09-10 14:35:09',13,'Изменение документа \'Наша команда\'',20);
INSERT INTO `engine_log` VALUES (2677,'2007-09-10 14:35:32',13,'Создание документа \'Наши офисы\'',33);
INSERT INTO `engine_log` VALUES (2678,'2007-09-10 14:35:52',13,'Создание документа \'Наши партнеры\'',34);
INSERT INTO `engine_log` VALUES (2679,'2007-09-10 14:36:09',13,'Создание документа \'Наши сертификаты\'',35);
INSERT INTO `engine_log` VALUES (2680,'2007-09-10 14:36:55',13,'Изменение документа \'О нас\'',1);
INSERT INTO `engine_log` VALUES (2681,'2007-09-10 14:38:21',13,'Изменение документа \'Наш бизнес\'',32);
INSERT INTO `engine_log` VALUES (2682,'2007-09-10 14:38:30',13,'Удаление документа \'О компании\'',2);
INSERT INTO `engine_log` VALUES (2683,'2007-09-10 14:38:37',13,'Изменение документа \'О нас\'',1);
INSERT INTO `engine_log` VALUES (2684,'2007-09-10 14:39:29',13,'Изменение документа \'Наши партнеры\'',34);
INSERT INTO `engine_log` VALUES (2685,'2007-09-10 14:39:49',13,'Изменение документа \'Наши сертификаты\'',35);
INSERT INTO `engine_log` VALUES (2686,'2007-09-10 14:41:01',13,'Создание документа \'Перевалка\'',36);
INSERT INTO `engine_log` VALUES (2687,'2007-09-10 14:41:24',13,'Создание документа \'Логистика\'',37);
INSERT INTO `engine_log` VALUES (2688,'2007-09-10 14:41:57',13,'Создание документа \'Таможенное оформление\'',38);
INSERT INTO `engine_log` VALUES (2689,'2007-09-10 14:42:08',13,'Изменение документа \'Услуги\'',13);
INSERT INTO `engine_log` VALUES (2690,'2007-09-10 14:42:58',13,'Изменение документа \'Услуги\'',13);
INSERT INTO `engine_log` VALUES (2691,'2007-09-10 14:43:31',13,'Создание документа \'Автотранспорт\'',39);
INSERT INTO `engine_log` VALUES (2692,'2007-09-10 14:43:51',13,'Создание документа \'Платформы\'',40);
INSERT INTO `engine_log` VALUES (2693,'2007-09-10 14:44:06',13,'Создание документа \'Терминалы\'',41);
INSERT INTO `engine_log` VALUES (2694,'2007-09-10 14:44:25',13,'Создание документа \'Оборудование\'',42);
INSERT INTO `engine_log` VALUES (2695,'2007-09-10 14:44:39',13,'Изменение документа \'Активы\'',3);
INSERT INTO `engine_log` VALUES (2696,'2007-09-10 14:45:10',13,'Изменение документа \'Наши ценности\'',31);
INSERT INTO `engine_log` VALUES (2697,'2007-09-10 14:45:16',13,'Удаление документа \'Активы\'',4);
INSERT INTO `engine_log` VALUES (2698,'2007-09-10 14:45:25',13,'Изменение документа \'Активы\'',3);
INSERT INTO `engine_log` VALUES (2699,'2007-09-10 14:45:51',13,'Удаление документа \'Сертификаты\'',12);
INSERT INTO `engine_log` VALUES (2700,'2007-09-10 14:45:51',13,'Удаление документа \'Сертификаты\'',11);
INSERT INTO `engine_log` VALUES (2701,'2007-09-10 14:45:55',13,'Удаление документа \'Партнеры\'',10);
INSERT INTO `engine_log` VALUES (2702,'2007-09-10 14:45:55',13,'Удаление документа \'Партнеры\'',9);
INSERT INTO `engine_log` VALUES (2703,'2007-09-10 14:47:08',13,'Изменение документа \'Агентирование\'',14);
INSERT INTO `engine_log` VALUES (2704,'2007-09-10 14:47:55',13,'Создание документа \'Контакты\'',43);
INSERT INTO `engine_log` VALUES (2705,'2007-09-10 14:48:00',13,'Удаление документа \'Контакты\'',7);
INSERT INTO `engine_log` VALUES (2706,'2007-09-10 14:48:09',13,'Изменение документа \'rus\'',25);
INSERT INTO `engine_log` VALUES (2707,'2007-09-10 14:53:38',13,'Создание документа \'News\'',6);
INSERT INTO `engine_log` VALUES (2708,'2007-09-10 14:54:11',13,'Создание папки \'About us\'',45);
INSERT INTO `engine_log` VALUES (2709,'2007-09-10 14:54:53',13,'Создание документа \'Our business\'',46);
INSERT INTO `engine_log` VALUES (2710,'2007-09-10 14:55:25',13,'Создание документа \'our values\'',47);
INSERT INTO `engine_log` VALUES (2711,'2007-09-10 14:55:35',13,'Изменение документа \'Our values\'',47);
INSERT INTO `engine_log` VALUES (2712,'2007-09-10 14:55:53',13,'Создание документа \'Our team\'',48);
INSERT INTO `engine_log` VALUES (2713,'2007-09-10 14:56:24',13,'Создание документа \'Our network\'',49);
INSERT INTO `engine_log` VALUES (2714,'2007-09-10 14:56:53',13,'Создание документа \'Our partners\'',50);
INSERT INTO `engine_log` VALUES (2715,'2007-09-10 14:57:26',13,'Создание документа \'Our memberships\'',51);
INSERT INTO `engine_log` VALUES (2716,'2007-09-10 14:58:00',13,'Изменение документа \'About us\'',45);
INSERT INTO `engine_log` VALUES (2717,'2007-09-10 14:58:05',13,'Изменение документа \'About us\'',45);
INSERT INTO `engine_log` VALUES (2718,'2007-09-10 14:58:40',13,'Создание папки \'Services\'',52);
INSERT INTO `engine_log` VALUES (2719,'2007-09-10 14:59:15',13,'Создание документа \'Liner agency\'',53);
INSERT INTO `engine_log` VALUES (2720,'2007-09-10 15:00:24',13,'Создание документа \'Freight forwarding\'',54);
INSERT INTO `engine_log` VALUES (2721,'2007-09-10 15:01:16',13,'Создание документа \'Terminal handling\'',55);
INSERT INTO `engine_log` VALUES (2722,'2007-09-10 15:02:16',13,'Создание документа \'Logistics\'',56);
INSERT INTO `engine_log` VALUES (2723,'2007-09-10 15:02:43',13,'Создание документа \'Customs\'',57);
INSERT INTO `engine_log` VALUES (2724,'2007-09-10 15:02:58',13,'Изменение документа \'Services\'',52);
INSERT INTO `engine_log` VALUES (2725,'2007-09-10 15:03:22',13,'Создание папки \'Assets\'',58);
INSERT INTO `engine_log` VALUES (2726,'2007-09-10 15:04:00',13,'Создание документа \'Trucking\'',59);
INSERT INTO `engine_log` VALUES (2727,'2007-09-10 15:04:33',13,'Создание документа \'Railway wagons\'',60);
INSERT INTO `engine_log` VALUES (2728,'2007-09-10 15:04:56',13,'Создание документа \'Terminals\'',61);
INSERT INTO `engine_log` VALUES (2729,'2007-09-10 15:05:29',13,'Создание документа \'Equipment\'',62);
INSERT INTO `engine_log` VALUES (2730,'2007-09-10 15:05:52',13,'Изменение документа \'Assets\'',58);
INSERT INTO `engine_log` VALUES (2731,'2007-09-10 15:06:38',13,'Создание папки \'Group of companies\'',63);
INSERT INTO `engine_log` VALUES (2732,'2007-09-10 15:07:10',13,'Создание документа \'Contacts\'',64);
INSERT INTO `engine_log` VALUES (2733,'2007-09-10 15:07:56',13,'Изменение документа \'eng\'',23);
INSERT INTO `engine_log` VALUES (2734,'2007-09-10 15:08:27',13,'Изменение документа \'About\'',26);
INSERT INTO `engine_log` VALUES (2735,'2007-09-11 12:33:09',13,'Изменение документа \'О НАС\'',1);
INSERT INTO `engine_log` VALUES (2736,'2007-09-11 12:33:41',13,'Изменение документа \'НОВОСТИ\'',17);
INSERT INTO `engine_log` VALUES (2737,'2007-09-11 12:33:56',13,'Изменение документа \'УСЛУГИ\'',13);
INSERT INTO `engine_log` VALUES (2738,'2007-09-11 12:34:07',13,'Изменение документа \'АКТИВЫ\'',3);
INSERT INTO `engine_log` VALUES (2739,'2007-09-11 12:34:17',13,'Изменение документа \'ГРУППА ГКС\'',5);
INSERT INTO `engine_log` VALUES (2740,'2007-09-11 12:34:35',13,'Изменение документа \'КОНТАКТЫ\'',43);
INSERT INTO `engine_log` VALUES (2741,'2007-09-11 12:34:48',13,'Изменение документа \'ГЛАВНАЯ\'',16);
INSERT INTO `engine_log` VALUES (2742,'2007-09-11 12:37:45',13,'Изменение документа \'Перевалка\'',36);
INSERT INTO `engine_log` VALUES (2743,'2007-09-11 12:37:58',13,'Изменение документа \'Перевалка\'',36);
INSERT INTO `engine_log` VALUES (2744,'2007-09-11 12:38:05',13,'Изменение документа \'Логистика\'',37);
INSERT INTO `engine_log` VALUES (2745,'2007-09-11 12:38:15',13,'Изменение документа \'Логистика\'',37);
INSERT INTO `engine_log` VALUES (2746,'2007-09-11 12:57:36',13,'Изменение документа \'Логистика\'',37);
INSERT INTO `engine_log` VALUES (2747,'2007-09-11 12:57:56',13,'Изменение документа \'Перевалка\'',36);
INSERT INTO `engine_log` VALUES (2748,'2007-09-11 12:58:05',13,'Изменение документа \'Логистика\'',37);
INSERT INTO `engine_log` VALUES (2749,'2007-09-11 12:58:41',13,'Изменение документа \'Таможенное оформление\'',38);
INSERT INTO `engine_log` VALUES (2750,'2007-09-11 13:00:29',13,'Изменение документа \'ABOUT US\'',45);
INSERT INTO `engine_log` VALUES (2751,'2007-09-11 13:00:44',13,'Изменение документа \'SERVICES\'',52);
INSERT INTO `engine_log` VALUES (2752,'2007-09-11 13:00:57',13,'Изменение документа \'ASSETS\'',58);
INSERT INTO `engine_log` VALUES (2753,'2007-09-11 13:01:08',13,'Изменение документа \'GROUP OF COMPANIES\'',63);
INSERT INTO `engine_log` VALUES (2754,'2007-09-11 13:01:22',13,'Изменение документа \'CONTACTS\'',64);
INSERT INTO `engine_log` VALUES (2755,'2007-09-11 13:01:42',13,'Изменение документа \'NEWS\'',44);
INSERT INTO `engine_log` VALUES (2756,'2007-09-11 13:02:06',13,'Изменение документа \'MAIN_ENG\'',28);
INSERT INTO `engine_log` VALUES (2757,'2007-09-11 13:02:50',13,'Изменение документа \'rus\'',25);
INSERT INTO `engine_log` VALUES (2758,'2007-09-12 16:21:48',5,'Изменение документа \'MAIN\'',28);
INSERT INTO `engine_log` VALUES (2759,'2007-09-12 16:21:59',5,'Изменение документа \'MAIN\'',28);
INSERT INTO `engine_log` VALUES (2760,'2007-09-12 16:26:59',5,'Создание документа \'\'',65);
INSERT INTO `engine_log` VALUES (2761,'2007-09-13 01:39:52',2,'Изменение документа \'rus\'',25);
INSERT INTO `engine_log` VALUES (2762,'2007-09-13 01:41:27',2,'Изменение шаблона \'_header\'',-2);
INSERT INTO `engine_log` VALUES (2763,'2007-09-13 01:42:28',2,'Изменение шаблона \'_header\'',-2);
INSERT INTO `engine_log` VALUES (2764,'2007-09-13 11:12:35',13,'Изменение документа \'Наша компания\'',32);
INSERT INTO `engine_log` VALUES (2765,'2007-09-13 11:13:20',13,'Изменение документа \'Our company\'',46);
INSERT INTO `engine_log` VALUES (2766,'2007-09-13 11:16:48',13,'Изменение документа \'Автотранспорт\'',39);
INSERT INTO `engine_log` VALUES (2767,'2007-09-13 11:17:14',13,'Изменение документа \'Автотранспорт\'',39);
INSERT INTO `engine_log` VALUES (2768,'2007-09-13 11:17:33',13,'Изменение документа \'Платформы\'',40);
INSERT INTO `engine_log` VALUES (2769,'2007-09-13 11:18:21',13,'Изменение документа \'Терминалы\'',41);
INSERT INTO `engine_log` VALUES (2770,'2007-09-13 11:19:51',13,'Изменение документа \'Оборудование\'',42);
INSERT INTO `engine_log` VALUES (2771,'2007-09-13 11:20:34',13,'Изменение документа \'Оборудование\'',42);
INSERT INTO `engine_log` VALUES (2772,'2007-09-13 11:20:54',13,'Изменение документа \'Оборудование\'',42);
INSERT INTO `engine_log` VALUES (2773,'2007-09-13 11:21:46',13,'Изменение документа \'Группа ГКС\'',6);
INSERT INTO `engine_log` VALUES (2774,'2007-09-13 11:23:57',13,'Изменение документа \'chinese\'',24);
INSERT INTO `engine_log` VALUES (2775,'2007-09-13 11:30:49',13,'Изменение документа \'Группа ГКС\'',6);
INSERT INTO `engine_log` VALUES (2776,'2007-09-13 11:31:31',13,'Изменение документа \'Группа ГКС\'',6);
INSERT INTO `engine_log` VALUES (2777,'2007-09-13 11:31:55',13,'Изменение документа \'Группа ГКС\'',6);
INSERT INTO `engine_log` VALUES (2778,'2007-09-13 11:32:20',13,'Изменение документа \'Группа ГКС\'',6);
INSERT INTO `engine_log` VALUES (2779,'2007-09-13 11:34:10',13,'Изменение документа \'Группа ГКС\'',6);
INSERT INTO `engine_log` VALUES (2780,'2007-09-13 11:36:26',13,'Изменение документа \'Группа ГКС\'',6);
INSERT INTO `engine_log` VALUES (2781,'2007-09-13 11:36:32',13,'Изменение документа \'Группа ГКС\'',6);
INSERT INTO `engine_log` VALUES (2782,'2007-09-13 11:37:01',13,'Изменение документа \'Группа ГКС\'',6);
INSERT INTO `engine_log` VALUES (2783,'2007-09-13 11:37:30',13,'Изменение документа \'Группа ГКС\'',6);
INSERT INTO `engine_log` VALUES (2784,'2007-09-13 11:38:22',13,'Изменение документа \'Группа ГКС\'',6);
INSERT INTO `engine_log` VALUES (2785,'2007-09-13 11:38:26',13,'Изменение документа \'Группа ГКС\'',6);
INSERT INTO `engine_log` VALUES (2786,'2007-09-13 11:39:23',13,'Изменение документа \'Группа ГКС\'',6);
INSERT INTO `engine_log` VALUES (2787,'2007-09-13 11:43:23',13,'Изменение документа \'Группа ГКС\'',6);
INSERT INTO `engine_log` VALUES (2788,'2007-09-13 11:45:03',13,'Изменение документа \'Группа ГКС\'',6);
INSERT INTO `engine_log` VALUES (2789,'2007-09-13 11:52:52',13,'Изменение документа \'Группа ГКС\'',6);
INSERT INTO `engine_log` VALUES (2790,'2007-09-13 11:56:55',13,'Изменение документа \'Группа ГКС\'',6);
INSERT INTO `engine_log` VALUES (2791,'2007-09-13 12:00:47',13,'Изменение документа \'Группа ГКС\'',6);
INSERT INTO `engine_log` VALUES (2792,'2007-09-13 12:02:21',13,'Изменение документа \'КОНТАКТЫ\'',43);
INSERT INTO `engine_log` VALUES (2793,'2007-09-13 12:02:53',13,'Изменение документа \'КОНТАКТЫ\'',43);
INSERT INTO `engine_log` VALUES (2794,'2007-09-13 12:03:03',13,'Изменение документа \'КОНТАКТЫ\'',43);
INSERT INTO `engine_log` VALUES (2795,'2007-09-13 12:03:23',13,'Изменение документа \'КОНТАКТЫ\'',43);
INSERT INTO `engine_log` VALUES (2796,'2007-09-13 12:17:58',13,'Изменение документа \'Группа ГКС\'',6);
INSERT INTO `engine_log` VALUES (2797,'2007-09-13 12:18:22',13,'Изменение документа \'Группа ГКС\'',6);
INSERT INTO `engine_log` VALUES (2798,'2007-09-13 12:19:00',13,'Изменение документа \'Группа ГКС\'',6);
INSERT INTO `engine_log` VALUES (2799,'2007-09-13 12:19:48',13,'Изменение документа \'Группа ГКС\'',6);
INSERT INTO `engine_log` VALUES (2800,'2007-09-13 12:25:46',2,'Изменение шаблона \'_header\'',-2);
INSERT INTO `engine_log` VALUES (2801,'2007-09-13 12:43:48',11,'Изменение шаблона \'_header\'',-2);
INSERT INTO `engine_log` VALUES (2802,'2007-09-13 12:44:14',11,'Изменение шаблона \'_header\'',-2);
INSERT INTO `engine_log` VALUES (2803,'2007-09-13 12:45:30',11,'Изменение шаблона \'main\'',-1);
INSERT INTO `engine_log` VALUES (2804,'2007-09-13 12:46:24',11,'Изменение шаблона \'main\'',-1);
INSERT INTO `engine_log` VALUES (2805,'2007-09-13 12:47:23',11,'Изменение шаблона \'_header\'',-2);
INSERT INTO `engine_log` VALUES (2806,'2007-09-13 12:47:31',11,'Изменение шаблона \'main\'',-1);
INSERT INTO `engine_log` VALUES (2807,'2007-09-13 12:49:48',11,'Изменение шаблона \'_header\'',-2);
INSERT INTO `engine_log` VALUES (2808,'2007-09-13 12:50:16',11,'Изменение шаблона \'_header\'',-2);
INSERT INTO `engine_log` VALUES (2809,'2007-09-13 12:51:21',11,'Изменение шаблона \'main\'',-1);
INSERT INTO `engine_log` VALUES (2810,'2007-09-13 12:51:25',11,'Изменение шаблона \'_header\'',-2);
INSERT INTO `engine_log` VALUES (2811,'2007-09-13 12:51:51',11,'Изменение шаблона \'_header\'',-2);
INSERT INTO `engine_log` VALUES (2812,'2007-09-13 12:52:35',11,'Изменение шаблона \'_header\'',-2);
INSERT INTO `engine_log` VALUES (2813,'2007-09-13 12:53:23',11,'Изменение шаблона \'_header\'',-2);
INSERT INTO `engine_log` VALUES (2814,'2007-09-13 12:53:36',11,'Изменение шаблона \'_header\'',-2);
INSERT INTO `engine_log` VALUES (2815,'2007-09-13 12:53:50',11,'Изменение шаблона \'main\'',-1);
INSERT INTO `engine_log` VALUES (2816,'2007-09-13 12:55:44',11,'Изменение документа \'Наша компания\'',32);
INSERT INTO `engine_log` VALUES (2817,'2007-09-13 12:56:02',11,'Изменение шаблона \'_header\'',-2);
INSERT INTO `engine_log` VALUES (2818,'2007-09-13 12:56:18',11,'Изменение шаблона \'_header\'',-2);
INSERT INTO `engine_log` VALUES (2819,'2007-09-13 12:56:32',11,'Изменение шаблона \'main\'',-1);
INSERT INTO `engine_log` VALUES (2820,'2007-09-13 12:57:13',11,'Изменение шаблона \'main\'',-1);
INSERT INTO `engine_log` VALUES (2821,'2007-09-13 12:57:39',11,'Изменение шаблона \'main\'',-1);
INSERT INTO `engine_log` VALUES (2822,'2007-09-13 12:57:45',11,'Изменение шаблона \'main\'',-1);
INSERT INTO `engine_log` VALUES (2823,'2007-09-13 12:58:24',11,'Изменение шаблона \'main\'',-1);
INSERT INTO `engine_log` VALUES (2824,'2007-09-13 13:00:06',2,'Изменение шаблона \'_header\'',-2);
INSERT INTO `engine_log` VALUES (2825,'2007-09-13 13:00:52',2,'Изменение шаблона \'_header\'',-2);
INSERT INTO `engine_log` VALUES (2826,'2007-09-13 13:04:26',2,'Изменение шаблона \'_header\'',-2);
INSERT INTO `engine_log` VALUES (2827,'2007-09-13 13:04:58',2,'Изменение шаблона \'_header\'',-2);
INSERT INTO `engine_log` VALUES (2828,'2007-09-13 13:05:46',2,'Изменение шаблона \'_header\'',-2);
INSERT INTO `engine_log` VALUES (2829,'2007-09-13 13:06:09',2,'Изменение шаблона \'_header\'',-2);
INSERT INTO `engine_log` VALUES (2830,'2007-09-13 13:26:37',11,'Изменение шаблона \'_header\'',-2);
INSERT INTO `engine_log` VALUES (2831,'2007-09-13 13:26:52',11,'Изменение шаблона \'_header\'',-2);
INSERT INTO `engine_log` VALUES (2832,'2007-09-13 13:27:10',2,'Изменение шаблона \'_header\'',-2);
INSERT INTO `engine_log` VALUES (2833,'2007-09-13 13:28:35',2,'Изменение шаблона \'_header\'',-2);
INSERT INTO `engine_log` VALUES (2834,'2007-09-13 13:28:47',11,'Изменение шаблона \'_header\'',-2);
INSERT INTO `engine_log` VALUES (2835,'2007-09-13 13:28:59',2,'Изменение шаблона \'_header\'',-2);
INSERT INTO `engine_log` VALUES (2836,'2007-09-13 13:29:52',2,'Изменение шаблона \'_header\'',-2);
INSERT INTO `engine_log` VALUES (2837,'2007-09-13 13:37:22',2,'Изменение шаблона \'main\'',-1);
INSERT INTO `engine_log` VALUES (2838,'2007-09-13 13:38:40',2,'Изменение шаблона \'main\'',-1);
INSERT INTO `engine_log` VALUES (2839,'2007-09-13 13:42:24',2,'Изменение шаблона \'main\'',-1);
INSERT INTO `engine_log` VALUES (2840,'2007-09-13 13:48:41',2,'Изменение шаблона \'main\'',-1);
INSERT INTO `engine_log` VALUES (2841,'2007-09-13 14:00:04',2,'Изменение шаблона \'_header\'',-2);
INSERT INTO `engine_log` VALUES (2842,'2007-09-13 14:00:49',2,'Изменение шаблона \'_header\'',-2);
INSERT INTO `engine_log` VALUES (2843,'2007-09-13 14:02:39',2,'Изменение шаблона \'_header\'',-2);
INSERT INTO `engine_log` VALUES (2844,'2007-09-13 14:03:13',2,'Изменение шаблона \'_header\'',-2);
INSERT INTO `engine_log` VALUES (2845,'2007-09-13 14:20:03',2,'Изменение шаблона \'_header\'',-2);
INSERT INTO `engine_log` VALUES (2846,'2007-09-13 14:27:30',2,'Изменение шаблона \'main\'',-1);
INSERT INTO `engine_log` VALUES (2847,'2007-09-13 14:27:50',2,'Изменение шаблона \'_header\'',-2);
INSERT INTO `engine_log` VALUES (2848,'2007-09-13 14:38:45',2,'Изменение шаблона \'main\'',-1);
INSERT INTO `engine_log` VALUES (2849,'2007-09-13 14:47:36',2,'Создание папки \'НОВОСТИ\'',66);
INSERT INTO `engine_log` VALUES (2850,'2007-09-13 14:47:42',2,'Создание папки \'КОНТАКТЫ\'',67);
INSERT INTO `engine_log` VALUES (2851,'2007-09-13 14:49:44',2,'Изменение документа \'НОВОСТИ\'',66);
INSERT INTO `engine_log` VALUES (2852,'2007-09-13 14:49:48',2,'Изменение документа \'НОВОСТИ\'',66);
INSERT INTO `engine_log` VALUES (2853,'2007-09-13 14:49:56',2,'Изменение документа \'НОВОСТИ\'',17);
INSERT INTO `engine_log` VALUES (2854,'2007-09-13 14:50:03',2,'Изменение документа \'КОНТАКТЫ\'',67);
INSERT INTO `engine_log` VALUES (2855,'2007-09-13 14:50:12',2,'Изменение документа \'КОНТАКТЫ\'',43);
INSERT INTO `engine_log` VALUES (2856,'2007-09-13 14:50:55',2,'Изменение документа \'rus\'',25);
INSERT INTO `engine_log` VALUES (2857,'2007-09-13 14:52:36',2,'Изменение документа \'НОВОСТИ\'',66);
INSERT INTO `engine_log` VALUES (2858,'2007-09-13 14:53:28',2,'Изменение документа \'НОВОСТИ\'',17);
INSERT INTO `engine_log` VALUES (2859,'2007-09-13 14:54:03',2,'Изменение документа \'КОНТАКТЫ\'',43);
INSERT INTO `engine_log` VALUES (2860,'2007-09-13 14:54:33',2,'Изменение документа \'КОНТАКТЫ\'',67);
INSERT INTO `engine_log` VALUES (2861,'2007-09-13 14:54:42',2,'Изменение документа \'НОВОСТИ\'',66);
INSERT INTO `engine_log` VALUES (2862,'2007-09-13 14:54:52',2,'Изменение документа \'НОВОСТИ\'',66);
INSERT INTO `engine_log` VALUES (2863,'2007-09-13 14:54:57',2,'Изменение документа \'НОВОСТИ\'',17);
INSERT INTO `engine_log` VALUES (2864,'2007-09-15 09:30:59',5,'Создание документа \'NEWS\'',68);
INSERT INTO `engine_log` VALUES (2865,'2007-09-15 09:31:14',5,'Удаление документа \'NEWS\'',68);
INSERT INTO `engine_log` VALUES (2866,'2007-09-15 09:31:29',5,'Создание папки \'NEWS\'',69);
INSERT INTO `engine_log` VALUES (2867,'2007-09-15 09:31:37',5,'Создание папки \'CONTACTS\'',70);
INSERT INTO `engine_log` VALUES (2868,'2007-09-17 11:24:36',13,'Изменение документа \'eng\'',23);
INSERT INTO `engine_log` VALUES (2869,'2007-09-17 11:26:52',13,'Изменение документа \'NEWS\'',44);
INSERT INTO `engine_log` VALUES (2870,'2007-09-17 11:26:57',13,'Изменение документа \'NEWS\'',69);
INSERT INTO `engine_log` VALUES (2871,'2007-09-17 11:28:52',13,'Изменение документа \'SERVICES\'',52);
INSERT INTO `engine_log` VALUES (2872,'2007-09-17 11:29:37',13,'Изменение документа \'ASSETS\'',58);
INSERT INTO `engine_log` VALUES (2873,'2007-09-17 11:30:18',13,'Изменение документа \'CONTACTS\'',64);
INSERT INTO `engine_log` VALUES (2874,'2007-09-17 11:32:17',13,'Изменение документа \'CONTACTS\'',70);
INSERT INTO `engine_log` VALUES (2875,'2007-09-17 11:35:05',13,'Изменение документа \'NEWS\'',69);
INSERT INTO `engine_log` VALUES (2876,'2007-09-17 11:40:12',13,'Изменение документа \'CONTACTS\'',70);
INSERT INTO `engine_log` VALUES (2877,'2007-09-17 11:41:00',13,'Изменение документа \'CONTACTS\'',64);
INSERT INTO `engine_log` VALUES (2878,'2007-09-17 11:41:33',13,'Изменение документа \'ABOUT US\'',45);
INSERT INTO `engine_log` VALUES (2879,'2007-09-17 11:41:52',13,'Изменение документа \'SERVICES\'',52);
INSERT INTO `engine_log` VALUES (2880,'2007-09-17 11:42:59',13,'Изменение документа \'ASSETS\'',58);
INSERT INTO `engine_log` VALUES (2881,'2007-09-17 11:43:31',13,'Изменение документа \'GROUP OF COMPANIES\'',63);
INSERT INTO `engine_log` VALUES (2882,'2007-09-17 11:44:59',13,'Изменение документа \'Aboud\'',30);
INSERT INTO `engine_log` VALUES (2883,'2007-09-17 11:46:08',13,'Изменение документа \'main_cn\'',29);
INSERT INTO `engine_log` VALUES (2884,'2007-09-17 12:10:21',13,'Изменение документа \'rus\'',25);
INSERT INTO `engine_log` VALUES (2885,'2007-09-17 12:10:38',13,'Изменение документа \'ГЛАВНАЯ\'',16);
INSERT INTO `engine_log` VALUES (2886,'2007-09-17 12:11:25',13,'Изменение документа \'eng\'',23);
INSERT INTO `engine_log` VALUES (2887,'2007-09-17 12:11:38',13,'Изменение документа \'MAIN\'',28);
INSERT INTO `engine_log` VALUES (2888,'2007-09-17 12:22:26',13,'Создание документа \'a\'',71);
INSERT INTO `engine_log` VALUES (2889,'2007-09-17 12:22:33',13,'Изменение документа \'a\'',71);
INSERT INTO `engine_log` VALUES (2890,'2007-09-17 12:25:21',13,'Изменение документа \'&#25105;&#20204;&#20844;&#21496;\'',71);
INSERT INTO `engine_log` VALUES (2891,'2007-09-17 12:26:33',13,'Изменение документа \'&#25105;&#20204;&#20844;&#21496;\'',71);
INSERT INTO `engine_log` VALUES (2892,'2007-09-17 12:27:20',13,'Изменение документа \'&#25105;&#20204;&#20844;&#21496;\'',71);
INSERT INTO `engine_log` VALUES (2893,'2007-09-17 12:29:47',13,'Изменение документа \'&#25105;&#20204;&#20844;&#21496;\'',71);
INSERT INTO `engine_log` VALUES (2894,'2007-09-17 12:31:03',13,'Изменение документа \'&#25105;&#20204;&#20844;&#21496;\'',71);
INSERT INTO `engine_log` VALUES (2895,'2007-09-17 12:32:13',13,'Изменение документа \'&#25105;&#20204;&#20844;&#21496;\'',71);
INSERT INTO `engine_log` VALUES (2896,'2007-09-17 12:48:27',13,'Создание документа \'????\'',72);
INSERT INTO `engine_log` VALUES (2897,'2007-09-17 12:48:35',13,'Удаление документа \'????\'',72);
INSERT INTO `engine_log` VALUES (2898,'2007-09-17 12:49:10',13,'Изменение документа \'&#25105;&#20204;&#20844;&#21496;\'',71);
INSERT INTO `engine_log` VALUES (2899,'2007-09-17 12:49:48',13,'Изменение документа \'&#25105;&#20204;&#20844;&#21496;\'',71);
INSERT INTO `engine_log` VALUES (2900,'2007-09-17 12:51:22',13,'Изменение документа \'&#25105;&#20204;&#20844;&#21496;\'',71);
INSERT INTO `engine_log` VALUES (2901,'2007-09-17 12:51:37',13,'Изменение документа \'&#25105;&#20204;&#20844;&#21496;\'',71);
INSERT INTO `engine_log` VALUES (2902,'2007-09-17 12:51:43',13,'Изменение документа \'chinese\'',24);
INSERT INTO `engine_log` VALUES (2903,'2007-09-17 14:53:10',13,'Изменение документа \'Наша компания\'',32);
INSERT INTO `engine_log` VALUES (2904,'2007-09-17 14:53:22',13,'Изменение документа \'Наша компания\'',32);
INSERT INTO `engine_log` VALUES (2905,'2007-09-17 14:53:37',13,'Изменение документа \'Наши ценности\'',31);
INSERT INTO `engine_log` VALUES (2906,'2007-09-17 14:53:58',13,'Изменение документа \'Наши партнеры\'',34);
INSERT INTO `engine_log` VALUES (2907,'2007-09-17 14:54:10',13,'Изменение документа \'Наши сертификаты\'',35);
INSERT INTO `engine_log` VALUES (2908,'2007-09-17 14:54:20',13,'Изменение документа \'Агентирование\'',14);
INSERT INTO `engine_log` VALUES (2909,'2007-09-17 14:54:30',13,'Изменение документа \'Экспедирование\'',15);
INSERT INTO `engine_log` VALUES (2910,'2007-09-17 14:54:39',13,'Изменение документа \'Перевалка\'',36);
INSERT INTO `engine_log` VALUES (2911,'2007-09-17 14:54:47',13,'Изменение документа \'Логистика\'',37);
INSERT INTO `engine_log` VALUES (2912,'2007-09-17 14:54:57',13,'Изменение документа \'Таможенное оформление\'',38);
INSERT INTO `engine_log` VALUES (2913,'2007-09-17 14:55:09',13,'Изменение документа \'Автотранспорт\'',39);
INSERT INTO `engine_log` VALUES (2914,'2007-09-17 14:55:17',13,'Изменение документа \'Платформы\'',40);
INSERT INTO `engine_log` VALUES (2915,'2007-09-17 14:55:27',13,'Изменение документа \'Терминалы\'',41);
INSERT INTO `engine_log` VALUES (2916,'2007-09-17 14:55:35',13,'Изменение документа \'Оборудование\'',42);
INSERT INTO `engine_log` VALUES (2917,'2007-09-17 14:56:57',13,'Изменение документа \'КОНТАКТЫ\'',43);
INSERT INTO `engine_log` VALUES (2918,'2007-09-18 10:59:44',2,'Изменение документа \'НОВОСТИ\'',17);
INSERT INTO `engine_log` VALUES (2919,'2007-09-18 11:01:06',2,'Изменение документа \'НОВОСТИ\'',17);
INSERT INTO `engine_log` VALUES (2920,'2007-09-18 11:01:46',2,'Создание документа \'Главная-новости\'',73);
INSERT INTO `engine_log` VALUES (2921,'2007-09-18 11:02:21',2,'Изменение документа \'Главная-новости\'',73);
INSERT INTO `engine_log` VALUES (2922,'2007-09-18 11:02:56',2,'Изменение документа \'Главная-новости\'',73);
INSERT INTO `engine_log` VALUES (2923,'2007-09-18 11:10:12',2,'Изменение документа \'Новости\'',73);
INSERT INTO `engine_log` VALUES (2924,'2007-09-18 12:17:53',11,'Изменение документа \'НОВОСТИ\'',17);
INSERT INTO `engine_log` VALUES (2925,'2007-09-18 12:18:36',11,'Изменение документа \'НОВОСТИ\'',17);
INSERT INTO `engine_log` VALUES (2926,'2007-09-18 12:18:37',11,'Изменение документа \'НОВОСТИ\'',17);
INSERT INTO `engine_log` VALUES (2927,'2007-09-18 12:18:46',11,'Создание документа \'\'',74);
INSERT INTO `engine_log` VALUES (2928,'2007-09-18 12:24:57',11,'Создание документа \'\'',75);
INSERT INTO `engine_log` VALUES (2929,'2007-09-18 12:25:05',11,'Изменение документа \'\'',75);
INSERT INTO `engine_log` VALUES (2930,'2007-09-18 12:25:22',11,'Создание документа \'\'',76);
INSERT INTO `engine_log` VALUES (2931,'2007-09-18 12:25:32',11,'Изменение документа \'\'',76);
INSERT INTO `engine_log` VALUES (2932,'2007-09-18 12:29:11',11,'Изменение документа \'Расширение автопарка \"Рускон\" \'',18);
INSERT INTO `engine_log` VALUES (2933,'2007-09-18 13:53:09',2,'Изменение документа \'eng\'',23);
INSERT INTO `engine_log` VALUES (2934,'2007-09-18 13:53:37',2,'Изменение документа \'eng\'',23);
INSERT INTO `engine_log` VALUES (2935,'2007-09-18 13:56:05',2,'Изменение документа \'rus\'',25);
INSERT INTO `engine_log` VALUES (2936,'2007-09-19 14:54:00',13,'Изменение документа \'Наши офисы\'',33);
INSERT INTO `engine_log` VALUES (2937,'2007-09-19 14:55:42',13,'Изменение документа \'Наши офисы\'',33);

--
-- Table structure for table `engine_objects`
--

DROP TABLE IF EXISTS `engine_objects`;
CREATE TABLE `engine_objects` (
  `id` bigint(20) NOT NULL auto_increment,
  `doc` bigint(20) NOT NULL default '-1',
  `type` varchar(255) NOT NULL default '',
  `name` varchar(255) NOT NULL default '',
  `par1` longtext NOT NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;

--
-- Dumping data for table `engine_objects`
--


--
-- Table structure for table `engine_rubric`
--

DROP TABLE IF EXISTS `engine_rubric`;
CREATE TABLE `engine_rubric` (
  `id` bigint(20) NOT NULL auto_increment,
  `name` text NOT NULL,
  `pid` bigint(20) NOT NULL default '-1',
  `tplrub` bigint(20) NOT NULL default '-1',
  `tpldoc` bigint(20) NOT NULL default '-1',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;

--
-- Dumping data for table `engine_rubric`
--


--
-- Table structure for table `engine_rubrique`
--

DROP TABLE IF EXISTS `engine_rubrique`;
CREATE TABLE `engine_rubrique` (
  `id` bigint(20) NOT NULL auto_increment,
  `pid` bigint(20) NOT NULL default '0',
  `name` longtext NOT NULL,
  `ic` char(1) NOT NULL default 'N',
  PRIMARY KEY  (`id`),
  KEY `engine_idx_rubrique_pid` (`pid`)
) TYPE=MyISAM;

--
-- Dumping data for table `engine_rubrique`
--


--
-- Table structure for table `engine_send`
--

DROP TABLE IF EXISTS `engine_send`;
CREATE TABLE `engine_send` (
  `id` bigint(20) NOT NULL auto_increment,
  `name` longtext NOT NULL,
  `doc_id` bigint(20) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;

--
-- Dumping data for table `engine_send`
--


--
-- Table structure for table `engine_send_emails`
--

DROP TABLE IF EXISTS `engine_send_emails`;
CREATE TABLE `engine_send_emails` (
  `id` bigint(20) NOT NULL auto_increment,
  `email` text NOT NULL,
  `send_id` bigint(20) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;

--
-- Dumping data for table `engine_send_emails`
--


--
-- Table structure for table `engine_stat_hit`
--

DROP TABLE IF EXISTS `engine_stat_hit`;
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
-- Dumping data for table `engine_stat_hit`
--


--
-- Table structure for table `engine_stat_referer`
--

DROP TABLE IF EXISTS `engine_stat_referer`;
CREATE TABLE `engine_stat_referer` (
  `sess_id` varchar(32) NOT NULL default '',
  `ic_sess_id` varchar(32) default NULL,
  `dt` timestamp(14) NOT NULL,
  `referer` text,
  PRIMARY KEY  (`sess_id`)
) TYPE=MyISAM;

--
-- Dumping data for table `engine_stat_referer`
--


--
-- Table structure for table `engine_stat_search`
--

DROP TABLE IF EXISTS `engine_stat_search`;
CREATE TABLE `engine_stat_search` (
  `id` int(11) NOT NULL auto_increment,
  `dt` timestamp(14) NOT NULL,
  `stype` char(1) default NULL,
  `query` varchar(255) default NULL,
  `found` int(11) default NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;

--
-- Dumping data for table `engine_stat_search`
--


--
-- Table structure for table `engine_styles`
--

DROP TABLE IF EXISTS `engine_styles`;
CREATE TABLE `engine_styles` (
  `id` bigint(20) NOT NULL auto_increment,
  `name` text NOT NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;

--
-- Dumping data for table `engine_styles`
--


--
-- Table structure for table `engine_tpl`
--

DROP TABLE IF EXISTS `engine_tpl`;
CREATE TABLE `engine_tpl` (
  `id` bigint(20) NOT NULL auto_increment,
  `name` longtext NOT NULL,
  `body` longtext NOT NULL,
  `type` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;

--
-- Dumping data for table `engine_tpl`
--

INSERT INTO `engine_tpl` VALUES (1,'main','[INCLUDE _header]\r\n<div class=\"bl\" style=\"width: 763px; clear: right;\">\r\n<div class=\"bl cb\" style=\"padding-bottom:1px;\"><img src=\"[DOCFIELD type=\'actimg\' doc_id=\'(%picfold%)\']\" width=\"763\" height=\"138\" alt=\"\" border=\"0\"></div>\r\n[INCLUDE _footer]\r\n',0);
INSERT INTO `engine_tpl` VALUES (3,'_footer','<div class=\"bl\" style=\"margin-right: 1px; border-top: 8px solid #19599D; width: 474px;padding-top: 50px;height: 80%;\">\r\n<h1>[DOCFIELD type=\'name\']</h1>\r\n<div style=\"padding: 25px 30px 30px 0px;\">\r\n[BODY]\r\n</div>\r\n</div>\r\n\r\n<div class=\"bl\" style=\"margin-right: 1px; border-top: 8px solid #A8B6D7; width: 260px;padding-top: 50px;\">\r\n<h1 class=\"news\">[DOCFIELD type=\'name\' doc_id=\'news_(%lang%)\']</h1>\r\n<div style=\"padding: 25px 0 0 22px;\">\r\n[BODY doc_id=\'news_(%lang%)\']\r\n<a class=\"news\"><b>[DOCFIELD type=\'caption_short\' doc_id=\'news_(%lang%)\']</b></a>\r\n[NEWSARC id=\'news_(%lang%)\']\r\n<br clear=\"all\"><br clear=\"all\">\r\n</div>\r\n</div>\r\n\r\n</div>\r\n\r\n\r\n</td></tr>\r\n<tr><td style=\"height: 10%; vertical-align:bottom;\">\r\n<div class=\"bl\" style=\"clear: righth;width:281px; padding: 85px 0 50px 0;\">\r\n<div class=\"bl\" style=\"padding-left: 30px; font-size: 10px;\">\r\n&copy; <a class=\"u\" href=\"#\" style=\"color: #22287A\">GCS</a>. Все права защищены.\r\n</div>\r\n</div>\r\n\r\n\r\n<div class=\"bl\" style=\"clear: right;background:  url(/img/bg-main.gif) no-repeat 0 0; width:773px; height:70px; padding-bottom: 28px;\">\r\n<div class=\"bot\">\r\n[MENU folder=\'-1\'\r\nformat=\'<a href=\"ITEM_LINK\">ITEM_TEXT</a>\'\r\nseparator=\'&nbsp;|&nbsp;\'\r\n]</div>\r\n</div>\r\n<div class=\"bl\" style=\"width:773px;  text-align: right;font-size: 10px;\">\r\n[PHP do=\'copyright.php\']\r\n</div>\r\n\r\n\r\n\r\n</td></tr></table>\r\n</body>\r\n</html>\r\n\r\n',0);
INSERT INTO `engine_tpl` VALUES (4,'first','[INCLUDE _header]\r\n\r\n<div class=\"bl\" style=\"width: 763px; clear: right;\">\r\n<div class=\"bl cb\" style=\"padding-bottom:1px;\">\r\n<object classid=\"clsid:d27cdb6e-ae6d-11cf-96b8-444553540000\" codebase=\"http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0\" width=\"763\" height=\"352\" id=\"gcs_flash\" align=\"middle\">\r\n<param name=\"allowScriptAccess\" value=\"sameDomain\" />\r\n<param name=\"movie\" value=\"/img/gcs_flash_[PHP do=\'echo $doc_vars[lang~];\'].swf\" /><param name=\"quality\" value=\"high\" /><param name=\"bgcolor\" value=\"#ffffff\" /><embed src=\"/img/gcs_flash_[PHP do=\'echo $doc_vars[lang~];\'].swf\" quality=\"high\" bgcolor=\"#ffffff\" width=\"763\" height=\"352\" name=\"gcs_flash\" align=\"middle\" allowScriptAccess=\"sameDomain\" type=\"application/x-shockwave-flash\" pluginspage=\"http://www.macromedia.com/go/getflashplayer\" />\r\n</object>\r\n</div>\r\n[INCLUDE _footer]\r\n',0);
INSERT INTO `engine_tpl` VALUES (2,'_header','[PHP do=\'find_open_folder.php\' in_folder=\'154\']\r\n[PHP do=\'find_open_folder.php\' in_folder=\'-1\' pname=\'lang\']\r\n[PHP do=\'find_open_folder.php\' in_folder=\'(%lang%)\' pname=\'picfold\']\r\n[PHP do=\'if ($doc_vars[folder~]==\"\") $doc_vars[folder~]=$doc_vars[lang~];\']\r\n\r\n<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\">\r\n\r\n<html>\r\n<head>\r\n    <title>[DOCFIELD type=\'title\']</title>\r\n    <link href=\"/css/style.css\" rel=\"stylesheet\" type=\"text/css\">\r\n    <meta http-equiv=\"content-type\" content=\"text/html; charset=windows-1251\">\r\n[DOCFIELD type=\'meta\']\r\n</head>\r\n<body>\r\n<table style=\"height: 100%; width: 100%\"><tr><td style=\"height: 100%; width: 100%;[IF do=\'($doc->code!=\"main\")\']background: url(/img/bg-main.jpg) no-repeat left bottom;[ENDIF]\">\r\n\r\n<table style=\"height: 100%; width: 100%\"><tr><td style=\"height: 90%;width:100%;\">\r\n<div style=\"background-color: #E6E6E6; height: 12px;\"><div style=\"width: 1044px;background-color: #fff; height: 12px;\"></div></div>\r\n<div style=\"margin: 0 0 1px 281px; width: 763px; background-color: #718ABA; height: 1px; clear:both;overflow: hidden;\"></div>\r\n\r\n<div class=\"bl\" style=\"width: 281px;\">\r\n\r\n<div class=\"bl\" style=\"padding: 20px 0 65px 31px;\"><a href=\"/\"><img src=\"/img/logo.gif\" width=\"188\" height=\"77\" alt=\"\" border=\"0\"></a></div>\r\n\r\n<div class=\"bl menu\" style=\"padding-left: 37px;\">\r\n\r\n[MENU folder=\'(%lang%)\'\r\ndeep_search=\'2\'\r\nonly_open_docs=\'1\'\r\nonly_open_docs1=\'1\'\r\nformat=\'<a class=\"unact\" href=\"ITEM_LINK\"><span>ITEM_TEXT</span></a>\'\r\nsformat=\'<a class=\"act\" href=\"ITEM_LINK\"><span>ITEM_TEXT</span></a>\'\r\nformat1=\'<a class=\"act2\" href=\"ITEM_LINK\"><span>ITEM_TEXT</span></a>\'\r\n]\r\n\r\n<div class=\"bl\" style=\"padding: 30px 0 60px 20px;\"><img src=\"/img/lang-[PHP do=\'echo $doc_vars[lang~];\'].gif\" width=\"86\" height=\"16\" alt=\"\" border=\"0\" usemap=\"#lang\"><map name=\"lang\">\r\n<area alt=\"\" coords=\"0,0,28,16\" href=\"[LINK doc_id=\'rus\']\"><area alt=\"\" coords=\"29,0,57,16\" href=\"[LINK doc_id=\'eng\']\"><area alt=\"\" coords=\"87,-1,58,16\" href=\"[LINK doc_id=\'cn\']\"></map>\r\n</div>\r\n</div>\r\n</div>',0);

--
-- Table structure for table `engine_user_rights`
--

DROP TABLE IF EXISTS `engine_user_rights`;
CREATE TABLE `engine_user_rights` (
  `id` bigint(20) NOT NULL auto_increment,
  `user` bigint(20) NOT NULL default '0',
  `granted` bigint(20) NOT NULL default '0',
  `document` bigint(20) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;

--
-- Dumping data for table `engine_user_rights`
--


--
-- Table structure for table `engine_users`
--

DROP TABLE IF EXISTS `engine_users`;
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

--
-- Dumping data for table `engine_users`
--

INSERT INTO `engine_users` VALUES (1,'serge','seBeLtI',NULL,20070817132447,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'Сергей',1,'','','','Администратор',1);
INSERT INTO `engine_users` VALUES (2,'serged','seBeLtI',NULL,20070817132447,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'Сергей',1,'','','','Разработчик',1);
INSERT INTO `engine_users` VALUES (3,'shramkova','eWy_38',NULL,20070817132447,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'Анна',1,'','','','Разработчик',1);
INSERT INTO `engine_users` VALUES (4,'tuchkova','eWy_38',NULL,20070817132447,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'Анна',1,'','','','Администратор',1);
INSERT INTO `engine_users` VALUES (5,'sveta','svBeLtI',NULL,20070817132447,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'Светлана',1,'','','','Администратор',1);
INSERT INTO `engine_users` VALUES (6,'sst','d2c432262c68fa3a0219',NULL,20070817132447,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'Сергей',1,'','','','Разработчик',1);
INSERT INTO `engine_users` VALUES (7,'kateri','KaBeLtI',NULL,20070817132447,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'Катя',1,'','','','Редактор',1);
INSERT INTO `engine_users` VALUES (8,'ereih','damnedest',NULL,20070817132447,NULL,NULL,NULL,'Рейх',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'ereih@belti.ru',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'Евгений',1,'Владимирович','','','Разработчик',1);
INSERT INTO `engine_users` VALUES (9,'ast','111111',NULL,20070817132447,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'ast@belti.ru',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'Александра',1,'','','','Администратор',1);
INSERT INTO `engine_users` VALUES (10,'astdev','astdev',NULL,20070817132447,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'ast@belti.ru',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'Александра',1,'','','','Разработчик',1);
INSERT INTO `engine_users` VALUES (11,'mlavrenovdev','mlavrenovdev',NULL,20070817132447,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'Максим',1,'','','','Разработчик',1);
INSERT INTO `engine_users` VALUES (12,'vadimbond','ab1231',NULL,20070817132447,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'Vadim',1,'','','','Разработчик',1);
INSERT INTO `engine_users` VALUES (13,'bugera','vfynbccf',NULL,20070817133523,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'bugera@belti.ru',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'Юля',1,'','','','Редактор',1);
INSERT INTO `engine_users` VALUES (14,'pkozhev','pavel1',NULL,20070817133523,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'pkozhev@belti.ru',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'Павел',1,'','','','Разработчик',1);

