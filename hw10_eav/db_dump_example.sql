--
-- PostgreSQL database dump
--

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET client_min_messages = warning;
SET row_security = off;

--
-- TOC entry 3 (class 2615 OID 2200)
-- Name: public; Type: SCHEMA; Schema: -; Owner: postgres
--

CREATE SCHEMA public;

ALTER SCHEMA public OWNER TO postgres;

--
-- TOC entry 2953 (class 0 OID 0)
-- Dependencies: 3
-- Name: SCHEMA public; Type: COMMENT; Schema: -; Owner: postgres
--

COMMENT ON SCHEMA public IS 'standard public schema';

SET default_tablespace = '';

SET default_with_oids = false;

--
-- TOC entry 199 (class 1259 OID 16416)
-- Name: tFilmAttrType; Type: TABLE; Schema: public; Owner: usr2
--

CREATE TABLE public."tFilmAttrType" (
                                        id integer NOT NULL,
                                        name character varying(60) NOT NULL,
                                        comment text DEFAULT ''::text NOT NULL
);


ALTER TABLE public."tFilmAttrType" OWNER TO usr2;

--
-- TOC entry 198 (class 1259 OID 16414)
-- Name: FilmAttrType_id_seq; Type: SEQUENCE; Schema: public; Owner: usr2
--

CREATE SEQUENCE public."FilmAttrType_id_seq"
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;

ALTER TABLE public."FilmAttrType_id_seq" OWNER TO usr2;

--
-- TOC entry 2954 (class 0 OID 0)
-- Dependencies: 198
-- Name: FilmAttrType_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: usr2
--

ALTER SEQUENCE public."FilmAttrType_id_seq" OWNED BY public."tFilmAttrType".id;

--
-- TOC entry 201 (class 1259 OID 16430)
-- Name: tFilmAttr; Type: TABLE; Schema: public; Owner: usr2
--

CREATE TABLE public."tFilmAttr" (
                                    id integer NOT NULL,
                                    name character varying(60) NOT NULL,
                                    type integer NOT NULL
);

ALTER TABLE public."tFilmAttr" OWNER TO usr2;

--
-- TOC entry 203 (class 1259 OID 16445)
-- Name: tFilmAttrValues; Type: TABLE; Schema: public; Owner: usr2
--

CREATE TABLE public."tFilmAttrValues" (
                                          id integer NOT NULL,
                                          attr integer NOT NULL,
                                          val_date date,
                                          val_text character varying,
                                          val_num numeric(2,0),
                                          film smallint NOT NULL
);

ALTER TABLE public."tFilmAttrValues" OWNER TO usr2;

--
-- TOC entry 202 (class 1259 OID 16443)
-- Name: tFilmAttrValues_id_seq; Type: SEQUENCE; Schema: public; Owner: usr2
--

CREATE SEQUENCE public."tFilmAttrValues_id_seq"
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;

ALTER TABLE public."tFilmAttrValues_id_seq" OWNER TO usr2;

--
-- TOC entry 2955 (class 0 OID 0)
-- Dependencies: 202
-- Name: tFilmAttrValues_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: usr2
--

ALTER SEQUENCE public."tFilmAttrValues_id_seq" OWNED BY public."tFilmAttrValues".id;

--
-- TOC entry 200 (class 1259 OID 16428)
-- Name: tFilmAttr_id_seq; Type: SEQUENCE; Schema: public; Owner: usr2
--

CREATE SEQUENCE public."tFilmAttr_id_seq"
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;

ALTER TABLE public."tFilmAttr_id_seq" OWNER TO usr2;

--
-- TOC entry 2956 (class 0 OID 0)
-- Dependencies: 200
-- Name: tFilmAttr_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: usr2
--

ALTER SEQUENCE public."tFilmAttr_id_seq" OWNED BY public."tFilmAttr".id;

--
-- TOC entry 197 (class 1259 OID 16402)
-- Name: tFilms; Type: TABLE; Schema: public; Owner: usr2
--

CREATE TABLE public."tFilms" (
                                 id integer NOT NULL,
                                 name character varying(60) NOT NULL,
                                 comment text DEFAULT ''::text NOT NULL
);

ALTER TABLE public."tFilms" OWNER TO usr2;

--
-- TOC entry 196 (class 1259 OID 16400)
-- Name: tFilms_id_seq; Type: SEQUENCE; Schema: public; Owner: usr2
--

CREATE SEQUENCE public."tFilms_id_seq"
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;

ALTER TABLE public."tFilms_id_seq" OWNER TO usr2;

--
-- TOC entry 2957 (class 0 OID 0)
-- Dependencies: 196
-- Name: tFilms_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: usr2
--

ALTER SEQUENCE public."tFilms_id_seq" OWNED BY public."tFilms".id;

--
-- TOC entry 2800 (class 2604 OID 16433)
-- Name: tFilmAttr id; Type: DEFAULT; Schema: public; Owner: usr2
--

ALTER TABLE ONLY public."tFilmAttr" ALTER COLUMN id SET DEFAULT nextval('public."tFilmAttr_id_seq"'::regclass);

--
-- TOC entry 2798 (class 2604 OID 16419)
-- Name: tFilmAttrType id; Type: DEFAULT; Schema: public; Owner: usr2
--

ALTER TABLE ONLY public."tFilmAttrType" ALTER COLUMN id SET DEFAULT nextval('public."FilmAttrType_id_seq"'::regclass);

--
-- TOC entry 2801 (class 2604 OID 16448)
-- Name: tFilmAttrValues id; Type: DEFAULT; Schema: public; Owner: usr2
--

ALTER TABLE ONLY public."tFilmAttrValues" ALTER COLUMN id SET DEFAULT nextval('public."tFilmAttrValues_id_seq"'::regclass);

--
-- TOC entry 2796 (class 2604 OID 16405)
-- Name: tFilms id; Type: DEFAULT; Schema: public; Owner: usr2
--

ALTER TABLE ONLY public."tFilms" ALTER COLUMN id SET DEFAULT nextval('public."tFilms_id_seq"'::regclass);

--
-- TOC entry 2945 (class 0 OID 16430)
-- Dependencies: 201
-- Data for Name: tFilmAttr; Type: TABLE DATA; Schema: public; Owner: usr2
--

INSERT INTO public."tFilmAttr" VALUES (1, 'Когда премьера', 1);
INSERT INTO public."tFilmAttr" VALUES (2, 'Ведущий актер', 2);
INSERT INTO public."tFilmAttr" VALUES (3, 'Стоимость проката', 3);

--
-- TOC entry 2943 (class 0 OID 16416)
-- Dependencies: 199
-- Data for Name: tFilmAttrType; Type: TABLE DATA; Schema: public; Owner: usr2
--

INSERT INTO public."tFilmAttrType" VALUES (1, 'Дата', '');
INSERT INTO public."tFilmAttrType" VALUES (2, 'Текст', '');
INSERT INTO public."tFilmAttrType" VALUES (3, 'Сумма', '');

--
-- TOC entry 2947 (class 0 OID 16445)
-- Dependencies: 203
-- Data for Name: tFilmAttrValues; Type: TABLE DATA; Schema: public; Owner: usr2
--

INSERT INTO public."tFilmAttrValues" VALUES (1, 1, '2019-07-15', NULL, NULL, 1);
INSERT INTO public."tFilmAttrValues" VALUES (2, 2, NULL, 'Актёр', NULL, 1);
INSERT INTO public."tFilmAttrValues" VALUES (3, 3, NULL, '', 1, 1);

--
-- TOC entry 2941 (class 0 OID 16402)
-- Dependencies: 197
-- Data for Name: tFilms; Type: TABLE DATA; Schema: public; Owner: usr2
--

INSERT INTO public."tFilms" VALUES (1, 'Белое солнце', '');

--
-- TOC entry 2958 (class 0 OID 0)
-- Dependencies: 198
-- Name: FilmAttrType_id_seq; Type: SEQUENCE SET; Schema: public; Owner: usr2
--

SELECT pg_catalog.setval('public."FilmAttrType_id_seq"', 3, true);

--
-- TOC entry 2959 (class 0 OID 0)
-- Dependencies: 202
-- Name: tFilmAttrValues_id_seq; Type: SEQUENCE SET; Schema: public; Owner: usr2
--

SELECT pg_catalog.setval('public."tFilmAttrValues_id_seq"', 3, true);

--
-- TOC entry 2960 (class 0 OID 0)
-- Dependencies: 200
-- Name: tFilmAttr_id_seq; Type: SEQUENCE SET; Schema: public; Owner: usr2
--

SELECT pg_catalog.setval('public."tFilmAttr_id_seq"', 3, true);

--
-- TOC entry 2961 (class 0 OID 0)
-- Dependencies: 196
-- Name: tFilms_id_seq; Type: SEQUENCE SET; Schema: public; Owner: usr2
--

SELECT pg_catalog.setval('public."tFilms_id_seq"', 1, true);

--
-- TOC entry 2807 (class 2606 OID 16425)
-- Name: tFilmAttrType filmattrtype_pk; Type: CONSTRAINT; Schema: public; Owner: usr2
--

ALTER TABLE ONLY public."tFilmAttrType"
    ADD CONSTRAINT filmattrtype_pk PRIMARY KEY (id);

--
-- TOC entry 2809 (class 2606 OID 16427)
-- Name: tFilmAttrType filmattrtype_un; Type: CONSTRAINT; Schema: public; Owner: usr2
--

ALTER TABLE ONLY public."tFilmAttrType"
    ADD CONSTRAINT filmattrtype_un UNIQUE (name);

--
-- TOC entry 2811 (class 2606 OID 16435)
-- Name: tFilmAttr tfilmattr_pk; Type: CONSTRAINT; Schema: public; Owner: usr2
--

ALTER TABLE ONLY public."tFilmAttr"
    ADD CONSTRAINT tfilmattr_pk PRIMARY KEY (id);

--
-- TOC entry 2813 (class 2606 OID 16437)
-- Name: tFilmAttr tfilmattr_un; Type: CONSTRAINT; Schema: public; Owner: usr2
--

ALTER TABLE ONLY public."tFilmAttr"
    ADD CONSTRAINT tfilmattr_un UNIQUE (name);

--
-- TOC entry 2815 (class 2606 OID 16453)
-- Name: tFilmAttrValues tfilmattrvalues_pk; Type: CONSTRAINT; Schema: public; Owner: usr2
--

ALTER TABLE ONLY public."tFilmAttrValues"
    ADD CONSTRAINT tfilmattrvalues_pk PRIMARY KEY (id);

--
-- TOC entry 2803 (class 2606 OID 16411)
-- Name: tFilms tfilms_pk; Type: CONSTRAINT; Schema: public; Owner: usr2
--

ALTER TABLE ONLY public."tFilms"
    ADD CONSTRAINT tfilms_pk PRIMARY KEY (id);

--
-- TOC entry 2805 (class 2606 OID 16413)
-- Name: tFilms tfilms_un; Type: CONSTRAINT; Schema: public; Owner: usr2
--

ALTER TABLE ONLY public."tFilms"
    ADD CONSTRAINT tfilms_un UNIQUE (name);

--
-- TOC entry 2816 (class 2606 OID 16438)
-- Name: tFilmAttr tfilmattr_fk; Type: FK CONSTRAINT; Schema: public; Owner: usr2
--

ALTER TABLE ONLY public."tFilmAttr"
    ADD CONSTRAINT tfilmattr_fk FOREIGN KEY (type) REFERENCES public."tFilmAttrType"(id) ON UPDATE CASCADE ON DELETE RESTRICT;

--
-- TOC entry 2817 (class 2606 OID 16454)
-- Name: tFilmAttrValues tfilmattrvalues_fk; Type: FK CONSTRAINT; Schema: public; Owner: usr2
--

ALTER TABLE ONLY public."tFilmAttrValues"
    ADD CONSTRAINT tfilmattrvalues_fk FOREIGN KEY (attr) REFERENCES public."tFilmAttr"(id) ON UPDATE CASCADE ON DELETE RESTRICT;

--
-- TOC entry 2818 (class 2606 OID 16483)
-- Name: tFilmAttrValues tfilmattrvalues_fk2; Type: FK CONSTRAINT; Schema: public; Owner: usr2
--

ALTER TABLE ONLY public."tFilmAttrValues"
    ADD CONSTRAINT tfilmattrvalues_fk2 FOREIGN KEY (film) REFERENCES public."tFilms"(id) ON UPDATE CASCADE ON DELETE RESTRICT;

--
-- PostgreSQL database dump complete
--