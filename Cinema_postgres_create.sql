CREATE DATABASE "cinema";

CREATE TABLE IF NOT EXISTS "cinema.cinema_hall" (
	"id" serial NOT NULL,
	"name" varchar(100) NOT NULL,
	CONSTRAINT "cinema_hall_pk" PRIMARY KEY ("id")
) WITH (
  OIDS=FALSE
);

INSERT INTO "cinema.cinema_hall" ("id", "name") VALUES
(1, "Hall 1"),
(2, "Hall 2"),
(3, "Hall 3"),
(4, "Hall 4");


CREATE TABLE IF NOT EXISTS "cinema.film" (
	"id" serial NOT NULL,
	"title" varchar(255) NOT NULL,
	"description" TEXT NOT NULL,
	"poster" varchar(255) NOT NULL,
	CONSTRAINT "film_pk" PRIMARY KEY ("id")
) WITH (
  OIDS=FALSE
);


INSERT INTO "cinema.film" ("id", "title", "description", "poster") VALUES
(1, "Film 1", "description 1", "poster_url 1"),
(2, "Film 2", "description 2", "poster_url 2"),
(3, "Film 3", "description 3", "poster_url 3"),
(4, "Film 4", "description 4", "poster_url 4");


CREATE TABLE IF NOT EXISTS "cinema.ticket" (
	"id" serial NOT NULL,
	"film_id" integer NOT NULL,
	"hall_id" integer NOT NULL,
	"price" integer NOT NULL,
	CONSTRAINT "ticket_pk" PRIMARY KEY ("id")
) WITH (
  OIDS=FALSE
);


INSERT INTO "cinema.ticket" ("id", "film_id", "hall_id", "price") VALUES
(1, 1, 1, 300),
(2, 1, 1, 500),
(3, 1, 1, 500),
(4, 2, 4, 500),
(5, 2, 4, 400),
(6, 2, 4, 500),
(7, 1, 1, 500),
(8, 1, 1, 450),
(9, 1, 1, 500),
(10, 4, 2, 250);


ALTER TABLE "cinema.ticket" ADD CONSTRAINT "ticket_fk0" FOREIGN KEY ("film_id") REFERENCES "cinema.film"("id");
ALTER TABLE "cinema.ticket" ADD CONSTRAINT "ticket_fk1" FOREIGN KEY ("hall_id") REFERENCES "cinema.cinema_hall"("id");

-- самый прибыльный фильм --
SELECT MAX("t.price") as "profit", "f.film_name" FROM "cinema.ticket t"
INNER JOIN "cinema.film f" ON "f.id" = "t.film_id"
GROUP BY "t.price", "f.film_name"
