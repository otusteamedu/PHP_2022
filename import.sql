CREATE DATABASE "cinema_busines";

CREATE TABLE "type_price"
(
    "id" serial NOT NULL PRIMARY KEY,
    "name" varchar(250) NOT NULL,
    "description" varchar(2000),
    "cost" integer NOT NULL,
)

CREATE TABLE "film"
(
    "uuid" serial NOT NULL PRIMARY KEY,
    "name" varchar(250) NOT NULL,
    "description" varchar(2000),
    "film_time" integer NOT NULL,
    "rating" integer NOT NULL,
    "date_start" TIMESTAMP NOT NULL,
    "date_end" TIMESTAMP NOT NULL
)

CREATE TABLE "cinema_hall"
(
    "id" serial NOT NULL PRIMARY KEY,
    "name" varchar(250) NOT NULL,
    "description" varchar(2000),
    "max_places" integer NOT NULL
)

CREATE TABLE "cinema_sessions"
(
    "uuid" serial NOT NULL PRIMARY KEY,
    "film_uuid" serial NOT NULL,
    "date_time_start" TIMESTAMP NOT NULL,
    "cinema_hall_id" serial NOT NULL,
)

CREATE TABLE "cinema_hall_place"
(
    "uuid" serial NOT NULL PRIMARY KEY,
    "cinema_hall_id" serial NOT NULL,
    "cinema_sessions_uuid" serial NOT NULL
)

CREATE TABLE "tickets"
(
    "uuid" serial NOT NULL PRIMARY KEY,
    "cinema_session_uuid" serial NOT NULL,
    "cinema_hall_id" serial NOT NULL,
    "cinema_hall_place_id" serial NOT NULL,
    "type_price_id" serial NOT NULL
)

ALTER TABLE "cinema_sessions" ADD CONSTRAINT "cinema_sessions_fk0" FOREIGN KEY ("cinema_hall_id") REFERENCES "cinema_hall"("id");
ALTER TABLE "cinema_sessions" ADD CONSTRAINT "cinema_sessions_fk1" FOREIGN KEY ("film_uuid") REFERENCES "film"("uuid");

ALTER TABLE "tickets" ADD CONSTRAINT "tickets_fk0" FOREIGN KEY ("cinema_session_uuid") REFERENCES "cinema_sessions"("uuid");
ALTER TABLE "tickets" ADD CONSTRAINT "tickets_fk1" FOREIGN KEY ("cinema_hall_place_id") REFERENCES "cinema_hall_place"("uuid");
ALTER TABLE "tickets" ADD CONSTRAINT "tickets_fk2" FOREIGN KEY ("type_price_id") REFERENCES "type_price"("id");

ALTER TABLE "cinema_hall_place" ADD CONSTRAINT "cinema_hall_place_fk0" FOREIGN KEY ("cinema_hall_id") REFERENCES "cinema_hall"("id");
ALTER TABLE "cinema_hall_place" ADD CONSTRAINT "cinema_hall_place_fk1" FOREIGN KEY ("cinema_session_uuid") REFERENCES "cinema_session"("uuid");
