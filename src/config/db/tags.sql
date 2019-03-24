CREATE TABLE `SITE_DB`.`tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,

  `context` varchar(50) NOT NULL,
  `value` varchar(100) NOT NULL,
  `description` text DEFAULT '',

  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;