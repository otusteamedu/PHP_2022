DELIMITER $$
CREATE PROCEDURE films(IN count INT)

BEGIN

    DECLARE i INT DEFAULT 0;

    WHILE i < count
        DO
            INSERT INTO films (title, base_price) VALUES (GenerateFilmTitle(), CEILING(RAND() * (300 - 100) + 100));
            SET i = i + 1;
        END WHILE;
END$$
DELIMITER ;

DELIMITER $$
CREATE PROCEDURE sessions(IN count INT)

BEGIN

    DECLARE i INT DEFAULT 0;
    DECLARE start timestamp;
    DECLARE end timestamp;

    WHILE i < count
        DO
            SET start = GenerateDate();
            SET end = dateadd(HH, 2, DATE (start)) ;
            IF (end < start) THEN INSERT INTO sessions (`from`, `to`, markup) VALUES (end, start, CEILING(RAND() * (50 - 25) + 25));
            else INSERT INTO sessions (`from`, `to`, markup) VALUES (start, end, CEILING(RAND() * (50 - 25) + 25));
            end if;

            SET i = i + 1;
        END WHILE;


END$$
DELIMITER ;