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

CREATE TABLE IF NOT EXISTS ticket (
    id SERIAL PRIMARY KEY NOT NULL,
    type VARCHAR(100),
    price int
);

CREATE TABLE hall_session(
    session_id int REFERENCES session,
    hall_id int REFERENCES hall
);

CREATE TABLE IF NOT EXISTS customer_ticket (
    id SERIAL PRIMARY KEY NOT NULL,
    session_id int REFERENCES session,
    customer_id int REFERENCES customer,
    ticket_id int REFERENCES ticket,
    place smallint NOT NULL CHECK
        (place > 0 AND place < 30),
    row smallint NOT NULL CHECK
        (row > 0 AND row < 15)
);

CREATE UNIQUE INDEX ON customer_ticket(session_id, place, row);
