CREATE TABLE IF NOT EXISTS `dmr-stats` (
  `id` int(11) NOT NULL,
  `date` date NOT NULL,
  `talktime` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `dmr-stats`
 ADD PRIMARY KEY (`id`,`date`);
