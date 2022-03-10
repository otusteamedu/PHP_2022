-- Create database structure

-- DROP TYPE IF EXISTS status;
-- CREATE TYPE status AS ENUM ('active', 'inactive', 'coming', 'expired');

-- DROP TYPE IF EXISTS day;
-- CREATE TYPE day AS ENUM ('monday', 'thuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday');

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
	"Day" day not null,
	"Time" time not null,
	"Price" numeric(10, 2) not null
);

CREATE TABLE "price_history" (
	"ID" serial primary key,
	"Shedule_ID" int not null REFERENCES "schedule" ("ID"),
	"Old_price" numeric(10, 2) not null,
	"New_price" numeric(10, 2) not null,
	"Date" date not null
);

CREATE TABLE "tickets" (
	"ID" serial primary key,
	"Shedule_ID" int not null REFERENCES "schedule" ("ID"),
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

INSERT INTO films ("ID", "Title", "Duration", "Release_date", "Status") VALUES
(1, 'Iron Man 3', 130, '2013-04-18', 'active'),
(2, 'Avatar', 162, '2009-12-10', 'active'),
(3, 'Titanic', 194, '1997-11-18', 'active'),
(4, 'The Avengers', 143, '2012-04-25', 'active');

INSERT INTO schedule ("ID", "Hall_ID", "Film_ID", "Day", "Time", "Price") VALUES
(1, 1, 1, 'monday', '10:00:00', 280),
(2, 1, 2, 'monday', '15:00:00', 300),
(3, 1, 1, 'monday', '20:00:00', 320),
(4, 1, 1, 'thuesday', '10:00:00', 280),
(5, 1, 2, 'thuesday', '15:00:00', 300),
(6, 1, 1, 'thuesday', '20:00:00', 320),
(7, 1, 1, 'wednesday', '10:00:00', 310),
(8, 1, 2, 'wednesday', '15:00:00', 330),
(9, 1, 1, 'wednesday', '20:00:00', 350),
(10, 1, 1, 'thursday', '10:00:00', 300),
(11, 1, 2, 'thursday', '15:00:00', 320),
(12, 1, 1, 'thursday', '20:00:00', 350),
(13, 1, 1, 'friday', '10:00:00', 300),
(14, 1, 2, 'friday', '15:00:00', 320),
(15, 1, 1, 'friday', '20:00:00', 350),
(16, 1, 1, 'saturday', '10:00:00', 400),
(17, 1, 2, 'saturday', '15:00:00', 420),
(18, 1, 1, 'saturday', '20:00:00', 450),
(19, 1, 1, 'sunday', '10:00:00', 400),
(20, 1, 2, 'sunday', '15:00:00', 420),
(21, 1, 1, 'sunday', '20:00:00', 450),
(22, 2, 3, 'monday', '10:00:00', 280),
(23, 2, 3, 'monday', '15:00:00', 300),
(24, 2, 3, 'monday', '20:00:00', 320),
(25, 2, 3, 'thuesday', '10:00:00', 280),
(26, 2, 3, 'thuesday', '15:00:00', 300),
(27, 2, 3, 'thuesday', '20:00:00', 320),
(28, 2, 3, 'wednesday', '10:00:00', 310),
(29, 2, 3, 'wednesday', '15:00:00', 330),
(30, 2, 3, 'wednesday', '20:00:00', 350),
(31, 2, 3, 'thursday', '10:00:00', 300),
(32, 2, 3, 'thursday', '15:00:00', 320),
(33, 2, 3, 'thursday', '20:00:00', 350),
(34, 2, 3, 'friday', '10:00:00', 300),
(35, 2, 3, 'friday', '15:00:00', 320),
(36, 2, 3, 'friday', '20:00:00', 350),
(37, 2, 3, 'saturday', '10:00:00', 400),
(38, 2, 3, 'saturday', '15:00:00', 420),
(39, 2, 3, 'saturday', '20:00:00', 450),
(40, 2, 3, 'sunday', '10:00:00', 400),
(41, 2, 3, 'sunday', '15:00:00', 420),
(42, 2, 3, 'sunday', '20:00:00', 450),
(43, 3, 4, 'monday', '10:00:00', 400),
(44, 3, 3, 'monday', '15:00:00', 500),
(45, 3, 4, 'monday', '20:00:00', 600),
(46, 3, 4, 'thuesday', '10:00:00', 400),
(47, 3, 3, 'thuesday', '15:00:00', 500),
(48, 3, 4, 'thuesday', '20:00:00', 600),
(49, 3, 4, 'wednesday', '10:00:00', 400),
(50, 3, 3, 'wednesday', '15:00:00', 500),
(51, 3, 4, 'wednesday', '20:00:00', 600),
(52, 3, 4, 'thursday', '10:00:00', 400),
(53, 3, 3, 'thursday', '15:00:00', 500),
(54, 3, 4, 'thursday', '20:00:00', 600),
(55, 3, 4, 'friday', '10:00:00', 400),
(56, 3, 3, 'friday', '15:00:00', 500),
(57, 3, 4, 'friday', '20:00:00', 600),
(58, 3, 4, 'saturday', '10:00:00', 450),
(59, 3, 3, 'saturday', '15:00:00', 550),
(60, 3, 4, 'saturday', '20:00:00', 650),
(61, 3, 4, 'sunday', '10:00:00', 450),
(62, 3, 3, 'sunday', '15:00:00', 550),
(63, 3, 4, 'sunday', '20:00:00', 650),
(64, 4, 4, 'monday', '10:00:00', 320),
(65, 4, 3, 'monday', '15:00:00', 420),
(66, 4, 4, 'monday', '20:00:00', 520),
(67, 4, 4, 'thuesday', '10:00:00', 320),
(68, 4, 3, 'thuesday', '15:00:00', 420),
(69, 4, 4, 'thuesday', '20:00:00', 520),
(70, 4, 4, 'wednesday', '10:00:00', 320),
(71, 4, 3, 'wednesday', '15:00:00', 420),
(72, 4, 4, 'wednesday', '20:00:00', 520),
(73, 4, 4, 'thursday', '10:00:00', 320),
(74, 4, 3, 'thursday', '15:00:00', 420),
(75, 4, 4, 'thursday', '20:00:00', 520),
(76, 4, 4, 'friday', '10:00:00', 350),
(77, 4, 3, 'friday', '15:00:00', 450),
(78, 4, 4, 'friday', '20:00:00', 550),
(79, 4, 4, 'saturday', '10:00:00', 380),
(80, 4, 3, 'saturday', '15:00:00', 480),
(81, 4, 4, 'saturday', '20:00:00', 580),
(82, 4, 4, 'sunday', '10:00:00', 380),
(83, 4, 3, 'sunday', '15:00:00', 480),
(84, 4, 4, 'sunday', '20:00:00', 580);

INSERT INTO price_history ("Shedule_ID", "Old_price", "New_price", "Date") VALUES
(5, 250, 300, '2022-01-08'),
(10, 280, 320, '2022-02-08'),
(10, 320, 300, '2022-02-18');

INSERT INTO tickets ("Shedule_ID", "Row_ID", "Place", "Date", "Amount") VALUES
(1, 1, 3, '2022-03-06', 280),
(5, 2, 2, '2022-01-06', 250),
(5, 2, 3, '2022-03-06', 300),
(5, 2, 3, '2022-03-06', 300),
(10, 1, 1, '2022-02-06', 280),
(10, 1, 2, '2022-03-06', 300),
(10, 1, 3, '2022-03-06', 300),
(10, 1, 4, '2022-03-06', 300),
(15, 2, 3, '2022-03-06', 300);

-- Show most profitable film

SELECT "films"."Title", sum("tickets"."Amount") as "Total_profit"
FROM "films", "tickets", "schedule"
WHERE "tickets"."Shedule_ID" = "schedule"."ID" AND "schedule"."Film_ID" = "films"."ID"
GROUP BY "films"."Title"
ORDER BY "Total_profit" DESC
LIMIT 1