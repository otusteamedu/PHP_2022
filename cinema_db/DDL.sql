CREATE DATABASE cinema_otus;

CREATE TABLE cinema_hall (
	id SERIAL PRIMARY KEY NOT NULL,
	name VARCHAR (50) NOT NULL,
	number_of_seats INTEGER NOT NULL
);

CREATE TABLE movie (
	id SERIAL PRIMARY KEY NOT NULL,
	title VARCHAR (100) NOT NULL
);

CREATE TABLE seance (
	id SERIAL PRIMARY KEY NOT NULL,
	cinema_hall_id INTEGER NOT NULL,
	movie_id INTEGER NOT NULL,
	price MONEY NOT NULL,
	starts_at DATE,
	FOREIGN KEY (cinema_hall_id) REFERENCES cinema_hall (id),
	FOREIGN KEY (movie_id) REFERENCES movie (id)
);

CREATE TABLE client (
	id SERIAL PRIMARY KEY NOT NULL,
	first_name VARCHAR (100) NOT NULL,
	last_name VARCHAR (100) NOT NULL
);

CREATE TABLE ticket (
	id SERIAL PRIMARY KEY NOT NULL,
	client_id INTEGER NOT NULL,
	seat_number INTEGER NOT NULL,
	seance_id SERIAL NOT NULL,
	FOREIGN KEY (client_id) REFERENCES client (id),
	FOREIGN KEY (seance_id) REFERENCES seance (id)
);