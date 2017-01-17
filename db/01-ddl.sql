-- MySQL dump 10.11
--
-- Host: localhost    Database: fruit
-- ------------------------------------------------------
-- Server version	5.0.51b-community-nt-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Current Database: `fruit`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `fruit` /*!40100 DEFAULT CHARACTER SET utf8 */;

GRANT ALL PRIVILEGES ON fruit.* TO 'fruit'@'%' WITH GRANT OPTION;

USE `fruit`;

--
-- Table structure for table `fm_cat_log`
--

DROP TABLE IF EXISTS `fm_cat_log`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `fm_cat_log` (
  `id` int(11) NOT NULL auto_increment,
  `fm_name` varchar(100) NOT NULL,
  `fm_descr` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `fm_priority`
--

DROP TABLE IF EXISTS `fm_priority`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `fm_priority` (
  `id` int(11) NOT NULL auto_increment,
  `fm_name` varchar(100) NOT NULL,
  `fm_descr` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `fm_project`
--

DROP TABLE IF EXISTS `fm_project`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `fm_project` (
  `id` int(11) NOT NULL auto_increment,
  `fm_name` varchar(100) NOT NULL,
  `fm_descr` varchar(255) NOT NULL,
  `fm_manager` varchar(255) NOT NULL,
  `fm_parent` int(11) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `fm_relation`
--

DROP TABLE IF EXISTS `fm_relation`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `fm_relation` (
  `id` int(11) NOT NULL auto_increment,
  `fm_parent` int(11) NOT NULL,
  `fm_child` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `fm_state`
--

DROP TABLE IF EXISTS `fm_state`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `fm_state` (
  `id` int(11) NOT NULL auto_increment,
  `fm_name` varchar(100) NOT NULL,
  `fm_descr` varchar(255) NOT NULL,
  `fm_next_state` int(11) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `fm_subscribe`
--

DROP TABLE IF EXISTS `fm_subscribe`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `fm_subscribe` (
  `id` int(11) NOT NULL auto_increment,
  `fm_task` int(11) NOT NULL,
  `fm_user` varchar(25) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `fm_task`
--

DROP TABLE IF EXISTS `fm_task`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `fm_task` (
  `id` int(11) NOT NULL auto_increment,
  `fm_name` varchar(100) NOT NULL,
  `fm_descr` varchar(255) default NULL,
  `fm_project` int(11) NOT NULL,
  `fm_state` int(11) NOT NULL,
  `fm_priority` int(11) NOT NULL default '2',
  `fm_plan` int(11) NOT NULL default '0',
  `fm_user` varchar(25) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

/*!50003 SET @SAVE_SQL_MODE=@@SQL_MODE*/;

DELIMITER ;;
/*!50003 SET SESSION SQL_MODE="STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION" */;;
/*!50003 CREATE */ /*!50017 DEFINER=`root`@`localhost` */ /*!50003 TRIGGER `i_add_work_log` AFTER INSERT ON `fm_task` FOR EACH ROW BEGIN
	INSERT INTO fm_work_log
    SELECT  null, new.id, 1, curdate(), now(), 0, concat(s.fm_descr), new.fm_user
    FROM fm_state s WHERE new.fm_state = s.id;
END */;;

/*!50003 SET SESSION SQL_MODE="STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION" */;;
/*!50003 CREATE */ /*!50017 DEFINER=`root`@`localhost` */ /*!50003 TRIGGER `u_add_work_log` AFTER UPDATE ON `fm_task` FOR EACH ROW BEGIN
    IF new.fm_state <> old.fm_state THEN
        INSERT INTO fm_work_log
        SELECT  null, new.id, 1, curdate(), now(), 0, concat(s.fm_descr), new.fm_user
        FROM fm_state s WHERE new.fm_state = s.id;
     END IF;
END */;;

/*!50003 SET SESSION SQL_MODE="STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION" */;;
/*!50003 CREATE */ /*!50017 DEFINER=`root`@`localhost` */ /*!50003 TRIGGER `d_remove_work_log` AFTER DELETE ON `fm_task` FOR EACH ROW BEGIN
   DELETE FROM fm_work_log where fm_task = old.id;
END */;;

DELIMITER ;
/*!50003 SET SESSION SQL_MODE=@SAVE_SQL_MODE*/;

--
-- Table structure for table `fm_timesheet`
--

DROP TABLE IF EXISTS `fm_timesheet`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `fm_timesheet` (
  `task_id` int(11) default NULL,
  `task_name` varchar(25) default NULL,
  `task_descr` varchar(255) default NULL,
  `task_state` varchar(25) default NULL,
  `project_name` varchar(25) default NULL,
  `task_spent_mon` int(11) default NULL,
  `task_spent_tue` int(11) default NULL,
  `task_spent_wen` int(11) default NULL,
  `task_spent_th` int(11) default NULL,
  `task_spent_fr` int(11) default NULL,
  `work_week` int(11) default NULL,
  `work_year` int(11) default NULL,
  `work_user` varchar(25) default NULL,
  KEY `fm_timesheet_work_user` USING BTREE (`work_user`,`work_week`,`work_year`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `fm_work_log`
--

DROP TABLE IF EXISTS `fm_work_log`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `fm_work_log` (
  `id` int(11) NOT NULL auto_increment,
  `fm_task` int(11) NOT NULL,
  `fm_cat` int(11) default NULL,
  `fm_date` datetime NOT NULL,
  `fm_date_actual` datetime default NULL,
  `fm_spent_hour` double NOT NULL,
  `fm_comment` varchar(255) default NULL,
  `fm_user` varchar(25) default NULL,
  PRIMARY KEY  (`id`),
  KEY `fm_work_log_fm_user` (`fm_user`),
  KEY `fm_work_log_fm_task` (`fm_task`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

/*!50003 SET @SAVE_SQL_MODE=@@SQL_MODE*/;

DELIMITER ;;
/*!50003 SET SESSION SQL_MODE="NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION" */;;
/*!50003 CREATE */ /*!50017 DEFINER=`root`@`localhost` */ /*!50003 TRIGGER `i_update_timesheet` AFTER INSERT ON `fm_work_log` FOR EACH ROW BEGIN
    if new.fm_spent_hour > 0 then
        call prc_timesheet(week(new.fm_date), year(new.fm_date), new.fm_user);
    END If;
END */;;

/*!50003 SET SESSION SQL_MODE="NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION" */;;
/*!50003 CREATE */ /*!50017 DEFINER=`root`@`localhost` */ /*!50003 TRIGGER `d_update_timesheet` AFTER DELETE ON `fm_work_log` FOR EACH ROW BEGIN
	if old.fm_spent_hour > 0 then
		call prc_timesheet(week(old.fm_date), year(old.fm_date), old.fm_user);
	END if;
END */;;

DELIMITER ;
/*!50003 SET SESSION SQL_MODE=@SAVE_SQL_MODE*/;

--
-- Temporary table structure for view `v_task_all`
--

DROP TABLE IF EXISTS `v_task_all`;
/*!50001 DROP VIEW IF EXISTS `v_task_all`*/;
/*!50001 CREATE TABLE `v_task_all` (
  `id` int(11),
  `fm_project_id` int(11),
  `fm_project` varchar(100),
  `fm_project_descr` varchar(255),
  `fm_manager` varchar(255),
  `fm_name` varchar(104),
  `fm_code` varchar(100),
  `fm_descr` varchar(255),
  `fm_state` varchar(255),
  `fm_state_name` varchar(100),
  `fm_next_state_id` int(11),
  `fm_priority` int(11),
  `fm_priority_name` varchar(100),
  `fm_priority_descr` varchar(255),
  `fm_week_hour` double,
  `fm_all_hour` double,
  `fm_plan_hour` int(11),
  `fm_last_comment` varchar(255),
  `fm_user` varchar(25)
) */;

--
-- Temporary table structure for view `v_task_in_progress`
--

DROP TABLE IF EXISTS `v_task_in_progress`;
/*!50001 DROP VIEW IF EXISTS `v_task_in_progress`*/;
/*!50001 CREATE TABLE `v_task_in_progress` (
  `id` int(11),
  `fm_project_id` int(11),
  `fm_project` varchar(100),
  `fm_project_descr` varchar(255),
  `fm_manager` varchar(255),
  `fm_name` varchar(104),
  `fm_code` varchar(100),
  `fm_descr` varchar(255),
  `fm_state` varchar(255),
  `fm_state_name` varchar(100),
  `fm_priority` int(11),
  `fm_priority_name` varchar(100),
  `fm_priority_descr` varchar(255),
  `fm_week_hour` double,
  `fm_all_hour` double,
  `fm_plan_hour` int(11),
  `fm_last_comment` varchar(255),
  `fm_user` varchar(25)
) */;

--
-- Dumping routines for database 'tm'
--
DELIMITER ;;
/*!50003 DROP FUNCTION IF EXISTS `func_full_project_descr` */;;
/*!50003 SET SESSION SQL_MODE="STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER"*/;;
/*!50003 CREATE*/ /*!50020 DEFINER=`root`@`localhost`*/ /*!50003 FUNCTION `func_full_project_descr`(project INT) RETURNS varchar(100) CHARSET cp1251
RETURN (select fm_name from fm_project where id = project) */;;
/*!50003 SET SESSION SQL_MODE=@OLD_SQL_MODE*/;;
/*!50003 DROP FUNCTION IF EXISTS `func_hour_day` */;;
/*!50003 SET SESSION SQL_MODE="NO_AUTO_CREATE_USER"*/;;
/*!50003 CREATE*/ /*!50020 DEFINER=`root`@`localhost`*/ /*!50003 FUNCTION `func_hour_day`(task INT, daynum INT, weeknum INT, weekyear INT, username VARCHAR(25)) RETURNS int(11)
RETURN coalesce((select sum(fm_spent_hour) from fm_work_log where fm_task = task and dayofweek(fm_date) = daynum and week(fm_date) = weeknum and year(fm_date) = weekyear and fm_user = username), 0) */;;
/*!50003 SET SESSION SQL_MODE=@OLD_SQL_MODE*/;;
/*!50003 DROP PROCEDURE IF EXISTS `prc_timesheet` */;;
/*!50003 SET SESSION SQL_MODE="NO_AUTO_CREATE_USER"*/;;
/*!50003 CREATE*/ /*!50020 DEFINER=`root`@`localhost`*/ /*!50003 PROCEDURE `prc_timesheet`(IN weeknum INT, IN weekyear INT, IN username VARCHAR(25))
BEGIN
        delete from fm_timesheet where work_week = weeknum and work_year = weekyear and work_user = username;
        insert into fm_timesheet
        select
            t.id,
            t.fm_name,
            t.fm_descr,
            s.fm_descr,
            p.fm_name,
            func_hour_day(t.id, 2, weeknum, weekyear, username),
            func_hour_day(t.id, 3, weeknum, weekyear, username),
            func_hour_day(t.id, 4, weeknum, weekyear, username),
            func_hour_day(t.id, 5, weeknum, weekyear, username),
            func_hour_day(t.id, 6, weeknum, weekyear, username),
            weeknum,
            weekyear,
            username
            from
                fm_task t,
                fm_project p,
                fm_state s
            where 
                t.id  in 
                        (select distinct fm_task
                                from fm_work_log
                                where fm_spent_hour > 0
                                    and fm_user = username
                                    and week(fm_date) = weeknum
                                    and year(fm_date) = weekyear) and
                t.fm_project  = p.id and
                t.fm_state  = s.id;
   END */;;
/*!50003 SET SESSION SQL_MODE=@OLD_SQL_MODE*/;;
DELIMITER ;

--
-- Current Database: `fruit`
--

USE `fruit`;

--
-- Final view structure for view `v_task_all`
--

/*!50001 DROP TABLE `v_task_all`*/;
/*!50001 DROP VIEW IF EXISTS `v_task_all`*/;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `v_task_all` AS select `t`.`id` AS `id`,`p`.`id` AS `fm_project_id`,`p`.`fm_name` AS `fm_project`,`p`.`fm_descr` AS `fm_project_descr`,`p`.`fm_manager` AS `fm_manager`,concat(convert(`p`.`fm_name` using utf8),_utf8'-',cast(`t`.`id` as char charset utf8)) AS `fm_name`,`t`.`fm_name` AS `fm_code`,`t`.`fm_descr` AS `fm_descr`,`s`.`fm_descr` AS `fm_state`,`s`.`fm_name` AS `fm_state_name`,`s`.`fm_next_state` AS `fm_next_state_id`,`t`.`fm_priority` AS `fm_priority`,`pr`.`fm_name` AS `fm_priority_name`,`pr`.`fm_descr` AS `fm_priority_descr`,coalesce((select sum(`l`.`fm_spent_hour`) AS `sum(fm_spent_hour)` from `fm_work_log` `l` where ((`l`.`fm_task` = `t`.`id`) and (week(`l`.`fm_date`,0) = week(curdate(),0)))),0) AS `fm_week_hour`,coalesce((select sum(`l`.`fm_spent_hour`) AS `sum(fm_spent_hour)` from `fm_work_log` `l` where (`l`.`fm_task` = `t`.`id`)),0) AS `fm_all_hour`,`t`.`fm_plan` AS `fm_plan_hour`,(select `fm_work_log`.`fm_comment` AS `fm_comment` from `fm_work_log` where (`fm_work_log`.`id` = (select max(`l`.`id`) AS `max(l.id)` from `fm_work_log` `l` where (`l`.`fm_task` = `t`.`id`)))) AS `fm_last_comment`,`t`.`fm_user` AS `fm_user` from (((`fm_task` `t` join `fm_project` `p` on((`t`.`fm_project` = `p`.`id`))) join `fm_state` `s` on((`t`.`fm_state` = `s`.`id`))) join `fm_priority` `pr` on((`t`.`fm_priority` = `pr`.`id`))) */;

--
-- Final view structure for view `v_task_in_progress`
--

/*!50001 DROP TABLE `v_task_in_progress`*/;
/*!50001 DROP VIEW IF EXISTS `v_task_in_progress`*/;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `v_task_in_progress` AS select `t`.`id` AS `id`,`t`.`fm_project_id` AS `fm_project_id`,`t`.`fm_project` AS `fm_project`,`t`.`fm_project_descr` AS `fm_project_descr`,`t`.`fm_manager` AS `fm_manager`,`t`.`fm_name` AS `fm_name`,`t`.`fm_code` AS `fm_code`,`t`.`fm_descr` AS `fm_descr`,`t`.`fm_state` AS `fm_state`,`t`.`fm_state_name` AS `fm_state_name`,`t`.`fm_priority` AS `fm_priority`,`t`.`fm_priority_name` AS `fm_priority_name`,`t`.`fm_priority_descr` AS `fm_priority_descr`,`t`.`fm_week_hour` AS `fm_week_hour`,`t`.`fm_all_hour` AS `fm_all_hour`,`t`.`fm_plan_hour` AS `fm_plan_hour`,`t`.`fm_last_comment` AS `fm_last_comment`,`t`.`fm_user` AS `fm_user` from `v_task_all` `t` where (`t`.`fm_state_name` not in (_utf8'done',_utf8'decline')) */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-01-16  9:53:32
