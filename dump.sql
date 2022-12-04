--
-- PostgreSQL database dump
--

-- Dumped from database version 13.3
-- Dumped by pg_dump version 13.3

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

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- Name: attribute_types; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.attribute_types (
                                        id integer NOT NULL,
                                        name character varying(20) NOT NULL
);


ALTER TABLE public.attribute_types OWNER TO postgres;

--
-- Name: attribute_types_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.attribute_types_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.attribute_types_id_seq OWNER TO postgres;

--
-- Name: attribute_types_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.attribute_types_id_seq OWNED BY public.attribute_types.id;


--
-- Name: attributes; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.attributes (
                                   id integer NOT NULL,
                                   type_id integer NOT NULL,
                                   name character varying(255) NOT NULL
);


ALTER TABLE public.attributes OWNER TO postgres;

--
-- Name: attributes_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.attributes_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.attributes_id_seq OWNER TO postgres;

--
-- Name: attributes_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.attributes_id_seq OWNED BY public.attributes.id;


--
-- Name: films; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.films (
                              id integer NOT NULL,
                              name character varying(255) NOT NULL
);


ALTER TABLE public.films OWNER TO postgres;

--
-- Name: films_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.films_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.films_id_seq OWNER TO postgres;

--
-- Name: films_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.films_id_seq OWNED BY public.films.id;


--
-- Name: values; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public."values" (
                                 id integer NOT NULL,
                                 attribute_id integer NOT NULL,
                                 v_int integer,
                                 v_float numeric,
                                 v_boolean boolean,
                                 v_string text,
                                 v_datetime timestamp without time zone,
                                 film_id integer NOT NULL
);


ALTER TABLE public."values" OWNER TO postgres;

--
-- Name: values_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.values_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.values_id_seq OWNER TO postgres;

--
-- Name: values_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.values_id_seq OWNED BY public."values".id;


--
-- Name: attribute_types id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.attribute_types ALTER COLUMN id SET DEFAULT nextval('public.attribute_types_id_seq'::regclass);


--
-- Name: attributes id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.attributes ALTER COLUMN id SET DEFAULT nextval('public.attributes_id_seq'::regclass);


--
-- Name: films id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.films ALTER COLUMN id SET DEFAULT nextval('public.films_id_seq'::regclass);


--
-- Name: values id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public."values" ALTER COLUMN id SET DEFAULT nextval('public.values_id_seq'::regclass);


--
-- Data for Name: attribute_types; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.attribute_types VALUES (1, 'int');
INSERT INTO public.attribute_types VALUES (2, 'string');
INSERT INTO public.attribute_types VALUES (3, 'float');
INSERT INTO public.attribute_types VALUES (4, 'datetime');
INSERT INTO public.attribute_types VALUES (5, 'boolean');


--
-- Data for Name: attributes; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.attributes VALUES (4, 4, 'Начало продажи билетов');
INSERT INTO public.attributes VALUES (5, 4, 'Начало рекламы на ТВ');
INSERT INTO public.attributes VALUES (6, 3, 'Цена');
INSERT INTO public.attributes VALUES (7, 1, 'Максимальное количество показов в день');
INSERT INTO public.attributes VALUES (8, 1, 'Количество актеров');
INSERT INTO public.attributes VALUES (2, 5, 'Премия Ника');
INSERT INTO public.attributes VALUES (3, 5, 'Премия Оскар');
INSERT INTO public.attributes VALUES (1, 2, 'Рецензия критика');


--
-- Data for Name: films; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.films VALUES (1, 'Cinema 1');
INSERT INTO public.films VALUES (2, 'Cinema 2');
INSERT INTO public.films VALUES (3, 'Cinema 3');


--
-- Data for Name: values; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public."values" VALUES (1, 1, NULL, NULL, NULL, 'Рецензия на фильм 1', NULL, 1);
INSERT INTO public."values" VALUES (2, 2, NULL, NULL, true, NULL, NULL, 1);
INSERT INTO public."values" VALUES (3, 3, NULL, NULL, false, NULL, NULL, 1);
INSERT INTO public."values" VALUES (6, 6, NULL, 123.45, NULL, NULL, NULL, 1);
INSERT INTO public."values" VALUES (7, 7, 4, NULL, NULL, NULL, NULL, 1);
INSERT INTO public."values" VALUES (8, 8, 100, NULL, NULL, NULL, NULL, 1);
INSERT INTO public."values" VALUES (10, 2, NULL, NULL, true, NULL, NULL, 2);
INSERT INTO public."values" VALUES (11, 3, NULL, NULL, false, NULL, NULL, 2);
INSERT INTO public."values" VALUES (18, 2, NULL, NULL, true, NULL, NULL, 3);
INSERT INTO public."values" VALUES (19, 3, NULL, NULL, false, NULL, NULL, 3);
INSERT INTO public."values" VALUES (9, 1, NULL, NULL, NULL, 'Рецензия на фильм 2', NULL, 2);
INSERT INTO public."values" VALUES (12, 4, NULL, NULL, NULL, NULL, '2022-01-01 02:00:00', 2);
INSERT INTO public."values" VALUES (14, 6, NULL, 234.56, NULL, NULL, NULL, 2);
INSERT INTO public."values" VALUES (15, 7, 5, NULL, NULL, NULL, NULL, 2);
INSERT INTO public."values" VALUES (16, 8, 101, NULL, NULL, NULL, NULL, 2);
INSERT INTO public."values" VALUES (22, 6, NULL, 1231.45, NULL, NULL, NULL, 3);
INSERT INTO public."values" VALUES (23, 7, 6, NULL, NULL, NULL, NULL, 3);
INSERT INTO public."values" VALUES (13, 5, NULL, NULL, NULL, NULL, '2022-12-02 02:00:00', 2);
INSERT INTO public."values" VALUES (4, 4, NULL, NULL, NULL, NULL, '2022-12-02 00:00:00', 1);
INSERT INTO public."values" VALUES (20, 4, NULL, NULL, NULL, NULL, '2022-12-01 03:00:00', 3);
INSERT INTO public."values" VALUES (17, 1, NULL, NULL, NULL, 'Рецензия на фильм 3', '2022-12-02 02:21:00', 3);
INSERT INTO public."values" VALUES (5, 5, NULL, NULL, NULL, NULL, '2022-12-22 00:00:00', 1);


--
-- Name: attribute_types_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.attribute_types_id_seq', 5, true);


--
-- Name: attributes_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.attributes_id_seq', 8, true);


--
-- Name: films_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.films_id_seq', 3, true);


--
-- Name: values_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.values_id_seq', 24, true);


--
-- Name: attribute_types attribute_types_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.attribute_types
    ADD CONSTRAINT attribute_types_pkey PRIMARY KEY (id);


--
-- Name: attributes attributes_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.attributes
    ADD CONSTRAINT attributes_pkey PRIMARY KEY (id);


--
-- Name: films films_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.films
    ADD CONSTRAINT films_pkey PRIMARY KEY (id);


--
-- Name: values values_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public."values"
    ADD CONSTRAINT values_pkey PRIMARY KEY (id);


--
-- Name: attributes attributes_type_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.attributes
    ADD CONSTRAINT attributes_type_id_fkey FOREIGN KEY (type_id) REFERENCES public.attribute_types(id) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: values values_attribute_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public."values"
    ADD CONSTRAINT values_attribute_id_fkey FOREIGN KEY (attribute_id) REFERENCES public.attributes(id) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: values values_film_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public."values"
    ADD CONSTRAINT values_film_id_fkey FOREIGN KEY (film_id) REFERENCES public.films(id) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- PostgreSQL database dump complete
--
