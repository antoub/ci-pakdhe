-- Adminer 4.2.2 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `groups_menus`;
CREATE TABLE `groups_menus` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `group_id` mediumint(8) unsigned NOT NULL,
  `menu_id` int(10) unsigned NOT NULL,
  `akses` tinyint(1) unsigned DEFAULT '1',
  `tambah` tinyint(1) unsigned DEFAULT '0',
  `ubah` tinyint(1) unsigned DEFAULT '0',
  `hapus` tinyint(1) unsigned DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `group_id` (`group_id`),
  KEY `menu_id` (`menu_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `menus`;
CREATE TABLE `menus` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'this is ID for menus',
  `parent_id` int(10) unsigned DEFAULT '0',
  `path` varchar(255) NOT NULL,
  `text` varchar(255) NOT NULL,
  `icon` varchar(255) DEFAULT 'glyphicon glyphicon-tasks',
  `list_order` varchar(3) DEFAULT '0',
  `remark` text,
  `flag` enum('draft','publish') DEFAULT 'draft',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `orgs`;
CREATE TABLE `orgs` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `parent_id` mediumint(8) unsigned NOT NULL COMMENT 'PID',
  `name` tinytext NOT NULL COMMENT 'Nama Org',
  `description` text COMMENT 'Desc. Org',
  `url_site` varchar(255) DEFAULT NULL COMMENT 'Situs Org',
  `alamat` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `users_orgs`;
CREATE TABLE `users_orgs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `org_id` mediumint(8) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `group_id` (`org_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- 2017-09-27 16:54:41
