-- Create database structure

-- DROP TYPE IF EXISTS status;
-- CREATE TYPE status AS ENUM ('active', 'inactive', 'coming', 'expired');

-- DROP DATABASE IF EXISTS cinema;
-- CREATE DATABASE cinema;

CREATE TABLE "halls" (
	"ID" serial primary key,
	"Title" varchar(255) not null
);

CREATE TABLE "hall_places" (
	"ID" serial primary key,
	"Hall_ID" int not null REFERENCES "halls" ("ID"),
	"Row" int not null,
	"Count_places" int not null
);

CREATE TABLE "films" (
	"ID" serial primary key,
	"Title" varchar(255) not null,
	"Description" text,
	"Duration" int not null,
	"Release_date" date not null,
	"Poster" text,
	"Status" status not null
);

CREATE TABLE "schedule" (
	"ID" serial primary key,
	"Hall_ID" int not null REFERENCES "halls" ("ID"),
	"Film_ID" int not null REFERENCES "films" ("ID"),
	"Price" numeric(10, 2) not null
);

CREATE TABLE "price_history" (
	"ID" serial primary key,
	"Price_ID" int not null REFERENCES "schedule" ("ID"),
	"Old_price" numeric(10, 2) not null,
	"New_price" numeric(10, 2) not null,
	"Date" date not null
);

CREATE TABLE "tickets" (
	"ID" serial primary key,
	"Price_ID" int not null REFERENCES "schedule" ("ID"),
	"Row_ID" int REFERENCES "hall_places" ("ID"),
	"Place" int not null,
	"Date" date not null,
	"Amount" numeric(10,2) not null
);

-- Insert data

INSERT INTO halls ("ID", "Title") VALUES
(1, 'Hall 1'),
(2, 'Hall 2'),
(3, 'Hall IMAX'),
(4, 'Hall Dolby ATMOS');

INSERT INTO hall_places ("Hall_ID", "Row", "Count_places") VALUES
(1, 1, 5),
(1, 2, 5),
(1, 3, 5),
(1, 4, 5),
(1, 5, 5),
(2, 1, 10),
(2, 2, 10),
(2, 3, 10),
(2, 4, 10),
(2, 5, 10),
(2, 6, 10),
(2, 7, 10),
(3, 1, 4),
(3, 2, 4),
(3, 3, 4),
(3, 4, 4),
(4, 1, 5),
(4, 2, 5),
(4, 3, 5),
(4, 4, 5);

INSERT INTO films ("Title", "Duration", "Release_date", "Status") VALUES
('Iron Man 3', 130, '2013-04-18', 'active'),
('Avatar', 162, '2009-12-10', 'active'),
('Titanic', 194, '1997-11-18', 'active'),
('The Avengers', 143, '2012-04-25', 'active');

INSERT INTO schedule ("ID", "Hall_ID", "Film_ID", "Price") VALUES
(1, 1, 1, 300),
(2, 1, 2, 320),
(3, 1, 3, 310),
(4, 1, 4, 300),
(5, 2, 1, 300),
(6, 2, 2, 320),
(7, 2, 3, 310),
(8, 2, 4, 300),
(9, 3, 1, 600),
(10, 3, 2, 640),
(11, 3, 3, 620),
(12, 3, 4, 600),
(13, 4, 1, 400),
(14, 4, 2, 420),
(15, 4, 3, 410),
(16, 4, 4, 400);

INSERT INTO price_history ("Price_ID", "Old_price", "New_price", "Date") VALUES
(5, 250, 300, '2022-01-08'),
(10, 540, 620, '2022-02-08'),
(10, 620, 640, '2022-02-18');

INSERT INTO tickets ("Price_ID", "Row_ID", "Place", "Date", "Amount") VALUES
(1, 1, 3, '2022-03-06', 300),
(5, 2, 2, '2022-01-06', 250),
(5, 2, 3, '2022-03-06', 300),
(5, 2, 3, '2022-03-06', 300),
(10, 1, 1, '2022-02-06', 540),
(10, 1, 2, '2022-03-06', 640),
(10, 1, 3, '2022-03-06', 640),
(10, 1, 4, '2022-03-06', 640),
(15, 2, 3, '2022-03-06', 402);

-- Show most profitable film

SELECT "films"."Title", sum("tickets"."Amount") as "Total_profit"
FROM "films", "tickets", "schedule"
WHERE "tickets"."Price_ID" = "schedule"."ID" AND "schedule"."Film_ID" = "films"."ID"
GROUP BY "films"."Title"
ORDER BY "Total_profit" DESC
LIMIT 1