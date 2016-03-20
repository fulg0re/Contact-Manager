/*
SQLyog Trial v12.2.1 (64 bit)
MySQL - 5.5.25 : Database - data
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`data` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `data`;

/*Table structure for table `contacts` */

DROP TABLE IF EXISTS `contacts`;

CREATE TABLE `contacts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstName` varchar(255) NOT NULL,
  `lastName` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `homePhone` varchar(255) NOT NULL,
  `homePhoneChecked` varchar(5) NOT NULL,
  `workPhone` varchar(255) NOT NULL,
  `workPhoneChecked` varchar(5) NOT NULL,
  `cellPhone` varchar(255) NOT NULL,
  `cellPhoneChecked` varchar(5) NOT NULL,
  `adress1` varchar(255) NOT NULL,
  `adress2` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `zip` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `birthday` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

/*Data for the table `contacts` */

insert  into `contacts`(`id`,`firstName`,`lastName`,`email`,`homePhone`,`homePhoneChecked`,`workPhone`,`workPhoneChecked`,`cellPhone`,`cellPhoneChecked`,`adress1`,`adress2`,`city`,`state`,`zip`,`country`,`birthday`) values 
(1,'Pavlo','Denys','fulg0re.den@gmail.com','(0352) 28-90-83','false','(067) 35-150-77','false','(067) 35-150-35','true','Ternopil1','Ternopil2','Ternopil3','Ternopil4','46016','Ukraine','11.07.1989'),
(2,'Ivan','Ivanov','Ivan@gmail.com','(0352) 11-22-33','true','(067) 11-222-33','false','(095) 33-111-22','false','Kiev1','Kiev2','Kiev3','Kiev4','489562','Ukraine','25.11.1987'),
(11,'jhgbuy','buy','bu','uy','false','bu','true','yb','false','u','yb','oj','niouj','ni','un','iu');

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `users` */

insert  into `users`(`id`,`username`,`password`) values 
(1,'qwe','056eafe7cf52220de2df36845b8ed170c67e23e3');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
