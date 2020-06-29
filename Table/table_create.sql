create TABLE user (
    num INT(11) not null AUTO_INCREMENT PRIMARY KEY,
    id varchar(100) not null,
    pass varchar(100) not null,
    name char(20),
    gender char(10),
    phone char(20),
    email char(80)
);
create table board (
    idx int(11) not null AUTO_INCREMENT PRIMARY KEY,
    name varchar(100) not null,
    pw varchar(100) not null,
    title varchar(100) not null,
    content text not null,
    date date not null,
    hit int(11) not null,
    lock_post int(11) not null
);

create table reply (
    idx int(11) not null AUTO_INCREMENT PRIMARY KEY,
    con_num int(11) not null,
    name varchar(100) not null,
    pw varchar(100) not null,
    title varchar(100) not null,
    content text not null,
    date datetime not null default '1900-01-01 00:00:00'
);