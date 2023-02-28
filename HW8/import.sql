CREATE DATABASE "cinema";

CREATE SEQUENCE sequence_id INCREMENT 1 START 1;

CREATE TABLE "type_price"
(
    "id" serial NOT NULL PRIMARY KEY,
    "name" varchar(250) NOT NULL,
    "description" varchar(2000),
    "cost" DEC(10,2) NOT NULL
);

CREATE TABLE price_history(
    "id" SERIAL NOT NULL PRIMARY KEY,
    "type_price_id" serial NOT NULL,
    "date_time" TIMESTAMP NOT NULL,
    "price" DEC(10,2) NOT NULL
);

CREATE SEQUENCE serial START 1;

CREATE TABLE "film"
(
    "id" serial NOT NULL PRIMARY KEY,
    "name" varchar(250) NOT NULL,
    "description" varchar(2000),
    "film_time" integer NOT NULL,
    "rating" integer NOT NULL,
    "date_start" TIMESTAMP NOT NULL,
    "date_end" TIMESTAMP NOT NULL
);

CREATE TABLE "cinema_hall"
(
    "id" serial NOT NULL PRIMARY KEY,
    "name" varchar(250) NOT NULL,
    "description" varchar(2000),
    "max_places" integer NOT NULL
);

CREATE TABLE "cinema_sessions"
(
    "id" serial NOT NULL PRIMARY KEY,
    "film_id" serial NOT NULL,
    "date_time_start" TIMESTAMP NOT NULL,
    "cinema_hall_id" serial NOT NULL,
);

CREATE TABLE "cinema_hall_place"
(
    "id" serial NOT NULL PRIMARY KEY,
    "cinema_hall_id" serial NOT NULL,
    "cinema_sessions_id" serial NOT NULL
);

CREATE TABLE "tickets"
(
    "id" serial NOT NULL PRIMARY KEY,
    "cinema_session_id" serial NOT NULL,
    "cinema_hall_id" serial NOT NULL,
    "cinema_hall_place_id" serial NOT NULL,
    "type_price_id" serial NOT NULL
);

ALTER TABLE "cinema_sessions" ADD CONSTRAINT "cinema_sessions_fk0" FOREIGN KEY ("cinema_hall_id") REFERENCES "cinema_hall"("id");
ALTER TABLE "cinema_sessions" ADD CONSTRAINT "cinema_sessions_fk1" FOREIGN KEY ("film_id") REFERENCES "film"("id");

ALTER TABLE "tickets" ADD CONSTRAINT "tickets_fk0" FOREIGN KEY ("cinema_session_id") REFERENCES "cinema_sessions"("id");
ALTER TABLE "tickets" ADD CONSTRAINT "tickets_fk1" FOREIGN KEY ("cinema_hall_place_id") REFERENCES "cinema_hall_place"("id");
ALTER TABLE "tickets" ADD CONSTRAINT "tickets_fk2" FOREIGN KEY ("type_price_id") REFERENCES "type_price"("id");
ALTER TABLE "tickets" ADD CONSTRAINT "tickets_fk3" FOREIGN KEY ("price_history_id") REFERENCES "price_history"("id");

ALTER TABLE "cinema_hall_place" ADD CONSTRAINT "cinema_hall_place_fk0" FOREIGN KEY ("cinema_hall_id") REFERENCES "cinema_hall"("id");
ALTER TABLE "cinema_hall_place" ADD CONSTRAINT "cinema_hall_place_fk1" FOREIGN KEY ("cinema_session_id") REFERENCES "cinema_session"("id");

ALTER TABLE "price_history" ADD CONSTRAINT "price_history_fk0" FOREIGN KEY ("type_price_id") REFERENCES "type_price"("id");