DROP TABLE IF EXISTS halls CASCADE ;
CREATE TABLE halls
(
    id integer NOT NULL constraint pk_hall_id primary key,
    name char(255) NOT NULL
);
INSERT INTO halls
VALUES
    (1, 'Зал "Красный"'),
    (2, 'Зал "Зеленый"'),
    (3, 'Зал "Желтый"');

DROP TABLE IF EXISTS halls_seat CASCADE;
CREATE TABLE halls_seat
(
    id integer NOT NULL constraint pk_hall_seat_id primary key,
    name smallint NOT NULL,
    hall_id integer NOT NULL,
    CONSTRAINT fk_hall_id
        FOREIGN KEY (hall_id) REFERENCES halls ON DELETE CASCADE
);
INSERT INTO halls_seat
VALUES
    (1, 1, 1),
    (2, 2, 1),
    (3, 3, 1),
    (4, 4, 1),
    (5, 5, 1),
    (6, 1, 2),
    (7, 2, 2),
    (8, 3, 2),
    (9, 4, 2),
    (10, 5, 2),
    (11, 1, 3),
    (12, 2, 3),
    (13, 3, 3),
    (14, 4, 3),
    (15, 5, 3);

DROP TABLE IF EXISTS films CASCADE;
CREATE TABLE films
(
    id integer NOT NULL constraint pk_film_id primary key,
    name char(255) NOT NULL,
    duration integer NOT NULL,
    rating float4 NOT NULL default 0.0
);
INSERT INTO films
VALUES
    (1, 'Аватар: Путь воды', 159, 9.9),
    (2, 'Маша и Медведь в кино: 12 месяцев', 121, 6.7);

DROP TABLE IF EXISTS seance CASCADE;
CREATE TABLE seance
(
    id integer NOT NULL constraint pk_seance_id primary key,
    hall_id integer NOT NULL,
    film_id integer NOT NULL,
    start timestamp NOT NULL,
    CONSTRAINT fk_hall_id
        FOREIGN KEY (hall_id) REFERENCES halls ON DELETE CASCADE,
    CONSTRAINT fk_film_id
        FOREIGN KEY (film_id) REFERENCES films ON DELETE CASCADE
);
INSERT INTO seance
VALUES
    (1, 1, 1, '2022-12-25 10:00:00'),
    (2, 2, 2, '2022-12-25 12:00:00'),
    (3, 1, 1, '2022-12-25 21:00:00'),
    (4, 2, 2, '2022-12-25 21:00:00'),
    (5, 1, 1, '2022-12-26 10:00:00'),
    (6, 2, 2, '2022-12-26 12:00:00'),
    (7, 1, 1, '2022-12-27 10:00:00'),
    (8, 2, 2, '2022-12-28 12:00:00');

DROP TABLE IF EXISTS orders CASCADE;
CREATE TABLE orders
(
    seance_id integer NOT NULL,
    seat_id integer NOT NULL,
    price decimal NOT NULL,
    CONSTRAINT fk_order_seance_id
        foreign key (seance_id) references seance,
    CONSTRAINT fk_order_halls_seat_id
        foreign key (seat_id) references halls_seat,
    CONSTRAINT pk_seat_seance_id
        primary key (seance_id, seat_id)
);
INSERT INTO orders
VALUES
    (1, 1, 10),
    (1, 2, 15),
    (2, 3, 10),
    (2, 4, 12),
    (3, 5, 15),
    (3, 6, 12),
    (4, 1, 10),
    (4, 2, 8),
    (5, 3, 10),
    (5, 4, 20),
    (6, 5, 12),
    (6, 6, 10);