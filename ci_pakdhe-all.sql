-- Adminer 4.2.2 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `groups`;
CREATE TABLE `groups` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `description` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

INSERT INTO `groups` (`id`, `name`, `description`) VALUES
(1,	'admin',	'Administrator'),
(2,	'members',	'General User');

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
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

INSERT INTO `groups_menus` (`id`, `group_id`, `menu_id`, `akses`, `tambah`, `ubah`, `hapus`) VALUES
(1,	1,	1,	1,	1,	1,	1),
(2,	1,	2,	1,	1,	1,	1),
(3,	1,	3,	1,	1,	1,	1),
(4,	1,	4,	1,	1,	1,	1),
(5,	1,	5,	1,	1,	1,	1),
(6,	1,	6,	1,	1,	1,	1),
(7,	1,	7,	1,	1,	1,	1),
(8,	1,	8,	1,	1,	1,	1);

DROP TABLE IF EXISTS `login_attempts`;
CREATE TABLE `login_attempts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(45) NOT NULL,
  `login` varchar(100) NOT NULL,
  `time` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `menus`;
CREATE TABLE `menus` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'this is ID for menus',
  `parent_id` int(10) unsigned DEFAULT '0',
  `path` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `icon` varchar(255) DEFAULT 'glyphicon glyphicon-tasks',
  `list_order` varchar(3) DEFAULT '0',
  `remark` text,
  `flag` enum('draft','publish') DEFAULT 'draft',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

INSERT INTO `menus` (`id`, `parent_id`, `path`, `name`, `icon`, `list_order`, `remark`, `flag`) VALUES
(1,	0,	'#',	'ACL',	'fa fa-cogs',	'90',	'Authentification Control List',	'publish'),
(2,	1,	'acl/orgs/',	'Orgs',	'fa fa-university',	'91',	'Master Organisation',	'publish'),
(3,	1,	'acl/groups/',	'Groups',	'fa fa-tags',	'92',	'Master Group',	'publish'),
(4,	1,	'acl/menus/',	'Menus',	'fa fa-list',	'93',	'Master Menus',	'publish'),
(5,	1,	'acl/groups_menu/',	'Groups Menu',	'fa fa-list-alt',	'94',	'Master Group Menus',	'publish'),
(6,	1,	'acl/users/',	'Users',	'fa fa-user-circle-o',	'95',	'Master Users',	'publish'),
(7,	0,	'#',	'KEPENDUDUKAN',	'fa fa-users',	'30',	'Penduduk',	'publish'),
(8,	7,	'pddk/master/',	'Master Data Penduduk',	'fa fa-users',	'31',	'Master Data Kependudukan',	'publish');

DROP TABLE IF EXISTS `orgs`;
CREATE TABLE `orgs` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `parent_id` mediumint(8) unsigned NOT NULL COMMENT 'PID',
  `name` tinytext NOT NULL COMMENT 'Nama Org',
  `description` text COMMENT 'Desc. Org',
  `url_site` varchar(255) DEFAULT '#' COMMENT 'Situs Org',
  `nama_pimpinan` varchar(255) DEFAULT NULL,
  `alamat` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

INSERT INTO `orgs` (`id`, `parent_id`, `name`, `description`, `url_site`, `nama_pimpinan`, `alamat`) VALUES
(1,	0,	'Org 1',	'Organisation One',	'#',	'John Bon Jovi',	''),
(2,	1,	'Sub Org 1.1',	'Description of Sub Org 1.1',	'#',	'',	'-');

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(45) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `salt` varchar(255) DEFAULT NULL,
  `email` varchar(254) NOT NULL,
  `activation_code` varchar(40) DEFAULT NULL,
  `forgotten_password_code` varchar(40) DEFAULT NULL,
  `forgotten_password_time` int(11) unsigned DEFAULT NULL,
  `remember_code` varchar(40) DEFAULT NULL,
  `created_on` int(11) unsigned NOT NULL,
  `last_login` int(11) unsigned DEFAULT NULL,
  `active` tinyint(1) unsigned DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `company` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

INSERT INTO `users` (`id`, `ip_address`, `username`, `password`, `salt`, `email`, `activation_code`, `forgotten_password_code`, `forgotten_password_time`, `remember_code`, `created_on`, `last_login`, `active`, `first_name`, `last_name`, `company`, `phone`) VALUES
(1,	'127.0.0.1',	'administrator',	'$2a$07$SeBknntpZror9uyftVopmu61qg0ms8Qv1yV6FG.kQOSM.9QhmTo36',	'',	'admin@admin.com',	'',	NULL,	NULL,	NULL,	1268889823,	1506911225,	1,	'Admin',	'istrator',	'ADMIN',	'0');

DROP TABLE IF EXISTS `users_groups`;
CREATE TABLE `users_groups` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `group_id` mediumint(8) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uc_users_groups` (`user_id`,`group_id`),
  KEY `fk_users_groups_users1_idx` (`user_id`),
  KEY `fk_users_groups_groups1_idx` (`group_id`),
  CONSTRAINT `fk_users_groups_groups1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `fk_users_groups_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

INSERT INTO `users_groups` (`id`, `user_id`, `group_id`) VALUES
(1,	1,	1);

DROP TABLE IF EXISTS `users_orgs`;
CREATE TABLE `users_orgs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `org_id` mediumint(8) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `group_id` (`org_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

INSERT INTO `users_orgs` (`id`, `user_id`, `org_id`) VALUES
(2,	1,	1);

-- 2017-10-04 16:20:18
