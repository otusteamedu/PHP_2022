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
-- DROP SEQUENCE public.seanses_id_seq;

CREATE SEQUENCE public.seanses_id_seq
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
	CONSTRAINT films_pk PRIMARY KEY (id)
);


-- public.halls definition

-- Drop table

-- DROP TABLE public.halls;

CREATE TABLE public.halls (
	id serial4 NOT NULL,
	hall_name varchar NOT NULL,
	number_of_seats int4 NOT NULL,
	CONSTRAINT halls_pk PRIMARY KEY (id)
);


-- public.seanses definition

-- Drop table

-- DROP TABLE public.seanses;

CREATE TABLE public.seanses (
	id serial4 NOT NULL,
	hall_id int4 NOT NULL,
	film_id int4 NOT NULL,
	start_time timestamp NOT NULL,
	end_time timestamp NOT NULL,
	CONSTRAINT seanses_check CHECK ((start_time < end_time)),
	CONSTRAINT seanses_pk PRIMARY KEY (id),
	CONSTRAINT seanses_fk FOREIGN KEY (film_id) REFERENCES public.films(id),
	CONSTRAINT seanses_fk_1 FOREIGN KEY (hall_id) REFERENCES public.halls(id)
);
CREATE INDEX seanses_film_id_idx ON seanses USING btree (film_id);
CREATE INDEX seanses_hall_id_idx ON seanses USING btree (hall_id);


-- public.tickets definition

-- Drop table

-- DROP TABLE public.tickets;

CREATE TABLE public.tickets (
	id serial4 NOT NULL,
	sold bool NOT NULL DEFAULT true,
	price numeric NOT NULL,
	"row" int4 NOT NULL,
	col int4 NOT NULL,
	seanse_id int4 NOT NULL,
	CONSTRAINT tickets_pk PRIMARY KEY (id),
	CONSTRAINT tickets_fk FOREIGN KEY (seanse_id) REFERENCES public.seanses(id)
);
CREATE INDEX tickets_seanse_id_idx ON tickets USING btree (seanse_id);


