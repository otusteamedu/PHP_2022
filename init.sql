CREATE TABLE age_restriction
(
    id  int NOT NULL AUTO_INCREMENT,
    age int NOT NULL,
    PRIMARY KEY (id)
)

CREATE TABLE film
(
    film_id         int          NOT NULL AUTO_INCREMENT,
    name            varchar(255) NOT NULL,
    age_restriction int          NOT NULL,
    duration        int          NOT NULL,
    PRIMARY KEY (film_id),
    FOREIGN KEY (age_restriction) REFERENCES age_restriction (id)
);



CREATE TABLE hall
(
    hall_id int          NOT NULL AUTO_INCREMENT,
    name    varchar(255) NOT NULL,
    PRIMARY KEY (hall_id)
);

CREATE TABLE film_session
(
    session_id int      NOT NULL AUTO_INCREMENT,
    hall_id    int      NOT NULL,
    film_id    int      NOT NULL,
    begins_at  DATETIME NOT NULL,
    ends_at    DATETIME NOT NULL,
    PRIMARY KEY (session_id),
    FOREIGN KEY (film_id) REFERENCES film (film_id),
    FOREIGN KEY (hall_id) REFERENCES hall (hall_id)
);

CREATE TABLE seat
(
    seat_id         int     NOT NULL AUTO_INCREMENT,
    hall_id         int     NOT NULL,
    raw_number      integer NOT NULL,
    raw_seat_number integer NOT NULL,
    PRIMARY KEY (seat_id),
    FOREIGN KEY (hall_id) REFERENCES hall (hall_id)
);

CREATE TABLE ticket
(
    ticket_id       int     NOT NULL AUTO_INCREMENT,
    film_session_id int     NOT NULL,
    seat_id         int     NOT NULL,
    price           int     NOT NULL,
    is_used         TINYINT NOT NULL,
    age_restriction int     NOT NULL,
    PRIMARY KEY (ticket_id),
    FOREIGN KEY (film_session_id) REFERENCES film_session (session_id),
    FOREIGN KEY (seat_id) REFERENCES seat (seat_id),
    FOREIGN KEY (age_restriction) REFERENCES age_restriction (id)
);


INSERT INTO hall (name)
VALUES ('Синий'),
       ('Красный'),
       ('Зеленый');

INSERT INTO age_restriction (age)
VALUES (12),
       (16),
       (18);

INSERT INTO film (name, age_restriction, duration)
VALUES ('Железный Человек', 2, 120),
       ('Ледниковый Период', 1, 130),
       ('Пила', 3, 240);

INSERT INTO film_session (hall_id, film_id, begins_at, ends_at)
VAlUES (2, 1, '2022-07-23 10:00:00', '2022-07-23 12:00:00'),
       (1, 2, '2022-07-23 12:30:00', '2022-07-23 14:40:00'),
       (3, 3, '2022-07-23 18:00:00', '2022-07-23 22:00:00')
    INSERT
INTO seat (hall_id, raw_number, raw_seat_number)
VALUES
    (1, 1, 1),
    (1, 1, 2),
    (1, 1, 3),
    (1, 1, 4),
    (1, 1, 5),
    (1, 2, 1),
    (1, 2, 2),
    (1, 2, 3),
    (1, 2, 4),
    (1, 2, 5),
    (1, 3, 1),
    (1, 3, 2),
    (1, 3, 3),
    (1, 3, 4),
    (1, 3, 5),
    (1, 4, 1),
    (1, 4, 2),
    (1, 4, 3),
    (1, 4, 4),
    (1, 4, 5),
    (1, 5, 1),
    (1, 5, 2),
    (1, 5, 3),
    (1, 5, 4),
    (1, 5, 5),
    (2, 1, 1),
    (2, 1, 2),
    (2, 1, 3),
    (2, 1, 4),
    (2, 1, 5),
    (2, 2, 1),
    (2, 2, 2),
    (2, 2, 3),
    (2, 2, 4),
    (2, 2, 5),
    (2, 3, 1),
    (2, 3, 2),
    (2, 3, 3),
    (2, 3, 4),
    (2, 3, 5),
    (2, 4, 1),
    (2, 4, 2),
    (2, 4, 3),
    (2, 4, 4),
    (2, 4, 5),
    (2, 5, 1),
    (2, 5, 2),
    (2, 5, 3),
    (2, 5, 4),
    (2, 5, 5),
    (3, 1, 1),
    (3, 1, 2),
    (3, 1, 3),
    (3, 1, 4),
    (3, 1, 5),
    (3, 2, 1),
    (3, 2, 2),
    (3, 2, 3),
    (3, 2, 4),
    (3, 2, 5),
    (3, 3, 1),
    (3, 3, 2),
    (3, 3, 3),
    (3, 3, 4),
    (3, 3, 5),
    (3, 4, 1),
    (3, 4, 2),
    (3, 4, 3),
    (3, 4, 4),
    (3, 4, 5),
    (3, 5, 1),
    (3, 5, 2),
    (3, 5, 3),
    (3, 5, 4),
    (3, 5, 5);
INSERT INTO ticket (film_session_id, seat_id, price, is_used, age_restriction)
VALUES (1, 26, 150, 1, 2),
       (1, 27, 150, 0, 2),
       (1, 28, 150, 1, 2),
       (1, 29, 150, 1, 2),
       (1, 30, 150, 0, 2),
       (1, 31, 150, 1, 2),
       (1, 32, 150, 1, 2),
       (1, 33, 150, 1, 2),
       (1, 34, 150, 0, 2),
       (1, 35, 150, 1, 2),
       (1, 36, 150, 1, 2),
       (1, 37, 150, 1, 2),
       (1, 38, 150, 1, 2),
       (1, 39, 150, 0, 2),
       (1, 40, 150, 0, 2),
       (1, 41, 150, 1, 2),
       (1, 42, 150, 1, 2),
       (1, 43, 150, 1, 2),
       (1, 44, 150, 0, 2),
       (1, 45, 150, 1, 2),
       (1, 46, 150, 0, 2),
       (1, 47, 150, 1, 2),
       (1, 48, 150, 0, 2),
       (1, 49, 150, 1, 2),
       (1, 50, 150, 1, 2),
       (2, 1, 155, 1, 2),
       (2, 2, 155, 0, 2),
       (2, 3, 155, 1, 2),
       (2, 4, 155, 1, 2),
       (2, 5, 155, 0, 2),
       (2, 6, 155, 1, 2),
       (2, 7, 155, 1, 2),
       (2, 8, 155, 1, 2),
       (2, 9, 155, 0, 2),
       (2, 10, 155, 1, 2),
       (2, 11, 155, 1, 2),
       (2, 12, 155, 0, 2),
       (2, 13, 155, 1, 2),
       (2, 14, 155, 0, 2),
       (2, 15, 155, 0, 2),
       (2, 16, 155, 0, 2),
       (2, 17, 155, 1, 2),
       (2, 18, 155, 1, 2),
       (2, 19, 155, 0, 2),
       (2, 20, 155, 0, 2),
       (2, 21, 155, 0, 2),
       (2, 22, 155, 1, 2),
       (2, 23, 155, 0, 2),
       (2, 24, 155, 1, 2),
       (2, 25, 155, 0, 2),
       (3, 51, 145, 1, 2),
       (3, 52, 145, 0, 2),
       (3, 53, 145, 1, 2),
       (3, 54, 145, 1, 2),
       (3, 55, 145, 1, 2),
       (3, 56, 145, 1, 2),
       (3, 57, 145, 1, 2),
       (3, 58, 145, 1, 2),
       (3, 59, 145, 1, 2),
       (3, 60, 145, 1, 2),
       (3, 61, 145, 1, 2),
       (3, 62, 145, 0, 2),
       (3, 63, 145, 1, 2),
       (3, 64, 145, 0, 2),
       (3, 65, 145, 1, 2),
       (3, 66, 145, 1, 2),
       (3, 67, 145, 1, 2),
       (3, 68, 145, 1, 2),
       (3, 69, 145, 1, 2),
       (3, 70, 145, 1, 2),
       (3, 71, 145, 1, 2),
       (3, 72, 145, 1, 2),
       (3, 73, 145, 1, 2),
       (3, 74, 145, 1, 2),
       (3, 75, 145, 1, 2);



