INSERT INTO film_entity(name, year) VALUES
    ('Зеленая миля', 1999),
    ('Список Шиндлера', 1993),
    ('Побег из Шоушенка', 1994),
    ('Властелин колец: Возвращение короля', 2003),
    ('Форрест Гамп', 1994);

INSERT INTO film_attribute_type(name) VALUES
    ('Строка'),
    ('Рецензия'),
    ('Деньги'),
    ('Рейтинг'),
    ('Премия'),
    ('Важная дата'),
    ('Служебная дата');

INSERT INTO film_attribute(type_id, name) VALUES
    (1, 'Слоган'),
    (2, 'Рецензия зрителей'),
    (2, 'Рецензия кинокритиков'),
    (3, 'Бюджет'),
    (3, 'Сборы в США'),
    (3, 'Сборы в мире'),
    (3, 'Сборы в России'),
    (4, 'Рейтинг IMDb'),
    (4, 'Рейтинг Кинопоиск'),
    (5, 'Оскар'),
    (5, 'Премия Гильдии актеров'),
    (5, 'Британская академия'),
    (6, 'Премьера в мире'),
    (6, 'Премьера в России'),
    (6, 'Релиз на DVD'),
    (7, 'Дата начала продажи билетов'),
    (7, 'Запуск рекламы');

INSERT INTO film_attribute_value (film_id, attribute_id, value_char) VALUES (1, 1, 'Пол Эджкомб не верил в чудеса. Пока не столкнулся с одним из них');
INSERT INTO film_attribute_value (film_id, attribute_id, value_char) VALUES (2, 1, 'Этот список - жизнь');
INSERT INTO film_attribute_value (film_id, attribute_id, value_char) VALUES (3, 1, 'Страх - это кандалы. Надежда - это свобода');
INSERT INTO film_attribute_value (film_id, attribute_id, value_char) VALUES (5, 1, 'Мир уже никогда не будет прежним, после того как вы увидите его глазами Форреста Гампа');

INSERT INTO film_attribute_value (film_id, attribute_id, value_text) VALUES (1, 2, 'Магия или реальность');
INSERT INTO film_attribute_value (film_id, attribute_id, value_text) VALUES (1, 3, 'Шедевр!');
INSERT INTO film_attribute_value (film_id, attribute_id, value_text) VALUES (2, 2, 'Памяти бесчисленных жертв Второй мировой нет и не будет конца.');
INSERT INTO film_attribute_value (film_id, attribute_id, value_text) VALUES (2, 3, 'Триумф зла — бездействие доброго человека.');
INSERT INTO film_attribute_value (film_id, attribute_id, value_text) VALUES (3, 2, 'Фильм про гнилую систему правосудия и везучего главного героя - лучший фильм всех народов?');
INSERT INTO film_attribute_value (film_id, attribute_id, value_text) VALUES (3, 3, 'Непоколебимая свобода…');
INSERT INTO film_attribute_value (film_id, attribute_id, value_text) VALUES (4, 2, 'Эпичный конец');
INSERT INTO film_attribute_value (film_id, attribute_id, value_text) VALUES (4, 3, 'Конец третьей эпохи: что мы увидели и что потеряли');
INSERT INTO film_attribute_value (film_id, attribute_id, value_text) VALUES (5, 2, 'Добрым дуракам везёт');
INSERT INTO film_attribute_value (film_id, attribute_id, value_text) VALUES (5, 3, 'Фильм о том, как великие поступки можно совершать, будучи самым простым человеком.');

INSERT INTO film_attribute_value (film_id, attribute_id, value_money) VALUES (1, 4, 60000000);
INSERT INTO film_attribute_value (film_id, attribute_id, value_money) VALUES (1, 5, 136801374);
INSERT INTO film_attribute_value (film_id, attribute_id, value_money) VALUES (1, 6, 286801374);
INSERT INTO film_attribute_value (film_id, attribute_id, value_money) VALUES (2, 4, 22000000);
INSERT INTO film_attribute_value (film_id, attribute_id, value_money) VALUES (2, 5, 96065768);
INSERT INTO film_attribute_value (film_id, attribute_id, value_money) VALUES (2, 6, 321306305);
INSERT INTO film_attribute_value (film_id, attribute_id, value_money) VALUES (3, 4, 25000000);
INSERT INTO film_attribute_value (film_id, attribute_id, value_money) VALUES (3, 5, 28341469);
INSERT INTO film_attribute_value (film_id, attribute_id, value_money) VALUES (3, 6, 28418687);
INSERT INTO film_attribute_value (film_id, attribute_id, value_money) VALUES (3, 7, 87432);
INSERT INTO film_attribute_value (film_id, attribute_id, value_money) VALUES (4, 4, 94000000);
INSERT INTO film_attribute_value (film_id, attribute_id, value_money) VALUES (4, 5, 377027325);
INSERT INTO film_attribute_value (film_id, attribute_id, value_money) VALUES (4, 6, 1140682011);
INSERT INTO film_attribute_value (film_id, attribute_id, value_money) VALUES (4, 7, 14085000);
INSERT INTO film_attribute_value (film_id, attribute_id, value_money) VALUES (5, 4, 55000000);
INSERT INTO film_attribute_value (film_id, attribute_id, value_money) VALUES (5, 5, 329694499);
INSERT INTO film_attribute_value (film_id, attribute_id, value_money) VALUES (5, 6, 677387716);
INSERT INTO film_attribute_value (film_id, attribute_id, value_money) VALUES (5, 7, 84460);

INSERT INTO film_attribute_value (film_id, attribute_id, value_numeric) VALUES (1, 8, 8.6);
INSERT INTO film_attribute_value (film_id, attribute_id, value_numeric) VALUES (1, 9, 9.1);
INSERT INTO film_attribute_value (film_id, attribute_id, value_numeric) VALUES (2, 8, 9.0);
INSERT INTO film_attribute_value (film_id, attribute_id, value_numeric) VALUES (2, 9, 8.8);
INSERT INTO film_attribute_value (film_id, attribute_id, value_numeric) VALUES (3, 8, 9.3);
INSERT INTO film_attribute_value (film_id, attribute_id, value_numeric) VALUES (3, 9, 9.1);
INSERT INTO film_attribute_value (film_id, attribute_id, value_numeric) VALUES (4, 8, 9.0);
INSERT INTO film_attribute_value (film_id, attribute_id, value_numeric) VALUES (4, 9, 8.6);
INSERT INTO film_attribute_value (film_id, attribute_id, value_numeric) VALUES (5, 8, 8.8);
INSERT INTO film_attribute_value (film_id, attribute_id, value_numeric) VALUES (5, 9, 8.9);

INSERT INTO film_attribute_value (film_id, attribute_id, value_boolean) VALUES (1, 10, false);
INSERT INTO film_attribute_value (film_id, attribute_id, value_boolean) VALUES (1, 11, false);
INSERT INTO film_attribute_value (film_id, attribute_id, value_boolean) VALUES (2, 10, true);
INSERT INTO film_attribute_value (film_id, attribute_id, value_boolean) VALUES (2, 12, true);
INSERT INTO film_attribute_value (film_id, attribute_id, value_boolean) VALUES (3, 10, false);
INSERT INTO film_attribute_value (film_id, attribute_id, value_boolean) VALUES (3, 11, false);
INSERT INTO film_attribute_value (film_id, attribute_id, value_boolean) VALUES (4, 10, true);
INSERT INTO film_attribute_value (film_id, attribute_id, value_boolean) VALUES (4, 11, true);
INSERT INTO film_attribute_value (film_id, attribute_id, value_boolean) VALUES (4, 12, true);
INSERT INTO film_attribute_value (film_id, attribute_id, value_boolean) VALUES (5, 10, true);
INSERT INTO film_attribute_value (film_id, attribute_id, value_boolean) VALUES (5, 11, true);
INSERT INTO film_attribute_value (film_id, attribute_id, value_boolean) VALUES (5, 12, true);

INSERT INTO film_attribute_value (film_id, attribute_id, value_date) VALUES (1, 13, '1999-12-06');
INSERT INTO film_attribute_value (film_id, attribute_id, value_date) VALUES (1, 14, '2000-04-18');
INSERT INTO film_attribute_value (film_id, attribute_id, value_date) VALUES (1, 15, '2001-02-13');
INSERT INTO film_attribute_value (film_id, attribute_id, value_date) VALUES (2, 13, '1993-11-30');
INSERT INTO film_attribute_value (film_id, attribute_id, value_date) VALUES (2, 14, '1994-05-21');
INSERT INTO film_attribute_value (film_id, attribute_id, value_date) VALUES (2, 15, '2004-09-28');
INSERT INTO film_attribute_value (film_id, attribute_id, value_date) VALUES (3, 13, '1994-09-10');
INSERT INTO film_attribute_value (film_id, attribute_id, value_date) VALUES (3, 14, '2019-10-24');
INSERT INTO film_attribute_value (film_id, attribute_id, value_date) VALUES (3, 15, '1994-09-01');
INSERT INTO film_attribute_value (film_id, attribute_id, value_date) VALUES (4, 13, '2003-12-01');
INSERT INTO film_attribute_value (film_id, attribute_id, value_date) VALUES (4, 14, '2004-01-22');
INSERT INTO film_attribute_value (film_id, attribute_id, value_date) VALUES (4, 15, '2004-05-25');
INSERT INTO film_attribute_value (film_id, attribute_id, value_date) VALUES (5, 13, '1994-06-23');
INSERT INTO film_attribute_value (film_id, attribute_id, value_date) VALUES (5, 14, '2020-02-13');
INSERT INTO film_attribute_value (film_id, attribute_id, value_date) VALUES (5, 15, '2009-12-01');

INSERT INTO film_attribute_value (film_id, attribute_id, value_date) VALUES (1, 16, current_date);
INSERT INTO film_attribute_value (film_id, attribute_id, value_date) VALUES (1, 17, current_date);
INSERT INTO film_attribute_value (film_id, attribute_id, value_date) VALUES (2, 16, current_date + INTERVAL '1 day');
INSERT INTO film_attribute_value (film_id, attribute_id, value_date) VALUES (2, 17, current_date + INTERVAL '1 day');
INSERT INTO film_attribute_value (film_id, attribute_id, value_date) VALUES (2, 16, current_date + INTERVAL '5 day');
INSERT INTO film_attribute_value (film_id, attribute_id, value_date) VALUES (2, 17, current_date + INTERVAL '5 day');
INSERT INTO film_attribute_value (film_id, attribute_id, value_date) VALUES (3, 16, current_date + INTERVAL '20 day');
INSERT INTO film_attribute_value (film_id, attribute_id, value_date) VALUES (3, 17, current_date + INTERVAL '10 day');
INSERT INTO film_attribute_value (film_id, attribute_id, value_date) VALUES (4, 16, current_date + INTERVAL '20 day');
INSERT INTO film_attribute_value (film_id, attribute_id, value_date) VALUES (4, 17, current_date + INTERVAL '20 day');
INSERT INTO film_attribute_value (film_id, attribute_id, value_date) VALUES (5, 16, current_date + INTERVAL '30 day');
INSERT INTO film_attribute_value (film_id, attribute_id, value_date) VALUES (5, 17, current_date + INTERVAL '20 day');