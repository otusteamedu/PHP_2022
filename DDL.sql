CREATE
    DATABASE cinema;

CREATE TABLE hall
(
    id     SERIAL PRIMARY KEY NOT NULL,
    number INTEGER            NOT NULL
);

CREATE TABLE movie
(
    id    SERIAL PRIMARY KEY NOT NULL,
    title VARCHAR(100)       NOT NULL
);

CREATE TABLE session
(
    id        SERIAL PRIMARY KEY NOT NULL,
    hall_id   INTEGER            NOT NULL,
    movie_id  INTEGER            NOT NULL,
    price     MONEY              NOT NULL,
    starts_at DATE,
    FOREIGN KEY (hall_id) REFERENCES hall (id),
    FOREIGN KEY (movie_id) REFERENCES movie (id)
);

CREATE TABLE client
(
    id    SERIAL PRIMARY KEY NOT NULL,
    name  VARCHAR(100)       NOT NULL,
    email VARCHAR(100)       NOT NULL
);

CREATE TABLE seat
(
    id      SERIAL PRIMARY KEY NOT NULL,
    hall_id INTEGER            NOT NULL,
    row     INTEGER            NOT NULL,
    number  INTEGER            NOT NULL,
    FOREIGN KEY (hall_id) REFERENCES hall (id)
);

CREATE TABLE ticket
(
    id         SERIAL PRIMARY KEY NOT NULL,
    client_id  INTEGER            NOT NULL,
    seat_id    INTEGER            NOT NULL,
    price      MONEY              NOT NULL,
    session_id SERIAL             NOT NULL,
    FOREIGN KEY (client_id) REFERENCES client (id),
    FOREIGN KEY (seat_id) REFERENCES seat (id),
    FOREIGN KEY (session_id) REFERENCES session (id)
);


