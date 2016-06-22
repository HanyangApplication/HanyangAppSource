-- MySQL dump 10.13  Distrib 5.1.73, for redhat-linux-gnu (x86_64)
--
-- Host: localhost    Database: hyumini
-- ------------------------------------------------------
-- Server version	5.1.73-log

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
-- Table structure for table `CommuteBus`
--

DROP TABLE IF EXISTS `CommuteBus`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `CommuteBus` (
  `time` tinyint(1) NOT NULL DEFAULT '0',
  `routeName` int(11) NOT NULL DEFAULT '0',
  `route` varchar(1000) DEFAULT NULL,
  PRIMARY KEY (`time`,`routeName`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `CommuteBus`
--

LOCK TABLES `CommuteBus` WRITE;
/*!40000 ALTER TABLE `CommuteBus` DISABLE KEYS */;
/*!40000 ALTER TABLE `CommuteBus` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ConnectLecture`
--

DROP TABLE IF EXISTS `ConnectLecture`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ConnectLecture` (
  `SID` char(10) NOT NULL,
  `lectureID` char(7) NOT NULL,
  KEY `SID` (`SID`),
  KEY `lectureID` (`lectureID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ConnectLecture`
--

LOCK TABLES `ConnectLecture` WRITE;
/*!40000 ALTER TABLE `ConnectLecture` DISABLE KEYS */;
INSERT INTO `ConnectLecture` VALUES ('2013043285','ELE3026'),('2013043285','CSE4006'),('2013043285','GEN4051'),('2010036831','ELE3026'),('2010036831','CSE4006'),('2010036831','MAT4006'),('2010036831','CYB9001'),('2009034723','ECC3005'),('2009034723','ECC3004'),('2009034723','ECE4065'),('2009034723','CSE4006'),('2009034723','EIS1003'),('2013042895','ELE3026'),('2013042895','CSE4006'),('2013042895','GEN3064'),('2013043296','CSE4006'),('2013043296','ELE3026'),('2013043296','CSE4076'),('2011037161','CLU1066'),('2011037161','CYB9001'),('2011037161','CSE4006'),('2011037161','ITE4067'),('2016113819','CSE9099'),('2016113819','CSE8043'),('2016113819','CSE4006'),('2015123555','CSE8069'),('2015123555','CSE4006'),('2015123555','CSE8046'),('2015151786','CSE8069'),('2015151786','CSE4006'),('2015151786','CSE8046');
/*!40000 ALTER TABLE `ConnectLecture` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Lecture`
--

DROP TABLE IF EXISTS `Lecture`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Lecture` (
  `lectureID` char(7) NOT NULL DEFAULT '',
  `lectureName` varchar(30) DEFAULT NULL,
  `professor` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`lectureID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Lecture`
--

LOCK TABLES `Lecture` WRITE;
/*!40000 ALTER TABLE `Lecture` DISABLE KEYS */;
INSERT INTO `Lecture` VALUES ('ELE3026','객체지향개발론','김정선'),('CSE4006','소프트웨어공학','Scott Uk-Jin Lee'),('GEN4051','초우량기업의조건','전상길'),('CYB9001','사이버토익','이다미'),('MAT2009','미분방정식','마상백'),('ECC3005','고급전자물리','심종인'),('ECC3004','불규칙변수론','김동우'),('ECE4065','컴퓨터네트워크1','김동우'),('EIS1003','제어시스템공학','송택렬'),('GEN3064','고급컴퓨터활용','최기환'),('CSE4076','정보검색론','김영훈'),('CLU1066','특허와협상','송지성'),('ITE4067','임베디드소프트웨어설계','윤종원'),('CSE9099','소프트웨어구조특강','김정선'),('CSE8043','알고리즘해석','오희국');
/*!40000 ALTER TABLE `Lecture` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `LectureSchedule`
--

DROP TABLE IF EXISTS `LectureSchedule`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `LectureSchedule` (
  `lectureID` char(7) NOT NULL DEFAULT '',
  `dayOfWeek` int(1) unsigned NOT NULL DEFAULT '0',
  `startTime` time NOT NULL DEFAULT '00:00:00',
  `endTime` time DEFAULT NULL,
  `classroom` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`lectureID`,`dayOfWeek`,`startTime`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `LectureSchedule`
--

LOCK TABLES `LectureSchedule` WRITE;
/*!40000 ALTER TABLE `LectureSchedule` DISABLE KEYS */;
INSERT INTO `LectureSchedule` VALUES ('ELE3026',1,'13:00:00','14:30:00','Y005-0305'),('CSE4006',2,'11:00:00','12:30:00','Y005-0305'),('GEN4051',3,'15:30:00','17:30:00','Y015-0301'),('ELE3026',5,'10:30:00','12:00:00','Y005-0304'),('CSE4006',5,'13:00:00','15:00:00','Y021-0318'),('CSE4006',5,'15:00:00','16:30:00','Y005-0305'),('MAT2009',2,'09:00:00','10:30:00','Y005-0407'),('MAT2009',3,'15:00:00','16:30:00','Y005-0503'),('ECC3005',1,'13:00:00','14:30:00','Y005-0407'),('ECC3004',1,'14:30:00','16:00:00','Y005-0401'),('ECE4065',1,'16:00:00','17:30:00','Y005-0401'),('EIS1003',2,'13:00:00','14:30:00','Y005-0401'),('ECE4065',3,'10:30:00','12:00:00','Y005-0303'),('ECC3004',3,'15:00:00','16:30:00','Y005-0505'),('ECC3005',3,'16:30:00','18:00:00','Y005-0407'),('EIS1003',4,'14:30:00','16:00:00','Y005-0501'),('GEN3064',3,'15:30:00','17:30:00','Y015-0301'),('CSE4076',1,'09:00:00','10:30:00','Y005-0305'),('CSE4076',2,'09:00:00','10:30:00','Y005-0509'),('ITE4067',3,'10:00:00','12:00:00','Y022-0412'),('ITE4067',3,'15:00:00','17:00:00','Y022-0412'),('CLU1066',4,'16:00:00','18:00:00','Y048-0304'),('CSE9099',1,'09:00:00','12:00:00','Y005-0405'),('CSE8043',2,'16:00:00','19:00:00','Y005-0405'),('CSE8069',2,'13:00:00','16:00:00','Y005-0405'),('CSE8046',4,'09:30:00','12:30:00','Y022-0412');
/*!40000 ALTER TABLE `LectureSchedule` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `OTP`
--

DROP TABLE IF EXISTS `OTP`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `OTP` (
  `SID` char(10) NOT NULL,
  `OTP` varchar(42) DEFAULT NULL,
  `expire` datetime DEFAULT NULL,
  PRIMARY KEY (`SID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `OTP`
--

LOCK TABLES `OTP` WRITE;
/*!40000 ALTER TABLE `OTP` DISABLE KEYS */;
INSERT INTO `OTP` VALUES ('2013043285','*F5B45C597770C5AF5FE3B55DE35A51541221CDA7','2016-06-20 14:57:54');
/*!40000 ALTER TABLE `OTP` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Post`
--

DROP TABLE IF EXISTS `Post`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Post` (
  `postID` int(255) unsigned NOT NULL AUTO_INCREMENT,
  `title` tinytext,
  `content` text,
  `numberOfRead` int(255) DEFAULT NULL,
  `writer` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`postID`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Post`
--

LOCK TABLES `Post` WRITE;
/*!40000 ALTER TABLE `Post` DISABLE KEYS */;
INSERT INTO `Post` VALUES (1,'첫 번째 게시글','첫 번째 게시글 입니다.',3,'김진희'),(2,'두 번째 게시글','두 번째 게시글입니다.\r\n\r\n수정',42,'김진희'),(3,'로그인 한 이후 첫 글 제목 수정','로그인 한 이후 첫 글입니다.\r\n내용수정',22,'woo'),(4,'로그인 한 이후 첫 글','로그인 한 이후 첫 글입니다.',60,'woo'),(5,'또 다른 사용자','나다',144,'관리자'),(8,'테스트용 글입니다.','테스트용 내용입니다.',23,'테스터1'),(7,'test','ㅗ됴\r\nHI',31,'테스터1'),(11,'Rkskrksk','Dhjddj',1,'이학진'),(10,'Test','Hi test1',5,'안윤근'),(12,'Jjjjjk','Jkkkk',1,'이학진'),(13,'Jdjdksk','Jdkdkddkek',1,'이학진'),(14,'Jdjxkoxleel','Kxkdekk',1,'이학진'),(15,'Kskksksk','Ndnnsjjs',1,'이학진'),(16,'Szjzkzkzkzk','Kxkxxkzkk',1,'이학진'),(17,'Jxkkzzkzk','Ksksks',1,'이학진');
/*!40000 ALTER TABLE `Post` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Reply`
--

DROP TABLE IF EXISTS `Reply`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Reply` (
  `replyID` int(11) NOT NULL AUTO_INCREMENT,
  `postID` int(11) DEFAULT NULL,
  `content` varchar(4000) DEFAULT NULL,
  `writer` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`replyID`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Reply`
--

LOCK TABLES `Reply` WRITE;
/*!40000 ALTER TABLE `Reply` DISABLE KEYS */;
INSERT INTO `Reply` VALUES (1,2,'첫 번째 댓글 수정','김진희'),(2,2,'두 번째 댓글','김진희'),(3,3,'첫 댓글 본인 수정','woo'),(5,2,'다른 사람 댓글','woo'),(8,4,'asdafsddf','woo'),(7,2,'다른 사람 댓글3 작성자 수정','woo'),(9,4,'fdgdfg','woo'),(10,5,'너냐?','관리자'),(11,5,'응, 나야 수정','관리자'),(16,8,'테스트용 댓글입니다.','테스터1'),(17,8,'테스트용 댓글입니ㅗ옹오다.','안윤근');
/*!40000 ALTER TABLE `Reply` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Semester`
--

DROP TABLE IF EXISTS `Semester`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Semester` (
  `semester` varchar(16) NOT NULL,
  `start` date NOT NULL,
  `end` date NOT NULL,
  UNIQUE KEY `semester` (`semester`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Semester`
--

LOCK TABLES `Semester` WRITE;
/*!40000 ALTER TABLE `Semester` DISABLE KEYS */;
INSERT INTO `Semester` VALUES ('semester','2016-03-02','2016-06-23'),('session','2016-06-24','2016-07-15'),('break','2016-07-16','2016-08-31');
/*!40000 ALTER TABLE `Semester` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ShuttleBus`
--

DROP TABLE IF EXISTS `ShuttleBus`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ShuttleBus` (
  `session` tinyint(1) NOT NULL DEFAULT '0',
  `dayOfWeek` tinyint(1) NOT NULL DEFAULT '0',
  `courseName` varchar(20) NOT NULL DEFAULT '',
  `time` time NOT NULL DEFAULT '00:00:00',
  PRIMARY KEY (`session`,`dayOfWeek`,`courseName`,`time`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ShuttleBus`
--

LOCK TABLES `ShuttleBus` WRITE;
/*!40000 ALTER TABLE `ShuttleBus` DISABLE KEYS */;
/*!40000 ALTER TABLE `ShuttleBus` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `User`
--

DROP TABLE IF EXISTS `User`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `User` (
  `ID` varchar(15) DEFAULT NULL,
  `SID` char(10) NOT NULL DEFAULT '',
  `email` varchar(30) DEFAULT NULL,
  `PW` varchar(42) DEFAULT NULL,
  `name` varchar(30) DEFAULT NULL,
  `master` int(1) unsigned DEFAULT NULL,
  PRIMARY KEY (`SID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `User`
--

LOCK TABLES `User` WRITE;
/*!40000 ALTER TABLE `User` DISABLE KEYS */;
INSERT INTO `User` VALUES (NULL,'Admin',NULL,'Admin','관리자',1),('rpsprpsp','TESTER1','frebern@naver.com','*84AF661C39A4F7868F88D518298B75CD3D4AD9E4','테스터1',0),('rlslrlsl','TESTER2','frebern@naver.com','*E7E7C35146328AD219A8327F587E3180ADF9545B','테스터2',1),('frebern','2013043285','frebern@hanyang.ac.kr','*84AF661C39A4F7868F88D518298B75CD3D4AD9E4','안윤근',0),('rhshrhsh','2010036831','rhshrhsh@hanyang.ac.kr','*40FB0396556B0CF76F75E58FDDF8656B17936FEC','이학진',0),(NULL,'2009034723',NULL,'2009034723','김진희',0),(NULL,'2013042895',NULL,'2013042895','성다혜',0),(NULL,'2013043296',NULL,'2013043296','우승연',0),(NULL,'2011037161',NULL,'2011037161','송형석',0),('koliaok','2016113819','koliaok@hanyang.ac.kr','*79A3B3704ACBA5393B35A42A28855AB6E41A03E0','김형락',0),(NULL,'2015123555',NULL,'2015123555','김선웅',0),(NULL,'2015151786',NULL,'2015151786','Wu Zhiqiang',0);
/*!40000 ALTER TABLE `User` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `WeeklyMenu`
--

DROP TABLE IF EXISTS `WeeklyMenu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `WeeklyMenu` (
  `cafeteriaID` int(1) unsigned NOT NULL DEFAULT '0',
  `dayOfWeek` int(1) unsigned NOT NULL DEFAULT '0',
  `time` int(1) unsigned NOT NULL DEFAULT '0',
  `menu` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`cafeteriaID`,`dayOfWeek`,`time`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `WeeklyMenu`
--

LOCK TABLES `WeeklyMenu` WRITE;
/*!40000 ALTER TABLE `WeeklyMenu` DISABLE KEYS */;
/*!40000 ALTER TABLE `WeeklyMenu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cafeteriaPreference`
--

DROP TABLE IF EXISTS `cafeteriaPreference`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cafeteriaPreference` (
  `SID` char(10) NOT NULL DEFAULT '',
  `rank1` tinyint(1) DEFAULT NULL,
  `rank2` tinyint(1) DEFAULT NULL,
  `rank3` tinyint(1) DEFAULT NULL,
  `rank4` tinyint(1) DEFAULT NULL,
  `rank5` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`SID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cafeteriaPreference`
--

LOCK TABLES `cafeteriaPreference` WRITE;
/*!40000 ALTER TABLE `cafeteriaPreference` DISABLE KEYS */;
/*!40000 ALTER TABLE `cafeteriaPreference` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `periodtime`
--

DROP TABLE IF EXISTS `periodtime`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `periodtime` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `year` int(11) DEFAULT NULL,
  `period` varchar(45) DEFAULT NULL,
  `begin` varchar(45) DEFAULT NULL,
  `due` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `periodtime`
--

LOCK TABLES `periodtime` WRITE;
/*!40000 ALTER TABLE `periodtime` DISABLE KEYS */;
INSERT INTO `periodtime` VALUES (1,2016,'winter','2016-06-20','2016-06-26'),(2,2016,'winter','2016-06-20','2016-06-01'),(3,2016,'winter','2016-06-16','2016-06-01'),(4,2016,'winter','2016-06-22','2016-07-01');
/*!40000 ALTER TABLE `periodtime` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `room`
--

DROP TABLE IF EXISTS `room`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `room` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `building` varchar(45) DEFAULT NULL,
  `room` varchar(45) DEFAULT NULL,
  `num` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `room`
--

LOCK TABLES `room` WRITE;
/*!40000 ALTER TABLE `room` DISABLE KEYS */;
/*!40000 ALTER TABLE `room` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `students`
--

DROP TABLE IF EXISTS `students`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `students` (
  `name` varchar(40) NOT NULL,
  `id` char(10) NOT NULL,
  `building` varchar(45) DEFAULT NULL,
  `room` varchar(45) DEFAULT NULL,
  `payment` tinyint(1) DEFAULT '0',
  `status` tinyint(1) DEFAULT '0',
  `a_building` varchar(45) DEFAULT NULL,
  `a_room` varchar(45) DEFAULT NULL,
  `roomtype` int(11) DEFAULT NULL,
  `address` varchar(50) DEFAULT NULL,
  `disability` tinyint(1) DEFAULT '0',
  `remark` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `students`
--

LOCK TABLES `students` WRITE;
/*!40000 ALTER TABLE `students` DISABLE KEYS */;
INSERT INTO `students` VALUES ('wzq','2015',NULL,NULL,1,1,'dorm1','3',NULL,NULL,0,NULL),('aaa','2016','dorm1','12',1,1,'dorm3','353',NULL,NULL,0,NULL),('abc','2015151786',NULL,NULL,0,0,'dorm2','353',NULL,NULL,0,NULL),('123','123',NULL,NULL,0,0,'dorm1','3',NULL,NULL,0,NULL),('w','1234',NULL,NULL,0,0,'dorm1','350',NULL,NULL,0,NULL),('yami','10292',NULL,NULL,0,0,'dorm1','123',NULL,NULL,0,NULL),('sdfsdfdsf','12312321',NULL,NULL,0,0,'dorm1','231',NULL,NULL,0,NULL),('12312','21312',NULL,NULL,0,0,'dorm1','sdfsdfdsf',NULL,NULL,0,NULL);
/*!40000 ALTER TABLE `students` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-06-20 16:52:19
