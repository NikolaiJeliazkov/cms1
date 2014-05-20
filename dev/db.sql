/*
SQLyog Community v11.0 (64 bit)
MySQL - 5.1.30-community : Database - icca_razum
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`classbn_razum` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `classbn_razum`;

/*Table structure for table `articles` */

DROP TABLE IF EXISTS `articles`;

CREATE TABLE `articles` (
  `ArticleId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `LangId` char(2) NOT NULL,
  `ArticleCreateTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ArticleModifyTime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ArticleAuthor` int(11) NOT NULL,
  `ArticleActivated` tinyint(4) NOT NULL DEFAULT '0',
  `ArticleOptions` int(10) unsigned NOT NULL DEFAULT '7' COMMENT 'bitmask\n1 - show author\n2 - show create time\n4 - show modified time',
  `ArticleValidFrom` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ArticleValidTo` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ArticleTitle` text,
  `ArticleSubtitle` text,
  `ArticleContent` text,
  `ArticleTags` text,
  `ArticleMetaKeywords` text,
  `ArticleMetaDescription` text,
  PRIMARY KEY (`ArticleId`),
  KEY `ArticleAuthor` (`ArticleAuthor`),
  KEY `LangId` (`LangId`),
  CONSTRAINT `articles_ibfk_2` FOREIGN KEY (`LangId`) REFERENCES `languages` (`LangId`),
  CONSTRAINT `articles_ibfk_1` FOREIGN KEY (`ArticleAuthor`) REFERENCES `users` (`UserId`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

/*Data for the table `articles` */

insert  into `articles`(`ArticleId`,`LangId`,`ArticleCreateTime`,`ArticleModifyTime`,`ArticleAuthor`,`ArticleActivated`,`ArticleOptions`,`ArticleValidFrom`,`ArticleValidTo`,`ArticleTitle`,`ArticleSubtitle`,`ArticleContent`,`ArticleTags`,`ArticleMetaKeywords`,`ArticleMetaDescription`) values (1,'bg','2013-03-04 14:14:41','2013-03-04 14:14:41',1,1,7,'0000-00-00 00:00:00','0000-00-00 00:00:00','НЧ \"Разум 1883\"',NULL,'- Логото и името на читалището\r\n- снимка на читалището\r\n- малки снимки от всички дейности на читалището с препратки\r\n- от ляво – рубриките / меню/\r\n- от дясно – календар с предстоящите изяви\r\n- 3-5 изречения за читалището и неговата мисия',NULL,NULL,NULL),(2,'bg','2013-03-04 14:15:18','2013-03-04 14:15:18',1,1,7,'0000-00-00 00:00:00','0000-00-00 00:00:00','История','Цифри и факти','<dl>\r\n	<dt>1883 г</dt>\r\n	<dd>Основано  читалище “Разум” – Монтана,  обявено в “Училищен алманах” на Максимов – по данни на Министерството на просвещението,  784, т 77.</dd>\r\n\r\n	<dt>1894 г</dt>\r\n	<dd>Възобновена дейността на читалище “Разум”.<br/>\r\n	Председател на Настоятелството – Гаврил Душков –от 1894 до 1912 г.<br/>\r\n	За седалище на читалището се определя училище “Кирил и Методий” Кафене “Шипка” / Качовото кафене.</dd>\r\n\r\n	<dt>1894 г</dt>\r\n	<dd>Начало на библиотечната дейност на читалището – 200 подарени книги, съхранявани в кафене “Шипка”.</dd>\r\n\r\n	<dt>1911 г</dt>\r\n	<dd>Закупен парцел от Настоятелството на ч-ще “Разум” /бивш турски  конак / чрез адвоката Цоло Мислов, публикувано в ДВ бр 57 през 1911 година.</dd>\r\n\r\n	<dt>1912 г</dt>\r\n	<dd>Читалище “Разум” влиза в Съюза на народните читалища.</dd>\r\n\r\n	<dt>1912-1918 г</dt>\r\n	<dd>Театралният  състав на читалището участва  н.а. Стефан Савов. Като актьор в Народния театър поставя пиеси на читалищната сцена.</dd>\r\n\r\n	<dt>до 1920 г</dt>\r\n	<dd>Набирани средства за нова читалищна сграда в Българска Земеделска Банка по време на войните.</dd>\r\n\r\n	<dt>1920 г</dt>\r\n	<dd>Създаден граждански хор от Иван Бърдаров от 80 изпълнители.</dd>\r\n\r\n	<dt>1920-1934 г</dt>\r\n	<dd>Старата сграда се преустроява – ремонт за 322 000 лв.</dd>\r\n\r\n	<dt>1922 г</dt>\r\n	<dd>Учителят Иван Бърдаров  прави първата  оперетна постановка – “Самодивското изворче”.</dd>\r\n\r\n	<dt>1926 г</dt>\r\n	<dd>Читалището организира детска забавачница с 30 деца.</dd>\r\n\r\n	<dt>1926 г</dt>\r\n	<dd>Създаден симфоничен оркестър</dd>\r\n\r\n	<dt>1926 г</dt>\r\n	<dd>Обновен театрален състав.<br/>\r\n	Открива се народен университет – първа лекция „Ролята на читалището”.</dd>\r\n\r\n	<dt>1927 г</dt>\r\n	<dd>В читалището се прожектира първият филм “Тайнственият капитан”, озвучаван на живо  от симфоничния оркестър.</dd>\r\n\r\n	<dt>1929 г</dt>\r\n	<dd>Създава се  духов оркестър.</dd>\r\n\r\n	<dt>1930 г</dt>\r\n	<dd>Открива се лятно кино с филма „Волга, Волга”.</dd>\r\n\r\n	<dt>1934 г</dt>\r\n	<dd>Решение на настоятелството за построяване на нова читалищна сграда,<br/>\r\n	сформира се  строителен комитет, надзорник -  Владимир Попов –  адвокат.<br/>\r\n	С лични  средства на настоятелството  и контролната  комисия / 1200 лв /се закупуват 200 кубика  камъни за основите на сградата.<br/>\r\n	Настоятелството отправя апел към гражданството за помощи.</dd>\r\n\r\n	<dt>20.VІ.1934 г</dt>\r\n	<dd>Полага се основния камък  на бъдещата сграда с водосвет.<br/>\r\n	В основния камък на сградата се зазижда послание:<br/>\r\n	“Днес, сряда, третия ден от седмицата, двадесети ден от месец юни 1934<br/>\r\n	година се положи този основен камък за построяване сграда на читалище под име “Разум” в гр Фердинанд.<br/>\r\n	Строежът се извърши от дарения, дадени от гражданите на града и при проект, съставен от техника Асен Иванчев.<br/>\r\n	Призоваваме божията милост и благодат за благоденствието на читалището!”</dd>\r\n\r\n	<dt>8.ІХ.1934 г</dt>\r\n	<dd>Настоятелството взема решение да сключи заем с РКБ за  50 000 лв, който  се  отпуска същия месец</dd>\r\n\r\n	<dt>1935 г</dt>\r\n	<dd>Строителството на читалищната сграда стига до първа плоча.</dd>\r\n\r\n	<dt>1936 г</dt>\r\n	<dd>Завършва първия етап от строежа на сградата- поставя се покривна конструкция с помощта на заеми и дарения от Колоездачно  дружество, търговско сдружение в града,  църковното настоятелство, туристическо  дружество.</dd>\r\n\r\n	<dt>26.ХІІ.1937 г</dt>\r\n	<dd>Тържествено се открива читалищния салон.</dd>\r\n\r\n	<dt>1938 г</dt>\r\n	<dd>Читалището влиза в полуготова сграда с почти нищожно обзавеждане.<br/>\r\n	Районната банка дава още 40 000  лв за оборудване,  като се подписва договор между  Настоятелството и банката  за даване киното и салона  под наем, като приходите се ползват от Банката и така се връщат заемите.</dd>\r\n\r\n</dl>\r\n',NULL,NULL,NULL),(3,'bg','2013-03-04 14:15:43','2013-03-04 14:15:43',1,1,7,'0000-00-00 00:00:00','0000-00-00 00:00:00','Дейности',NULL,NULL,NULL,NULL,NULL),(4,'bg','2013-03-04 14:16:06','2013-03-04 14:16:06',1,1,7,'0000-00-00 00:00:00','0000-00-00 00:00:00','Проекти',NULL,'представяне на кратко на всички проекти,\r\nгодина на спечелване, тема, донори, дейност и др',NULL,NULL,NULL),(7,'bg','2013-03-04 14:20:57','2013-03-04 14:20:57',1,1,7,'0000-00-00 00:00:00','0000-00-00 00:00:00','Представяме Ви','Светослав Стефанов Боцев – председател на НЧ „Разум 1883” – гр Монтана.','<p>Светослав Боцев е потомствен самодеец в читалището. Вероятно, любовта към сцената и пеенето  се предава генетично, защото едни от най-активните самодейни изпълнители на народни песни и танци в  Белоградчик са неговите баба и дядо , а родителите му  активни участници в т н  Ансамбъл  през 50-те години на миналия век -  граждански хор и симфоничен оркестър в читалище „Разум” Монтана. По –късно майка му – Вера Боцева,  ушива най-красивите тоалети на  солистите от самодейната оперета при читалището, които се пазят и до днес.</p>\r\n<p>Светослав Боцев пее в ученическия хор на Гимназията, а от 1980 г  става председател на смесения хор в читалището под диригенството на Чавдар Маждраков.</p>\r\n<p>Отначало на шега, но в последствие се оказа много успешно, създаването на мъжки хор при читалището през 2000 г, душата и организатора на който е г-н Боцев. Съставът има много почитатели, всяка година участва в престижни Международни хорови фестивали и всеки път завоюва една от първите награди, създава традиции и значими концертни изяви.</p>\r\n<p>Няколко мандата е бил член на Настоятелството на читалището  и зам председател, а от 2010 г – председател.</p>\r\n',NULL,NULL,NULL),(9,'bg','2013-03-04 14:22:10','2013-03-04 14:22:10',1,1,7,'0000-00-00 00:00:00','0000-00-00 00:00:00','Контакти',NULL,'<p>НАРОДНО ЧИТАЛИЩЕ &quot;РАЗУМ 1883&quot; – гр МОНТАНА</p>\r\n<p>Бул &quot;ТРЕТИ МАРТ&quot; 88</p>\r\n<p>Гр МОНТАНА</p>\r\n<pre>Тел. 096 / 305 671\r\n     096 / 306 393</pre>\r\n',NULL,NULL,NULL),(10,'bg','2013-03-04 16:52:24','0000-00-00 00:00:00',1,1,7,'0000-00-00 00:00:00','0000-00-00 00:00:00','wwwTitle',NULL,NULL,NULL,NULL,NULL);

/*Table structure for table `authassignment` */

DROP TABLE IF EXISTS `authassignment`;

CREATE TABLE `authassignment` (
  `itemname` varchar(64) NOT NULL,
  `UserId` int(11) NOT NULL,
  `bizrule` text,
  `data` text,
  PRIMARY KEY (`itemname`,`UserId`),
  KEY `UserId` (`UserId`),
  CONSTRAINT `authassignment_ibfk_2` FOREIGN KEY (`UserId`) REFERENCES `users` (`UserId`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `authassignment_ibfk_1` FOREIGN KEY (`itemname`) REFERENCES `authitem` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `authassignment` */

/*Table structure for table `authitem` */

DROP TABLE IF EXISTS `authitem`;

CREATE TABLE `authitem` (
  `name` varchar(64) NOT NULL,
  `type` int(11) NOT NULL,
  `description` text,
  `bizrule` text,
  `data` text,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `authitem` */

/*Table structure for table `authitemchild` */

DROP TABLE IF EXISTS `authitemchild`;

CREATE TABLE `authitemchild` (
  `parent` varchar(64) NOT NULL,
  `child` varchar(64) NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `authitemchild_ibfk_2` (`child`),
  CONSTRAINT `authitemchild_ibfk_2` FOREIGN KEY (`child`) REFERENCES `authitem` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `authitemchild_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `authitem` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `authitemchild` */

/*Table structure for table `languages` */

DROP TABLE IF EXISTS `languages`;

CREATE TABLE `languages` (
  `LangId` char(2) NOT NULL,
  `LangName` varchar(255) NOT NULL,
  `LangActivated` tinyint(4) NOT NULL DEFAULT '0',
  `LangOrder` int(10) unsigned NOT NULL,
  PRIMARY KEY (`LangId`),
  UNIQUE KEY `LangOrder` (`LangOrder`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `languages` */

insert  into `languages`(`LangId`,`LangName`,`LangActivated`,`LangOrder`) values ('bg','Български',1,1),('en','English',0,2);

/*Table structure for table `modules` */

DROP TABLE IF EXISTS `modules`;

CREATE TABLE `modules` (
  `ModuleName` varchar(255) NOT NULL,
  `ModuleClass` varchar(255) DEFAULT NULL,
  `ModuleDescription` text,
  PRIMARY KEY (`ModuleName`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `modules` */

insert  into `modules`(`ModuleName`,`ModuleClass`,`ModuleDescription`) values ('Calendar','ModuleCalendar',NULL),('Gallery','ModuleGallery',NULL),('Index','ModuleIndex',NULL),('News','ModuleNews',NULL),('Pages','ModulePage',NULL);

/*Table structure for table `posts` */

DROP TABLE IF EXISTS `posts`;

CREATE TABLE `posts` (
  `PostId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `PostPubDate` date NOT NULL,
  `ArticleId` int(10) unsigned NOT NULL,
  `PostShortContent` text,
  PRIMARY KEY (`PostId`),
  KEY `ArticleId` (`ArticleId`),
  CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`ArticleId`) REFERENCES `articles` (`ArticleId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `posts` */

/*Table structure for table `sitemap` */

DROP TABLE IF EXISTS `sitemap`;

CREATE TABLE `sitemap` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parent` int(10) unsigned DEFAULT NULL,
  `LangId` char(2) NOT NULL,
  `url` varchar(255) NOT NULL,
  `pos` int(10) unsigned NOT NULL,
  `ModuleName` varchar(255) NOT NULL,
  `ModuleData` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `Alter_Key1` (`LangId`,`parent`,`url`),
  UNIQUE KEY `Alter_Key2` (`LangId`,`parent`,`pos`),
  KEY `ModuleName` (`ModuleName`),
  KEY `parent` (`parent`),
  CONSTRAINT `sitemap_ibfk_3` FOREIGN KEY (`parent`) REFERENCES `sitemap` (`id`),
  CONSTRAINT `sitemap_ibfk_1` FOREIGN KEY (`LangId`) REFERENCES `languages` (`LangId`),
  CONSTRAINT `sitemap_ibfk_2` FOREIGN KEY (`ModuleName`) REFERENCES `modules` (`ModuleName`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

/*Data for the table `sitemap` */

insert  into `sitemap`(`id`,`parent`,`LangId`,`url`,`pos`,`ModuleName`,`ModuleData`) values (1,NULL,'bg','',0,'Index','1'),(2,1,'bg','history',0,'Pages','2'),(3,1,'bg','activities',1,'Pages','3'),(4,1,'bg','projects',2,'Pages','4'),(5,1,'bg','calendar',3,'Calendar',NULL),(6,1,'bg','news',4,'News',NULL),(7,1,'bg','blog',5,'Pages','7'),(8,1,'bg','gallery',6,'Gallery',NULL),(9,1,'bg','contacts',7,'Pages','9'),(12,9,'bg','www',0,'Pages','10');

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `UserId` int(11) NOT NULL AUTO_INCREMENT,
  `UserEmail` varchar(255) NOT NULL,
  `UserName` varchar(255) NOT NULL,
  `UserPassword` varchar(255) NOT NULL,
  `UserActivated` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`UserId`),
  UNIQUE KEY `UserEmail` (`UserEmail`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `users` */

insert  into `users`(`UserId`,`UserEmail`,`UserName`,`UserPassword`,`UserActivated`) values (1,'njeliazkov@gmail.com','Nikolai Jeliazkov','qwerty',1);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
