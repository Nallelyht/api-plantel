/*
SQLyog Community v12.2.5 (64 bit)
MySQL - 10.1.21-MariaDB : Database - plantel
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`plantel` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `plantel`;

/*Table structure for table `alumno` */

DROP TABLE IF EXISTS `alumno`;

CREATE TABLE `alumno` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  `paterno` varchar(50) NOT NULL,
  `materno` varchar(50) NOT NULL,
  `curp` varchar(18) NOT NULL,
  `email` varchar(100) NOT NULL,
  `fechaNacimiento` date NOT NULL,
  `sexo` enum('M','F') NOT NULL,
  `grupo` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

/*Data for the table `alumno` */

insert  into `alumno`(`id`,`nombre`,`paterno`,`materno`,`curp`,`email`,`fechaNacimiento`,`sexo`,`grupo`) values 
(1,'Ramón','Ramírez','Gárate','9857893475738475','fdjshfjweh@hkhjk.com','1987-08-11','M',1),
(2,'Silvia','Perez','Rojas','dfhdhfhjkhfsdj','lfjsdklfj@lhkhjkh.com','1988-06-18','M',1),
(4,'sdfsdfsdfsdf','dfsdfsdfsd','sdfsdfsdfsdfsdf','sfsd3545345345345','345345345345','2017-11-01','M',2),
(5,'aaaaaaaaaaa','aaaaaaaaaaa','aaaaaaaaaaa','aaaaaaaaaaa','aaaaaaaaaaa','2021-01-27','M',3),
(6,'aaaaaaaaaaaaaaaa','aaaaaaaaaaaa','aaaaaaaaaaaaaaa','66666666666666666','ghdfghdfhfg','2017-11-23','M',4),
(7,'3453453453453','5345345345','34534534534','45345345345','3434553455345345','2017-11-01','M',4),
(8,'dasdasdas','dasdsadas','dasdasdsa','dasdasdas','ddasdasdasdas','2017-11-10','M',5),
(9,'Ramales','Andres','Ireta','IERA941124','ireta@gmail.com','1994-11-24','',3),
(10,'Carrillo','Andrea','Lopez','LALALA0101','andy@gmail.com','1993-03-31','M',4);

/*Table structure for table `grupo` */

DROP TABLE IF EXISTS `grupo`;

CREATE TABLE `grupo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  `nivel` enum('S','B') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

/*Data for the table `grupo` */

insert  into `grupo`(`id`,`nombre`,`nivel`) values 
(1,'1-A','S'),
(2,'1-B','S'),
(3,'2-A','S'),
(4,'2-B','S'),
(5,'3-A','S'),
(6,'3-B','S'),
(7,'1-A','B'),
(8,'1-B','B'),
(9,'2-A','B'),
(10,'2-B','B'),
(11,'3-A','B'),
(12,'3-B','B');

/*Table structure for table `grupo_alumnos` */

DROP TABLE IF EXISTS `grupo_alumnos`;

CREATE TABLE `grupo_alumnos` (
  `fk_alumno` int(11) NOT NULL,
  `fk_grupo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `grupo_alumnos` */

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
