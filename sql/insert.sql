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

INSERT INTO hall_session (session_id, hall_id) VALUES (1, 1);
INSERT INTO hall_session (session_id, hall_id) VALUES (6, 2);
INSERT INTO hall_session (session_id, hall_id) VALUES (7, 3);
INSERT INTO hall_session (session_id, hall_id) VALUES (2, 3);
INSERT INTO hall_session (session_id, hall_id) VALUES (3, 2);
INSERT INTO hall_session (session_id, hall_id) VALUES (8, 1);
INSERT INTO hall_session (session_id, hall_id) VALUES (4, 2);
INSERT INTO hall_session (session_id, hall_id) VALUES (5, 2);

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

INSERT INTO ticket (id, session_id, customer_id, price) VALUES (1, 1, 7, 250);
INSERT INTO ticket (id, session_id, customer_id, price) VALUES (2, 1, 6, 250);
INSERT INTO ticket (id, session_id, customer_id, price) VALUES (3, 1, 5, 250);
INSERT INTO ticket (id, session_id, customer_id, price) VALUES (6, 2, 3, 200);
INSERT INTO ticket (id, session_id, customer_id, price) VALUES (7, 3, 2, 400);
INSERT INTO ticket (id, session_id, customer_id, price) VALUES (10, 3, 10, 400);
INSERT INTO ticket (id, session_id, customer_id, price) VALUES (5, 6, 1, 200);
INSERT INTO ticket (id, session_id, customer_id, price) VALUES (4, 5, 9, 200);
INSERT INTO ticket (id, session_id, customer_id, price) VALUES (8, 7, 4, 400);
INSERT INTO ticket (id, session_id, customer_id, price) VALUES (9, 6, 8, 400);
