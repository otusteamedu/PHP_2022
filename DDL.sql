CREATE TABLE "halls" (
  "id" integer PRIMARY KEY,
  "name" text
);

CREATE TABLE "users" (
  "id" integer PRIMARY KEY,
  "username" text
);

CREATE TABLE "films" (
  "id" integer PRIMARY KEY,
  "title" text
);

CREATE TABLE "seats" (
  "id" integer PRIMARY KEY,
  "hall_id" integer REFERENCES "halls" ("id"),
  "row" integer,
  "number" integer,
  "seat_type_id" integer REFERENCES "seat_types" ("id")  
);

CREATE TABLE "shows" (
  "id" integer PRIMARY KEY,
  "hall_id" integer REFERENCES "halls" ("id"),
  "film_id" integer REFERENCES "films" ("id"),
  "show_date" date,
  "show_time" time
);

CREATE TABLE "tickets" (
  "id" integer PRIMARY KEY,
  "seat_id" integer REFERENCES "seats" ("id"),
  "user_id" integer REFERENCES "users" ("id"),
  "show_id" integer REFERENCES "shows" ("id"),
  "cost" integer
);

CREATE TABLE "prices" (
  "id" integer PRIMARY KEY,
  "seat_type_id" integer REFERENCES "seat_types" ("id"),
  "price" integer REFERENCES "shows" ("id"),
  "show_id" integer
);

CREATE TABLE "seat_types" (
  "id" integer PRIMARY KEY,
  "type_name" text
);