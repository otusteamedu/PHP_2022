insert into hall (seat_row, seats_in_row, category)
values (5, 5, 'VIP'),
       (10, 10, 'Simple'),
       (15, 15, 'Simple');

insert into movie (name, duration)
values ('Avengers', '02:23'),
       ('Spider-Man', '02:28'),
       ('Iron Man', '02:06');

insert into time (weekday, daytime)
values ('Workday', 'Afternoon'),
       ('Workday', 'Evening'),
       ('Weekend', 'Afternoon'),
       ('Weekend', 'Evening');

insert into ticket_category (price, hall_id, time_id)
values (200, 1, 1), (300, 2, 2), (300, 3, 3),
       (400, 3, 4), (100, 1, 1), (400, 2, 4),
       (300, 3, 3), (400, 3, 4), (100, 3, 1);

insert into session (movie_id, date,ticket_category_id)
values (1, '01.01.2022', 1), (2, '01.01.2022', 2), (3, '01.01.2022', 3),
       (1, '01.01.2022', 4), (2, '01.01.2022', 5), (3, '01.01.2022', 6),
       (1, '01.01.2022', 7), (2, '01.01.2022', 8), (3, '01.01.2022', 9);

insert into ticket (seat, session_id)
values (1, 1), (2, 1), (3, 1),
       (1, 2), (2, 2), (3, 2), (4, 2), (5, 2),
       (1, 3), (2, 3), (3, 3), (4, 3), (5, 3), (6, 3), (7, 3),
       (1, 4), (2, 4), (3, 4), (4, 4), (5, 4), (6, 4), (7, 4), (8, 4), (9, 4),
       (1, 5), (2, 5), (3, 5), (4, 5),
       (1, 6), (2, 6), (3, 6), (4, 6), (5, 6), (6, 6), (7, 6), (8, 6), (9, 6), (10, 6),
       (1, 7), (2, 7), (3, 7), (4, 7), (5, 7), (6, 7), (7, 7), (8, 7),
       (1, 8), (2, 8), (3, 8), (4, 8), (5, 8), (6, 8), (7, 8), (8, 8), (9, 8), (10, 8),
       (1, 9), (2, 9), (3, 9);
