INSERT INTO "customer" ("id", "name", "surname", "email", "phone") VALUES (1, 'Клара', 'Цветаева', 'zvisnakov@orlova.ru', '(35222) 53-7777');
INSERT INTO "customer" ("id", "name", "surname", "email", "phone") VALUES (2, 'Пётр', 'Поляков', 'margarita.rogova@subina.ru', '(812) 443-22-59');
INSERT INTO "customer" ("id", "name", "surname", "email", "phone") VALUES (3, 'Розалина', 'Алексеева', 'zrogov@yandex.ru', '(35222) 83-4338');
INSERT INTO "customer" ("id", "name", "surname", "email", "phone") VALUES (4, 'Светлана', 'Березина', 'prohor88@silov.ru', '(495) 828-7472');
INSERT INTO "customer" ("id", "name", "surname", "email", "phone") VALUES (5, 'Альбина', 'Соколова', 'kalasnikova.rafail@blinov.ru', '(495) 734-1923');
INSERT INTO "customer" ("id", "name", "surname", "email", "phone") VALUES (6, 'Аполлон', 'Герасимов', 'pgorskov@inbox.ru', '+7 (922) 972-4770');
INSERT INTO "customer" ("id", "name", "surname", "email", "phone") VALUES (7, 'Александра', 'Кузнецова', 'vikentij85@denisov.org', '(495) 206-2670');
INSERT INTO "customer" ("id", "name", "surname", "email", "phone") VALUES (8, 'Ирина', 'Соколова', 'jisaev@ya.ru', '(35222) 86-3206');
INSERT INTO "customer" ("id", "name", "surname", "email", "phone") VALUES (9, 'Ника', 'Петрова', 'alla81@vlasova.ru', '8-800-145-7171');
INSERT INTO "customer" ("id", "name", "surname", "email", "phone") VALUES (10, 'Олег', 'Борисов', 'sgorbunova@grisina.ru', '(35222) 36-2912');

INSERT INTO "cinema_hall" ("id", "name", "max_places") VALUES (1, 'VIP', 100);
INSERT INTO "cinema_hall" ("id", "name", "max_places") VALUES (2, 'IMAX', 50);
INSERT INTO "cinema_hall" ("id", "name", "max_places") VALUES (3, 'RELAX', 25);

INSERT INTO "move" ("id", "name", "description", "release_date", "duration") VALUES (1, 'Мстители', 'Команда супергероев дает отпор скандинавскому богу Локи. Начало фантастической саги в киновселенной Marvel', '2012-05-03', 137);
INSERT INTO "move" ("id", "name", "description", "release_date", "duration") VALUES (2, 'Человек-паук: Нет пути домой', 'Жизнь и репутация Питера Паркера оказываются под угрозой, поскольку Мистерио раскрыл всему миру тайну личности Человека-паука. Пытаясь исправить ситуацию, Питер обращается за помощью к Стивену Стрэнджу, но вскоре всё становится намного опаснее.', '2021-12-15', 148);
INSERT INTO "move" ("id", "name", "description", "release_date", "duration") VALUES (3, 'Аватар', 'Бывший морпех Джейк Салли прикован к инвалидному креслу. Несмотря на немощное тело, Джейк в душе по-прежнему остается воином. Он получает задание совершить путешествие в несколько световых лет к базе землян на планете Пандора, где корпорации добывают редкий минерал, имеющий огромное значение для выхода Земли из энергетического кризиса.', '2009-12-17', 162);
INSERT INTO "move" ("id", "name", "description", "release_date", "duration") VALUES (4, 'Зеленая миля', 'В тюрьме для смертников появляется заключенный с божественным даром. Мистическая драма по роману Стивена Кинга', '2000-04-18', 189);
INSERT INTO "move" ("id", "name", "description", "release_date", "duration") VALUES (5, 'Властелин колец: Возвращение короля', 'Повелитель сил тьмы Саурон направляет свою бесчисленную армию под стены Минас-Тирита, крепости Последней Надежды. Он предвкушает близкую победу, но именно это мешает ему заметить две крохотные фигурки — хоббитов, приближающихся к Роковой Горе, где им предстоит уничтожить Кольцо Всевластья.', '2004-01-22', 201);
INSERT INTO "move" ("id", "name", "description", "release_date", "duration") VALUES (6, 'Интерстеллар', 'Когда засуха, пыльные бури и вымирание растений приводят человечество к продовольственному кризису, коллектив исследователей и учёных отправляется сквозь червоточину (которая предположительно соединяет области пространства-времени через большое расстояние) в путешествие, чтобы превзойти прежние ограничения для космических путешествий человека и найти планету с подходящими для человечества условиями.', '2014-11-06', 169);

INSERT INTO "session" ("id", "name", "move_id", "cinema_hall_id", "price") VALUES (1, 'Мстители', 1, 1, 250);
INSERT INTO "session" ("id", "name", "move_id", "cinema_hall_id", "price") VALUES (2, 'Мстители', 1, 2, 300);
INSERT INTO "session" ("id", "name", "move_id", "cinema_hall_id", "price") VALUES (3, 'Мстители', 1, 3, 400);
INSERT INTO "session" ("id", "name", "move_id", "cinema_hall_id", "price") VALUES (4, 'Человек-паук: Нет пути домой', 2, 1, 350);
INSERT INTO "session" ("id", "name", "move_id", "cinema_hall_id", "price") VALUES (5, 'Человек-паук: Нет пути домой', 2, 2, 200);
INSERT INTO "session" ("id", "name", "move_id", "cinema_hall_id", "price") VALUES (6, 'Аватар', 3, 2, 400);
INSERT INTO "session" ("id", "name", "move_id", "cinema_hall_id", "price") VALUES (7, 'Зеленая миля', 4, 3, 350);
INSERT INTO "session" ("id", "name", "move_id", "cinema_hall_id", "price") VALUES (8, 'Властелин колец: Возвращение короля', 5, 1, 200);
INSERT INTO "session" ("id", "name", "move_id", "cinema_hall_id", "price") VALUES (9, 'Властелин колец: Возвращение короля', 5, 3, 250);
INSERT INTO "session" ("id", "name", "move_id", "cinema_hall_id", "price") VALUES (10, 'Интерстеллар', 6, 2, 200);
INSERT INTO "session" ("id", "name", "move_id", "cinema_hall_id", "price") VALUES (11, 'Интерстеллар', 6, 3, 250);

INSERT INTO "schedule"  ("id", "session_id", "start_date_session", "start_time_session") VALUES (1, 1, '2022-08-01', '08:00:00');
INSERT INTO "schedule"  ("id", "session_id", "start_date_session", "start_time_session") VALUES (2, 2, '2022-08-01', '08:00:00');
INSERT INTO "schedule"  ("id", "session_id", "start_date_session", "start_time_session") VALUES (3, 3, '2022-08-01', '08:00:00');
INSERT INTO "schedule"  ("id", "session_id", "start_date_session", "start_time_session") VALUES (4, 4, '2022-08-01', '09:35:00');
INSERT INTO "schedule"  ("id", "session_id", "start_date_session", "start_time_session") VALUES (5, 5, '2022-08-01', '09:35:00');
INSERT INTO "schedule"  ("id", "session_id", "start_date_session", "start_time_session") VALUES (6, 6, '2022-08-01', '11:05:00');
INSERT INTO "schedule"  ("id", "session_id", "start_date_session", "start_time_session") VALUES (7, 7, '2022-08-01', '09:00:00');
INSERT INTO "schedule"  ("id", "session_id", "start_date_session", "start_time_session") VALUES (8, 8, '2022-08-01', '12:40:00');
INSERT INTO "schedule"  ("id", "session_id", "start_date_session", "start_time_session") VALUES (9, 9, '2022-08-01', '11:00:00');
INSERT INTO "schedule"  ("id", "session_id", "start_date_session", "start_time_session") VALUES (10, 10, '2022-08-01', '14:00:00');
INSERT INTO "schedule"  ("id", "session_id", "start_date_session", "start_time_session") VALUES (11, 11, '2022-08-01', '20:00:00');

INSERT INTO "ticket" ("id", "date_of_sale", "time_of_sale", "customer_id", "schedule_id") VALUES (1, '2022-07-29', '13:25:00', 1, 1);
INSERT INTO "ticket" ("id", "date_of_sale", "time_of_sale", "customer_id", "schedule_id") VALUES (2, '2022-07-28', '10:05:12', 2, 2);
INSERT INTO "ticket" ("id", "date_of_sale", "time_of_sale", "customer_id", "schedule_id") VALUES (3, '2022-07-25', '11:23:20', 3, 2);
INSERT INTO "ticket" ("id", "date_of_sale", "time_of_sale", "customer_id", "schedule_id") VALUES (4, '2022-07-29', '09:10:01', 4, 4);
INSERT INTO "ticket" ("id", "date_of_sale", "time_of_sale", "customer_id", "schedule_id") VALUES (5, '2022-07-28', '09:00:00', 5, 4);
INSERT INTO "ticket" ("id", "date_of_sale", "time_of_sale", "customer_id", "schedule_id") VALUES (6, '2022-07-10', '18:10:15', 6, 4);
INSERT INTO "ticket" ("id", "date_of_sale", "time_of_sale", "customer_id", "schedule_id") VALUES (7, '2022-07-05', '22:10:10', 7, 6);
INSERT INTO "ticket" ("id", "date_of_sale", "time_of_sale", "customer_id", "schedule_id") VALUES (8, '2022-07-12', '15:10:12', 8, 8);
INSERT INTO "ticket" ("id", "date_of_sale", "time_of_sale", "customer_id", "schedule_id") VALUES (9, '2022-07-21', '20:15:10', 9, 7);
INSERT INTO "ticket" ("id", "date_of_sale", "time_of_sale", "customer_id", "schedule_id") VALUES (10, '2022-07-19', '16:18:05', 10, 11);

INSERT INTO "occupied_cinema_hall_seats" ("id", "ticket_id", "cinema_hall_id", "row", "place") VALUES (1, 1, 1, 3, 5);
INSERT INTO "occupied_cinema_hall_seats" ("id", "ticket_id", "cinema_hall_id", "row", "place") VALUES (2, 2, 2, 2, 10);
INSERT INTO "occupied_cinema_hall_seats" ("id", "ticket_id", "cinema_hall_id", "row", "place") VALUES (3, 3, 2, 4, 7);
INSERT INTO "occupied_cinema_hall_seats" ("id", "ticket_id", "cinema_hall_id", "row", "place") VALUES (4, 4, 1, 7, 1);
INSERT INTO "occupied_cinema_hall_seats" ("id", "ticket_id", "cinema_hall_id", "row", "place") VALUES (5, 5, 1, 8, 5);
INSERT INTO "occupied_cinema_hall_seats" ("id", "ticket_id", "cinema_hall_id", "row", "place") VALUES (6, 6, 1, 4, 3);
INSERT INTO "occupied_cinema_hall_seats" ("id", "ticket_id", "cinema_hall_id", "row", "place") VALUES (7, 7, 2, 5, 2);
INSERT INTO "occupied_cinema_hall_seats" ("id", "ticket_id", "cinema_hall_id", "row", "place") VALUES (8, 8, 1, 4, 10);
INSERT INTO "occupied_cinema_hall_seats" ("id", "ticket_id", "cinema_hall_id", "row", "place") VALUES (9, 9, 3, 3, 5);
INSERT INTO "occupied_cinema_hall_seats" ("id", "ticket_id", "cinema_hall_id", "row", "place") VALUES (10, 10, 3, 1, 2);

INSERT INTO "sales_history" ("id", "move_id", "session_price", "ticket_id") VALUES (1, 1, 250, 1);
INSERT INTO "sales_history" ("id", "move_id", "session_price", "ticket_id") VALUES (2, 1, 300, 2);
INSERT INTO "sales_history" ("id", "move_id", "session_price", "ticket_id") VALUES (3, 1, 300, 3);
INSERT INTO "sales_history" ("id", "move_id", "session_price", "ticket_id") VALUES (4, 2, 350, 4);
INSERT INTO "sales_history" ("id", "move_id", "session_price", "ticket_id") VALUES (5, 2, 350, 5);
INSERT INTO "sales_history" ("id", "move_id", "session_price", "ticket_id") VALUES (6, 2, 350, 6);
INSERT INTO "sales_history" ("id", "move_id", "session_price", "ticket_id") VALUES (7, 3, 400, 7);
INSERT INTO "sales_history" ("id", "move_id", "session_price", "ticket_id") VALUES (8, 5, 200, 8);
INSERT INTO "sales_history" ("id", "move_id", "session_price", "ticket_id") VALUES (9, 4, 350, 9);
INSERT INTO "sales_history" ("id", "move_id", "session_price", "ticket_id") VALUES (10, 6, 250, 10);