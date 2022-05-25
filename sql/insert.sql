INSERT INTO film (id, name, duration) VALUES (1, 'Флешбек', '01:54:00');
INSERT INTO film (id, name, duration) VALUES (2, 'Грешное тело', '01:24:00');
INSERT INTO film (id, name, duration) VALUES (3, 'Волк с Уолл-стрит', '03:05:00');

INSERT INTO customer (id, phone) VALUES (1, '123478217');
INSERT INTO customer (id, phone) VALUES (2, '12536218');
INSERT INTO customer (id, phone) VALUES (3, '12342543');
INSERT INTO customer (id, phone) VALUES (4, '345345');
INSERT INTO customer (id, phone) VALUES (5, '12343564');
INSERT INTO customer (id, phone) VALUES (6, '345345');
INSERT INTO customer (id, phone) VALUES (7, '3455467657');
INSERT INTO customer (id, phone) VALUES (8, '35435');
INSERT INTO customer (id, phone) VALUES (9, '345345');
INSERT INTO customer (id, phone) VALUES (10, '345345345');

INSERT INTO hall (id, name) VALUES (1, 'Красный');
INSERT INTO hall (id, name) VALUES (2, 'Зеленый');
INSERT INTO hall (id, name) VALUES (3, 'Синий');

INSERT INTO session (id, film_id, time) VALUES (1, 1, '12:00:00');
INSERT INTO session (id, film_id, time) VALUES (2, 1, '17:24:00');
INSERT INTO session (id, film_id, time) VALUES (3, 1, '22:00:00');
INSERT INTO session (id, film_id, time) VALUES (4, 2, '09:15:00');
INSERT INTO session (id, film_id, time) VALUES (5, 2, '15:20:00');
INSERT INTO session (id, film_id, time) VALUES (6, 2, '12:00:00');
INSERT INTO session (id, film_id, time) VALUES (7, 3, '19:00:00');
INSERT INTO session (id, film_id, time) VALUES (8, 3, '23:15:00');
INSERT INTO session (id, film_id, time) VALUES (9, 3, '10:20:00');
INSERT INTO session (id, film_id, time) VALUES (10, 3, '13:10:00');

INSERT INTO hall_session (session_id, hall_id) VALUES (1, 1);
INSERT INTO hall_session (session_id, hall_id) VALUES (6, 2);
INSERT INTO hall_session (session_id, hall_id) VALUES (7, 3);
INSERT INTO hall_session (session_id, hall_id) VALUES (2, 3);
INSERT INTO hall_session (session_id, hall_id) VALUES (3, 2);
INSERT INTO hall_session (session_id, hall_id) VALUES (8, 1);
INSERT INTO hall_session (session_id, hall_id) VALUES (4, 2);
INSERT INTO hall_session (session_id, hall_id) VALUES (5, 2);
INSERT INTO hall_session (session_id, hall_id) VALUES (10, 3);

INSERT INTO ticket_type (id, type, price) VALUES (1, 'Утренний', 250);
INSERT INTO ticket_type (id, type, price) VALUES (2, 'Дневной', 350);
INSERT INTO ticket_type (id, type, price) VALUES (3, 'Вечерний', 500);

INSERT INTO place (id, row, place, hall_id) VALUES (1, 1, 1, 1);
INSERT INTO place (id, row, place, hall_id) VALUES (2, 2, 1, 1);
INSERT INTO place (id, row, place, hall_id) VALUES (3, 3, 1, 1);
INSERT INTO place (id, row, place, hall_id) VALUES (4, 4, 1, 1);
INSERT INTO place (id, row, place, hall_id) VALUES (5, 5, 1, 1);
INSERT INTO place (id, row, place, hall_id) VALUES (6, 1, 2, 1);
INSERT INTO place (id, row, place, hall_id) VALUES (7, 2, 2, 1);
INSERT INTO place (id, row, place, hall_id) VALUES (8, 3, 2, 1);
INSERT INTO place (id, row, place, hall_id) VALUES (9, 4, 2, 1);
INSERT INTO place (id, row, place, hall_id) VALUES (10, 5, 2, 1);
INSERT INTO place (id, row, place, hall_id) VALUES (11, 1, 3, 1);
INSERT INTO place (id, row, place, hall_id) VALUES (12, 2, 3, 1);
INSERT INTO place (id, row, place, hall_id) VALUES (13, 3, 3, 1);
INSERT INTO place (id, row, place, hall_id) VALUES (14, 4, 3, 1);
INSERT INTO place (id, row, place, hall_id) VALUES (15, 5, 3, 1);
INSERT INTO place (id, row, place, hall_id) VALUES (16, 1, 4, 1);
INSERT INTO place (id, row, place, hall_id) VALUES (17, 2, 4, 1);
INSERT INTO place (id, row, place, hall_id) VALUES (18, 3, 4, 1);
INSERT INTO place (id, row, place, hall_id) VALUES (19, 4, 4, 1);
INSERT INTO place (id, row, place, hall_id) VALUES (20, 5, 4, 1);
INSERT INTO place (id, row, place, hall_id) VALUES (21, 1, 5, 1);
INSERT INTO place (id, row, place, hall_id) VALUES (22, 2, 5, 1);
INSERT INTO place (id, row, place, hall_id) VALUES (23, 3, 5, 1);
INSERT INTO place (id, row, place, hall_id) VALUES (24, 4, 5, 1);
INSERT INTO place (id, row, place, hall_id) VALUES (25, 5, 5, 1);
INSERT INTO place (id, row, place, hall_id) VALUES (26, 1, 1, 2);
INSERT INTO place (id, row, place, hall_id) VALUES (27, 2, 1, 2);
INSERT INTO place (id, row, place, hall_id) VALUES (28, 3, 1, 2);
INSERT INTO place (id, row, place, hall_id) VALUES (29, 1, 2, 2);
INSERT INTO place (id, row, place, hall_id) VALUES (30, 2, 2, 2);
INSERT INTO place (id, row, place, hall_id) VALUES (31, 3, 2, 2);
INSERT INTO place (id, row, place, hall_id) VALUES (32, 1, 3, 2);
INSERT INTO place (id, row, place, hall_id) VALUES (33, 2, 3, 2);
INSERT INTO place (id, row, place, hall_id) VALUES (34, 3, 3, 2);
INSERT INTO place (id, row, place, hall_id) VALUES (35, 1, 1, 3);
INSERT INTO place (id, row, place, hall_id) VALUES (36, 1, 2, 3);
INSERT INTO place (id, row, place, hall_id) VALUES (37, 1, 3, 3);
INSERT INTO place (id, row, place, hall_id) VALUES (38, 1, 4, 3);
INSERT INTO place (id, row, place, hall_id) VALUES (39, 2, 1, 3);
INSERT INTO place (id, row, place, hall_id) VALUES (40, 2, 2, 3);
INSERT INTO place (id, row, place, hall_id) VALUES (41, 2, 3, 3);
INSERT INTO place (id, row, place, hall_id) VALUES (42, 2, 4, 3);
INSERT INTO place (id, row, place, hall_id) VALUES (43, 3, 1, 3);
INSERT INTO place (id, row, place, hall_id) VALUES (44, 3, 2, 3);
INSERT INTO place (id, row, place, hall_id) VALUES (45, 3, 3, 3);
INSERT INTO place (id, row, place, hall_id) VALUES (46, 3, 4, 3);

INSERT INTO ticket (id, session_id, customer_id, ticket_type_id, place_id) VALUES (1, 1, 1, 2, 3);
INSERT INTO ticket (id, session_id, customer_id, ticket_type_id, place_id) VALUES (2, 3, 2, 3, 32);
INSERT INTO ticket (id, session_id, customer_id, ticket_type_id, place_id) VALUES (3, 4, 3, 1, 32);
INSERT INTO ticket (id, session_id, customer_id, ticket_type_id, place_id) VALUES (4, 10, 4, 2, 43);
INSERT INTO ticket (id, session_id, customer_id, ticket_type_id, place_id) VALUES (5, 10, 5, 2, 44);
INSERT INTO ticket (id, session_id, customer_id, ticket_type_id, place_id) VALUES (6, 10, 6, 2, 45);
INSERT INTO ticket (id, session_id, customer_id, ticket_type_id, place_id) VALUES (7, 7, 7, 3, 44);
INSERT INTO ticket (id, session_id, customer_id, ticket_type_id, place_id) VALUES (8, 4, 8, 1, 25);
INSERT INTO ticket (id, session_id, customer_id, ticket_type_id, place_id) VALUES (9, 2, 9, 2, 45);
INSERT INTO ticket (id, session_id, customer_id, ticket_type_id, place_id) VALUES (10, 8, 10, 3, 5);
