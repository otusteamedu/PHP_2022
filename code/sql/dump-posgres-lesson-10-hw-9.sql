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
-- Name: lesson; Type: SCHEMA; Schema: -; Owner: root
--

CREATE SCHEMA lesson;


ALTER SCHEMA lesson OWNER TO root;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- Name: films_attributes; Type: TABLE; Schema: lesson; Owner: root
--

CREATE TABLE lesson.films_attributes (
    id integer NOT NULL,
    name character varying(100),
    type_id integer
);


ALTER TABLE lesson.films_attributes OWNER TO root;

--
-- Name: attributes_id_seq; Type: SEQUENCE; Schema: lesson; Owner: root
--

CREATE SEQUENCE lesson.attributes_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE lesson.attributes_id_seq OWNER TO root;

--
-- Name: attributes_id_seq; Type: SEQUENCE OWNED BY; Schema: lesson; Owner: root
--

ALTER SEQUENCE lesson.attributes_id_seq OWNED BY lesson.films_attributes.id;


--
-- Name: films_attributes_type; Type: TABLE; Schema: lesson; Owner: root
--

CREATE TABLE lesson.films_attributes_type (
    id integer NOT NULL,
    name character varying(100)
);


ALTER TABLE lesson.films_attributes_type OWNER TO root;

--
-- Name: attributes_type_id_seq; Type: SEQUENCE; Schema: lesson; Owner: root
--

CREATE SEQUENCE lesson.attributes_type_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE lesson.attributes_type_id_seq OWNER TO root;

--
-- Name: attributes_type_id_seq; Type: SEQUENCE OWNED BY; Schema: lesson; Owner: root
--

ALTER SEQUENCE lesson.attributes_type_id_seq OWNED BY lesson.films_attributes_type.id;


--
-- Name: films; Type: TABLE; Schema: lesson; Owner: root
--

CREATE TABLE lesson.films (
    id integer NOT NULL,
    name character varying(100)
);


ALTER TABLE lesson.films OWNER TO root;

--
-- Name: films_id_seq; Type: SEQUENCE; Schema: lesson; Owner: root
--

CREATE SEQUENCE lesson.films_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE lesson.films_id_seq OWNER TO root;

--
-- Name: films_id_seq; Type: SEQUENCE OWNED BY; Schema: lesson; Owner: root
--

ALTER SEQUENCE lesson.films_id_seq OWNED BY lesson.films.id;


--
-- Name: films_values; Type: TABLE; Schema: lesson; Owner: root
--

CREATE TABLE lesson.films_values (
    id integer NOT NULL,
    val_text character varying,
    film_id integer,
    attr integer,
    val_number numeric(2,0),
    val_date date,
    val_bool boolean,
    val_uuid uuid
);


ALTER TABLE lesson.films_values OWNER TO root;

--
-- Name: values_id_seq; Type: SEQUENCE; Schema: lesson; Owner: root
--

CREATE SEQUENCE lesson.values_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE lesson.values_id_seq OWNER TO root;

--
-- Name: values_id_seq; Type: SEQUENCE OWNED BY; Schema: lesson; Owner: root
--

ALTER SEQUENCE lesson.values_id_seq OWNED BY lesson.films_values.id;


--
-- Name: films id; Type: DEFAULT; Schema: lesson; Owner: root
--

ALTER TABLE ONLY lesson.films ALTER COLUMN id SET DEFAULT nextval('lesson.films_id_seq'::regclass);


--
-- Name: films_attributes id; Type: DEFAULT; Schema: lesson; Owner: root
--

ALTER TABLE ONLY lesson.films_attributes ALTER COLUMN id SET DEFAULT nextval('lesson.attributes_id_seq'::regclass);


--
-- Name: films_attributes_type id; Type: DEFAULT; Schema: lesson; Owner: root
--

ALTER TABLE ONLY lesson.films_attributes_type ALTER COLUMN id SET DEFAULT nextval('lesson.attributes_type_id_seq'::regclass);


--
-- Name: films_values id; Type: DEFAULT; Schema: lesson; Owner: root
--

ALTER TABLE ONLY lesson.films_values ALTER COLUMN id SET DEFAULT nextval('lesson.values_id_seq'::regclass);


--
-- Data for Name: films; Type: TABLE DATA; Schema: lesson; Owner: root
--

COPY lesson.films (id, name) FROM stdin;
1	Титаник
\.


--
-- Data for Name: films_attributes; Type: TABLE DATA; Schema: lesson; Owner: root
--

COPY lesson.films_attributes (id, name, type_id) FROM stdin;
2	Отзыв неизвестной киноакадемии	2
1	Pецензии критиков	2
4	Дата запускать рекламы	1
6	Мировая премьера	2
7	Премьера в US	2
5	Дата начала продажи билетов	2
8	Стоимость фильма	3
3	Дата запуска рекламы в US	1
9	Подтверждение	4
\.


--
-- Data for Name: films_attributes_type; Type: TABLE DATA; Schema: lesson; Owner: root
--

COPY lesson.films_attributes_type (id, name) FROM stdin;
1	Дата
2	Текст
4	Bool
3	UUID
\.


--
-- Data for Name: films_values; Type: TABLE DATA; Schema: lesson; Owner: root
--

COPY lesson.films_values (id, val_text, film_id, attr, val_number, val_date, val_bool, val_uuid) FROM stdin;
1	Нет критики по фильму все ок!	1	1	\N	\N	\N	\N
2	«Оскар» в 14 номинациях	1	2	\N	\N	\N	\N
3	\N	1	8	\N	2022-05-04	\N	\N
4	\N	1	9	\N	\N	t	\N
5	\N	1	4	\N	\N	\N	e897baa6-cbc3-11ec-9d64-0242ac120002
\.


--
-- Name: attributes_id_seq; Type: SEQUENCE SET; Schema: lesson; Owner: root
--

SELECT pg_catalog.setval('lesson.attributes_id_seq', 9, true);


--
-- Name: attributes_type_id_seq; Type: SEQUENCE SET; Schema: lesson; Owner: root
--

SELECT pg_catalog.setval('lesson.attributes_type_id_seq', 4, true);


--
-- Name: films_id_seq; Type: SEQUENCE SET; Schema: lesson; Owner: root
--

SELECT pg_catalog.setval('lesson.films_id_seq', 1, true);


--
-- Name: values_id_seq; Type: SEQUENCE SET; Schema: lesson; Owner: root
--

SELECT pg_catalog.setval('lesson.values_id_seq', 5, true);


--
-- Name: films_attributes attributes_pk; Type: CONSTRAINT; Schema: lesson; Owner: root
--

ALTER TABLE ONLY lesson.films_attributes
    ADD CONSTRAINT attributes_pk PRIMARY KEY (id);


--
-- Name: films_attributes_type attributes_type_pk; Type: CONSTRAINT; Schema: lesson; Owner: root
--

ALTER TABLE ONLY lesson.films_attributes_type
    ADD CONSTRAINT attributes_type_pk PRIMARY KEY (id);


--
-- Name: films films_pk; Type: CONSTRAINT; Schema: lesson; Owner: root
--

ALTER TABLE ONLY lesson.films
    ADD CONSTRAINT films_pk PRIMARY KEY (id);


--
-- Name: films_values values_pk; Type: CONSTRAINT; Schema: lesson; Owner: root
--

ALTER TABLE ONLY lesson.films_values
    ADD CONSTRAINT values_pk PRIMARY KEY (id);


--
-- Name: attributes_id_uindex; Type: INDEX; Schema: lesson; Owner: root
--

CREATE UNIQUE INDEX attributes_id_uindex ON lesson.films_attributes USING btree (id);


--
-- Name: attributes_type_id_uindex; Type: INDEX; Schema: lesson; Owner: root
--

CREATE UNIQUE INDEX attributes_type_id_uindex ON lesson.films_attributes_type USING btree (id);


--
-- Name: films_id_uindex; Type: INDEX; Schema: lesson; Owner: root
--

CREATE UNIQUE INDEX films_id_uindex ON lesson.films USING btree (id);


--
-- Name: values_id_uindex; Type: INDEX; Schema: lesson; Owner: root
--

CREATE UNIQUE INDEX values_id_uindex ON lesson.films_values USING btree (id);


--
-- Name: films_attributes films_attributes_films_attributes_type_id_fk; Type: FK CONSTRAINT; Schema: lesson; Owner: root
--

ALTER TABLE ONLY lesson.films_attributes
    ADD CONSTRAINT films_attributes_films_attributes_type_id_fk FOREIGN KEY (type_id) REFERENCES lesson.films_attributes_type(id);


--
-- Name: films_values films_values_films_attributes_id_fk; Type: FK CONSTRAINT; Schema: lesson; Owner: root
--

ALTER TABLE ONLY lesson.films_values
    ADD CONSTRAINT films_values_films_attributes_id_fk FOREIGN KEY (attr) REFERENCES lesson.films_attributes(id);


--
-- Name: films_values films_values_films_id_fk; Type: FK CONSTRAINT; Schema: lesson; Owner: root
--

ALTER TABLE ONLY lesson.films_values
    ADD CONSTRAINT films_values_films_id_fk FOREIGN KEY (film_id) REFERENCES lesson.films(id);


--
-- PostgreSQL database dump complete
--

