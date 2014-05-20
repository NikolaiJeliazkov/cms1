
CREATE TABLE `Project` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(128) NOT NULL,
  `path` varchar(255) NOT NULL,
  `source_lang` varchar(5) NOT NULL,
  `lang_list` text NOT NULL,
  `active` tinyint(1) default NULL,
  PRIMARY KEY  (`id`)
) DEFAULT CHARSET=utf8 ;