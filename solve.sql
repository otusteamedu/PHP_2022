create table films
(
    id    serial primary key,
    title varchar(255)
);

create table film_attribute_types
(
    id    serial primary key,
    title varchar(255)
);

create table film_attributes
(
    id    serial primary key,
    title varchar(255),
    type  integer references film_attribute_types (id)
);

create table film_attribute_values
(
    id       serial primary key,
    attr     integer references film_attributes (id),
    val_text varchar,
    val_num  numeric(9),
    val_date date,
    val_bool boolean,
    film     integer references films (id)
);

INSERT INTO films (title)
VALUES ('Счастливы вместе'),
       ('Наша раша: яйца судьбы'),
       ('Полицейский с рублевки');

INSERT INTO film_attribute_types (title)
VALUES ('string'),
       ('date'),
       ('boolean'),
       ('numeric');

INSERT INTO film_attributes (title, type)
VALUES ('Рецензии', 1),
       ('Оскар', 3),
       ('Мировая премьера', 2),
       ('Премьера в РФ', 2),
       ('Запуск рекламной кампании', 2);

INSERT INTO film_attribute_values (film, attr, val_text, val_num, val_date, val_bool)
VALUES (1, 1, 'Безупречно', null, null, null),
       (2, 1, 'Прекрасно', null, null, null),
       (3, 1, 'Шедевер', null, null, null),
       (3, 2, null, null, null, true),
       (1, 3, null, null, '2023-01-07', null),
       (1, 4, null, null, '2023-01-14', null),
       (2, 4, null, null, '2023-01-19', null),
       (3, 4, null, null, '2023-01-15', null),
       (1, 5, null, null, '2022-12-19', null);


CREATE VIEW v_service_data AS
SELECT f.title film,
       CASE
           WHEN fav.val_date = date('now') THEN fa.title
           END nowdate_task,
       CASE
           WHEN fav.val_date >= (date('now') + '20 day'::interval) THEN fa.title
           END future_task
FROM films f
         LEFT JOIN film_attribute_values fav on f.id = fav.film
         LEFT JOIN film_attributes fa on fa.id = fav.attr
WHERE fa.type = 2;

CREATE VIEW v_marketing_data AS
SELECT f.title   film,
       fat.title type,
       fa.title  attr,
       CASE
           WHEN fav.val_date IS NOT NULL THEN fav.val_date::text
           WHEN fav.val_bool IS NOT NULL THEN fav.val_bool::text
           WHEN fav.val_num IS NOT NULL THEN fav.val_num::text
           WHEN fav.val_text IS NOT NULL THEN fav.val_text
           END   value
FROM films f
         LEFT JOIN film_attribute_values fav on f.id = fav.film
         LEFT JOIN film_attributes fa on fa.id = fav.attr
         LEFT JOIN film_attribute_types fat on fat.id = fa.type;
