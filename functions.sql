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
CREATE FUNCTION GenerateDate()
    RETURNS TIMESTAMP

BEGIN

    return FROM_UNIXTIME(ROUND((RAND() * (UNIX_TIMESTAMP('2023-06-20') - UNIX_TIMESTAMP('2022-12-02'))) +
                               UNIX_TIMESTAMP('2022-12-02')));

END$$
DELIMITER ;