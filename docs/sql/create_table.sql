
create table if not exists `news` (
    `id` int not null auto_increment comment '新闻ID',
    `title` varchar(100) not null comment '新闻标题',
    `content` text not null comment '新闻内容',
    `created_at` datetime not null comment '创建时间',
    `updated_at` datetime not null comment '更新时间',
    primary key (`id`)
) engine=InnoDb character set=utf8 comment '新闻表';

insert into `news` (`title`, `content`, `created_at`, `updated_at`) values
('新闻标题1', '新闻内容1', now(), now()),
('新闻标题2', '新闻内容2', now(), now()),
('新闻标题3', '新闻内容3', now(), now()),
('新闻标题4', '新闻内容4', now(), now()),
('新闻标题5', '新闻内容5', now(), now()),
('新闻标题6', '新闻内容6', now(), now()),
('新闻标题7', '新闻内容7', now(), now());
