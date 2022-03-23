-- Create database structure

DROP TYPE IF EXISTS status;
CREATE TYPE status AS ENUM ('active', 'inactive', 'coming', 'expired');

DROP TYPE IF EXISTS day;
CREATE TYPE day AS ENUM ('monday', 'thuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday');

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
	"Schedule_ID" int not null REFERENCES "schedule" ("ID"),
	"Old_price" numeric(10, 2) not null,
	"New_price" numeric(10, 2) not null,
	"Date" date not null
);

CREATE TABLE "tickets" (
	"ID" serial primary key,
	"Schedule_ID" int not null REFERENCES "schedule" ("ID"),
	"Row_ID" int REFERENCES "hall_places" ("ID"),
	"Place" int not null,
	"Date" date not null,
	"Amount" numeric(10,2) not null
);
