create table test(
     Id int primary key auto_increment,
     Name varchar(18),
     description varchar(100)
 );

create table video(
     Id int(10) primary key auto_increment,
     Name varchar(100) default '',
     cat_id smallint(4) unsigned default 0,
     image varchar(200) default '',
     url varchar(200) default '',
     type tinyint(1) unsigned default 0,
     content text,
     uploader varchar(200) default '',
     create_time int(10) unsigned default 0,
     update_time int(10) unsigned default 0,
     status tinyint(1) unsigned
 );