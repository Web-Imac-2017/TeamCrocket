SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

CREATE TABLE `ajkl7_test` (
  `id` int(10) unsigned NOT NULL,
  `testEntry1` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `ajkl7_user` (
  `id` int(10) unsigned NOT NULL,
  `nickname` varchar(32) NOT NULL,
  `password` varchar(40) NOT NULL,
  `lastname` varchar(32) NOT NULL,
  `firstname` varchar(32) NOT NULL,
  `email` varchar(128) NOT NULL,
  `sex` char(1) NOT NULL DEFAULT 'h' COMMENT 'h/f',
  `image` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `city` varchar(32) NOT NULL,
  `latitude` float NOT NULL,
  `longitude` float NOT NULL,
  `country` char(3) NOT NULL DEFAULT 'FRA' COMMENT 'ISO ALPHA-3 Code',
  `date_birth` date DEFAULT NULL,
  `verified` tinyint(1) NOT NULL DEFAULT '0',
  `creation_date` datetime DEFAULT NULL,
  `modification_date` datetime DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `ajkl7_user_verification` (
  `user_id` int(10) unsigned NOT NULL,
  `token` varchar(32) NOT NULL,
  `date_exp` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


ALTER TABLE `ajkl7_test`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `ajkl7_user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

ALTER TABLE `ajkl7_user_verification`
  ADD UNIQUE KEY `user_id` (`user_id`);


ALTER TABLE `ajkl7_test`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
ALTER TABLE `ajkl7_user`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;

ALTER TABLE `ajkl7_user_verification`
  ADD CONSTRAINT `uid_fk` FOREIGN KEY (`user_id`) REFERENCES `ajkl7_user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;
