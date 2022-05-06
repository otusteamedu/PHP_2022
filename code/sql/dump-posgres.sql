--
-- PostgreSQL database dump
--

-- Dumped from database version 13.3 (Debian 13.3-1.pgdg100+1)
-- Dumped by pg_dump version 13.3 (Debian 13.3-1.pgdg100+1)

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

--
-- Name: cinema; Type: SCHEMA; Schema: -; Owner: root
--

CREATE SCHEMA cinema;


ALTER SCHEMA cinema OWNER TO root;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- Name: cinema; Type: TABLE; Schema: cinema; Owner: root
--

CREATE TABLE cinema.cinema (
    id integer NOT NULL,
    name character varying(10)
);


ALTER TABLE cinema.cinema OWNER TO root;

--
-- Name: cost; Type: TABLE; Schema: cinema; Owner: root
--

CREATE TABLE cinema.cost (
    id integer NOT NULL,
    cost double precision,
    currency_id integer
);


ALTER TABLE cinema.cost OWNER TO root;

--
-- Name: cost_id_seq; Type: SEQUENCE; Schema: cinema; Owner: root
--

CREATE SEQUENCE cinema.cost_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE cinema.cost_id_seq OWNER TO root;

--
-- Name: cost_id_seq; Type: SEQUENCE OWNED BY; Schema: cinema; Owner: root
--

ALTER SEQUENCE cinema.cost_id_seq OWNED BY cinema.cost.id;


--
-- Name: currency; Type: TABLE; Schema: cinema; Owner: root
--

CREATE TABLE cinema.currency (
    id integer NOT NULL,
    name character varying(20)
);


ALTER TABLE cinema.currency OWNER TO root;

--
-- Name: currency_id_seq; Type: SEQUENCE; Schema: cinema; Owner: root
--

CREATE SEQUENCE cinema.currency_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE cinema.currency_id_seq OWNER TO root;

--
-- Name: currency_id_seq; Type: SEQUENCE OWNED BY; Schema: cinema; Owner: root
--

ALTER SEQUENCE cinema.currency_id_seq OWNED BY cinema.currency.id;


--
-- Name: film; Type: TABLE; Schema: cinema; Owner: root
--

CREATE TABLE cinema.film (
    id integer NOT NULL,
    name character varying(20),
    created timestamp without time zone,
    updated timestamp without time zone
);


ALTER TABLE cinema.film OWNER TO root;

--
-- Name: film_id_seq; Type: SEQUENCE; Schema: cinema; Owner: root
--

CREATE SEQUENCE cinema.film_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE cinema.film_id_seq OWNER TO root;

--
-- Name: film_id_seq; Type: SEQUENCE OWNED BY; Schema: cinema; Owner: root
--

ALTER SEQUENCE cinema.film_id_seq OWNED BY cinema.film.id;


--
-- Name: hall; Type: TABLE; Schema: cinema; Owner: root
--

CREATE TABLE cinema.hall (
    id integer NOT NULL,
    name character varying(10),
    cinema_id integer
);


ALTER TABLE cinema.hall OWNER TO root;

--
-- Name: hall_id_seq; Type: SEQUENCE; Schema: cinema; Owner: root
--

CREATE SEQUENCE cinema.hall_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE cinema.hall_id_seq OWNER TO root;

--
-- Name: hall_id_seq; Type: SEQUENCE OWNED BY; Schema: cinema; Owner: root
--

ALTER SEQUENCE cinema.hall_id_seq OWNED BY cinema.hall.id;


--
-- Name: hall_places; Type: TABLE; Schema: cinema; Owner: root
--

CREATE TABLE cinema.hall_places (
    id integer NOT NULL,
    film_id integer,
    hall_id integer,
    place_id integer,
    "row" smallint,
    cost_id integer
);


ALTER TABLE cinema.hall_places OWNER TO root;

--
-- Name: hall_places_id_seq; Type: SEQUENCE; Schema: cinema; Owner: root
--

CREATE SEQUENCE cinema.hall_places_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE cinema.hall_places_id_seq OWNER TO root;

--
-- Name: hall_places_id_seq; Type: SEQUENCE OWNED BY; Schema: cinema; Owner: root
--

ALTER SEQUENCE cinema.hall_places_id_seq OWNED BY cinema.hall_places.id;


--
-- Name: order; Type: TABLE; Schema: cinema; Owner: root
--

CREATE TABLE cinema."order" (
    id integer NOT NULL,
    user_id integer,
    hall_places_id integer,
    status_id integer
);


ALTER TABLE cinema."order" OWNER TO root;

--
-- Name: order_id_seq; Type: SEQUENCE; Schema: cinema; Owner: root
--

CREATE SEQUENCE cinema.order_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE cinema.order_id_seq OWNER TO root;

--
-- Name: order_id_seq; Type: SEQUENCE OWNED BY; Schema: cinema; Owner: root
--

ALTER SEQUENCE cinema.order_id_seq OWNED BY cinema."order".id;


--
-- Name: order_status; Type: TABLE; Schema: cinema; Owner: root
--

CREATE TABLE cinema.order_status (
    id integer NOT NULL,
    name character varying(20)
);


ALTER TABLE cinema.order_status OWNER TO root;

--
-- Name: order_status_id_seq; Type: SEQUENCE; Schema: cinema; Owner: root
--

CREATE SEQUENCE cinema.order_status_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE cinema.order_status_id_seq OWNER TO root;

--
-- Name: order_status_id_seq; Type: SEQUENCE OWNED BY; Schema: cinema; Owner: root
--

ALTER SEQUENCE cinema.order_status_id_seq OWNED BY cinema.order_status.id;


--
-- Name: places; Type: TABLE; Schema: cinema; Owner: root
--

CREATE TABLE cinema.places (
    id integer NOT NULL,
    place integer
);


ALTER TABLE cinema.places OWNER TO root;

--
-- Name: places_id_seq; Type: SEQUENCE; Schema: cinema; Owner: root
--

CREATE SEQUENCE cinema.places_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE cinema.places_id_seq OWNER TO root;

--
-- Name: places_id_seq; Type: SEQUENCE OWNED BY; Schema: cinema; Owner: root
--

ALTER SEQUENCE cinema.places_id_seq OWNED BY cinema.places.id;


--
-- Name: table_name_id_seq; Type: SEQUENCE; Schema: cinema; Owner: root
--

CREATE SEQUENCE cinema.table_name_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE cinema.table_name_id_seq OWNER TO root;

--
-- Name: table_name_id_seq; Type: SEQUENCE OWNED BY; Schema: cinema; Owner: root
--

ALTER SEQUENCE cinema.table_name_id_seq OWNED BY cinema.cinema.id;


--
-- Name: user; Type: TABLE; Schema: cinema; Owner: root
--

CREATE TABLE cinema."user" (
    id integer NOT NULL,
    name character varying(20)
);


ALTER TABLE cinema."user" OWNER TO root;

--
-- Name: user_id_seq; Type: SEQUENCE; Schema: cinema; Owner: root
--

CREATE SEQUENCE cinema.user_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE cinema.user_id_seq OWNER TO root;

--
-- Name: user_id_seq; Type: SEQUENCE OWNED BY; Schema: cinema; Owner: root
--

ALTER SEQUENCE cinema.user_id_seq OWNED BY cinema."user".id;


--
-- Name: cinema id; Type: DEFAULT; Schema: cinema; Owner: root
--

ALTER TABLE ONLY cinema.cinema ALTER COLUMN id SET DEFAULT nextval('cinema.table_name_id_seq'::regclass);


--
-- Name: cost id; Type: DEFAULT; Schema: cinema; Owner: root
--

ALTER TABLE ONLY cinema.cost ALTER COLUMN id SET DEFAULT nextval('cinema.cost_id_seq'::regclass);


--
-- Name: currency id; Type: DEFAULT; Schema: cinema; Owner: root
--

ALTER TABLE ONLY cinema.currency ALTER COLUMN id SET DEFAULT nextval('cinema.currency_id_seq'::regclass);


--
-- Name: film id; Type: DEFAULT; Schema: cinema; Owner: root
--

ALTER TABLE ONLY cinema.film ALTER COLUMN id SET DEFAULT nextval('cinema.film_id_seq'::regclass);


--
-- Name: hall id; Type: DEFAULT; Schema: cinema; Owner: root
--

ALTER TABLE ONLY cinema.hall ALTER COLUMN id SET DEFAULT nextval('cinema.hall_id_seq'::regclass);


--
-- Name: hall_places id; Type: DEFAULT; Schema: cinema; Owner: root
--

ALTER TABLE ONLY cinema.hall_places ALTER COLUMN id SET DEFAULT nextval('cinema.hall_places_id_seq'::regclass);


--
-- Name: order id; Type: DEFAULT; Schema: cinema; Owner: root
--

ALTER TABLE ONLY cinema."order" ALTER COLUMN id SET DEFAULT nextval('cinema.order_id_seq'::regclass);


--
-- Name: order_status id; Type: DEFAULT; Schema: cinema; Owner: root
--

ALTER TABLE ONLY cinema.order_status ALTER COLUMN id SET DEFAULT nextval('cinema.order_status_id_seq'::regclass);


--
-- Name: places id; Type: DEFAULT; Schema: cinema; Owner: root
--

ALTER TABLE ONLY cinema.places ALTER COLUMN id SET DEFAULT nextval('cinema.places_id_seq'::regclass);


--
-- Name: user id; Type: DEFAULT; Schema: cinema; Owner: root
--

ALTER TABLE ONLY cinema."user" ALTER COLUMN id SET DEFAULT nextval('cinema.user_id_seq'::regclass);


--
-- Data for Name: cinema; Type: TABLE DATA; Schema: cinema; Owner: root
--

COPY cinema.cinema (id, name) FROM stdin;
1	Украина
\.


--
-- Data for Name: cost; Type: TABLE DATA; Schema: cinema; Owner: root
--

COPY cinema.cost (id, cost, currency_id) FROM stdin;
1	100	1
2	150	1
3	200	1
4	250	1
\.


--
-- Data for Name: currency; Type: TABLE DATA; Schema: cinema; Owner: root
--

COPY cinema.currency (id, name) FROM stdin;
1	Гривня
\.


--
-- Data for Name: film; Type: TABLE DATA; Schema: cinema; Owner: root
--

COPY cinema.film (id, name, created, updated) FROM stdin;
1	Титаник	2022-03-03 14:16:38	2022-03-03 14:17:01
2	Терминатор2	2022-03-03 14:16:38	2022-03-03 14:17:01
3	Властелин колец	2022-03-03 14:16:38	2022-03-03 14:17:01
4	Форсаж9	2022-03-03 14:16:38	2022-03-03 14:17:01
\.


--
-- Data for Name: hall; Type: TABLE DATA; Schema: cinema; Owner: root
--

COPY cinema.hall (id, name, cinema_id) FROM stdin;
1	Первый зал	1
2	Второй зал	1
\.


--
-- Data for Name: hall_places; Type: TABLE DATA; Schema: cinema; Owner: root
--

COPY cinema.hall_places (id, film_id, hall_id, place_id, "row", cost_id) FROM stdin;
1	1	1	6	1	1
2	1	1	4	1	2
3	1	1	2	1	3
4	1	1	1	1	4
5	1	1	7	1	1
6	1	1	5	1	2
7	1	1	3	1	3
\.


--
-- Data for Name: order; Type: TABLE DATA; Schema: cinema; Owner: root
--

COPY cinema."order" (id, user_id, hall_places_id, status_id) FROM stdin;
1	1	1	3
2	1	1	1
3	2	2	2
4	2	2	3
\.


--
-- Data for Name: order_status; Type: TABLE DATA; Schema: cinema; Owner: root
--

COPY cinema.order_status (id, name) FROM stdin;
1	Новый
2	В обработке
3	Выполнен
\.


--
-- Data for Name: places; Type: TABLE DATA; Schema: cinema; Owner: root
--

COPY cinema.places (id, place) FROM stdin;
1	18
2	17
3	16
4	15
5	1
6	2
7	3
8	4
9	5
10	6
11	7
12	8
13	9
14	10
15	11
16	12
17	13
18	14
\.


--
-- Data for Name: user; Type: TABLE DATA; Schema: cinema; Owner: root
--

COPY cinema."user" (id, name) FROM stdin;
1	Василий Иванович
2	Петр Петрович
\.


--
-- Name: cost_id_seq; Type: SEQUENCE SET; Schema: cinema; Owner: root
--

SELECT pg_catalog.setval('cinema.cost_id_seq', 1, false);


--
-- Name: currency_id_seq; Type: SEQUENCE SET; Schema: cinema; Owner: root
--

SELECT pg_catalog.setval('cinema.currency_id_seq', 1, false);


--
-- Name: film_id_seq; Type: SEQUENCE SET; Schema: cinema; Owner: root
--

SELECT pg_catalog.setval('cinema.film_id_seq', 1, false);


--
-- Name: hall_id_seq; Type: SEQUENCE SET; Schema: cinema; Owner: root
--

SELECT pg_catalog.setval('cinema.hall_id_seq', 1, false);


--
-- Name: hall_places_id_seq; Type: SEQUENCE SET; Schema: cinema; Owner: root
--

SELECT pg_catalog.setval('cinema.hall_places_id_seq', 1, false);


--
-- Name: order_id_seq; Type: SEQUENCE SET; Schema: cinema; Owner: root
--

SELECT pg_catalog.setval('cinema.order_id_seq', 1, false);


--
-- Name: order_status_id_seq; Type: SEQUENCE SET; Schema: cinema; Owner: root
--

SELECT pg_catalog.setval('cinema.order_status_id_seq', 1, false);


--
-- Name: places_id_seq; Type: SEQUENCE SET; Schema: cinema; Owner: root
--

SELECT pg_catalog.setval('cinema.places_id_seq', 1, false);


--
-- Name: table_name_id_seq; Type: SEQUENCE SET; Schema: cinema; Owner: root
--

SELECT pg_catalog.setval('cinema.table_name_id_seq', 1, false);


--
-- Name: user_id_seq; Type: SEQUENCE SET; Schema: cinema; Owner: root
--

SELECT pg_catalog.setval('cinema.user_id_seq', 1, false);


--
-- Name: cost cost_pk; Type: CONSTRAINT; Schema: cinema; Owner: root
--

ALTER TABLE ONLY cinema.cost
    ADD CONSTRAINT cost_pk PRIMARY KEY (id);


--
-- Name: currency currency_pk; Type: CONSTRAINT; Schema: cinema; Owner: root
--

ALTER TABLE ONLY cinema.currency
    ADD CONSTRAINT currency_pk PRIMARY KEY (id);


--
-- Name: film film_pk; Type: CONSTRAINT; Schema: cinema; Owner: root
--

ALTER TABLE ONLY cinema.film
    ADD CONSTRAINT film_pk PRIMARY KEY (id);


--
-- Name: hall hall_pk; Type: CONSTRAINT; Schema: cinema; Owner: root
--

ALTER TABLE ONLY cinema.hall
    ADD CONSTRAINT hall_pk PRIMARY KEY (id);


--
-- Name: hall_places hall_places_pk; Type: CONSTRAINT; Schema: cinema; Owner: root
--

ALTER TABLE ONLY cinema.hall_places
    ADD CONSTRAINT hall_places_pk PRIMARY KEY (id);


--
-- Name: order order_pk; Type: CONSTRAINT; Schema: cinema; Owner: root
--

ALTER TABLE ONLY cinema."order"
    ADD CONSTRAINT order_pk PRIMARY KEY (id);


--
-- Name: order_status order_status_pk; Type: CONSTRAINT; Schema: cinema; Owner: root
--

ALTER TABLE ONLY cinema.order_status
    ADD CONSTRAINT order_status_pk PRIMARY KEY (id);


--
-- Name: places places_pk; Type: CONSTRAINT; Schema: cinema; Owner: root
--

ALTER TABLE ONLY cinema.places
    ADD CONSTRAINT places_pk PRIMARY KEY (id);


--
-- Name: cinema table_name_pk; Type: CONSTRAINT; Schema: cinema; Owner: root
--

ALTER TABLE ONLY cinema.cinema
    ADD CONSTRAINT table_name_pk PRIMARY KEY (id);


--
-- Name: user user_pk; Type: CONSTRAINT; Schema: cinema; Owner: root
--

ALTER TABLE ONLY cinema."user"
    ADD CONSTRAINT user_pk PRIMARY KEY (id);


--
-- Name: cost_id_uindex; Type: INDEX; Schema: cinema; Owner: root
--

CREATE UNIQUE INDEX cost_id_uindex ON cinema.cost USING btree (id);


--
-- Name: currency_id_uindex; Type: INDEX; Schema: cinema; Owner: root
--

CREATE UNIQUE INDEX currency_id_uindex ON cinema.currency USING btree (id);


--
-- Name: film_id_uindex; Type: INDEX; Schema: cinema; Owner: root
--

CREATE UNIQUE INDEX film_id_uindex ON cinema.film USING btree (id);


--
-- Name: hall_id_uindex; Type: INDEX; Schema: cinema; Owner: root
--

CREATE UNIQUE INDEX hall_id_uindex ON cinema.hall USING btree (id);


--
-- Name: hall_places_id_uindex; Type: INDEX; Schema: cinema; Owner: root
--

CREATE UNIQUE INDEX hall_places_id_uindex ON cinema.hall_places USING btree (id);


--
-- Name: order_id_uindex; Type: INDEX; Schema: cinema; Owner: root
--

CREATE UNIQUE INDEX order_id_uindex ON cinema."order" USING btree (id);


--
-- Name: order_status_id_uindex; Type: INDEX; Schema: cinema; Owner: root
--

CREATE UNIQUE INDEX order_status_id_uindex ON cinema.order_status USING btree (id);


--
-- Name: places_id_uindex; Type: INDEX; Schema: cinema; Owner: root
--

CREATE UNIQUE INDEX places_id_uindex ON cinema.places USING btree (id);


--
-- Name: table_name_id_uindex; Type: INDEX; Schema: cinema; Owner: root
--

CREATE UNIQUE INDEX table_name_id_uindex ON cinema.cinema USING btree (id);


--
-- Name: user_id_uindex; Type: INDEX; Schema: cinema; Owner: root
--

CREATE UNIQUE INDEX user_id_uindex ON cinema."user" USING btree (id);


--
-- Name: cost cost_currency_id_fk; Type: FK CONSTRAINT; Schema: cinema; Owner: root
--

ALTER TABLE ONLY cinema.cost
    ADD CONSTRAINT cost_currency_id_fk FOREIGN KEY (currency_id) REFERENCES cinema.currency(id);


--
-- Name: hall hall_cinema_id_fk; Type: FK CONSTRAINT; Schema: cinema; Owner: root
--

ALTER TABLE ONLY cinema.hall
    ADD CONSTRAINT hall_cinema_id_fk FOREIGN KEY (cinema_id) REFERENCES cinema.cinema(id);


--
-- Name: hall_places hall_places_cost_id_fk; Type: FK CONSTRAINT; Schema: cinema; Owner: root
--

ALTER TABLE ONLY cinema.hall_places
    ADD CONSTRAINT hall_places_cost_id_fk FOREIGN KEY (cost_id) REFERENCES cinema.cost(id);


--
-- Name: hall_places hall_places_film_id_fk; Type: FK CONSTRAINT; Schema: cinema; Owner: root
--

ALTER TABLE ONLY cinema.hall_places
    ADD CONSTRAINT hall_places_film_id_fk FOREIGN KEY (film_id) REFERENCES cinema.film(id);


--
-- Name: hall_places hall_places_hall_id_fk; Type: FK CONSTRAINT; Schema: cinema; Owner: root
--

ALTER TABLE ONLY cinema.hall_places
    ADD CONSTRAINT hall_places_hall_id_fk FOREIGN KEY (hall_id) REFERENCES cinema.hall(id);


--
-- Name: hall_places hall_places_places_id_fk; Type: FK CONSTRAINT; Schema: cinema; Owner: root
--

ALTER TABLE ONLY cinema.hall_places
    ADD CONSTRAINT hall_places_places_id_fk FOREIGN KEY (place_id) REFERENCES cinema.places(id);


--
-- Name: order order_hall_places_id_fk; Type: FK CONSTRAINT; Schema: cinema; Owner: root
--

ALTER TABLE ONLY cinema."order"
    ADD CONSTRAINT order_hall_places_id_fk FOREIGN KEY (hall_places_id) REFERENCES cinema.hall_places(id);


--
-- Name: order order_order_status_id_fk; Type: FK CONSTRAINT; Schema: cinema; Owner: root
--

ALTER TABLE ONLY cinema."order"
    ADD CONSTRAINT order_order_status_id_fk FOREIGN KEY (status_id) REFERENCES cinema.order_status(id);


--
-- Name: order order_user_id_fk; Type: FK CONSTRAINT; Schema: cinema; Owner: root
--

ALTER TABLE ONLY cinema."order"
    ADD CONSTRAINT order_user_id_fk FOREIGN KEY (user_id) REFERENCES cinema."user"(id);


--
-- PostgreSQL database dump complete
--

