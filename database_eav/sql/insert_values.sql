INSERT INTO film (name, timing)
VALUES
    ('Гладиатор', '02:05'),
    ('Титаник', '03:15'),
    ('Аватар', '02:35'),
    ('Начало', '02:15'),
    ('Матрица', '01:55');

INSERT INTO film_attribute_type (type)
VALUES
       ('int'),
       ('numeric'),
       ('varchar'),
       ('text'),
       ('boolean'),
       ('date');

INSERT INTO film_attribute (name, film_attribute_type_id)
VALUES
    ('Рецензия', 4),
    ('Отзыв', 4),
    ('Премьера в мире', 6),
    ('Премьера в РФ', 6),
    ('Старт продаж', 6),
    ('Старт рекламы', 6),
    ('Премия Оскар', 5),
    ('Премия Ника', 5);

INSERT INTO film_value (film_id, film_attribute_id, value_int, value_numeric, value_varchar, value_text, value_boolean, value_date)
VALUES
    (1, 1, null, null, null, 'Рецензия к первому фильму', null, null),
    (1, 2, null, null, null, 'Отзыв к первому фильму', null, null),
    (1, 3, null, null, null, null, null, '2022-04-21'),
    (1, 4, null, null, null, null, null, '2022-04-26'),
    (1, 5, null, null, null, null, null, '2022-04-25'),
    (1, 6, null, null, null, null, null, '2022-04-01'),
    (1, 7, null, null, null, null, true, null),
    (1, 8, null, null, null, null, true, null),

    (2, 1, null, null, null, 'Рецензия ко второму фильму', null, null),
    (2, 2, null, null, null, 'Отзыв ко второму фильму', null, null),
    (2, 3, null, null, null, null, null, '2022-05-23'),
    (2, 4, null, null, null, null, null, '2022-05-29'),
    (2, 5, null, null, null, null, null, '2022-05-28'),
    (2, 6, null, null, null, null, null, '2022-05-03'),
    (2, 7, null, null, null, null, true, null),

    (3, 1, null, null, null, 'Рецензия к третьему фильму', null, null),
    (3, 2, null, null, null, 'Отзыв к третьему фильму', null, null),
    (3, 3, null, null, null, null, null, '2022-06-11'),
    (3, 4, null, null, null, null, null, '2022-06-17'),
    (3, 5, null, null, null, null, null, '2022-06-16'),
    (3, 6, null, null, null, null, null, '2022-05-28'),
    (3, 7, null, null, null, null, true, null),
    (3, 8, null, null, null, null, true, null),

    (4, 1, null, null, null, 'Рецензия к четвертому фильму', null, null),
    (4, 2, null, null, null, 'Отзыв к четвертому фильму', null, null),
    (4, 3, null, null, null, null, null, '2022-06-19'),
    (4, 4, null, null, null, null, null, '2022-06-20'),
    (4, 5, null, null, null, null, null, '2022-06-19'),
    (4, 6, null, null, null, null, null, '2022-06-01'),
    (4, 8, null, null, null, null, true, null),

    (5, 1, null, null, null, 'Рецензия к пятому фильму', null, null),
    (5, 2, null, null, null, 'Отзыв к пятому фильму', null, null),
    (5, 3, null, null, null, null, null, '2022-04-22'),
    (5, 4, null, null, null, null, null, '2022-04-27'),
    (5, 5, null, null, null, null, null, '2022-04-26'),
    (5, 6, null, null, null, null, null, '2022-04-03'),
    (5, 7, null, null, null, null, true, null),
    (5, 8, null, null, null, null, true, null);
