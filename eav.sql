CREATE TABLE movies
(
    id         BIGSERIAL PRIMARY KEY,
    title      VARCHAR(200) not null,
    created_at TIMESTAMP default CURRENT_TIMESTAMP
);

CREATE TABLE attribute_types
(
    id   SMALLSERIAL PRIMARY KEY,
    name VARCHAR(20) not null
);

CREATE TABLE attributes
(
    id                BIGSERIAL PRIMARY KEY,
    name              VARCHAR(100) not null,
    attribute_type_id SMALLINT     NOT NULL REFERENCES attribute_types (id)
);

CREATE TABLE values
(
    attribute_id BIGINT NOT NULL REFERENCES attributes (id),
    movie_id     BIGINT NOT NULL REFERENCES movies (id),
    int_value    INT     DEFAULT NULL,
    float_value  FLOAT   DEFAULT NULL,
    date_value   date    DEFAULT NULL,
    text_value   TEXT    DEFAULT NULL,
    bool_value   BOOLEAN DEFAULT NULL
);

-- Добавляем индексы, т.к в values будет очень быстро заполняться.
-- Предполагаем, что одна характеристика для одного фильма будет иметь только одно значение.
CREATE UNIQUE INDEX attribute_movie_ids_idx ON values (attribute_id, movie_id);
-- Поиск по attribute_id будет производиться за корректное время за счет индекса attribute_movie_ids_idx
-- (т.к attribute_id стоит на первом месте), поэтому нужно добавить только индекс для movie_id
CREATE INDEX values_movie_id_idx ON values (movie_id);


-- Заполняем таблицы
INSERT INTO movies (id, title, created_at)
VALUES (DEFAULT, 'Человек-Козийрог', DEFAULT);
INSERT INTO movies (id, title, created_at)
VALUES (DEFAULT, 'Зеленый Жираф', DEFAULT);
INSERT INTO movies (id, title, created_at)
VALUES (DEFAULT, 'Тристан и Изольда', DEFAULT);
INSERT INTO movies (id, title, created_at)
VALUES (DEFAULT, 'Шрэк: новая реальность', DEFAULT);
INSERT INTO movies (id, title, created_at)
VALUES (DEFAULT, 'Ковбой Марльборо и Ковбой Бибоп: схватка на горбатой горе', DEFAULT);
INSERT INTO movies (id, title, created_at)
VALUES (DEFAULT, 'Король Артур', DEFAULT);
INSERT INTO movies (id, title, created_at)
VALUES (DEFAULT, 'Назад в светлое будущее', DEFAULT);
INSERT INTO movies (id, title, created_at)
VALUES (DEFAULT, 'Котопес и Робокоп', DEFAULT);
INSERT INTO movies (id, title, created_at)
VALUES (DEFAULT, 'Аватар', DEFAULT);
INSERT INTO movies (id, title, created_at)
VALUES (DEFAULT, 'Вматрица', DEFAULT);

INSERT INTO attribute_types (id, name)
VALUES (DEFAULT, 'int');
INSERT INTO attribute_types (id, name)
VALUES (DEFAULT, 'float');
INSERT INTO attribute_types (id, name)
VALUES (DEFAULT, 'date');
INSERT INTO attribute_types (id, name)
VALUES (DEFAULT, 'text');
INSERT INTO attribute_types (id, name)
VALUES (DEFAULT, 'bool');

INSERT INTO attributes (id, name, attribute_type_id)
VALUES (DEFAULT, 'Рецензия Василия Петровича', 4);
INSERT INTO attributes (id, name, attribute_type_id)
VALUES (DEFAULT, 'Премия Оскар', 5);
INSERT INTO attributes (id, name, attribute_type_id)
VALUES (DEFAULT, 'Оценка IMDB', 2);
INSERT INTO attributes (id, name, attribute_type_id)
VALUES (DEFAULT, 'Оценка Кинопоиск', 2);
INSERT INTO attributes (id, name, attribute_type_id)
VALUES (DEFAULT, 'Премия Золотая малина', 5);
INSERT INTO attributes (id, name, attribute_type_id)
VALUES (DEFAULT, 'Мировая премьера', 3);
INSERT INTO attributes (id, name, attribute_type_id)
VALUES (DEFAULT, 'Премьера в России', 3);
INSERT INTO attributes (id, name, attribute_type_id)
VALUES (DEFAULT, 'Дата старта продаж билетов', 3);
INSERT INTO attributes (id, name, attribute_type_id)
VALUES (DEFAULT, 'Сборы в мире', 1);
INSERT INTO attributes (id, name, attribute_type_id)
VALUES (DEFAULT, 'Сборы в России', 1);

INSERT INTO values (attribute_id, movie_id, int_value, float_value, date_value, text_value, bool_value)
VALUES (1, 1, null, null, null, 'Нормальный фильмец', null);
INSERT INTO values (attribute_id, movie_id, int_value, float_value, date_value, text_value, bool_value)
VALUES (2, 1, null, null, null, null, true);
INSERT INTO values (attribute_id, movie_id, int_value, float_value, date_value, text_value, bool_value)
VALUES (6, 1, null, null, '2022-12-28', null, null);
INSERT INTO values (attribute_id, movie_id, int_value, float_value, date_value, text_value, bool_value)
VALUES (1, 2, null, null, null, 'Под пиво вечером зайдет', null);
INSERT INTO values (attribute_id, movie_id, int_value, float_value, date_value, text_value, bool_value)
VALUES (3, 2, null, 9, null, null, null);
INSERT INTO values (attribute_id, movie_id, int_value, float_value, date_value, text_value, bool_value)
VALUES (2, 2, null, null, null, null, true);
INSERT INTO values (attribute_id, movie_id, int_value, float_value, date_value, text_value, bool_value)
VALUES (1, 3, null, null, null, 'Так интересно было, что уснул после вступительной мелодии', null);
INSERT INTO values (attribute_id, movie_id, int_value, float_value, date_value, text_value, bool_value)
VALUES (4, 3, null, 2.1, null, null, null);
INSERT INTO values (attribute_id, movie_id, int_value, float_value, date_value, text_value, bool_value)
VALUES (10, 3, 120000, null, null, null, null);
INSERT INTO values (attribute_id, movie_id, int_value, float_value, date_value, text_value, bool_value)
VALUES (7, 3, null, null, '2022-12-28', null, null);
INSERT INTO values (attribute_id, movie_id, int_value, float_value, date_value, text_value, bool_value)
VALUES (1, 4, null, null, null, 'У режиссера руки из одного места', null);
INSERT INTO values (attribute_id, movie_id, int_value, float_value, date_value, text_value, bool_value)
VALUES (8, 4, null, null, '2022-12-28', null, null);
INSERT INTO values (attribute_id, movie_id, int_value, float_value, date_value, text_value, bool_value)
VALUES (10, 5, 1320000, null, null, null, null);
INSERT INTO values (attribute_id, movie_id, int_value, float_value, date_value, text_value, bool_value)
VALUES (2, 6, null, null, null, null, true);
INSERT INTO values (attribute_id, movie_id, int_value, float_value, date_value, text_value, bool_value)
VALUES (4, 7, null, 9.1, null, null, null);
INSERT INTO values (attribute_id, movie_id, int_value, float_value, date_value, text_value, bool_value)
VALUES (3, 7, null, 3.2, null, null, null);
INSERT INTO values (attribute_id, movie_id, int_value, float_value, date_value, text_value, bool_value)
VALUES (10, 9, 1320000, null, null, null, null);
INSERT INTO values (attribute_id, movie_id, int_value, float_value, date_value, text_value, bool_value)
VALUES (2, 9, null, null, null, null, true);
INSERT INTO values (attribute_id, movie_id, int_value, float_value, date_value, text_value, bool_value)
VALUES (1, 9, null, null, null, 'Даже не смотрел', null);
INSERT INTO values (attribute_id, movie_id, int_value, float_value, date_value, text_value, bool_value)
VALUES (10, 10, 132000, null, null, null, null);
INSERT INTO values (attribute_id, movie_id, int_value, float_value, date_value, text_value, bool_value)
VALUES (8, 1, null, null, '2022-12-29', null, null);
INSERT INTO values (attribute_id, movie_id, int_value, float_value, date_value, text_value, bool_value)
VALUES (8, 2, null, null, '2022-12-29', null, null);
INSERT INTO values (attribute_id, movie_id, int_value, float_value, date_value, text_value, bool_value)
VALUES (8, 3, null, null, '2022-12-29', null, null);
INSERT INTO values (attribute_id, movie_id, int_value, float_value, date_value, text_value, bool_value)
VALUES (8, 4, null, null, '2022-12-29', null, null);
INSERT INTO values (attribute_id, movie_id, int_value, float_value, date_value, text_value, bool_value)
VALUES (8, 5, null, null, '2023-01-18', null, null);
INSERT INTO values (attribute_id, movie_id, int_value, float_value, date_value, text_value, bool_value)
VALUES (8, 6, null, null, '2023-01-18', null, null);
INSERT INTO values (attribute_id, movie_id, int_value, float_value, date_value, text_value, bool_value)
VALUES (8, 7, null, null, '2023-01-18', null, null);
INSERT INTO values (attribute_id, movie_id, int_value, float_value, date_value, text_value, bool_value)
VALUES (8, 8, null, null, '2023-01-18', null, null);
INSERT INTO values (attribute_id, movie_id, int_value, float_value, date_value, text_value, bool_value)
VALUES (8, 9, null, null, '2023-01-18', null, null);
INSERT INTO values (attribute_id, movie_id, int_value, float_value, date_value, text_value, bool_value)
VALUES (8, 10, null, null, '2023-01-18', null, null);



-- VIEW для отображения сегодняшних задач
CREATE VIEW todays_tasks AS
SELECT m.title, a.name as task_name
FROM movies m
         JOIN values v ON m.id = v.movie_id
         JOIN attributes a ON v.attribute_id = a.id
         JOIN attribute_types at ON a.attribute_type_id = at.id
WHERE at.name = 'date'
  AND v.date_value = CURRENT_DATE;

-- VIEW для отображения задач, которые наступят через 20 дней
CREATE VIEW in20days_tasks AS
SELECT m.title, a.name as task_name
FROM movies m
         JOIN values v ON m.id = v.movie_id
         JOIN attributes a ON v.attribute_id = a.id
         JOIN attribute_types at ON a.attribute_type_id = at.id
WHERE at.name = 'date'
  AND v.date_value = CURRENT_DATE + 20;


-- VIEW для отображения всех характеристик фильмов
--  значения получаю, конкатенируя все значения, тк заполнено только одно из полей, остальные null - при касте
--  превращаются в пустую строку и на отображаемое значение не влияют
CREATE VIEW movie_attribute_values AS
SELECT m.title                       AS movie_title,
       at.name                       AS attribute_type,
       a.name                        AS attribute_name,
       concat(v.int_value::varchar, v.float_value::varchar, v.date_value::varchar, v.text_value,
              v.bool_value::varchar) AS value
FROM movies m
         JOIN values v on m.id = v.movie_id
         JOIN attributes a on v.attribute_id = a.id
         JOIN attribute_types at on a.attribute_type_id = at.id
ORDER BY m.title;