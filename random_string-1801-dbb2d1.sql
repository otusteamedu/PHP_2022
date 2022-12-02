DELIMITER $$
CREATE FUNCTION GenerateFilmTitle()
    RETURNS VARCHAR(255)

BEGIN

    DECLARE title VARCHAR(255);
    DECLARE titleLen INT;
    DECLARE chars VARCHAR(53);
    DECLARE charsLen INT;

    SET chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ abcdefghijklmnopqrstuvwxyz';
    SET titleLen = RAND() * (25 - 10);
    SET charsLen = LENGTH(chars);
    SET title = '';

    WHILE LENGTH(title) < titleLen
        DO
            SET title = CONCAT(title, substring(chars, CEILING(RAND() * charsLen), 1));
        END WHILE;

    RETURN title;

END$$
DELIMITER ;

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
CREATE FUNCTION GenerateDate()
    RETURNS TIMESTAMP

BEGIN

    return FROM_UNIXTIME(ROUND((RAND() * (UNIX_TIMESTAMP('2023-06-20') - UNIX_TIMESTAMP('2022-12-02'))) +
                               UNIX_TIMESTAMP('2022-12-02')));

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
            SET end = GenerateDate();
            IF (end < start) THEN INSERT INTO sessions (`from`, `to`, markup) VALUES (end, start, CEILING(RAND() * (50 - 25) + 25));
            else INSERT INTO sessions (`from`, `to`, markup) VALUES (start, end, CEILING(RAND() * (50 - 25) + 25));
            end if;

            SET i = i + 1;
        END WHILE;


END$$
DELIMITER ;

