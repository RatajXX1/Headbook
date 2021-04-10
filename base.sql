create table HD_friends
(
    User_id   int null,
    Friend_id int null
);

create table HD_post
(
    id_post         int auto_increment
        primary key,
    user_id         varchar(250)                       null,
    likes           int      default 0                 null,
    message         text                               null,
    wheres_location varchar(500)                       null,
    photos_urls     text                               null,
    time_data       datetime default CURRENT_TIMESTAMP null
);

create table HD_session
(
    ids       varchar(250)                       null,
    adress_IP varchar(250)                       null,
    ueser_id  int                                null,
    device    varchar(500)                       null,
    time_data datetime default CURRENT_TIMESTAMP null
);

create table HD_users
(
    ids       int auto_increment
        primary key,
    hd_name   varchar(100) null,
    hd_surr   varchar(100) null,
    hd_phone  varchar(100) null,
    hd_mail   varchar(250) null,
    hd_pass   varchar(250) null,
    hd_birth  varchar(100) null,
    hd_gender varchar(100) null
);