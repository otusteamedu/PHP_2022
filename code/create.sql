CREATE TABLE IF NOT EXISTS hall_type
(
    id    serial PRIMARY KEY NOT NULL,
    title varchar(255)       NOT NULL
);

CREATE TABLE IF NOT EXISTS hall
(
    id           serial PRIMARY KEY NOT NULL,
    number       integer            NOT NULL,
    id_hall_type integer REFERENCES hall_type
);

CREATE TABLE IF NOT EXISTS film
(
    id        serial PRIMARY KEY NOT NULL,
    title     varchar(255)       NOT NULL,
    rating    decimal            NOT NULL,
    date_from date               NOT NULL,
    date_to   date               NOT NULL
);

CREATE TABLE IF NOT EXISTS session
(
    id      serial PRIMARY KEY NOT NULL,
    id_film integer REFERENCES film,
    id_hall integer REFERENCES hall,
    price   decimal            NOT NULL
);

CREATE TABLE IF NOT EXISTS seat
(
    id           serial PRIMARY KEY NOT NULL,
    number       integer            NOT NULL,
    row          integer            NOT NULL,
    hall_type_id integer REFERENCES hall_type
);

CREATE TABLE IF NOT EXISTS session_seat
(
    id         serial PRIMARY KEY NOT NULL,
    id_session integer REFERENCES session,
    id_seat    integer REFERENCES seat
);

CREATE TABLE IF NOT EXISTS ticket
(
    id           serial PRIMARY KEY NOT NULL,
    id_film      integer REFERENCES film,
    id_seat      integer REFERENCES seat,
    id_hall      integer REFERENCES hall,
    id_session   integer REFERENCES session,
    ticket_price decimal            NOT NULL
);

CREATE TABLE IF NOT EXISTS session_seat
(
    id      serial PRIMARY KEY NOT NULL,
    id_hall integer REFERENCES hall,
    id_seat integer REFERENCES seat
);

