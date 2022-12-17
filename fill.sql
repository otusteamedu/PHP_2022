INSERT INTO hall (number) VALUES (1);
INSERT INTO hall (number) VALUES (2);
INSERT INTO hall (number) VALUES (3);

INSERT INTO movie (title) VALUES ('Ёлки');
INSERT INTO movie (title) VALUES ('Ёлки 2');
INSERT INTO movie (title) VALUES ('Ёлки 3');
INSERT INTO movie (title) VALUES ('Ёлки 4');
INSERT INTO movie (title) VALUES ('Ёлки 5');
INSERT INTO movie (title) VALUES ('Ёлки 6');

INSERT INTO session (hall_id, movie_id, price, starts_at) VALUES (1, 1, 100, '2022-12-31');
INSERT INTO session (hall_id, movie_id, price, starts_at) VALUES (2, 2, 200, '2022-12-31');
INSERT INTO session (hall_id, movie_id, price, starts_at) VALUES (3, 3, 300, '2022-12-31');
INSERT INTO session (hall_id, movie_id, price, starts_at) VALUES (1, 4, 100, '2022-12-31');
INSERT INTO session (hall_id, movie_id, price, starts_at) VALUES (2, 5, 400, '2022-12-31');
INSERT INTO session (hall_id, movie_id, price, starts_at) VALUES (3, 6, 200, '2022-12-31');

INSERT INTO client (name, email) VALUES ('Jonh', 'jonh@email.com');
INSERT INTO client (name, email) VALUES ('Dan', 'dan@email.com');
INSERT INTO client (name, email) VALUES ('Anna', 'anna@email.com');

INSERT INTO seat (hall_id, row, number) VALUES (1, 1, 1);
INSERT INTO seat (hall_id, row, number) VALUES (1, 1, 2);
INSERT INTO seat (hall_id, row, number) VALUES (1, 1, 3);
INSERT INTO seat (hall_id, row, number) VALUES (1, 2, 1);
INSERT INTO seat (hall_id, row, number) VALUES (1, 2, 2);
INSERT INTO seat (hall_id, row, number) VALUES (2, 1, 1);
INSERT INTO seat (hall_id, row, number) VALUES (1, 1, 2);
INSERT INTO seat (hall_id, row, number) VALUES (3, 1, 1);
INSERT INTO seat (hall_id, row, number) VALUES (3, 1, 1);
INSERT INTO seat (hall_id, row, number) VALUES (3, 1, 3);

INSERT INTO ticket (client_id, seat_id, price, session_id) VALUES (1, 1, 150, 1);
INSERT INTO ticket (client_id, seat_id, price, session_id) VALUES (2, 1, 250, 1);
INSERT INTO ticket (client_id, seat_id, price, session_id) VALUES (3, 1, 350, 1);
INSERT INTO ticket (client_id, seat_id, price, session_id) VALUES (1, 1, 450, 2);
INSERT INTO ticket (client_id, seat_id, price, session_id) VALUES (2, 1, 230, 2);
INSERT INTO ticket (client_id, seat_id, price, session_id) VALUES (3, 1, 200, 2);
INSERT INTO ticket (client_id, seat_id, price, session_id) VALUES (1, 1, 100, 3);
INSERT INTO ticket (client_id, seat_id, price, session_id) VALUES (2, 1, 300, 4);
INSERT INTO ticket (client_id, seat_id, price, session_id) VALUES (3, 1, 300, 5);
INSERT INTO ticket (client_id, seat_id, price, session_id) VALUES (1, 1, 550, 6);
INSERT INTO ticket (client_id, seat_id, price, session_id) VALUES (2, 1, 150, 6);



