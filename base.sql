SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";
CREATE DATABASE IF NOT EXISTS `teamcrocket` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `teamcrocket`;

CREATE TABLE `ajkl7_todo` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(32) NOT NULL,
  `done` tinyint(1) NOT NULL,
  `creator_id` int(10) UNSIGNED DEFAULT NULL,
  `creation_date` datetime DEFAULT NULL,
  `modification_date` datetime DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `ajkl7_user` (
  `id` int(10) UNSIGNED NOT NULL,
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

CREATE TABLE `ajkl7_user_reset_password` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `token` varchar(32) NOT NULL,
  `date_exp` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `ajkl7_user_verification` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `token` varchar(32) NOT NULL,
  `date_exp` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


ALTER TABLE `ajkl7_todo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `creator_id` (`creator_id`);

ALTER TABLE `ajkl7_user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `nickname` (`nickname`);

ALTER TABLE `ajkl7_user_reset_password`
  ADD UNIQUE KEY `user_id` (`user_id`);

ALTER TABLE `ajkl7_user_verification`
  ADD UNIQUE KEY `user_id` (`user_id`);


ALTER TABLE `ajkl7_todo`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;
ALTER TABLE `ajkl7_user`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=126;

ALTER TABLE `ajkl7_todo`
  ADD CONSTRAINT `ajkl7_todo_ibfk_1` FOREIGN KEY (`creator_id`) REFERENCES `ajkl7_user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

ALTER TABLE `ajkl7_user_reset_password`
  ADD CONSTRAINT `uid_urp_fk` FOREIGN KEY (`user_id`) REFERENCES `ajkl7_user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

ALTER TABLE `ajkl7_user_verification`
  ADD CONSTRAINT `uid_fk` FOREIGN KEY (`user_id`) REFERENCES `ajkl7_user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;
