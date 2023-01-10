CREATE TABLE IF NOT EXISTS hall
(
    hall_id smallserial  NOT NULL primary key,
    title   varchar(255) NOT NULL
);
CREATE TABLE IF NOT EXISTS movie
(
    movie_id serial       NOT NULL primary key,
    title    varchar(255) NOT NULL
);
CREATE TABLE IF NOT EXISTS session
(
    session_id serial      NOT NULL primary key,
    hall_id    int2        NOT NULL REFERENCES hall (hall_id),
    movie_id   int         NOT NULL REFERENCES movie (movie_id),
    time_start timestamptz NOT NULL,
    time_end   timestamptz NOT NULL
);
CREATE TABLE IF NOT EXISTS seat_category
(
    seat_cat_id   smallserial  NOT NULL primary key,
    category_name varchar(255) NOT NULL
);
CREATE TABLE IF NOT EXISTS seat
(
    seat_id     serial NOT NULL primary key,
    hall_id     int2   NOT NULL REFERENCES hall (hall_id),
    seat_cat_id int2   NOT NULL REFERENCES seat_category (seat_cat_id),
    seat_number int2   NOT NULL
);
CREATE TABLE IF NOT EXISTS price
(
    price_id    serial NOT NULL primary key,
    session_id  int    NOT NULL REFERENCES session (session_id),
    seat_cat_id int2   NOT NULL REFERENCES seat_category (seat_cat_id),
    price_value money  NOT NULL
);
CREATE TABLE IF NOT EXISTS ticket
(
    ticket_id      serial      NOT NULL primary key,
    session_id     int         NOT NULL REFERENCES session (session_id),
    seat_id        int2        NOT NULL REFERENCES seat (seat_id),
    price_id       int         NOT NULL REFERENCES price (price_id),
    sale_timestamp timestamptz NOT NULL DEFAULT now()
);