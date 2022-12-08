DELIMITER $$
CREATE PROCEDURE FillBase(IN count INT)

BEGIN

    DECLARE i INT DEFAULT 1;

    WHILE i < (count+1)
        DO
            INSERT INTO `films` (`id`, `title`) VALUES(i, GenerateString());
            insert into `attribute_film` (`film_id`, `attribute_id`, `val_date`) values (i, 1, DATE(GenerateDate()));
            insert into `attribute_film` (`film_id`, `attribute_id`, `val_date`) values (i, 2, DATE(GenerateDate()));
            insert into `attribute_film` (`film_id`, `attribute_id`, `val_string`) values (i, 3, GenerateString());
            insert into `attribute_film` (`film_id`, `attribute_id`, `val_string`) values (i, 4, GenerateString());
            insert into `attribute_film` (`film_id`, `attribute_id`, `val_int`) values (i, 5, RAND()*18);
            insert into `attribute_film` (`film_id`, `attribute_id`, `val_bool`) values (i, 6, RAND()*1);
            insert into `attribute_film` (`film_id`, `attribute_id`, `val_date`) values (i, 7, DATE(GenerateDate()));
            SET i = i + 1;
        END WHILE;
    END$$
DELIMITER ;
