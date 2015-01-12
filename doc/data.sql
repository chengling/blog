CREATE TABLE `ph_admin` (
  `adid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(25) NOT NULL DEFAULT '' COMMENT '后台用户名',
  `passwd` char(32) NOT NULL DEFAULT '' COMMENT '后台用户密码',
  `role_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`adid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='后台用户表' ; 

CREATE TABLE `ph_category` (
  `cid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cname` varchar(20) NOT NULL DEFAULT '' COMMENT '栏目名称',
  `keywords` varchar(255) NOT NULL DEFAULT '' COMMENT '关键字',
  `description` varchar(255) NOT NULL DEFAULT '' COMMENT '描述',
  `isoff` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0为正常，1为关闭',
  PRIMARY KEY (`cid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='栏目表'            
create table ph_role (
	id int primary key auto_increment comment '角色id',
	name varchar(15) not null default '' comment '角色名字',
	des varchar(50) comment '角色描述'
)engine=myisam default charset=utf8;

CREATE TABLE IF NOT EXISTS `ph_role_menu` (
  `role_id` smallint(6) unsigned NOT NULL,
  `menu_id` smallint(6) unsigned NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

create table ph_menu(
	id int primary key auto_increment comment '权限id',	
	url varchar(100) comment '权限对应的url',
	title varchar(25) not null default '' comment '菜单名字',
	parent_id int not null default 0 comment '菜单上级id',
	level int null default 0 comment '菜单层级'
)engine=myisam default charset=utf8;


CREATE TABLE IF NOT EXISTS `ph_role_admin` (
  `role_id` smallint(6) unsigned NOT NULL,
  `admin_id` smallint(6) unsigned NOT NULL,
  primary key (role_id,admin_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;