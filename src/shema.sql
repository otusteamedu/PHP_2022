CREATE TABLE public.halls
(
    "id"   serial       NOT NULL,
    "name" VARCHAR(255) NOT NULL UNIQUE,
    CONSTRAINT "halls_pk" PRIMARY KEY ("id")
) WITH (
      OIDS = FALSE
      );

CREATE TABLE public.sessions
(
    "id"       serial    NOT NULL,
    "movie_id" integer   NOT NULL,
    "hall_id"  integer   NOT NULL,
    "start_at" TIMESTAMP NOT NULL,
    "end_at"   TIMESTAMP NOT NULL,
    "markup"   DECIMAL   NOT NULL,
    CONSTRAINT "sessions_pk" PRIMARY KEY ("id")
) WITH (
      OIDS = FALSE
      );


CREATE TABLE public.movies
(
    "id"           serial       NOT NULL,
    "name"         VARCHAR(255) NOT NULL,
    "duration"     TIME         NOT NULL,
    "rental_price" DECIMAL      NOT NULL,
    CONSTRAINT "movies_pk" PRIMARY KEY ("id")
) WITH (
      OIDS = FALSE
      );


CREATE TABLE public.tickets
(
    "id"      serial  NOT NULL,
    "price"   DECIMAL NOT NULL,
    "seat_id" integer NOT NULL,
    CONSTRAINT "tickets_pk" PRIMARY KEY ("id")
) WITH (
      OIDS = FALSE
      );


CREATE TABLE public.session_ticket
(
    "session_id" integer NOT NULL,
    "ticket_id"  integer NOT NULL
) WITH (
      OIDS = FALSE
      );


CREATE TABLE public.rows
(
    "id"      serial  NOT NULL,
    "hall_id" integer NOT NULL,
    "number"  integer NOT NULL,
    CONSTRAINT "rows_pk" PRIMARY KEY ("id")
) WITH (
      OIDS = FALSE
      );


CREATE TABLE public.seats
(
    "id"     serial  NOT NULL,
    "number" integer NOT NULL,
    "row_id" integer NOT NULL,
    CONSTRAINT "seats_pk" PRIMARY KEY ("id")
) WITH (
      OIDS = FALSE
      );


CREATE TABLE
    public.attributes
(
    id                serial NOT NULL,
    name              character varying(50) NULL,
    attribute_type_id integer NULL
);

CREATE TABLE
    public.attribute_type
(
    id   serial NOT NULL,
    type character varying(50) NULL
);

CREATE TABLE
    public.attribute_value
(
    movie_id      integer NOT NULL,
    attribute_id  integer NOT NULL,
    value_integer integer NULL,
    value_text    text NULL,
    value_boolean boolean NULL,
    value_date    date NULL
);



ALTER TABLE public.sessions
    ADD CONSTRAINT sessions_fk0 FOREIGN KEY ("movie_id") REFERENCES public.movies ("id");

ALTER TABLE public.sessions
    ADD CONSTRAINT sessions_fk1 FOREIGN KEY ("hall_id") REFERENCES public.halls ("id");


ALTER TABLE public.tickets
    ADD CONSTRAINT tickets_fk0 FOREIGN KEY ("seat_id") REFERENCES public.seats ("id");

ALTER TABLE public.session_ticket
    ADD CONSTRAINT session_ticket_fk0 FOREIGN KEY ("session_id") REFERENCES public.sessions ("id");
ALTER TABLE public.session_ticket
    ADD CONSTRAINT session_ticket_fk1 FOREIGN KEY ("ticket_id") REFERENCES public.tickets ("id");

ALTER TABLE public.rows
    ADD CONSTRAINT rows_fk0 FOREIGN KEY ("hall_id") REFERENCES public.halls ("id");

ALTER TABLE public.seats
    ADD CONSTRAINT seats_fk0 FOREIGN KEY ("row_id") REFERENCES public.rows ("id");

ALTER TABLE public.attribute_type
    ADD CONSTRAINT attribute_type_pkey PRIMARY KEY (id);


ALTER TABLE public.attributes
    ADD CONSTRAINT attributes_pkey PRIMARY KEY (id);

ALTER TABLE public.attributes
    ADD CONSTRAINT attributes_fk0 FOREIGN KEY (attribute_type_id) REFERENCES public.attribute_type (id);

ALTER TABLE
    public.attribute_value
    ADD
        CONSTRAINT attribute_value_fk0 FOREIGN KEY (attribute_id) REFERENCES public.attributes ("id");

ALTER TABLE
    public.attribute_value
    ADD
        CONSTRAINT attribute_value_fk1 FOREIGN KEY (movie_id) REFERENCES public.movies ("id");






