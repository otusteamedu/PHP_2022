insert into movie
values (1, 'Friends', 120, 300),
       (2, 'Taxi', 110, 270),
       (3, 'Avatar', 180, 300);

insert into movie_attribute_type (id, name)
values (1, 'string'),
       (2, 'text'),
       (3, 'integer'),
       (4, 'boolean'),
       (5, 'float'),
       (6, 'datetime');

insert into movie_attribute (id, name, attribute_type_id)
values (1, 'Official Review', 2),
       (2, 'Unknown Person Review', 2),
       (3, 'Oscar', 4),
       (4, 'MTV Award', 4),
       (5, 'Cannes Golden Palm', 4),
       (6, 'World Premiere', 6),
       (7, 'Russia Premiere', 6),
       (8, 'USA Premiere', 6),
       (9, 'Netflix Start', 6),
       (10, 'Sales Start', 6),
       (11, 'Sales End', 6),
       (12, 'Promotion Start', 6),
       (13, 'Promotion End', 6);

insert into movie_attribute_value (movie_id, movie_attribute_id, value_datetime)
values (1, 10, now() - interval '5 days'),
       (1, 11, now() + interval '20 days'),
       (1, 7, now()),
       (1, 8, now() - interval '1 day'),
       (2, 10, now() - interval '15 days'),
       (2, 11, now() + interval '3 days'),
       (2, 9, now()),
       (2, 7, now() + interval '1 day'),
       (3, 10, now() + interval '5 days'),
       (3, 11, now() + interval '20 days'),
       (3, 7, now() + interval '6 days'),
       (3, 8, now() - interval '2 day');
