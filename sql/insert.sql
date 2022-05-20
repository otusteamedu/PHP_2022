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

INSERT INTO ticket (id, type, price) VALUES (1, 'Утренний', 250);
INSERT INTO ticket (id, type, price) VALUES (2, 'Дневной', 350);
INSERT INTO ticket (id, type, price) VALUES (3, 'Вечерний', 500);

INSERT INTO customer_ticket (id, session_id, customer_id, ticket_id, place, row) VALUES (1, 1, 1, 2, 3, 5);
INSERT INTO customer_ticket (id, session_id, customer_id, ticket_id, place, row) VALUES (2, 3, 2, 3, 1, 1);
INSERT INTO customer_ticket (id, session_id, customer_id, ticket_id, place, row) VALUES (3, 4, 3, 1, 10, 12);
INSERT INTO customer_ticket (id, session_id, customer_id, ticket_id, place, row) VALUES (4, 10, 4, 2, 15, 5);
INSERT INTO customer_ticket (id, session_id, customer_id, ticket_id, place, row) VALUES (5, 10, 5, 2, 14, 5);
INSERT INTO customer_ticket (id, session_id, customer_id, ticket_id, place, row) VALUES (6, 10, 6, 2, 16, 5);
INSERT INTO customer_ticket (id, session_id, customer_id, ticket_id, place, row) VALUES (7, 7, 7, 3, 2, 3);
INSERT INTO customer_ticket (id, session_id, customer_id, ticket_id, place, row) VALUES (8, 4, 8, 1, 20, 10);
INSERT INTO customer_ticket (id, session_id, customer_id, ticket_id, place, row) VALUES (9, 2, 9, 2, 1, 1);
INSERT INTO customer_ticket (id, session_id, customer_id, ticket_id, place, row) VALUES (10, 8, 10, 3, 10, 3);
