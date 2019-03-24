CREATE TABLE `SITE_DB`.`items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,

  `sindex` varchar(255) NULL DEFAULT NULL,
  `status` int(11) NOT NULL,
  `itemtype` varchar(40) NOT NULL,

  `user_id` int(11) NULL DEFAULT NULL,

  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_at` timestamp NULL DEFAULT NULL,
  `published_at` timestamp NULL DEFAULT NULL,

  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `sindex` (`sindex`),
  CONSTRAINT `items_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `SITE_DB`.`users` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;