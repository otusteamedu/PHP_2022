CREATE TABLE halls (
    id serial PRIMARY KEY,
    name VARCHAR ( 255 ) UNIQUE NOT NULL,
    count_rows SMALLINT NOT NULL,
    count_seats_in_row SMALLINT NOT NULL
);

CREATE TABLE sectors(
    id serial PRIMARY KEY,
    name VARCHAR (255) UNIQUE NOT NULL,
    markup_percentage SMALLINT DEFAULT (0)
);


CREATE TABLE films(
    id serial PRIMARY KEY,
    name varchar (255) NOT NULL,
    duration SMALLINT NOT NULL,
    beginning_of_distribution DATE NOT NULL,
    end_of_distribution DATE NOT NULL
);


CREATE TABLE screening (
    id serial PRIMARY KEY,
    beginning_date_time timestamp NOT NULL,

    hall_id INT NOT NULL, FOREIGN KEY (hall_id) REFERENCES halls (id) ON DELETE CASCADE,
    film_id INT NOT NULL, FOREIGN KEY (film_id) REFERENCES films (id) ON DELETE SET NULL
);


CREATE TABLE rows_seats(
    id serial PRIMARY KEY,
    seat SMALLINT NOT NULL,
    row SMALLINT NOT NULL,

    hall_id INT NOT NULL, FOREIGN KEY (hall_id) REFERENCES halls (id) ON DELETE CASCADE,
    sector_id INT NOT NULL, FOREIGN KEY (sector_id) REFERENCES sectors (id) ON DELETE SET NULL
);

CREATE TABLE  tickets (
    id serial PRIMARY KEY,
    sold BOOLEAN NOT NULL DEFAULT (false),
    price NUMERIC NOT NULL,

    screening_id INT NOT NULL, FOREIGN KEY (screening_id) REFERENCES screening (id) ON DELETE SET NULL ,
    rows_seats_id INT NOT NULL, FOREIGN KEY (rows_seats_id) REFERENCES rows_seats (id) ON DELETE SET NULL
);
