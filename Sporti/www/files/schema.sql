SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

CREATE TABLE `brand` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `label` varchar(64) COLLATE utf8mb4_czech_ci NOT NULL DEFAULT '""',
  `brand_category_id` int(11) DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_czech_ci NOT NULL DEFAULT '""',
  `note` text COLLATE utf8mb4_czech_ci NOT NULL DEFAULT '',
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_modified` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `date_deleted` datetime DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `brand_category_id` (`brand_category_id`),
  KEY `created_by` (`created_by`),
  KEY `deleted_by` (`deleted_by`),
  CONSTRAINT `brand_ibfk_1` FOREIGN KEY (`brand_category_id`) REFERENCES `brand_category` (`id`),
  CONSTRAINT `brand_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `login` (`id`),
  CONSTRAINT `brand_ibfk_3` FOREIGN KEY (`deleted_by`) REFERENCES `login` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci;


CREATE TABLE `brand_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `label` varchar(64) COLLATE utf8mb4_czech_ci NOT NULL DEFAULT '""',
  `description` varchar(255) COLLATE utf8mb4_czech_ci NOT NULL DEFAULT '""',
  `note` text COLLATE utf8mb4_czech_ci NOT NULL DEFAULT '',
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_modified` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `date_deleted` datetime DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `created_by` (`created_by`),
  KEY `deleted_by` (`deleted_by`),
  CONSTRAINT `brand_category_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `login` (`id`),
  CONSTRAINT `brand_category_ibfk_2` FOREIGN KEY (`deleted_by`) REFERENCES `login_role` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci;


CREATE TABLE `login` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) COLLATE utf8mb4_czech_ci NOT NULL DEFAULT '""',
  `first_name` varchar(16) COLLATE utf8mb4_czech_ci NOT NULL DEFAULT '""',
  `last_name` varchar(32) COLLATE utf8mb4_czech_ci NOT NULL DEFAULT '""',
  `login_role_id` int(11) NOT NULL,
  `email` varchar(128) COLLATE utf8mb4_czech_ci NOT NULL DEFAULT '""',
  `password` varchar(16) COLLATE utf8mb4_czech_ci NOT NULL DEFAULT '""',
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_modified` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `date_deleted` datetime DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `login_role_id` (`login_role_id`),
  KEY `created_by` (`created_by`),
  KEY `deleted_by` (`deleted_by`),
  CONSTRAINT `login_ibfk_1` FOREIGN KEY (`login_role_id`) REFERENCES `login_role` (`id`),
  CONSTRAINT `login_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `login` (`id`),
  CONSTRAINT `login_ibfk_3` FOREIGN KEY (`deleted_by`) REFERENCES `login` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci;


CREATE TABLE `login_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) COLLATE utf8mb4_czech_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci;
