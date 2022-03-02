DELETE FROM transactions WHERE id<>-1;
DELETE FROM orders WHERE id<>-1;
DELETE FROM sessions WHERE id<>-1;
DELETE FROM prices WHERE id<>-1;
DELETE FROM hall_places WHERE id<>-1;
DELETE FROM halls WHERE id<>-1;
DELETE FROM films WHERE id<>-1;

ALTER SEQUENCE films_id_seq RESTART;
ALTER SEQUENCE halls_id_seq RESTART;
ALTER SEQUENCE prices_id_seq RESTART;
ALTER SEQUENCE sessions_id_seq RESTART;
ALTER SEQUENCE hall_places_id_seq RESTART;

INSERT INTO halls (name) VALUES ('Red hall');
INSERT INTO halls (name) VALUES ('Green hall');
INSERT INTO halls (name) VALUES ('Black hall');

INSERT INTO hall_places (number, hull_id, type) VALUES ('A1', 1, 'VIP');
INSERT INTO hall_places (number, hull_id, type) VALUES ('B2', 1, 'COMFORT');
INSERT INTO hall_places (number, hull_id, type) VALUES ('B3', 1, 'COMFORT');
INSERT INTO hall_places (number, hull_id, type) VALUES ('C4', 1, 'BUSINESS');
INSERT INTO hall_places (number, hull_id, type) VALUES ('C5', 1, 'BUSINESS');

INSERT INTO hall_places (number, hull_id, type) VALUES ('A1', 2, 'VIP');
INSERT INTO hall_places (number, hull_id, type) VALUES ('B2', 2, 'COMFORT');
INSERT INTO hall_places (number, hull_id, type) VALUES ('B3', 2, 'COMFORT');
INSERT INTO hall_places (number, hull_id, type) VALUES ('C4', 2, 'BUSINESS');
INSERT INTO hall_places (number, hull_id, type) VALUES ('C5', 2, 'BUSINESS');

INSERT INTO hall_places (number, hull_id, type) VALUES ('A1', 3, 'VIP');
INSERT INTO hall_places (number, hull_id, type) VALUES ('B2', 3, 'COMFORT');
INSERT INTO hall_places (number, hull_id, type) VALUES ('B3', 3, 'COMFORT');
INSERT INTO hall_places (number, hull_id, type) VALUES ('C4', 3, 'BUSINESS');
INSERT INTO hall_places (number, hull_id, type) VALUES ('C5', 3, 'BUSINESS');

INSERT INTO films (name) VALUES ('Red film');
INSERT INTO films (name) VALUES ('Green film');
INSERT INTO films (name) VALUES ('Black film');

INSERT INTO prices (film, session,vip_place,business_place,comfort_place ) VALUES (100, 120, 130, 140, 150);
INSERT INTO prices (film, session,vip_place,business_place,comfort_place ) VALUES (110, 125, 135, 170, 250);
INSERT INTO prices (film, session,vip_place,business_place,comfort_place ) VALUES (177, 122, 133, 144 ,232);

INSERT INTO sessions (hall_id, film_id, date_start, date_end, price_id)
VALUES (1, 1, now() - interval '1 hours', now() - interval '2 hours', 1);
INSERT INTO sessions (hall_id, film_id, date_start, date_end, price_id)
VALUES (1, 1, now() - interval '2 hours', now() - interval '3 hours', 2);
INSERT INTO sessions (hall_id, film_id, date_start, date_end, price_id)
VALUES (1, 1, now() - interval '4 hours', now() - interval '5 hours', 3);


INSERT INTO sessions (hall_id, film_id, date_start, date_end, price_id)
VALUES (2, 2, now() + interval '2 day', now() + interval '2 day', 3);
INSERT INTO sessions (hall_id, film_id, date_start, date_end, price_id)
VALUES (2, 2, now() + interval '2 day', now() + interval '2 day', 3);
INSERT INTO sessions (hall_id, film_id, date_start, date_end, price_id)
VALUES (2, 2, now() + interval '2 day', now() + interval '2 day', 3);


INSERT INTO sessions (hall_id, film_id, date_start, date_end, price_id)
VALUES (3, 3, now() - interval '1 hours', now() - interval '2 hours', 2);
INSERT INTO sessions (hall_id, film_id, date_start, date_end, price_id)
VALUES (3, 3, now() - interval '2 hours', now() - interval '3 hours', 1);
INSERT INTO sessions (hall_id, film_id, date_start, date_end, price_id)
VALUES (3, 3, now() - interval '4 hours', now() - interval '5 hours', 2);


INSERT INTO orders (session_id, place_id, status,amount) VALUES (8,11,'PAID',350);
INSERT INTO orders (session_id, place_id, status,amount) VALUES (8,12,'PAID',370);
INSERT INTO orders (session_id, place_id, status,amount) VALUES (8,14,'PAID',360);
INSERT INTO orders (session_id, place_id, status,amount) VALUES (8,15,'PAID',360);
INSERT INTO orders (session_id, place_id, status,amount) VALUES (6,9,'BOOKED',443);
INSERT INTO orders (session_id, place_id, status,amount) VALUES (6,8,'PAID',531);
INSERT INTO orders (session_id, place_id, status,amount) VALUES (6,7,'PAID',531);
INSERT INTO orders (session_id, place_id, status,amount) VALUES (1,2,'PAID',370);
INSERT INTO orders (session_id, place_id, status,amount) VALUES (1,1,'PAID',350);
INSERT INTO orders (session_id, place_id, status,amount) VALUES (1,4,'BOOKED',360);
