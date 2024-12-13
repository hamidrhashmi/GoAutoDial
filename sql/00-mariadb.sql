CREATE DATABASE asterisk;
CREATE DATABASE goautodial;
CREATE DATABASE kamailio;
CREATE DATABASE osticketdb;

GRANT SELECT,INSERT,UPDATE,DELETE,ALTER,CREATE,LOCK TABLES ON asterisk.* TO 'asterisku'@'%' IDENTIFIED BY 'asterisku1234';
GRANT SELECT,INSERT,UPDATE,DELETE,ALTER,CREATE,LOCK TABLES ON asterisk.* TO 'asterisku'@'localhost' IDENTIFIED BY 'asterisku1234';

GRANT SELECT,INSERT,UPDATE,DELETE ON asterisk.* TO 'goautodialu'@'%' IDENTIFIED BY 'goautodialu1234';
GRANT SELECT,INSERT,UPDATE,DELETE ON asterisk.* TO 'goautodialu'@'localhost' IDENTIFIED BY 'goautodialu1234';

GRANT SELECT,INSERT,UPDATE,DELETE ON goautodial.* TO 'goautodialu'@'%' IDENTIFIED BY 'goautodialu1234';
GRANT SELECT,INSERT,UPDATE,DELETE ON goautodial.* TO 'goautodialu'@'localhost' IDENTIFIED BY 'goautodialu1234';

GRANT SELECT,INSERT,UPDATE,DELETE ON osticketdb.* TO 'osticketu'@'%' IDENTIFIED BY 'osticketu1234';
GRANT SELECT,INSERT,UPDATE,DELETE ON osticketdb.* TO 'osticketu'@'localhost' IDENTIFIED BY 'osticketu1234';

GRANT SELECT,INSERT,UPDATE,DELETE ON kamailio.* TO 'kamailiou'@'%' IDENTIFIED BY 'kamailiou1234';
GRANT SELECT,INSERT,UPDATE,DELETE ON kamailio.* TO 'kamailiou'@'localhost' IDENTIFIED BY 'kamailiou1234';

GRANT SELECT ON kamailio.* TO 'kamailioro'@'localhost' IDENTIFIED BY 'kamailioro';

GRANT RELOAD ON *.* TO asterisku@'%';
GRANT RELOAD ON *.* TO asterisku@localhost;

flush privileges;
