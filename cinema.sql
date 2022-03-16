-- Create database structure

CREATE TABLE "films" (
	"ID" serial primary key,
	"Title" varchar(100) not null
);

CREATE TABLE "attribute_types" (
	"ID" serial primary key,
	"Title" varchar(100) not null UNIQUE
);

CREATE TABLE "attributes" (
	"ID" serial primary key,
	"Title" varchar(100) not null,
	"Attribute_Type" integer not null REFERENCES "attribute_types" ("ID")
);

CREATE TABLE "attribute_values" (
	"ID" serial primary key,
	"Film_ID" integer not null REFERENCES "films" ("ID"),
	"Attribute_ID" integer not null REFERENCES "attributes" ("ID"),
	"Date" date,
	"Time" time,
	"Timestamp" timestamp,
	"Text_small" varchar(255),
	"Text_big" text,
	"Number_small_int" integer,
	"Number_big_int" bigint,
	"Number_double" double precision,
	"Money" money,
	"Boolean" boolean,
	"Json" json,
	"Jsonb" jsonb
);

-- Insert data

INSERT INTO "films" ("Title") values ('Iron Man 3'), ('Avatar'), ('Titanic'), ('The Avengers');

INSERT INTO "attribute_types" ("ID", "Title") values
(1, 'Text (small)'),
(2, 'Text (big)'),
(3, 'Number (small int)'),
(4, 'Date'),
(5, 'Time'),
(6, 'Timestamp'),
(7, 'Number_big_int'),
(8, 'Number_double'),
(9, 'Money'),
(10, 'Boolean'),
(11, 'Json'),
(12, 'Jsonb');

INSERT INTO "attributes" ("ID", "Title", "Attribute_Type") values
(1, 'Reviews by critics', 1),
(2, 'Review by an unknown film academy', 1),
(3, 'Review by the British film academy', 1),
(4, 'Oscar', 3),
(5, 'Nika', 3),
(6, 'Golden globe', 3),
(7, 'World premiere', 4),
(8, 'Premiere in RU', 4),
(9, 'Premiere in KG', 4),
(10, 'Ticket sales start date', 4),
(11, 'Ticket sales finish date', 4),
(12, 'TV ad start date', 4),
(13, 'TV ad finish date', 4),
(14, 'Duration', 5),
(15, 'Box office', 9);

INSERT INTO "attribute_values" ("Film_ID", "Attribute_ID", "Date", "Text_small", "Number_small_int", "Time", "Money") values
(1, 1, null, 'Good film', null, null, null),
(1, 3, null, 'Best film', null, null, null),
(1, 6, null, null, 1, null, null),
(1, 7, '2022-04-01', null, null, null, null),
(1, 8, '2022-04-14', null, null, null, null),
(1, 10, current_date, null, null, null, null),
(1, 11, current_date + INTERVAL '20 day', null, null, null, null),
(1, 14, null, null, null, '02:10:00', null),
(1, 15, null, null, null, null, '$1,214,811,252.00'),
(2, 1, null, 'Bad film', null, null, null),
(2, 3, null, 'Very bad film', null, null, null),
(2, 4, null, null, 1, null, null),
(2, 7, '2022-04-01', null, null, null, null),
(2, 8, '2022-04-14', null, null, null, null),
(2, 10, current_date, null, null, null, null),
(2, 11, current_date + INTERVAL '20 day', null, null, null, null),
(2, 14, null, null, null, '02:42:00', null),
(2, 15, null, null, null, null, '$2,847,379,794.00'),
(3, 10, current_date + INTERVAL '20 day', null, null, null, null),
(3, 14, null, null, null, '03:14:00', null),
(3, 15, null, null, null, null, '$2,201,647,264.00'),
(4, 10, current_date + INTERVAL '20 day', null, null, null, null),
(4, 14, null, null, null, '02:23:00', null),
(4, 15, null, null, null, null, '$1,518,812,988.00');
