INSERT INTO movie (name)
VALUES ('Avengers'),
       ('Spider-Man'),
       ('Iron Man');

INSERT INTO movie_attribute_type (name, type)
VALUES ('Рецензии', 'string'),
       ('Премии', 'bool'),
       ('Важные даты', 'date'),
       ('Служебные даты', 'date');

INSERT INTO movie_attribute (name, movie_attribute_type_id)
VALUES ('Рецензии критиков', 1), ('Отзыв неизвестной киноакадемии', 1),
       ('Оскар', 2), ('Ника', 2),
       ('Мировая премьера', 3), ('Премьера в РФ', 3),
       ('Начало продажи билетов', 4), ('Запуск рекламы на ТВ', 4);

INSERT INTO movie_attribute_value (movie_id, movie_attribute_id, value_string)
VALUES (1, 1, 'Рандомный текст рецензии критиков'), (1, 2, 'Рандомный текст отзыва неизвестной киноакадемии'),
       (2, 1, 'Рандомный текст рецензии критиков 2'),
       (3, 2, 'Рандомный текст отзыва неизвестной киноакадемии 2');

INSERT INTO movie_attribute_value (movie_id, movie_attribute_id, value_bool)
VALUES (1, 3, true), (1, 4, false),
       (2, 3, false), (2, 4, false),
       (3, 3, false), (3, 4, true);

INSERT INTO movie_attribute_value (movie_id, movie_attribute_id, value_date)
VALUES (1, 5, CURRENT_DATE), (1, 6, CURRENT_DATE + INTERVAL '20 days'),
       (2, 5, CURRENT_DATE + INTERVAL '20 days'), (2, 6, CURRENT_DATE),
       (3, 5, CURRENT_DATE), (3, 6, CURRENT_DATE);

INSERT INTO movie_attribute_value (movie_id, movie_attribute_id, value_date)
VALUES (1, 7, CURRENT_DATE), (1, 8, CURRENT_DATE + INTERVAL '20 days'),
       (2, 7, CURRENT_DATE + INTERVAL '20 days'), (2, 8, CURRENT_DATE),
       (3, 7, CURRENT_DATE), (3, 8, CURRENT_DATE);

CREATE INDEX movie_attribute_movie_attribute_type_id ON movie_attribute(movie_attribute_type_id);
CREATE INDEX movie_attribute_value_movie_id ON movie_attribute_value(movie_id);
CREATE INDEX movie_attribute_value_movie_attribute_id ON movie_attribute_value(movie_attribute_id);