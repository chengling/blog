CREATE TABLE `ph_admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(25) NOT NULL DEFAULT '' COMMENT '后台用户名',
  `passwd` char(32) NOT NULL DEFAULT '' COMMENT '后台用户密码',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1 COMMENT='后台用户表';
insert into `ph_admin`(`id`,`username`,`passwd`) values('1','admin','21232f297a57a5a743894a0e4a801fc3'),('2','test','e10adc3949ba59abbe56e057f20f883e'),('4','test5','e10adc3949ba59abbe56e057f20f883e'),('5','chenlin','e10adc3949ba59abbe56e057f20f883e');
CREATE TABLE `ph_article` (
  `aid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(200) NOT NULL DEFAULT '' COMMENT '文章标题',
  `content` text COMMENT '文章内容',
  `time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '发表时间',
  `thumb` varchar(100) NOT NULL DEFAULT '' COMMENT '缩略图地址',
  `intro` varchar(200) NOT NULL DEFAULT '' COMMENT '文章摘要',
  `click` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '点击次数',
  `istop` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0为正常，1为置顶',
  `isdel` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0为正常，1为进入回收站',
  `cid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '所属栏目ID',
  PRIMARY KEY (`aid`),
  KEY `fk_hd_article_hd_category1_idx` (`cid`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=latin1 COMMENT='文章表';
insert into `ph_article`(`aid`,`title`,`content`,`time`,`thumb`,`intro`,`click`,`istop`,`isdel`,`cid`) values('8','test10','444','1418826754','/public/upload/images/2014/12/1418826754.jpg','','4','0','0','3'),('5','test6','9999','1418655101','/public/upload/images/2014/12/1418655101.png','','9','0','0','3'),('6','test7','66666','1418655341','/public/upload/images/2014/12/1418655341.png','','5','0','0','3'),('7','test9','4444444444444444','1418733985','/public/upload/images/2014/12/1418733985.jpg','','2','0','0','3'),('9','test67','555','1418826784','/public/upload/images/2014/12/1418826784.jpg','','4','0','0','3'),('10','test56','666','1418826806','/public/upload/images/2014/12/1418826806.jpg','','5','0','0','3'),('11','test89','555','1418826837','/public/upload/images/2014/12/1418826837.jpg','','5','0','0','3'),('12','test87','555','1418826851','/public/upload/images/2014/12/1418826851.jpg','','4','0','0','4'),('13','test675','555555555555555','1418826871','/public/upload/images/2014/12/1418826871.jpg','','5','0','0','3'),('14','test21','555555555555555555555555','1418907042','/public/upload/images/2014/12/1418907042.png','','2','0','0','3'),('15','test21','2222222222222222222','1418907059','/public/upload/images/2014/12/1418907059.png','','3','0','0','2'),('16','test24','1111111111111111','1418907160','/public/upload/images/2014/12/1418907160.png','','1','0','0','3'),('17','test26','33333333333333333333','1418907188','/public/upload/images/2014/12/1418907188.png','','5','0','0','3');
CREATE TABLE `ph_category` (
  `cid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cname` varchar(20) NOT NULL DEFAULT '' COMMENT '栏目名称',
  `keywords` varchar(255) NOT NULL DEFAULT '' COMMENT '关键字',
  `description` varchar(255) NOT NULL DEFAULT '' COMMENT '描述',
  `isoff` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0为正常，1为关闭',
  PRIMARY KEY (`cid`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1 COMMENT='栏目表';
insert into `ph_category`(`cid`,`cname`,`keywords`,`description`,`isoff`) values('4','test12','111','1','1'),('2','test1','test1','test1','1'),('3','test8888812','test2','test88888888888','0');
CREATE TABLE `ph_comment` (
  `coid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nickname` varchar(20) NOT NULL DEFAULT '' COMMENT '用户昵称',
  `time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '评论时间',
  `content` varchar(255) NOT NULL DEFAULT '' COMMENT '评论内容',
  `aid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '所属文章ID',
  PRIMARY KEY (`coid`),
  KEY `fk_hd_comment_hd_article_idx` (`aid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='评论表';
CREATE TABLE `ph_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '权限id',
  `url` varchar(100) DEFAULT NULL,
  `title` varchar(25) NOT NULL DEFAULT '' COMMENT '菜单名字',
  `parent_id` int(11) NOT NULL DEFAULT '0' COMMENT '菜单上级id',
  `level` int(11) DEFAULT '0' COMMENT '菜单层级',
  `sort` tinyint(4) NOT NULL DEFAULT '1',
  `is_main` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=40 DEFAULT CHARSET=utf8;
insert into `ph_menu`(`id`,`url`,`title`,`parent_id`,`level`,`sort`,`is_main`) values('1','','后台首页','0','0','11','1'),('2','','系统管理','0','0','10','1'),('4','admin/index/copy','后台首页','1','1','1','1'),('5','','栏目管理','0','0','9','1'),('13','admin/category/add','添加栏目','5','1','1','1'),('12','admin/category/index','栏目列表','5','1','1','1'),('14','','文章管理','0','0','1','1'),('15','admin/article/index','文章列表','14','1','1','1'),('16','admin/article/del','删除文章','14','1','1','0'),('17','admin/article/edit','修改文章','14','1','1','0'),('18','admin/menu/add','添加菜单','2','1','1','1'),('19','admin/menu/index','菜单列表','2','1','1','1'),('22','admin/article/index/1','回收站','14','1','1','1'),('23','admin/role/add','添加角色','2','1','1','1'),('24','admin/role/index','角色列表','2','1','1','1'),('25','admin/admin/add','添加管理员','2','1','1','1'),('26','admin/admin/index','管理员列表','2','1','1','1'),('27','admin/menu/edit','修改菜单','2','1','1','0'),('28','admin/menu/del','删除菜单','2','1','1','0'),('29','admin/role/edit','修改角色','2','1','1','0'),('30','admin/role/del','删除角色','2','1','1','0'),('31','admin/admin/edit','修改管理员','2','1','1','0'),('32','admin/admin/del','删除管理员','2','1','1','0'),('33','','评论管理','0','0','1','1'),('34','admin/comment/index','查看评论','33','1','1','1'),('35','admin/article/add','添加文章','14','1','1','1'),('37','admin/index/index','后台首页','1','1','10','0'),('38','','数据库管理','0','0','1','1'),('39','admin/data/index','数据库备份','38','1','1','1');
CREATE TABLE `ph_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '角色id',
  `name` varchar(15) NOT NULL DEFAULT '' COMMENT '角色名字',
  `des` varchar(50) DEFAULT NULL COMMENT '角色描述',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
insert into `ph_role`(`id`,`name`,`des`) values('1','editoer','editoer'),('2','administrator','administrator'),('3','editor','editor');
CREATE TABLE `ph_role_admin` (
  `role_id` smallint(6) unsigned NOT NULL,
  `admin_id` smallint(6) unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`admin_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
insert into `ph_role_admin`(`role_id`,`admin_id`) values('1','5'),('2','2'),('3','4');
CREATE TABLE `ph_role_menu` (
  `role_id` smallint(6) unsigned NOT NULL,
  `menu_id` smallint(6) unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`menu_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
insert into `ph_role_menu`(`role_id`,`menu_id`) values('1','1'),('1','4'),('1','14'),('1','15'),('1','16'),('1','17'),('1','22'),('1','35'),('1','37'),('2','1'),('2','2'),('2','4'),('2','18'),('2','19'),('2','23'),('2','24'),('2','25'),('2','26'),('2','27'),('2','28'),('2','29'),('2','30'),('2','31'),('2','32'),('2','37'),('3','1'),('3','4'),('3','14'),('3','15'),('3','16'),('3','17'),('3','22'),('3','35'),('3','37');

