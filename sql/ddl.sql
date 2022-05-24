CREATE TABLE IF NOT EXISTS hall (
    id SERIAL PRIMARY KEY NOT NULL,
    name varchar(50) NOT NULL
);

CREATE TABLE IF NOT EXISTS film (
    id SERIAL PRIMARY KEY NOT NULL,
    name VARCHAR NOT NULL,
    duration TIME NOT NULL
);

CREATE TABLE IF NOT EXISTS session (
    id SERIAL PRIMARY KEY NOT NULL,
    film_id int REFERENCES film,
    time time
);

CREATE TABLE IF NOT EXISTS customer (
    id SERIAL PRIMARY KEY NOT NULL,
    phone numeric
);

CREATE TABLE IF NOT EXISTS ticket_type (
    id SERIAL PRIMARY KEY NOT NULL,
    type VARCHAR(100),
    price int
);

CREATE TABLE IF NOT EXISTS hall_session(
    session_id int REFERENCES session,
    hall_id int REFERENCES hall
);

CREATE TABLE IF NOT EXISTS ticket (
    id SERIAL PRIMARY KEY NOT NULL,
    session_id int REFERENCES session,
    customer_id int REFERENCES customer,
    ticket_type_id int REFERENCES ticket_type,
    place_id smallint NOT NULL,
    row_id smallint NOT NULL
);

CREATE TABLE IF NOT EXISTS place (
    id SERIAL NOT NULL PRIMARY KEY,
    number smallint NOT NULL CHECK
        (number > 0 AND number < 30)
);

CREATE TABLE IF NOT EXISTS row (
    id SERIAL NOT NULL PRIMARY KEY,
    number smallint NOT NULL CHECK
        (number > 0 AND number < 15)
);

CREATE UNIQUE INDEX ON ticket(session_id, place_id, row_id);
