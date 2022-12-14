INSERT INTO "move_entity" ("id", "name") VALUES (1, 'Список Шиндлера');
INSERT INTO "move_entity" ("id", "name") VALUES (2, 'Зеленая миля');
INSERT INTO "move_entity" ("id", "name") VALUES (3, 'Властелин колец: Возвращение короля');
INSERT INTO "move_entity" ("id", "name") VALUES (4, 'Криминальное чтиво');
INSERT INTO "move_entity" ("id", "name") VALUES (5, 'Темный рыцарь');

INSERT INTO "move_attribute_type" ("id", "name") VALUES (1, 'Доход');
INSERT INTO "move_attribute_type" ("id", "name") VALUES (2, 'Расход');
INSERT INTO "move_attribute_type" ("id", "name") VALUES (3, 'Рейтинг');
INSERT INTO "move_attribute_type" ("id", "name") VALUES (4, 'Описание');
INSERT INTO "move_attribute_type" ("id", "name") VALUES (5, 'Рецензия');
INSERT INTO "move_attribute_type" ("id", "name") VALUES (6, 'Календарь');
INSERT INTO "move_attribute_type" ("id", "name") VALUES (7, 'Награды');

INSERT INTO "move_attribute" ("id", "move_attribute_type_id", "name") VALUES (1, 1, 'Сборы в США');
INSERT INTO "move_attribute" ("id", "move_attribute_type_id", "name") VALUES (2, 1, 'Сборы в мире');
INSERT INTO "move_attribute" ("id", "move_attribute_type_id", "name") VALUES (3, 2, 'Цена покупки фильма');
INSERT INTO "move_attribute" ("id", "move_attribute_type_id", "name") VALUES (4, 2, 'Бюджет фильма');
INSERT INTO "move_attribute" ("id", "move_attribute_type_id", "name") VALUES (5, 3, 'Рейтинг IMDb');
INSERT INTO "move_attribute" ("id", "move_attribute_type_id", "name") VALUES (6, 3, 'Рейтинг Кинопоиск');
INSERT INTO "move_attribute" ("id", "move_attribute_type_id", "name") VALUES (7, 3, 'Рейтинг MPAA');
INSERT INTO "move_attribute" ("id", "move_attribute_type_id", "name") VALUES (8, 4, 'Жанр');
INSERT INTO "move_attribute" ("id", "move_attribute_type_id", "name") VALUES (9, 4, 'Категория');
INSERT INTO "move_attribute" ("id", "move_attribute_type_id", "name") VALUES (10, 4, 'Продолжительность');
INSERT INTO "move_attribute" ("id", "move_attribute_type_id", "name") VALUES (11, 4, 'Минимальный возраст для просмотра');
INSERT INTO "move_attribute" ("id", "move_attribute_type_id", "name") VALUES (12, 4, 'Режисер');
INSERT INTO "move_attribute" ("id", "move_attribute_type_id", "name") VALUES (13, 4, 'Краткое описание');
INSERT INTO "move_attribute" ("id", "move_attribute_type_id", "name") VALUES (14, 5, 'Рецензии зрителей');
INSERT INTO "move_attribute" ("id", "move_attribute_type_id", "name") VALUES (15, 6, 'Премьера в мире');
INSERT INTO "move_attribute" ("id", "move_attribute_type_id", "name") VALUES (16, 6, 'Премьера в России');
INSERT INTO "move_attribute" ("id", "move_attribute_type_id", "name") VALUES (17, 6, 'Запуск рекламы');
INSERT INTO "move_attribute" ("id", "move_attribute_type_id", "name") VALUES (18, 6, 'Дата показа фильма в кинотеатре');
INSERT INTO "move_attribute" ("id", "move_attribute_type_id", "name") VALUES (19, 6, 'Релиз DVD');
INSERT INTO "move_attribute" ("id", "move_attribute_type_id", "name") VALUES (20, 7, 'Оскар');
INSERT INTO "move_attribute" ("id", "move_attribute_type_id", "name") VALUES (21, 7, 'Сезар');
INSERT INTO "move_attribute" ("id", "move_attribute_type_id", "name") VALUES (22, 7, 'Золотой глобус');

INSERT INTO "move_value" ("id", "move_entity_id", "move_attribute_id", "value_decimal") VALUES (1, 1, 1, 96065768);
INSERT INTO "move_value" ("id", "move_entity_id", "move_attribute_id", "value_decimal") VALUES (2, 1, 2, 321306305);
INSERT INTO "move_value" ("id", "move_entity_id", "move_attribute_id", "value_decimal") VALUES (3, 1, 3, 1000);
INSERT INTO "move_value" ("id", "move_entity_id", "move_attribute_id", "value_decimal") VALUES (4, 1, 4, 22000000);
INSERT INTO "move_value" ("id", "move_entity_id", "move_attribute_id", "value_decimal") VALUES (5, 1, 5, 9.00);
INSERT INTO "move_value" ("id", "move_entity_id", "move_attribute_id", "value_decimal") VALUES (6, 1, 6, 8.8);
INSERT INTO "move_value" ("id", "move_entity_id", "move_attribute_id", "value_string") VALUES (7, 1, 7, 'R');
INSERT INTO "move_value" ("id", "move_entity_id", "move_attribute_id", "value_text") VALUES (8, 1, 8, 'драма, биография, история, военный');
INSERT INTO "move_value" ("id", "move_entity_id", "move_attribute_id", "value_string") VALUES (9, 1, 9, '250 лучших фильмов');
INSERT INTO "move_value" ("id", "move_entity_id", "move_attribute_id", "value_int") VALUES (10, 1, 10, 195);
INSERT INTO "move_value" ("id", "move_entity_id", "move_attribute_id", "value_int") VALUES (11, 1, 11, 16);
INSERT INTO "move_value" ("id", "move_entity_id", "move_attribute_id", "value_string") VALUES (12, 1, 12, 'Стивен Спилберг');
INSERT INTO "move_value" ("id", "move_entity_id", "move_attribute_id", "value_text") VALUES (13, 1, 13, 'История немецкого промышленника, спасшего тысячи жизней во время Холокоста. Драма Стивена Спилберга');
INSERT INTO
    "move_value"
    ("id", "move_entity_id", "move_attribute_id", "value_jsonb")
VALUES
    (14, 1, 14, '{"Zoso": "Самый лучший фильм Спилберга, и самая лучшая режиссёрская работа всех времён. Фильм снят чёрно-белым, т.к.Спилберг сказал, что эта тема у него всегда ассоциировалась с чёрно-белыми документальными фильмами. По большому счёту в фильме нет ничего оригинального, он просто показывает тяжёлый и страшный период жизни людей, который основан на реальных событиях. Но к счастью Стивен Спилберг - просто маньяк в сфере режиссуры, он из каждого своего фильма старается выжать всё по максимуму, а в этом фильме он просто делает невозможное. Фильм просто нашпигован гениальными режиссёрским кино моментами, которые просто потрясают.",
  "DimMcMurfy": "Отто фон Шиндлер (кличка Моисей). Предприниматель, вхожий в кабинеты высших чинов Третьего рейха. Наша разведка до сих пор затрудняется назвать причины этого. Умен, квалифицирован, дерзок.Характер нордический. Женат не ясно на ком. Цель - воссоздание современной трактовки исхода евреев из Египта.\n\nДанный резидент обладает мощными характеристиками, как то:\n\n1) Харизматичен. Может с легкостью обводить вокруг пальца глупый офицерский состав. Останавливает поезда с заключенными силой мысли. Убеждает различные исчадия Ада не убивать, используя лишь силу логики.\n\n2) Красив. Скачет на коне, имеет много женщин и автомобиль.\n\n3) Дальновиден. Ну тут все понятно.", "Lena Fadeeva": "В плане сухого исторического материала в виде фактов и цифр тема фильма не стала для меня откровением, я все это уже знала и даже умудрилась пропустить через себя много лет назад, когда в институте писала диплом на тему германского фашизма и когда удалось переворошить горы литературы о нацизме. Тогда был настоящий шок и очень много слез. Фильм посмотрела только сейчас, и это стало столкновением с чем-то живым, совершенно не книжным, и стоило мне огромного душевного напряжения, почти физической боли, которую я как будто бы ощущала вместе с теми, кого на экране били, расстреливали, сжигали… Откровением стало именно то, как сумел Стивен Спилберг до дрожи реалистично и достоверно выразить атмосферу той страшной эпохи, когда мир буквально захлебнулся в крови, а самые святые ценности и моральные устои, на которых строилось человеческое существование, были преданы поруганию."}');
INSERT INTO "move_value" ("id", "move_entity_id", "move_attribute_id", "value_timestamp") VALUES (15, 1, 15, '1993-11-30');
INSERT INTO "move_value" ("id", "move_entity_id", "move_attribute_id", "value_timestamp") VALUES (16, 1, 16, '1994-05-21');
INSERT INTO "move_value" ("id", "move_entity_id", "move_attribute_id", "value_timestamp") VALUES (17, 1, 17, CURRENT_DATE); /*Запуск рекламы*/
INSERT INTO "move_value" ("id", "move_entity_id", "move_attribute_id", "value_timestamp") VALUES (18, 1, 18, CURRENT_DATE + INTERVAL '20 days'); /*Дата показа фильма в кинотеатре*/
INSERT INTO "move_value" ("id", "move_entity_id", "move_attribute_id", "value_timestamp") VALUES (19, 1, 19, '2004-09-28');
INSERT INTO "move_value" ("id", "move_entity_id", "move_attribute_id", "value_text") VALUES (20, 1, 20, 'Лучший фильм, Лучший режисcер, Лучший адаптированный сценарий, Лучшая работа оператора, Лучшие декорации, Лучший монтаж, Лучший оригинальный саундтрек');
INSERT INTO "move_value" ("id", "move_entity_id", "move_attribute_id", "value_text") VALUES (21, 1, 21, 'Лучший фильм на иностранном языке'); /*Сезар*/
INSERT INTO "move_value" ("id", "move_entity_id", "move_attribute_id", "value_text") VALUES (22, 1, 22, 'Лучший фильм, Лучший режиссер, Лучший сценарий');

/*Зеленая миля*/
INSERT INTO "move_value" ("id", "move_entity_id", "move_attribute_id", "value_decimal") VALUES (23, 2, 1, 136801374);
INSERT INTO "move_value" ("id", "move_entity_id", "move_attribute_id", "value_decimal") VALUES (24, 2, 2, 286801374);
INSERT INTO "move_value" ("id", "move_entity_id", "move_attribute_id", "value_decimal") VALUES (25, 2, 3, 750);
INSERT INTO "move_value" ("id", "move_entity_id", "move_attribute_id", "value_decimal") VALUES (26, 2, 4, 60000000);
INSERT INTO "move_value" ("id", "move_entity_id", "move_attribute_id", "value_decimal") VALUES (27, 2, 5, 8.60);
INSERT INTO "move_value" ("id", "move_entity_id", "move_attribute_id", "value_decimal") VALUES (28, 2, 6, 9.1);
INSERT INTO "move_value" ("id", "move_entity_id", "move_attribute_id", "value_string") VALUES (29, 2, 7, 'R');
INSERT INTO "move_value" ("id", "move_entity_id", "move_attribute_id", "value_text") VALUES (30, 2, 8, 'драма, криминал');
INSERT INTO "move_value" ("id", "move_entity_id", "move_attribute_id", "value_string") VALUES (31, 2, 9, '250 лучших фильмов');
INSERT INTO "move_value" ("id", "move_entity_id", "move_attribute_id", "value_int") VALUES (32, 2, 10, 189);
INSERT INTO "move_value" ("id", "move_entity_id", "move_attribute_id", "value_int") VALUES (33, 2, 11, 16);
INSERT INTO "move_value" ("id", "move_entity_id", "move_attribute_id", "value_string") VALUES (34, 2, 12, 'Фрэнк Дарабонт');
INSERT INTO "move_value" ("id", "move_entity_id", "move_attribute_id", "value_text") VALUES (35, 2, 13, 'В тюрьме для смертников появляется заключенный с божественным даром. Мистическая драма по роману Стивена Кинга');
INSERT INTO
    "move_value"
("id", "move_entity_id", "move_attribute_id", "value_jsonb")
VALUES
    (36, 2, 14, '{"P.S.SeLeNa": "''Они помогли ему убить себя и так происходит каждый день во всем мире''...\n\nФильм, который я могу смело назвать шедевром. Фильм, который длится три часа и которые пролетают незаметно. Фильм, который смотрится каждый раз как в первый. Фильм, который нельзя забыть и которым нельзя не проникнуться. Фильм, котрый заставляет задуматься о жизни, которую мы тратим на пустяки, теша себя иллюзией бессмертия, о смерти, которая не щадит никого.\n\nФильм о зле, которое не всегда наказуемо и о добре, которое подчас бессильно что-либо изменить. И тебе остается лишь смотреть на то, как вершится суд, над тем кто не должен сидеть на скамье подсудимых.\n\nФильм, который изменил мое мировоззрение и научил по-другому относиться к жизни.", "Боб": "Сюжет идентичен с книгой Стивена Кинга, поэтому буду краток. Пол Эджкомб работает начальником тюремного блока. Это не простой блок — здесь проводят свои последние недели люди, осужденные на смертную казнь — самые отъявленные уголовники: маньяки, насильники, убийцы. Пол проработал здесь много лет, провел сотни казней и научился быть циником, но так и не научился быть убийцей. Он сумел сохранить в себе человека, как и три его закадычных друга, работающих с ним же. Свои последние шаги в качестве живого человека смертники назвали «зеленой милей», потому что пол длинного коридора, по которому вели заключенного в последний путь был покрыт линолеумом зеленого цвета."}');
INSERT INTO "move_value" ("id", "move_entity_id", "move_attribute_id", "value_timestamp") VALUES (37, 2, 15, '1999-12-06');
INSERT INTO "move_value" ("id", "move_entity_id", "move_attribute_id", "value_timestamp") VALUES (38, 2, 16, '2000-04-18');
INSERT INTO "move_value" ("id", "move_entity_id", "move_attribute_id", "value_timestamp") VALUES (39, 2, 17, CURRENT_DATE); /*Запуск рекламы*/
INSERT INTO "move_value" ("id", "move_entity_id", "move_attribute_id", "value_timestamp") VALUES (40, 2, 18, CURRENT_DATE + INTERVAL '20 days'); /*Дата показа фильма в кинотеатре*/
INSERT INTO "move_value" ("id", "move_entity_id", "move_attribute_id", "value_timestamp") VALUES (41, 2, 19, '2001-02-13');
INSERT INTO "move_value" ("id", "move_entity_id", "move_attribute_id", "value_text") VALUES (42, 2, 20, 'лучший фильм, лучшая мужская роль второго плана, лучший адаптированный сценарий, лучший звук');
INSERT INTO "move_value" ("id", "move_entity_id", "move_attribute_id", "value_text") VALUES (43, 2, 22, 'лучшая мужская роль второго плана');

/*Властелин колец: Возвращение короля*/
INSERT INTO "move_value" ("id", "move_entity_id", "move_attribute_id", "value_decimal") VALUES (44, 3, 1, 377027325); /*сборы в США*/
INSERT INTO "move_value" ("id", "move_entity_id", "move_attribute_id", "value_decimal") VALUES (45, 3, 2, 1140682011); /*сборы в мире*/
INSERT INTO "move_value" ("id", "move_entity_id", "move_attribute_id", "value_decimal") VALUES (46, 3, 3, 2750); /*Цена покупка фильма*/
INSERT INTO "move_value" ("id", "move_entity_id", "move_attribute_id", "value_decimal") VALUES (47, 3, 4, 94000000); /*Бюджет фильма*/
INSERT INTO "move_value" ("id", "move_entity_id", "move_attribute_id", "value_decimal") VALUES (48, 3, 5, 9.00); /*Рейтинг IMDb*/
INSERT INTO "move_value" ("id", "move_entity_id", "move_attribute_id", "value_decimal") VALUES (49, 3, 6, 8.6); /*Рейтинг Кинопоиск*/
INSERT INTO "move_value" ("id", "move_entity_id", "move_attribute_id", "value_string") VALUES (50, 3, 7, 'PG-13'); /*Рейтинг MPAA*/
INSERT INTO "move_value" ("id", "move_entity_id", "move_attribute_id", "value_text") VALUES (51, 3, 8, 'фэнтези, приключения, драма'); /*Жанр*/
INSERT INTO "move_value" ("id", "move_entity_id", "move_attribute_id", "value_string") VALUES (52, 3, 9, '250 лучших фильмов'); /*Категория*/
INSERT INTO "move_value" ("id", "move_entity_id", "move_attribute_id", "value_int") VALUES (53, 3, 10, 201); /*Продолжительность*/
INSERT INTO "move_value" ("id", "move_entity_id", "move_attribute_id", "value_int") VALUES (54, 3, 11, 12); /*Минимальный возраст для просмотра*/
INSERT INTO "move_value" ("id", "move_entity_id", "move_attribute_id", "value_string") VALUES (55, 3, 12, 'Питер Джексон'); /*Режисер*/
INSERT INTO "move_value" ("id", "move_entity_id", "move_attribute_id", "value_text") VALUES (56, 3, 13, 'There can be no triumph without loss. No victory without suffering. No freedom without sacrifice'); /*Краткое описание*/
INSERT INTO
    "move_value"
("id", "move_entity_id", "move_attribute_id", "value_jsonb")
VALUES
    (57, 3, 14, '{"aly-dashka": "Я не маньяк, но просмотрел в общей сложности всю трилогию около 30 раз! И при том не пожалел ни одного часа потраченного на это дело. И я не понимаю тех людей, которые, делая отрешонное от этого мира лицо, говорят, что скучнее фильма не видели, и что засыпают они на 15 минуте просмотра. И как часто я встречаю фразу, что это ''очередное'' фэнтези. Как же неправы люди заявляющие это. Ведь это самое первое в мире фэнтези! Ведь уважаемый толкиенистами английский профессор Дж.Р.Р.Толкин является создателем, если хотите отцом этого жанра. Его ВК - это первое фэнтези в мире, к тому же историческое.", "Genious_Fox": "Мне странно, что отзывы о таком шедевре настолько холодные… Такое впечатление что тут открыли форум критиков ''ВК''…\n\nФильм поражает своей масштабностью, красотой и глубиной образов и самого мира — до сих пор удивляюсь, как мог один человек создать целый мир, целую эпоху со своими мифами, героями, географией, летоисчеслением, прошлым, настояшим и будующим!\n\nГений Толкиена идеально перенесен на большие экраны и экранизация романа просто разрывает тебя на куски! Когда смотришь фильм - ты попадаешь в сказку... причем не добрую и поучительную, а реалистичную и жесткую, где высоко приподнесены такие извечные ценности как честь, достоинство, отвага, долг."}'); /*Рецензии зрителей*/
INSERT INTO "move_value" ("id", "move_entity_id", "move_attribute_id", "value_timestamp") VALUES (58, 3, 15, '2003-12-01'); /*Премьера в мире*/
INSERT INTO "move_value" ("id", "move_entity_id", "move_attribute_id", "value_timestamp") VALUES (59, 3, 16, '2004-01-22'); /*Премьера в Росии*/
INSERT INTO "move_value" ("id", "move_entity_id", "move_attribute_id", "value_timestamp") VALUES (60, 3, 17, CURRENT_DATE); /*Запуск рекламы*/
INSERT INTO "move_value" ("id", "move_entity_id", "move_attribute_id", "value_timestamp") VALUES (61, 3, 18, CURRENT_DATE + INTERVAL '20 days'); /*Дата показа фильма в кинотеатре*/
INSERT INTO "move_value" ("id", "move_entity_id", "move_attribute_id", "value_timestamp") VALUES (62, 3, 19, '2004-05-25'); /*Релиз DVD*/
INSERT INTO "move_value" ("id", "move_entity_id", "move_attribute_id", "value_text") VALUES (63, 3, 20, 'лучший фильм, лучший режиссер, лучший адаптированный сценарий, лучшие декорации, лучшие костюмы, лучший звук, лучший монтаж, лучшие визуальные эффекты, лучший грим, лучшая песня, лучший оригинальный саундтрек'); /*Оскар*/
INSERT INTO "move_value" ("id", "move_entity_id", "move_attribute_id", "value_text") VALUES (64, 3, 22, 'лучший фильм (драма), лучший режиссер, лучшая песня, лучший саундтрек'); /*Золотой глобус*/

/*Криминальное чтиво*/
INSERT INTO "move_value" ("id", "move_entity_id", "move_attribute_id", "value_decimal") VALUES (65, 4, 1, 107928762); /*сборы в США*/
INSERT INTO "move_value" ("id", "move_entity_id", "move_attribute_id", "value_decimal") VALUES (66, 4, 2, 213928762); /*сборы в мире*/
INSERT INTO "move_value" ("id", "move_entity_id", "move_attribute_id", "value_decimal") VALUES (67, 4, 3, 1750); /*Цена покупка фильма*/
INSERT INTO "move_value" ("id", "move_entity_id", "move_attribute_id", "value_decimal") VALUES (68, 4, 4, 8000000); /*Бюджет фильма*/
INSERT INTO "move_value" ("id", "move_entity_id", "move_attribute_id", "value_decimal") VALUES (69, 4, 5, 8.9); /*Рейтинг IMDb*/
INSERT INTO "move_value" ("id", "move_entity_id", "move_attribute_id", "value_decimal") VALUES (70, 4, 6, 8.6); /*Рейтинг Кинопоиск*/
INSERT INTO "move_value" ("id", "move_entity_id", "move_attribute_id", "value_string") VALUES (71, 4, 7, 'R'); /*Рейтинг MPAA*/
INSERT INTO "move_value" ("id", "move_entity_id", "move_attribute_id", "value_text") VALUES (72, 4, 8, 'криминал, драма'); /*Жанр*/
INSERT INTO "move_value" ("id", "move_entity_id", "move_attribute_id", "value_string") VALUES (73, 4, 9, '250 лучших фильмов'); /*Категория*/
INSERT INTO "move_value" ("id", "move_entity_id", "move_attribute_id", "value_int") VALUES (74, 4, 10, 154); /*Продолжительность*/
INSERT INTO "move_value" ("id", "move_entity_id", "move_attribute_id", "value_int") VALUES (75, 4, 11, 18); /*Минимальный возраст для просмотра*/
INSERT INTO "move_value" ("id", "move_entity_id", "move_attribute_id", "value_string") VALUES (76, 4, 12, 'Квентин Тарантино'); /*Режисер*/
INSERT INTO "move_value" ("id", "move_entity_id", "move_attribute_id", "value_text") VALUES (77, 4, 13, 'Несколько связанных историй из жизни бандитов. Шедевр Квентина Тарантино, который изменил мировое кино'); /*Краткое описание*/
INSERT INTO
    "move_value"
("id", "move_entity_id", "move_attribute_id", "value_jsonb")
VALUES
    (78, 4, 14, '{"HelenN": "Каждый год на экран выходит n-нное количество фильмов. Публика жаждет новинок, режиссёры – больших кассовых сборов, актёры – славы. 1994 год – это год «богатого урожая» в кино, подаривший фильмы: «Форрест Гамп», «Побег из Шоушенка», «Ворон», «Интервью с вампиром», «Леон», «Маска», «Мэверик», а так же «Криминальное чтиво» - не лыком сшитое. О нём-то сейчас и идёт речь.", "Serjio128": "Если меня спросят, о чём этот фильм, то я ответить не смогу, потому что фильм ни о чём. Никакой темы, никакой идеи я не увидел. Чему хотел научить и что вообще хотел показать Тарантино, я не понял. Эти постоянно нудные, граничащие с пошлостью диалоги, которые и составляют основу фильма мне никак не были примечательны. Не понимаю, как этот фильм получил Оскара за лучший сценарий! Было невыносимо скучно смотреть, но я заставил себя досидеть до конца. Не лучшие два с половиной часа в моей жизни..."}'); /*Рецензии зрителей*/
INSERT INTO "move_value" ("id", "move_entity_id", "move_attribute_id", "value_timestamp") VALUES (79, 4, 15, '1994-05-21'); /*Премьера в мире*/
INSERT INTO "move_value" ("id", "move_entity_id", "move_attribute_id", "value_timestamp") VALUES (80, 4, 16, '1995-09-29'); /*Премьера в Росии*/
INSERT INTO "move_value" ("id", "move_entity_id", "move_attribute_id", "value_timestamp") VALUES (81, 4, 17, CURRENT_DATE); /*Запуск рекламы*/
INSERT INTO "move_value" ("id", "move_entity_id", "move_attribute_id", "value_timestamp") VALUES (82, 4, 18, CURRENT_DATE + INTERVAL '20 days'); /*Дата показа фильма в кинотеатре*/
INSERT INTO "move_value" ("id", "move_entity_id", "move_attribute_id", "value_timestamp") VALUES (83, 4, 19, '2002-01-31'); /*Релиз DVD*/
INSERT INTO "move_value" ("id", "move_entity_id", "move_attribute_id", "value_text") VALUES (84, 4, 20, 'лучший фильм, лучшая мужская роль, лучшая мужская ролль второго плана, лучшая женская роль второго плана, лучший режиссер, лучший монтаж'); /*Оскар*/
INSERT INTO "move_value" ("id", "move_entity_id", "move_attribute_id", "value_text") VALUES (85, 4, 21, 'лучший фильм на инсотранном языке'); /*Сезар*/
INSERT INTO "move_value" ("id", "move_entity_id", "move_attribute_id", "value_text") VALUES (86, 4, 22, 'лучший фильм (драма), луяшая мужская роль, лучшая мусжкая роль второго плана, лучшая женская роль второго плана, лучший режисер'); /*Золотой глобус*/

/*Темный рыцарь*/
INSERT INTO "move_value" ("id", "move_entity_id", "move_attribute_id", "value_decimal") VALUES (87, 5, 1, 533345358); /*сборы в США*/
INSERT INTO "move_value" ("id", "move_entity_id", "move_attribute_id", "value_decimal") VALUES (88, 5, 2, 1003045358); /*сборы в мире*/
INSERT INTO "move_value" ("id", "move_entity_id", "move_attribute_id", "value_decimal") VALUES (89, 5, 3, 1100); /*Цена покупка фильма*/
INSERT INTO "move_value" ("id", "move_entity_id", "move_attribute_id", "value_decimal") VALUES (90, 5, 4, 185000000); /*Бюджет фильма*/
INSERT INTO "move_value" ("id", "move_entity_id", "move_attribute_id", "value_decimal") VALUES (91, 5, 5, 9.00); /*Рейтинг IMDb*/
INSERT INTO "move_value" ("id", "move_entity_id", "move_attribute_id", "value_decimal") VALUES (92, 5, 6, 8.5); /*Рейтинг Кинопоиск*/
INSERT INTO "move_value" ("id", "move_entity_id", "move_attribute_id", "value_string") VALUES (93, 5, 7, 'PG-13'); /*Рейтинг MPAA*/
INSERT INTO "move_value" ("id", "move_entity_id", "move_attribute_id", "value_text") VALUES (94, 5, 8, 'фантастика, боевик, триллер, криминал, драма'); /*Жанр*/
INSERT INTO "move_value" ("id", "move_entity_id", "move_attribute_id", "value_string") VALUES (95, 5, 9, '250 лучших фильмов'); /*Категория*/
INSERT INTO "move_value" ("id", "move_entity_id", "move_attribute_id", "value_int") VALUES (96, 5, 10, 152); /*Продолжительность*/
INSERT INTO "move_value" ("id", "move_entity_id", "move_attribute_id", "value_int") VALUES (97, 5, 11, 16); /*Минимальный возраст для просмотра*/
INSERT INTO "move_value" ("id", "move_entity_id", "move_attribute_id", "value_string") VALUES (98, 5, 12, 'Кристофер Нолан'); /*Режисер*/
INSERT INTO "move_value" ("id", "move_entity_id", "move_attribute_id", "value_text") VALUES (99, 5, 13, 'У Бэтмена появляется новый враг — философ-террорист Джокер. Кинокомикс, который вывел жанр на новый уровень'); /*Краткое описание*/
INSERT INTO
    "move_value"
("id", "move_entity_id", "move_attribute_id", "value_jsonb")
VALUES
    (100, 5, 14, '{"re-D-rum": "Только что с премьеры. Эмоции переполняют. Я, честно говоря, не могу представить реакцию большинства зрителей, но мне, в отличие от трёх моих друзей, фильм безумно понравился!", "Macabre": "Хруст поп-корна, непрекращающиеся разговоры, доносящиеся с задних рядов на протяжении второй половины фильма, тяжёлые вздохи и слова ''наконец-то'' сказанные кем-то сразу же после того, как пошли титры..."}'); /*Рецензии зрителей*/
INSERT INTO "move_value" ("id", "move_entity_id", "move_attribute_id", "value_timestamp") VALUES (101, 5, 15, '2008-07-14'); /*Премьера в мире*/
INSERT INTO "move_value" ("id", "move_entity_id", "move_attribute_id", "value_timestamp") VALUES (102, 5, 16, '2008-08-14'); /*Премьера в Росии*/
INSERT INTO "move_value" ("id", "move_entity_id", "move_attribute_id", "value_timestamp") VALUES (103, 5, 17, CURRENT_DATE); /*Запуск рекламы*/
INSERT INTO "move_value" ("id", "move_entity_id", "move_attribute_id", "value_timestamp") VALUES (104, 5, 18, CURRENT_DATE + INTERVAL '20 days'); /*Дата показа фильма в кинотеатре*/
INSERT INTO "move_value" ("id", "move_entity_id", "move_attribute_id", "value_timestamp") VALUES (105, 5, 19, '2008-12-09'); /*Релиз DVD*/
INSERT INTO "move_value" ("id", "move_entity_id", "move_attribute_id", "value_text") VALUES (106, 5, 20, 'лучшая мужская роль второго плана, лучший монтаж звука, лучшая работа оператора, лучшие декорации, лучший звук, лучший монтаж, лучшие визуальные эффекты, лучший грим'); /*Оскар*/
INSERT INTO "move_value" ("id", "move_entity_id", "move_attribute_id", "value_text") VALUES (107, 5, 22, 'лучшая мужская роль второго плана'); /*Золотой глобус*/