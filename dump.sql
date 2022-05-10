DROP TABLE IF EXISTS films;
CREATE TABLE films (
                       "id" serial PRIMARY KEY,
                       "title" varchar(255) NOT NULL
);

DROP TABLE IF EXISTS attribute_types;
CREATE TABLE attribute_types (
                         "id" serial PRIMARY KEY,
                         "name" varchar(60) NOT NULL
);


DROP TABLE IF EXISTS attributes;
CREATE TABLE attributes (
                         "id" serial PRIMARY KEY,
                         "attribute_type_id" integer NOT NULL,
                         "name" varchar(60) NOT NULL,
                         FOREIGN KEY (attribute_type_id) REFERENCES attribute_types(id) ON DELETE CASCADE
);

CREATE INDEX attributes_type_id_index ON attributes (attribute_type_id);

DROP TABLE IF EXISTS attribute_values;
CREATE TABLE attribute_values (
                       "id" serial PRIMARY KEY,
                       "attribute_id" integer NOT NULL,
                       "value_date" date null,
                       "value_float" double precision null,
                       "value_integer" integer null,
                       "value_boolean" boolean null,
                       "value_text" text null,
                       "film_id" integer null,
                       FOREIGN KEY (attribute_id) REFERENCES attributes(id) ON DELETE CASCADE,
                       FOREIGN KEY (film_id) REFERENCES films(id) ON DELETE CASCADE
);

CREATE INDEX attribute_values_attr_id_index ON attribute_values (attribute_id);

INSERT INTO films (title)
VALUES ('Титаник');


INSERT INTO attribute_types (name) VALUES
                                          ('Текстовое поле'),
                                          ('Дата');

INSERT INTO attributes (attribute_type_id, name) VALUES
                                       (1, 'Описание'),
                                       (2, 'Задание');

INSERT INTO attribute_values (attribute_id, value_text, value_date, film_id) VALUES
                                                     (1, 'Описание фильма титаник', null, 1),
                                                     (2, null, '2022-05-10', 1),
                                                     (2, null, '2022-05-09', 1),
                                                     (2, null, '2022-05-29', 1),
                                                     (2, null, '2022-05-28', 1);
