DROP DATABASE IF EXISTS AutoDirect; 
CREATE DATABASE AutoDirect;
USE AutoDirect;


CREATE TABLE `USERS`(
  `username`  varchar(20)  NOT NULL,
  `password`   varchar(60)  NOT NULL,
  `type_usr`  varchar(20)  NOT NULL,
  PRIMARY KEY(username)
);


CREATE TABLE `CLIENT`(
  `usrname`     varchar(20)   NOT NULL,
  `First_name`  varchar(20)   NOT NULL,
  `Last_name`   varchar(20)   NOT NULL,
  `address`     varchar(155)  NOT NULL,
  FOREIGN KEY(usrname)REFERENCES USERS(username)
);


CREATE TABLE `EMPLOYEE`(
  `usrname`   varchar(20)   NOT NULL,
  `postion`  varchar(20)   NOT NULL,
  FOREIGN KEY(usrname)REFERENCES USERS(username)
);


CREATE TABLE `CAR`(
  `car_id` varchar(20) NOT NULL,
  `year`   int(11) NOT NULL,
  `make`   varchar(20) NOT NULL,
  `model`  varchar(40) NOT NULL,
  `engine` varchar(20) NOT NULL,
  PRIMARY KEY(car_id)
);


CREATE TABLE `PART`(
  `part_number` varchar(20) NOT NULL,
  `brand` varchar(100) NOT NULL,
  `name` varchar(20) NOT NULL,
  `price` decimal(6,2) NOT NULL,
  `num_stock` int(11) NOT NULL,
  PRIMARY KEY(part_number)
);


CREATE TABLE `HAS_PARTS`(
  `category` varchar(30) NOT NULL,
  `cr_id` varchar(20) NOT NULL,
  `pt_num` varchar(20) NOT NULL,
  FOREIGN KEY(cr_id)REFERENCES CAR(car_id),
  FOREIGN KEY(pt_num)REFERENCES PART(part_number)
);


CREATE TABLE `ORDERS`(
  `order_number` varchar(40) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `status` varchar(20) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `cusername` varchar(20) NOT NULL,
  PRIMARY KEY(order_number),
  FOREIGN KEY(cusername)REFERENCES CLIENT(usrname)
);


CREATE TABLE `PARTS_PURCHASED`(
  `od_number` varchar(40) NOT NULL,
  `pt_nm` varchar(20) NOT NULL,
  FOREIGN KEY(od_number)REFERENCES ORDERS(order_number),
  FOREIGN KEY(pt_nm)REFERENCES PART(part_number)
);


CREATE TABLE `MANAGES`(
  `od_num` varchar(40) NOT NULL,
  `e_username` varchar(20) NOT NULL,
  FOREIGN KEY(od_num)REFERENCES ORDERS(order_number),
  FOREIGN KEY(e_username)REFERENCES EMPLOYEE(usrname)
);

INSERT INTO USERS(username, password, type_usr) VALUES
("client", "$2y$10$fIE27WAXWEj0HfBCoSruHuJFusU8AVZ8./c4ckbK82Up/.Fq56/4K", "client");
INSERT INTO USERS(username, password, type_usr) VALUES
("admin", "$2y$10$fIE27WAXWEj0HfBCoSruHuJFusU8AVZ8./c4ckbK82Up/.Fq56/4K", "admin");


GRANT SELECT, INSERT, UPDATE, DELETE
ON * 
TO admin@localhost
IDENTIFIED BY 'pass';