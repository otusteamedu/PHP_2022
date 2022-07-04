-- DROP SCHEMA public;

CREATE SCHEMA public AUTHORIZATION postgres;

-- DROP SEQUENCE public.films_id_seq;

CREATE SEQUENCE public.films_id_seq
	INCREMENT BY 1
	MINVALUE 1
	MAXVALUE 9223372036854775807
	START 1;
-- DROP SEQUENCE public.halls_id_seq;

CREATE SEQUENCE public.halls_id_seq
	INCREMENT BY 1
	MINVALUE 1
	MAXVALUE 9223372036854775807
	START 1;
-- DROP SEQUENCE public.price_description_id_seq;

CREATE SEQUENCE public.price_description_id_seq
	INCREMENT BY 1
	MINVALUE 1
	MAXVALUE 9223372036854775807
	START 1;
-- DROP SEQUENCE public.prices_id_seq;

CREATE SEQUENCE public.prices_id_seq
	INCREMENT BY 1
	MINVALUE 1
	MAXVALUE 9223372036854775807
	START 1;
-- DROP SEQUENCE public.seanses_id_seq;

CREATE SEQUENCE public.seanses_id_seq
	INCREMENT BY 1
	MINVALUE 1
	MAXVALUE 9223372036854775807
	START 1;
-- DROP SEQUENCE public.seats_id_seq;

CREATE SEQUENCE public.seats_id_seq
	INCREMENT BY 1
	MINVALUE 1
	MAXVALUE 9223372036854775807
	START 1;
-- DROP SEQUENCE public.tickets_id_seq;

CREATE SEQUENCE public.tickets_id_seq
	INCREMENT BY 1
	MINVALUE 1
	MAXVALUE 9223372036854775807
	START 1;-- public.films definition

-- Drop table

-- DROP TABLE public.films;

CREATE TABLE public.films (
	id serial4 NOT NULL,
	film_name varchar NOT NULL,
	base_ticket_price numeric NOT NULL DEFAULT 150,
	CONSTRAINT films_pk PRIMARY KEY (id)
);


-- public.halls definition

-- Drop table

-- DROP TABLE public.halls;

CREATE TABLE public.halls (
	id serial4 NOT NULL,
	hall_name varchar NOT NULL,
	CONSTRAINT halls_pk PRIMARY KEY (id)
);


-- public.price_description definition

-- Drop table

-- DROP TABLE public.price_description;

CREATE TABLE public.price_description (
	id serial4 NOT NULL,
	description varchar NOT NULL,
	CONSTRAINT price_description_pk PRIMARY KEY (id)
);


-- public.prices definition

-- Drop table

-- DROP TABLE public.prices;

CREATE TABLE public.prices (
	id serial4 NOT NULL,
	value numeric NOT NULL,
	description_id int4 NOT NULL,
	CONSTRAINT prices_pk PRIMARY KEY (id),
	CONSTRAINT prices_fk FOREIGN KEY (id) REFERENCES public.price_description(id) ON DELETE RESTRICT ON UPDATE RESTRICT
);


-- public.seanses definition

-- Drop table

-- DROP TABLE public.seanses;

CREATE TABLE public.seanses (
	id serial4 NOT NULL,
	film_id int4 NOT NULL,
	start_time timestamp NOT NULL,
	end_time timestamp NOT NULL,
	CONSTRAINT seanses_check CHECK ((start_time < end_time)),
	CONSTRAINT seanses_pk PRIMARY KEY (id),
	CONSTRAINT seanses_fk FOREIGN KEY (film_id) REFERENCES public.films(id)
);
CREATE INDEX seanses_film_id_idx ON seanses USING btree (film_id);


-- public.seats definition

-- Drop table

-- DROP TABLE public.seats;

CREATE TABLE public.seats (
	id serial4 NOT NULL,
	hall_id int4 NOT NULL,
	"row_number" int4 NOT NULL,
	seat_number int4 NOT NULL,
	vip bool NOT NULL DEFAULT false,
	CONSTRAINT seats_pk PRIMARY KEY (id),
	CONSTRAINT seats_fk FOREIGN KEY (hall_id) REFERENCES public.halls(id)
);


-- public.tickets definition

-- Drop table

-- DROP TABLE public.tickets;

CREATE TABLE public.tickets (
	id serial4 NOT NULL,
	sold bool NOT NULL DEFAULT true,
	seanse_id int4 NOT NULL,
	seat_id int4 NOT NULL,
	price_id int4 NOT NULL,
	CONSTRAINT tickets_pk PRIMARY KEY (id),
	CONSTRAINT tickets_fk FOREIGN KEY (seanse_id) REFERENCES public.seanses(id),
	CONSTRAINT tickets_prices_fk FOREIGN KEY (id) REFERENCES public.prices(id) ON DELETE RESTRICT ON UPDATE RESTRICT,
	CONSTRAINT tickets_seats_fk FOREIGN KEY (seat_id) REFERENCES public.seats(id)
);
CREATE INDEX tickets_seanse_id_idx ON tickets USING btree (seanse_id);


