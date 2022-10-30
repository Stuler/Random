SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

INSERT INTO `brand` (`id`, `label`, `brand_category_id`, `description`, `note`, `date_created`, `date_modified`, `date_deleted`, `created_by`, `deleted_by`) VALUES
(1,	'Garmin',	6,	'',	'',	'2022-10-27 05:30:55',	NULL,	NULL,	1,	NULL),
(2,	'Fisher',	7,	'',	'',	'2022-10-27 05:31:11',	NULL,	NULL,	1,	NULL),
(3,	'Bauer',	7,	'',	'',	'2022-10-27 05:31:20',	NULL,	NULL,	1,	NULL),
(4,	'Craft',	1,	'',	'',	'2022-10-27 05:31:31',	NULL,	NULL,	1,	NULL),
(5,	'Adidas',	1,	'',	'',	'2022-10-27 05:31:42',	'2022-10-27 03:53:22',	'2022-10-27 05:53:22',	1,	1),
(6,	'Adidas',	1,	'',	'',	'2022-10-27 05:53:41',	NULL,	NULL,	1,	NULL),
(7,	'Force',	1,	'',	'',	'2022-10-27 05:54:02',	NULL,	NULL,	1,	NULL),
(8,	'Fila',	3,	'',	'',	'2022-10-27 05:54:34',	'2022-10-30 10:58:57',	'2022-10-30 11:58:57',	1,	1),
(9,	'Klimatex',	1,	'',	'',	'2022-10-27 05:55:01',	NULL,	NULL,	1,	NULL),
(10,	'SUUNTO',	6,	'',	'',	'2022-10-27 05:55:12',	NULL,	NULL,	1,	NULL),
(11,	'Saucony',	4,	'',	'',	'2022-10-27 05:55:39',	NULL,	NULL,	1,	NULL),
(12,	'HokaOneOne',	4,	'',	'',	'2022-10-28 13:33:55',	NULL,	NULL,	1,	NULL),
(13,	'CCM',	7,	'',	'',	'2022-10-28 13:34:04',	NULL,	NULL,	1,	NULL),
(14,	'Reebok',	1,	'',	'',	'2022-10-28 13:34:13',	NULL,	NULL,	1,	NULL),
(15,	'CTM',	7,	'Kola',	'',	'2022-10-28 13:34:28',	'2022-10-30 09:40:26',	NULL,	1,	NULL),
(16,	'Scott',	7,	'',	'',	'2022-10-28 13:34:37',	'2022-10-28 19:24:14',	'2022-10-28 21:24:14',	1,	1),
(17,	'COROS',	6,	'',	'Sportovní hodinky',	'2022-10-28 13:34:46',	'2022-10-30 09:40:51',	NULL,	1,	NULL),
(18,	'StrongFirst',	7,	'',	'',	'2022-10-28 13:34:55',	'2022-10-30 10:57:40',	'2022-10-30 11:57:40',	1,	1),
(19,	'Sportful',	1,	'',	'Funkčkní a sportovní oblečení',	'2022-10-28 13:35:06',	'2022-10-30 10:54:40',	'2022-10-30 11:54:40',	1,	1),
(20,	'Under Armour',	3,	'',	'Modní a funkční sportovní oblečení',	'2022-10-28 13:38:15',	'2022-10-30 09:39:16',	NULL,	1,	NULL),
(21,	'Tom Taylor',	3,	'',	'trika',	'2022-10-28 13:38:28',	'2022-10-30 09:37:43',	NULL,	1,	NULL),
(22,	'Oakley',	6,	'',	'Stylové a sportovní brýle',	'2022-10-28 13:38:35',	'2022-10-30 09:49:28',	NULL,	1,	NULL),
(23,	'Sulov',	7,	'',	'',	'2022-10-28 13:40:52',	'2022-10-29 08:31:49',	'2022-10-29 10:31:49',	1,	1),
(24,	'Nike',	1,	'',	'Módní oblečení',	'2022-10-28 13:41:11',	'2022-10-30 09:39:47',	NULL,	1,	NULL),
(25,	'Innov8',	4,	'',	'',	'2022-10-28 13:41:23',	'2022-10-29 08:32:46',	'2022-10-29 10:32:46',	1,	1),
(26,	'CMP',	5,	'Obuv',	'',	'2022-10-28 21:24:56',	'2022-10-30 10:54:02',	'2022-10-30 11:54:02',	1,	1),
(27,	'Giro',	7,	'Kvalitní',	'Cyklistické přilby',	'2022-10-29 10:33:34',	'2022-10-30 10:53:13',	'2022-10-30 11:53:13',	1,	1),
(28,	'Giro',	NULL,	'',	'',	'2022-10-30 11:01:13',	'2022-10-30 10:01:15',	'2022-10-30 11:01:15',	1,	1),
(29,	'Giro',	NULL,	'',	'',	'2022-10-30 11:02:05',	'2022-10-30 10:02:11',	'2022-10-30 11:02:11',	1,	1),
(30,	'Giro',	NULL,	'',	'',	'2022-10-30 11:05:07',	'2022-10-30 10:05:09',	'2022-10-30 11:05:09',	1,	1),
(31,	'Giro',	NULL,	'',	'',	'2022-10-30 11:05:16',	'2022-10-30 10:05:18',	'2022-10-30 11:05:18',	1,	1),
(32,	'Giro',	NULL,	'',	'',	'2022-10-30 11:06:46',	'2022-10-30 10:06:50',	'2022-10-30 11:06:50',	1,	1),
(33,	'Giro',	NULL,	'',	'',	'2022-10-30 11:07:05',	'2022-10-30 10:07:07',	'2022-10-30 11:07:07',	1,	1),
(34,	'Giro',	NULL,	'',	'',	'2022-10-30 11:09:14',	'2022-10-30 10:11:19',	'2022-10-30 11:11:19',	1,	1),
(35,	'Giro',	NULL,	'',	'',	'2022-10-30 11:11:29',	'2022-10-30 10:11:34',	'2022-10-30 11:11:34',	1,	1),
(36,	'Giro',	NULL,	'',	'',	'2022-10-30 11:12:18',	'2022-10-30 10:12:20',	'2022-10-30 11:12:20',	1,	1),
(37,	'Giro',	NULL,	'',	'',	'2022-10-30 11:13:05',	'2022-10-30 10:13:09',	'2022-10-30 11:13:09',	1,	1),
(38,	'Giros',	NULL,	'',	'',	'2022-10-30 11:15:05',	'2022-10-30 10:15:07',	'2022-10-30 11:15:07',	1,	1),
(39,	'gir',	NULL,	'',	'',	'2022-10-30 11:49:36',	'2022-10-30 10:49:44',	'2022-10-30 11:49:44',	1,	1),
(40,	'AlpinePro',	NULL,	'',	'',	'2022-10-30 12:33:18',	NULL,	NULL,	1,	NULL);

INSERT INTO `brand_category` (`id`, `label`, `description`, `note`, `date_created`, `date_modified`, `date_deleted`, `created_by`, `deleted_by`) VALUES
(1,	'Sportovní oblečení',	'Sportovní oblečení',	'',	'2022-10-26 21:33:21',	'2022-10-26 19:37:28',	NULL,	1,	NULL),
(3,	'Stylové oblečení',	'',	'',	'2022-10-26 21:38:01',	NULL,	NULL,	1,	NULL),
(4,	'Sportovní obuv',	'',	'',	'2022-10-26 21:38:20',	NULL,	NULL,	1,	NULL),
(5,	'Outdoorová obuv',	'',	'',	'2022-10-26 21:38:53',	NULL,	NULL,	1,	NULL),
(6,	'Sportovní doplňky',	'',	'',	'2022-10-26 21:39:12',	NULL,	NULL,	1,	NULL),
(7,	'Sportovní výbava',	'',	'',	'2022-10-27 05:26:48',	NULL,	NULL,	1,	NULL);

INSERT INTO `login` (`id`, `name`, `first_name`, `last_name`, `login_role_id`, `email`, `password`, `date_created`, `date_modified`, `date_deleted`, `created_by`, `deleted_by`) VALUES
(1,	'administrátor',	'',	'',	1,	'admin@sporti.cz',	'7e240de74fb1ed08',	'2022-10-25 20:45:33',	NULL,	NULL,	1,	NULL);

INSERT INTO `login_role` (`id`, `name`) VALUES
(1,	'admin'),
(2,	'user');