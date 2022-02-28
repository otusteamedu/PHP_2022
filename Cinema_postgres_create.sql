CREATE DATABASE "cinema";

CREATE TABLE "cinema_hall" (
	"hall_id" serial NOT NULL,
	"name" varchar(100) NOT NULL,
	"quantity_of_places" integer NOT NULL,
	CONSTRAINT "cinema_hall_pk" PRIMARY KEY ("hall_id")
) WITH (
  OIDS=FALSE
);

CREATE TABLE "film" (
	"film_id" serial NOT NULL,
	"title" varchar(255) NOT NULL,
	"description" TEXT NOT NULL,
	"poster" varchar(255) NOT NULL,
	"premier_date" DATE NOT NULL,
	CONSTRAINT "film_pk" PRIMARY KEY ("film_id")
) WITH (
  OIDS=FALSE
);

CREATE TABLE "ticket" (
	"ticket_id" serial NOT NULL,
	"price_id" integer NOT NULL,
	"purchase_date" DATE NOT NULL,
	CONSTRAINT "ticket_pk" PRIMARY KEY ("ticket_id")
) WITH (
  OIDS=FALSE
);

CREATE TABLE "price" (
	"price_id" serial NOT NULL,
	"hall_id" integer NOT NULL,
	"place_type_id" integer NOT NULL,
	"session_id" integer NOT NULL,
	"film_id" integer NOT NULL,
	"amount" integer NOT NULL,
	CONSTRAINT "price_pk" PRIMARY KEY ("price_id")
) WITH (
  OIDS=FALSE
);

CREATE TABLE "place_type" (
	"place_type_id" serial NOT NULL,
	"type" varchar(255) NOT NULL,
	CONSTRAINT "place_type_pk" PRIMARY KEY ("place_type_id")
) WITH (
  OIDS=FALSE
);

CREATE TABLE "session" (
	"session_id" serial NOT NULL,
	"title" varchar(255) NOT NULL,
	"time" TIME NOT NULL,
	CONSTRAINT "session_pk" PRIMARY KEY ("session_id")
) WITH (
  OIDS=FALSE
);

ALTER TABLE "ticket" ADD CONSTRAINT "ticket_fk0" FOREIGN KEY ("price_id") REFERENCES "price"("price_id");

ALTER TABLE "price" ADD CONSTRAINT "price_fk0" FOREIGN KEY ("hall_id") REFERENCES "cinema_hall"("hall_id");
ALTER TABLE "price" ADD CONSTRAINT "price_fk1" FOREIGN KEY ("place_type_id") REFERENCES "place_type"("place_type_id");
ALTER TABLE "price" ADD CONSTRAINT "price_fk2" FOREIGN KEY ("session_id") REFERENCES "session"("session_id");
ALTER TABLE "price" ADD CONSTRAINT "price_fk3" FOREIGN KEY ("film_id") REFERENCES "film"("film_id");

-- самый прибыльный фильм --
SELECT SUM("p.amount") as "profit", "f.film_name" FROM "ticket t"
INNER JOIN "price p" ON "p.price_id" = "t.price_id"
INNER JOIN "film f" ON "f.film_id" = "p.film_id"
GROUP BY "profit", "f.film_name"
ORDER BY "profit" DESC
LIMIT 1;
