CREATE TABLE `hdrs_advert` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '标题',
  `url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '图片',
  `link_url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '外链',
  `sort` int(2) NOT NULL DEFAULT '0' COMMENT '排序',
  `status` tinyint(2) NOT NULL DEFAULT '0' COMMENT '状态 0 启用;1 禁用',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='广告表';
CREATE TABLE `hdrs_complaints` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '用户id',
  `title` varchar(255) NOT NULL DEFAULT '' COMMENT '标题',
  `content` text NOT NULL COMMENT '内容',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='投诉表';
CREATE TABLE `hdrs_area` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `hdrs_area` varchar(255) NOT NULL DEFAULT '' COMMENT '区域',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='区域表';
CREATE TABLE `hdrs_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `title` varchar(255) NOT NULL DEFAULT '' COMMENT '名称',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='会员分组';
CREATE TABLE `hdrs_integral_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '用户id',
  `goods` varchar(200) NOT NULL DEFAULT '' COMMENT '商品名称',
  `integral_num` varchar(200) NOT NULL DEFAULT '' COMMENT '积分变动',
  `title` text NOT NULL COMMENT '变动纪录',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='积分纪录表';
CREATE TABLE `hdrs_video` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `title` varchar(255) NOT NULL DEFAULT '' COMMENT '名称',
  `picture` varchar(255) NOT NULL DEFAULT '' COMMENT '缩略图',
  `path` varchar(255) NOT NULL DEFAULT '' COMMENT '视屏地址',
  `get_integral` int(11) NOT NULL DEFAULT '0' COMMENT '获得积分',
  `length_time` varchar(255) NOT NULL DEFAULT '' COMMENT '规定时间',
  `number` int(11) NOT NULL DEFAULT '0' COMMENT '视屏浏览量',
  `group_id` int(11) NOT NULL DEFAULT '0' COMMENT '视屏分组id',
  `type` tinyint(2) NOT NULL DEFAULT '0' COMMENT '状态 0 会员视频;1 免费视屏',
  `is_delete` tinyint(2) NOT NULL DEFAULT '0' COMMENT '状态 0 启用;1 禁用',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='视屏表';
CREATE TABLE `hdrs_share` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `send_id` int(11) NOT NULL DEFAULT '0' COMMENT '分享用户id',
  `receive_id` int(11) NOT NULL DEFAULT '0' COMMENT '查看用户id',
  `video_id` int(11) NOT NULL DEFAULT '0' COMMENT '视屏id',
  `type` tinyint(2) NOT NULL DEFAULT '0' COMMENT '状态 0 会员视频;1 免费视屏',
  `integral` int(11) NOT NULL DEFAULT '0' COMMENT '积分变动',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_send_id` (`send_id`),
  KEY `idx_receive_id` (`receive_id`),
  KEY `idx_video_id` (`video_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='分享记录表';


alter table admin_users  add  storename  varchar(255) NOT NULL DEFAULT ''
alter table admin_users  add  mobile  varchar(20) NOT NULL DEFAULT ''
alter table admin_users  add  address  varchar(255) NOT NULL DEFAULT ''
alter table admin_users  add  storenumber  int(11) NOT NULL DEFAULT '0' 
alter table users  add  avatar  varchar(255) NOT NULL DEFAULT ''
alter table users  add  openid  varchar(50) NOT NULL DEFAULT ''
alter table users  add  mobile  varchar(20) NOT NULL DEFAULT ''
alter table users  add  adminuser_id  int(11) NOT NULL DEFAULT '0'
alter table users  add  area_id  int(11) NOT NULL DEFAULT '0'
alter table users  add  group_id  int(11) NOT NULL DEFAULT '0'
alter table users  add  integral  int(11) NOT NULL DEFAULT '0'
alter table users  add  is_members  tinyint(2) NOT NULL DEFAULT '0'
alter table users  add  is_delete  tinyint(2) NOT NULL DEFAULT '0'