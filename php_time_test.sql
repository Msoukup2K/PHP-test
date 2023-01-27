-- Adminer 4.8.1 MySQL 5.7.34 dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `stats`;
CREATE TABLE `stats` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url_id` int(11) NOT NULL,
  `ip_add` varchar(255) DEFAULT NULL,
  `db_down` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `url_id` (`url_id`),
  CONSTRAINT `stats_ibfk_2` FOREIGN KEY (`url_id`) REFERENCES `url` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `stats` (`id`, `url_id`, `ip_add`, `db_down`) VALUES
(37,	26,	'::1',	NULL),
(38,	26,	'::1',	'2023-01-26'),
(39,	26,	'::1',	'2023-01-26');

DROP TABLE IF EXISTS `url`;
CREATE TABLE `url` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'idurl',
  `long_url` varchar(255) NOT NULL,
  `short_url` varchar(255) NOT NULL,
  `created` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `url` (`id`, `long_url`, `short_url`, `created`) VALUES
(26,	'https://www.facebook.com/',	'201dd5',	'2023-01-26');

-- 2023-01-27 10:00:13
