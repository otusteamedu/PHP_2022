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

CREATE TABLE IF NOT EXISTS place (
    id SERIAL NOT NULL PRIMARY KEY,
    row smallint NOT NULL,
    place smallint NOT NULL,
    hall_id int REFERENCES hall
);
CREATE UNIQUE INDEX ON place(row, place, hall_id);

CREATE TABLE IF NOT EXISTS ticket (
    id SERIAL PRIMARY KEY NOT NULL,
    session_id int REFERENCES session,
    customer_id int REFERENCES customer,
    ticket_type_id int REFERENCES ticket_type,
    place_id int REFERENCES place
);

CREATE UNIQUE INDEX ON ticket(session_id, place_id);
