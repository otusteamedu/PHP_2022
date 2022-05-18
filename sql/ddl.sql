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
    session_id int REFERENCES session,
    customer_id int REFERENCES customer,
    price int
);

CREATE TABLE hall_session(
    session_id int REFERENCES session,
    hall_id int REFERENCES hall
);