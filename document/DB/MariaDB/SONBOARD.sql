create user SONBOARD;
create database SONBOARD;
grant all on SONBOARD.* to 'SONBOARD'@'localhost' identified by 'thsvlftkdWkd';
grant all on SONBOARD.* to 'SONBOARD'@'%' identified by 'thsvlftkdWkd';
flush privileges;

