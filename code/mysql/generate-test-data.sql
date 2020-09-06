-- usage: call generate(10000)
CREATE PROCEDURE `generate`(IN num INT)
BEGIN

    DECLARE chars VARCHAR(100) DEFAULT 'abcdefghijklmnopqrstuvwxyz';
    DECLARE chars1 VARCHAR(100) DEFAULT '行政技术研发财务人事开发公关推广营销咨询客服运营测试';
    DECLARE chars2 VARCHAR(100) DEFAULT '北京上海青岛重庆成都安徽福建浙江杭州深圳温州内蒙古天津河北西安四川';
    DECLARE chars3 CHAR(6) DEFAULT '356789';
    DECLARE realname VARCHAR(10) DEFAULT '';
    DECLARE id int;
    DECLARE len int;
    DECLARE phone CHAR(11) DEFAULT '';
    DECLARE department VARCHAR(10) DEFAULT '';
    DECLARE address VARCHAR(25) DEFAULT '';
    DECLARE created_at datetime;
    CREATE TABLE IF NOT EXISTS `person`  (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `realname` varchar(20) NOT NULL,
        `age` tinyint(3) unsigned NOT NULL DEFAULT '0',
        `sex` tinyint(1) NOT NULL DEFAULT '0',
        `phone` char(11) NOT NULL DEFAULT '',
        `department` char(10) NOT NULL,
        `address` varchar(200) NOT NULL,
        `created_at` datetime NOT NULL,
        PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
    
    set id=1;
    set autocommit = 0;
    WHILE id <= num DO

        set len = FLOOR(5 + RAND()*20);
        set realname = '';
        WHILE len > 0 DO
            SET realname = CONCAT(realname,substring(chars,FLOOR(1 + RAND()*26),1));
            SET len = len - 1;
        END WHILE;

        set len = 10;
        set phone = concat('1', substring(chars3,FLOOR(1 + RAND()*6),1));
        WHILE len > 0 DO
            SET phone = CONCAT(phone, FLOOR(1 + RAND()*9));
            SET len = len - 1;
        END WHILE;
        
        set len = FLOOR(2 + RAND()*2);
        set department = '';
        WHILE len > 0 DO
            SET department = CONCAT(department,substring(chars1,FLOOR(1 + RAND()*26),1));
            SET len = len - 1;
        END WHILE;
        set department=CONCAT(department,'部');

        set len = FLOOR(6+RAND()*18);
        set address = '';
        WHILE len > 0 DO
            SET address = CONCAT(address,SUBSTR(chars2,FLOOR(1 + RAND()*33),1));
            SET len = len - 1;
        END WHILE;
        
        set created_at = DATE_ADD(DATE_ADD(DATE_SUB(CURRENT_TIMESTAMP, INTERVAL 1 YEAR), INTERVAL FLOOR(1 + RAND()*360) day), INTERVAL FLOOR(1 + RAND()*86400) second);
        INSERT INTO person (realname,age,sex,phone,department,address,created_at) VALUES (realname,FLOOR(RAND()*100), FLOOR(RAND()*2), phone, department, address, created_at);
        set id = id + 1;
    END WHILE;
    set autocommit = 1;
END