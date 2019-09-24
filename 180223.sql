/*
SQLyog Ultimate v12.5.0 (64 bit)
MySQL - 5.7.18-log : Database - yii2basicadmin
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`yii2basicadmin` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci */;

USE `yii2basicadmin`;

/*Table structure for table `auth_assignment` */

DROP TABLE IF EXISTS `auth_assignment`;

CREATE TABLE `auth_assignment` (
  `item_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`item_name`,`user_id`),
  KEY `auth_assignment_user_id_idx` (`user_id`),
  CONSTRAINT `auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `auth_assignment` */

insert  into `auth_assignment`(`item_name`,`user_id`,`created_at`) values ('role1','1',1519364439);
insert  into `auth_assignment`(`item_name`,`user_id`,`created_at`) values ('role1','2',1519364455);

/*Table structure for table `auth_item` */

DROP TABLE IF EXISTS `auth_item`;

CREATE TABLE `auth_item` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `type` smallint(6) NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `rule_name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `data` blob,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`),
  KEY `rule_name` (`rule_name`),
  KEY `idx-auth_item-type` (`type`),
  CONSTRAINT `auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `auth_item` */

insert  into `auth_item`(`name`,`type`,`description`,`rule_name`,`data`,`created_at`,`updated_at`) values ('/admin/*',2,NULL,NULL,NULL,1519364260,1519364260);
insert  into `auth_item`(`name`,`type`,`description`,`rule_name`,`data`,`created_at`,`updated_at`) values ('/admin/assignment/*',2,NULL,NULL,NULL,1519363908,1519363908);
insert  into `auth_item`(`name`,`type`,`description`,`rule_name`,`data`,`created_at`,`updated_at`) values ('/admin/assignment/assign',2,NULL,NULL,NULL,1519364254,1519364254);
insert  into `auth_item`(`name`,`type`,`description`,`rule_name`,`data`,`created_at`,`updated_at`) values ('/admin/assignment/index',2,NULL,NULL,NULL,1519364254,1519364254);
insert  into `auth_item`(`name`,`type`,`description`,`rule_name`,`data`,`created_at`,`updated_at`) values ('/admin/assignment/revoke',2,NULL,NULL,NULL,1519364254,1519364254);
insert  into `auth_item`(`name`,`type`,`description`,`rule_name`,`data`,`created_at`,`updated_at`) values ('/admin/assignment/view',2,NULL,NULL,NULL,1519364254,1519364254);
insert  into `auth_item`(`name`,`type`,`description`,`rule_name`,`data`,`created_at`,`updated_at`) values ('/admin/default/*',2,NULL,NULL,NULL,1519363908,1519363908);
insert  into `auth_item`(`name`,`type`,`description`,`rule_name`,`data`,`created_at`,`updated_at`) values ('/admin/default/index',2,NULL,NULL,NULL,1519364254,1519364254);
insert  into `auth_item`(`name`,`type`,`description`,`rule_name`,`data`,`created_at`,`updated_at`) values ('/admin/menu/*',2,NULL,NULL,NULL,1519363908,1519363908);
insert  into `auth_item`(`name`,`type`,`description`,`rule_name`,`data`,`created_at`,`updated_at`) values ('/admin/menu/create',2,NULL,NULL,NULL,1519364254,1519364254);
insert  into `auth_item`(`name`,`type`,`description`,`rule_name`,`data`,`created_at`,`updated_at`) values ('/admin/menu/delete',2,NULL,NULL,NULL,1519364254,1519364254);
insert  into `auth_item`(`name`,`type`,`description`,`rule_name`,`data`,`created_at`,`updated_at`) values ('/admin/menu/index',2,NULL,NULL,NULL,1519364254,1519364254);
insert  into `auth_item`(`name`,`type`,`description`,`rule_name`,`data`,`created_at`,`updated_at`) values ('/admin/menu/update',2,NULL,NULL,NULL,1519364254,1519364254);
insert  into `auth_item`(`name`,`type`,`description`,`rule_name`,`data`,`created_at`,`updated_at`) values ('/admin/menu/view',2,NULL,NULL,NULL,1519364254,1519364254);
insert  into `auth_item`(`name`,`type`,`description`,`rule_name`,`data`,`created_at`,`updated_at`) values ('/admin/permission/*',2,NULL,NULL,NULL,1519364254,1519364254);
insert  into `auth_item`(`name`,`type`,`description`,`rule_name`,`data`,`created_at`,`updated_at`) values ('/admin/permission/assign',2,NULL,NULL,NULL,1519364254,1519364254);
insert  into `auth_item`(`name`,`type`,`description`,`rule_name`,`data`,`created_at`,`updated_at`) values ('/admin/permission/create',2,NULL,NULL,NULL,1519364254,1519364254);
insert  into `auth_item`(`name`,`type`,`description`,`rule_name`,`data`,`created_at`,`updated_at`) values ('/admin/permission/delete',2,NULL,NULL,NULL,1519364254,1519364254);
insert  into `auth_item`(`name`,`type`,`description`,`rule_name`,`data`,`created_at`,`updated_at`) values ('/admin/permission/index',2,NULL,NULL,NULL,1519364254,1519364254);
insert  into `auth_item`(`name`,`type`,`description`,`rule_name`,`data`,`created_at`,`updated_at`) values ('/admin/permission/remove',2,NULL,NULL,NULL,1519364254,1519364254);
insert  into `auth_item`(`name`,`type`,`description`,`rule_name`,`data`,`created_at`,`updated_at`) values ('/admin/permission/update',2,NULL,NULL,NULL,1519364254,1519364254);
insert  into `auth_item`(`name`,`type`,`description`,`rule_name`,`data`,`created_at`,`updated_at`) values ('/admin/permission/view',2,NULL,NULL,NULL,1519364254,1519364254);
insert  into `auth_item`(`name`,`type`,`description`,`rule_name`,`data`,`created_at`,`updated_at`) values ('/admin/role/*',2,NULL,NULL,NULL,1519363908,1519363908);
insert  into `auth_item`(`name`,`type`,`description`,`rule_name`,`data`,`created_at`,`updated_at`) values ('/admin/role/assign',2,NULL,NULL,NULL,1519364254,1519364254);
insert  into `auth_item`(`name`,`type`,`description`,`rule_name`,`data`,`created_at`,`updated_at`) values ('/admin/role/create',2,NULL,NULL,NULL,1519364254,1519364254);
insert  into `auth_item`(`name`,`type`,`description`,`rule_name`,`data`,`created_at`,`updated_at`) values ('/admin/role/delete',2,NULL,NULL,NULL,1519364254,1519364254);
insert  into `auth_item`(`name`,`type`,`description`,`rule_name`,`data`,`created_at`,`updated_at`) values ('/admin/role/index',2,NULL,NULL,NULL,1519364254,1519364254);
insert  into `auth_item`(`name`,`type`,`description`,`rule_name`,`data`,`created_at`,`updated_at`) values ('/admin/role/remove',2,NULL,NULL,NULL,1519364254,1519364254);
insert  into `auth_item`(`name`,`type`,`description`,`rule_name`,`data`,`created_at`,`updated_at`) values ('/admin/role/update',2,NULL,NULL,NULL,1519364254,1519364254);
insert  into `auth_item`(`name`,`type`,`description`,`rule_name`,`data`,`created_at`,`updated_at`) values ('/admin/role/view',2,NULL,NULL,NULL,1519364254,1519364254);
insert  into `auth_item`(`name`,`type`,`description`,`rule_name`,`data`,`created_at`,`updated_at`) values ('/admin/route/*',2,NULL,NULL,NULL,1519363908,1519363908);
insert  into `auth_item`(`name`,`type`,`description`,`rule_name`,`data`,`created_at`,`updated_at`) values ('/admin/route/assign',2,NULL,NULL,NULL,1519364254,1519364254);
insert  into `auth_item`(`name`,`type`,`description`,`rule_name`,`data`,`created_at`,`updated_at`) values ('/admin/route/create',2,NULL,NULL,NULL,1519364254,1519364254);
insert  into `auth_item`(`name`,`type`,`description`,`rule_name`,`data`,`created_at`,`updated_at`) values ('/admin/route/index',2,NULL,NULL,NULL,1519364254,1519364254);
insert  into `auth_item`(`name`,`type`,`description`,`rule_name`,`data`,`created_at`,`updated_at`) values ('/admin/route/refresh',2,NULL,NULL,NULL,1519364254,1519364254);
insert  into `auth_item`(`name`,`type`,`description`,`rule_name`,`data`,`created_at`,`updated_at`) values ('/admin/route/remove',2,NULL,NULL,NULL,1519364254,1519364254);
insert  into `auth_item`(`name`,`type`,`description`,`rule_name`,`data`,`created_at`,`updated_at`) values ('/admin/rule/*',2,NULL,NULL,NULL,1519363908,1519363908);
insert  into `auth_item`(`name`,`type`,`description`,`rule_name`,`data`,`created_at`,`updated_at`) values ('/admin/rule/create',2,NULL,NULL,NULL,1519364254,1519364254);
insert  into `auth_item`(`name`,`type`,`description`,`rule_name`,`data`,`created_at`,`updated_at`) values ('/admin/rule/delete',2,NULL,NULL,NULL,1519364254,1519364254);
insert  into `auth_item`(`name`,`type`,`description`,`rule_name`,`data`,`created_at`,`updated_at`) values ('/admin/rule/index',2,NULL,NULL,NULL,1519364254,1519364254);
insert  into `auth_item`(`name`,`type`,`description`,`rule_name`,`data`,`created_at`,`updated_at`) values ('/admin/rule/update',2,NULL,NULL,NULL,1519364254,1519364254);
insert  into `auth_item`(`name`,`type`,`description`,`rule_name`,`data`,`created_at`,`updated_at`) values ('/admin/rule/view',2,NULL,NULL,NULL,1519364254,1519364254);
insert  into `auth_item`(`name`,`type`,`description`,`rule_name`,`data`,`created_at`,`updated_at`) values ('/admin/user/*',2,NULL,NULL,NULL,1519363908,1519363908);
insert  into `auth_item`(`name`,`type`,`description`,`rule_name`,`data`,`created_at`,`updated_at`) values ('/admin/user/activate',2,NULL,NULL,NULL,1519364254,1519364254);
insert  into `auth_item`(`name`,`type`,`description`,`rule_name`,`data`,`created_at`,`updated_at`) values ('/admin/user/change-password',2,NULL,NULL,NULL,1519364254,1519364254);
insert  into `auth_item`(`name`,`type`,`description`,`rule_name`,`data`,`created_at`,`updated_at`) values ('/admin/user/delete',2,NULL,NULL,NULL,1519364254,1519364254);
insert  into `auth_item`(`name`,`type`,`description`,`rule_name`,`data`,`created_at`,`updated_at`) values ('/admin/user/index',2,NULL,NULL,NULL,1519364254,1519364254);
insert  into `auth_item`(`name`,`type`,`description`,`rule_name`,`data`,`created_at`,`updated_at`) values ('/admin/user/login',2,NULL,NULL,NULL,1519364254,1519364254);
insert  into `auth_item`(`name`,`type`,`description`,`rule_name`,`data`,`created_at`,`updated_at`) values ('/admin/user/logout',2,NULL,NULL,NULL,1519364254,1519364254);
insert  into `auth_item`(`name`,`type`,`description`,`rule_name`,`data`,`created_at`,`updated_at`) values ('/admin/user/request-password-reset',2,NULL,NULL,NULL,1519364254,1519364254);
insert  into `auth_item`(`name`,`type`,`description`,`rule_name`,`data`,`created_at`,`updated_at`) values ('/admin/user/reset-password',2,NULL,NULL,NULL,1519364254,1519364254);
insert  into `auth_item`(`name`,`type`,`description`,`rule_name`,`data`,`created_at`,`updated_at`) values ('/admin/user/signup',2,NULL,NULL,NULL,1519364254,1519364254);
insert  into `auth_item`(`name`,`type`,`description`,`rule_name`,`data`,`created_at`,`updated_at`) values ('/admin/user/view',2,NULL,NULL,NULL,1519364254,1519364254);
insert  into `auth_item`(`name`,`type`,`description`,`rule_name`,`data`,`created_at`,`updated_at`) values ('Permission1',2,NULL,NULL,NULL,1519363858,1519363858);
insert  into `auth_item`(`name`,`type`,`description`,`rule_name`,`data`,`created_at`,`updated_at`) values ('role1',1,NULL,NULL,NULL,1519363298,1519363298);

/*Table structure for table `auth_item_child` */

DROP TABLE IF EXISTS `auth_item_child`;

CREATE TABLE `auth_item_child` (
  `parent` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `child` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`),
  CONSTRAINT `auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `auth_item_child` */

insert  into `auth_item_child`(`parent`,`child`) values ('Permission1','/admin/*');
insert  into `auth_item_child`(`parent`,`child`) values ('Permission1','/admin/assignment/*');
insert  into `auth_item_child`(`parent`,`child`) values ('Permission1','/admin/assignment/assign');
insert  into `auth_item_child`(`parent`,`child`) values ('Permission1','/admin/assignment/index');
insert  into `auth_item_child`(`parent`,`child`) values ('Permission1','/admin/assignment/revoke');
insert  into `auth_item_child`(`parent`,`child`) values ('Permission1','/admin/assignment/view');
insert  into `auth_item_child`(`parent`,`child`) values ('Permission1','/admin/default/*');
insert  into `auth_item_child`(`parent`,`child`) values ('Permission1','/admin/default/index');
insert  into `auth_item_child`(`parent`,`child`) values ('Permission1','/admin/menu/*');
insert  into `auth_item_child`(`parent`,`child`) values ('Permission1','/admin/menu/create');
insert  into `auth_item_child`(`parent`,`child`) values ('Permission1','/admin/menu/delete');
insert  into `auth_item_child`(`parent`,`child`) values ('Permission1','/admin/menu/index');
insert  into `auth_item_child`(`parent`,`child`) values ('Permission1','/admin/menu/update');
insert  into `auth_item_child`(`parent`,`child`) values ('Permission1','/admin/menu/view');
insert  into `auth_item_child`(`parent`,`child`) values ('Permission1','/admin/permission/*');
insert  into `auth_item_child`(`parent`,`child`) values ('Permission1','/admin/permission/assign');
insert  into `auth_item_child`(`parent`,`child`) values ('Permission1','/admin/permission/create');
insert  into `auth_item_child`(`parent`,`child`) values ('Permission1','/admin/permission/delete');
insert  into `auth_item_child`(`parent`,`child`) values ('Permission1','/admin/permission/index');
insert  into `auth_item_child`(`parent`,`child`) values ('Permission1','/admin/permission/remove');
insert  into `auth_item_child`(`parent`,`child`) values ('Permission1','/admin/permission/update');
insert  into `auth_item_child`(`parent`,`child`) values ('Permission1','/admin/permission/view');
insert  into `auth_item_child`(`parent`,`child`) values ('Permission1','/admin/role/*');
insert  into `auth_item_child`(`parent`,`child`) values ('Permission1','/admin/role/assign');
insert  into `auth_item_child`(`parent`,`child`) values ('Permission1','/admin/role/create');
insert  into `auth_item_child`(`parent`,`child`) values ('Permission1','/admin/role/delete');
insert  into `auth_item_child`(`parent`,`child`) values ('Permission1','/admin/role/index');
insert  into `auth_item_child`(`parent`,`child`) values ('Permission1','/admin/role/remove');
insert  into `auth_item_child`(`parent`,`child`) values ('Permission1','/admin/role/update');
insert  into `auth_item_child`(`parent`,`child`) values ('Permission1','/admin/role/view');
insert  into `auth_item_child`(`parent`,`child`) values ('Permission1','/admin/route/*');
insert  into `auth_item_child`(`parent`,`child`) values ('Permission1','/admin/route/assign');
insert  into `auth_item_child`(`parent`,`child`) values ('Permission1','/admin/route/create');
insert  into `auth_item_child`(`parent`,`child`) values ('Permission1','/admin/route/index');
insert  into `auth_item_child`(`parent`,`child`) values ('Permission1','/admin/route/refresh');
insert  into `auth_item_child`(`parent`,`child`) values ('Permission1','/admin/route/remove');
insert  into `auth_item_child`(`parent`,`child`) values ('Permission1','/admin/rule/*');
insert  into `auth_item_child`(`parent`,`child`) values ('Permission1','/admin/rule/create');
insert  into `auth_item_child`(`parent`,`child`) values ('Permission1','/admin/rule/delete');
insert  into `auth_item_child`(`parent`,`child`) values ('Permission1','/admin/rule/index');
insert  into `auth_item_child`(`parent`,`child`) values ('Permission1','/admin/rule/update');
insert  into `auth_item_child`(`parent`,`child`) values ('Permission1','/admin/rule/view');
insert  into `auth_item_child`(`parent`,`child`) values ('Permission1','/admin/user/*');
insert  into `auth_item_child`(`parent`,`child`) values ('Permission1','/admin/user/activate');
insert  into `auth_item_child`(`parent`,`child`) values ('Permission1','/admin/user/change-password');
insert  into `auth_item_child`(`parent`,`child`) values ('Permission1','/admin/user/delete');
insert  into `auth_item_child`(`parent`,`child`) values ('Permission1','/admin/user/index');
insert  into `auth_item_child`(`parent`,`child`) values ('Permission1','/admin/user/login');
insert  into `auth_item_child`(`parent`,`child`) values ('Permission1','/admin/user/logout');
insert  into `auth_item_child`(`parent`,`child`) values ('Permission1','/admin/user/request-password-reset');
insert  into `auth_item_child`(`parent`,`child`) values ('Permission1','/admin/user/reset-password');
insert  into `auth_item_child`(`parent`,`child`) values ('Permission1','/admin/user/signup');
insert  into `auth_item_child`(`parent`,`child`) values ('Permission1','/admin/user/view');
insert  into `auth_item_child`(`parent`,`child`) values ('role1','Permission1');

/*Table structure for table `auth_rule` */

DROP TABLE IF EXISTS `auth_rule`;

CREATE TABLE `auth_rule` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `data` blob,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `auth_rule` */

/*Table structure for table `menu` */

DROP TABLE IF EXISTS `menu`;

CREATE TABLE `menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  `parent` int(11) DEFAULT NULL,
  `route` varchar(255) DEFAULT NULL,
  `order` int(11) DEFAULT NULL,
  `data` blob,
  PRIMARY KEY (`id`),
  KEY `parent` (`parent`),
  CONSTRAINT `menu_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `menu` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

/*Data for the table `menu` */

insert  into `menu`(`id`,`name`,`parent`,`route`,`order`,`data`) values (1,'系统管理',NULL,'/admin/default/index',NULL,NULL);
insert  into `menu`(`id`,`name`,`parent`,`route`,`order`,`data`) values (2,'分配权限',1,'/admin/assignment/index',NULL,NULL);
insert  into `menu`(`id`,`name`,`parent`,`route`,`order`,`data`) values (3,'菜单列表',1,'/admin/menu/index',NULL,NULL);
insert  into `menu`(`id`,`name`,`parent`,`route`,`order`,`data`) values (4,'用户列表',1,'/admin/user/index',NULL,NULL);
insert  into `menu`(`id`,`name`,`parent`,`route`,`order`,`data`) values (5,'角色列表',1,'/admin/role/index',NULL,NULL);
insert  into `menu`(`id`,`name`,`parent`,`route`,`order`,`data`) values (6,'权限列表',1,'/admin/permission/index',NULL,NULL);
insert  into `menu`(`id`,`name`,`parent`,`route`,`order`,`data`) values (7,'路由列表',1,'/admin/route/index',NULL,NULL);
insert  into `menu`(`id`,`name`,`parent`,`route`,`order`,`data`) values (8,'规则列表',1,'/admin/rule/index',NULL,NULL);

/*Table structure for table `migration` */

DROP TABLE IF EXISTS `migration`;

CREATE TABLE `migration` (
  `version` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `migration` */

insert  into `migration`(`version`,`apply_time`) values ('m000000_000000_base',1519357116);
insert  into `migration`(`version`,`apply_time`) values ('m140506_102106_rbac_init',1519357365);
insert  into `migration`(`version`,`apply_time`) values ('m140602_111327_create_menu_table',1519357123);
insert  into `migration`(`version`,`apply_time`) values ('m160312_050000_create_user',1519357123);
insert  into `migration`(`version`,`apply_time`) values ('m170907_052038_rbac_add_index_on_auth_assignment_user_id',1519357365);

/*Table structure for table `user` */

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT '10',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user` */

insert  into `user`(`id`,`username`,`auth_key`,`password_hash`,`password_reset_token`,`email`,`status`,`created_at`,`updated_at`) values (1,'admin1','Ij208jUVshN5NPTkkzSrA0qrAOOch1a8','$2y$13$TrxoY2RZe9zrN8/PryFPmOzd6Fg07yxZTicSwtbv45vZ4Pv.JsnCW',NULL,'admin1@test.com',10,1519362783,1519362783);
insert  into `user`(`id`,`username`,`auth_key`,`password_hash`,`password_reset_token`,`email`,`status`,`created_at`,`updated_at`) values (2,'admin','NeFCg8aD2hn7u_mHd5FV8g8dQBxyXiD6','$2y$13$zzYMQpwlG2rFjcCR2Q.yqeCH4DM9vyfhRKJxyUWB4AdAOszy6NCcS',NULL,'admin@t.cn',10,1519363368,1519363368);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
