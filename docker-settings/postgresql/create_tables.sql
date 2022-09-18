CREATE TABLE "cinema_hall"
(
    "id"   serial       NOT NULL,
    "name" VARCHAR(255) NOT NULL,
    CONSTRAINT "cinema_hall_pk" PRIMARY KEY ("id")
) WITH (
    OIDS = FALSE
);

CREATE TABLE "movie"
(
    "id"           serial       NOT NULL,
    "name"         VARCHAR(150) NOT NULL,
    "description"  TEXT         NOT NULL,
    "release_date" DATE         NOT NULL,
    "duration"     DECIMAL      NOT NULL,
    "price"        DECIMAL      NOT NULL,
    CONSTRAINT "movie_pk" PRIMARY KEY ("id")
) WITH (
    OIDS = FALSE
);

CREATE TABLE "ticket"
(
    "id"           serial       NOT NULL,
    "date_of_sale" DATE         NOT NULL,
    "time_of_sale" TIME         NOT NULL,
    "customer_id"  integer      NOT NULL,
    "schedule_id"  integer      NOT NULL,
    "total_price"  DECIMAL      NOT NULL,
    "movie_name"    VARCHAR(255) NOT NULL,
    CONSTRAINT "ticket_pk" PRIMARY KEY ("id")
) WITH (
    OIDS = FALSE
);

CREATE TABLE "session"
(
    "id"             serial  NOT NULL,
    "name"           TEXT    NOT NULL,
    "movie_id"        integer NOT NULL,
    "cinema_hall_id" integer NOT NULL,
    "price"          DECIMAL NOT NULL,
    CONSTRAINT "session_pk" PRIMARY KEY ("id")
) WITH (
    OIDS = FALSE
);

CREATE TABLE "customer"
(
    "id"      serial       NOT NULL,
    "name"    VARCHAR(150) NOT NULL,
    "surname" VARCHAR(150) NOT NULL,
    "email"   VARCHAR(150) NOT NULL,
    "phone"   VARCHAR(255) NOT NULL,
    CONSTRAINT "customer_pk" PRIMARY KEY ("id")
) WITH (
    OIDS = FALSE
);

CREATE TABLE "schedule"
(
    "id"                 serial  NOT NULL,
    "session_id"         integer NOT NULL,
    "start_date_session" DATE    NOT NULL,
    "start_time_session" TIME    NOT NULL,
    CONSTRAINT "schedule_pk" PRIMARY KEY ("id")
) WITH (
    OIDS = FALSE
);

CREATE TABLE "occupied_cinema_hall_seats"
(
    "id"             serial  NOT NULL,
    "ticket_id"      integer NOT NULL,
    "cinema_hall_id" integer NOT NULL,
    "row"            integer NOT NULL,
    "place"          integer NOT NULL,
    CONSTRAINT "occupied_cinema_hall_seats_pk" PRIMARY KEY ("id")
) WITH (
    OIDS = FALSE
);

CREATE TABLE "cinema_hall_configuration"
(
    "id"             serial  NOT NULL,
    "cinema_hall_id" integer NOT NULL,
    "row"            integer NOT NULL,
    "places_in_row"  integer NOT NULL,
    CONSTRAINT "cinema_hall_configuration_pk" PRIMARY KEY ("id")
) WITH (
    OIDS = FALSE
);

ALTER TABLE "ticket"
    ADD CONSTRAINT "ticket_fk0" FOREIGN KEY ("customer_id") REFERENCES "customer" ("id");
ALTER TABLE "ticket"
    ADD CONSTRAINT "ticket_fk1" FOREIGN KEY ("schedule_id") REFERENCES "schedule" ("id");

ALTER TABLE "session"
    ADD CONSTRAINT "session_fk0" FOREIGN KEY ("movie_id") REFERENCES "movie" ("id");
ALTER TABLE "session"
    ADD CONSTRAINT "session_fk1" FOREIGN KEY ("cinema_hall_id") REFERENCES "cinema_hall" ("id");

ALTER TABLE "schedule"
    ADD CONSTRAINT "schedule_fk0" FOREIGN KEY ("session_id") REFERENCES "session" ("id");

ALTER TABLE "occupied_cinema_hall_seats"
    ADD CONSTRAINT "occupied_cinema_hall_seats_fk0" FOREIGN KEY ("ticket_id") REFERENCES "ticket" ("id");
ALTER TABLE "occupied_cinema_hall_seats"
    ADD CONSTRAINT "occupied_cinema_hall_seats_fk1" FOREIGN KEY ("cinema_hall_id") REFERENCES "cinema_hall" ("id");

ALTER TABLE "cinema_hall_configuration"
    ADD CONSTRAINT "cinema_hall_configuration_fk0" FOREIGN KEY ("cinema_hall_id") REFERENCES "cinema_hall" ("id");