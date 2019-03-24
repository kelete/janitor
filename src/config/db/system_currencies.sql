CREATE TABLE `SITE_DB`.`system_currencies` (
  `id` varchar(3) NOT NULL,
  `name` varchar(50) NOT NULL,

  `abbreviation` varchar(10) NOT NULL,
  `abbreviation_position` varchar(10) NOT NULL DEFAULT 'after',

  `decimals` int(11) NOT NULL DEFAULT 0,
  `decimal_separator` varchar(1) NOT NULL DEFAULT ',',
  `grouping_separator` varchar(1) NOT NULL DEFAULT '.',

  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;