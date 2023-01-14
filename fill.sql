INSERT INTO movies (name) VALUES ('Брат');
INSERT INTO movies (name) VALUES ('Груз 200');
INSERT INTO movies (name) VALUES ('Кочегар');
INSERT INTO movies (name) VALUES ('Про уродов и людей');
INSERT INTO movies (name) VALUES ('Война');
INSERT INTO movies (name) VALUES ('Я тоже хочу');
INSERT INTO movies (name) VALUES ('Морфий');
INSERT INTO movies (name) VALUES ('Жмурки');

INSERT INTO attribute_types (type) VALUES ('Дата выхода');
INSERT INTO attribute_types (type) VALUES ('Текст');
INSERT INTO attribute_types (type) VALUES ('Бюджет');
INSERT INTO attribute_types (type) VALUES ('Рейтинг');

INSERT INTO movie_attributes (movie, attribute_type) VALUES (1, 2);
INSERT INTO movie_attributes (movie, attribute_type) VALUES (1, 3);
INSERT INTO movie_attributes (movie, attribute_type) VALUES (2, 2);
INSERT INTO movie_attributes (movie, attribute_type) VALUES (3, 1);
INSERT INTO movie_attributes (movie, attribute_type) VALUES (3, 1);
INSERT INTO movie_attributes (movie, attribute_type) VALUES (4, 4);
INSERT INTO movie_attributes (movie, attribute_type) VALUES (5, 3);
INSERT INTO movie_attributes (movie, attribute_type) VALUES (5, 1);


INSERT INTO  attribute_type_value (movie_attribute, text, decimal, int, date) VALUES (1, '4 фильм режисера Балабанова', null, null, null);
INSERT INTO  attribute_type_value (movie_attribute, text, decimal, int, date) VALUES (2, null, null, 235, null);
INSERT INTO  attribute_type_value (movie_attribute, text, decimal, int, date) VALUES (3, '3 фильм режисера Балабанова', null, null, null);
INSERT INTO  attribute_type_value (movie_attribute, text, decimal, int, date) VALUES (4, null, null, null, '2000-08-02');
INSERT INTO  attribute_type_value (movie_attribute, text, decimal, int, date) VALUES (5, null, null, null, '2002-08-02');
INSERT INTO  attribute_type_value (movie_attribute, text, decimal, int, date) VALUES (6, null, 4.6, null, null);
INSERT INTO  attribute_type_value (movie_attribute, text, decimal, int, date) VALUES (7, null, null, 320, null);
INSERT INTO  attribute_type_value (movie_attribute, text, decimal, int, date) VALUES (8, '5 фильм режисера Балабанова', null, null, null);

