--
-- "La cuisine" Initial Data Base
--

--
-- Table structure for table `CATEGORIES`
--

DROP TABLE IF EXISTS `CATEGORIES`;
CREATE TABLE `CATEGORIES` (
  `cat_id` int(11) NOT NULL AUTO_INCREMENT,
  `cat_name` varchar(150) NOT NULL,
  `cat_desc` text NOT NULL,
  `cat_status` enum('0','1') NOT NULL DEFAULT '0',
  `cat_createdbyid` int(11) NOT NULL,
  `cat_createdbyname` varchar(250) NOT NULL,
  `cat_createdip` varchar(100) NOT NULL,
  `cat_createddate` datetime NOT NULL,
  `cat_modbyid` int(11) NOT NULL,
  `cat_modbyname` varchar(250) NOT NULL,
  `cat_modip` varchar(100) NOT NULL,
  `cat_moddate` datetime NOT NULL,
  PRIMARY KEY (`cat_id`)
);

--
-- Dumping data for table `CATEGORIES`
--

LOCK TABLES `CATEGORIES` WRITE;
-- Please note that categories are added via the web interface, anyways im leaving here some nice examples
-- INSERT INTO `CATEGORIES` (`cat_id`, `cat_name`, `cat_desc`, `cat_status`, `cat_createdbyid`, `cat_createdbyname`, `cat_createdip`, `cat_createddate`, `cat_modbyid`, `cat_modbyname`, `cat_modip`, `cat_moddate`) VALUES (1,'Platos fuertes','Platos fuertes','1',1,'Carlos Anibarro','192.168.100.100','2017-10-03 15:15:15',0,'','','0000-00-00 00:00:00');
-- INSERT INTO `CATEGORIES` (`cat_id`, `cat_name`, `cat_desc`, `cat_status`, `cat_createdbyid`, `cat_createdbyname`, `cat_createdip`, `cat_createddate`, `cat_modbyid`, `cat_modbyname`, `cat_modip`, `cat_moddate`) VALUES (2,'Refrescos','Sodas y refrescos','1',1,'Carlos Anibarro','192.168.100.100','2017-10-03 15:15:15',0,'','','0000-00-00 00:00:00');
-- INSERT INTO `CATEGORIES` (`cat_id`, `cat_name`, `cat_desc`, `cat_status`, `cat_createdbyid`, `cat_createdbyname`, `cat_createdip`, `cat_createddate`, `cat_modbyid`, `cat_modbyname`, `cat_modip`, `cat_moddate`) VALUES (3,'Snacks','Chocolates, dulces y galletas','1',1,'Carlos Anibarro','192.168.100.100','2017-10-03 15:15:15',0,'','','0000-00-00 00:00:00');
-- INSERT INTO `CATEGORIES` (`cat_id`, `cat_name`, `cat_desc`, `cat_status`, `cat_createdbyid`, `cat_createdbyname`, `cat_createdip`, `cat_createddate`, `cat_modbyid`, `cat_modbyname`, `cat_modip`, `cat_moddate`) VALUES (4,'Galletas','','0',1,'Carlos Anibarro','192.168.46.1','2017-10-11 10:28:47',1,'Carlos Anibarro','192.168.46.1','2017-10-11 11:08:03');
-- INSERT INTO `CATEGORIES` (`cat_id`, `cat_name`, `cat_desc`, `cat_status`, `cat_createdbyid`, `cat_createdbyname`, `cat_createdip`, `cat_createddate`, `cat_modbyid`, `cat_modbyname`, `cat_modip`, `cat_moddate`) VALUES (5,'Golosinas','','0',1,'Carlos Anibarro','192.168.100.200','2017-10-11 17:26:49',1,'Carlos Anibarro','192.168.100.200','2017-10-11 17:26:56');
-- INSERT INTO `CATEGORIES` (`cat_id`, `cat_name`, `cat_desc`, `cat_status`, `cat_createdbyid`, `cat_createdbyname`, `cat_createdip`, `cat_createddate`, `cat_modbyid`, `cat_modbyname`, `cat_modip`, `cat_moddate`) VALUES (6,'Golosinas','','1',1,'Carlos Anibarro','192.168.46.1','2017-10-16 14:07:47',0,'','','0000-00-00 00:00:00');
UNLOCK TABLES;

--
-- Table structure for table `CITIES`
--

DROP TABLE IF EXISTS `CITIES`;
CREATE TABLE `CITIES` (
  `city_id` int(11) NOT NULL AUTO_INCREMENT,
  `city_name` varchar(100) NOT NULL,
  `city_code` varchar(3) NOT NULL,
  PRIMARY KEY (`city_id`)
);

--
-- Dumping data for table `CITIES`
--

LOCK TABLES `CITIES` WRITE;
-- This depends on your country cities, anyways im leaving you some examples
-- INSERT INTO `CITIES` (`city_id`, `city_name`, `city_code`) VALUES (1,'La Paz','201');
-- INSERT INTO `CITIES` (`city_id`, `city_name`, `city_code`) VALUES (2,'Santa Cruz','701');
-- INSERT INTO `CITIES` (`city_id`, `city_name`, `city_code`) VALUES (3,'Cochabamba','301');
-- INSERT INTO `CITIES` (`city_id`, `city_name`, `city_code`) VALUES (4,'Sucre','101');
-- INSERT INTO `CITIES` (`city_id`, `city_name`, `city_code`) VALUES (5,'Potosi','501');
-- INSERT INTO `CITIES` (`city_id`, `city_name`, `city_code`) VALUES (6,'Beni','801');
-- INSERT INTO `CITIES` (`city_id`, `city_name`, `city_code`) VALUES (7,'Oruro','401');
-- INSERT INTO `CITIES` (`city_id`, `city_name`, `city_code`) VALUES (8,'Tarija','601');
-- INSERT INTO `CITIES` (`city_id`, `city_name`, `city_code`) VALUES (9,'Cobija','901');
-- INSERT INTO `CITIES` (`city_id`, `city_name`, `city_code`) VALUES (10,'El Alto','206');
-- INSERT INTO `CITIES` (`city_id`, `city_name`, `city_code`) VALUES (11,'Montero','703');
-- INSERT INTO `CITIES` (`city_id`, `city_name`, `city_code`) VALUES (12,'Yacuiba','605');
UNLOCK TABLES;

--
-- Table structure for table `DAILYMENU`
--

DROP TABLE IF EXISTS `DAILYMENU`;
CREATE TABLE `DAILYMENU` (
  `dm_id` int(11) NOT NULL AUTO_INCREMENT,
  `dm_date` date NOT NULL,
  `prod_id` int(11) NOT NULL,
  `dm_status` enum('0','1') NOT NULL DEFAULT '0',
  `dm_createdbyid` int(11) NOT NULL,
  `dm_createdbyname` varchar(250) NOT NULL,
  `dm_createdip` varchar(100) NOT NULL,
  `dm_createddate` datetime NOT NULL,
  `dm_modbyid` int(11) NOT NULL,
  `dm_modbyname` varchar(250) NOT NULL,
  `dm_modip` varchar(100) NOT NULL,
  `dm_moddate` datetime NOT NULL,
  PRIMARY KEY (`dm_id`)
);

--
-- Dumping data for table `DAILYMENU`
--

LOCK TABLES `DAILYMENU` WRITE;
UNLOCK TABLES;

--
-- Table structure for table `DEPARTMENTS`
--

DROP TABLE IF EXISTS `DEPARTMENTS`;
CREATE TABLE `DEPARTMENTS` (
  `department_id` int(11) NOT NULL AUTO_INCREMENT,
  `department_name` varchar(250) NOT NULL,
  `department_code` varchar(2) NOT NULL,
  PRIMARY KEY (`department_id`)
);

--
-- Dumping data for table `DEPARTMENTS`
--

LOCK TABLES `DEPARTMENTS` WRITE;
-- Note that this depends on your country departments, regions, etc
-- Anyways, im leaving you some examples
-- INSERT INTO `DEPARTMENTS` (`department_id`, `department_name`, `department_code`) VALUES (1,'La Paz','01');
-- INSERT INTO `DEPARTMENTS` (`department_id`, `department_name`, `department_code`) VALUES (2,'Santa Cruz','03');
-- INSERT INTO `DEPARTMENTS` (`department_id`, `department_name`, `department_code`) VALUES (3,'Cochabamba','02');
-- INSERT INTO `DEPARTMENTS` (`department_id`, `department_name`, `department_code`) VALUES (4,'Chuquisaca','07');
-- INSERT INTO `DEPARTMENTS` (`department_id`, `department_name`, `department_code`) VALUES (5,'Potosi','05');
-- INSERT INTO `DEPARTMENTS` (`department_id`, `department_name`, `department_code`) VALUES (6,'Beni','08');
-- INSERT INTO `DEPARTMENTS` (`department_id`, `department_name`, `department_code`) VALUES (7,'Oruro','04');
-- INSERT INTO `DEPARTMENTS` (`department_id`, `department_name`, `department_code`) VALUES (8,'Tarija','06');
-- INSERT INTO `DEPARTMENTS` (`department_id`, `department_name`, `department_code`) VALUES (9,'Pando','09');
UNLOCK TABLES;

--
-- Table structure for table `PHOTOS`
--

DROP TABLE IF EXISTS `PHOTOS`;
CREATE TABLE `PHOTOS` (
  `photo_id` int(11) NOT NULL AUTO_INCREMENT,
  `photo_desc` varchar(200) NOT NULL,
  `photo_prodcat` int(11) NOT NULL,
  `photo_cat` enum('0','1','2') NOT NULL DEFAULT '0',
  `photo_filename` varchar(200) NOT NULL,
  `photo_type` varchar(200) NOT NULL,
  `photo_size` varchar(20) NOT NULL,
  `photo_status` enum('0','1') NOT NULL DEFAULT '0',
  `photo_createdbyid` int(11) NOT NULL,
  `photo_createdbyname` varchar(250) NOT NULL,
  `photo_createdip` varchar(100) NOT NULL,
  `photo_createddate` datetime NOT NULL,
  `photo_modbyid` int(11) NOT NULL,
  `photo_modbyname` varchar(250) NOT NULL,
  `photo_modip` varchar(100) NOT NULL,
  `photo_moddate` datetime NOT NULL,
  PRIMARY KEY (`photo_id`)
);

--
-- Dumping data for table `PHOTOS`
--

LOCK TABLES `PHOTOS` WRITE;
UNLOCK TABLES;

--
-- Table structure for table `PRICES`
--

DROP TABLE IF EXISTS `PRICES`;
CREATE TABLE `PRICES` (
  `price_id` int(11) NOT NULL AUTO_INCREMENT,
  `prod_id` int(11) NOT NULL,
  `price_price` double NOT NULL,
  `price_desc` text NOT NULL,
  `price_status` enum('0','1') NOT NULL DEFAULT '0',
  `price_createdbyid` int(11) NOT NULL,
  `price_createdbyname` varchar(150) NOT NULL,
  `price_createdip` varchar(100) NOT NULL,
  `price_createddate` datetime NOT NULL,
  `price_modbyid` int(11) NOT NULL,
  `price_modbyname` varchar(150) NOT NULL,
  `price_modip` varchar(100) NOT NULL,
  `price_moddate` datetime NOT NULL,
  PRIMARY KEY (`price_id`)
);

--
-- Dumping data for table `PRICES`
--

LOCK TABLES `PRICES` WRITE;
UNLOCK TABLES;

--
-- Table structure for table `PRODUCTS`
--

DROP TABLE IF EXISTS `PRODUCTS`;
CREATE TABLE `PRODUCTS` (
  `prod_id` int(11) NOT NULL AUTO_INCREMENT,
  `prod_name` varchar(150) NOT NULL,
  `cat_id` int(11) NOT NULL,
  `prod_desc` text NOT NULL,
  `prod_status` enum('0','1') NOT NULL DEFAULT '0',
  `prod_createdbyid` int(11) NOT NULL,
  `prod_createdbyname` varchar(150) NOT NULL,
  `prod_createdip` varchar(100) NOT NULL,
  `prod_createddate` datetime NOT NULL,
  `prod_modbyid` int(11) NOT NULL,
  `prod_modbyname` varchar(150) NOT NULL,
  `prod_modip` varchar(100) NOT NULL,
  `prod_moddate` datetime NOT NULL,
  PRIMARY KEY (`prod_id`)
);

--
-- Dumping data for table `PRODUCTS`
--

LOCK TABLES `PRODUCTS` WRITE;
-- Please note that you should use the web interface to add products to each categorie
-- anyways, here are some examples:
-- INSERT INTO `PRODUCTS` (`prod_id`, `prod_name`, `cat_id`, `prod_desc`, `prod_status`, `prod_createdbyid`, `prod_createdbyname`, `prod_createdip`, `prod_createddate`, `prod_modbyid`, `prod_modbyname`, `prod_modip`, `prod_moddate`) VALUES (1,'Silpancho',1,'Delicioso plato cochabambino con carne delgada','1',1,'Carlos Anibarro','192.168.100.100','2017-10-03 15:15:15',0,'','','0000-00-00 00:00:00');
-- INSERT INTO `PRODUCTS` (`prod_id`, `prod_name`, `cat_id`, `prod_desc`, `prod_status`, `prod_createdbyid`, `prod_createdbyname`, `prod_createdip`, `prod_createddate`, `prod_modbyid`, `prod_modbyname`, `prod_modip`, `prod_moddate`) VALUES (2,'Pique Macho',1,'Delicioso plato cochabambino combinado','1',1,'Carlos Anibarro','192.168.100.100','2017-10-03 15:15:15',1,'Carlos Anibarro','192.168.100.200','2017-10-11 16:28:20');
UNLOCK TABLES;

--
-- Table structure for table `RESERVATIONS`
--

DROP TABLE IF EXISTS `RESERVATIONS`;
CREATE TABLE `RESERVATIONS` (
  `res_id` int(11) NOT NULL AUTO_INCREMENT,
  `res_date` date NOT NULL,
  `res_name` varchar(150) NOT NULL,
  `res_email` text NOT NULL,
  `prod_id` int(11) NOT NULL,
  `res_code` varchar(50) NOT NULL,
  `res_status` enum('0','1') NOT NULL DEFAULT '0',
  `res_createdip` varchar(100) NOT NULL,
  `res_createddate` datetime NOT NULL,
  `res_modip` varchar(100) NOT NULL,
  `res_moddate` datetime NOT NULL,
  PRIMARY KEY (`res_id`)
);

--
-- Dumping data for table `RESERVATIONS`
--

LOCK TABLES `RESERVATIONS` WRITE;
UNLOCK TABLES;

--
-- Table structure for table `SALEPRODUCTS`
--

DROP TABLE IF EXISTS `SALEPRODUCTS`;
CREATE TABLE `SALEPRODUCTS` (
  `sp_id` int(11) NOT NULL AUTO_INCREMENT,
  `sale_id` int(11) NOT NULL,
  `cat_id` int(11) NOT NULL,
  `prod_id` int(11) NOT NULL,
  `sp_price` double NOT NULL,
  `sp_status` enum('0','1') NOT NULL DEFAULT '0',
  `sp_createdbyid` int(11) NOT NULL,
  `sp_createdbyname` varchar(250) NOT NULL,
  `sp_createdip` varchar(100) NOT NULL,
  `sp_createddate` datetime NOT NULL,
  `sp_modbyid` int(11) NOT NULL,
  `sp_modbyname` varchar(250) NOT NULL,
  `sp_modip` varchar(100) NOT NULL,
  `sp_moddate` datetime NOT NULL,
  PRIMARY KEY (`sp_id`)
);

--
-- Dumping data for table `SALEPRODUCTS`
--

LOCK TABLES `SALEPRODUCTS` WRITE;
UNLOCK TABLES;

--
-- Table structure for table `SALES`
--

DROP TABLE IF EXISTS `SALES`;
CREATE TABLE `SALES` (
  `sale_id` int(11) NOT NULL AUTO_INCREMENT,
  `sale_name` varchar(250) NOT NULL,
  `sale_idc` varchar(250) NOT NULL,
  `sale_amount` double NOT NULL,
  `sale_status` enum('0','1') NOT NULL DEFAULT '0',
  `sale_createdbyid` int(11) NOT NULL,
  `sale_createdbyname` varchar(250) NOT NULL,
  `sale_createdip` varchar(100) NOT NULL,
  `sale_createddate` datetime NOT NULL,
  `sale_modbyid` int(11) NOT NULL,
  `sale_modbyname` varchar(250) NOT NULL,
  `sale_modip` varchar(100) NOT NULL,
  `sale_moddate` datetime NOT NULL,
  PRIMARY KEY (`sale_id`)
);

--
-- Dumping data for table `SALES`
--

LOCK TABLES `SALES` WRITE;
UNLOCK TABLES;

--
-- Table structure for table `USERLEVELS`
--

DROP TABLE IF EXISTS `USERLEVELS`;
CREATE TABLE `USERLEVELS` (
  `level_id` int(11) NOT NULL,
  `level_name` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`level_id`)
);

--
-- Dumping data for table `USERLEVELS`
--

LOCK TABLES `USERLEVELS` WRITE;
-- Allthough these are the basic user levels, you are free to add more, but please translate them if needed
-- levels should be: 1 user, 30 kitchen, 40 sales, 50, admin restorant, 80 management, 100 sys admin
INSERT INTO `USERLEVELS` (`level_id`, `level_name`) VALUES (1,'Usuario');
INSERT INTO `USERLEVELS` (`level_id`, `level_name`) VALUES (30,'Cocina');
INSERT INTO `USERLEVELS` (`level_id`, `level_name`) VALUES (40,'Sales');
INSERT INTO `USERLEVELS` (`level_id`, `level_name`) VALUES (50,'Admin Restaurant');
INSERT INTO `USERLEVELS` (`level_id`, `level_name`) VALUES (80,'Gerencia');
INSERT INTO `USERLEVELS` (`level_id`, `level_name`) VALUES (100,'Administrador del Sistema');
UNLOCK TABLES;

--
-- Table structure for table `USERS`
--

DROP TABLE IF EXISTS `USERS`;
CREATE TABLE `USERS` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `level_id` int(11) NOT NULL,
  `city_id` int(11) NOT NULL,
  `department_id` int(11) NOT NULL,
  `user_username` varchar(250) NOT NULL,
  `user_password` varchar(60) NOT NULL,
  `user_name` varchar(250) NOT NULL,
  `user_idc` varchar(30) NOT NULL,
  `user_dateofbirth` date NOT NULL DEFAULT '0000-00-00',
  `user_email` varchar(250) NOT NULL,
  `user_phonenumber` varchar(100) NOT NULL,
  `user_city` varchar(250) NOT NULL DEFAULT '',
  `user_address` text NOT NULL,
  `user_department` varchar(250) NOT NULL DEFAULT '',
  `user_latitude` varchar(15) NOT NULL,
  `user_longitude` varchar(15) NOT NULL,
  `user_createdbyid` int(11) NOT NULL,
  `user_createdbyname` varchar(150) NOT NULL,
  `user_createdip` varchar(100) NOT NULL,
  `user_createddate` datetime NOT NULL,
  `user_modbyid` int(11) NOT NULL,
  `user_modbyname` varchar(150) NOT NULL,
  `user_modip` varchar(100) NOT NULL,
  `user_moddate` datetime NOT NULL,
  `user_status` enum('0','1','2') NOT NULL DEFAULT '0',
  `user_statusbyid` int(11) NOT NULL,
  `user_statusbyname` varchar(150) NOT NULL,
  `user_statusip` varchar(250) NOT NULL,
  `user_statusdate` datetime NOT NULL,
  `user_login` enum('0','1') NOT NULL DEFAULT '0',
  `user_loginhash` varchar(250) NOT NULL,
  `user_loginsession` varchar(250) NOT NULL,
  `user_loginfrom` varchar(150) NOT NULL,
  `user_loginclient` varchar(250) NOT NULL,
  `user_logindatetime` datetime NOT NULL,
  `user_loginexpires` datetime NOT NULL,
  PRIMARY KEY (`user_id`)
);

--
-- Dumping data for table `USERS`
--

LOCK TABLES `USERS` WRITE;
INSERT INTO `USERS` (`user_id`, `level_id`, `city_id`, `department_id`, `user_username`, `user_password`, `user_name`, `user_idc`, `user_dateofbirth`, `user_email`, `user_phonenumber`, `user_city`, `user_address`, `user_department`, `user_latitude`, `user_longitude`, `user_createdbyid`, `user_createdbyname`, `user_createdip`, `user_createddate`, `user_modbyid`, `user_modbyname`, `user_modip`, `user_moddate`, `user_status`, `user_statusbyid`, `user_statusbyname`, `user_statusip`, `user_statusdate`, `user_login`, `user_loginhash`, `user_loginsession`, `user_loginfrom`, `user_loginclient`, `user_logindatetime`, `user_loginexpires`) VALUES (1,100,1,1,'admin','admin','Sys Admin','No IDC','2000-01-01','admin@lacuisine.org','1112223334','La Paz','No name street #nonumber','La Paz','-16.5005228','-68.1270541',1,'Carlos Anibarro','192.168.100.225','2013-09-24 19:20:34',1,'Carlos Anibarro','192.168.46.1','2017-10-11 08:13:38','2',1,'cae','192.168.100.100','2013-09-24 19:20:34','0','','','192.168.46.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:56.0) Gecko/20100101 Firefox/56.0','2017-10-31 10:26:58','0000-00-00 00:00:00');
UNLOCK TABLES;

--
-- Table structure for table `USERSTATUS`
--

DROP TABLE IF EXISTS `USERSTATUS`;
CREATE TABLE `USERSTATUS` (
  `us_id` int(11) NOT NULL,
  `us_name` varchar(100) NOT NULL,
  PRIMARY KEY (`us_id`)
);

--
-- Dumping data for table `USERSTATUS`
--

LOCK TABLES `USERSTATUS` WRITE;
-- Feel free to translate this to your language, 0 = created, 1 = inactive, 2 = active
INSERT INTO `USERSTATUS` (`us_id`, `us_name`) VALUES (0,'Creado');
INSERT INTO `USERSTATUS` (`us_id`, `us_name`) VALUES (1,'Inactivo');
INSERT INTO `USERSTATUS` (`us_id`, `us_name`) VALUES (2,'Activo');
UNLOCK TABLES;
