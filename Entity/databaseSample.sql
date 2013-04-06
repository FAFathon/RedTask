-- Host: localhost
-- Generation Time: Apr 06, 2013 at 10:03 PM
-- Server version: 5.6.10
-- PHP Version: 5.4.12

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `RedTask`
--

-- --------------------------------------------------------

--
-- Table structure for table `labels`
--

CREATE TABLE IF NOT EXISTS `labels` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `label_task`
--

CREATE TABLE IF NOT EXISTS `label_task` (
  `label_id` int(11) NOT NULL,
  `task_id` int(11) NOT NULL,
  UNIQUE KEY `l_t` (`label_id`,`task_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE IF NOT EXISTS `tasks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `description` text,
  `deadline` datetime DEFAULT NULL,
  `time_estimated` int(11) DEFAULT NULL,
  `time_spent` int(11) DEFAULT NULL,
  `priority` tinyint(3) DEFAULT NULL,
  `progress` int(11) DEFAULT NULL,
  `weight` int(11) DEFAULT NULL,
  `done` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

