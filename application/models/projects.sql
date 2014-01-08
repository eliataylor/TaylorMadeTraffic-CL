-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 23-12-2013 a las 14:52:39
-- Versión del servidor: 5.5.8
-- Versión de PHP: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `tmm_porfolio`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `projects`
--

DROP TABLE IF EXISTS `tags`;
CREATE TABLE IF NOT EXISTS `tags` (
  `tag_id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) NOT NULL,
  `tag_key` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `tag_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `tag_date` date DEFAULT NULL,
  PRIMARY KEY (`tag_id`),
  KEY (`project_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1;

DROP TABLE IF EXISTS `images`;
CREATE TABLE IF NOT EXISTS `images` (
  `image_id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) NOT NULL,
  `image_weight` smallint(4) NOT NULL, 
  `image_src` varchar(2000) COLLATE utf8_unicode_ci NOT NULL,
  `image_width` smallint(4) DEFAULT NULL, 
  `image_height` smallint(4) DEFAULT NULL, 
  PRIMARY KEY (`image_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1;


DROP TABLE IF EXISTS `projects`;
CREATE TABLE IF NOT EXISTS `projects` (
  `project_id` int(11) NOT NULL AUTO_INCREMENT,
  `project_type` varchar(55) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'd',
  `project_startdate` date DEFAULT NULL,
  `project_launchdate` date DEFAULT NULL,
  `project_startyear` smallint(4) NOT NULL,
  `project_launchyear` smallint(4) NOT NULL,
  `project_title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `project_subtitle` int(11) NOT NULL,
  `project_liveurl` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `project_devurl` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `license_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `project_copyright` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `project_client` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `project_icon` varchar(2000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `project_devtools` varchar(2000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `project_team` varchar(2000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `project_html` varchar(4000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `project_desc` varchar(2000) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`project_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1;

--
-- Volcar la base de datos para la tabla `projects`
--

INSERT INTO `projects` (`project_id`, `project_type`, `project_startdate`, `project_launchdate`, `project_startyear`, `project_launchyear`, `project_title`, `project_subtitle`, `project_liveurl`, `project_devurl`, `license_id`, `project_copyright`, `project_client`, `project_icon`, `project_devtools`, `project_team`, `project_html`, `project_desc`) VALUES
(1, 'design', '2007-09-01', '2008-02-01', 2007, 2008, 'The LoveQuest Tour', 0, 'http://www.taylormadetraffic.com/', 'http://www.TheMeans.info/_dev/web40.php', NULL, 'Taylor Made Management', '', NULL, 'Illustrator, Photoshop, Flash', 'Design:E.A.Taylor;Animation:Justin Herman', NULL, NULL),
(2, 'design', '2007-09-01', '2008-02-01', 2007, 2008, 'Flavor', 0, 'http://www.taylormadetraffic.com/', 'http://www.TheMeans.info/_dev/web40.php', NULL, 'Taylor Made Management', '', NULL, 'Illustrator, Photoshop', 'Design:E.A.Taylor', NULL, NULL),
(3, 'design', '2007-09-01', '2008-02-01', 2007, 2008, 'Biko', 0, 'http://www.taylormadetraffic.com/', 'http://www.TheMeans.info/_dev/web40.php', NULL, 'Taylor Made Management', '', NULL, 'Illustrator, Photoshop', 'Design:E.A.Taylor', NULL, NULL),
(4, 'design', '2007-09-01', '2008-02-01', 2007, 2008, 'Ambitions', 0, 'http://www.taylormadetraffic.com/', 'http://www.TheMeans.info/_dev/web40.php', NULL, 'Taylor Made Management', '', NULL, 'Illustrator, Photoshop', 'Design:E.A.Taylor', NULL, NULL),
(5, 'design', '2006-01-01', '2006-02-01', 2006, 2006, 'Nina Vidal', 0, NULL, NULL, NULL, '', '', NULL, 'Illustrator, Photoshop', 'Design:E.A.Taylor', NULL, NULL),
(6, 'design', '2006-01-01', '2006-01-01', 2006, 2006, 'WSCC', 0, NULL, NULL, NULL, 'WSCC', '', NULL, 'Illustrator, Photoshop, Flash', 'Design:E.A.Taylor', NULL, NULL),
(7, 'design', '2004-09-01', NULL, 2004, 0, 'The A and E Advisor', 0, 'http://www.aandeadvisor.com/', NULL, NULL, 'Taylor Made Management', '', NULL, 'Illustrator, Photoshop, Flash', 'Design:E.A.Taylor', NULL, NULL),
(8, 'design', '2002-08-01', '2002-08-01', 2002, 2002, 'Traffic', 0, 'http://www.taylormadetraffic.com/TMT/Traffic/', NULL, NULL, 'Taylor Made Management', '', NULL, 'Illustrator, Photoshop, Flash', 'Design:Dan Wilson;Producer:E.A.Taylor', NULL, NULL),
(9, 'development', '2012-12-01', '2012-12-01', 2012, 2012, 'Track Authority', 0, 'http://trackauthoritymusic.com', NULL, NULL, 'Taylor Made Management', '', NULL, 'LAMP, Bash, Android,Facebook APIs', 'Design:E.A.Taylor;Front-End:E.A.Taylor;Back-End:E.A.Taylor;Business Development:E.A.Taylor,Andrew Williams', NULL, NULL),
(10, 'development', '2013-12-21', NULL, 2013, 0, 'LealtadTarjeta', 0, NULL, NULL, NULL, 'Taylor Made Management', 'SuperWashingWell Laundromat', NULL, 'Native Android SDK,Facebook APIs', 'Design:E.A.Taylor;Front-End:E.A.Taylor;Back-End:E.A.Taylor;Business Development: Sam Taylor', NULL, NULL),
(11, 'development', '2013-07-01', '2013-12-01', 2013, 2013, 'ID Dashboard', 0, 'http://analytics.idinteractive.co', NULL, NULL, 'ID Interactive', '', NULL, 'AJAX,PHP,mySQL,Google APIs,Facebook APIs,YouTube APIs,Twitter APIs', 'Design:E.A.Taylor;Front-End:E.A.Taylor;Back-End:E.A.Taylor;Business Development:Juan Ruiz,Claudia Herez;QA:Alejandra F', NULL, NULL),
(12, 'development', '2013-11-01', '2013-12-01', 2013, 2013, 'Oreo Navidad', 0, 'http://www.ganaoreo.com', NULL, NULL, 'Oreo', 'ID Interactive', NULL, 'PHP,mySQL', 'Design:Camilo;Front-End:E.A.Taylor;Back-End:E.A.Taylor', NULL, NULL),
(13, 'development', '2009-05-01', '2012-07-01', 2009, 2012, 'Healthline Navigator', 0, 'http://www.healthline.com/corporate/navigator/prod/demo.html', NULL, NULL, 'Healthline Networks', '', NULL, 'Java,Spring,Oracle,JavaScript', 'Design:E.A.Taylor;Development:E.A.Taylor', NULL, NULL),
(14, 'development', '2009-05-01', '2012-07-01', 2009, 2012, 'Healthline Dashboard', 0, 'http://nav.healthline.com/healthstat/nav/dashboard/login', NULL, NULL, 'Healthline Networks', '', NULL, 'Java,Spring,Oracle,JavaScript', 'Design:E.A.Taylor;Development:E.A.Taylor', NULL, NULL),
(15, 'development', '2009-05-01', '2012-07-01', 2009, 2012, 'Healthline computeQA ', 0, 'http://www.healthline.com/corporate/navigator/prod/crawler.html?domain=healthline', NULL, NULL, 'Healthline Networks', '', NULL, 'WebSQL-lite,JavaScript,Google Chrome Extension,LocalStorage', 'Design:E.A.Taylor;Development:E.A.Taylor', NULL, NULL),
(16, 'development', '2009-05-01', '2009-07-01', 2009, 2009, 'Elite Wedding Locations', 0, 'http://www.eliteweddinglocations.com', 'http://www.weddinglocations.com/clientpass/index.php', NULL, 'Elite Wedding Locations', 'Noospheric LLC', NULL, 'AJAX,AS3,Flex,PHP,mySQL', 'Design:E.A.Taylor;Development:E.A.Taylor;Project Management:Jacquas Habra,Kevin Kent,James McCorkle', NULL, 'Entirely object oriented javascript, updating only necessary html through single AJAX wrapper. Running performance queries returns tabular html, dynamic css graphics, and xml for a Flex chart accessed through ExternalInterface. '),
(17, 'development', '2009-07-01', '2009-08-01', 2009, 2009, 'Black Panther Party', 0, 'http://www.blackpanther.org', 'http://skye.taylormadetraffic.com/bpp/', NULL, 'Taylor Made Management', '', NULL, 'AS3,PHP,mySQL', 'Design:E.A.Taylor;Development:E.A.Taylor', NULL, 'Extended i-google''s interface components to scale dynamically and link between e-commerce site and research portal'),
(18, 'development', '2009-03-01', '2009-10-01', 2009, 2009, 'ChartMedica', 0, 'http://www.chartmedica.com', 'http://www.chartmedica.info/newChartProto1.php', NULL, 'ChartMedica LLC', '', NULL, 'AS3,Flex,PHP,mySQL', 'Design:E.A.Taylor;Development:E.A.Taylor,Roy,David', NULL, 'Features included an advanced pdf viewing tool, autocompletes searching over 600K records, and automated faxing via MyFax API.'),
(19, 'development', '2008-09-01', '2009-02-01', 2008, 2009, 'The Means', 0, 'http://www.TheMeans.info', 'http://www.TheMeans.info/_dev/web40.php', '1', 'Taylor Made Management', 'Berkeley High School', NULL, 'AS3,PHP,mySQL', 'Design:E.A.Taylor;Development:E.A.Taylor,Roy,David;Product Development:Biko Eisen-Martin', NULL, 'A tool for teachers and students to develop the writing process. Modeled after a traditional newsroom, students and teachers can develop assignements, work on multiple versions of a story, share ideas within the class, and more. UI Tools include tinyMCE text editor, advance sourcing maps, and multi-category search options'),
(20, 'development', '2008-04-01', '2008-08-01', 2008, 2008, 'BCBGMaxAzriaGroup', 0, 'http://www.bcbgmaxazriagroup.com/Fall2009', NULL, NULL, 'BCBGMaxAzriaGroup', '', NULL, 'AS2,PHP,mySQL', 'Design:Natasha Li;Front-End:E.A.Taylor,Robert Baindourve;Back-End:Edwin Ado,Ray;Artistic Direction:Edwin Roses', NULL, 'A major overhaul of the corporate branding home. Framework is still in place today.'),
(21, 'development', '2008-07-01', '2008-08-01', 2008, 2008, 'HerveLeger', 0, 'http://www.herveleger.com', NULL, NULL, 'HerveLeger', 'BCBGMaxAzriaGroup', NULL, 'AS2,PHP,mySQL', 'Design:Joe;Front-End:E.A.Taylor;Back-End:Edwin Ado', NULL, 'A slick and clean site for the highest-end of the BCBG courtoir brands.'),
(22, 'development', '2008-08-01', '2008-12-01', 2008, 2008, 'Building Safety Solutions', 0, 'http://www.bssnet.com', NULL, NULL, 'Building Safety Solutions', '', NULL, 'AS2,XML,JSFL,Scorm', '3DModeling:Umberto Polanco;Front-End:E.A.Taylor;Back-End:E.A.Taylor;Business Development:Hector Gomez', NULL, 'Commercial software providing interactive emergency evacuation training for skyscrapers and public buildings throughout the US. Advanced UI tools include detail floor maps of emergency equipment and exit routes with controls for sorting and searching'),
(23, 'development', '2004-08-01', NULL, 2004, 0, 'The A and E Advisor', 0, 'http://www.aandeadvisor.com', 'http://www.aandeadvisor.com/wizard/', NULL, 'Taylor Made Management', '', NULL, 'AS3,PHP,mySQL,JavaScript,AJAX', 'Front-End:E.A.Taylor;Design:E.A.Taylor', NULL, 'An e-learning tool with an applicable edge. Creates completely customized contracts from a intelligent questionnaire about the parties involved, their interests, and needs. Provides bi-partisian advice from attorneys, artists, and industry professionals'),
(24, 'development', '2008-08-01', '2009-01-01', 2008, 2009, 'Good Life With Gabby', 0, 'http://www.goodlifewithgabby.com', NULL, NULL, 'Good Life With Gabby', '', NULL, 'AS2,PHP,mySQL', 'Front-End:E.A.Taylor;Back-End:E.A.Taylor;Free-Hand:Unknown;Business Development:Lisa Vasquez', NULL, 'A fun, educational site for kids and parents to learn about, and find recipes on healthy lifestyles and nutrition. Includes tooling book, jquery shopping page, recipes table, videos, and translation of virtually everything into 12 languages at runtime via google''s language API.'),
(25, 'development', '2008-05-01', '2009-06-01', 2008, 2009, 'Ruth Raser', 0, 'http://www.ruthraser.com', 'http://www.ruthraser.com/newRaser.html', NULL, 'Ruth Raser', '', NULL, 'AS3,Flex', 'Design:E.A.Taylor;Development:E.A.Taylor', NULL, 'A unique approach to navigation, with advance controls for restyling the site''s backgrounds, panels, and colors at runtime.'),
(26, 'development', '2009-01-01', '2009-02-01', 2009, 2009, 'Margaret Timbrell', 0, 'http://www.margarettimbrell.com', NULL, NULL, 'Margaret Timbrell', '', NULL, 'AS3,Flash,XML,PHP,mySQL', 'Development:E.A.Taylor;Design:E.A.Taylor', NULL, 'A simple and effective layout with clean animation and some customizing features'),
(27, 'development', '2009-03-01', '2009-04-01', 2009, 2009, 'Fuse Green', 0, 'http://www.fusegreen.com', NULL, NULL, 'Fuse Green', '', NULL, 'AS3,Flash,XML,PHP,mySQL', 'Front-End:E.A.Taylor;Back-End:E.A.Taylor;Design:Fuse Green', NULL, 'A graphic designer''s portfolio offering zooming tools on every image and easy access to every page and image at once.'),
(28, 'development', '2004-04-01', '2006-02-01', 2004, 2006, 'Ankh Marketing', 0, 'http://www.ankhmarketing.com', 'http://www.taylormadetraffic.com/ankh/', NULL, 'Ankh Marketing', '', NULL, 'HTML,CSS,AS3,Flash', 'Design:E.A.Taylor;Front-End:E.A.Taylor', NULL, 'A few very old flash sites for a former employer');
