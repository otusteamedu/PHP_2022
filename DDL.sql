CREATE TABLE "films" (
  "id" integer PRIMARY KEY,
  "title" text
);

CREATE TABLE "attribute_types" (
  "id" integer PRIMARY KEY,
  "name" text,
  "data_type" text
);

CREATE TABLE "attributes" (
  "id" integer PRIMARY KEY,
  "name" text,
  "type_id" integer REFERENCES "attribute_types" ("id")
);

CREATE TABLE "attribute_values" (
  "id" integer PRIMARY KEY,
  "film_id" integer REFERENCES "films" ("id"),
  "attribute_id" integer REFERENCES "attributes" ("id"),
  "value_text" text,
  "value_date" date,
  "value_boolean" boolean,
  "value_integer" integer
);

CREATE INDEX attribute_values_film_id ON attribute_values (film_id);
CREATE INDEX attribute_values_attribute_id ON attribute_values (attribute_id);
CREATE INDEX attributes_type_id ON attributes (type_id);